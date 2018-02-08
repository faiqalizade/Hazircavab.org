<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Hazir Cavab</title>
		<script src="../jquery-3.2.1.js"></script>
		<link rel="stylesheet" href="../style.css">
		<link class="stylecss" rel="stylesheet" href="">
		<script>
		if ($(window).width() < 1200 && $(window).width() > 1022) {
			$(document).ready(function () {
				$('#article_on_1200').css({'transition':'margin .5s'});
				$('.wrapper').css({'transition':'margin .5s'});
			});
			$('.stylecss').attr('href','../style1200-1024.css');
		}else if ($(window).width() <= 1022 && $(window).width() > 765 ) {
			$(document).ready(function () {
				$('#article_on_1200').css({'transition':'margin .5s'});
				$('.wrapper').css({'transition':'margin .5s'});
			});
			$('.stylecss').attr('href','../style1024_765.css');
		}else if ($(window).width() <= 765) {
			$(document).ready(function () {
				$('#article_on_1200').css({'transition':'margin .5s'});
				$('.content').css({'transition':'margin .5s'});
			});
			$('.stylecss').attr('href','../style765-0.css');
		}
		</script>
		<link rel="shortcut icon" href="../images/Logoicon.jpg" type="image/jpg">
		<meta name="viewport" content="width=device-width"/>
	</head>
	<body>
			<article>
				<div class="article_content">
					<div class="sidebar_logo_block">
						<a href="#" id="sidebar_logo_link"><img id="sidebar_logo" src="../images/Logo2.0white.svg" alt="Home"></a>
					</div>
					<div class="article_links_block">
						<a href="index.php?page=blog" class="article_links"><img src="../images/blog.png">Блог</a>
						<a href="#" class="article_links"><img src="../images/question-sign.png"> Все вопросы</a>
						<a href="#" class="article_links"><img src="../images/users.png">Пользователи</a>
						<a href="#" class="article_links"><img src="../images/tags.svg">Все теги</a>
						<a href="#" class="article_links"><img src="../images/book.png">Готовые домашние задания</a>
						<a href="#" class="article_links"><img src="../images/calculator.svg">Сервисы</a>
					</div>
				</div>
				<a href="../" style="float:left; width:100%; text-align:center; color: #fff; font-family: 'Exo 2'; padding-bottom: 2%;">RU</a>
				<div class="article_footer">
					<p style="text-align:center; font-size:1.1em; margin-bottom: 7%;">Hazırcavab - Вопросы и ответы</p>
					<p style="text-align:center; font-size:.8em; color:#b9b4b4">Здесь вы можете найти ответы на вопросы по любой теме из любых областей.</p>
					<a href="#" class="article_footer_about_button">Далее &#8594;</a>
				</div>
			</article>
			<div id="article_on_1200">
saasd
			</div>
			<div class="wrapper">
				<div class="content">
					<header>
						<div class="main_page_header_wrapper">
							<div class="main_page_header_menu_block">
								<img src="../images/menu.svg">
							</div>
							<div class="main_page_header_logo_block">
								<a href="#"><img id="main_page_header_logo" src="../images/Logo2.0white.svg"></a>
							</div>
							<div class="search_input_block"><input id="search_input" type="text" placeholder="Поиск" name="Search"></div>
						</div>
						<div class="header_search">
							<a href="#"> <img src="../images/search.svg"></a>
						</div>
						<div class="header_login">
							<a href="#"><img src="../images/avatar.svg"></a>
							<p id="header_login_button">Войти</p>
						</div>
					</header>
					<div class="content_after_header">
<div class="main_page">
	<div class="main_page_header">
		<p id="main_page_title">Все вопросы</p>
	</div>
	<div class="main_page_header_after">
		<div class="question_list">
			<a href="#" class="question_list_titles">Новые</a>
			<a href="#" class="question_list_titles">Популярные</a>
			<a href="#" class="question_list_titles">Без ответа</a>
		</div>
		<div class="add_question">
			<a href="#" id="add_question_button"> <span>Задать вопрос</span> <img id="add_image" src="../images/add.png"> </a>
		</div>
	</div>
	<div class="questions">
		<?php for($i = 0; $i <= 19; $i++ ): ?>
