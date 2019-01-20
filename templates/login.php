<?php if(!isset($_COOKIE['user_id']) && !isset($_COOKIE['user_hash'])):?>
<div id='login_page_wrapper' >
    <p id='login_page_error'><?=$error?></p>
    <p id='login_page_title'>Вход</p>
    <form method='post'>
        <input type="text" autocomplete="username" name="login" required autofocus class='login_page_inputs' placeholder='Логин'>
        <input type="password" autocomplete='current-password' name='password' required class='login_page_inputs' placeholder='Пароль'>
        <input type="submit" value='Войти' name='login_page_submit' id='login_page_submit'>
    </form>
    <label for="login_page_submit"><div id='login_page_submit_label'>
        Войти
    </div></label>
    <a href='index.php?page=registr' id='login_page_register_bttn' >
        Регистрация
    </a>
    <a id='login_page_forgot_bttn' href="index.php?page=forgot">Забыл(-a) пароль</a>
</div>
<script>
    $('.login_page_inputs').focus(function(){
        $('.login_page_inputs').css('box-shadow','none');
        $(this).css('box-shadow','0 0 5px rgba(0,0,0,0.5)');
    });
    $('.login_page_inputs').focusout(function(){
        $('.login_page_inputs').css('box-shadow','none');
    });
</script>
<?php
else:
    echo "
    <script>
location = 'index.php';
</script>
    ";
endif;?>