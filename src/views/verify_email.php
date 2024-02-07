<?php
$title = "Подтвердить почту";
?>
<section id="verify_email" class="flex justify-center px-3 py-12">
	<div class="loader fixed left-0 top-0 z-10 bg-white w-full h-full justify-center items-center">
		<img src="<?= APP_URL . "/src/assets/images/loader.gif" ?>" alt="loader">
	</div>
	<div class="self-center max-w-[500px]">
		<div class="mb-6 text-center">
			<h2 class="text-2xl mb-3 font-bold">Подтвердите свою почту</h2>
			<p>Мы отправили код подтверждения вам на почту. Введите его ниже</p>
		</div>
		<p class="error_message sticky-position"></p>
		<form action class="form">
			<label class="field">
				<span>Код подтверждения</span>
				<input type="text" name="confirm_code">
			</label>
		<button type="button" class="send_code_btn font-semibold block">Отправить код</button>
		<button type="submit" class="block px-4 py-2 mt-5 rounded border bg-blue-600 text-white">Отправить</button>
		</form>
	</div>
</section>
<script type="module" src="<?= APP_URL . "/src/assets/js/views/auth/verify_email_form.js" ?>"></script>