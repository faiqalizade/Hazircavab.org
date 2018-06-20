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
				opened_question_question_footer_setting_block = 1;
			}else {
				$(this).next('.opened_question_question_footer_setting_block').fadeOut(200);
				opened_question_question_footer_setting_block = 0;
			}
		}else if ($('.opened_question_question_footer_setting_image').index(this) == opened_question_opened_setting_id) {
				$(this).next('.opened_question_question_footer_setting_block').fadeOut(200);
				opened_question_question_footer_setting_block = 0;
				opened_question_opened_setting_id = undefined;
		}else {
				opened_question_opened_setting_id = $('.opened_question_question_footer_setting_image').index(this);
				$('.opened_question_question_footer_setting_block').hide();
				opened_question_question_footer_setting_block = 0;
				if (!opened_question_question_footer_setting_block){
					$(this).next('.opened_question_question_footer_setting_block').fadeIn(500);
					opened_question_question_footer_setting_block = 1;
				}else {
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
			opened_question_question_footer_setting_block = 0;
			opened_question_opened_setting_id = undefined;
		}
	}
});
$(document).on('touchstart',function (event) {
	if (event.target.id != 'opened_question_question_footer_setting_image' && event.target.className != 'opened_question_question_footer_setting_image') {
		if (opened_question_question_footer_setting_block) {
			$('.opened_question_question_footer_setting_block').fadeOut(200);
			opened_question_question_footer_setting_block = 0;
			opened_question_opened_setting_id = undefined;
		}
	}
});
$('#opened_question_question_add_answer_submit').click(function () {
	if(endTextLength > 5){
    	$('#add_answer_form').submit(); 
	}
});
var openedAnswerCommenting = 0;
$('.opened_question_question_answer_comment_button').click(function () {
	var indexComment = $('.opened_question_question_answer_comment_button').index(this);
	if(!openedAnswerCommenting){
		$('.opened_question_answer_comment_wrapper').eq(indexComment).fadeIn();
		openedAnswerCommenting = 1;
	}else{
		$('.opened_question_answer_comment_wrapper').eq(indexComment).fadeOut();
		openedAnswerCommenting = 0;
	}
});
$('.opened_question_answer_comment_send_button').click(function () {
	console.log($('.opened_question_answer_comment_send_button').index(this));
});


//Opened question page script end not Vue


Vue.component('hc-editor',{
	props:{
		i: String,
		changer:Boolean,
		content: String,
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
                    <p class='image_internet' >Из интернета</p>
                </div>
            </div>
            <!--***********-->
            <div @mouseout='mouseOut' @mouseover='mouseOver' @click='list' class='editor_button list' title='Список' >
                <div class='list_after' >
                    <img class='editor_button_img' src="HCeditor/HCeditorimg/list.svg" alt="Список" />
                </div>
                <div class='ol_button_list'>
                    <p class ='ol'>Нумерованный</p>
                    <p class='ul'>Маркированный</p>
                </div>
            </div>
        </div>
    </div>
		<textarea name='HCeditor' @keydown='HCeditor' class="editor_textarea" @focus='focus' @focusout='focusOut' >{{content}}</textarea>
		<p id='HCeditor_error'></p>
        <textarea name="HCeditorContent" class="HCeditorcopy">{{content}}</textarea>
		<input @change='file' type="file"  class='file' id="uploadFile" />
		<div v-if='changer' id='edit_answer_buttons_wrapper'>
		<p id='edit_answer_button' >Изменить</p>
		<p id='edit_answer_cancel' @click='close' >Отменить</p>
		</div>
</div>`,
methods:{
    bold(){
        bold(this.index);
    },
    italic(){
        italic(this.index);
    },
    link(){
        link(this.index);
    },
    superscript(){
        superscript(this.index);
    },
    subscript(){
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