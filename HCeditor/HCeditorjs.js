    var endTextLength,readyText,e;
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
        
    $('.bold').click(function () {
        e = $('.bold').index(this);
        bold(e);
    });

    $('.image_internet').click(function(){
        e = $('.image_internet').index(this);
        image_internet(e);
    });
    $('.file').change(function () {
        e = $('.file').index(this);
        file(e);
    });

    $('.italic').click(function(){
        e = $('.italic').index(this);
        italic(e);
    });
    $('.superscript').click(function(){
        e = $('.superscript').index(this);
        superscript(e);
        });

    $('.subscript').click(function(){
        e = $('.subscript').index(this);
        subscript(e);
    });
    $('.link').click(function(){
        e = $('.link').index(this);
        link(e);
    });

    var openedListImg = false,openedListList = false;
    $('.image').click(function () {
        e = $('.image').index(this);
        image(e);
    });
    $('.list_after').click(function () {
        e = $('.list_after').index(this);
        list(e);
    });

    $('.ol').click(function(){
        e = $('.ol').index(this);
        ol(e);
    });

    $('.ul').click(function(){
        e = $('.ul').index(this);
        ul(e);
    });

    $('.editor_textarea').focus(function () {
        e = $('.editor_textarea').index(this);
        editorFocus(e);
    });

    $('.editor_textarea').focusout(function () {
       e = $('.editor_textarea').index(this);
       editorFocusOut(e);
    });

    $('.editor_button').mouseover(function () {
        var e = $('.editor_button').index(this);
        editorButtonMouseOver(e);
    });
    $('.editor_button').mouseout(function () {
        editorButtonMouseOut();
    });

    $(document).click(function (event) {
        if(event.target.className != 'image' && event.target.className != 'editor_button_img'){
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
            $('.list').eq(e).css('background-color','#2a2f4213');
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
            $('.image').eq(e).css('background-color','#2a2f4213');
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
        var profil = 'test';
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
        link = 'usersfiles/'+profil+'/images/'+file_name+'.png';
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
            $('.editor_button').eq(e).css('background-color','#2a2f4213');
        }
    }
    //---- Editor Buttons Mouse Out
    function editorButtonMouseOut(){
        if(!openedListList && !openedListImg){
            $('.editor_button').css('background-color','transparent');
        }
    }
    //End Functions for Edit