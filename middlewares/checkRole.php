<?php
function checkRole($requiredRole) {
    return function() use ($requiredRole) {
        session_start();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== $requiredRole) {
            http_response_code(403);
            echo "Access denied";
            exit();
        }
    };
}
