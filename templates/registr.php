<div id='registr_page_wrapper'>
<?php if(!isset($_POST['registr_page_submit'])):?>
<p id='registr_page_title'>Регистрация</p>
<form method="post" id='registr_page_form'>
    <input type="text" class='registr_page_inputs' required name='reg_name' placeholder='Имя' >
    <input type="text" class='registr_page_inputs' required name='reg_lastName' placeholder='Фамилия'>
    <input type="text" class='registr_page_inputs' required name='reg_login' placeholder='Логин'>
    <input type="email" class='registr_page_inputs' required name='reg_mail' placeholder='E-mail'>
    <input type="password" class='registr_page_inputs' required name='reg_password' placeholder='Пароль'>
    <input type="password" class='registr_page_inputs' required name="reg_verification_password" placeholder='Повторите пароль'>
    <input type="submit" name='registr_page_submit' value="Регистрироваться" id='registr_page_submit'>
    <label for="registr_page_submit">
        <div id='registr_page_submit_label' >
            Регистрироваться
        </div>
    </label>
    <p id='registr_page_desc' >Нажимая на кнопку Регистрироваться вы соглашаетесь <a href="#">правилами</a> сайта</p>
</form>
<?php elseif(isset($error)): ?>
<p id='regist_page_error' ><?=$error;?></p>
<p id='registr_page_title'>Регистрация</p>
<form method="post" id='registr_page_form'>
    <input type="text" class='registr_page_inputs' required name='reg_name' placeholder='Имя' value='<?=$_POST['reg_name']?>'>
    <input type="text" class='registr_page_inputs' required name='reg_lastName' placeholder='Фамилия' value='<?=$_POST['reg_lastName']?>'>
    <input type="text" class='registr_page_inputs' required name='reg_login' placeholder='Логин' value='<?=$_POST['reg_login']?>'>
    <input type="email" class='registr_page_inputs' required name='reg_mail' placeholder='E-mail' value='<?=$_POST['reg_mail']?>'>
    <input type="password" class='registr_page_inputs' required name='reg_password' placeholder='Пароль'>
    <input type="password" class='registr_page_inputs' required name="reg_verification_password" placeholder='Повторите пароль'>
    <input type="submit" name='registr_page_submit' value="Регистрироваться" id='registr_page_submit'>
    <label for="registr_page_submit">
        <div id='registr_page_submit_label' >
            Регистрироваться
        </div>
    </label>
    <p id='registr_page_desc' >Нажимая на кнопку Регистрироваться вы соглашаетесь <a href="#">правилами</a> сайта</p>
</form>
<?php else:?>
<p id='registr_page_after_submit_title' class='pulse' >Регистрация прошла успешно, пожалуйста подтвердите аккаунт</p>
<p id='registr_page_after_submit_text' >На,указанная вами, почту отправлена ссылка подтверждения. Проверьте пожалуйста почту.</p>
<?php endif;?>
</div>
<script>
        $('.registr_page_inputs').focus(function(){
        $('.registr_page_inputs').css('box-shadow','none');
        $(this).css('box-shadow','0 0 5px rgba(0,0,0,0.5)');
    });
    $('.registr_page_inputs').focusout(function(){
        $('.registr_page_inputs').css('box-shadow','none');
    });
</script>