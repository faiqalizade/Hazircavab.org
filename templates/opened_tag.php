<?php
if(!isset($list_page_number)){
	$page_number = 1;
}else{
	$page_number = $list_page_number;
}
$list_limit_last = ($page_number - 1) * 15;
$list_limit = $page_number * 15;
$cycle_number = 0;
$opened_tag_load = R::load('tags',$tag);
if(isset($_GET['questions'])){
	$opened_tag_title = 'questions';
	$opened_tag_questions_load = R::getAll("SELECT 
	questions.*,
	questiontags.question_id,
	questiontags.tag_id,
	questiontags.tag_name_ru,
	questiontags.tag_name_az
	FROM questions
	JOIN questiontags ON questiontags.question_id = questions.id
	WHERE questiontags.tag_id = ? ORDER BY  `date` DESC, `time` DESC",[$tag]);
}elseif(isset($_GET['subscribes'])){
	$opened_tag_title = 'subscribes';
	$opened_tag_subscribed_uesrs_load = R::find('tagsubscribes','tag_id = ?',[$tag]);
}else{
	echo "			<script>
	window.location = 'index.php?page=tags&tag=$tag&questions';
</script>";
}
$opened_tag_questions_load_where_check = R::find('questions','check_answer <> ?',[',']);
?>
<div id='opened_tag_header_wrapper' >
<div id='opened_tag_header'>
<img src="tagimages/<?=$tag?>.png">
<p><?= ($defLang == 'ru') ? $opened_tag_load->name_ru : $opened_tag_load->name_az ?></p>
<div id='opened_tag_header_about' >
    <div class='opened_tag_header_about_item'>
        <p><?=$opened_tag_load->questions?></p>
        <p class='opened_tag_header_about_item_name'><?= $langVals[$defLang]['questions'] ?></p>
    </div>
    <div class='opened_tag_header_about_item'>
        <p><?=$opened_tag_load->subscribes?></p>
        <p class='opened_tag_header_about_item_name'><?=$langVals[$defLang]['subscribeText2']?></p>
    </div>
    <div class='opened_tag_header_about_item'>
        <p><?=(int)((count($opened_tag_questions_load_where_check) * 100) / $opened_tag_load->questions)?>%</p>
        <p class='opened_tag_header_about_item_name'><?=$langVals[$defLang]['solvedText']?></p>
    </div>
</div>
<?php
if($cookie_checked):
	$subscribed_tag_logined_user = R::find('tagsubscribes','WHERE user_id = ? AND tag_id = ?',[$user_infos->id,$tag]);
	if(empty($subscribed_tag_logined_user)):?>
	<a href='index.php?page=subscribe&sub_tag=<?=$opened_tag_load->id?>' id='opened_tag_header_subscribe_button' ><?=$langVals[$defLang]['subscribeText']?></a>
<?php else:?>
	<a href='index.php?page=unsubscribe&sub_tag=<?=$opened_tag_load->id?>' id='opened_tag_header_subscribed_button' ><?=$langVals[$defLang]['subscribedText']?></a>
<?php 
	endif;
endif;
?>
</div>
</div>
<div id='opened_tag_tag_lists' >
    <a href="index.php?page=tags&tag=<?=$tag?>&questions" class='opened_tag_tag_list' ><?=$langVals[$defLang]['questionsProfile']?></a>
    <a href="index.php?page=tags&tag=<?=$tag?>&subscribes" class='opened_tag_tag_list' ><?=$langVals[$defLang]['subscribesText']?></a>
</div>
<div id='opened_tag_after_list_wrapper' >
	<?php if(isset($_GET['questions'])):?>
		<script>
			$('.opened_tag_tag_list').eq(0).css('border-bottom','solid 2px');
		</script>
	<div class="questions">
		<?php
			$page_count = $opened_tag_load->questions / 15;
			if(is_float($page_count)){
				$page_count++;
			}
			settype($page_count,'int');
			if($page_number > $page_count && $page_count > 0 || $page_number <= 0){
				echo "
				<script>
				window.location = 'index.php?page=tags&tag=$tag';
				</script>
				";
			}
		foreach($opened_tag_questions_load as $question):
				if($cycle_number >= $list_limit_last && $cycle_number < $list_limit):
					$question_tags_count = R::count('questiontags','WHERE question_id = ?',[$question['id']]);
			?>
					<div class="question2">
						<div class="question_information_block">
							<div class='question_tags_wrapper' >
							<a href="index.php?page=question&question=<?=$question['id']?>"><img src="tagimages/<?=$question['tag_id']?>.png"></a>
							<a href="index.php?page=question&question=<?=$question['id']?>" class='question_tags' ><?= ($defLang == 'ru') ? $question['tag_name_ru'] : $question['tag_name_az'] ?></a>
							<?php if($question_tags_count > 1):?>
							<a href="index.php?page=question&question=<?=$question['id']?>" class='question_tags_more_tags'> &nbsp; <?=$langVals[$defLang]['andMore']?> <?=$question_tags_count - 1?></a>
							<?php endif;?>
							</div>
							<a href="index.php?page=question&question=<?=$question['id']?>" class="question_title"><?=$question['title']?></a>
							<p class="question_information"><?=$question['views']?> <i class="fas fa-eye"></i> &#8226; <?=$question['date'].' '.$question['time']?></p>
						</div>
					<div class="question_answers">
						<?php
						if($question['check_answer'] != ','):?>
						<div class="question_answers_wrapper check">
							<p><?=$question['answers']?></p>
							<p><?= $langVals[$defLang]['answersCount'] ?></p>
						</div>
						<?php else:?>
						<div class="question_answers_wrapper">
							<p><?=$question['answers']?></p>
							<p><?= $langVals[$defLang]['answersCount'] ?></p>
						</div>
						<?php endif;?>
					</div>
					</div>
	<?php 			
					endif;
					if($cycle_number == $list_limit){
						break;
					}
					$cycle_number++;
			endforeach;
	else:
		echo '<div class="users_list_wrapper">
		<script>
			$(".opened_tag_tag_list").eq(1).css("border-bottom","solid 2px");
		</script>
		';
		foreach ($opened_tag_subscribed_uesrs_load as $user_info):
			$find_user_questions = R::find('questions','user = ?',[$user_info->user_login]);
			$find_user_answers = R::find('answers','user = ?',[$user_info->user_login]);
		?>
			<div class="user_list_block">
				<a href="index.php?page=user&user=<?=$user_info->user_id?>" id="user_list_user_image"><img src="usersfiles/<?=$user_info->user_login?>/profil.jpg"></a>
				<a href="index.php?page=user&user=<?=$user_info->user_id?>"><p id="user_list_user_name"><?=$user_info->user_name.' '.$user_info->user_surname?></p></a>
				<p id="user_list_user_answersquestions">
					<a href="index.php?page=user&user=<?=$user_info->user_id?>&user_questions"><?=count($find_user_questions)?> <?= $langVals[$defLang]['questions'] ?></a>
					<span>&#8226;</span>
					<a href="index.php?page=user&user=<?=$user_info->user_id?>&user_answers"><?=count($find_user_answers)?> <?= $langVals[$defLang]['answersCount'] ?></a>
				</p>
			</div>
	<?php
		endforeach;
	endif;
		?>
</div>
	<?php if ($opened_tag_load->questions > 15):?>
		<div class="questions_pages">
			<?php if($page_number > 1):?>
				<a href="index.php?page=tags&tag=<?=$tag?>&<?=$opened_tag_title?>&pn=<?=$page_number - 1;?>">&#8592; <?=$langVals[$defLang]['paginationPrev']?></a>
			<?php endif;
			if($page_number > 6){
				$left_page_list = $page_number - 6;
			}
			for($i = 1; $i <= $page_count; $i++):
				if($i > $left_page_list && $i <= 10 + $left_page_list):
			?>
				<a id = '<?=$i?>' href="index.php?page=tags&tag=<?=$tag?>&<?=$opened_tag_title?>&pn=<?=$i?>"><?=$i?></a>
			<?php
				endif;
			endfor;
			if($page_number < $page_count):
			?>
				<a href="index.php?page=tags&tag=<?=$tag?>&<?=$opened_tag_title?>&pn=<?=$page_number + 1;?>"><?=$langVals[$defLang]['paginationNext']?> &#8594;</a>
			<?php endif;?>
		</div>
		<script>
			$('#<?=$page_number?>').css('color','#0b2542');
		</script>
	<?php endif;?>
</div>