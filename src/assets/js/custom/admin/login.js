import { get_visitors_data, send_visitors_data } from "corejs/visitors";
document.addEventListener("DOMContentLoaded", () => {
  //=======================================================================
  //Import login system
  //=======================================================================
  (async () => {
    const login = await import(
      /* webpackChunkName: "login" */ "corejs/login_register.class"
    );
  })();
  //=======================================================================
  //Get visitors IP Adresss
  //=======================================================================
  let visitor = get_visitors_data().then((visitors_data) => {
    var data = {
      url: "visitors/track",
      table: "visitors",
      ip: visitors_data.ip,
    };
    send_visitors_data(data, manageR);
    function manageR(response) {}
  });
});
