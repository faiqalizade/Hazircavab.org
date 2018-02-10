<?php
$opened_question_load = R::load('questions',$opened_question);
$opened_question_load->views = $opened_question_load->views + 1;
R::store($opened_question_load);
$find_question_added_profile = R::findOne('users','login = ?',[$opened_question_load->user]);
$find_answers_to_question = R::find('answers','question_id = '.$opened_question);
?>
<div class="question_added_user_information">
	<a href="index.php?page=user&user=<?=$find_question_added_profile->id?>"><img id="question_added_user_information_image" src="usersfiles/<?=$find_question_added_profile->login?>/profil.png"></a>
	<p id="question_added_user_information_name"> <a href="index.php?page=user&user=<?=$find_question_added_profile->id?>"><?=$find_question_added_profile->name.' '.$find_question_added_profile->surname?></a></p>
	<p id="question_added_user_information_username"> <a href="index.php?page=user&user=<?=$find_question_added_profile->id?>">@<?=$find_question_added_profile->login?></a> </p>
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
		<p id="opened_question_question_title"><?=$opened_question_load->title?></p>
	</div>
	<div class="opened_question_question_content">
		<?=preg_replace( "#\r?\n#", "<br/>", $opened_question_load->content );?>
	</div>
	<div class="opened_question_question_footer">
		<p id="opened_question_question_footer_time"><?=$opened_question_load->date?> - <?=$opened_question_load->time?></p>
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
<?php if(!empty($find_answers_to_question)):?>
<?php foreach ($find_answers_to_question as $answer):
	$find_answer_added_profile = R::findOne('users','login = ?',[$answer->user]);?>
			<div class="opened_question_question_answers_wrapper">
				<div class="opened_question_answer_imgs">
					<a href="#" id="opened_question_question_answer_added_user_image" ><img src="usersfiles/<?=$find_answer_added_profile->login?>/profil.png"></a>
					<?php if($answer->check_answer):?>
						<img id="opened_question_question_answer_added_checked" src="images/check.png">
					<?php endif;?>
				</div>
				<div class="opened_question_question_answer">
					<div class="opened_question_question_answer_header">
						<a id="opened_question_question_answer_header_user" href="#"><?=$find_answer_added_profile->name.' '.$find_answer_added_profile->surname?></a>
						<a id="opened_question_question_answer_header_username" href="#">@<?=$find_answer_added_profile->login?></a>
					</div>
					<div class="opened_question_question_answer_content">
						<?=preg_replace("#\r?\n#", "<br/>",$answer->answer_content)?>
					</div>
					<div class="opened_question_question_answer_like_block">
						<a href="#" id="opened_question_question_answer_like_button">
							<p id="opened_question_question_answer_like_button_text">Мне нравиться</p>
							<p id="opened_question_question_answer_like_button_quantity"><?=$answer->likes?></p>
						</a>
					</div>
				</div>
				<div class="opened_question_question_answer_footer">
					<p id="opened_question_question_footer_time"><?=$answer->date?> - <?=$answer->time?></p>
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
	<?php endforeach; ?>
<?php endif;?>
<div id="opened_question_question_add_answer">
	<p id='opened_question_question_add_answer_title' >ВАШ ОТВЕТ НА ВОПРОС</p>
	<form method="post" id='HCeditorForm'>
		<?php require 'HCeditor/HCeditor.php';?>
	</form>
	<div id='opened_question_question_add_answer_submit' >
		Отправить
	</div>
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
