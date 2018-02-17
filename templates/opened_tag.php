<?php
$opened_tag_load = R::findOne('tags','tagname = ?',[$tag]);
$opened_tag_questions_load = R::find('questions','ORDER BY date DESC,time DESC');
$opened_tag_questions_load_where_check = R::find('questions','check_answer > 0');
?>
<div id='opened_tag_header_wrapper' >
<div id='opened_tag_header'>
<img src="tagimages/<?=$tag?>.png">
<p><?=$tag?></p>
<div id='opened_tag_header_about' >
    <div class='opened_tag_header_about_item'>
        <p><?=$opened_tag_load->questions?></p>
        <p class='opened_tag_header_about_item_name'>вопросов</p>
    </div>
    <div class='opened_tag_header_about_item'>
        <p><?=$opened_tag_load->subscribes?></p>
        <p class='opened_tag_header_about_item_name'>подписчиков</p>
    </div>
    <div class='opened_tag_header_about_item'>
        <p><?=(int)((count($opened_tag_questions_load_where_check) * 100) / $opened_tag_load->questions)?>%</p>
        <p class='opened_tag_header_about_item_name'>решено</p>
    </div>
</div>
<div id='opened_tag_header_subscribe_button' >
    Вы подписаны
</div>
</div>
</div>
<div id='opened_tag_tag_lists' >
    <a href="" class='opened_tag_tag_list' >Вопросы</a>
    <a href="" class='opened_tag_tag_list' >Подписчики</a>
</div>
<div class="questions">
	<?php foreach($opened_tag_questions_load as $question): 
		$opened_tag_question_tag_array = explode(',',$question->tags);
		foreach($opened_tag_question_tag_array as $tags):
			if($tags == $tag):
		?>
<div class="question">
<div class="question2">
<div class="question_information_block">
	<a href="index.php?page=question&question=12" class="question_title">Как сделать сайт за 1 час? skjdaklhdlashdsdjfh sadhdsf asdhaskfsjajksdfhjshdfjsdhf</a>
	<p class="question_information"><?=$question->views?> просмотров &#8226; <?=$question->date.' '.$question->time?></p>
</div>
<div class="question_answers">
	<div class="question_answers_wrapper">
		<p><?=$question->answers?></p>
		<p>Ответов</p>
	</div>
</div>
		</div>
			</div>
<?php 
		endif;
	endforeach;
endforeach; ?>
	<div class="questions_pages">
		<a href="#">&#8592; Предыдущий</a>
		<a href="#">1</a>
		<a href="#">2</a>
		<a href="#">3</a>
		<a href="#">4</a>
		<a href="#">5</a>
		<a href="#">Следующий &#8594;</a>
	</div>
</div>