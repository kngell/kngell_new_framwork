//Admin js
import "plugins/flexadmin/js/app";
import { BASE_URL } from "corejs/config";

document.addEventListener("DOMContentLoaded", function () {
  //logout
  var logout = $("span:contains('Logout')");
  $(logout).on("click", function () {
    if (typeof FB !== "undefined") {
      FB.logout().then((response) => {
        // logged out
      });
    }
    $.ajax({
      url: BASE_URL + "auth/logout",
      method: "post",
      success: function (response) {
        console.log(response);
        if (response.result == "success") {
          logout.closest("div").load(location.href + " .connect");
          if (response.msg == "redirect") {
            window.location.href = BASE_URL;
          }
        }
      },
    });
  });
});
