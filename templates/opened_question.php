<?php
$opened_question_load = R::load('questions',$opened_question);
if($opened_question_load->id != 0){
	$opened_question_load->views = $opened_question_load->views + 1;
	R::store($opened_question_load);
}
$find_question_added_profile = R::findOne('users','login = ?',[$opened_question_load->user]);
$find_answers_to_question = R::find('answers','question_id = '.$opened_question);
$opened_question_tag_array = explode(',',$opened_question_load->tags);
?>
<div class="question_added_user_information">
	<a href="index.php?page=user&user=<?=$find_question_added_profile->id?>"><img id="question_added_user_information_image" src="usersfiles/<?=$find_question_added_profile->login?>/profil.png"></a>
	<p id="question_added_user_information_name"> <a href="index.php?page=user&user=<?=$find_question_added_profile->id?>"><?=$find_question_added_profile->name.' '.$find_question_added_profile->surname?></a></p>
	<p id="question_added_user_information_username"> <a href="index.php?page=user&user=<?=$find_question_added_profile->id?>">@<?=$find_question_added_profile->login?></a> </p>
</div>
<div class="opened_question">
	<div class="opened_question_title">
		<div class="opened_question_tags">
			<a href="index.php?page=tags&tag=<?=$opened_question_tag_array[0]?>" id="opened_question_tags_main_tag_block" > <img src="tagimages/<?=$opened_question_tag_array[0]?>.png"><?=$opened_question_tag_array[0]?></a>
			<?php for($i = 1; $i < count($opened_question_tag_array); $i++):?>
			<p>&#8226;</p>
			<p><a href="index.php?page=tags&tag=<?=$opened_question_tag_array[$i]?>"><?=$opened_question_tag_array[$i]?></a></p>
			<?php endfor;?>
		</div>
		<p id="opened_question_question_title"><?=$opened_question_load->title?></p>
	</div>
	<div class="opened_question_question_content">
		<?=preg_replace( "#\r?\n#", "<br/>", $opened_question_load->content );?>
	</div>
	<div class="opened_question_question_footer">
		<p class="opened_question_question_footer_time"><?=$opened_question_load->views?> &nbsp; просмотров &nbsp; <?=$opened_question_load->date?> - <?=$opened_question_load->time?></p>
		<div class="opened_question_question_footer_setting_block_wrapper">
			<div class="opened_question_question_footer_setting_image">
				<img src="images/3pointsilver.svg" id="opened_question_question_footer_setting_image">
			</div>
			<div class="opened_question_question_footer_setting_block">
				<?php if($find_question_added_profile->login == $user_infos->login || $user_infos->status == 1): ?>
					<a href="index.php?page=edit_question&question=<?=$opened_question_load->id?>">Изменить</a>
					<a href="index.php?page=remove_question&question=<?=$opened_question_load->id?>" id="opened_question_question_footer_setting_delete">Удалить</a>
				<?php else:?>
					<a href="index.php">Пожаловаться</a>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>
<?php if(!empty($find_answers_to_question)):?>
	<p id="text_answers_to_question" >ОТВЕТЫ НА ВОПРОС</p>
