<?php
$opened_user_infos = R::load('users',$opened_user_profile);
$find_user_check_answers = R::getAll('SELECT * FROM answers WHERE user = :user AND check_answer = :answer',
    [':user' => $opened_user_infos->login, ':answer' => 1]
);
if(!isset($list_page_number)){
	$page_number = 1;
}else{
	$page_number = $list_page_number;
}
$list_limit_last = ($page_number - 1) * 15;
$list_limit = $page_number * 15;
$cycle_number = 0;

if($opened_user_infos->id != 0):
    if($_COOKIE['user_id'] == $opened_user_profile && $opened_user_infos->verifed != 1):
?>
<a href='index.php?page=myprofile&profile' id='opened_user_profile_not_verifed' >
        <?=$langVals[$defLang]['verifyEmailText']?> <?=$opened_user_infos->mail?>
</a>
<?php endif;?>
<div id='opened_user_profile_header_wrapper' >
    <div id='opened_user_profile_header'>
    <img id='opened_user_profile_image' src="usersfiles/<?=$opened_user_infos->login?>/profil.jpg">
    </div>
    <p id='opened_user_profile_name'><?=$opened_user_infos->name.' '.$opened_user_infos->surname?></p>
    <p id='opened_user_profile_job' ><?=$opened_user_infos->small_desc?></p>
    <?php if($opened_user_profile == $_COOKIE['user_id']): ?>
    <div id='opened_user_verifed'>
    <p id='opened_user_profile_logout'><?=$langVals[$defLang]['signOutText']?></p>
    <a href="index.php?page=myprofile&profile" id='opened_user_profile_setting_block'> <img src="images/settings.svg"> </a>
    </div>
    <?php endif;?>
    <div id='opened_user_profile_works' >
        <div class='opened_user_profile_work' >
            <p class='opened_user_profile_work_number' ><?=$opened_user_infos->questions?></p>
            <p class='opened_user_profile_work_name' ><?= $langVals[$defLang]['questions'] ?></p>
        </div>
        <div class='opened_user_profile_work' >
            <p class='opened_user_profile_work_number'><?=$opened_user_infos->answers?></p>
            <p class='opened_user_profile_work_name' ><?= $langVals[$defLang]['answersCount'] ?></p>
        </div>
        <div class='opened_user_profile_work' >
            <p class='opened_user_profile_work_number'><?= (int) ((count($find_user_check_answers) * 100) / $opened_user_infos->answers)?>%</p>
            <p class='opened_user_profile_work_name' ><?=$langVals[$defLang]['solvedText']?></p>
        </div>
    </div>
</div>
<div id='opened_user_profile_lists' >
    <a href="index.php?page=user&user=<?=$opened_user_profile?>&infos" class='opened_user_profile_list' ><?= $langVals[$defLang]['information'] ?></a>
    <a href="index.php?page=user&user=<?=$opened_user_profile?>&questions" class='opened_user_profile_list' ><?=$langVals[$defLang]['questionsProfile']?></a>
    <a href="index.php?page=user&user=<?=$opened_user_profile?>&answers" class='opened_user_profile_list' ><?=$langVals[$defLang]['answersText']?></a>
    <a href="index.php?page=user&user=<?=$opened_user_profile?>&tags" class='opened_user_profile_list' ><?=$langVals[$defLang]['tagsText']?></a>
    <a href="index.php?page=user&user=<?=$opened_user_profile?>&likes" class='opened_user_profile_list' ><?=$langVals[$defLang]['likes']?></a>
</div>
<div class="opened_user_profil_selections select">
    <div class="select_selectedOption">
        <p class='select_selectedOption_text'></p> <i class="fas fa-angle-down"></i>
    </div>
    <div class="select_options_wrapper">
        <a class="select_option" href="index.php?page=user&user=<?=$opened_user_profile?>&infos" ><?= $langVals[$defLang]['information'] ?></a>
        <a class="select_option" href="index.php?page=user&user=<?=$opened_user_profile?>&questions"><?=$langVals[$defLang]['questionsProfile']?></a>
        <a class="select_option" href="index.php?page=user&user=<?=$opened_user_profile?>&answers"><?=$langVals[$defLang]['answersText']?></a>
        <a class="select_option" href="index.php?page=user&user=<?=$opened_user_profile?>&tags"><?=$langVals[$defLang]['tagsText']?></a>
        <a class="select_option" href="index.php?page=user&user=<?=$opened_user_profile?>&likes"><?=$langVals[$defLang]['likes']?></a>
    </div>
