<?php
if($cookie_checked):
    if($user_infos->verifed != 1): ?>
    <a href='index.php?page=myprofile&profile' id='opened_user_profile_not_verifed' >
        <?=$langVals[$defLang]['verifyEmailText']?> <?=$user_infos->mail?>
    </a>
    <?php endif; ?>
    <div class="main_page_header">
        <p id="main_page_title"><?= $langVals[$defLang]['askQusetions'] ?></p>
    </div>
    <div id='add_question_form_wrapper' >
        <form id='add_question_form' method="post" novalidate>
            <p class='add_question_input_titles' ><?=$langVals[$defLang]['questionTitleText']?></p>
            <input class='add_question_inputs' AUTOCOMPLETE='off' maxlength='125' name='add_question_title' id='question_title' type="text">
            <p id='question_title_error' ></p>
            <p class='add_question_input_titles' ><?=$langVals[$defLang]['tagsText']?>:</p>
            <p></p>
            <input class='add_question_inputs' id='question_tags' type="text" name='add_question_tags'>
            <div id='question_tags_alternative_input_block' >
            <div id='question_tags_alternative_input_wrapper' >
                <div id='question_tags_alternative_input_wrapper_2' >
                <input type="text" AUTOCOMPLETE='off' id='question_tags_alternative_input'>
                </div>
            </div>
            </div>
            <p id='question_tags_error' ></p>
            <p class='add_question_input_titles' ><?=$langVals[$defLang]['moreText']?>:</p>
            <div id="opened_question_question_add_answer">
              <hc-editor i='<?=$indexforeditor?>' ></hc-editor>
            </div>
        </form>
        <div id='add_question_send_buttons_wrapper' >
        <div class='add_question_send_button'  id='add_question_send_button'><?=$langVals[$defLang]['publishText']?></div>
        <div class='add_question_send_button' id='add_question_preview_button' ><?=$langVals[$defLang]['previewText']?></div>
        </div>
    </div>
    <div id='add_question_preview_wrapper'>
        <div id='add_question_preview_tags_block'>
            <img src="" id='add_question_preview_tags_img' >
            <p id='add_question_preview_tags' ></p>
        </div>
        <p id='add_question_preview_title' ></p>
        <div id='add_question_preview_content' ></div>
        <div id='add_question_send_buttons_wrapper'>
            <div class='add_question_send_button'  id='add_question_send_button2'><?=$langVals[$defLang]['publishText']?></div>
            <div class='add_question_send_button'  id='add_question_preview_edit'>Редактировать</div>
        </div>
    </div>
    <script>
    $(document).ready(function () {
        var tagInputArr,tagsInput,tagsInputIdArr;
    var questionTitle = false,questionTags = false,questionContent = false,questionTitleVal;
    $('#question_tags_alternative_input').focus(function () {
        $('#question_tags_alternative_input_wrapper').css('border-color','#077fcc');
    });

    $('#question_tags_alternative_input').focusout(function () {
        $('#question_tags_alternative_input_wrapper').css('border-color','#eee');
    });

    $('#question_title').focus(function () {
        $('#question_title').css('border-color','#077fcc');
    });

    $('#question_title').focusout(function () {
        $('#question_title').css('border-color','#eee');
    });

    $('#question_tags_alternative_input').on('keydown',function (e){
        var addTag;
        setTimeout(() => {
            addTag = $('#question_tags_alternative_input').val();
        }, 100);
        setTimeout(() => {
            if(addTag.length != 0){
                $.ajax({
                url: 'templates/find_typed_tag.php',
                type: 'post',
                cache: false,
                dataType: 'html',
                data: ({findTag: addTag,lang:interfaceLang}),
                success: function (data) {
                        $('#question_tags_alternative_input_found_tags').remove();
                        $('#question_tags_alternative_input').after(data);
                        tagsInput = $('#question_tags').val();
                        $('.found_tag').click(function () {
                            $('#question_tags_alternative_input_found_tags').remove();
                            $('#question_tags_alternative_input').focus();
                            if($.inArray($(this).find('p').text(),tagInputArr) == -1){
                                $('#question_tags_alternative_input_wrapper_2').before('<div class="add_question_tag" >'+$(this).find('p').text().toUpperCase()+' <span class="tag_remove_span" >&#10005;</span> </div>');
                            if(!tagsInput){
                                tagsInputIdArr = [parseInt($(this).find('span').text())];
                                tagsInput += $(this).find('p').text();
                            }else{
                                tagsInputIdArr.push(parseInt($(this).find('span').text()));
                                tagsInput += ',' + $(this).find('p').text();
                            }
                            $('#question_tags_alternative_input').val('');
                            $('#question_tags').val(tagsInput);
                            tagsInput = $('#question_tags').val();
                            tagInputArr = tagsInput.split(',');
                            }
                            checkInputsToEmpty();
                        });
                        if(e.keyCode == 13){
                            $('#question_tags_alternative_input_found_tags').remove();
                        }
                    }
                });
            }else{
                $('#question_tags_alternative_input_found_tags').remove();
            }
        }, 100);
        if(e.keyCode == 13){
            setTimeout(() => {
                tagsInput = $('#question_tags').val();
                if($('.found_tag').eq(0).find('p').text() != ''){
                    addTag = $('.found_tag').eq(0).find('p').text();
                }else{
                    addTag = false;
                }
            if($.inArray(addTag,tagInputArr) == -1){
                if(addTag){
                    $('#question_tags_alternative_input_wrapper_2').before('<div class="add_question_tag" >'+addTag.toUpperCase()+' <span class="tag_remove_span" >&#10005;</span> </div>');
                    if(!tagsInput){
                        tagsInputIdArr = [parseInt($('.found_tag').eq(0).find('span').text())];
                        tagsInput += addTag;
                    }else{
                        tagsInputIdArr.push(parseInt($('.found_tag').eq(0).find('span').text()));
                        tagsInput += ',' + addTag;
                    }
                    $('#question_tags_alternative_input').val('');
                    $('#question_tags').val(tagsInput);
                    tagsInput = $('#question_tags').val();
                    tagInputArr = tagsInput.split(',');
                    checkInputsToEmpty();
                }
            }
            }, 120);
        }
    });
    $(document).on('click','.tag_remove_span',function () {
        var removingTagIndex = $('.tag_remove_span').index(this);
        $('.add_question_tag').eq(removingTagIndex).remove();
        tagInputArr.splice(removingTagIndex,1);
        tagsInputIdArr.splice(removingTagIndex,1);
        $('#question_tags').val(tagInputArr.join(','));
        checkInputsToEmpty();
    });
    $('#question_tags_alternative_input_wrapper').click(function () {
        $('#question_tags_alternative_input').focus();
    });
    checkInputsToEmpty();
    function checkInputsToEmpty(){
        if($('#question_title').val().length > 0){
            questionTitleVal = $('#question_title').val().trim();
            if(questionTitleVal[0] == questionTitleVal[0].toUpperCase()){
                $('#question_title_error').text('');
                questionTitleVal = questionTitleVal.trim();
                if(questionTitleVal[questionTitleVal.length - 1] == '?'){
                    if(questionTitleVal.length < 14){
                        questionTitle = false;
                        $('#question_title_error').text('Минимальная длина текста 14');
                    }else{
                        questionTitle = true;
                        $('#question_title_error').text('');
                    }
                }else{
                    questionTitle = false;
                    $('#question_title_error').text('Вопрос должен заканчиватья с вопросительным знаком');
                }
            }else{
                questionTitle = false;
                $('#question_title_error').text('Вопрос должен начаться с большой буквы');
            }
        }else{
            questionTitle = false;
        }

        if($('#question_tags').val().length > 0){
            questionTags = true;
        }else{
            questionTags = false;
        }
        if($('.editor_textarea').val().length > 0){
            questionContent = true;
        }else{
            questionContent = false;
        }
        if(questionTitle && questionTags && questionContent){
            $('.add_question_send_button').css({
                'cursor':'pointer',
                'color':'#9c9c9d'
            });
            $('.add_question_send_button:first-child').css({
                'color':'#65c178'
            });
        }else{
            $('.add_question_send_button').css({
                'cursor':'not-allowed',
                'color':'#bdbdc0'
            });
            $('.add_question_send_button:first-child').css({
                'color':'#a1e0ae'
            });
        }
    }

    $('#question_title').on('keyup',function () {
        checkInputsToEmpty();
    });

    $('#question_tags').on('keyup',function () {
        checkInputsToEmpty();
    });

    $('.editor_textarea').on('keyup',function () {
        checkInputsToEmpty();
    });
    var check_tags_return_bool = false;
    function CheckTags(preview){
      $.ajax({
              url: 'templates/check_sent_tags.php',
              type: 'post',
              cache: false,
              dataType: 'html',
              data: ({checkTag:tagsInputIdArr,lang:interfaceLang}),
              success: function (data) {
                  data = JSON.parse(data);
                  if(data.length > 0){
                      if(data.length <= 5){
                            tagInputArr = [];
                            data.forEach(element => {
                                tagInputArr.push(element[0]);
                            });
                            $('#question_tags_error').text('');
                            $('#question_tags').val(tagInputArr.join(','));
                            $('#HCeditor_error').text('');
                            $('#HCeditorcopy').val(readyText);
                            if(preview){
                                $('#add_question_form_wrapper').css('display','none');
                                $('#add_question_preview_wrapper').css('display','block');
                                $('#add_question_preview_tags').html(tagInputArr.join("  &#8226;  "));
                                $('#add_question_preview_title').text($('#question_title').val());
                                $('#add_question_preview_content').html(readyText.replace(/(?:\r\n|\r|\n)/g, '<br/>'));
                                $('#add_question_preview_tags_img').attr('src','tagimages/'+data[0][1]+'.png');
                            }
                            check_tags_return_bool = true;
                            return true;
                      }else{
                            check_tags_return_bool = false;
                          $('#question_tags_error').text('Невозможно указать более пяти тегов');
                      }
                  }else{
                        check_tags_return_bool = false;
                      $('#question_tags_error').text('Необходимо указать один из существующих тегов');
                  }
              }
      });
        return check_tags_return_bool;
    }
    $('#add_question_preview_edit').click(function () {
            $('#add_question_form_wrapper').css('display','block');
            $('#add_question_preview_wrapper').css('display','none');
            $('.add_question_tag').remove();
            for(var i = 0; i < tagInputArr.length; i++){
                $('#question_tags_alternative_input_wrapper_2').before('<div class="add_question_tag" >'+tagInputArr[i].toUpperCase()+' <span class="tag_remove_span" >&#10005;</span> </div>');
            }
        });
    $('#add_question_preview_button').click(function () {
            if($('.add_question_send_button').css('cursor') == 'pointer'){
                tagLength = 0;
                if(endTextLength <= 30){
                    //Здесь должны вывести ошибку
                    $('#HCeditor_error').text('Минимальная длина текста: 30, максимальная: 10 000');
                }else{
                    $('#HCeditor_error').text('');
                    CheckTags(true);
                }
            }
        });
        $('#add_question_send_button,#add_question_send_button2').click(function () {
            
            if(endTextLength <= 30 || $('.editor_textarea').val() <= 30){
                    //Здесь должны вывести ошибку
                    $('#HCeditor_error').text('Минимальная длина текста: 30, максимальная: 10 000');
                }else{
                    $('#HCeditor_error').text('');
                    CheckTags();
                    setTimeout(() => {
                        if(check_tags_return_bool && questionTitle){
                        $('#question_tags').val(tagsInputIdArr);
                            setTimeout(() => {
                                $('#add_question_form').submit();
                            }, 200);
                        }
                    }, 600);
                }
        });
    });
    </script>
<?php endif;?>
<script>
	init_hceditor('opened_question_question_add_answer');
</script>
