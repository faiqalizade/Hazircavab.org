<?php
$lastThreeArticles = R::find('blog', 'ORDER BY date DESC,time DESC LIMIT 3');
?>
<div class="blog_page">
	<p class="blog_page_header"><?=$langVals[$_COOKIE['language']]['blogNewArtciles']?> <a href="index.php?page=blog" class="blog_page_header_link"><?=$langVals[$_COOKIE['language']]['allArticles']?></a>
	</p>
	<div class="blog_page_newblogs">
		<?php foreach($lastThreeArticles as $article): ?>
		<a href="index.php?page=blog&blog=<?=$article->id?>" class="blog_article">
			<img class="blog_article_image" src="<?=$article->image?>">
			<div class="blog_article_info">
				<p id="blog_article_info_header"><?=$article->title?></p>
				<p><?=$article->views?> - <?= $langVals[$_COOKIE['language']]['views'] ?> &#8226; <?=$article->comments?> - <?=$langVals[$_COOKIE['language']]['comments']?></p>
			</div>
		</a>
		<?php endforeach; ?>
	</div>
</div>