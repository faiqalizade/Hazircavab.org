<?php
require '../db.php';
if($_POST['lang'] == 'ru'){
    $findTags = R::find('tags','name_ru LIKE ?',[$_POST['findTag'].'%']);
}else{
    $findTags = R::find('tags','name_az LIKE ?',[$_POST['findTag'].'%']);
}
if(!empty($findTags)):
?>
<div id='question_tags_alternative_input_found_tags'>
    <?php foreach($findTags as $tag): ?>
    <div class='found_tag'>
    <img src="tagimages/<?=$tag->id?>.png">
    <span class='tag_id' style='display:none;'><?=$tag->id?></span>
    <?php if($_POST['lang'] == 'ru'):?>
        <p><?=$tag->name_ru?></p>
    <?php else:?>
        <p><?=$tag->name_az?></p>
    <?php endif;?>
    </div>
    <?php endforeach;?>
</div>
<?php endif;?>