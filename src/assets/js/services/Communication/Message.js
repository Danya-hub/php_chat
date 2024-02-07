"use strict";

import Builder from "../../helpers/actionBuilder.js";
import XHR from "../../helpers/xhr.js";

class Message extends Builder {
  constructor() {
    super();
  }

  async getMessagesByChatId(chat_id) {
    try {
      const request = new XHR();

      request.open("GET", `get_messages_by_chat_id/data/${chat_id}`);

      const response = await request.send();

      this.cases["onMessageByChatId/succeeded"]?.call(this, response);
    } catch (error) {
      console.error(error);
    }
  }
}

export default Message;
