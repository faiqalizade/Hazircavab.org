<?php
date_default_timezone_set('Asia/Baku');
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
if($page == 'activation'){
    if(isset($activate_accaunt) && strlen($activate_accaunt) >= 20){
        $activation_accaunt_find = R::findOne('users','verifed = ?',[$activate_accaunt]);
        if(empty($activation_accaunt_find)){
            $error = 'Этот код уже не действителен';
        }else{
            $accaunt_activated = R::load('users',$activation_accaunt_find->id);
            $accaunt_activated->verifed = 1;
            R::store($accaunt_activated);
            $success = 'Аккаунт успешно подтверждена';
        }
    }else{
        header('Location: index.php');
        exit();
    }
}
if($_COOKIE['language'] == 'az'){
    // header('Location: az/');
}
if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_hash'])){
    $check_cookie = R::load('users', $_COOKIE['user_id']);
    if ($check_cookie->user_hash != $_COOKIE['user_hash']) {
        setcookie('user_id','', time() - 3600,'/');
        setcookie('user_hash','', time() - 3600,'/');
        $cookie_checked = false;
    }else{
        $cookie_checked = true;
        $user_infos = $check_cookie;
    }
}else{
    setcookie('user_hash','', time() - 3600,'/');
    setcookie('user_id','', time() - 3600,'/');
    $cookie_checked = false;
}
if ($page == 'registr') {
    if (isset($_POST['registr_page_submit'])) {
        $searchmail = R::findOne('users','mail = ?',[$_POST['reg_mail']]);
        $searchlogin = R::findOne('users','login = ?',[$_POST['reg_login']]);
        if (empty($searchmail)) {
            if (empty($searchlogin)) {
                if(strlen($_POST['reg_password']) >= 8){
                    if ($_POST['reg_password'] == $_POST['reg_verification_password']) {
                        $registry_verification = generateRandomString(20);
                        $registry = R::dispense('users');
                        $registry->name = htmlspecialchars($_POST['reg_name']);
                        $registry->surname = htmlspecialchars($_POST['reg_lastName']);
                        $registry->login = htmlspecialchars($_POST['reg_login']);
                        $registry->password = password_hash($_POST['reg_password'], PASSWORD_DEFAULT);
                        $registry->mail = htmlspecialchars($_POST['reg_mail']);
                        $registry->answer_likes = ',';
                        $registry->small_desc = '';
                        $registry->desc = '';
                        $registry->verifed = $registry_verification;
                        $registry->status = 0;
                        $registry->user_hash;
                        R::store($registry);
                        mkdir('usersfiles/'.htmlspecialchars($_POST['reg_login']));
                        mkdir('usersfiles/'.htmlspecialchars($_POST['reg_login']).'/images');
                        copy('profil images/14.png','usersfiles/'.htmlspecialchars($_POST['reg_login']).'/profil.png');
                        # Buarada Maile mektub atmag lazimdi
                    }else {
                        $error = 'Пароли не совпадают';
                    }
                }else{
                    $error = 'Пароль не должна быть менее 8 символов';
                }
            }else {
                $error = 'Аккаунт с такой логином существует';
            }
        }else{
            $error = 'Аккаунт с такой почтой существует';
        }
    }
}elseif ($page == 'login') {
    if (isset($_POST['login_page_submit'])) {
        $searchlogin = R::findOne('users','login = ?',[$_POST['login']]);
        if (!empty($searchlogin)) {
            if (password_verify($_POST['password'],$searchlogin->password)) {
                $user_hash = generateRandomString(15);
                setcookie('user_id',$searchlogin->id,time() + 86400*365,'/');
                setcookie('user_hash',$user_hash,time() + 86400*365,'/');
                $user_sign = R::load('users',$searchlogin->id);
                $user_sign->user_hash = $user_hash;
                R::store($user_sign);
                header('Location:index.php');
                exit();
            }else {
                $error = 'Неправильно введен логин или пароль';
            }
        }else{
            $error = 'Неправильно введен логин или пароль';
        }
    }
}
if($page == 'myprofile'){
    if(isset($profile)){
        if($cookie_checked){
            if(!empty($_POST['my_profil_selected_img_number'])){
                copy('profil images/'.$_POST['my_profil_selected_img_number'].'.png','usersfiles/'.$user_infos->login.'/profil.png');
        }else{
            copy($_FILES['my_profil_own_image']['tmp_name'],'usersfiles/'.$user_infos->login.'/profil.png');
        }
        if(isset($_POST['my_profile_info_change_submit'])){
            $profil_info_change = R::load('users', $_COOKIE['user_id']);
            $profil_info_change->name = htmlspecialchars($_POST['my_profil_change_name']);
            $profil_info_change->surname = htmlspecialchars($_POST['my_profil_change_surname']);
            $profil_info_change->small_desc = htmlspecialchars($_POST['my_profil_change_small_desc']);
            $profil_info_change->desc = htmlspecialchars($_POST['my_profil_change_desc']);
            if($profil_info_change->verifed != 1){
                $change_mail_verification = generateRandomString(20);
                $profil_info_change->verifed = $change_mail_verification;
                # Buarada Maile mektub atmag lazimdi
            }
            R::store($profil_info_change);
            header("Refresh:0");
            exit();
        }
        }
    }elseif (isset($accaunt)) {
        if ($cookie_checked) {
            if (isset($_POST['my_profile_pass_change_submit'])) {
                $profil_pass_change = R::load('users', $_COOKIE['user_id']);
                if(password_verify($_POST['my_profil_change_pass_old'],$profil_pass_change->password)){
                    if($_POST['my_profil_change_pass_new'] == $_POST['my_profil_change_pass_again_new']){
                        $profil_pass_change->password = $registry->password = password_hash($_POST['my_profil_change_pass_new'], PASSWORD_DEFAULT);
                        $succes = 'Пароль успешно изменен';
                        R::store($profil_pass_change);
                        # Buarada Maile mektub atmag lazimdi
                    }else{
                        $error = 'Пароли не совпадают';
                    }
                }else{
                    $error = 'Неправильно введен старый пароль';
                }
            }
        }
    }
}

