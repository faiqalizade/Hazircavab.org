<?php
function get_client_ip_server() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}
    if(isset($_POST['feedback_subm'])){
        if($cookie_checked){
            // send mail
            $sendMessage = R::dispense('adminmessages');
            $sendMessage->subject = htmlspecialchars($_POST['messageSubject']);
            $sendMessage->from_mail = htmlspecialchars($_POST['messageFrom']);
            $sendMessage->from_id = $user_infos->id;
            $sendMessage->content = htmlspecialchars($_POST['messageContent']);
            $sendMessage->user_ip = get_client_ip_server();
            $sendMessage->viewed = 0;
            $sendMessage->date = date('Y-m-d');
            $sendMessage->time = date('H:i:s');
            R::store($sendMessage);
        }
    }
?>
<div class="main_page_header">
    <p id="main_page_title"><?=$langVals[$defLang]['feedbackText']?></p>
</div>
<div class="main_page_header_after">
    <div id='add_question_form_wrapper'>
        <form id='add_question_form' method="post">
            <p class='add_question_input_titles'><?=$langVals[$defLang]['subjectText']?></p>
            <input class='add_question_inputs' required AUTOCOMPLETE='off' maxlength='125' name='messageSubject' id='question_title' type="text">
            <p id='question_tags_error'></p>
            <p class='add_question_input_titles'>Email</p>
            <input class='add_question_inputs' required value='<?=$user_infos->mail?>' type="text" name='messageFrom'>
            <p id='question_tags_error'></p>
            <p class='add_question_input_titles'><?=$langVals[$defLang]['messageText']?>:</p>
            <textarea class='add_question_inputs' required name="messageContent" id="content" rows="10"></textarea>
            <input type="submit" id='feedback_subm' name='feedback_subm' style="display:none">
        </form>
        <div id='add_question_send_buttons_wrapper'>
            <label for='feedback_subm' style="cursor: pointer; color: rgb(101, 193, 120);" class='add_question_send_button' id='add_question_send_button'><?=$langVals[$defLang]['sendText']?></label>
        </div>
    </div>
</div>