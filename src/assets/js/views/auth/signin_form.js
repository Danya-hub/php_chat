"use strict";

import Signin from "../../services/Auth/Signin.js";

const form = document.querySelector(".form");
const error_message = document.querySelector(".error_message");

const service = new Signin(error_message);

service.addCase({
  ["login/succeeded"](response) {
    this.message_elem.classList.remove("visible");
    this.message_elem.textContent = "";
    window.location.href = response.body.location;
  },
  ["login/failed"](error) {
    this.message_elem.classList.add("visible");
    this.message_elem.textContent = error.body.message;
  },
});

function handleSubmitForm(e) {
  e.preventDefault();

  const form_data = new FormData(e.target);

  service.login(form_data);
}

form.addEventListener("submit", handleSubmitForm);
