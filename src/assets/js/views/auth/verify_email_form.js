"use strict";

import VerifyEmail from "../../services/Auth/VerifyEmail.js";

const form = document.querySelector(".form");
const send_code_btn = document.querySelector(".send_code_btn");
const error_message = document.querySelector(".error_message");

const service = new VerifyEmail(error_message);

service.addCase({
  ["checkCode/succeeded"](response) {
    this.error_message.classList.remove("visible");
    this.error_message.textContent = "";
    document.body.classList.remove("loading");
    location.href = response.body.location;
  },
  ["checkCode/failure"](response) {
    this.error_message.classList.add("visible");
    this.error_message.textContent = response.body.message;
    document.body.classList.remove("loading");
  },
  ["sendCode/succeeded"](response) {
    this.error_message.classList.add("visible");
    this.error_message.textContent = response.body.message;
    document.body.classList.remove("loading");
  },
  ["sendCode/failure"](response) {
    this.error_message.classList.add("visible");
    this.error_message.textContent = response.body.message;
    document.body.classList.remove("loading");
  },
});

function handleSubmitForm(e) {
  e.preventDefault();

  const form_data = new FormData(e.target);

  document.body.classList.add("loading");

  service.checkCode(form_data);
}

function handleSendCode() {
  document.body.classList.add("loading");

  service.sendCode();
}

send_code_btn.addEventListener("click", handleSendCode);
form.addEventListener("submit", handleSubmitForm);
