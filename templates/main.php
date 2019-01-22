
<?php
if(!isset($list_page_number)){
	$page_number = 1;
}else{
	$page_number = $list_page_number;
}
$list_limit_last = ($page_number - 1) * 15;
$list_limit = $page_number * 15;
?>
<div class="main_page_header">
	<p id="main_page_title"><?= $langVals[$defLang]['allQuestions'] ?></p>
</div>
<div class="main_page_header_after">
	<div class="question_list">
		<a href="index.php?page=questions&new" class="question_list_titles"><?php echo (isset($defLang)) ? $langVals[$defLang]['new'] : $langVals['ru']['new'] ?></a>
		<a href="index.php?page=questions&popular" class="question_list_titles"><?php echo (isset($defLang)) ? $langVals[$defLang]['popular'] : $langVals['ru']['popular'] ?></a>
		<a href="index.php?page=questions&notanswer" class="question_list_titles"><?= $langVals[$defLang]['notAnswered'] ?></a>
	</div>
	<?php
	if(isset($_GET['new'])){
		$question_list = R::find('questions','ORDER BY date DESC,time DESC');
		$order_question = 'new';
		echo "
		<script>
		$('.question_list_titles').eq(0).attr('id','opened_question_page');
		</script>
		";
	}elseif(isset($_GET['popular'])){
		$question_list = R::find('questions','ORDER BY views DESC, date DESC,time DESC');
		$order_question = 'popular';
		echo "
		<script>
		$('.question_list_titles').eq(1).attr('id','opened_question_page');
		</script>
		";
	}elseif(isset($_GET['notanswer'])){
		$question_list = R::find('questions','answers = 0 ORDER BY date,time DESC');
		$order_question = 'notanswer';
		echo "
		<script>
		$('.question_list_titles').eq(2).attr('id','opened_question_page');
		</script>
		";
	}else{
		$question_list = R::find('questions','ORDER BY date DESC,time DESC');
		$order_question = 'new';
		echo "
		<script>
		$('.question_list_titles').eq(0).attr('id','opened_question_page');
		</script>
		";
	}
	$page_count = count($question_list) / 15;
	if(is_float($page_count)){
		$page_count++;
	}
	settype($page_count,'int');
	if($page_number > $page_count && $page_count > 0 || $page_number <= 0){
		echo "
		<script>
		window.location = 'index.php';
		</script>
		";
	}
	if($cookie_checked):?>
	<div class="add_question">
		<a href="index.php?page=addquestion" id="add_question_button"> <span><?= $langVals[$defLang]['askQusetions'] ?></span> <img id="add_image" src="images/add.png"> </a>
	</div>
<?php endif;?>
</div>
<div class="questions">
	<?php
	$cycle_number = 0;
	foreach($question_list as $question):
		$tagsarray = explode(',',$question->tags);
		if($cycle_number >= $list_limit_last && $cycle_number < $list_limit):
		?>
<div class="question">
<div class="question2">
<div class="question_information_block">
	<div class='question_tags_wrapper' >
	<a href="index.php?page=question&question=<?=$question->id?>"><img src="tagimages/<?=$tagsarray[0]?>.png"></a>
	<a href="index.php?page=question&question=<?=$question->id?>" class='question_tags' ><?=$tagsarray[0]?></a>
	<?php if(count($tagsarray) > 1):?>
	<a href="index.php?page=question&question=<?=$question->id?>" class='question_tags_more_tags'> &nbsp; и ещё <?=count($tagsarray) - 1?></a>
	<?php endif;?>
	</div>
	<a href="index.php?page=question&question=<?=$question->id?>" class="question_title"><?=$question->title?></a>
	<p class="question_information"><?=$question->views?> <i class="fas fa-eye"></i> &#8226; <?=$question->date.' '.$question->time?></p>
</div>
<div class="question_answers">
	<?php
	if($question->check_answer != ','):?>
	<div class="question_answers_wrapper check">
		<p><?=$question->answers?></p>
		<p><?= $langVals[$defLang]['answersCount'] ?></p>
	</div>
	<?php else:?>
	<div class="question_answers_wrapper">
		<p><?=$question->answers?></p>
		<p><?= $langVals[$defLang]['answersCount'] ?></p>
	</div>
	<?php endif;?>
</div>
		</div>
			</div>
<?php
	endif;
	if($cycle_number == $list_limit){
		break;
	}
	$cycle_number++;
endforeach;
	if(count($question_list) > 15):
?>
		<div class="questions_pages">
			<?php if($page_number > 1):?>
				<a href="index.php?page=questions&<?=$order_question?>&pn=<?=$page_number - 1;?>">&#8592; <?=$langVals[$defLang]['paginationPrev']?></a>
			<?php endif;
			if($page_number > 6){
				$left_page_list = $page_number - 6;
			}
			for($i = 1; $i <= $page_count; $i++):
				if($i > $left_page_list && $i <= 10 + $left_page_list):
			?>
				<a id = '<?=$i?>' href="index.php?page=questions&<?=$order_question?>&pn=<?=$i?>"><?=$i?></a>
			<?php
				endif;
			endfor;
			if($page_number < $page_count):
			?>
				<a href="index.php?page=questions&<?=$order_question?>&pn=<?=$page_number + 1;?>"><?=$langVals[$defLang]['paginationNext']?> &#8594;</a>
			<?php endif;?>
		</div>
		<script>
		$('#<?=$page_number?>').css('color','#0b2542');
		</script>
<?php endif;?>
</div>
<?php require 'templates/main_page_blog.php';?>