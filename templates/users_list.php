<?php
$user_list_get = R::findAll('users','ORDER BY id DESC');
if(!isset($list_page_number)){
	$page_number = 1;
}else{
	$page_number = $list_page_number;
}
$list_limit_last = ($page_number - 1) * 15;
$list_limit = $page_number * 15;
$page_count = count($user_list_get) / 15;
	if(is_float($page_count)){
		$page_count++;
	}
settype($page_count,'int');
?>
<div class="main_page_header">
	<p id="main_page_title">Пользователи</p>
</div>
<div id='user_list' >
	<div class="users_list_wrapper">
	<?php foreach ($user_list_get as $user_info): 
		$find_user_questions = R::find('questions','user = ?',[$user_info->login]);
		$find_user_answers = R::find('answers','user = ?',[$user_info->login]);
		if($cycle_number >= $list_limit_last && $cycle_number < $list_limit):
		?>
		<div class="user_list_block">
			<a href="index.php?page=user&user=<?=$user_info->id?>" id="user_list_user_image"><img src="usersfiles/<?=$user_info->login?>/profil.png"></a>
			<a href="index.php?page=user&user=<?=$user_info->id?>"><p id="user_list_user_name"><?=$user_info->name.' '.$user_info->surname?></p></a>
			<p id="user_list_user_answersquestions">
				<a href="index.php?page=user&user=<?=$user_info->id?>&user_questions"><?=count($find_user_questions)?> Вопросов</a>
				<span>&#8226;</span>
				<a href="index.php?page=user&user=<?=$user_info->id?>&user_answers"><?=count($find_user_answers)?> Ответов</a>
			</p>
		</div>
	<?php 
	endif;
	if($cycle_number == $list_limit){
		break;
	}
	$cycle_number++;
endforeach; ?>
	</div>
	<?php if(count($user_list_get) > 15): ?>
<div class="questions_pages">
			<?php if($page_number > 1):?>
				<a href="index.php?page=users&pn=<?=$page_number - 1;?>">&#8592; Предыдущий</a>
			<?php endif;
			if($page_number > 6){
				$left_page_list = $page_number - 6;
			}
			for($i = 1; $i <= $page_count; $i++):
				if($i > $left_page_list && $i <= 10 + $left_page_list):
			?>
				<a id = '<?=$i?>' href="index.php?page=users&pn=<?=$i?>"><?=$i?></a>
			<?php
				endif;
			endfor;
			if($page_number < $page_count):
			?>
				<a href="index.php?page=users&pn=<?=$page_number + 1;?>">Следующий &#8594;</a>
			<?php endif;?>
		</div>
<?php endif;?>
</div>