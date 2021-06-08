import { Modal } from "bootstrap";
// Bootstrap modal

const bs_login_box = document.getElementById("login-box");
const bs_register_box = document.getElementById("register-box");
const bs_forgot_box = document.getElementById("forgot-box");

export const login_modal = new Modal(bs_login_box, {
  keyboard: false,
});
export const register_modal = new Modal(bs_register_box, {
  keyboard: false,
});
export const forgot_modal = new Modal(bs_forgot_box, {
  keyboard: false,
});
