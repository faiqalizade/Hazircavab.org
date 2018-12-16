<?php
	$article = R::load('blog',$blog_id);
	if($article->id != 0){
		$article->views = $article->views + 1;
		R::store($article);
	}
	$comments = R::find('commentstoarticle','WHERE article_id = ?',[$blog_id]);
?>
<div class="main_page_header">
	<p id="main_blog_title">
		<?=$article->title?>
	</p>
	<div id="blog_added_information">
		<img src="usersfiles/<?=$article->user_login?>/profil.png">
		<p>
			<a href="index.php?page=user&user=<?=$article->user_id?>&infos">
				<?=$article->user_name?> <?=$article->user_surname?>
			</a>
		</p>
		<p>&#8226;</p>
		<img src="images/eye.png">
		<p>
			<?=$article->views?>
		</p>
		<p>&#8226;</p>
		<img src="images/chat.png">
		<p>
			<?=$article->comments?>
		</p>
		<p>&#8226;</p>
		<img src="images/like.png">
		<p>
			<?=$article->likes?>
		</p>
		<p>&#8226;</p>
		<p>
			<?=$article->date?> -
			<?=$article->time?>
		</p>
	</div>
</div>
<img class="opened_blog_photo" src="<?=$article->image?>">
<div class="opened_blog_content">
	<?=preg_replace( "#\r?\n#", "<br/>", $article->content )?>
</div>

<div class="blog_like_button">
	<div class="like_button">
		<p>Лайкнуть</p>
		<p>
			<?=$article->likes?>
		</p>
	</div>
</div>
<div class="blog_comments_block" id='opened_question_question_add_answer'>
	<p class="comment_text">Коментарии</p>

	<?php
	if(!empty($comments)):
	foreach ($comments as $comment):?>
	<div class="blog_comment">
		<div class="blog_comment_added_user_inf">
			<img id="blog_comment_added_user_image" src="usersfiles/<?=$comment->user_login?>/profil.png">
			<div>
				<p id="blog_comment_added_name"> <a href="#">
						<?=$comment->user_name?>
						<?=$comment->user_surname?></a> </p>
				<p id="blog_comment_added_username"> <a href="#">@
						<?=$comment->user_login?></a> </p>
			</div>
		</div>
		<div class="blog_comment_content">
			<?=preg_replace( "#\r?\n#", "<br/>", $comment->content )?>
		</div>
		<div class="opened_question_question_answer_footer">
					<p class="opened_question_question_footer_time"><?=$comment->date?> - <?=$comment->time?></p>
					<div class="opened_question_question_footer_setting_block_wrapper">
						<div class="opened_question_question_footer_setting_image">
							<img src="images/3pointsilver.svg" id="opened_question_question_footer_setting_image">
						</div>
						<div class="opened_question_question_footer_setting_block">
							<?php if($comment->user_login == $user_infos->login || $user_infos->status == 9): ?>
								<a class='opened_question_question_footer_setting_edit' >Изменить</a>
								<a href="index.php?page=question&question=<?=$opened_question?>&remove_answer=<?=$answer->id?>" class="opened_question_question_footer_setting_delete">Удалить</a>
							<?php else:?>
								<a href="index.php">Пожаловаться</a>
							<?php endif;?>
						</div>
					</div>
				</div>
	</div>
	<?php
	endforeach;
	else:
	?>
	<p class='empty_tag'>Пусто</p>
<?php endif;
if($cookie_checked):
?>
<form id="blog_add_comment_form" method="post">
		<hc-editor i='<?=$indexforeditor?>'></hc-editor>
		<label for="blog_comment_add_submit_for_label" id='blog_comment_add_submit'>Отправить</label>
		<input type="submit" name="blog_comment_add_submit" id="blog_comment_add_submit_for_label" value="Отправить">
</form>
<?php else: ?>
<div id="opened_question_question_add_answer">
	<div id='opened_question_question_added_answer' >
		<img src="images/lock.svg">
		<p>Чтобы комментировать статью вы должны войти</p>
	</div>
</div>
<?php endif;?>
</div>
<script>
	init_hceditor('opened_question_question_add_answer');
</script>