<?php
	var_dump($refresh);
?>
<section id="chats" class="relative grid md:grid-cols-4 sm:grid-cols-3 grid-cols-1 h-screen overflow-hidden">
	<div id="settings" class="hidden absolute grid md:grid-cols-4 sm:grid-cols-3 grid-cols-1 bg-black bg-opacity-50 w-full h-full cursor-pointer">
		<aside class="left-0 top-0 bg-white z-[1] cursor-auto">
			
		</aside>
	</div>
	<aside id="side-panel" class="hidden sm:block border-r-2 flex flex-col">
		<header class="flex items-center h-12 px-4">
			<button id="setting-menu" class="p-2">
				<i class="fa-solid fa-bars text-2xl"></i>
			</button>
			<form action method="GET" id="search-user" class="mb-0 ms-1 w-full">
				<input type="text" id="search" name="user" placeholder="Поиск" class="block px-4 py-1 rounded-full border-gray-500 border w-full">
				<button type="button" id="cancel-search">X</button>
			</form>
		</header>
		<div id="chat-list" class="overflow-y-scroll py-2 relative w-full h-full">
			<div id="new-chats" class="absolute left-0 top-0 w-full bg-white"></div>
			<div id="my-chats" class="w-full"></div>
		</div>
	</aside>
	<div id="current-chat" class="sm:col-start-2 col-start-1 col-end-5 bg-lime-100 h-screen flex flex-col">
		<header class="top-chat-panel bg-white px-6 justify-between items-center">
			<b id="chat-companion-name">

			</b>
			<button type="button" class="w-10 h-10">
				<i class="fa-solid fa-ellipsis-vertical"></i>
			</button>
		</header>
		<div id="user-messages-container" class="flex-1 overflow-y-scroll mx-2 my-3">
			<div class="w-2/3 mx-auto flex flex-col">
				<div id="user-messages-output">
					<p class="empty">Нажмите, кому хотели бы написать</p>
				</div>
			</div>
		</div>
		<form action method="POST" class="message-form mb-3 w-3/4 mx-auto">
			<div class="bg-white shadow rounded flex w-full items-center">
				<input type="text" name="message" class="w-full h-full bg-white px-3">
				<label class="cursor-pointer px-4 py-2">
					<i class="fa-solid fa-paperclip text-xl text-gray-500"></i>
					<input type="file" class="hidden">
				</label>
			</div>
			<button type="submit" class="h-full max-w-10 w-full text-2xl bg-white text-gray-500 mx-3 flex justify-center items-center rounded-full shadow hover:bg-gray-100">
				<i class="fa-solid fa-location-arrow"></i>
			</button>
		</form>
	</div>
</section>
<script type="module" src="<?= APP_URL . "/src/assets/js/views/communication/user_chats.js" ?>"></script>
<script type="module" src="<?= APP_URL . "/src/assets/js/views/communication/user_settings.js" ?>"></script>
<script type="module" src="<?= APP_URL . "/src/assets/js/views/communication/search_user.js" ?>"></script>
<script type="module" src="<?= APP_URL . "/src/assets/js/views/communication/write_message.js" ?>"></script>