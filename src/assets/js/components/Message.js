function MessageBlock(message, are_sender) {
	const block = document.createElement("div");
	block.id = message.id;
	block.className = `flex ${are_sender ? "justify-end" : "justify-start"} my-3`;

	block.setAttribute("created_at", message.created_at);

	const created_at = new Date(message.created_at); 
	const formatted_create_at = Intl.DateTimeFormat(window.navigator.language, {
		minute: "numeric",
		hour: "numeric",		
	}).format(created_at);

	block.innerHTML = `
		<div class="flex bg-white p-2 w-fit items-end flex-wrap max-w-[45%] rounded-md shadow">
			<p class="break-words overflow-hidden">${message.message}</p>
			<span class="ps-2 text-xs text-gray-500 ml-auto">${formatted_create_at}</span>
		</div>
	`;

	return block;
}

export default MessageBlock;