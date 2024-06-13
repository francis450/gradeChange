$(document).ready(function () {
  $("#department_id").change(function () {
    var department_id = $(this).val();
    if (department_id != "") {
      var pathArray = window.location.pathname.split("/");
      let url = pathArray[0] + "/" + pathArray[1] + "/courses/department";

      $.ajax({
        url: url,
        method: "POST",
        data: { department_id: department_id },
        dataType: "json",
        success: function (data) {
          console.log(data);
          var course_select = $("#course_id");
          course_select.empty();
          course_select.append('<option value="">Select Course</option>');
          $.each(data.courses, function (key, value) {
            course_select.append(
              '<option value="' +
              value.id +
              '">' +
              value.code +
              " - " +
              value.name +
              "</option>"
            );
          });
          var student_select = $("#student_id");
          student_select.empty();
          student_select.append('<option value="">Select Student</option>');
          $.each(data.students, function (key, value) {
            student_select.append(
              '<option value="' +
              value.id +
              '">' +
              value.student_number +
              " - " +
              value.name +
              "</option>"
            );
          });
        },
      });
    }
  });

  $("#course_id").change(function () {
    var course_id = $(this).val();
    var pathArray = window.location.pathname.split("/");
    let url = pathArray[0] + "/" + pathArray[1] + "/courses/students";
    if (course_id != "") {
      $.ajax({
        url: url,
        method: "POST",
        data: { course_id: course_id },
        dataType: "json",
        success: function (data) {
          var student_select = $("#student_id");
          student_select.empty();
          student_select.append('<option value="">Select Student</option>');
          $.each(data, function (key, value) {
            student_select.append(
              '<option value="' +
              value.id +
              '">' +
              value.student_number +
              " - " +
              value.name +
              "</option>"
            );
          });
        },
      });
    }
  });

  $("#points").on("input", function () {
    var points = $(this).val();
    if (points < 0 || points > 100 || !$.isNumeric(points)) {
      return;
    }

    if (points >= 80) {
      $("#grade").val("A");
    } else if (points >= 70) {
      $("#grade").val("B");
    } else if (points >= 60) {
      $("#grade").val("C");
    } else if (points >= 50) {
      $("#grade").val("D");
    } else if (points >= 40) {
      $("#grade").val("E");
    } else if (points < 40) {
      $("#grade").val("F");
    } else {
      alert("Invalid points");
    }
  });

  $(".ernrollment_student_id").change(function () {
    var student_id = $(this).val();
    var pathArray = window.location.pathname.split("/");
    let url = pathArray[0] + "/" + pathArray[1] + "/enrollments/student";
    if (student_id != "") {
      $.ajax({
        url: url,
        method: "POST",
        data: { student_id: student_id },
        dataType: "json",
        success: function (data) {
          // console.log(data);
          var enrollmentCourseSelect = $(".course_grade_id");
          enrollmentCourseSelect.empty();
          enrollmentCourseSelect.append(
            '<option value="">Select Course</option>'
          );
          $.each(data, function (key, value) {
            enrollmentCourseSelect.append(
              '<option value="' + value.id + '">' + value.name + "</option>"
            );
          });
        },
      });
    }
  });

  $(".course_grade_id").change(function () {
    var course_id = $(this).val();
    var student_id = $("#student_id").val();

    var pathArray = window.location.pathname.split("/");
    let url = pathArray[0] + "/" + pathArray[1] + "/grades/course";
    if (course_id != "" && student_id != "") {
      $.ajax({
        url: url,
        method: "POST",
        data: { course_id: course_id, student_id: student_id },
        dataType: "json",
        success: function (data) {
          var data = data[0];
          var original_points = $("#original_points");
          original_points.empty();
          original_points.val(data.points); // Corrected line

          var original_grade = $("#original_grade");
          original_grade.empty();
          original_grade.val(data.grade); // Corrected line
        },
      });
    } else {
      alert("Choose Course and Student to load grades");
    }
  });

  $('#approve').click(function (e) {
    e.preventDefault();
    let feedback = $('#feedback').val();

    if (feedback == '') {
      alert('Feedback is required');
      return;
    }

    // get the id from the url
    let pathArray = window.location.pathname.split('/');
    let url = pathArray[0] + '/' + pathArray[1] + '/grade-change-requests/approve/' + pathArray[3];
    $.post(url, { feedback: feedback }, function (data) {
      if (data != ''){
        alert(data);
      }else{
        window.location.href = pathArray[0] + '/' + pathArray[1] + '/grade-change-requests';
      }
    });
  });

  $('#deny').click(function (e) {
    e.preventDefault();
    let feedback = $('#feedback').val();
    if (feedback == '') {
      alert('Feedback is required');
      return;
    }
    let pathArray = window.location.pathname.split('/');
    let url = pathArray[0] + '/' + pathArray[1] + '/grade-change-requests/deny/' + pathArray[3];
    $.post(url, { feedback: feedback }, function (data) {
      alert(data);
    });
  });
});
