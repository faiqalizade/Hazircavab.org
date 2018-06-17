<div class="main_page_header">
<p id="main_blog_title">Упал сервер WhatsApp askdhashdl asjdhadh asdjh asjd asdja </p>
<div id="blog_added_information">
	<img src="images/profil.png">
	<p> <a href="#">Faiq Alizade</a> </p>
	<p>&#8226;</p>
	<p>12312 Просмотров</p>
	<p>&#8226;</p>
	<img src="images/chat.png">
	<p>3</p>
	<p>&#8226;</p>
	<img src="images/like.png">
	<p>143</p>
	<p>&#8226;</p>
	<p>3 января 2018 - 10:47</p>
</div>
</div>
<img class="opened_blog_photo" src="images/blog1.png">
<div class="opened_blog_content">
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
</div>

<div class="blog_like_button">
	<div class="like_button"> <p>Лайкнуть</p> <p>143</p> </div>
</div>
<div class="blog_comments_block">
	<p class="comment_text">Коментарии</p>

<?php for ($i=0; $i < 9; $i++):?>
	<div class="blog_comment">
		<div class="blog_comment_added_user_inf">
			<img id="blog_comment_added_user_image" src="images/profil.png">
			<div>
				<p id="blog_comment_added_name"> <a href="#">Faiq Alizade</a> </p>
				<p id="blog_comment_added_username"> <a href="#">@faiqalizade</a> </p>
			</div>
		</div>
		<div class="blog_comment_content">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</div>
	</div>
<?php endfor; ?>
	<form id="blog_add_comment_form" method="post">
		<?php require 'HCeditor/HCeditor.php';?>
		<input type="submit" name="blog_comment_add_submit" id="blog_comment_add_submit" value="Отправить">
	</form>

</div>
