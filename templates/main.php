
<div class="main_page_header">
	<p id="main_page_title">Все вопросы</p>
</div>
<div class="main_page_header_after">
	<div class="question_list">
		<a href="#" class="question_list_titles">Новые</a>
		<a href="#" class="question_list_titles">Популярные</a>
		<a href="#" class="question_list_titles">Без ответа</a>
	</div>
	<?php if($cookie_checked):?>
	<div class="add_question">
		<a href="index.php?page=addquestion" id="add_question_button"> <span>Задать вопрос</span> <img id="add_image" src="images/add.png"> </a>
	</div>
<?php endif;?>
</div>
<div class="questions">
	<?php for($i = 0; $i <= 19; $i++ ): ?>
<div class="question">
<div class="question2">
<div class="question_information_block">
	<a href="index.php?page=question&question=12" class="question_title">Как сделать сайт за 1 час? skjdaklhdlashdsdjfh sadhdsf asdhask asd asdkasdj asdl fsjajksdfhjshdfjsdhf</a>
	<p class="question_information">1212 просмотров &#8226; 15 мин. назад</p>
</div>
<div class="question_answers">
	<div class="question_answers_wrapper">
		<p>15</p>
		<p>Ответов</p>
	</div>
</div>
		</div>
			</div>
	<?php endfor; ?>
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
<?php require 'templates/main_page_blog.php';?>
