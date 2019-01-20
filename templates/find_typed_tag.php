<?php
require '../db.php';
$findTags = R::find('tags','name_ru LIKE ?',[$_POST['findTag'].'%']);
if(!empty($findTags)):
?>
<div id='question_tags_alternative_input_found_tags'>
    <?php foreach($findTags as $tag): ?>
    <div class='found_tag'>
    <img src="tagimages/<?=mb_strtolower($tag->name_ru)?>.png">
    <p><?=$tag->name_ru?></p>
    </div>
    <?php endforeach;?>
</div>
<?php endif;?>