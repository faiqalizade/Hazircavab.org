<?php
if($opened_question_load->id != 0){
	$opened_question_load->views = $opened_question_load->views + 1;
	R::store($opened_question_load);
}
$find_question_added_profile = R::findOne('users','login = ?',[$opened_question_load->user]);
$find_answers_to_question = R::find('answers','question_id = ? ORDER BY check_answer DESC, date,time',[$opened_question]);
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
		<p class="opened_question_question_footer_time"><?=$opened_question_load->views?> &nbsp; <i class="fas fa-eye"></i> &nbsp; - &nbsp; <?=$opened_question_load->date?> - <?=$opened_question_load->time?></p>
		<div class="opened_question_question_footer_setting_block_wrapper">
			<div class="opened_question_question_footer_setting_image">
				<img src="images/3pointsilver.svg" id="opened_question_question_footer_setting_image">
			</div>
			<div class="opened_question_question_footer_setting_block">
				<?php if($find_question_added_profile->login == $user_infos->login || $user_infos->status == 9): ?>
					<a class="opened_question_footer_setting_edit_button" href="index.php?page=edit_question&question=<?=$opened_question_load->id?>">Изменить</a>
					<a href="index.php?page=remove_question&question=<?=$opened_question_load->id?>" class="opened_question_question_footer_setting_delete">Удалить</a>
				<?php else:?>
					<a href="index.php">Пожаловаться</a>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>
<?php if(!empty($find_answers_to_question)):?>
	<p id="text_answers_to_question" ><?=$langVals[$defLang]['questionsAnswersText']?></p>
