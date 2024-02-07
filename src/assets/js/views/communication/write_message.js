"use strict";

import ChatActions from "../../actions/Chat.js";
import MessageBlock from "../../components/Message.js";
import Chat from "../../services/Communication/Chat.js";

const form = document.querySelector(".message-form");
const user_chats = document.getElementById("my-chats");
const user_messages_output = document.getElementById("user-messages-output");

const service = new Chat(user_chats);

service.addCase({
  ["onAddMessage/succeeded"](response) {
    const message = response.body;
    const chat_item = document.getElementById(message.chat_id);
    const last_chat_message = chat_item.querySelector(".last-message")

    const item = MessageBlock(message, true);
    user_messages_output.appendChild(item);
    last_chat_message.textContent = message.message;

    ChatActions.scrollDown();
    form.reset();
  },
  ["onAddMessage/failure"](error) {
    console.error(error);
  },
});

function handleSubmitForm(e) {
  e.preventDefault();

  const chat_id = sessionStorage.getItem("chat_id");
  const companion_id = sessionStorage.getItem("to_user");

  const form_data = new FormData(e.target);
  form_data.append("to_user", companion_id);
  form_data.append("chat_id", chat_id || "");

  service.writeMessage(form_data);
}

form.addEventListener("submit", handleSubmitForm);
