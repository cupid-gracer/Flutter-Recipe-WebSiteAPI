$(document).ready(function () {
    $("#ChangePasswordForm").validate({
      ignore: [],
      rules: {
          current_password: {
              required: true
          },
          new_password: {
              required: true,
              minlength:8
          },
          confirm_password: {
              required: true,
              equalTo:"#new_password"
          }
      },
  });

  $("#ChangePasswordForm").submit(function () {
      if ($("#ChangePasswordForm").valid()) {
          $('#loader').show();
      }
  });
});