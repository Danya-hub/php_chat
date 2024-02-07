<?php
$title = "Создать профиль";
?>
<section id="signup" class="flex justify-center px-3 py-12">
	<div class="loader fixed left-0 top-0 z-10 bg-white w-full h-full justify-center items-center">
		<img src="<?= APP_URL . "/src/assets/images/loader.gif" ?>" alt="loader">
	</div>
	<div class="self-center max-w-[500px] overflow-scroll">
		<div class="mb-6 text-center">
			<h1 class="text-2xl mb-3 font-bold">Зарегестрироваться</h1>
			<p>Зарегестрируйтесь для общения с другими пользователями</p>
		</div>
		<div class="relative my-5">
			<span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-2">или</span>
			<hr class="border-t border-gray-500" />
		</div>
		<p class="error_message sticky-position"></p>
		<form class="form" action method="post">
			<label class="field block my-4">
				<span>Фотография</span>
				<div class="avatar">
					<img src="<?= APP_URL . "/src/assets/images/person.svg" ?>" alt="avatar">
					<input type="file" name="avatar" class="image_input hidden">
				</div>
			</label>
			<div class="md:flex">
				<label class="field me-3">
					<span>Имя</span>
					<input type="text" name="first_name">
				</label>
				<label class="field">
					<span>Фамилия</span>
					<input type="text" name="last_name">
				</label>
			</div>
			<label class="field">
				<span>Почта</span>
				<input type="email" name="email">
			</label>
			<label class="field">
				<span>Пароль</span>
				<input type="password" name="password">
			</label>
			<label class="field">
				<span>Подтвердите пароль</span>
				<input type="password" name="confirm_password">
			</label>
			<div>
				<label class="flex items-baseline">
					<input type="checkbox" name="sign">
					<p class="ps-2 text-gray-500">Я соглашаюсь с условиями по использованию веб-приложения</p>
				</label>
				<p class="mt-2">
					У вас уже существует аккаунт?
					<a class="font-semibold" href="signin">Войти</a>
				</p>
				<button type="submit" class="px-4 py-2 mt-5 rounded border bg-blue-600 text-white">Регестрировать</button>
			</div>
		</form>
	</div>
</section>
<script type="module" src="<?= APP_URL . "/src/assets/js/views/auth/signup_form.js" ?>"></script>