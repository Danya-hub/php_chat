"use strict";

import Signup from "../../services/Auth/Signup.js";

const form = document.querySelector(".form");
const image_input = document.querySelector(".image_input");
const avatar = document.querySelector(".avatar img");
const error_message = document.querySelector(".error_message");

const service = new Signup(error_message);

service.addCase({
  ["onCreatedAccount/succeeded"](response) {
    this.error_message.classList.remove("visible");
    this.error_message.textContent = "";
    document.body.classList.remove("loading");
    location.href = response.body.location;
  },
  ["onCreatedAccount/failed"](error) {
    this.error_message.classList.add("visible");
    document.body.classList.remove("loading");
    this.error_message.textContent = error.body.message;
  },
});

function handleDisplaySelectedImage(e) {
  const created_temp_image_url = URL.createObjectURL(e.target.files[0]);

  avatar.src = created_temp_image_url;
}

async function handleSubmitForm(e) {
  e.preventDefault();

  const form_data = new FormData(e.target);

  document.body.classList.add("loading");
  service.createAccount(form_data);
}

form.addEventListener("submit", handleSubmitForm);
image_input.addEventListener("change", handleDisplaySelectedImage);
