<div class="main_page_header">
	<p id="main_page_title">Теги</p>
</div>
<div class='tags_list_wrapper'>
<?php
$tag_list_get_tags = R::find('tags');
foreach ($tag_list_get_tags as $tag):
?>
<div class='tag_list_block'>
<a href="index.php?page=tags&tag=<?=$tag->tagname?>&questions" id="tag_list_tag_image"><img src="tagimages/<?=mb_strtolower($tag->tagname)?>.png"></a>
<a href="index.php?page=tags&tag=<?=$tag->tagname?>&questions"><p id="tag_list_tag_name"><?=$tag->tagname?></p></a>
<p id='tag_list_tag_asked'>
<a href="index.php?page=tags&tag=<?=$tag->tagname?>&questions"><?=$tag->questions?> Вопросов</a>
</p>
<div class='tag_list_tag_subscribe_wrapper'>
<?php
$subscribed_tag_logined_user = R::find('users','WHERE id = ? AND subscribe_tag LIKE ?',[$user_infos->id,'%,'.$tag->tagname.',%']);
if(empty($subscribed_tag_logined_user)):?>
	<a href='index.php?page=subscribe&sub_tag=<?=$tag->id?>' class='tag_list_tag_subscribe' >Подписаться <span><?=$tag->subscribes?></span></a>
<?php else:?>
	<a href='index.php?page=unsubscribe&sub_tag=<?=$tag->id?>' class='tag_list_tag_subscribed' >Вы подписаны<span><?=$tag->subscribes?></span></a>
<?php endif;?>
</div>
</div>
<?php endforeach;?>
</div>