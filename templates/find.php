<?php
require '../db.php';
$findquestion = R::find('questions','title LIKE ? ORDER BY views DESC, date DESC, time DESC LIMIT 3',['%'.$_POST['findText'].'%']);
$findarticles = R::find('blog','title LIKE ? ORDER BY views DESC, date DESC, time DESC LIMIT 3',['%'.$_POST['findText'].'%']);
if($_POST['lang'] == 'ru'){
    $findtags = R::find('tags','name_ru LIKE ? LIMIT 3',['%'.$_POST['findText'].'%']);
}else{
    $findtags = R::find('tags','name_az LIKE ? LIMIT 3',['%'.$_POST['findText'].'%']);
}
$findprofiles = R::find('users','login LIKE ? LIMIT 3',[$_POST['findText'].'%']);
if(!empty($findquestion) || !empty($findtags) || !empty($findprofiles) || !empty($findarticles)):
?>
<div class='foundWrapper' >
    <?php foreach($findquestion as $question): ?>
        <a href='index.php?page=question&question=<?=$question->id?>' class='findList' ><?=substr($question->title,0,63).'...'?></a>
    <?php endforeach;?>
</div>
<div class='foundWrapper' >
    <?php foreach($findtags as $tag): ?>
        <a href='index.php?page=tags&tag=<?=$tag->id?>&questions' class='findList' ><img class='findTagImage' src="tagimages/<?=$tag->id?>.png"><?= ($_POST['lang'] == 'ru') ? $tag->name_ru : $tag->name_az?></a>
    <?php endforeach;?>
</div>
<div class='foundWrapper' >
    <?php foreach($findprofiles as $user): ?>
        <a href='index.php?page=user&user=<?=$user->id?>&infos' class='findList' ><img class='findTagImage' src="usersfiles/<?=$user->login?>/profil.jpg">@<?=substr($user->login,0,66);?></a>
    <?php endforeach;?>
</div>
<div class='foundWrapper' >
    <?php foreach($findarticles as $article): ?>
        <a href='index.php?page=blog&blog=<?=$article->id?>' class='findList' ><img class='findTagImage' src="<?=$article->image?>"><?=substr($article->title,0,63).'...';?></a>
    <?php endforeach;?>
</div>
<?php else:?>
<a href='index.php?page=q&q=<?=$_POST['findText']?>' id='notFound' >
<?=($_POST['lang'] == 'ru') ? "Поиск по запросу" : 'Axtarış' ?> "<?=$_POST['findText']?>"
</a>
<?php endif;?>