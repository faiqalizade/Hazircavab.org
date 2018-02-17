<div class="main_page_header">
	<p id="main_page_title">Теги</p>
</div>
<div class='tags_list_wrapper'>
<?php
$tag_list_get_tags = R::find('tags');
foreach ($tag_list_get_tags as $tag):
?>
<div class='tag_list_block'>
<a href="index.php?page=tags&tag=<?=$tag->tagname?>" id="tag_list_tag_image"><img src="tagimages/<?=mb_strtolower($tag->tagname)?>.png"></a>
<a href="index.php?page=tags&tag=<?=$tag->tagname?>"><p id="tag_list_tag_name"><?=$tag->tagname?></p></a>
<p id='tag_list_tag_asked'>
<a href="index.php?page=tags&tag=<?=$tag->tagname?>"><?=$tag->questions?> Вопросов</a>
</p>
<div class='tag_list_tag_subscribe_wrapper'>
<p class='tag_list_tag_subscribe' >Подписаться <span><?=$tag->subscribes?></span></p>
</div>
</div>
<?php endforeach;?>
</div>