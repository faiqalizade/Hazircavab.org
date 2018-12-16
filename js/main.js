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
		$('.main_page_header_menu_block').css('background-color','#4f5a6e');
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
		$(this).css('background-color','#4f5a6e');
	}
});
var window_width = $(window).width();
$(window).resize(function () {
	if ($(window).width() < 1200 && $(window).width() > 1022) {
		$('.stylecss').attr('href','css/style1200-1024.css');
		setTimeout(function () {
			$('.content').css('transition','margin .5s');
        }, 600);
        $('.wrapper').css('display','flex');
		$('.mobileModeFind').css('display','none');
	}else if ($(window).width() <= 1022 && $(window).width() > 765 ) {
		$('.stylecss').attr('href','css/style1024_765.css');
		setTimeout(function () {
			$('.content').css('transition','margin .5s');
        }, 600);
        $('.wrapper').css('display','flex');
		$('.mobileModeFind').css('display','none');
	}else if ($(window).width() <= 765) {
		$('.stylecss').attr('href','css/style765-0.css');
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
        $('.wrapper').css('display','flex');
		$('.mobileModeFind').css('display','none');
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

//Opened question page script start


$('.opened_question_question_content > a').attr('target','blank');
$('.opened_question_question_answer_content > a').attr('target','blank');
var opened_question_question_footer_setting_block = 0,opened_question_opened_setting_id;
function openDropMenu(element) {
	if (typeof opened_question_opened_setting_id == 'undefined') {
		opened_question_opened_setting_id = $('.opened_question_question_footer_setting_image').index(element);
		if (!opened_question_question_footer_setting_block){
			$(element).next('.opened_question_question_footer_setting_block').fadeIn(500);
			$('.opened_question_question_footer_setting_image').css('background-color','transparent');
			$(element).css('background-color','#e8e8e8');
			opened_question_question_footer_setting_block = 1;
		}else {
			$(element).next('.opened_question_question_footer_setting_block').fadeOut(200);
			$('.opened_question_question_footer_setting_image').css('background-color','transparent');
			opened_question_question_footer_setting_block = 0;
		}
	}else if ($('.opened_question_question_footer_setting_image').index(element) == opened_question_opened_setting_id) {
			$(element).next('.opened_question_question_footer_setting_block').fadeOut(200);
			$('.opened_question_question_footer_setting_image').css('background-color','transparent');
			opened_question_question_footer_setting_block = 0;
			opened_question_opened_setting_id = undefined;
	}else {
			opened_question_opened_setting_id = $('.opened_question_question_footer_setting_image').index(element);
			$('.opened_question_question_footer_setting_block').hide();
			$('.opened_question_question_footer_setting_image').css('background-color','transparent');
			opened_question_question_footer_setting_block = 0;
			if (!opened_question_question_footer_setting_block){
				$(element).next('.opened_question_question_footer_setting_block').fadeIn(500);
				$(element).css('background-color','#e8e8e8');
				opened_question_question_footer_setting_block = 1;
			}else {
				$('.opened_question_question_footer_setting_image').css('background-color','transparent');
				$(element).next('.opened_question_question_footer_setting_block').fadeOut(200);
				opened_question_question_footer_setting_block = 0;
			}
	}
}

function removeComment(element) {
	var
	commentIndex				= $('.remove_button_comment').index(element)
	commentId					= $('.remove_button_comment').eq(commentIndex).attr('commentId')
	count						= $(element).closest('.opened_question_question_answer').find('.answers_comments_count').text() ;
	count = parseInt(count);
	count--;
	$(element).closest('.opened_question_question_answer').find('.answers_comments_count').text(count);
	$(element).closest('.opened_question_comment_to_answer_wrapper').hide();
	$.ajax({
		type: "post",
		url: "templates/deleteCommentToAnswer.php",
		data: {comment:commentId},
		dataType: "html",
		success: function (data) {

		}
	});
}
setTimeout(() => {
	$('div.opened_question_question_footer_setting_image').click(function () {
		openDropMenu(this);
	});
}, 100);
$('body').click(function (event) {
	if (event.target.id != 'opened_question_question_footer_setting_image' && event.target.className != 'opened_question_question_footer_setting_image') {
		if (opened_question_question_footer_setting_block) {
			$('.opened_question_question_footer_setting_block').fadeOut(200);
			$('.opened_question_question_footer_setting_image').css('background-color','transparent');
			opened_question_question_footer_setting_block = 0;
			opened_question_opened_setting_id = undefined;
		}
	}
});
$(document).on('touchstart',function (event) {
	if (event.target.id != 'opened_question_question_footer_setting_image' && event.target.className != 'opened_question_question_footer_setting_image') {
		if (opened_question_question_footer_setting_block) {
			$('.opened_question_question_footer_setting_block').fadeOut(200);
			$('.opened_question_question_footer_setting_image').css('background-color','transparent');
			opened_question_question_footer_setting_block = 0;
			opened_question_opened_setting_id = undefined;
		}
	}
});
setTimeout(() => {
	$('#opened_question_question_add_answer_submit').click(function () {
		if(endTextLength > 5){
			$('#add_answer_form').submit();
		}
	});
	var openedAnswerCommenting = 0,indexOpenedAnswerComment;
$('.opened_question_question_answer_comment_button').click(function () {
	var indexComment = $('.opened_question_question_answer_comment_button').index(this);
	if(indexComment == indexOpenedAnswerComment){
		$('.opened_question_answer_comment_wrapper').eq(indexComment).slideUp(500);
		openedAnswerCommenting = 0;
		indexOpenedAnswerComment = undefined;
	}else{
		$('.opened_question_answer_comment_wrapper').hide();
		$('.opened_question_answer_comment_wrapper').eq(indexComment).slideDown(500);
		indexOpenedAnswerComment = indexComment;
	}
});
$('.opened_question_comment_to_answer_reply_bttn').click(function () {
		var
		indexEditor 			= $(this).attr('answerEditorIndex'),
		userName				= $(this).attr('user');
		userName 				= '@'+userName+',';
		$('.editor_textarea').eq(indexEditor).val(userName);
		$('.HCeditorcopy').eq(indexEditor).val(userName);
		setCaretToPos($('.editor_textarea').eq(indexEditor)[0],userName.length);
});


$('.remove_button_comment').click(function () {
	removeComment(this);
});

$('.opened_question_comment_to_answer_like_bttn').click(function () {
	var
	likeButtonIndex				= $('.opened_question_comment_to_answer_like_bttn').index(this)
	likesCount					= $('.comments_to_answer_count').eq(likeButtonIndex).text()
	commentId					= $(this).attr('commentId') ;
	likesCount = parseInt(likesCount);
	if($(this).attr('liked') == 'false'){
		likesCount++;
		$('.comments_to_answer_like_text').eq(likeButtonIndex).text('Не нравиться');
		$('.comments_to_answer_count').eq(likeButtonIndex).text(likesCount);
		$(this).attr('liked','true');
		$.ajax({
			type: "post",
			url: "templates/likeComment.php",
			data: {comment:commentId,user:authId},
			dataType: "html",
			success: function (data) {

			}
		});
	}else{
		$('.comments_to_answer_like_text').eq(likeButtonIndex).text('Нравиться');
		likesCount--;
		$('.comments_to_answer_count').eq(likeButtonIndex).text(likesCount);
		$(this).attr('liked','false');
		$.ajax({
			type: "post",
			url: "templates/unLikeComment.php",
			data: {comment:commentId,user:authId},
			dataType: "html",
			success: function () {
			}
		});
	}
});
$('.opened_question_answer_comment_send_button').click(function () {
	var
	indexToAddComment		= $(this).attr('indexEditorComment'),
	contentToAddComment		= $('.HCeditorcopy').eq(indexToAddComment).val()
	answerIdToComment 		= $(this).attr('answerId'),
	indexCommentsWrapper	= $('.opened_question_answer_comment_send_button').index(this)  ;
	contentToAddComment = contentToAddComment.trim();
	var replyToUserComment = '';
		if(contentToAddComment[0] == '@'){
			for(var i=1; i < contentToAddComment.length; i++){
				if(contentToAddComment[i] != ',' ){
					replyToUserComment += contentToAddComment[i];
				}else{
					break;
				}
			}
			$.ajax({
				type: "post",
				url: "templates/answerCommentUserfind.php",
				data: {user:replyToUserComment},
				dataType: "html",
				success: function (data) {
					var arr = data.split(',');
					if(arr[0] == 'true'){
						contentToAddComment = "<a href='index.php?page=user&user="+arr[1]+"' class='answer_comment_reply'>"+replyToUserComment+"</a>"+contentToAddComment.substring(i);
					}else{
						replyToUserComment = '';
					}
				}
			});
		}
		setTimeout(() => {
			if(contentToAddComment.length - replyToUserComment.length > 5){
				$.ajax({
					type: "post",
					url: "templates/addCommentToAnswer.php",
					data: {answer:answerIdToComment,comment:contentToAddComment,user:authLogin,replyto:replyToUserComment},
					dataType: "html",
					success: function (data) {
						$('.editor_textarea').eq(indexToAddComment).val('');
						var
						commentsCount 		= $('.answers_comments_count').eq(indexCommentsWrapper).text()
						lastId				= data ;
						commentsCount = parseInt(commentsCount);
						commentsCount++;
						$('.answers_comments_count').eq(indexCommentsWrapper).text(commentsCount);
						var
						today				= new Date(),
						day					= today.getDate(),
						mounth				= today.getMonth()+1,
						year				= today.getFullYear(),
						hours				= today.getHours(),
						minutes				= today.getMinutes(),
						seconds				= today.getSeconds();
						if(day < 10) {
							day = '0'+day;
						}
						if(mounth < 10) {
							mounth = '0'+mounth;
						}
						if(seconds < 10) {
							seconds = '0'+seconds;
						}
						if(hours < 10) {
							hours = '0'+hours;
						}
						if(minutes < 10) {
							minutes = '0'+minutes;
						}
						today = day+'.'+mounth+'.'+year+' - '+hours+':'+minutes+':'+seconds;
						var commentAddBlock = `
						<div class='opened_question_comment_to_answer_wrapper'>
						<div class='opened_question_comment_to_answer_image_user'>
							<a href='index.php?page=user&user`+authId+`'><img src='usersfiles/`+authLogin+`/profil.png' class='opened_question_comment_to_answer_image'></a>
						</div>
						<div class='opened_question_comment_to_answer_content_wrapper'>
							<div class='opened_question_comment_to_answer_user_infos'>
								<a href='index.php?page=user&user`+authId+`' class='opened_question_comment_to_answer_user' >`+authName+`</a> <a href='index.php?page=user&user`+authId+`' class='opened_question_comment_to_answer_username' >@`+authLogin+`</a>
							</div>
							<div class='opened_question_comment_to_answer_content'>
							`+contentToAddComment.replace(/\n/g, "<br />")+`
							</div>
							<div class='opened_question_comment_to_answer_footer'>
								<p class='opened_question_comment_to_answer_date'>`+ today +`</p>
								<p class='opened_question_comment_to_answer_like_bttn'>Нравиться (0)</p>
								<p class='opened_question_comment_to_answer_reply_bttn'>Ответить</p>
								<div class="opened_question_question_footer_setting_block_wrapper">
									<div onclick='openDropMenu(this)' class="opened_question_question_footer_setting_image">
										<img src="images/3pointsilver.svg" id="opened_question_question_footer_setting_image">
									</div>
									<div class="opened_question_question_footer_setting_block">
										<a onclick='removeComment(this)' commentId='`+lastId+`' class="opened_question_question_footer_setting_delete remove_button_comment">Удалить</a>
									</div>
								</div>
							</div>
						</div>
					</div>`;
						$('.opened_question_answer_comments').eq(indexCommentsWrapper).append(commentAddBlock);
					}
				});
			}
		}, 100);
});
}, 100);
