import { APP_URL } from "../constants/paths.js";

function chatListItem(
	id,
  chat,
  default_values = {
    last_message: "",
  }
) {
  const button = document.createElement("button");
  button.className = "chat-item py-2 px-4 block hover:bg-gray-200 me-1 w-full";
  button.type = "button";
  button.id = id;

  button.innerHTML = `
			        	<div class="flex">
			        		<img src="${APP_URL}/dist/${chat.avatar}" alt="avatar" class="bg-red-500 max-w-16 w-full h-16 rounded-full">
			        		<div class="ms-4 flex flex-col justify-between py-1 text-start">
			        			<div class="flex justify-between text-gray-500">
			        				<h4 class="font-semibold max-lines-1">${chat.first_name} ${chat.last_name}</h4>
			        				<span class="ms-2"></span>
			        			</div>
			        			<p class="last-message max-lines-1 text-gray-500">${default_values.last_message}</p>
			        		</div>
			        	</div>
						`;

  return button;
}

export default chatListItem;
