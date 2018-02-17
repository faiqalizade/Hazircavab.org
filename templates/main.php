
<div class="main_page_header">
	<p id="main_page_title">Все вопросы</p>
</div>
<div class="main_page_header_after">
	<div class="question_list">
		<a href="index.php?page=questions&new" class="question_list_titles">Новые</a>
		<a href="index.php?page=questions&popular" class="question_list_titles">Популярные</a>
		<a href="index.php?page=questions&notanswer" class="question_list_titles">Без ответа</a>
	</div>
	<?php
	if(isset($_GET['new'])){
		$question_list = R::find('questions','ORDER BY date DESC,time DESC');
		echo "
		<script>
		$('.question_list_titles').eq(0).attr('id','opened_question_page');
		</script>
		";
	}elseif(isset($_GET['popular'])){
		$question_list = R::find('questions','ORDER BY views DESC, date DESC,time DESC');
		echo "
		<script>
		$('.question_list_titles').eq(1).attr('id','opened_question_page');
		</script>
		";
	}elseif(isset($_GET['notanswer'])){
		$question_list = R::find('questions','answers = 0 ORDER BY date,time DESC');
		echo "
		<script>
		$('.question_list_titles').eq(2).attr('id','opened_question_page');
		</script>
		";
	}else{
		$question_list = R::find('questions','ORDER BY date DESC,time DESC');
		echo "
		<script>
		$('.question_list_titles').eq(0).attr('id','opened_question_page');
		</script>
		";
	}
	if($cookie_checked):?>
	<div class="add_question">
		<a href="index.php?page=addquestion" id="add_question_button"> <span>Задать вопрос</span> <img id="add_image" src="images/add.png"> </a>
	</div>
<?php endif;?>
</div>
<div class="questions">
	<?php foreach($question_list as $question):
		$tagsarray = explode(',',$question->tags);
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
	<p class="question_information"><?=$question->views?> просмотров &#8226; <?=$question->date.' '.$question->time?></p>
</div>
<div class="question_answers">
	<?php if($question->check_answer > 0):?>
	<div class="question_answers_wrapper check">
		<p><?=$question->answers?></p>
		<p>Ответов</p>
	</div>
	<?php else:?>
	<div class="question_answers_wrapper">
		<p><?=$question->answers?></p>
		<p>Ответов</p>
	</div>
	<?php endif;?>
</div>
		</div>
			</div>
<?php endforeach;
	if(count($question_list) > 15):
?>
		<div class="questions_pages">
			<a href="#">&#8592; Предыдущий</a>
			<a href="#">1</a>
			<a href="#">2</a>
			<a href="#">3</a>
			<a href="#">4</a>
			<a href="#">5</a>
			<a href="#">Следующий &#8594;</a>
		</div>
<?php endif;?>
</div>
<?php require 'templates/main_page_blog.php';?>
