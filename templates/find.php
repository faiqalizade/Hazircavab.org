<?php
require '../db.php';
$findquestion = R::find('questions','title LIKE ? ORDER BY views DESC LIMIT 3',['%'.$_POST['findText'].'%']);
$findtags = R::find('tags','tagname LIKE ? LIMIT 3',['%'.$_POST['findText'].'%']);
$findprofiles = R::find('users','login LIKE ? LIMIT 3',[$_POST['findText'].'%']);
if(!empty($findquestion) || !empty($findtags) || !empty($findprofiles)):
?>
<div id='findQuestions' >
    <?php foreach($findquestion as $question): ?>
        <a href='index.php?page=question&question=<?=$question->id?>' class='findList' ><?=$question->title?></a>
    <?php endforeach;?>
</div>
<div id='findTags' >
    <?php foreach($findtags as $tag): ?>
        <a href='index.php?page=tags&tag=<?=$tag->tagname?>&questions' class='findList' ><img class='findTagImage' src="tagimages/<?=$tag->tagname?>.png"><?=$tag->tagname?></a>
    <?php endforeach;?>
</div>
<div id='findUsers' >
    <?php foreach($findprofiles as $user): ?>
        <a href='index.php?page=user&user=<?=$user->id?>&infos' class='findList' ><img class='findTagImage' src="usersfiles/<?=$user->login?>/profil.png"><?=$user->login?></a>
    <?php endforeach;?>
</div>
<?php else:?>
<p id='notFound' >
Ничего не найдено по запросу "<?=$_POST['findText']?>"
</p>
<?php endif;?>