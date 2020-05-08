<?php
	$article = R::load('blog',$blog_id);
	$is_liked_blog_user = R::findOne('bloglikes', 'WHERE user_id = ? AND blog_id = ?',[$user_infos->id,$blog_id]);
	if($article->id != 0){
		$article->views = $article->views + 1;
		if(isset($_POST['like_button_submit'])){
			if($cookie_checked){
				$article->likes = $article->likes + 1;
				$blog_likes_table = R::dispense('bloglikes');
				$blog_likes_table->blog_id = $blog_id;
				$blog_likes_table->user_id = $user_infos->id;
				R::store($blog_likes_table);
				echo "
				<script>
					setTimeout(()=>{
						window.location = 'index.php?page=blog&blog=$blog_id';
					},50);
				</script>
				";
			}
		}elseif (isset($_POST['unlike_button_submit'])) {
			$article->likes = $article->likes - 1;
			$blog_likes_table = R::load('bloglikes',$is_liked_blog_user->id);
			R::trash($blog_likes_table);
			echo "
				<script>
				setTimeout(()=>{
					window.location = 'index.php?page=blog&blog=$blog_id';
				},50);
				</script>
				";
		}
		R::store($article);
	}
	$comments = R::find('commentstoarticle','WHERE article_id = ?',[$blog_id]);
?>
<div class="main_page_header">
	<p id="main_blog_title">
		<?=$article->title?>
	</p>
	<div id="blog_added_information">
		<img src="usersfiles/<?=$article->user_login?>/profil.jpg">
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
	<?php if(empty($is_liked_blog_user)): ?>
		<form method="post">
			<input  style='display:none'type="submit" name="like_button_submit" id='like_button_submit' >
		</form>
		<label for='like_button_submit' class="like_button">
			<p><i class="fas fa-thumbs-up"></i></p>
			<p id="like_counts">
				<?=$article->likes?>
			</p>
		</label>
	<?php else: ?>
		<form method="post">
			<input  style='display:none'type="submit" name="unlike_button_submit" id='like_button_submit' >
		</form>
		<label for='like_button_submit' class="unlike_button">
			<p><i class="fas fa-thumbs-up"></i></p>
			<p id="like_counts">
				<?=$article->likes?>
			</p>
		</label>
	<?php endif; ?>
</div>
<div class="blog_comments_block" id='opened_question_question_add_answer'>
	<p class="comment_text"><?=$langVals[$defLang]['comments']?></p>

	<?php
	if(!empty($comments)):
	foreach ($comments as $comment):?>
	<div class="blog_comment" data_comment_id='<?=$comment->id?>'>
		<div class="blog_comment_added_user_inf">
			<img id="blog_comment_added_user_image" src="usersfiles/<?=$comment->user_login?>/profil.jpg">
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
					<p class="opened_question_question_footer_time"><?=$comment->date?> - <?=$comment->time?> </p>
					<div class="opened_question_question_footer_setting_block_wrapper">
						<div class="opened_question_question_footer_setting_image">
							<img src="images/3pointsilver.svg" id="opened_question_question_footer_setting_image">
						</div>
						<div class="opened_question_question_footer_setting_block">
							<?php if($comment->user_login == $user_infos->login || $user_infos->status == 9): ?>
								<a class='opened_question_question_footer_setting_edit' ><?=$langVals[$defLang]['editText']?></a>
								<a class="opened_question_question_footer_setting_delete"><?=$langVals[$defLang]['removeText']?></a>
							<?php else:?>
								<a href="index.php"><?=$langVals[$defLang]['complainText']?></a>
							<?php endif;?>
						</div>
					</div>
				</div>
	</div>
	<?php
	endforeach;
	else:
	?>
	<p class='empty_tag'><?=$langVals[$defLang]['emptyText']?></p>
<?php endif;
if($cookie_checked):
?>
<form id="blog_add_comment_form" method="post">

		<hc-editor :minlength='10' :required='true' i='<?=$indexforeditor?>'></hc-editor>
		<label for="blog_comment_add_submit_for_label" class='blog_comment_add_submit submit_btn'><?=$langVals[$defLang]['addComment']?></label>
		<input type="submit" name="blog_comment_add_submit" id="blog_comment_add_submit_for_label" value="<?=$langVals[$defLang]['addComment']?>">
		<div class="edit_buttons_wrapper" style='display:none'>
			<p class="edit_button"><?=$langVals[$defLang]['editText']?></p> 
			<p class="edit_cancel">Отменить</p>
		</div>
</form>
<?php else: ?>
<div id="opened_question_question_add_answer">
	<div id='opened_question_question_added_answer' >
		<img src="images/lock.svg">
		<p><?=$langVals[$defLang]['signinForSendAnswer']?></p>
	</div>
</div>
<?php endif;?>
</div>
<script>
	init_hceditor('opened_question_question_add_answer');

	var i,content,
	commentsCount		=	<?=$article->comments?>;

	$('.opened_question_question_footer_setting_edit').click(function () { 
		$('.edit_buttons_wrapper').show();
		$('.blog_comment_add_submit').hide();
		$('#blog_comment_add_submit_for_label').attr('disabled','disabled');
		i				=	$('.opened_question_question_footer_setting_edit').index(this);
		content			=	$('.blog_comment_content').eq(i).text();
		content = content.replace(/<br\s*[\/]?>/gi,"\n");
		$('.editor_textarea').val(content.trim());
	});


	
	$('.edit_button').click(function () {
		if(endTextLength > 10){
			$('#HCeditor_error').text('');
			var
			commentId			=	$('.blog_comment').eq(i).attr('data_comment_id'),
			newContent			=	$('.HCeditorcopy').val();
			$.ajax({
				type: "post",
				url: "library/ajaxEditer.php",
				data: {table:"commentstoarticle",edit_id:commentId,content:newContent},
				dataType: "html",
				cache: false,
				success: function (response) {
					$('.blog_comment_content').eq(i).text(newContent);
					$('.edit_buttons_wrapper').hide();
					$('.blog_comment_add_submit').show();
					$('#blog_comment_add_submit_for_label').removeAttr('disabled');
					$('.editor_textarea').val('');
				}
			});
		}else{
			$('#HCeditor_error').text('Минимальная длина текста: 10, максимальная: 10 000');
		}
	});
	$('.edit_cancel').click(function () { 
		$('.edit_buttons_wrapper').hide();
		$('.blog_comment_add_submit').show();
		$('#blog_comment_add_submit_for_label').removeAttr('disabled');
		$('.editor_textarea').val('');
	});




	$('.opened_question_question_footer_setting_delete').click(function () { 
		i				=	$('.opened_question_question_footer_setting_delete').index(this);
		var
		commentId			=	$('.blog_comment').eq(i).attr('data_comment_id');
		$.ajax({
			type: "post",
			url: "library/ajaxTrash.php",
			data: {table:'commentstoarticle',trash_id:commentId},
			dataType: "html",
			success: function () {
				$( ".blog_comment" ).eq(i).hide( "drop", { direction: "up" }, 400);
			}
		});

		$.ajax({
				type: "post",
				url: "library/ajaxEditer.php",
				data: {table:"blog",edit_id:"<?=$blog_id?>",comments: commentsCount - 1 },
				dataType: "html",
				cache: false,
				success: function (response) {
					$('#blog_added_information p').eq(4).text(commentsCount - 1);
					commentsCount -= 1;
				}
			});
	});
</script>