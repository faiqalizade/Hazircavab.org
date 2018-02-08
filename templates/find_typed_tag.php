<?php
require '../db.php';
$findTags = R::find('tags','tagname LIKE ?',[$_POST['findTag'].'%']);
if(!empty($findTags)):
?>
<div id='question_tags_alternative_input_found_tags'>
    <?php foreach($findTags as $tag): ?>
    <div class='found_tag'>
    <img src="tagimages/<?=strtolower($tag->tagname)?>.png">
    <p><?=$tag->tagname?></p>
    </div>
    <?php endforeach;?>
</div>
<?php endif;?>