</div>
<div id='opened_user_desc' >
    <?php
    if(isset($_GET['infos'])):
        if(!empty($opened_user_infos->desc)){
            echo preg_replace( "#\r?\n#", "<br/>", $opened_user_infos->desc);
        }else{
            echo "<p class='empty_tag' ><?=$langVals[$defLang]['emptyText']?></p>";
        }
        echo "
        <script>
        $('.opened_user_profile_list').eq(0).css('border-bottom','solid 2px');
        $('.select_selectedOption_text').text('".$langVals[$defLang]['information']."');
        $('.select_option').eq(0).css('color','#536880');
        </script>
        ";?>
    <?php elseif(isset($_GET['questions'])):
            $find_user_questions = R::find('questions','WHERE user = ? ORDER BY date DESC,time DESC',[$opened_user_infos->login]);
            echo "
            <script>
            $('.opened_user_profile_list').eq(1).css('border-bottom','solid 2px');
            $('.select_selectedOption_text').text('".$langVals[$defLang]['questions']."');
            $('.select_option').eq(1).css('color','#536880');
            </script>
            ";
            if(!empty($find_user_questions)):
                $opened_profile_title = 'questions';
                $list_item_count = count($find_user_questions);
                $page_count = count($find_user_questions) / 15;
                if(is_float($page_count)){
                    $page_count++;
                }
                settype($page_count,'int');
                if($page_number > $page_count && $page_count > 0 || $page_number <= 0){
                    echo "
                    <script>
                    window.location = 'index.php?page=user&user=$opened_user_profile';
                    </script>
                    ";
                }
                foreach ($find_user_questions as $question):
                    if($cycle_number >= $list_limit_last && $cycle_number < $list_limit):
                        $tagsarray = R::find('questiontags','WHERE question_id = ?',[$question->id]);
                        if(!empty($tagsarray)){
                            foreach ($tagsarray as $val) {
                                $first_tag_id = $val->tag_id;
                                if($defLang == 'az'){
                                    $first_tag_name = $val->tag_name_az;
                                }else{
                                    $first_tag_name = $val->tag_name_ru;
                                }
                                break;
                            }
                        }
                ?>
                    <div class="question2">
                        <div class="question_information_block">
                            <div class='question_tags_wrapper' >
                            <a href="index.php?page=question&question=<?=$question->id?>"><img src="tagimages/<?=$first_tag_id?>.png"></a>
	                        <a href="index.php?page=question&question=<?=$question->id?>" class='question_tags' ><?=$first_tag_name?></a>
                                <?php if(count($tagsarray) > 1):?>
                                    <a href="index.php?page=question&question=<?=$question->id?>" class='question_tags_more_tags'> &nbsp; <?=$langVals[$defLang]['andMore']?> <?=count($tagsarray) - 1?></a>
                                <?php endif;?>
                            </div>
                            <a href="index.php?page=question&question=<?=$question->id?>" class="question_title"><?=$question->title?></a>
                            <p class="question_information"><?=$question->views?> <i class="fas fa-eye"></i> &#8226; <?=$question->date.' '.$question->time?></p>
                        </div>
                        <div class="question_answers">
                            <?php
                            if($question->check_answer != ','):?>
                            <div class="question_answers_wrapper check">
                                <p><?=$question->answers?></p>
                                <p><?= $langVals[$defLang]['answersCount'] ?></p>
                            </div>
                            <?php else:?>
                            <div class="question_answers_wrapper">
                                <p><?=$question->answers?></p>
                                <p><?= $langVals[$defLang]['answersCount'] ?></p>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>
            <?php
                unset($first_tag_name,$first_tag_id,$tagsarray);
                endif;
                if($cycle_number == $list_limit){
                    break;
                }
                $cycle_number++;
            endforeach;
        else:
            echo "<p class='empty_tag' ><?=$langVals[$defLang]['emptyText']?></p>";
        endif;
    elseif (isset($_GET['answers'])):
        $find_user_answers = R::find('answers','WHERE user = ?',[$opened_user_infos->login]);
        echo "
        <script>
        $('.opened_user_profile_list').eq(2).css('border-bottom','solid 2px');
        $('.select_selectedOption_text').text('".$langVals[$defLang]['answersText']."');
        $('.select_option').eq(2).css('color','#536880');
        </script>
        ";
        if(!empty($find_user_answers)):
            $opened_profile_title = 'answers';
            $list_item_count = count($find_user_answers);
            $page_count = count($find_user_questions) / 15;
            if(is_float($page_count)){
                $page_count++;
            }
            settype($page_count,'int');
            if($page_number > $page_count && $page_count > 0 || $page_number <= 0){
                echo "
                <script>
                window.location = 'index.php?page=user&user=$opened_user_profile';
                </script>
                ";
            }
            foreach($find_user_answers as $answer):
                $load_answered_question = R::load('questions',$answer->question_id);
                if($cycle_number >= $list_limit_last && $cycle_number < $list_limit):
            ?>
            <div class='opened_user_answer_list_wrapper' >
                <a href='index.php?page=question&question=<?=$answer->question_id?>' ><?=$load_answered_question->title?></a>
                <div class='opened_user_answer_user_infos_wrapper' >
                        <img class='opened_user_answer_img'  src="usersfiles/<?=$opened_user_infos->login?>/profil.jpg">
                        <p class='opened_user_aswer_user_name' ><?=$opened_user_infos->name.' '.$opened_user_infos->surname?></p>
                        <p class='opened_user_aswer_user_login'>@<?=$opened_user_infos->login?></p>
                    </div>
                <div style='float:left;width:100%;' >
                    <div class='opened_user_answer_list_content' >
                        <?=preg_replace( "#\r?\n#", "<br/>", $answer->answer_content);?>
                        <p><?=$langVals[$defLang]['answeredDate']?>: <?=$answer->date.' &nbsp; '.$answer->time?></p>
                    </div>
                </div>
            </div>
        <?php
                endif;
                if($cycle_number == $list_limit){
                    break;
                }
                $cycle_number++;
            endforeach;
        else:
            echo "<p class='empty_tag' ><?=$langVals[$defLang]['emptyText']?></p>";
        endif;
    elseif (isset($_GET['likes'])):
        echo "
        <script>
        $('.opened_user_profile_list').eq(4).css('border-bottom','solid 2px');
        $('.select_selectedOption_text').text('".$langVals[$defLang]['likes']."');
        $('.select_option').eq(4).css('color','#536880');
        </script>
        ";
        $load_liked_answers = R::load('users',$opened_user_profile);
        $answer_likes_arr = explode(',',$load_liked_answers->answer_likes);
        if(count($answer_likes_arr) > 2):
            foreach($answer_likes_arr as $answer):
                if(!empty($answer)):
                    $load_liked_answer = R::load('answers',$answer);
                    if($load_liked_answer->id != 0):
                        $load_answered_question = R::load('questions',$load_liked_answer->question_id);
                        $find_answered_user = R::findOne('users','login = ?',[$load_liked_answer->user]);
        ?>
                    <div class='opened_user_answer_list_wrapper' >
                        <a href='index.php?page=question&question=<?=$load_liked_answer->question_id?>' ><?=$load_answered_question->title?></a>
                        <div class='opened_user_answer_user_infos_wrapper' >
                                <img class='opened_user_answer_img'  src="usersfiles/<?=$load_liked_answer->user?>/profil.jpg">
                                <p class='opened_user_aswer_user_name' ><?=$find_answered_user->name.' '.$find_answered_user->surname?></p>
                                <p class='opened_user_aswer_user_login'>@<?=$load_liked_answer->user?></p>
                            </div>
                        <div style='float:left;width:100%;' >
                            <div class='opened_user_answer_list_content' >
                                <?=preg_replace( "#\r?\n#", "<br/>", $load_liked_answer->answer_content);?>
                                <p><?=$langVals[$defLang]['answeredDate']?>: <?=$load_liked_answer->date.' &nbsp; '.$load_liked_answer->time?></p>
                            </div>
                        </div>
                    </div>
    <?php
                    endif;
                else:
                    continue;
                endif;
            endforeach;
        endif;
    elseif (isset($_GET['tags'])):
        
        echo "
        <script>
        $('.opened_user_profile_list').eq(3).css('border-bottom','solid 2px');
        $('.select_selectedOption_text').text('".$langVals[$defLang]['tagsText']."');
        $('.select_option').eq(3).css('color','#536880');
        </script>
        ";
        $opened_user_tag_subscribe_arr = R::find('tagsubscribes','user_id = ?',[$opened_user_profile]);
        if(!empty($opened_user_tag_subscribe_arr)):
            echo "<div class='tags_list_wrapper'>";
            foreach($opened_user_tag_subscribe_arr as $subscribe_tag):
                $tag = R::load('tags',$subscribe_tag->tag_id);
                $subscribed_tag_logined_user = R::find('tagsubscribes','WHERE user_id = ? AND tag_id = ?',[$user_infos->id,$subscribe_tag->tag_id]);
        ?>
                            <div class='tag_list_block'>
                                <a href="index.php?page=tags&tag=<?=$subscribe_tag->tag_id?>" id="tag_list_tag_image"><img src="tagimages/<?=$subscribe_tag->tag_id?>.png"></a>
                                <a href="index.php?page=tags&tag=<?=$subscribe_tag->tag_id?>"><p id="tag_list_tag_name"><?= ($defLang == 'ru') ? $subscribe_tag->tag_name_ru : $subscribe_tag->tag_name_az ?></p></a>
                                <p id='tag_list_tag_asked'>
                                <a href="index.php?page=tags&tag=<?=$subscribe_tag->tag_id?>"> <?= $langVals[$defLang]['questions'] ?> - <?=$tag->questions?></a>
                                </p>
                                <div class='tag_list_tag_subscribe_wrapper'>
                                <?php if(empty($subscribed_tag_logined_user)):?>
                                    <a href='index.php?page=subscribe&sub_tag=<?=$tag->id?>' class='tag_list_tag_subscribe' ><?=$langVals[$defLang]['subscribeText']?> <span><?=$tag->subscribes?></span></a>
                                <?php else:?>
                                    <a href='index.php?page=unsubscribe&sub_tag=<?=$tag->id?>' class='tag_list_tag_subscribed' ><?=$langVals[$defLang]['subscribedText']?><span><?=$tag->subscribes?></span></a>
                                <?php endif;?>
                                </div>
                            </div>
        <?php
            endforeach;
            echo "</div>";
        else:?>
        <p class='empty_tag' ><?=$langVals[$defLang]['emptyText']?></p>
    <?php
    endif;
    else:
        echo "
        <script>
        window.location = 'index.php?page=user&user=$opened_user_profile&infos';
        </script>
        ";?>

    <?php endif;?>
