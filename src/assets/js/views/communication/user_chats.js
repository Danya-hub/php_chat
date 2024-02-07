"use strict";

import chatListItem from "../../components/ChatListItem.js";
import ChatActions from "../../actions/Chat.js";
import Chat from "../../services/Communication/Chat.js";
import Message from "../../services/Communication/Message.js";
import MessageBlock from "../../components/Message.js";

const user_chats = document.getElementById("my-chats");
const user_messages_output = document.getElementById("user-messages-output");

const chatService = new Chat(user_chats);
const messageService = new Message();

chatService.addCase({
  async ["onNavigate/succeeded"](response) {
    ChatActions.onOpenChat(response.body);

    user_messages_output.innerHTML = "";

    messageService.getMessagesByChatId(response.body.id);
  },
});

messageService.addCase({
  ["onMessageByChatId/succeeded"](response) {
    response.body.forEach((message) => {
      const item = MessageBlock(message, +message.are_sender);

      user_messages_output.appendChild(item);
    });

    ChatActions.scrollDown();
  },
});

chatService.getChatsByUser().then((response) => {
  response.body.forEach((chat) => {
    const item = chatListItem(chat.id, chat, {
      last_message: chat.last_message,
    });

    item.addEventListener("click", () => chatService.navigateToOwnChat(chat));

    user_chats.appendChild(item);
  });
});
