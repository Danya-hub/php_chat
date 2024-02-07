import Builder from "../../helpers/actionBuilder.js";
import XHR from "../../helpers/xhr.js";

class Chat extends Builder {
  constructor(chat_list) {
    super();

    this.chat_list = chat_list;
  }

  async addToRecomended(user) {
    const data = `user_id=${user.id}`;

    try {
      const request = new XHR("application/x-www-form-urlencoded");
      request.open("POST", "add_to_recomended");

      const response = await request.send(data);

      this.cases["onRecommend/succeeded"]?.call(this, response);
    } catch (error) {
      this.cases["onRecommend/failure"]?.call(this, error);
    }
  }

  async findUser(e) {
    try {
      const username = e.target.value;

      const request = new XHR();
      request.open("GET", `find_users_by_name/data/${username}`);

      const response = await request.send();
      this.cases["onFound/succeeded"]?.call(this, response);
    } catch (error) {
      this.cases["onFound/failure"]?.call(this, error);
    }
  }

  async writeMessage(data) {
    try {
      const request = new XHR();

      request.open("POST", "write_message/data");
      const response = await request.send(data);

      this.cases["onAddMessage/succeeded"]?.call(this, response);
    } catch (error) {
      this.cases["onAddMessage/failure"]?.call(this, error);
    }
  }

  async getChatsByUser() {
    const request = new XHR();
    request.open("GET", "get_chats_by_user/data");

    const response = await request.send();

    return response;
  }

  async navigateToNewChat(chat) {
    this.cases["onNavigate/succeeded"]?.call(this, chat);

    sessionStorage.setItem("to_user", chat.id);
    sessionStorage.setItem("chat_id", chat.chat_id);
  }

  async navigateToOwnChat(chat) {
    try {
      const request = new XHR();
      request.open("GET", `get_companion_by_chat/data/${chat.id}`);

      const response = await request.send();
      this.cases["onNavigate/succeeded"]?.call(this, response);

      sessionStorage.setItem("chat_id", chat.id);
      sessionStorage.setItem("to_user", chat.companion_id);
    } catch (error) {
      this.cases["onNavigate/succeeded"]?.call(this, error);
    }
  }
}

export default Chat;
