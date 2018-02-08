<?php
$user_list_get = R::findAll('users','ORDER BY id DESC');
?>
<div class="main_page_header">
	<p id="main_page_title">Пользователи</p>
</div>
<div class="users_list_wrapper">
<?php foreach ($user_list_get as $user_info): ?>
	<div class="user_list_block">
		<a href="index.php?page=user&user=<?=$user_info->id?>" id="user_list_user_image"><img src="usersfiles/<?=$user_info->login?>/profil.png"></a>
		<a href="index.php?page=user&user=<?=$user_info->id?>"><p id="user_list_user_name"><?=$user_info->name.' '.$user_info->surname?></p></a>
		<p id="user_list_user_answersquestions">
			<a href="index.php?page=user&user=<?=$user_info->id?>&user_questions">13 Вопросов</a>
			<span>&#8226;</span>
			<a href="index.php?page=user&user=<?=$user_info->id?>&user_answers">2 Ответов</a>
		</p>
	</div>
<?php endforeach; ?>
</div>
