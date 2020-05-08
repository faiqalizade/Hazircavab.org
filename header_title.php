<?php
// Notification types: 
// 0 = add answer to question
// 1 = like answer to question
// 2 = check answer to question
// 3 = add comment to answer
// 4 = like comment to answer
// 5 = reply to comment answer
# =============== VARS ==============
$page = $_GET['page'];
$blog_id = $_GET['blog'];
$opened_user_profile = $_GET['user'];
$tag = $_GET['tag'];
$profile = $_GET['profile'];
$opened_question = $_GET['question'];
$accaunt = $_GET['password'];
$activate_accaunt = $_GET['activate_code'];
$like_answer = $_GET['like'];
$unlike_answer = $_GET['unlike'];
$check_answer = $_GET['check'];
$uncheck_answer = $_GET['uncheck'];
$remove_answer = $_GET['remove_answer'];
$list_page_number = $_GET['pn'];
$query = $_GET['q'];
# =============== ENDVARS ==============
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
if(isset($_COOKIE['language'])){
    if($_COOKIE['language'] != 'az' && $_COOKIE['language'] != 'ru'){
        setcookie('language','ru',time() + 1009152000,'/');
        $defLang = 'ru';
    }
    if($cookie_checked && $user_infos->lang != $_COOKIE['language']){
        $check_cookie->lang = $_COOKIE['language'];
        R::store($check_cookie);
    }
}elseif($cookie_checked){
    if($user_infos->lang != 'az'){
        setcookie('language','ru',time() + 1009152000,'/');
        $defLang = 'ru';
    }else{
        setcookie('language','az',time() + 1009152000,'/');
        $defLang = 'az';
    }
}else{
    setcookie('language','ru',time() + 1009152000,'/');
    $defLang = 'ru';
}
if ($page == 'registr') {
    if (isset($_POST['registr_page_submit'])) {
        $searchmail = R::findOne('users','mail = ?',[$_POST['reg_mail']]);
        $searchlogin = R::findOne('users','login = ?',[$_POST['reg_login']]);
        if (empty($searchmail)) {
            if (empty($searchlogin)) {
                if(strlen($_POST['reg_password']) >= 8){
                    $verifed_login = true;
                    for ($i=0; $i < strlen(htmlspecialchars(trim($_POST['reg_login']))); $i++) { 
                        if($_POST['reg_login'][$i] == ' '){
                            $verifed_login = false;
                            break;
                        }
                    }
                    if($verifed_login){
                        if ($_POST['reg_password'] == $_POST['reg_verification_password']) {
                            $registry_verification = generateRandomString(20);
                            $registry = R::dispense('users');
                            $registry->name = htmlspecialchars($_POST['reg_name']);
                            $registry->surname = htmlspecialchars($_POST['reg_lastName']);
                            $registry->login = htmlspecialchars(trim($_POST['reg_login']));
                            $registry->password = password_hash($_POST['reg_password'], PASSWORD_DEFAULT);
                            $registry->mail = htmlspecialchars($_POST['reg_mail']);
                            $registry->lang = $_COOKIE['language'];
                            $registry->answer_likes = ',';
                            $registry->comments_likes = ',';
                            $registry->small_desc = '';
                            $registry->desc = '';
                            $registry->questions = 0;
                            $registry->answers = 0;
                            $registry->checked_answers = 0;
                            $registry->verifed = $registry_verification;
                            $registry->status = 0;
                            $registry->user_hash;
                            R::store($registry);
                            mkdir('usersfiles/'.htmlspecialchars($_POST['reg_login']));
                            mkdir('usersfiles/'.htmlspecialchars($_POST['reg_login']).'/images');
                            copy('profil images/14.jpg','usersfiles/'.htmlspecialchars($_POST['reg_login']).'/profil.jpg');
                            $to = $_POST['reg_mail'];
                            $headers = "From: noreply@hazircavab.org\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            $message = '<html><body>';
                            if($defLang == 'az'){
                                $subject = 'E-mail adresin təsdiqlənməsi.';
                                $message .= '<h1>Salam Dostum!</h1>';
                                $message .= "<p>Əziz ".$_POST['reg_name'].", təbriklər sən Hazırcavab.org saytından qeydiyyatdan keçdin. Son bir etap qaldı, <a href='faiqaliza3.tmweb.ru/index.php?page=activation&activate_code=".$registry_verification."'>buraya keçib</a> e-mail adresi təsdiqlə!"."</p>";
                                $message .= "<p>Uğurlar Dostum</p>";
                                $message .= "<p>Hörmətlə HAZIRCAVAB!</p>";
                            }else{
                                $subject = 'Подтверждение почты.';
                                $message .= '<h1>Здравствуй друг(подруга)!</h1>';
                                $message .= "<p>Дорогой(-ая) ".$_POST['reg_name'].", поздравляем ты зарегистрирован на сайте Hazırcavab.org . Последний этап, тебе нужно подтвердить почту переходив по этой <a href='faiqaliza3.tmweb.ru/index.php?page=activation&activate_code=".$registry_verification."'>ссылке</a>!"."</p>";
                                $message .= "<p>Удачи друг(подруга)</p>";
                                $message .= "<p>С уважением HAZIRCAVAB!</p>";
                            }
                            $message .= '</body></html>';
                            mail($to,$subject,$message,$headers);
                            # Buarada Maile mektub atmag lazimdi
                        }else {
                            $error = $langVals[$defLang]['singUpPassError'];
                        }
                    }else {
                        $error = $langVals[$defLang]['singUpLoginSpaceError'];
                    }
                }else{
                    $error = $langVals[$defLang]['singUpPassLengthError'];
                }
            }else {
                $error = $langVals[$defLang]['singUpLoginHasError'];
            }
        }else{
            $error = $langVals[$defLang]['singUpLoginHasError'];
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
                $error = $langVals[$defLang]['singInError'];
            }
        }else{
            $error = $langVals[$defLang]['singInError'];
        }
    }
}
if($page == 'myprofile'){
    if(isset($profile)){
        if($cookie_checked){
            if(!empty($_POST['my_profil_selected_img_number'])){
                copy('profil images/'.$_POST['my_profil_selected_img_number'].'.jpg','usersfiles/'.$user_infos->login.'/profil.jpg');
        }else{
            copy($_FILES['my_profil_own_image']['tmp_name'],'usersfiles/'.$user_infos->login.'/profil.jpg');
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
            $questionNewTags = explode(',',htmlspecialchars($_POST['add_question_tags']));
            $add_question = R::dispense('questions');
            $add_question->title = htmlspecialchars(trim($_POST['add_question_title']));
            $add_question->content = $_POST['HCeditorContent'];
            $add_question->user = $user_infos->login;
            $add_question->usermail = $user_infos->mail;
            $add_question->userid = $user_infos->id;
            $add_question->views = 0;
            $add_question->answers = 0;
            $add_question->language = $user_infos->lang;
            $add_question->check_answer = ',';
            $add_question->date = date('Y-m-d');
            $add_question->time = date('H:i:s');
            $lastId = R::store($add_question);
            foreach ($questionNewTags as $tagId) {
                $tagQuestionsCountAdd = R::load('tags',$tagId);
                $addQuestionsTags = R::dispense('questiontags');
                $addQuestionsTags->question_id = $lastId;
                $addQuestionsTags->tag_id = $tagId;
                $addQuestionsTags->tag_name_ru = $tagQuestionsCountAdd->name_ru;
                $addQuestionsTags->tag_name_az = $tagQuestionsCountAdd->name_az;
                R::store($addQuestionsTags);
                $tagQuestionsCountAdd->questions = $tagQuestionsCountAdd->questions + 1;
                R::store($tagQuestionsCountAdd);
            }
            $add_question_count_user = R::load('users',$user_infos->id);
            $add_question_count_user->questions = $add_question_count_user->questions + 1;
            R::store($add_question_count_user);
            header('Location: index.php?page=question&question='.$lastId);
            exit();
        }
    }
}

if($page == 'edit_question'){
    if ($cookie_checked) {
        if(isset($_POST['add_question_title'])){
            $load_question_edit = R::load('questions',$opened_question);
            if($load_question_edit->user == $user_infos->login || $user_infos->status == 9){
                if($load_question_edit->id != 0){
                    $question_tags = R::find('questiontags','question_id = ?',[$opened_question]);
                    $questionNewTags = explode(',',htmlspecialchars($_POST['add_question_tags']));
                    foreach ($question_tags as $tag) {
                        $question_tagIds[] = $tag->id;
                        $editTag = R::load('tags',$tag->tag_id);
                        $editTag->questions = $editTag->questions - 1;
                        R::store($editTag);
                    }
                    foreach ($questionNewTags as $tagId) {
                        $tagQuestionsCountAdd = R::load('tags',$tagId);
                        $addQuestionsTags = R::dispense('questiontags');
                        $addQuestionsTags->question_id = $opened_question;
                        $addQuestionsTags->tag_id = $tagId;
                        $addQuestionsTags->tag_name_ru = $tagQuestionsCountAdd->name_ru;
                        $addQuestionsTags->tag_name_az = $tagQuestionsCountAdd->name_az;
                        R::store($addQuestionsTags);
                        $tagQuestionsCountAdd->questions = $tagQuestionsCountAdd->questions + 1;
                        R::store($tagQuestionsCountAdd);
                    }
                    $load_question_edit->title = htmlspecialchars($_POST['add_question_title']);
                    $load_question_edit->content = $_POST['HCeditorContent'];
                    R::store($load_question_edit);
                    R::trashAll($question_tags);
                    header('Location: index.php?page=question&question='.$opened_question);
                    exit();
                }
            }
        }
    }
}
if($page == 'remove_question'){
    if($check_cookie){
        $load_remove_question = R::load('questions',$opened_question);
        if($load_remove_question->user == $user_infos->login || $user_infos->status == 9){
            $find_questions_tags = R::find('questiontags','question_id = ?',[$opened_question]);
            if($load_remove_question->user == $user_infos->login){
                $edit_user_question_count = R::load('users',$user_infos->id);
                $edit_user_question_count->questions = $edit_user_question_count->questions - 1;
                R::store($edit_user_question_count); 
            }else{
                $find_user = R::findOne('users','login = ?',[$load_remove_question->user]);
                $edit_user_question_count = R::load('users',$find_user->id);
                $edit_user_question_count->questions = $edit_user_question_count->questions - 1;
                R::store($edit_user_question_count); 
            }
            foreach ($find_questions_tags as $tag) {
                $editTag = R::load('tags',$tag->tag_id);
                $editTag->questions = $editTag->questions - 1;
                R::store($editTag);
            }
            $find_question_answers = R::find('answers','question_id = ?',[$opened_question]);
            R::trashAll($find_questions_tags);
            R::trashAll($find_question_answers);
            R::trash($load_remove_question);
            header('Location: index.php');
            exit();
        }
    }
}
if($page == 'question'){ 
    $opened_question_load = R::load('questions',$opened_question);
    if(!isset($like_answer) && !isset($unlike_answer) && !isset($check_answer) && !isset($uncheck_answer) && !isset($remove_answer)){
        if(!empty($_POST)){
            if(isset($_POST['HCeditorContent'])){
                if($cookie_checked){
                    $change_question_answered = R::load('questions',$opened_question);
                    $change_question_answered->answers = $change_question_answered->answers + 1;
                    R::store($change_question_answered);
                    $change_users_answer_count = R::load('users',$user_infos->id);
                    $change_users_answer_count->answers = $change_users_answer_count->answers + 1;
                    R::store($change_users_answer_count);
                    $add_answer_to_question = R::dispense('answers');
                    $add_answer_to_question->question_id = $opened_question;
                    $add_answer_to_question->answer_content = $_POST['HCeditorContent'];
                    $add_answer_to_question->date = date('Y-m-d');
                    $add_answer_to_question->time = date('H:i:s');
                    $add_answer_to_question->user = $user_infos->login;
                    $add_answer_to_question->usermail = $user_infos->mail;
                    $add_answer_to_question->userid = $user_infos->id;
                    $add_answer_to_question->likes = 0;
                    $add_answer_to_question->check_answer = 0;
                    R::store($add_answer_to_question);
                    if($user_infos->login != $opened_question_load->user){
                        $add_notif = R::dispense('notifications');
                        $add_notif->from_id = $user_infos->id;
                        $add_notif->from_login = $user_infos->login;
                        $add_notif->to = $opened_question_load->user;
                        $add_notif->to_user_id = $opened_question_load->userid;
                        $add_notif->type = 0;
                        $add_notif->where = 'index.php?page=question&question='.$opened_question;
                        $add_notif->whereid = $opened_question;
                        $add_notif->viewed = 0;
                        $add_notif->date = date('Y-m-d');
                        $add_notif->time = date('H:i:s');
                        R::store($add_notif);
                        $notif_to_user_norif_load = R::load('users',$opened_question_load->userid);
                        $to = $opened_question_load->usermail;
                        $headers = "From: noreply@hazircavab.org\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                        $message = '<html><body>';
                        if($notif_to_user_norif_load->lang == 'az'){
                            $subject = "Sualinizi cavablandirdilar";
                            $message .= '<h1>Salam Dostum!</h1>';
                            $message .= "<p> @$user_infos->login ".$langVals['az']['notif0']." </p>";
                            $message .= "<p> Baxmaq ucun bu <a href='index.php?page=question&question=$opened_question' > linke </a> daxil olun </p>";
                            $message .= "<p>Uğurlar Dostum</p>";
                            $message .= "<p>Hörmətlə HAZIRCAVAB!</p>";
                        }else{
                            $subject = "Ответили на ваш вопрос";
                            $message .= '<h1>Здравствуй друг(подруга)!</h1>';
                            $message .= "<p> @$user_infos->login ".$langVals['ru']['notif0']." </p>";
                            $message .= "<p> Чтобы посмотреть перейдите по этой <a href='index.php?page=question&question=$opened_question' >ссылке</a></p>";
                            $message .= "<p>Удачи друг(подруга)</p>";
                            $message .= "<p>С уважением HAZIRCAVAB!</p>";
                        }
                        $message .= '</body></html>';
                        mail($to,$subject,$message,$headers);
                    }
                    header('Refresh:0');
                    exit();
                }
            }
        }
        $pageTitle = $opened_question_load->title.' - ';
    }else{
        if(isset($like_answer)){
            if($cookie_checked){
                $load_if_not_liked_answer_user = R::find('users','WHERE id = ? AND answer_likes LIKE ?',[$user_infos->id,'%,'.$like_answer.',%']);
                if(empty($load_if_not_liked_answer_user)){
                    $load_liked_answer = R::load('answers',$like_answer);
                    $load_liked_answer->likes = $load_liked_answer->likes + 1;
                    R::store($load_liked_answer);
                    $load_answer_likes_user = R::load('users',$user_infos->id);
                    $load_answer_likes_user->answer_likes = $load_answer_likes_user->answer_likes.$like_answer.',';
                    R::store($load_answer_likes_user);
                    if($user_infos->login != $load_liked_answer->user){
                        $add_notif = R::dispense('notifications');
                        $add_notif->from_id = $user_infos->id;
                        $add_notif->from_login = $user_infos->login;
                        $add_notif->to = $load_liked_answer->user;
                        $add_notif->to_user_id = $load_liked_answer->userid;
                        $add_notif->type = 1;
                        $add_notif->where = 'index.php?page=question&question='.$opened_question;
                        $add_notif->whereid = $opened_question;
                        $add_notif->viewed = 0;
                        $add_notif->date = date('Y-m-d');
                        $add_notif->time = date('H:i:s');
                        R::store($add_notif);
                        $load_liked_answer_user = R::load('users',$load_liked_answer->userid);
                        $to = $load_liked_answer->usermail;
                        $headers = "From: noreply@hazircavab.org\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                        $message = '<html><body>';
                        if($load_liked_answer_user->lang == 'az'){
                            $subject = "Cavabiniz beyenildi";
                            $message .= '<h1>Salam Dostum!</h1>';
                            $message .= "<p> @$user_infos->login ".$langVals['az']['notif1']." </p>";
                            $message .= "<p> Baxmaq ucun bu <a href='index.php?page=question&question=$opened_question' > linke </a> daxil olun </p>";
                            $message .= "<p>Uğurlar Dostum</p>";
                            $message .= "<p>Hörmətlə HAZIRCAVAB!</p>";
                        }else{
                            $subject = "Понравился ваш ответ";
                            $message .= '<h1>Здравствуй друг(подруга)!</h1>';
                            $message .= "<p> @$user_infos->login ".$langVals['ru']['notif1']." </p>";
                            $message .= "<p> Чтобы посмотреть перейдите по этой <a href='index.php?page=question&question=$opened_question' >ссылке</a></p>";
                            $message .= "<p>Удачи друг(подруга)</p>";
                            $message .= "<p>С уважением HAZIRCAVAB!</p>";
                        }
                        $message .= '</body></html>';
                        mail($to,$subject,$message,$headers);
                    }
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
                    if($load_clicked_check_answer_question->check_answer == ','){
                        $load_clicked_check_answer_question->check_answer = ','.$check_answer.',';
                        $load_checked_answer = R::load('answers',$check_answer);
                        $load_checked_answer->check_answer = 1;
                        $add_notif = R::dispense('notifications');
                        $add_notif->from_id = $user_infos->id;
                        $add_notif->from_login = $user_infos->login;
                        $add_notif->to = $load_checked_answer->user;
                        $add_notif->to_user_id = $load_checked_answer->userid;
                        $add_notif->type = 2;
                        $add_notif->where = 'index.php?page=question&question='.$opened_question;
                        $add_notif->whereid = $opened_question;
                        $add_notif->viewed = 0;
                        $add_notif->date = date('Y-m-d');
                        $add_notif->time = date('H:i:s');
                        R::store($load_checked_answer);
                        R::store($load_clicked_check_answer_question);
                        R::store($add_notif);
                        $load_checked_answer_user = R::load('users',$load_checked_answer->userid);
                        $to = $load_checked_answer->usermail;
                        $headers = "From: noreply@hazircavab.org\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                        $message = '<html><body>';
                        if($load_checked_answer_user->lang == 'az'){
                            $subject = "Cavabiniz duzgun kimi isarelendi";
                            $message .= '<h1>Salam Dostum!</h1>';
                            $message .= "<p> @$user_infos->login ".$langVals['az']['notif2']." </p>";
                            $message .= "<p> Baxmaq ucun bu <a href='index.php?page=question&question=$opened_question' > linke </a> daxil olun </p>";
                            $message .= "<p>Uğurlar Dostum</p>";
                            $message .= "<p>Hörmətlə HAZIRCAVAB!</p>";
                        }else{
                            $subject = "Ваш ответ отмечен как правильный";
                            $message .= '<h1>Здравствуй друг(подруга)!</h1>';
                            $message .= "<p> @$user_infos->login ".$langVals['ru']['notif2']." </p>";
                            $message .= "<p> Чтобы посмотреть перейдите по этой <a href='index.php?page=question&question=$opened_question' >ссылке</a></p>";
                            $message .= "<p>Удачи друг(подруга)</p>";
                            $message .= "<p>С уважением HAZIRCAVAB!</p>";
                        }
                        $message .= '</body></html>';
                        mail($to,$subject,$message,$headers);
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
                $load_answer_likes = R::load('answers',$unlike_answer);
                $load_answer_likes->likes = $load_answer_likes->likes - 1;
                $load_user_answer_likes->answer_likes = implode(',',$new_like_list);
                R::store($load_user_answer_likes);
                R::store($load_answer_likes);
                header("Location:".$_SERVER['HTTP_REFERER']);
                exit();
            }
        }elseif (isset($uncheck_answer)) {
            if($cookie_checked){
                $find_answer_in_check_answers_to_question = R::find('questions','WHERE id = ? AND check_answer LIKE ?',[$opened_question,'%,'.$uncheck_answer.',%']);
                if(!empty($find_answer_in_check_answers_to_question)){
                    $load_uncheck_answer_question = R::load('questions',$opened_question);
                    $check_answers_arr = explode(',',$load_uncheck_answer_question->check_answer);
                    $new_check_answer = [];
                    foreach ($check_answers_arr as $answer) {
                        if($answer != $uncheck_answer){
                            $new_check_answer[] = $answer;
                        }
                    }
                    $load_uncheck_answer_question->check_answer = implode(',',$new_check_answer);
                    $load_uncheck_answer = R::load('answers',$uncheck_answer);
                    $load_uncheck_answer->check_answer = 0;
                    R::store($load_uncheck_answer);
                    R::store($load_uncheck_answer_question);
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }
            }
        }elseif (isset($remove_answer)) {
            if($cookie_checked){
                $load_answer_to_remove = R::load('answers',$remove_answer);
                if($user_infos->status == 9 || $load_answer_to_remove->user == $user_infos->login){
                    if($load_answer_to_remove->check_answer){
                        $load_question_to_change_check_answers_list = R::load('questions',$opened_question);
                        $check_answers_arr = explode(',',$load_question_to_change_check_answers_list->check_answer);
                        $new_check_answers_list = [];
                        foreach ($check_answers_arr as $answer) {
                            if($answer != $remove_answer){
                                $new_check_answers_list[] = $answer;
                            }
                        }
                        $load_question_to_change_check_answers_list->check_answer = implode(',',$new_check_answers_list);
                        R::store($load_question_to_change_check_answers_list);
                    }
                    $user_answer_count = R::load('users',$load_answer_to_remove->userid);
                    $user_answer_count->answers = $user_answer_count->answers - 1;
                    R::store($user_answer_count);
                    R::trash($load_answer_to_remove);
                    $load_question_to_minus_answer = R::load('questions',$opened_question);
                    $load_question_to_minus_answer->answers = $load_question_to_minus_answer->answers - 1;
                    R::store($load_question_to_minus_answer);
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }else{
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }
            }else{
                header("Location:".$_SERVER['HTTP_REFERER']);
                exit();
            }
        }
    }
}
if($page == 'subscribe'){
    if($cookie_checked){
        if(isset($_GET['sub_tag'])){
            $load_tag = R::load('tags',$_GET['sub_tag']);
            if($load_tag->id != 0){
                $is_subscribed = R::find('tagsubscribes','WHERE tag_id = ? AND user_id = ?',[$_GET['sub_tag'],$user_infos->id]);
                if(empty($is_subscribed)){
                    $add_subscribe_tag = R::dispense('tagsubscribes');
                    $add_subscribe_tag->user_id = $user_infos->id;
                    $add_subscribe_tag->user_login = $user_infos->login;
                    $add_subscribe_tag->user_name = $user_infos->name;
                    $add_subscribe_tag->user_surname = $user_infos->surname;
                    $add_subscribe_tag->tag_id = $load_tag->id;
                    $add_subscribe_tag->tag_name_ru = $load_tag->name_ru;
                    $add_subscribe_tag->tag_name_az = $load_tag->name_az;
                    $load_tag->subscribes = $load_tag->subscribes + 1;
                    R::store($load_tag);
                    R::store($add_subscribe_tag);
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }else{
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }
            }else{
                header("Location: index.php?page=login");
                exit();
            }
        }else{
            header("Location: index.php?page=login");
            exit();
        }
    }else{
        header("Location: index.php?page=login");
        exit();
    }
}

if($page == 'unsubscribe'){
    if($cookie_checked){
        if(isset($_GET['sub_tag'])){
            $load_unsubscribe_tag = R::load('tags',$_GET['sub_tag']);
            if($load_unsubscribe_tag->id != 0){
                $is_subscribed =  R::find('tagsubscribes','WHERE user_id = ? AND tag_id = ?',[$user_infos->id,$_GET['sub_tag']]);
                if(!empty($is_subscribed)){
                    foreach ($is_subscribed as $sub) {
                        R::trash(R::load('tagsubscribes',$sub->id));
                        break;
                    }
                    $load_unsubscribe_tag->subscribes = $load_unsubscribe_tag->subscribes - 1;
                    R::store($load_unsubscribe_tag);
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }else{
                    header("Location: index.php");
                    exit();
                }
            }else{
                header("Location: index.php");
                exit();
            }
        }else{
            header("Location: index.php");
            exit();
        }
    }
}

if($page == 'blog'){
    if(isset($_POST['blog_comment_add_submit']) && $cookie_checked){
        $change_question_comments = R::load('blog',$blog_id);
        $change_question_comments->comments = $change_question_comments->comments + 1;
        R::store($change_question_comments);
        $addCommentToBlog = R::dispense('commentstoarticle');
        $addCommentToBlog->article_id = $blog_id;
        $addCommentToBlog->content = $_POST['HCeditorContent'];
        $addCommentToBlog->user_id = $user_infos['id'];
        $addCommentToBlog->user_name = $user_infos['name'];
        $addCommentToBlog->user_surname = $user_infos['surname'];
        $addCommentToBlog->user_login = $user_infos['login'];
        $addCommentToBlog->date = date('Y-m-d');
        $addCommentToBlog->time = date('H:i:s');
        R::store($addCommentToBlog);
        header("Location:".$_SERVER['HTTP_REFERER']);
        exit();
    }
}
if(isset($_GET['notif'])){
        $notifEdit = R::load('notifications',$_GET['notif']);
        if($cookie_checked){
            if($notifEdit->to == $user_infos->login){
                if(!$notifEdit->viewed){
                    $notifEdit->viewed = 1;
                    R::store($notifEdit);
                }
            }
        }
}

if($_POST['forgot_password_submit']){
    if(strpos(trim($_POST['forgot']),'@') === false){
        $forgotFind = R::findOne('users','login = ?',[trim($_POST['forgot'])]);
    }else{
        $forgotFind = R::findOne('users','mail = ?',[trim($_POST['forgot'])]);
    }
    if(empty($forgotFind)){
        $error = 'Пользователь таким логином или почтой не существует';
    }else{
        $success = 'Ссылка для восстановления пароля отправлено на вашу почту';
        //TO DO SEND MAIL
    }
}
?>