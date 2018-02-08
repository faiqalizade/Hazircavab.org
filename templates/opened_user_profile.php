<?php 
$opened_user_infos = R::load('users',$opened_user_profile);
if($opened_user_infos->id != 0):
    if($_COOKIE['user_id'] == $opened_user_profile && $opened_user_infos->verifed != 1):
?>
<a href='index.php?page=myprofile&profile' id='opened_user_profile_not_verifed' >
        Подтвердите, пожалуйста, эл.Почту: <?=$opened_user_infos->mail?>
</a>
<?php endif;?>
<div id='opened_user_profile_header_wrapper' >
    <div id='opened_user_profile_header'>
    <?php if($_COOKIE['user_id'] == $opened_user_profile):?>
    <img id='opened_user_profile_image' src="usersfiles/<?=$user_infos->login?>/profil.png">
    <?php else: ?>
    <img id='opened_user_profile_image' src="usersfiles/<?=$opened_user_infos->login?>/profil.png">
    <?php endif;?>
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
            <p class='opened_user_profile_work_number' >10</p>
            <p class='opened_user_profile_work_name' >вопросов</p>
        </div>
        <div class='opened_user_profile_work' >
            <p class='opened_user_profile_work_number'>5</p>
            <p class='opened_user_profile_work_name' >ответов</p>
        </div>
        <div class='opened_user_profile_work' >
            <p class='opened_user_profile_work_number'>50%</p>
            <p class='opened_user_profile_work_name' >решений</p>
        </div>
    </div>
</div>
<div id='opened_user_profile_lists' >
    <a href="" class='opened_user_profile_list' >Информация</a>
    <a href="" class='opened_user_profile_list' >Вопросы</a>
    <a href="" class='opened_user_profile_list' >Ответы</a>
    <a href="" class='opened_user_profile_list' >Теги</a>
    <a href="" class='opened_user_profile_list' >Понравившиеся</a>
</div>
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