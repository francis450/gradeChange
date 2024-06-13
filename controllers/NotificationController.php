<?php

class NotificationController extends BaseController
{
    public function __construct()
    {
        $this->checkAuthentication();
    }

    public function index()
    {
        $notifications = new Notification();

        if ($_SESSION['role'] == 'admin') {
            $notifications = $notifications->all();
        } else {
            $notifications = $notifications->whereAnd(['user_id' => $_SESSION['user_id'], 'is_read' => 0]);
        }

        $this->render('notifications/index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notificationModel = new Notification();
        $notification = $notificationModel->where('id', $id);

        if ($notification) {
            $notificationModel->update('id', $id, ['is_read' => 1]);
            $notifications = $notificationModel->whereAnd(['user_id' => $_SESSION['user_id'], 'is_read' => 0]);
            $this->render('notifications/index', compact('notifications'));
        } else {
            $this->render('notifications/index', ['error' => 'Notification not found']);
        }
    }

    public function show($id)
    {
        $notificationModel = new Notification();
        $notification = $notificationModel->where('id', $id)[0];

        if ($notification) {
            if ($notificationModel->update('id', $id, ['is_read' => 1])) {
                $this->render('notifications/show', compact('notification'));
            }
        } else {
            $this->render('notifications/index', ['error' => 'Notification not found']);
        }
    }
}
