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
setTimeout(() => {
	$('div.opened_question_question_footer_setting_image').click(function () {
		if (typeof opened_question_opened_setting_id == 'undefined') {
			opened_question_opened_setting_id = $('.opened_question_question_footer_setting_image').index(this);
			if (!opened_question_question_footer_setting_block){
				$(this).next('.opened_question_question_footer_setting_block').fadeIn(500);
				$('.opened_question_question_footer_setting_image').css('background-color','#fff');
				$(this).css('background-color','#e8e8e8');
				opened_question_question_footer_setting_block = 1;
			}else {
				$(this).next('.opened_question_question_footer_setting_block').fadeOut(200);
				$('.opened_question_question_footer_setting_image').css('background-color','#fff');
				opened_question_question_footer_setting_block = 0;
			}
		}else if ($('.opened_question_question_footer_setting_image').index(this) == opened_question_opened_setting_id) {
				$(this).next('.opened_question_question_footer_setting_block').fadeOut(200);
				$('.opened_question_question_footer_setting_image').css('background-color','#fff');
				opened_question_question_footer_setting_block = 0;
				opened_question_opened_setting_id = undefined;
		}else {
				opened_question_opened_setting_id = $('.opened_question_question_footer_setting_image').index(this);
				$('.opened_question_question_footer_setting_block').hide();
				$('.opened_question_question_footer_setting_image').css('background-color','#fff');
				opened_question_question_footer_setting_block = 0;
				if (!opened_question_question_footer_setting_block){
					$(this).next('.opened_question_question_footer_setting_block').fadeIn(500);
					$(this).css('background-color','#e8e8e8');
					opened_question_question_footer_setting_block = 1;
				}else {
					$('.opened_question_question_footer_setting_image').css('background-color','#fff');
					$(this).next('.opened_question_question_footer_setting_block').fadeOut(200);
					opened_question_question_footer_setting_block = 0;
				}
		}
	});
}, 100);
$('body').click(function (event) {
	if (event.target.id != 'opened_question_question_footer_setting_image' && event.target.className != 'opened_question_question_footer_setting_image') {
		if (opened_question_question_footer_setting_block) {
			$('.opened_question_question_footer_setting_block').fadeOut(200);
			$('.opened_question_question_footer_setting_image').css('background-color','#fff');
			opened_question_question_footer_setting_block = 0;
			opened_question_opened_setting_id = undefined;
		}
	}
});
$(document).on('touchstart',function (event) {
	if (event.target.id != 'opened_question_question_footer_setting_image' && event.target.className != 'opened_question_question_footer_setting_image') {
		if (opened_question_question_footer_setting_block) {
			$('.opened_question_question_footer_setting_block').fadeOut(200);
			$('.opened_question_question_footer_setting_image').css('background-color','#fff');
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
					success: function () {
						$('.editor_textarea').eq(indexToAddComment).val('');
						var commentsCount = $('.answers_comments_count').eq(indexCommentsWrapper).text();
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


//Opened question page script end not Vue
Vue.component('hc-editor',{
	props:{
		i: String,
		changer:Boolean,
		content: String,
		answerid: Number
	},
    data: function () {
      return{
		  index: this.i,
      }  
    },
    template: `<div id='editor_wrapper'>
    <div class='editor_buttons_block' >
        <div id='editor_buttons_wrapper'>
            <div @mouseout='mouseOut' @mouseover='mouseOver'  @click='bold' class='editor_button bold' title='Жирный' >
                <img class='editor_button_img' src="HCeditor/HCeditorimg/bold.svg" alt="Жирный" />
            </div>
            <div @mouseout='mouseOut' @mouseover='mouseOver' @click='italic' class='editor_button italic' title='Курсивный'  >
                <img class='editor_button_img' src="HCeditor/HCeditorimg/italic.svg" alt="Курсивный" />
            </div>
            <div @mouseout='mouseOut' @mouseover='mouseOver' @click='link' class='editor_button link' title='Ссылка' >
                <img class='editor_button_img' src="HCeditor/HCeditorimg/link.svg" alt="Ссылка" />
            </div>
            <div @mouseout='mouseOut' @mouseover='mouseOver' @click='superscript' class='editor_button superscript' title='Степень' >
                <img class='editor_button_img' src="HCeditor/HCeditorimg/superscript.svg" alt="Степень" />
            </div>
            <div @mouseout='mouseOut' @mouseover='mouseOver' @click='subscript' class='editor_button subscript' title='Индекс' >
                <img class='editor_button_img' src="HCeditor/HCeditorimg/subscript.svg" alt="Индекс" />
            </div>
            <!--***********-->
            <div @mouseout='mouseOut' @mouseover='mouseOver' @click='img' class='editor_button image' title='Изображение' >
                <div class='image_after' >
                    <img class='editor_button_img' src="HCeditor/HCeditorimg/picture.svg" alt="Изображение" />
                </div>
                <div class='image_button_list' >
                    <label for="uploadFile"><p class='image_local' >С компьютера </p></label>
                    <p @click='from_internet' class='image_internet' >Из интернета</p>
                </div>
            </div>
            <!--***********-->
            <div @mouseout='mouseOut' @mouseover='mouseOver' @click='list' class='editor_button list' title='Список' >
                <div class='list_after' >
                    <img class='editor_button_img' src="HCeditor/HCeditorimg/list.svg" alt="Список" />
                </div>
                <div class='ol_button_list'>
                    <p @click='ol' class ='ol'>Нумерованный</p>
                    <p @click='ul' class='ul'>Маркированный</p>
                </div>
            </div>
        </div>
    </div>
		<textarea name='HCeditor' @keydown='HCeditor' class="editor_textarea" @focus='focus' @focusout='focusOut' >{{content}}</textarea>
		<p id='HCeditor_error'></p>
        <textarea name="HCeditorContent" class="HCeditorcopy">{{content}}</textarea>
		<input @change='file' type="file"  class='file' id="uploadFile" />
		<div v-if='changer' id='edit_answer_buttons_wrapper'>
		<p @click='save' id='edit_answer_button' >Изменить</p>
		<p id='edit_answer_cancel' @click='close' >Отменить</p>
		</div>
</div>`,
methods:{
    bold(){
		closeDropdown();
        bold(this.index);
    },
    italic(){
		closeDropdown();
        italic(this.index);
    },
    link(){
		closeDropdown();
        link(this.index);
    },
    superscript(){
		closeDropdown();
        superscript(this.index);
    },
    subscript(){
		closeDropdown();
        subscript(this.index);
    },
    img(){
        image(this.index);
    },
    list(){
        list(this.index);
    },
    focus(){
        editorFocus(this.index);
    },
    focusOut(){
        editorFocusOut(this.index);
    },
    mouseOver(){
        $('.editor_button').mouseover(function () {
            var e = $('.editor_button').index(this);
            editorButtonMouseOver(e); 
        });
	},
	mouseOut(){
        if(!openedListList && !openedListImg){
            $('.editor_button').css('background-color','transparent');
        }
	},
	HCeditor(){
		HCeditor(this.index);
	},
	close(){
		this.$emit('changer');
	},
	file(){
		file(this.index);
	},
	from_internet(){
		image_internet(this.index);
	},
	ol(){
		ol(this.index);
	},
	ul(){
		ul(this.index);
	},
	save(){
		var answerId = this.answerid,answerContent=$('.HCeditorcopy').eq(this.index).val(),Index=this.index,element=this;
		$.ajax({
			type: "post",
			url: "templates/edit_answer.php",
			data: {answerId:answerId,editAnswerContent:answerContent},
			dataType: "html",
			cache: false,
			success: function () {
				$('.block_for_switch_edit_answer').eq(Index).html(answerContent.replace(/\n/g, "<br />"));
				element.$emit('changer');
			}
		});
	}
}
});
const vues = document.querySelectorAll(".hc-editor");
const each = Array.prototype.forEach;
each.call(vues, (el) => new Vue({
	el,
	data:{
		show:false
	}
}));

new Vue({
	el:'#opened_question_question_add_answer',
});
//Opened question page script end with Vue