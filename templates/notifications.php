<?php
$notifications = R::find('notifications','WHERE `to` = ? ORDER BY date DESC,time DESC',[$user_infos->login]);
?>
<div class="main_page_header">
    <p id="main_page_title">
        <?= $langVals[$_COOKIE['language']]['notifications'] ?>
    </p>
</div>
<div class="main_page_header_after">
    <div class="notif-page-list-wrapper">

        <?php foreach($notifications as $notif):?>
        <!-- Comments Start -->
        <div class="notif-page-list-item">
            <div class="notif-page-notif-notviewed-wrapper">
                <?php if(!$notif->viewed): ?>
                    <span class='notif-page-notif-notviewed' ></span>
                <?php endif;?>
            </div>
            <img class='notif-page-notif-img' src="images/notif_<?=$notif->type?>.svg">
            <div class='notif-page-notif-content'>
                <a class='notif-page-notif-title' href="#">
                    <?php if($notif->type == 0):?>
                    <?=$notif->from_login?> ответил на ваш вопрос.
                    <?php elseif($notif->type == 1):?>
                    <?=$notif->from_login?> понравился ваш ответ.
                    <?php elseif($notif->type == 2):?>
                    <?=$notif->from_login?> отметил ваш ответ как правильный.
                    <?php elseif($notif->type == 3):?>
                    <?=$notif->from_login?> прокомментировал ваш ответ.
                    <?php elseif($notif->type == 4):?>
                    <?=$notif->from_login?> понравился ваш комментарий к ответу.
                    <?php elseif($notif->type == 5):?>
                    <?=$notif->from_login?> ответил на ваш комментарий к ответу.
                    <?php endif;?>
                </a>
                <p class='notif-page-notif-date'>
                    <?= $notif->date.' - '.$notif->time?>
                </p>
            </div>
        </div>
        <!-- Comments End -->
        <?php endforeach;?>
    </div>
</div>