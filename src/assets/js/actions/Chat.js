const current_chat = document.getElementById("current-chat");
const companion_name = document.getElementById("chat-companion-name");

class ChatActions {
  static scrollDown() {
    const user_messages_container = document.getElementById("user-messages-container");

    user_messages_container.scrollTo(0, user_messages_container.scrollHeight);
  }

  static onOpenChat(response) {
    current_chat.classList.add("selected-chat");
    companion_name.textContent = `${response.first_name} ${response.last_name}`;
  }
}

export default ChatActions;
