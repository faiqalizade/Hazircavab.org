<?php 
$opened_user_infos = R::load('users',$opened_user_profile);
$find_user_questions = R::find('questions','user = ? ORDER BY date, time DESC',[$opened_user_infos->login]);
$find_user_answers = R::find('answers','user = ? ORDER BY date,time DESC',[$opened_user_infos->login]);
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
        Подтвердите, пожалуйста, эл.Почту: <?=$opened_user_infos->mail?>
</a>
<?php endif;?>
<div id='opened_user_profile_header_wrapper' >
    <div id='opened_user_profile_header'>
    <img id='opened_user_profile_image' src="usersfiles/<?=$opened_user_infos->login?>/profil.png">
    </div>
    <p id='opened_user_profile_name'><?=$opened_user_infos->name.' '.$opened_user_infos->surname?></p>
    <p id='opened_user_profile_job' ><?=$opened_user_infos->small_desc?></p>
    <?php if($opened_user_profile == $_COOKIE['user_id']): ?>
    <div id='opened_user_verifed'>
    <p id='opened_user_profile_logout'>Выйти</p>
    <a href="index.php?page=myprofile&profile" id='opened_user_profile_setting_block'> <img src="images/settings.svg"> </a>
    </div>
    <?php endif;?>
    <div id='opened_user_profile_works' >
        <div class='opened_user_profile_work' >
            <p class='opened_user_profile_work_number' ><?=count($find_user_questions)?></p>
            <p class='opened_user_profile_work_name' >вопросов</p>
        </div>
        <div class='opened_user_profile_work' >
            <p class='opened_user_profile_work_number'><?=count($find_user_answers)?></p>
            <p class='opened_user_profile_work_name' >ответов</p>
        </div>
        <div class='opened_user_profile_work' >
            <p class='opened_user_profile_work_number'><?= (int) ((count($find_user_check_answers) * 100) / count($find_user_answers))?>%</p>
            <p class='opened_user_profile_work_name' >решений</p>
        </div>
    </div>
</div>
<div id='opened_user_profile_lists' >
    <a href="index.php?page=user&user=<?=$opened_user_profile?>&infos" class='opened_user_profile_list' >Информация</a>
    <a href="index.php?page=user&user=<?=$opened_user_profile?>&questions" class='opened_user_profile_list' >Вопросы</a>
    <a href="index.php?page=user&user=<?=$opened_user_profile?>&answers" class='opened_user_profile_list' >Ответы</a>
    <a href="index.php?page=user&user=<?=$opened_user_profile?>&tags" class='opened_user_profile_list' >Теги</a>
    <a href="index.php?page=user&user=<?=$opened_user_profile?>&likes" class='opened_user_profile_list' >Понравившиеся</a>
