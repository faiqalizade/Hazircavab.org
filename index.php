<?php
$page = $_GET['page'];
$blog = $_GET['blog'];
$opened_user_profile = $_GET['user'];
$tag = $_GET['tag'];
$profile = $_GET['profile'];
$opened_question = $_GET['question'];
$accaunt = $_GET['password'];
$activate_accaunt = $_GET['activate_code'];
$like_answer = $_GET['like'];
$unlike_answer = $_GET['unlike'];
$check_answer = $_GET['check'];
$uncheck_answer = $_GET['uncheck'];
$remove_answer = $_GET['remove_answer'];
$list_page_number = $_GET['pn'];
$query = $_GET['q'];
require 'db.php';
require 'header_title.php';
 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Hazir Cavab</title>
		<script src="jquery-3.2.1.js"></script>
		<link rel="stylesheet" class='style' href="">
		<link class="stylecss" rel="stylesheet" href="">
		<script>
		$(document).ready(function() {
			$('.style').attr('href','style.css');
			if ($(window).width() < 1200 && $(window).width() > 1022) {
			$(document).ready(function () {
				$('#article_on_1200').css({'transition':'margin .5s'});
				$('.content').css({'transition':'margin .5s'});
			});
			$('.stylecss').attr('href','style1200-1024.css');
		}else if ($(window).width() <= 1022 && $(window).width() > 765 ) {
			$(document).ready(function () {
				$('#article_on_1200').css({'transition':'margin .5s'});
				$('.content').css({'transition':'margin .5s'});
			});
			$('.stylecss').attr('href','style1024_765.css');
		}else if ($(window).width() <= 765) {
			$(document).ready(function () {
				$('#article_on_1200').css({'transition':'margin .5s'});
				$('.content').css({'transition':'margin .5s'});
			});
			$('.stylecss').attr('href','style765-0.css');
		}
		$('body').css('display','block');
		$('#article_on_1200').height($('.wrapper').height());
		function setcookie ( name, value, path, exp_y, exp_m, exp_d, exp_h , exp_m , domain, secure ){
   	 var cookie_string = name + "=" + escape ( value );

    if ( exp_y )
    {
      var expires = new Date ( exp_y, exp_m, exp_d, exp_h , exp_m );
      cookie_string += "; expires=" + expires.toGMTString();
    }

    if ( path )
          cookie_string += "; path=" + escape ( path );

    if ( domain )
          cookie_string += "; domain=" + escape ( domain );

    if ( secure )
          cookie_string += "; secure";

    document.cookie = cookie_string;
  }
  function deletecookie ( cookie_name ){
    var date = new Date;
    date.setDate(date.getDate() - 5);
    document.cookie = cookie_name +'=; path=/; expires='+date.toUTCString();
  }
  function getcookie ( cookie_name ){
    var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );

    if ( results )
      return ( unescape ( results[2] ) );
    else
      return null;
  }
  if (getcookie('opened') == null) {
	  first_time();
  }
		});
		</script>
		<link rel="shortcut icon" href="images/Logoicon.jpg" type="image/jpg">
		<meta name="viewport" content="width=device-width"/>
	</head>
	<body style='display:none;'>
		<div id='first_time_guide_block'>
			<div id='first_time_guide'>
				<div id='first_time_guide_content' >
				<div id='first_time_guide_change_lang_block'>
				<p id='first_time_guide_change_langg' >Изменить язык?</p>
				<div id='first_time_guide_change_lang_wrapper' >
				<p id='first_time_guide_change_lang_lang'>Az</p>
				<p id='first_time_guide_change_lang_cancel'>Нет, спасибо</p>
			</div>
				</div>
				<div id='first_time_guide_lang_setting' class='first_time_guide_blocks'>
					<p class='first_time_guide_titles' >Вы всегда сможете изменить язык в настройках профиля</p>
					<img id='first_time_guide_lang_setting_img' src="images/first_time_guide_lang.jpg">
				</div>
				<div class='first_time_guide_blocks' id='first_time_guide_end_block'>
					<p id='first_time_guide_end_title' >Список вопросов прост: Заголовок вопроса, просмотры,время добавления, количество ответов(<b>если цвет зелёный это знак того что среди ответов есть правильный</b>)</p>
					<img id='first_time_guide_before_end_image' src="images/first_time_guide_question_list.jpg">
				</div>
				<div class='first_time_guide_blocks'>
					<p class='first_time_guide_end_title'>Начинаем...</p>
					<p id='first_time_guide_end_desc'>Подробнее вы можете найти на <a href="index.php?page=about">этой</a> странице</p>
				</div>
				</div>
			<div id='first_time_guide_next_button_wrapper' >
				<p id='first_time_guide_next_button' >Вперёд</p>
			</div>
			</div>
		</div>
			<article>
				<div class="article_content">
					<div class="sidebar_logo_block">
						<a href="index.php" id="sidebar_logo_link"><img id="sidebar_logo" src="images/Logo2.0white.svg" alt="Home"></a>
					</div>
					<div class="article_links_block">
						<a href="index.php?page=blog" class="article_links"><img src="images/blog.svg">Блог</a>
						<a href="index.php?page=questions&new" class="article_links"><img src="images/question-sign.svg"> Все вопросы</a>
						<a href="index.php?page=users" class="article_links"><img src="images/users.svg">Пользователи</a>
						<a href="index.php?page=tags" class="article_links"><img src="images/tags.svg">Все теги</a>
						<a href="index.php?page=het" class="article_links"><img src="images/book.svg">Готовые домашние задания</a>
						<a href="index.php?page=services" class="article_links"><img src="images/calculator.svg">Сервисы</a>
					</div>
				</div>
				<div class="article_footer">
					<p style="text-align:center; font-size:1.1em; margin-bottom: 7%;">Hazırcavab - Вопросы и ответы</p>
					<p style="text-align:center; font-size:.8em; color:#b9b4b4">Здесь вы можете найти ответы на вопросы по любой теме из любых областей.</p>
					<a href="#" class="article_footer_about_button">Далее &#8594;</a>
				</div>
			</article>
			<div id="article_on_1200">
			<div class="article_links_block">
						<a href="index.php?page=blog" class="article_links"><img src="images/blog.svg">Блог</a>
						<a href="index.php?page=questions&new" class="article_links"><img src="images/question-sign.svg"> Все вопросы</a>
						<a href="index.php?page=users" class="article_links"><img src="images/users.svg">Пользователи</a>
						<a href="index.php?page=tags" class="article_links"><img src="images/tags.svg">Все теги</a>
						<a href="index.php?page=het" class="article_links"><img src="images/book.svg">Готовые домашние задания</a>
						<a href="index.php?page=services" class="article_links"><img src="images/calculator.svg">Сервисы</a>
					</div>
			</div>
			<div class="wrapper">
				<div class="content">
					<header>
						<div class="main_page_header_wrapper">
							<div class="main_page_header_menu_block">
								<img src="images/menu.svg">
							</div>
							<div class="main_page_header_logo_block">
								<a href="index.php"><img id="main_page_header_logo" src="images/Logo2.0white.svg"></a>
							</div>
							<div class="search_input_block">
								<input id="search_input" autocomplete="off" type="text" placeholder="Поиск" name="Search">
								<div id='find'>

								</div>
							</div>
						</div>
						<div class="header_search">
							<a href="#"> <img src="images/search.svg"></a>
						</div>
						<div class="header_login">
						<?php if ($cookie_checked):?>
						<a href='index.php?page=user&user=<?=$user_infos->id?>' id='user_logined_header_name'><?=$user_infos->name.' '.$user_infos->surname?></a>
						<a id='user_logined_header_block' href="index.php?page=user&user=<?=$user_infos->id?>"><img src="usersfiles/<?=$user_infos->login?>/profil.png"></a>
						<?php else:?>
						<a href="index.php?page=login"><img src="images/avatar.svg"></a>
						<a href="index.php?page=login" id="header_login_button">Войти</a>
						<?php endif;?>
						</div>
					</header>