<?php foreach ($find_answers_to_question as $answer):
	$find_answer_added_profile = R::findOne('users','login = ?',[$answer->user]);?>
			<div class="opened_question_question_answers_wrapper">
				<div class="opened_question_answer_imgs">
					<a href="index.php?page=user&user=<?=$find_answer_added_profile->id?>" id="opened_question_question_answer_added_user_image" ><img src="usersfiles/<?=$find_answer_added_profile->login?>/profil.png"></a>
					<?php if($answer->check_answer):?>
						<img id="opened_question_question_answer_added_checked" src="images/check.png">
					<?php endif;?>
				</div>
				<div class="opened_question_question_answer">
					<div class="opened_question_question_answer_header">
						<a id="opened_question_question_answer_header_user" href="index.php?page=user&user=<?=$find_answer_added_profile->id?>"><?=$find_answer_added_profile->name.' '.$find_answer_added_profile->surname?></a>
						<a id="opened_question_question_answer_header_username" href="index.php?page=user&user=<?=$find_answer_added_profile->id?>">@<?=$find_answer_added_profile->login?></a>
					</div>
					<div class="opened_question_question_answer_content">
						<p style='display:none;' class='for_edit_copy_content_no_br'><?=$answer->answer_content?></p>
						<p style='display:none;' class='for_edit_copy_content_id'><?=$answer->id?></p>
						<div class='block_for_switch_edit_answer' >
							<?=preg_replace("#\r?\n#", "<br/>",$answer->answer_content)?>
						</div>
						<div class='block_for_edit_answer'>

						</div>
					</div>
					<?php if($cookie_checked):?>
						<div class="opened_question_question_answer_like_block">
							<?php
							$load_user_like_answers = R::find('users','WHERE id = ? AND answer_likes LIKE ?',[$user_infos->id,'%,'.$answer->id.',%']);
							if(empty($load_user_like_answers)):?>
							<a href="index.php?page=question&question=<?=$opened_question?>&like=<?=$answer->id?>" id="opened_question_question_answer_like_button">
								<p id="opened_question_question_answer_like_button_text">Нравиться</p>
								<p id="opened_question_question_answer_like_button_quantity"><?=$answer->likes?></p>
							<?php else:?>
							<a href="index.php?page=question&question=<?=$opened_question?>&unlike=<?=$answer->id?>" id="opened_question_question_answer_liked_button">
								<p id="opened_question_question_answer_liked_button_text">Не нравиться</p>
								<p id="opened_question_question_answer_liked_button_quantity"><?=$answer->likes?></p>
							<?php endif; ?>
							</a>
							<?php if($find_question_added_profile->login == $user_infos->login && $answer->user != $user_infos->login): ?>
									<?php if($answer->check_answer == 0): ?>
									<a href="index.php?page=question&question=<?=$opened_question?>&check=<?=$answer->id?>" id='opened_question_question_answer_check_button' >
										<p id='opened_question_question_answer_check_button_text' >Правильный ответ</p>
									<?php else:?>
										<a href="index.php?page=question&question=<?=$opened_question?>&uncheck=<?=$answer->id?>" id='opened_question_question_answer_checked_button' >
											<p id='opened_question_question_answer_checked_button_text' >Неправильный ответ</p>
									<?php endif;?>
									</a>
							<?php endif;?>
						</div>
					<?php endif;?>
				</div>
				<div class="opened_question_question_answer_footer">
					<p class="opened_question_question_footer_time"><?=$answer->date?> - <?=$answer->time?></p>
					<div class="opened_question_question_footer_setting_block_wrapper">
						<div class="opened_question_question_footer_setting_image">
							<img src="images/3pointsilver.svg" id="opened_question_question_footer_setting_image">
						</div>
						<div class="opened_question_question_footer_setting_block">
							<?php if($find_answer_added_profile->login == $user_infos->login || $user_infos->status == 1): ?>
								<a class='opened_question_question_footer_setting_edit' >Изменить</a>
								<a href="index.php?page=question&question=<?=$opened_question?>&remove_answer=<?=$answer->id?>" id="opened_question_question_footer_setting_delete">Удалить</a>
							<?php else:?>
								<a href="index.php">Пожаловаться</a>
							<?php endif;?>
						</div>
					</div>
				</div>
				
			</div>
	<?php endforeach;
	$content = '';
	?>