</div>
<div id='opened_user_desc' >
    <?php
    if(isset($_GET['infos'])):
        if(!empty($opened_user_infos->desc)){
            echo preg_replace( "#\r?\n#", "<br/>", $opened_user_infos->desc);
        }else{
            echo "<p class='no_subscribe_tag' >Пусто</p>";
        }
        echo "
        <script>
        $('.opened_user_profile_list').eq(0).css('border-bottom','solid 2px');
        </script>
        ";?>
    <?php elseif(isset($_GET['questions'])):
            echo "
            <script>
            $('.opened_user_profile_list').eq(1).css('border-bottom','solid 2px');
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
                    $tagsarray = explode(',',$question->tags);
                    if($cycle_number >= $list_limit_last && $cycle_number < $list_limit):
                ?>
                    <div class="question2">
                        <div class="question_information_block">
                            <div class='question_tags_wrapper' >
                                <a href="index.php?page=question&question=<?=$question->id?>"><img src="tagimages/<?=$tagsarray[0]?>.png"></a>
                                <a href="index.php?page=question&question=<?=$question->id?>" class='question_tags' ><?=$tagsarray[0]?></a>
                                <?php if(count($tagsarray) > 1):?>
                                    <a href="index.php?page=question&question=<?=$question->id?>" class='question_tags_more_tags'> &nbsp; и ещё <?=count($tagsarray) - 1?></a>
                                <?php endif;?>
                            </div>
                            <a href="index.php?page=question&question=<?=$question->id?>" class="question_title"><?=$question->title?></a>
                            <p class="question_information"><?=$question->views?> просмотров &#8226; <?=$question->date.' '.$question->time?></p>
                        </div>
                        <div class="question_answers">
                            <?php
                            if($question->check_answer != ','):?>
                            <div class="question_answers_wrapper check">
                                <p><?=$question->answers?></p>
                                <p>Ответов</p>
                            </div>
                            <?php else:?>
                            <div class="question_answers_wrapper">
                                <p><?=$question->answers?></p>
                                <p>Ответов</p>
                            </div>
                            <?php endif;?>
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
            echo "<p class='no_subscribe_tag' >Пусто</p>";
        endif;
    elseif (isset($_GET['answers'])):
        echo "
        <script>
        $('.opened_user_profile_list').eq(2).css('border-bottom','solid 2px');
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
                        <img class='opened_user_answer_img'  src="usersfiles/<?=$opened_user_infos->login?>/profil.png">
                        <p class='opened_user_aswer_user_name' ><?=$opened_user_infos->name.' '.$opened_user_infos->surname?></p>
                        <p class='opened_user_aswer_user_login'>@<?=$opened_user_infos->login?></p>
                    </div>
                <div style='float:left;width:100%;' >
                    <div class='opened_user_answer_list_content' >
                        <?=preg_replace( "#\r?\n#", "<br/>", $answer->answer_content);?>
                        <p>Ответ написан: <?=$answer->date.' &nbsp; '.$answer->time?></p>
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
            echo "<p class='no_subscribe_tag' >Пусто</p>";
        endif;
    elseif (isset($_GET['likes'])):
        echo "
        <script>
        $('.opened_user_profile_list').eq(4).css('border-bottom','solid 2px');
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
                                <img class='opened_user_answer_img'  src="usersfiles/<?=$load_liked_answer->user?>/profil.png">
                                <p class='opened_user_aswer_user_name' ><?=$find_answered_user->name.' '.$find_answered_user->surname?></p>
                                <p class='opened_user_aswer_user_login'>@<?=$load_liked_answer->user?></p>
                            </div>
                        <div style='float:left;width:100%;' >
                            <div class='opened_user_answer_list_content' >
                                <?=preg_replace( "#\r?\n#", "<br/>", $load_liked_answer->answer_content);?>
                                <p>Ответ написан: <?=$load_liked_answer->date.' &nbsp; '.$load_liked_answer->time?></p>
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
        </script>
        ";
        $opened_user_tag_subscribe_arr = explode(',',$opened_user_infos->subscribe_tag);
        if(count($opened_user_tag_subscribe_arr) > 2):
            echo "<div class='tags_list_wrapper'>";
            foreach($opened_user_tag_subscribe_arr as $subscribe_tag):
                if(!empty($subscribe_tag)):
                    $tag = R::findOne('tags','tagname = ?',[$subscribe_tag]);
                    $subscribed_tag_logined_user = R::find('users','WHERE id = ? AND subscribe_tag LIKE ?',[$user_infos->id,'%,'.$tag->tagname.',%']);
        ?>
                            <div class='tag_list_block'>
                                <a href="index.php?page=tags&tag=<?=$tag->tagname?>" id="tag_list_tag_image"><img src="tagimages/<?=mb_strtolower($tag->tagname)?>.png"></a>
                                <a href="index.php?page=tags&tag=<?=$tag->tagname?>"><p id="tag_list_tag_name"><?=$tag->tagname?></p></a>
                                <p id='tag_list_tag_asked'>
                                <a href="index.php?page=tags&tag=<?=$tag->tagname?>"><?=$tag->questions?> Вопросов</a>
                                </p>
                                <div class='tag_list_tag_subscribe_wrapper'>
                                <?php if(empty($subscribed_tag_logined_user)):?>
                                    <a href='index.php?page=subscribe&sub_tag=<?=$tag->id?>' class='tag_list_tag_subscribe' >Подписаться <span><?=$tag->subscribes?></span></a>
                                <?php else:?>
                                    <a href='index.php?page=unsubscribe&sub_tag=<?=$tag->id?>' class='tag_list_tag_subscribed' >Вы подписаны<span><?=$tag->subscribes?></span></a>
                                <?php endif;?>
                                </div>
                            </div>
        <?php 
                endif;
            endforeach;
            echo "</div>";
        else:?>
        <p class='no_subscribe_tag' >Пусто</p>
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
				<a href="index.php?page=user&user=<?=$opened_user_profile?>&<?=$opened_profile_title?>&pn=<?=$page_number - 1;?>">&#8592; Предыдущий</a>
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
				<a href="index.php?page=user&user=<?=$opened_user_profile?>&<?=$opened_profile_title?>&pn=<?=$page_number + 1;?>">Следующий &#8594;</a>
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
<a href="index.php?page=adminKabinet">Admin Panel</a>
<?php endif;?>
<?php else:?>
<script>
    location = 'index.php';
</script>
<?php endif;?>