<?php if($cookie_checked):
    if($user_infos->verifed != 1):
    ?>
    <a href='index.php?page=myprofile&profile' id='opened_user_profile_not_verifed' >
    Подтвердите, пожалуйста, эл.Почту: <?=$user_infos->mail?> 
</a>
    <?php endif;?>
    <p>
<?php
// $user_infost = preg_replace( "#\r?\n#", "<br/>", $user_infos->desc );
// Для вывода текста с переносами
?>
    </p>
<div id='my_profil_header' >
<a href="index.php?page=myprofile&profile" class='my_profil_header_list' >Информация</a>
<a href="index.php?page=myprofile&password" class='my_profil_header_list' >Изменить пароль</a>
</div>
<?php if(isset($profile)):?>
<div id='my_profil_wrapper' >
<img id='my_profil_image' src="usersfiles/<?=$user_infos->login?>/profil.png">
<p id='my_profil_img_change_bttn' >Изменить</p>
<div id='my_profil_img_change_images_block' >
    <form method="post" id='my_profil_image_change_form' enctype='multipart/form-data'> 
    <input id='my_profil_selected_img_number' name='my_profil_selected_img_number' type="text">
    <input type="file" name="my_profil_own_image" id="my_profile_image_upload">
    </form>
        <?php for($i = 1; $i <= 14; $i++):?>
        <img class='my_profil_img_change_image' src="profil images/<?=$i?>.png">
        <?php endfor;?>
    <label for='my_profile_image_upload' id='my_profil_img_change_own' >Свой</label>
</div>
<form id='my_profil_info_change_form' method="post">
    <p class='my_profil_info_input_titles' >Имя:</p>
    <input class='my_profil_info_inputs' name='my_profil_change_name' type="text" value='<?=$user_infos->name?>'>
    <p class='my_profil_info_input_titles' >Фамилия:</p>
    <input class='my_profil_info_inputs' type="text" name='my_profil_change_surname' value='<?=$user_infos->surname?>'>
    <p class='my_profil_info_input_titles' >Коротко о себе:</p>
    <input class='my_profil_info_inputs' type="text" name='my_profil_change_small_desc' value='<?=$user_infos->small_desc?>'>
    <p class='my_profil_info_input_titles' >О себе:</p>
    <textarea id='my_profil_info_textarea' name='my_profil_change_desc' ><?=$user_infos->desc?></textarea>
    <input type="submit" name="my_profile_info_change_submit" id='my_profil_change_info_submit' >
</form>
<div id='my_profil_change_lang_wrapper' >
    <p id='my_profil_change_lang_title' >Язык:</p>
    <p class='my_profil_change_lang' >Русский</p>
    <p class='my_profil_change_lang' >Azərbaycanca</p>
</div>
<p id='my_profil_change_info_submit_label' ><label for="my_profil_change_info_submit" >Сохранить</label></p>
</div>
<a id='my_profil_message_not_sended' >Если эл.почта не подтверждена, то при каждом нажатии на кнопку сохранить мы снова отправляем сообщение на почту для подтверждения. При этом прошлое сообщение становиться не активным</a>
<script>
$('.my_profil_header_list:first-child').css('border-bottom','solid 2px');
function getcookie ( cookie_name ){
    var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );

    if ( results )
      return ( unescape ( results[2] ) );
    else
      return null;
  }
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
  if(getcookie('language') == 'ru'){
      $('.my_profil_change_lang:eq(0)').attr('class','my_profil_change_lang selected_language');
  }else{
    $('.my_profil_change_lang:eq(1)').attr('class','my_profil_change_lang selected_language');
  }
  $('.my_profil_change_lang').click(function () {
      if($('.my_profil_change_lang').index(this) == 1){
          setcookie('language','az','/',2030,0);
      }else{
          setcookie('language','ru','/',2030,0);
      }
      location.reload();
  });
</script>
<?php elseif(isset($accaunt)):?>
<p id='my_profil_change_password_error' ><?=$error?></p>
<p id='my_profil_change_password_succes'><?=$succes?></p>
<form id='my_profil_pass_change_form' method="post">
    <p class='my_profil_info_input_titles' >Старый пароль:</p>
    <input class='my_profil_info_inputs' name='my_profil_change_pass_old' type="password" required>
    <p class='my_profil_info_input_titles' >Новый пароль:</p>
    <input class='my_profil_info_inputs' type="password" name='my_profil_change_pass_new' required>
    <p class='my_profil_info_input_titles' >Повторите новый пароль:</p>
    <input class='my_profil_info_inputs' type="password" name='my_profil_change_pass_again_new' required>
    <input type="submit" name="my_profile_pass_change_submit" id='my_profil_change_pass_submit' >
</form>
<p id='my_profil_change_info_submit_label' ><label for="my_profil_change_pass_submit" >Сохранить</label></p>
<a id='my_profile_pass_change_forgot_button' href="index.php?page=forgot">Забыл(-а) пароль</a>
<script>
$('.my_profil_header_list:last-child').css('border-bottom','solid 2px');
</script>
<?php
else:
    echo "
    <script>
    location = 'index.php';
</script>
    ";
endif;?>
<script>
    var myProfilOpenedImgChange = false;
    $('#my_profil_img_change_bttn').click(function(){
        if(!myProfilOpenedImgChange){
            $('#my_profil_img_change_images_block').fadeIn(1000);
            $('#my_profil_img_change_images_block').css('display','flex');
            myProfilOpenedImgChange = true;
        }else{
            $('#my_profil_img_change_images_block').fadeOut();
            myProfilOpenedImgChange = false;
        }
    });
$('#my_profile_image_upload').change(function () {
    $('#my_profil_image_change_form').submit();
});
$('.my_profil_img_change_image').click(function(){
    $('#my_profil_selected_img_number').val($('.my_profil_img_change_image').index(this) + 1);
    $('#my_profil_image_change_form').submit();
});
</script>
<?php else:?>
<script>
    location = 'index.php';
</script>
<?php endif;?>