<?php endif;
if($cookie_checked):
$load_answers_for_user = R::getAll('SELECT * FROM answers WHERE user = :user',
[':user' => $user_infos->login]
);
$isset_asnwer = in_array($opened_question,array_column($load_answers_for_user,'question_id'));
if(empty($isset_asnwer) && $cookie_checked):
?>
<div id="opened_question_question_add_answer">
	<p id='opened_question_question_add_answer_title' >ВАШ ОТВЕТ НА ВОПРОС</p>
	<form method="post" id='add_answer_form'>
		<?php require 'HCeditor/HCeditor.php';?>
	</form>
	<div id='opened_question_question_add_answer_submit' >
		Отправить
	</div>
</div>
<?php else:?>
<div id="opened_question_question_add_answer">
	<p id='opened_question_question_add_answer_title' >ВАШ ОТВЕТ НА ВОПРОС</p>
	<div id='opened_question_question_added_answer' >
	<img src="images/lock.svg">
	<p>Вы уже ответили на этот вопрос</p>
	</div>
</div>
<?php endif;
else:
?>
<div id="opened_question_question_add_answer">
	<p id='opened_question_question_add_answer_title' >ВАШ ОТВЕТ НА ВОПРОС</p>
	<div id='opened_question_question_added_answer' >
	<img src="images/lock.svg">
	<p>Чтобы ответить на вопрос вы должны войти</p>
	</div>
</div>
<?php endif;?>

<template id='test' >
	<?php require 'HCeditor/HCeditor.php' ?>
	<div id='edit_answer_buttons_wrapper' >
		<p id='edit_answer_button' >Изменить</p>
		<p id='edit_answer_cancel' >Отменить</p>
	</div>
</template>
<script>
	$('.opened_question_question_content > a').attr('target','blank');
	$('.opened_question_question_answer_content > a').attr('target','blank');
var opened_question_question_footer_setting_block = 0,opened_question_opened_setting_id;
$('div.opened_question_question_footer_setting_image').click(function () {
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
$('#opened_question_question_add_answer_submit').click(function () {
	if(endTextLength > 5){
    	$('#add_answer_form').submit(); 
	}
});
var test = $('<template></template>');
var el = $('#test');
$('.opened_question_question_footer_setting_block').click(function () {
	$('.opened_question_question_footer_setting_block').hide();
	var editAnswerIndex = $('.opened_question_question_footer_setting_block').index(this);
	editAnswerIndex -= 1;
	var editAnswerId = $('.for_edit_copy_content_id').eq(editAnswerIndex).text();
	$('.block_for_switch_edit_answer').css('display','block');
	$('.block_for_switch_edit_answer').eq(editAnswerIndex).css('display','none');
	$('.block_for_edit_answer').children().remove();
	$('.block_for_edit_answer').eq(editAnswerIndex).html(el.html());
	$('.block_for_edit_answer .editor_textarea').html($('.for_edit_copy_content_no_br').eq(editAnswerIndex).html());
	$('#edit_answer_cancel').click(function () {
		$('.block_for_edit_answer').children().remove();
		$('.block_for_switch_edit_answer').css('display','block');
	});
	$('#edit_answer_button').click(function () {
		if (endTextLength > 5) {
			var editAnswerNewContent = $('.block_for_edit_answer .HCeditorcopy').val();
			$.ajax({
				url: 'templates/edit_answer.php',
				dataType: 'html',
				data: ({answerId: editAnswerId,editAnswerContent: editAnswerNewContent}),
				type: 'post',
				success: function (data) {
					$('.block_for_edit_answer').children().remove();
					$('.block_for_switch_edit_answer').eq(editAnswerIndex).html(editAnswerNewContent.replace(/(?:\r\n|\r|\n)/g, '<br/>'));
					$('.block_for_switch_edit_answer').css('display','block');
					$('.for_edit_copy_content_no_br').eq(editAnswerIndex).text(editAnswerNewContent.replace(/<br\s*[\/]?>/gi,"\n"));
				}
			});	
		}
	});
	$('#opened_question_question_add_answer .editor_textarea').focus(function () {
		$('.block_for_edit_answer').children().remove();
		$('.block_for_switch_edit_answer').css('display','block');
	});
});
</script>