<div class="question">
	<div class="question2">
	<div class="question_information_block">
		<a href="#" class="question_title">Как сделать сайт за 1 час? skjdaklhdlashdsdjfh sadhdsf asdhaskfsjajksdfhjshdfjsdhf</a>
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

	<div class="blog_page">
		<p class="blog_page_header">Блог - Новые статьи <a href="#" class="blog_page_header_link">Все статьи</a> </p>
		<div class="blog_page_newblogs">
			<?php for($i=0;$i < 3; $i++): ?>
				<div class="blog_article">
					<img class="blog_article_image" src="../images/blog1.jpg">
					<div class="blog_article_info">
						<p id="blog_article_info_header"> <a href="#">Sual</a> </p>
						<p>1213 Просмотров &#8226; 12 Коментарий</p>
					</div>
				</div>
			<?php endfor; ?>
		</div>
	</div>

	<div class="">

	</div>
</div>

<div class="ads_page_right_sidebar">
	asdasd
</div>
					</div>
				</div>

				<footer>
					<div class="footer_abouts">
						<a href="#">&copy; AF</a>
						<a href="#">О Сайте</a>
						<a href="#">Контакты</a>
					</div>
					<div class="footer_socials">
						<a href="#"><img class="footer_soical_icons" src="../images/instagram-logo.png"></a>
						<a href="#"><img class="footer_soical_icons" src="../images/facebook-logo.png"></a>
					</div>
				</footer>
			</div>
	</body>
</html>
<!-- <script>
CKEDITOR.replace( 'test', {
    filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=../images',
    filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
} );
</script> -->
<script>
var wrapper_height = $('.wrapper').height();
var opened_article_on_1200 = false;
$('#article_on_1200').height(wrapper_height);
$('.main_page_header_menu_block').click(function () {
	if (!opened_article_on_1200) {
		$('#article_on_1200').css('margin','0');
		$('.main_page_header_menu_block').css('background-color','#7080b1');
		$('.wrapper').css('margin-left','260px');
		opened_article_on_1200 = true;
	}else {
		$('#article_on_1200').css('margin-left','-260px');
		$('.wrapper').css('margin-left','0');
		$('.main_page_header_menu_block').css('background-color','#516174');
		opened_article_on_1200 = false;
	}
});
$('.main_page_header_menu_block').mouseover(function () {
	if (!opened_article_on_1200) {
		$(this).css('background-color','#64728c');
	}
});
$('.main_page_header_menu_block').mouseout(function () {
	if (!opened_article_on_1200) {
		$(this).css('background-color','#516174');
	}
});
var window_width = $(window).width();
$(window).resize(function () {
	if ($(window).width() < 1200 && $(window).width() > 1022) {
		$('.stylecss').attr('href','../style1200-1024.css');
		setTimeout(function () {
			$('.wrapper').css('transition','margin .5s');
		}, 600);
	}else if ($(window).width() <= 1022 && $(window).width() > 765 ) {
		$('.stylecss').attr('href','../style1024_765.css');
		setTimeout(function () {
			$('.wrapper').css('transition','margin .5s');
		}, 600);
	}else if ($(window).width() <= 765) {
		$('.stylecss').attr('href','../style765-0.css');
		setTimeout(function () {
			$('.wrapper').css('transition','margin .5s');
		}, 600);
	}else if ($(window).width() >= 1200) {
		$('.wrapper').css('margin-left','')
		$('.wrapper').css('transition','none');
		$('.stylecss').attr('href','');
		$('#article_on_1200').css('margin-left','-260px');
		$('.main_page_header_menu_block').css('background-color','#516174');
		opened_article_on_1200 = false;
	}
});
</script>