<?php
$indexforeditor=0;
foreach ($find_answers_to_question as $answer):
	$find_answer_added_profile = R::findOne('users','login = ?',[$answer->user]);?>
			<div class="opened_question_question_answers_wrapper hc-editor" >
				<div class="opened_question_answer_imgs">
					<a href="index.php?page=user&user=<?=$find_answer_added_profile->id?>" id="opened_question_question_answer_added_user_image" ><img src="usersfiles/<?=$find_answer_added_profile->login?>/profil.png"></a>
					<?php if($answer->check_answer):?>
						<img id="opened_question_question_answer_added_checked" src="images/check.png">
					<?php endif;?>
				</div>
				<div class="opened_question_question_answer">
					<div class="opened_question_question_answer_header">
						<a class="opened_question_question_answer_header_user" href="index.php?page=user&user=<?=$find_answer_added_profile->id?>"><?=$find_answer_added_profile->name.' '.$find_answer_added_profile->surname?></a>
						<a class="opened_question_question_answer_header_username" href="index.php?page=user&user=<?=$find_answer_added_profile->id?>">@<?=$find_answer_added_profile->login?></a>
					</div>
					<div class="opened_question_question_answer_content">
						<div v-show='!show' class='block_for_switch_edit_answer'>
							<?=preg_replace("#\r?\n#", "<br/>",$answer->answer_content)?>
						</div>
						<div class='block_for_edit_answer'>
						<hc-editor v-show='show' :answerid='<?=$answer->id?>' @changer='show = false' content='<?=$answer->answer_content?>' :changer='true' i='<?=$indexforeditor?>'></hc-editor>
						</div>
					</div>
					<?php if($cookie_checked):?>
						<div class="opened_question_question_answer_like_block">
							<?php
							$load_user_like_answers = R::find('users','WHERE id = ? AND answer_likes LIKE ?',[$user_infos->id,'%,'.$answer->id.',%']);
							if(empty($load_user_like_answers)):?>
							<a href="index.php?page=question&question=<?=$opened_question?>&like=<?=$answer->id?>" id="opened_question_question_answer_like_button">
								<p id="opened_question_question_answer_like_button_text"><i class="fas fa-thumbs-up"></i></p>
								<p id="opened_question_question_answer_like_button_quantity"><?=$answer->likes?></p>
							<?php else:?>
							<a href="index.php?page=question&question=<?=$opened_question?>&unlike=<?=$answer->id?>" id="opened_question_question_answer_liked_button">
								<p id="opened_question_question_answer_liked_button_text"><i class="fas fa-thumbs-up"></i></p>
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
							<?php endif;
							$indexforeditor++;
							$commentsToAnswer = R::find('commentstoanswer','WHERE answer_id = ? ORDER BY date,time',[$answer->id]);
							?>
							<p class='opened_question_question_answer_comment_button' ><i class="fas fa-comment"></i> (<span class="answers_comments_count"><?=count($commentsToAnswer)?></span>) </p>
						</div>
					<?php endif;?>
					<div class='opened_question_answer_comment_wrapper'>
						<div class="opened_question_answer_comments">
							<!--*******************-->
							<?php foreach($commentsToAnswer as $comment):
								$commentAddedUser = R::findOne('users','login = ?',[$comment->user]);
								$commentsLikesArray = explode(',',$user_infos->comments_likes);
								?>
								<div class='opened_question_comment_to_answer_wrapper'>
									<div class='opened_question_comment_to_answer_image_user'>
										<a href='index.php?page=user&user=<?=$commentAddedUser->id?>'><img src='usersfiles/<?=$comment->user?>/profil.png' class='opened_question_comment_to_answer_image'></a>
									</div>
									<div class='opened_question_comment_to_answer_content_wrapper'>
										<div class='opened_question_comment_to_answer_user_infos'>
											<a href='index.php?page=user&user=<?=$commentAddedUser->id?>' class='opened_question_comment_to_answer_user' ><?=$commentAddedUser->name?> <?=$commentAddedUser->surname?></a> <a href='index.php?page=user&user=<?=$commentAddedUser->id?>'class='opened_question_comment_to_answer_username' >@<?=$comment->user?></a>
										</div>
										<div class='opened_question_comment_to_answer_content'>
										<?=preg_replace('#\r?\n#', '<br/>',$comment->content)?>
										</div>
										<div class='opened_question_comment_to_answer_footer'>
											<p class='opened_question_comment_to_answer_date'><?=$comment->date?> - <?=$comment->time?></p>
											<?php if(in_array($comment->id,$commentsLikesArray)): ?>
												<p class='opened_question_comment_to_answer_like_bttn' commentId='<?=$comment->id?>' liked='true'> <span class="comments_to_answer_like_text"><i class="fas fa-thumbs-up"></i></span> (<span class="comments_to_answer_count"><?=$comment->likes?></span>)</pre>
											<?php else:?>
												<p class='opened_question_comment_to_answer_like_bttn' commentId='<?=$comment->id?>' liked='false'> <span class="comments_to_answer_like_text"><i class="far fa-thumbs-up"></i></span> (<span class="comments_to_answer_count"><?=$comment->likes?></span>)</p>
											<?php endif;?>
											<p class='opened_question_comment_to_answer_reply_bttn' user='<?=$comment->user?>' answerEditorIndex='<?=$indexforeditor?>' ><i class="fas fa-reply"></i></p>
											<div class="opened_question_question_footer_setting_block_wrapper">
												<div class="opened_question_question_footer_setting_image">
													<img src="images/3pointsilver.svg" id="opened_question_question_footer_setting_image">
												</div>
												<div class="opened_question_question_footer_setting_block">
												<?php if($comment->user == $user_infos->login || $user_infos->status == 9): ?>
													<a commentId='<?=$comment->id?>' class="opened_question_question_footer_setting_delete remove_button_comment">Удалить</a>
												<?php else:?>
													<a href="index.php">Пожаловаться</a>
												<?php endif;?>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach;?>
							<!--*******************-->
						</div>
						<div class="comment_to_answer_editor_wrapper">
							<hc-editor i='<?=$indexforeditor?>'></hc-editor>
						</div>
						<div>
							<div answerId='<?=$answer->id?>' indexEditorComment='<?=$indexforeditor?>' class='opened_question_answer_comment_send_button submit_btn' >
								Комментировать
							</div>
						</div>
					</div>
				</div>
				<div class="opened_question_question_answer_footer">
					<p class="opened_question_question_footer_time"><?=$answer->date?> - <?=$answer->time?></p>
					<div class="opened_question_question_footer_setting_block_wrapper">
						<div class="opened_question_question_footer_setting_image">
							<img src="images/3pointsilver.svg" id="opened_question_question_footer_setting_image">
						</div>
						<div class="opened_question_question_footer_setting_block">
							<?php if($find_answer_added_profile->login == $user_infos->login || $user_infos->status == 9): ?>
								<a @click='show=true' class='opened_question_question_footer_setting_edit' >Изменить</a>
								<a href="index.php?page=question&question=<?=$opened_question?>&remove_answer=<?=$answer->id?>" class="opened_question_question_footer_setting_delete">Удалить</a>
							<?php else:?>
								<a href="index.php">Пожаловаться</a>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div>
	<?php
	$indexforeditor++;
	endforeach;
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
	<div class="editorBlock">
	<form method="post" id='add_answer_form'>
		<hc-editor i='<?=$indexforeditor?>' ></hc-editor>
	</form>
	</div>
	<div id='opened_question_question_add_answer_submit' class='submit_btn' >
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
<script>
	init_hceditor('opened_question_question_add_answer','hc-editor');
</script>