<div class="content_after_header">
<div class="main_page">
	<?php
	 require 'templates/page.php';
	//  R::selectDatabase('DB2');
	//  $test = R::find('admin');
	//  var_dump($test);
	 ?>
</div>
<?php 
if ($page != 'adminKabinet') {
	require 'templates/ads.php'; 
}else {
	echo "
	<script>
	$('.main_page').css('width','97%');
</script>
";
}
?>
					</div>
				</div>
				<?php require 'templates/footer.php'; ?>
			</div>
	</body>
</html>
<script>
	$('#search_input').on('keydown',function (e) {
		if(e.which == 13){
			setTimeout(() => {
				if($('#search_input').val().length > 0){
					document.location = 'index.php?page=q&q='+$('#search_input').val();
				}
			}, 100);
		}
		setTimeout(() => {
			if($('#search_input').val().length > 0){
				$('#find').css('display','block');
				$('#findQuestions').remove();
				$('#findTags').remove();
				$('#findUsers').remove();
				var typedText = $('#search_input').val();
				$.ajax({
					url: 'templates/find.php',
					type: 'post',
					cache: false,
					dataType: 'html',
					data: ({findText:typedText}),
					success: function (data) {
						$('#notFound').remove();
						$('#find').append(data);
					}
				});
			}else{
				$('#findQuestions').remove();
				$('#findTags').remove();
				$('#findUsers').remove();
				$('#notFound').remove();
				$('#find').css('display','none');
			}
		}, 3000);
	});
</script>
<script src="main.js" defer></script>