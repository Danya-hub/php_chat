<?php
$title = "Войти в учет. запись";
?>
<section id="signin" class="flex justify-center px-3 py-12">
	<div class="loader fixed left-0 top-0 z-10 bg-white w-full h-full justify-center items-center">
		<img src="<?= APP_URL . "/src/assets/images/loader.gif" ?>" alt="loader">
	</div>
	<div class="self-center max-w-[500px] overflow-scroll">
		<div class="text-center">
			<h1 class="text-2xl mb-3 font-bold">Войти</h1>
			<p class="mb-6 text-center">Добро пожаловать обратно</p>
		</div>
		<div class="relative my-5">
			<span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-2">или</span>
			<hr class="border-t border-gray-500" />
		</div>
		<p class="error_message sticky-position"></p>
		<form action method="post" class="form">
			<label class="field">
				<span>Почта</span>
				<input type="email" name="email">
			</label>
			<label class="field">
				<span>Пароль</span>
				<input type="password" name="password">
			</label>
			<p>
				Вы еще не зарегестрированы?
				<a class="font-semibold" href="signup">Создайте</a>
			</p>
			<button type="submit" class="px-4 py-2 mt-5 rounded border bg-blue-600 text-white">Войти</button>
	</div>
	</form>
	</div>
</section>
<script type="module" src="<?= APP_URL . "/src/assets/js/views/auth/signin_form.js" ?>"></script>