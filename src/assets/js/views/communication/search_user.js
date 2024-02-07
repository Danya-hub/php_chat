import Chat from "../../services/Communication/Chat.js";
import chatListItem from "../../components/ChatListItem.js";
import ChatActions from "../../actions/Chat.js";

const input = document.getElementById("search");
const cancel_search = document.getElementById("cancel-search");
const side_panel = document.getElementById("side-panel");

const user_chats = document.getElementById("my-chats");
const new_chats_output = document.getElementById("new-chats");

const service = new Chat(user_chats);

service.addCase({
  ["onFound/succeeded"](response) {
    try {
      new_chats_output.innerHTML = "";

      response.body.forEach((user) => {
        const item = chatListItem(user.id, user);

        item.addEventListener("click", () => this.addToRecomended(user));

        new_chats_output.appendChild(item);
      });
    } catch (error) {
      new_chats_output.innerHTML = `<p>${error.message}</p>`;
    }

    side_panel.classList.add("search-state");
  },
  ["onFound/failure"](error) {
    console.error(error);
  },
  ["onNavigate/succeeded"]: ChatActions.onOpenChat,
  ["onNavigate/failure"](error) {
    console.error(error);
  },
  ["onRecommend/succeeded"](response) {
    response.body.forEach((user) => {
      const item = chatListItem(user.chat_id, user, {
        last_message: "Напишите новое сообщение",
      });

      item.addEventListener("click", this.navigateToNewChat.bind(this, user));

      this.chat_list.prepend(item);
    });

    handleStopSearchingUsers();
  },
  ["onRecommend/failure"](error) {
    console.error(error);
  },
});

function handleChangeValue(e) {
  service.findUser(e);
}

function handleStopSearchingUsers() {
  side_panel.classList.remove("search-state");
  input.value = "";
}

cancel_search.addEventListener("click", handleStopSearchingUsers);
input.addEventListener("change", handleChangeValue);
