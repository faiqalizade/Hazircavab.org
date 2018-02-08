$(document).ready(function(){
	var opened_article_on_1200 = false;
$('.main_page_header_menu_block').click(function () {
	$('#article_on_1200').css('visibility','visible');
	if (!opened_article_on_1200) {
		$('#article_on_1200').css('margin','0');
		$('.main_page_header_menu_block').css('background-color','#7080b1');
		$('.content').css('margin-left','260px');
		opened_article_on_1200 = true;
	}else {
		$('#article_on_1200').css('margin-left','-260px');
		$('.content').css('margin-left','0');
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
		$('.stylecss').attr('href','style1200-1024.css');
		setTimeout(function () {
			$('.content').css('transition','margin .5s');
		}, 600);
	}else if ($(window).width() <= 1022 && $(window).width() > 765 ) {
		$('.stylecss').attr('href','style1024_765.css');
		setTimeout(function () {
			$('.content').css('transition','margin .5s');
		}, 600);
	}else if ($(window).width() <= 765) {
		$('.stylecss').attr('href','style765-0.css');
		setTimeout(function () {
			$('.content').css('transition','margin .5s');
		}, 600);
	}else if ($(window).width() >= 1200) {
		$('.content').css('margin-left','')
		$('.content').css('transition','none');
		$('.stylecss').attr('href','');
		$('.main_page_header_menu_block').css('background-color','#516174');
		opened_article_on_1200 = false;
		$('#article_on_1200').css('margin-left','-260px');
		$('.content').css('margin-left','0');
		$('.main_page_header_menu_block').css('background-color','#516174');
	}
	$('#article_on_1200').height($('.wrapper').height());
});
});
function first_time() {

	$('#first_time_guide_block').css('display','flex');
	function getcookie ( cookie_name ){
		var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
	
		if ( results )
		  return ( unescape ( results[2] ) );
		else
		  return null;
	  }
	function setcookie ( name, value, path, exp_y, exp_m, exp_d, exp_h ,domain, secure ){
   	 var cookie_string = name + "=" + escape ( value );

    if ( exp_y )
    {
      var expires = new Date (exp_y,exp_m);
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
  if (getcookie('language') == null) {
	$('#first_time_guide_change_lang_block').fadeIn(1000);
	$('#first_time_guide_change_lang_block').css('display','flex');
	$('#first_time_guide_change_lang_cancel').click(function () {
		setcookie('language','ru','/',2030,0);
		$('#first_time_guide_change_lang_block').fadeOut(500);
		setTimeout(() => {
			languageFind();
		}, 500);
	});
  }else{
	  languageFind();
  }
  function languageFind() {
	$('.first_time_guide_blocks').css('display','none');
	var guideIndexNumber = 0;
	$('#first_time_guide_change_lang_block').css('display','none');
	$('#first_time_guide_next_button_wrapper').css('display','flex');
	$('#first_time_guide_lang_setting').fadeIn(1000);
	$('#first_time_guide_lang_setting').css('display','flex');
	$('#first_time_guide_next_button').click(function () {
		if (guideIndexNumber == 1) {
			$('#first_time_guide_next_button_wrapper').css('display','none');
			setTimeout(() => {
				$('#first_time_guide_block').fadeOut(1000);
				setcookie('opened',1,'/',2030,0);
			}, 5000);
			$('#first_time_guide_end_desc a').click(function () {
				$('#first_time_guide_block').fadeOut(1000);
				setcookie('opened',1,'/',2030,0);
			});
		}
		if (guideIndexNumber != 2) {
			$('.first_time_guide_blocks').eq(guideIndexNumber).fadeOut(500);
			guideIndexNumber++;
			setTimeout(() => {
				$('.first_time_guide_blocks').eq(guideIndexNumber).fadeIn(1000);
				if (guideIndexNumber == 1) {
					$('#first_time_guide_end_block').css('display','flex');
				}
			}, 500);
		}
	});
}
}