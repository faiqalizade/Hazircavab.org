<div class="question_added_user_information">
	<a href="#"><img id="question_added_user_information_image" src="images/profil.png"></a>
	<p id="question_added_user_information_name"> <a href="#">Alizade Faiq</a> </p>
	<p id="question_added_user_information_username"> <a href="#">@alizadefaiq</a> </p>
</div>
<div class="opened_question">
	<div class="opened_question_title">
		<div class="opened_question_tags">
			<a href="#" id="opened_question_tags_main_tag_block" > <img src="images/js.jpg"> JavaScript</a>
			<p>&#8226;</p>
			<p><a href="#">PHP</a></p>
			<p>&#8226;</p>
			<p><a href="#">MySQL</a> </p>
		</div>
		<p id="opened_question_question_title">Как сделать сайт за 1 час? skjdaklhdlashdsdjfh sadhdsf asdhaskfsjajksdfhjshdfjsdhf</p>
	</div>
	<div class="opened_question_question_content">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non p
		roident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</div>
	<div class="opened_question_question_footer">
		<p id="opened_question_question_footer_time">04.01.2018 - 14:26</p>
		<div class="opened_question_question_footer_setting_block_wrapper">
			<div class="opened_question_question_footer_setting_image">
				<img src="images/3pointsilver.svg" id="opened_question_question_footer_setting_image">
			</div>
			<div class="opened_question_question_footer_setting_block">
				<a href="index.php">Изменить</a>
				<a href="#" id="opened_question_question_footer_setting_delete">Удалить</a>
			</div>
		</div>
	</div>
	<p id="text_answers_to_question" >ОТВЕТЫ НА ВОПРОС</p>
</div>
<?php for ($i=0; $i < 5; $i++):?>
		<div class="opened_question_question_answers_wrapper">
			<div class="opened_question_answer_imgs">
				<a href="#" id="opened_question_question_answer_added_user_image" ><img src="images/profil.png"></a>
				<img id="opened_question_question_answer_added_checked" src="images/check.png">
			</div>
			<div class="opened_question_question_answer">
				<div class="opened_question_question_answer_header">
					<a id="opened_question_question_answer_header_user" href="#">Faiq Alizade</a>
					<a id="opened_question_question_answer_header_username" href="#">@alizadefaiq</a>
				</div>
				<div class="opened_question_question_answer_content">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				</div>
				<div class="opened_question_question_answer_like_block">
					<a href="#" id="opened_question_question_answer_like_button">
						<p id="opened_question_question_answer_like_button_text">Мне нравиться</p>
						<p id="opened_question_question_answer_like_button_quantity">4</p>
					</a>
				</div>
			</div>
			<div class="opened_question_question_answer_footer">
				<p id="opened_question_question_footer_time">04.01.2018 - 14:26</p>
				<div class="opened_question_question_footer_setting_block_wrapper">
					<div class="opened_question_question_footer_setting_image">
						<img src="images/3pointsilver.svg" id="opened_question_question_footer_setting_image">
					</div>
					<div class="opened_question_question_footer_setting_block">
						<a href="index.php">Изменить</a>
						<a href="#" id="opened_question_question_footer_setting_delete">Удалить</a>
					</div>
				</div>
			</div>
		</div>
<?php endfor; ?>
<div id="opened_question_question_add_answer">
	<p id='opened_question_question_add_answer_title' >ВАШ ОТВЕТ НА ВОПРОС</p>
	<form method="post">
		<?php require 'HCeditor/HCeditor.php';?>
		<input id="opened_question_question_add_answer_submit" type="submit" name="submit" value="Ответить">
	</form>
</div>
<script>
var opened_question_question_footer_setting_block = 0,opened_question_opened_setting_id;
$('.opened_question_question_footer_setting_image').click(function () {
	if (typeof opened_question_opened_setting_id == 'undefined') {
		opened_question_opened_setting_id = $('.opened_question_question_footer_setting_image').index(this);
		if (!opened_question_question_footer_setting_block){
			$(this).next('.opened_question_question_footer_setting_block').fadeIn(500);
			opened_question_question_footer_setting_block = 1;
		}else {
			$(this).next('.opened_question_question_footer_setting_block').fadeOut(200);
			opened_question_question_footer_setting_block = 0;
		}
	}else if ($('.opened_question_question_footer_setting_image').index(this) == opened_question_opened_setting_id) {
			$(this).next('.opened_question_question_footer_setting_block').fadeOut(200);
			opened_question_question_footer_setting_block = 0;
			opened_question_opened_setting_id = undefined;
	}else {
			opened_question_opened_setting_id = $('.opened_question_question_footer_setting_image').index(this);
			$('.opened_question_question_footer_setting_block').hide();
			opened_question_question_footer_setting_block = 0;
			if (!opened_question_question_footer_setting_block){
				$(this).next('.opened_question_question_footer_setting_block').fadeIn(500);
				opened_question_question_footer_setting_block = 1;
			}else {
				$(this).next('.opened_question_question_footer_setting_block').fadeOut(200);
				opened_question_question_footer_setting_block = 0;
			}
	}
});
$('body').click(function (event) {
	if (event.target.id != 'opened_question_question_footer_setting_image' && event.target.className != 'opened_question_question_footer_setting_image') {
		if (opened_question_question_footer_setting_block) {
			$('.opened_question_question_footer_setting_block').fadeOut(200);
			opened_question_question_footer_setting_block = 0;
			opened_question_opened_setting_id = undefined;
		}
	}
});
$(document).on('touchstart',function (event) {
	if (event.target.id != 'opened_question_question_footer_setting_image' && event.target.className != 'opened_question_question_footer_setting_image') {
		if (opened_question_question_footer_setting_block) {
			$('.opened_question_question_footer_setting_block').fadeOut(200);
			opened_question_question_footer_setting_block = 0;
			opened_question_opened_setting_id = undefined;
		}
	}
});
</script>
