<div id='registr_page_wrapper'>
    <?php if(!isset($_POST['registr_page_submit'])):?>
    <p id='registr_page_title'><?=$langVals[$defLang]['signUp']?></p>
    <form method="post" id='registr_page_form'>
        <input type="text" class='registr_page_inputs' required name='reg_name' placeholder='<?=$langVals[$defLang]["name"]?>' >
        <input type="text" class='registr_page_inputs' required name='reg_lastName' placeholder='<?=$langVals[$defLang]["surname"]?>'>
        <input type="text" class='registr_page_inputs' required name='reg_login' placeholder='<?=$langVals[$defLang]['loginText']?>'>
        <input type="email" class='registr_page_inputs' required name='reg_mail' placeholder='E-mail'>
        <input type="password" autocomplete="new-password" class='registr_page_inputs' required name='reg_password' placeholder='<?=$langVals[$defLang]['passwordText']?>'>
        <input type="password" autocomplete="new-password" class='registr_page_inputs' required name="reg_verification_password" placeholder='<?=$langVals[$defLang]["repeatPasswordText"]?>'>
        <input type="submit" name='registr_page_submit' value="Регистрироваться" id='registr_page_submit'>
        <label for="registr_page_submit">
            <div id='registr_page_submit_label'>
                <?=$langVals[$defLang]['signUpBtnText']?>
            </div>
        </label>
        <p id='registr_page_desc'>
        <?=$langVals[$defLang]['registrLicenseHTML']?>
        </p>
    </form>
    <?php elseif(isset($error)): ?>
    <p id='regist_page_error'>
        <?=$error;?>
    </p>
    <p id='registr_page_title'>Регистрация</p>
    <form method="post" id='registr_page_form'>
        <input type="text" class='registr_page_inputs' required name='reg_name' placeholder='<?php echo (isset($_COOKIE['
            language'])) ? $langVals[$defLang]['name'] : $langVals['ru']['name'] ?>' value='
        <?=$_POST['reg_name']?>'>
        <input type="text" class='registr_page_inputs' required name='reg_lastName' placeholder='<?php echo (isset($_COOKIE['
            language'])) ? $langVals[$defLang]['surname'] : $langVals['ru']['surname'] ?>' value='
        <?=$_POST['reg_lastName']?>'>
        <input type="text" class='registr_page_inputs' required name='reg_login' placeholder='<?=$langVals[$defLang]['loginText']?>' value='<?=$_POST['
            reg_login']?>'>
        <input type="email" class='registr_page_inputs' required name='reg_mail' placeholder='E-mail' value='<?=$_POST['
            reg_mail']?>'>
        <input type="password" autocomplete="new-password" class='registr_page_inputs' required name='reg_password' placeholder='<?=$langVals[$defLang]['passwordText']?>'>
        <input type="password" autocomplete="new-password" class='registr_page_inputs' required name="reg_verification_password" placeholder='Повторите пароль'>
        <input type="submit" name='registr_page_submit' value="Регистрироваться" id='registr_page_submit'>
        <label for="registr_page_submit">
            <div id='registr_page_submit_label'>
                <?=$langVals[$defLang]['signUpBtnText']?>
            </div>
        </label>
        <p id='registr_page_desc'>
            <?=$langVals[$defLang]['registrLicenseHTML']?>
        </p>
    </form>
    <?php else:?>
    <p id='registr_page_after_submit_title' class='pulse'><?=$langVals[$defLang]["registrText1"]?></p>
    <p id='registr_page_after_submit_text'><?=$langVals[$defLang]["registrText2"]?></p>
    <?php endif;?>
</div>
<script>
    $('.registr_page_inputs').focus(function () {
        $('.registr_page_inputs').css('box-shadow', 'none');
        $(this).css('box-shadow', '0 0 5px rgba(0,0,0,0.5)');
    });
    $('.registr_page_inputs').focusout(function () {
        $('.registr_page_inputs').css('box-shadow', 'none');
    });
</script>