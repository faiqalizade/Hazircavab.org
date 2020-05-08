<div class="main_page_header">
	<p id="main_page_title"><?=$langVals[$defLang]['tagsText']?></p>
</div>
<div class='tags_list_wrapper'>
<?php
if(!isset($list_page_number)){
	$page_number = 1;
}else{
	$page_number = $list_page_number;
}
$list_limit_last = ($page_number - 1) * 15;
$list_limit = $page_number * 15;
$tag_list_get_tags = R::find('tags');
$page_count = count($tag_list_get_tags) / 15;
	if(is_float($page_count)){
		$page_count++;
	}
settype($page_count,'int');
foreach ($tag_list_get_tags as $tag):
	if($cycle_number >= $list_limit_last && $cycle_number < $list_limit):
?>
<div class='tag_list_block'>
<a href="index.php?page=tags&tag=<?=$tag->id?>&questions" id="tag_list_tag_image"><img src="tagimages/<?=$tag->id?>.png"></a>
<a href="index.php?page=tags&tag=<?=$tag->id?>&questions"><p id="tag_list_tag_name"><?= ($defLang == 'ru') ? $tag->name_ru : $tag->name_az ?></p></a>
<p id='tag_list_tag_asked'>
<a href="index.php?page=tags&tag=<?=$tag->id?>&questions"> <?= $langVals[$defLang]['questions'] ?> - <?=$tag->questions?></a>
</p>
<div class='tag_list_tag_subscribe_wrapper'>
<?php
$subscribed_tag_logined_user = R::find('tagsubscribes','WHERE user_id = ? AND tag_id = ?',[$user_infos->id,$tag->id]);
if(empty($subscribed_tag_logined_user)):?>
	<a href='index.php?page=subscribe&sub_tag=<?=$tag->id?>' class='tag_list_tag_subscribe' ><?=$langVals[$defLang]['subscribeText']?> <span><?=$tag->subscribes?></span></a>
<?php else:?>
	<a href='index.php?page=unsubscribe&sub_tag=<?=$tag->id?>' class='tag_list_tag_subscribed' ><?=$langVals[$defLang]['subscribedText']?><span><?=$tag->subscribes?></span></a>
<?php endif;?>
</div>
</div>
<?php
	endif;
	if($cycle_number == $list_limit){
		break;
	}
	$cycle_number++;
endforeach;?>
<?php if(count($tag_list_get_tags) > 15): ?>
<div class="questions_pages">
			<?php if($page_number > 1):?>
				<a href="index.php?page=tags&pn=<?=$page_number - 1;?>">&#8592; <?=$langVals[$defLang]['paginationPrev']?></a>
			<?php endif;
			if($page_number > 6){
				$left_page_list = $page_number - 6;
			}
			for($i = 1; $i <= $page_count; $i++):
				if($i > $left_page_list && $i <= 10 + $left_page_list):
			?>
				<a id = '<?=$i?>' href="index.php?page=tags&pn=<?=$i?>"><?=$i?></a>
			<?php
				endif;
			endfor;
			if($page_number < $page_count):
			?>
				<a href="index.php?page=tags&pn=<?=$page_number + 1;?>"><?=$langVals[$defLang]['paginationNext']?> &#8594;</a>
			<?php endif;?>
		</div>
<?php endif;?>
</div>