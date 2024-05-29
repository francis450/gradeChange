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
});
