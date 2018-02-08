<script>
$(document).ready(function () {
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
                console.log('salan');
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

    <?php if($page == 'addquestion'): ?>
        $('#add_question_send_button,#add_question_send_button2').click(function () {
            if($('.add_question_send_button').css('cursor') == 'pointer'){
                tagLength = 0;
                var sendToFunText = $('#editor_textarea').val();
                var readyText = selectionTagsInText(sendToFunText);
                if(readyText.length - tagLength <= 30){
                    //Здесь должны вывести ошибку
                    $('#HCeditor_error').text('Минимальная длина текста: 30, максимальная: 10 000');
                }else{
                    $.ajax({
                            url: 'templates/check_sent_tags.php',
                            type: 'post',
                            cache: false,
                            dataType: 'html',
                            data: ({checkTag:tagInputArr}),
                            success: function (data) {
                                if(data.length > 0){
                                    tagInputArr = data.split(',');
                                    if(tagInputArr.length <= 5){
                                        $('#question_tags_error').text('');
                                        $('#question_tags').val(tagInputArr.join(','));
                                        $('#HCeditor_error').text('');
                                        $('#HCeditorcopy').val(readyText);
                                        $('#add_question_form').submit();
                                    }else{
                                        $('#question_tags_error').text('Невозможно указать более пяти тегов');
                                    }
                                }else{
                                    $('#question_tags_error').text('Необходимо указать один из существующих тегов');
                                }
                            }
                    });
                }
            }
        });

        $('#add_question_preview_edit').click(function () {
            $('#add_question_form_wrapper').css('display','block');
            $('#add_question_preview_wrapper').css('display','none');
        });
        $('#add_question_preview_button').click(function () {
            if($('.add_question_send_button').css('cursor') == 'pointer'){
                tagLength = 0;
                var sendToFunText = $('#editor_textarea').val();
                var readyText = selectionTagsInText(sendToFunText);
                if(readyText.length - tagLength <= 30){
                    //Здесь должны вывести ошибку
                    $('#HCeditor_error').text('Минимальная длина текста: 30, максимальная: 10 000');
                }else{
                    $.ajax({
                            url: 'templates/check_sent_tags.php',
                            type: 'post',
                            cache: false,
                            dataType: 'html',
                            data: ({checkTag:tagInputArr}),
                            success: function (data) {
                                if(data.length > 0){
                                    tagInputArr = data.split(',');
                                    if(tagInputArr.length <= 5){
                                        $('#question_tags_error').text('');
                                        $('#question_tags').val(tagInputArr.join(','));
                                        $('#HCeditor_error').text('');
                                        $('#HCeditorcopy').val(readyText);
                                        $('#add_question_form_wrapper').css('display','none');
                                        $('#add_question_preview_wrapper').css('display','block');
                                        $('#add_question_preview_tags_img').attr('src','tagimages/'+tagInputArr[0].toLowerCase()+'.png');
                                        $('#add_question_preview_tags').html(tagInputArr.join("  &#8226;  "));
                                        $('#add_question_preview_title').text($('#question_title').val());
                                        $('#add_question_preview_content').html(readyText.replace(/(?:\r\n|\r|\n)/g, '<br/>'));
                                    }else{
                                        $('#question_tags_error').text('Невозможно указать более пяти тегов');
                                    }
                                }else{
                                    $('#question_tags_error').text('Необходимо указать один из существующих тегов');
                                }
                            }
                    });
                }
            }
        });
    <?php else:?>

    $('#add_question_send_button,#add_question_send_button2').click(function () {
            if($('.add_question_send_button').css('cursor') == 'pointer'){
                tagLength = 0;
                var sendToFunText = $('#editor_textarea').val();
                var readyText = selectionTagsInText(sendToFunText);
                if(readyText.length - tagLength <= 30){
                    //Здесь должны вывести ошибку
                    $('#HCeditor_error').text('Минимальная длина текста: 30, максимальная: 10 000');
                }else{
                    $('#HCeditor_error').text('');
                    $('#HCeditorcopy').val(readyText);
                    $('#add_question_form').submit();
                }
            }
        });
    <?php endif;?>
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


    $('#bold').click(function(){
        var caretpos,oldText = $('#editor_textarea').val(),newText = '';
        caretpos = $('#editor_textarea').prop("selectionStart");
        for(i = 0; i < caretpos; i++){
            newText += oldText[i];
        }
        newText += '<b></b>';
        for(i; i < oldText.length; i++){
            newText += oldText[i];
        }
        $('#editor_textarea').val(newText);
        setCaretToPos($('#editor_textarea')[0],caretpos+3);
    });

    $('#image_internet').click(function(){
        var link = prompt('Введите URL картины:','http://');
        if(link != '' && link != null){
        var caretpos,oldText = $('#editor_textarea').val(),newText = '';
        caretpos = $('#editor_textarea').prop("selectionStart");
        for(i = 0; i < caretpos; i++){
            newText += oldText[i];
        }
        newText += '<img src="'+link+'">';
        for(i; i < oldText.length; i++){
            newText += oldText[i];
        }
        $('#editor_textarea').val(newText);
        setCaretToPos($('#editor_textarea')[0],caretpos+12+link.length);
        }
    });

    $('#file').change(function () {
        $('#editor_textarea').attr('disabled');
        var file_name = randomHash();
        var file_data = $('#file').prop('files')[0];
        var form_data = new FormData();
        var profil = '<?=$user_infos->login?>';
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
                    $('#editor_textarea').removeAttr('disabled');
                }
        });
        link = 'usersfiles/'+profil+'/images/'+file_name+'.png';
        var caretpos,oldText = $('#editor_textarea').val(),newText = '';
        caretpos = $('#editor_textarea').prop("selectionStart");
        for(i = 0; i < caretpos; i++){
            newText += oldText[i];
        }
        newText += '<img src="'+link+'">';
        for(i; i < oldText.length; i++){
            newText += oldText[i];
        }
        $('#editor_textarea').val(newText);
        setCaretToPos($('#editor_textarea')[0],caretpos+19+link.length);
    });

    $('#italic').click(function(){
        var caretpos,oldText = $('#editor_textarea').val(),newText = '';
        caretpos = $('#editor_textarea').prop("selectionStart");
        for(i = 0; i < caretpos; i++){
            newText += oldText[i];
        }
        newText += '<i></i>';
        for(i; i < oldText.length; i++){
            newText += oldText[i];
        }
        $('#editor_textarea').val(newText);
        setCaretToPos($('#editor_textarea')[0],caretpos+3);
    });
    $('#superscript').click(function(){
        var caretpos,oldText = $('#editor_textarea').val(),newText = '';
        caretpos = $('#editor_textarea').prop("selectionStart");
        for(i = 0; i < caretpos; i++){
            newText += oldText[i];
        }
        newText += '<sup></sup>';
        for(i; i < oldText.length; i++){
            newText += oldText[i];
        }
        $('#editor_textarea').val(newText);
        setCaretToPos($('#editor_textarea')[0],caretpos+5);
    });

    $('#subscript').click(function(){
        var caretpos,oldText = $('#editor_textarea').val(),newText = '';
        caretpos = $('#editor_textarea').prop("selectionStart");
        for(i = 0; i < caretpos; i++){
            newText += oldText[i];
        }
        newText += '<sub></sub>';
        for(i; i < oldText.length; i++){
            newText += oldText[i];
        }
        $('#editor_textarea').val(newText);
        setCaretToPos($('#editor_textarea')[0],caretpos+5);
    });
    $('#link').click(function(){
        var link = prompt('Введите URL ссылки:','http://');
        if(link != ''){
            var caretpos,oldText = $('#editor_textarea').val(),newText = '';
        caretpos = $('#editor_textarea').prop("selectionStart");
        for(i = 0; i < caretpos; i++){
            newText += oldText[i];
        }
        newText += '<a href="'+link+'"></a>';
        for(i; i < oldText.length; i++){
            newText += oldText[i];
        }
        $('#editor_textarea').val(newText);
        setCaretToPos($('#editor_textarea')[0],caretpos+11+link.length);
        }else{
            $('#editor_textarea').focus();
        }
    });

    var openedListImg = false,openedListList = false;
    $('#image').click(function () {
        
        if(openedListList){
            $('#ol_button_list').hide();
            openedListList = false;
            $('#list').css('background-color','transparent');
        }
        if(!openedListImg){
            $('#image').css('background-color','#2a2f4213');
            $('#image_button_list').fadeIn(500);
            openedListImg = true;
        }else{
            $('#image').css('background-color','transparent');
            $('#image_button_list').fadeOut();
            openedListImg = false;
        }
    });
    $('#list_after').click(function () {
        if(openedListImg){
            $('#image_button_list').hide();
            openedListImg = false;
            $('#image').css('background-color','transparent');
        }
        if(!openedListList){
            $('#list').css('background-color','#2a2f4213');
            $('#ol_button_list').fadeIn(500);
            openedListList = true;
        }else{
            $('#list').css('background-color','transparent');
            $('#ol_button_list').fadeOut();
            openedListList = false;
        }
    });

    $('#ol').click(function(){
        var caretpos,oldText = $('#editor_textarea').val(),newText = '';
        caretpos = $('#editor_textarea').prop("selectionStart");
        for(i = 0; i < caretpos; i++){
            newText += oldText[i];
        }
        newText += '<ol>\n\t<li></li>\n</ol>';
        for(i; i < oldText.length; i++){
            newText += oldText[i];
        }
        $('#editor_textarea').val(newText);
        setCaretToPos($('#editor_textarea')[0],caretpos+10);
    });

    $('#ul').click(function(){
        var caretpos,oldText = $('#editor_textarea').val(),newText = '';
        caretpos = $('#editor_textarea').prop("selectionStart");
        for(i = 0; i < caretpos; i++){
            newText += oldText[i];
        }
        newText += '<ul>\n\t<li></li>\n</ul>';
        for(i; i < oldText.length; i++){
            newText += oldText[i];
        }
        $('#editor_textarea').val(newText);
        setCaretToPos($('#editor_textarea')[0],caretpos+10);
    });

    $('#editor_textarea').focus(function () { 
       $('#editor_textarea').css('border-color','#077fcc');
       $('#editor_buttons_block').css('border-bottom-color','#077fcc');
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
    });
    $('#editor_textarea').focusout(function () {
       $('#editor_textarea').css('border-color','#eee');
       $('#editor_buttons_block').css('border-bottom-color','#eee');
    });

    $('.editor_button').mouseover(function () {
        if(openedListList || openedListImg){
        }else{
            $('.editor_button').css('background-color','transparent');
            $(this).css('background-color','#2a2f4213');
        }
    });
    $('.editor_button').mouseout(function () {
        if(openedListList || openedListImg){
        }else{
            $('.editor_button').css('background-color','transparent');
        }
    });

    $(document).click(function (event) {
        if(event.target.id != 'image_after' && event.target.className != 'editor_button_img'){
            $('#image').css('background-color','transparent');
            $('#image_button_list').hide();
            openedListImg = false;
        }
        if(event.target.id != 'list_after' && event.target.className != 'editor_button_img'){
            $('#list').css('background-color','transparent');
            $('#ol_button_list').hide();
            openedListList = false;
        }
    });
});
</script>