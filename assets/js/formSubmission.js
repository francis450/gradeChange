$(document).ready(function () {
  $("#form").submit(function (event) {
    event.preventDefault();
    var form = $(this);
    var url = form.attr("action");
    var type = form.attr("method");
    var data = form.serialize();
    $.ajax({
      url: url,
      type: type,
      data: data,
      success: function (response) {
        $("#alert").show();
        $("#response").html(response);
      },
    });
  });
});
