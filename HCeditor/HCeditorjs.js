var endTextLength,readyText,e;
function init_hceditor(id,classes){
  $('head').append('<link rel="stylesheet" href="HCeditor/HCeditor.css">');
  function HCeditor(index) {
      tagLength = 0;
      setTimeout(() => {
          var sendToFunText = $('.editor_textarea').eq(index).val();
          readyText = selectionTagsInText(sendToFunText);
          $('.HCeditorcopy').eq(index).val(readyText);
          endTextLength = readyText.length - tagLength;
      }, 100);
  }
  var tagLength = 0;
  //Начало функции htmlspecialchars
  function htmlspecialchars(text) {
              return text
              .replace(/&/g, "&amp;")
              .replace(/</g, "&lt;")
              .replace(/>/g, "&gt;")
              .replace(/"/g, "&quot;")
              .replace(/'/g, "&#039;");
          }
  //Конец функции htmlspecialchars

  //Начало функции рандомный строки
  function randomHash() {
      var text = "";
      var possible = "0123456789";

      for (var i = 0; i < 20; i++){
          text += possible.charAt(Math.floor(Math.random() * possible.length));
      }
      return text;
  }
  //Конец функции рандомный строки

  //Начало функции для обработки тегов
  function setTag(tag) {
      var checkTag = tag;
      if(tag[tag.length - 1] == '<'){
          tag = '';
          for(var i = 0; i < checkTag.length - 1; i++ ){
              tag += checkTag[i];
          }
          tag = htmlspecialchars(tag);
      }else if(tag[1] == ' '){
          tag = htmlspecialchars(tag);
      }else if(tag[1] == 'b'){
          tag = '<b>';
      }else if(tag[1] == 'i'){
          if(tag[2] != 'm'){
              tag = '<i>';
          }else if(tag[3] =='g'){
              var imageSrc = '',closedSrc = false;
              for(var i = 0; i < tag.length; i++){
              if(tag[i] == '"' || tag[i] == '\''){
                  i++;
                  for(i; i < tag.length; i++){
                      if(tag[i] == '"' || tag[i] == '\''){
                          closedSrc = true;
                      }
                      if(!closedSrc){
                          imageSrc += tag[i];
                      }
                  }
              }
          }
          imageSrc = imageSrc.replace(/\s/g, '');
          if(!imageSrc){
              tag = '';
          }else{
              tag = '<img src="'+imageSrc+'">';
          }
          }else{
              tag = '';
          }
      }else if(tag[1] == 'a'){
          //Здесь мы должные брать внутри href
          var anchorHref = '',closedHref = false;
          for(var i = 0; i < tag.length; i++){
              if(tag[i] == '"' || tag[i] == '\''){
                  i++;
                  for(i; i < tag.length; i++){
                      if(tag[i] == '"' || tag[i] == '\''){
                          closedHref = true;
                      }
                      if(!closedHref){
                          anchorHref += tag[i];
                      }
                  }
              }
          }
          anchorHref = anchorHref.replace(/\s/g, '');
          if(!anchorHref){
              tag = '';
          }else{
              tag = '<a href="'+anchorHref+'">';
          }
      }else if(tag[1] == '\\'){
          tag = htmlspecialchars(tag);
      }else if(tag[1] == '\/'){
          tag = tag;
      }else if(tag[1] == 's'){
          if(tag[2] == 'u'){
              if(tag[3] == 'b'){
                  tag = '<sub>';
              }else if(tag[3] == 'p'){
                  tag = '<sup>';
              }else{
                  tag = '';
              }
          }else{
              tag = '';
          }
      }else if(tag[1] == 'u'){
          if(tag[2] == 'l'){
              tag = '<ul>';
          }else{
              tag = '';
          }
      }else if(tag[1] == 'o'){
          if(tag[2] == 'l'){
              tag = '<ol>';
          }else{
              tag = '';
          }
      }else if(tag[1] == 'l'){
          if(tag[2] == 'i'){
              tag = '<li>';
          }else{
              tag = '';
          }
      }else{
          tag = htmlspecialchars(tag);
      }
      tagLength += tag.length;
      return tag;
  }

  //Конец функции для обработки тегов
  $('.editor_textarea').on('keydown',function () {
      e = $('.editor_textarea').index(this);
      HCeditor(e);
  });
  //Начало функции для отбора тегов с текста
  function selectionTagsInText(text) {
      var textReturn = '',openedTagNum,closedTagNum,openedTag = false,openedTagNumfor,closedTag = false,tag = '',closedTagReverse = false;
      for(var i = 0; i < text.length; i++){
              if(text[i] == '<'){
                          tag = '<';
                          openedTag = true;
                          openedTagNum = i+1;
                          closedTag = false;
                          openedTagNumfor = openedTagNum;
                      for(openedTagNumfor; openedTagNumfor < text.length; openedTagNumfor++){
                          if(!closedTag){
                              tag += text[openedTagNumfor];
                              if(text[openedTagNumfor] == '>'){
                                  closedTagNum = openedTagNumfor;
                                  closedTag = true;
                              }else if(text[openedTagNumfor] == '<'){
                                  closedTagNum = openedTagNumfor;
                                  closedTag = true;
                                  closedTagReverse = true;
                              }
                          }
                      }
                      if(closedTag){
                          textReturn += setTag(tag);
                      }else{
                          closedTagNum = openedTagNumfor;
                          textReturn += htmlspecialchars(tag);
                      }
              }else if(text[i] == '>'){
                  if(i > closedTagNum || !closedTag){
                      openedTag = true;
                      closedTagNum = i;
                      textReturn += '&gt;';
                  }
              }
          if(!openedTag){
              textReturn += text[i];
          }else{
              if(i > closedTagNum){
                  openedTag = false;
                  textReturn += text[i];
              }
          }
      }
      return textReturn;
  }
  //Конец функции для отбора тегов с текста


      // Start set caret position
      function setSelectionRange(input, selectionStart, selectionEnd) {
          if (input.setSelectionRange) {
              input.focus();
              input.setSelectionRange(selectionStart, selectionEnd);
          } else if (input.createTextRange) {
              var range = input.createTextRange();
              range.collapse(true);
              range.moveEnd('character', selectionEnd);
              range.moveStart('character', selectionStart);
              range.select();
          }
      }
      function setCaretToPos(input, pos) {
          setSelectionRange(input, pos, pos);
      }
      // End set caret position

      // setCaretToPos($("#test")[0], 5);  Сама функция смены позиции
  var openedListImg = false,openedListList = false;
  $(document).click(function (event) {
      if(event.target.className != 'image_after' && event.target.className != 'editor_button_img'){
          $('.image').css('background-color','transparent');
          $('.image_button_list').hide();
          openedListImg = false;
      }
      if(event.target.className != 'list_after' && event.target.className != 'editor_button_img'){
          $('.list').css('background-color','transparent');
          $('.ol_button_list').hide();
          openedListList = false;
      }
  });
  function closeDropdown() {
      $('.image').css('background-color','transparent');
      $('.image_button_list').hide();
      openedListImg = false;
      $('.list').css('background-color','transparent');
      $('.ol_button_list').hide();
      openedListList = false;
  }
  // Start Functions for Edit

  //---- Bold
  function bold(e) {
      var caretpos,oldText = $('.editor_textarea').eq(e).val(),newText = '';
      caretpos = $('.editor_textarea').eq(e).prop("selectionStart");
      for(i = 0; i < caretpos; i++){
          newText += oldText[i];
      }
      newText += '<b></b>';
      for(i; i < oldText.length; i++){
          newText += oldText[i];
      }
      $('.editor_textarea').eq(e).val(newText);
      setCaretToPos($('.editor_textarea').eq(e)[0],caretpos+3);
  }

  // ---- Italic
  function italic(e) {
      var caretpos,oldText = $('.editor_textarea').eq(e).val(),newText = '';
      caretpos = $('.editor_textarea').eq(e).prop("selectionStart");
      for(i = 0; i < caretpos; i++){
          newText += oldText[i];
      }
      newText += '<i></i>';
      for(i; i < oldText.length; i++){
          newText += oldText[i];
      }
      $('.editor_textarea').eq(e).val(newText);
      setCaretToPos($('.editor_textarea').eq(e)[0],caretpos+3);
  }
  //---- Link
  function link(e) {
      var link = prompt('Введите URL ссылки:','http://');
      if(link != ''){
          var caretpos,oldText = $('.editor_textarea').eq(e).val(),newText = '';
      caretpos = $('.editor_textarea').eq(e).prop("selectionStart");
      for(i = 0; i < caretpos; i++){
          newText += oldText[i];
      }
      newText += '<a href="'+link+'"></a>';
      for(i; i < oldText.length; i++){
          newText += oldText[i];
      }
      $('.editor_textarea').eq(e).val(newText);
      setCaretToPos($('.editor_textarea').eq(e)[0],caretpos+11+link.length);
      }else{
          $('.editor_textarea').eq(e).focus(this);
      }
  }
  //---- Superscript
  function superscript(e) {
      var caretpos,oldText = $('.editor_textarea').eq(e).val(),newText = '';
      caretpos = $('.editor_textarea').eq(e).prop("selectionStart");
      for(i = 0; i < caretpos; i++){
          newText += oldText[i];
      }
      newText += '<sup></sup>';
      for(i; i < oldText.length; i++){
          newText += oldText[i];
      }
      $('.editor_textarea').eq(e).val(newText);
      setCaretToPos($('.editor_textarea').eq(e)[0],caretpos+5);
  }

  //---- Subscript
  function subscript(e) {
      var caretpos,oldText = $('.editor_textarea').eq(e).val(),newText = '';
      caretpos = $('.editor_textarea').eq(e).prop("selectionStart");
      for(i = 0; i < caretpos; i++){
          newText += oldText[i];
      }
      newText += '<sub></sub>';
      for(i; i < oldText.length; i++){
          newText += oldText[i];
      }
      $('.editor_textarea').eq(e).val(newText);
      setCaretToPos($('.editor_textarea').eq(e)[0],caretpos+5);
  }

  //---- List
  function list(e) {
      if(openedListImg){
          $('.image_button_list').hide();
          $('.image').css('background-color','transparent');
          openedListImg = false;
      }
      $('.ol_button_list').hide();
          $('.list').css('background-color','transparent');
          openedListList = false;
      if(!openedListList){
          $('.list').eq(e).css('background-color','#eff0f1');
          $('.ol_button_list').eq(e).fadeIn(500);
          openedListList = true;
      }else{
          $('.list').eq(e).css('background-color','transparent');
          $('.ol_button_list').eq(e).fadeOut();
          openedListList = false;
      }
  }

  //---- Ol
  function ol(e){
      var caretpos,oldText = $('.editor_textarea').eq(e).val(),newText = '';
      caretpos = $('.editor_textarea').eq(e).prop("selectionStart");
      for(i = 0; i < caretpos; i++){
          newText += oldText[i];
      }
      newText += '<ol>\n\t<li></li>\n</ol>';
      for(i; i < oldText.length; i++){
          newText += oldText[i];
      }
      $('.editor_textarea').eq(e).val(newText);
      setCaretToPos($('.editor_textarea').eq(e)[0],caretpos+10);
  }

  //--- Ul
  function ul(e) {
      var caretpos,oldText = $('.editor_textarea').eq(e).val(),newText = '';
      caretpos = $('.editor_textarea').eq(e).prop("selectionStart");
      for(i = 0; i < caretpos; i++){
          newText += oldText[i];
      }
      newText += '<ul>\n\t<li></li>\n</ul>';
      for(i; i < oldText.length; i++){
          newText += oldText[i];
      }
      $('.editor_textarea').eq(e).val(newText);
      setCaretToPos($('.editor_textarea').eq(e)[0],caretpos+10);
  }

  //---- Image
  function image(e) {
      if(openedListList){
          $('.ol_button_list').hide();
          $('.list').css('background-color','transparent');
          openedListList = false;
      }
      $('.image_button_list').hide();
          $('.image').css('background-color','transparent');
          openedListImg = false;
      //----------------
      if(!openedListImg){
          $('.image').eq(e).css('background-color','#eff0f1');
          $('.image_button_list').eq(e).fadeIn(500);
          openedListImg = true;
      }else{
          $('.image').eq(e).css('background-color','transparent');
          $('.image_button_list').eq(e).fadeOut();
          openedListImg = false;
      }
  }
  //---- Image from internet
  function image_internet(e) {
      var link = prompt('Введите URL картины:','http://');
      if(link != '' && link != null){
      var caretpos,oldText = $('.editor_textarea').eq(e).val(),newText = '';
      caretpos = $('.editor_textarea').eq(e).prop("selectionStart");
      for(i = 0; i < caretpos; i++){
          newText += oldText[i];
      }
      newText += '<img src="'+link+'">';
      for(i; i < oldText.length; i++){
          newText += oldText[i];
      }
      $('.editor_textarea').eq(e).val(newText);
      setCaretToPos($('.editor_textarea').eq(e)[0],caretpos+12+link.length);
      }
  }

  //---- File
  function file(e) {
      $('.editor_textarea').eq(e).attr('disabled');
      var file_name = randomHash();
      var file_data = $('.file').prop('files')[0];
      var form_data = new FormData();
      var profil = authLogin;
      form_data.append('file', file_data);
      form_data.append('imgName',file_name);
      form_data.append('profil',profil);
      $.ajax({
              url: 'templates/uploadImage.php', // point to server-side PHP script
              dataType: 'html',  // what to expect back from the PHP script, if anything
              cache: false,
              contentType: false,
              processData: false,
              data: form_data,
              type: 'post',
              success: function () {
                  $('.editor_textarea').eq(e).removeAttr('disabled');
              }
      });
      link = 'usersfiles/'+profil+'/images/'+file_name+'.jpg';
      var caretpos,oldText = $('.editor_textarea').eq(e).val(),newText = '';
      caretpos = $('.editor_textarea').eq(e).prop("selectionStart");
      for(i = 0; i < caretpos; i++){
          newText += oldText[i];
      }
      newText += '<img src="'+link+'">';
      for(i; i < oldText.length; i++){
          newText += oldText[i];
      }
      $('.editor_textarea').eq(e).val(newText);
      setCaretToPos($('.editor_textarea').eq(e)[0],caretpos+19+link.length);
      HCeditor(e);
  }

  //---- Editor Focus
  function editorFocus(e){
      $('.editor_textarea').eq(e).css('border-color','#077fcc');
      $('.editor_buttons_block').css('border-bottom-color','#eee');
     $('.editor_buttons_block').eq(e).css('border-bottom-color','#077fcc');
     if(openedListImg){
          $('#image_button_list').hide();
          openedListImg = false;
          $('#image').css('background-color','transparent');
      }
      if(openedListList){
          $('#list').css('background-color','transparent');
          $('#ol_button_list').hide();
          openedListList = false;
      }
  }
  //---- Editor Focusout
  function editorFocusOut(e){
    $('.editor_textarea').eq(e).css('border-color','#eee');
    $('.editor_buttons_block').css('border-bottom-color','#eee');
  }
  //--- Editor Buttons Mouse Over
  function   editorButtonMouseOver(e){
      if(!openedListList && !openedListImg){
          $('.editor_button').css('background-color','transparent');
          $('.editor_button').eq(e).css('background-color','#eff0f1');
      }
  }
  //---- Editor Buttons Mouse Out
  function editorButtonMouseOut(){
      if(!openedListList && !openedListImg){
          $('.editor_button').css('background-color','transparent');
      }
  }
  //End Functions for Edit


  // VUEJS
  Vue.component('hc-editor',{
  	props:{
  		i: String,
  		changer:Boolean,
  		content: String,
        answerid: Number,
        required: Boolean,
        minlength: Number 
  	},
      data: function () {
        return{
            index: this.i,
            interfaceLanguage: interfaceLang
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
                      <label :for="'uploadFile'+index"><p class='image_local' >С компьютера </p></label>
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
          <textarea v-if='required' :minlength="this.minlength" required name='HCeditor' @keydown='HCeditor' class="editor_textarea" @focus='focus' @focusout='focusOut' >{{content}}</textarea>
          <textarea v-else name='HCeditor' @keydown='HCeditor' :minlength="this.minlength" class="editor_textarea" @focus='focus' @focusout='focusOut' >{{content}}</textarea>
  		<p id='HCeditor_error'></p>
          <textarea  v-if='required' :minlength="this.minlength" required @keydown='security' name="HCeditorContent" class="HCeditorcopy">{{content}}</textarea>
          <textarea  v-else :minlength="this.minlength" @keydown='security' name="HCeditorContent" class="HCeditorcopy">{{content}}</textarea>
  		<input @change='file' type="file"  class='file' :id="'uploadFile'+index" style="display:none;" />
  		<div v-if='changer' id='edit_answer_buttons_wrapper' class='edit_buttons_wrapper'>
  		<p @click='save' id='edit_answer_button' class='edit_button' >Изменить</p>
  		<p id='edit_answer_cancel' class='edit_cancel' @click='close' >Отменить</p>
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
    security(){
        setTimeout(function(){
            $('.HCeditorcopy').val('');
        },200);
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
  			url: "library/ajaxEditer.php",
  			data: {table:"answers",edit_id:answerId,answer_content:answerContent},
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
  // Если хотите на одном блоке вывести несколько редакторов - Начало
  if (classes) {
    const vues = document.querySelectorAll("."+classes);
    const each = Array.prototype.forEach;
    each.call(vues, (el) => new Vue({
    	el,
    	data:{
    		show:false
    	}
    }));
  }
  // Если хотите на одном блоке вывести несколько редакторов - Конец
  new Vue({
  	el:'#'+id,
  });
}