</div>

    <?php if ($list_item_count > 15):?>
		<div class="questions_pages">
			<?php if($page_number > 1):?>
				<a href="index.php?page=user&user=<?=$opened_user_profile?>&<?=$opened_profile_title?>&pn=<?=$page_number - 1;?>">&#8592; <?=$langVals[$defLang]['paginationPrev']?></a>
			<?php endif;
			if($page_number > 6){
				$left_page_list = $page_number - 6;
			}
			for($i = 1; $i <= $page_count; $i++):
				if($i > $left_page_list && $i <= 10 + $left_page_list):
			?>
				<a id = '<?=$i?>' href="index.php?page=user&user=<?=$opened_user_profile?>&<?=$opened_profile_title?>&pn=<?=$i?>"><?=$i?></a>
			<?php
				endif;
			endfor;
			if($page_number < $page_count):
			?>
				<a href="index.php?page=user&user=<?=$opened_user_profile?>&<?=$opened_profile_title?>&pn=<?=$page_number + 1;?>"><?=$langVals[$defLang]['paginationNext']?> &#8594;</a>
			<?php endif;?>
		</div>
		<script>
			$('#<?=$page_number?>').css('color','#0b2542');
		</script>
	<?php endif;?>

<script>
    function deletecookie ( cookie_name ){
    var date = new Date;
    date.setDate(date.getDate() - 5);
    document.cookie = cookie_name +'=; path=/; expires='+date.toUTCString();
  }
    $('#opened_user_profile_logout').click(function(){
        deletecookie('user_id');
        deletecookie('user_hash');
        location.reload();
    });
</script>

<?php if($user_infos->status):?>
<a href="admin">Admin Panel</a>
<?php endif;?>
<?php else:?>
<script>
    location = 'index.php';
</script>
<?php endif;?>