if($page == 'addquestion'){
    if($cookie_checked){
        if(isset($_POST['add_question_title'])){
            $add_question = R::dispense('questions');
            $add_question->title = htmlspecialchars($_POST['add_question_title']);
            $add_question->tags = htmlspecialchars($_POST['add_question_tags']);
            $add_question->content = $_POST['HCeditorContent'];
            $add_question->user = $user_infos->login;
            $add_question->views = 0;
            $add_question->answers = 0;
            $add_question->check_answer = 0;
            $add_question->date = date('d.m.Y');
            $add_question->time = date('H:i');
            R::store($add_question);
            $add_tag_questions_number_array = explode(',',$_POST['add_question_tags']);
            foreach ($add_tag_questions_number_array as $find_tag) {
                $find_tag_to_add = R::findOne('tags','tagname = ?',[$find_tag]);
                $add_question_numbers = R::dispense('tags');
                $add_question_numbers->id = $find_tag_to_add->id;
                $add_question_numbers->questions = $find_tag_to_add->questions + 1;
                R::store($add_question_numbers);
            }
            $to_location_question = R::find('questions');
            header('Location: index.php?page=question&question='.end($to_location_question)->id);
            exit();
        }
    }
}
if($page == 'question'){
    if(!isset($like_answer) && !isset($unlike_answer) && !isset($check_answer) && !isset($uncheck_answer)){
        if(!empty($_POST)){
            if(isset($_POST['HCeditorContent'])){
                if($cookie_checked){
                    $change_question_answered = R::load('questions',$opened_question);
                    $change_question_answered->answers = $change_question_answered->answers + 1;
                    R::store($change_question_answered);
                    $add_answer_to_question = R::dispense('answers');
                    $add_answer_to_question->question_id = $opened_question;
                    $add_answer_to_question->answer_content = $_POST['HCeditorContent'];
                    $add_answer_to_question->date = date('d.m.Y');
                    $add_answer_to_question->time = date('H:i');
                    $add_answer_to_question->user = $user_infos->login;
                    $add_answer_to_question->likes = 0;
                    $add_answer_to_question->check_answer = 0;
                    R::store($add_answer_to_question);
                    header('Refresh:0');
                    exit();
                }
            }
        }
    }else{
        if(isset($like_answer)){
            if($cookie_checked){
                $load_if_not_liked_answer_user = R::find('users','WHERE id = ? AND answer_likes LIKE ?',[$user_infos->id,'%,'.$like_answer.',%']);
                if(empty($load_if_not_liked_answer_user)){
                    $load_liked_answer = R::load('answers',$like_answer);
                    $load_liked_answer->likes = $load_liked_answer->likes + 1;
                    R::store($load_liked_answer);
                    $load_liked_answer_user = R::load('users',$user_infos->id);
                    $load_liked_answer_user->answer_likes = $load_liked_answer_user->answer_likes.$like_answer.',';
                    R::store($load_liked_answer_user);
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }else{
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }
            }
        }elseif (isset($check_answer)) {
            if($cookie_checked){
                $load_clicked_check_answer_question = R::load('questions',$opened_question);
                if($load_clicked_check_answer_question->user == $user_infos->login){
                    if($load_clicked_check_answer_question->check_answer == '0'){
                        $load_clicked_check_answer_question->check_answer = ','.$check_answer.',';
                        $load_checked_answer = R::load('answers',$check_answer);
                        $load_checked_answer->check_answer = 1;
                        R::store($load_checked_answer);
                        R::store($load_clicked_check_answer_question);
                        header("Location:".$_SERVER['HTTP_REFERER']);
                        exit();
                    }else{
                        $load_if_not_checked_question_answer = R::find('questions','WHERE id = ? AND check_answer LIKE ?',[$opened_question,'%,'.$check_answer.',%']);
                        if(empty($load_if_not_checked_question_answer)){
                            $load_check_answer_to_question = R::load('questions',$opened_question);
                            $load_check_answer_to_question->check_answer = $load_check_answer_to_question->check_answer.$check_answer.',';
                            $load_checked_answer = R::load('answers',$check_answer);
                            $load_checked_answer->check_answer = 1;
                            R::store($load_checked_answer);
                            R::store($load_check_answer_to_question);
                            header("Location:".$_SERVER['HTTP_REFERER']);
                            exit();
                        }             
                    }
                }else{
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }
            }
        }elseif (isset($unlike_answer)) {
            if($cookie_checked){
                $load_user_answer_likes = R::load('users',$user_infos->id);
                $answer_likes_arr = explode(',',$load_user_answer_likes->answer_likes);
                $new_like_list = [];
                foreach ($answer_likes_arr as $like) {
                    if($like != $unlike_answer){
                        $new_like_list[] = $like;
                    }
                }
                $load_anaswer_likes = R::load('answers',$unlike_answer);
                $load_anaswer_likes->likes = $load_anaswer_likes->likes - 1;
                $load_user_answer_likes->answer_likes = implode(',',$new_like_list);
                R::store($load_user_answer_likes);
                R::store($load_anaswer_likes);
                header("Location:".$_SERVER['HTTP_REFERER']);
                exit();
            }
        }
    }
}
?>