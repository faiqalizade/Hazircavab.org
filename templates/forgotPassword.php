<div id='login_page_wrapper' >
    <p id='login_page_error'><?=$error?></p>
    <p id='forgot_page_success'><?=$success?></p>
    <p id='login_page_title'>Введите логин или почту</p>
    <form method='post'>
        <input type="text" autocomplete="username" name="forgot" required autofocus class='login_page_inputs' placeholder='Login or Email'>
        <input type="submit" value='Войти' name='forgot_password_submit' id='login_page_submit'>
    </form>
    <label for="login_page_submit">
        <div id='login_page_submit_label'>
            Отправить
        </div>
    </label>
</div>