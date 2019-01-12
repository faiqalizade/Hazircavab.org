<div class="main_page_header">
	<p id="main_page_title"><?=$langVals[$_COOKIE['language']]['blog']?></p>
</div>
<div class="blog_page_header_after">
	<div class="blog_list">
		<a href="index.php?page=blog&new" class="blog_list_titles"><?php echo (isset($_COOKIE['language'])) ? $langVals[$_COOKIE['language']]['new'] : $langVals['ru']['new'] ?></a>
		<a href="index.php?page=blog&popular" class="blog_list_titles"><?php echo (isset($_COOKIE['language'])) ? $langVals[$_COOKIE['language']]['popular'] : $langVals['ru']['popular'] ?></a>
	</div>
</div>

<?php
if(!isset($list_page_number)){
	$page_number = 1;
}else{
	$page_number = $list_page_number;
}
$list_limit_last = ($page_number - 1) * 14;
$list_limit = $page_number * 14;
$article_count = R::count('blog');
$page_count = ceil($article_count / 14);
	settype($page_count,'int');
	if($page_number > $page_count && $page_count > 0 || $page_number <= 0){
		echo "
		<script>
		window.location = 'index.php?page=blog';
		</script>
		";
	}
	$leftLimit = ($page_number - 1) * 14;
	$rightLimit = $page_number * 14;
if(isset($_GET['new'])){
	$articles = R::find('blog', 'ORDER BY date DESC,time DESC LIMIT :leftLimit,:rightLimit',[":leftLimit"=>$leftLimit,":rightLimit"=>$rightLimit]);
	$order_articles = 'new';
	echo "
	<script>
	$('.blog_list_titles').eq(0).attr('id','opened_blog_page');
	</script>
	";
}elseif(isset($_GET['popular'])){
	$articles = R::find('blog', 'ORDER BY views DESC, comments DESC, date DESC,time DESC LIMIT :leftLimit,:rightLimit',[":leftLimit"=>$leftLimit,":rightLimit"=>$rightLimit]);
	$order_articles = 'popular';
	echo "
	<script>
	$('.blog_list_titles').eq(1).attr('id','opened_blog_page');
	</script>
	";
}else{
	$articles = R::find('blog', 'ORDER BY date DESC,time DESC LIMIT :leftLimit,:rightLimit',[":leftLimit"=>$leftLimit,":rightLimit"=>$rightLimit]);
	$order_articles = 'new';
	echo "
	<script>
		$('.blog_list_titles').eq(0).attr('id','opened_blog_page');
	</script>
	";
}
?>

<div class="blog">
	<?php
$i = 0;
foreach($articles as $article):
	if($i < 2):
?>
	<div class="main_blog">
		<div class="main_blog_image_block">
			<a href="index.php?page=blog&blog=<?=$article->id?>">
				<img src="<?=$article->image?>"></a>
		</div>
		<div class="main_blog_informations">
			<div class="main_blog_informations_content">
				<p id="main_blog_header_wrapper"> <a href="index.php?page=blog&blog=<?=$article->id?>" id="main_blog_header">
						<?=$article->title?></a></p>
				<a href="index.php?page=blog&blog=<?=$article->id?>" id="main_blog_description">
					<?=$article->desc?></a>
			</div>
			<div class="main_blog_footer">
				<p class="main_blog_footer_items"><img src="images/eye.png">
					<?=$article->views?>
				</p>
				<p class="main_blog_footer_items"><img src="images/chat.png">
					<?=$article->comments?>
				</p>
				<p class="main_blog_footer_items"><img src="images/like.png">
					<?=$article->likes?>
				</p>
				<p class="main_blog_footer_items"><img src="images/clock.png">
					<?=$article->date?> -
					<?=$article->time?>
				</p>
			</div>
		</div>
	</div>
	<?php
	else:
		break;
	endif;
	$i++;
endforeach;?>
</div>
<div class="main_blog_bottom_wrapper">
	<?php
	$i = 0;
	foreach($articles as $restArticle):
		if($i > 1):
	?>
	<div class="main_blog_bottom_right">
		<div class="main_blog_bottom_image_block">
			<a href="index.php?page=blog&blog=<?=$restArticle->id?>">
				<img src="<?=$restArticle->image?>">
			</a>
		</div>
		<div class="main_blog_bottom_informations">
			<p>
				<a id="main_blog_bottom_header" href="index.php?page=blog&blog=<?=$restArticle->id?>">
					<?=$restArticle->title?>
				</a>
			</p>
			<p class="main_blog_bottom_footer_time">
				<img src="images/clock.png"> <?=$restArticle->date?> - <?=$restArticle->time?>
			</p>
			<div class="main_blog_bottom_footer">
				<p class="main_blog_bottom_footer_items">
					<img src="images/eye.png"> <?=$restArticle->views?>
				</p>
				<p class="main_blog_bottom_footer_items">
					<img src="images/chat.png"> <?=$restArticle->comments?>
				</p>
				<p class="main_blog_bottom_footer_items">
					<img src="images/like.png"> <?=$restArticle->likes?>
				</p>
			</div>
		</div>
	</div>
	<?php
	endif;
	$i++;
endforeach; 	
	if($article_count > 14): ?>
		<div class="questions_pages">
			<?php if($page_number > 1):?>
				<a href="index.php?page=blog&<?=$order_articles?>&pn=<?=$page_number - 1;?>">&#8592; <?=$langVals[$_COOKIE['language']]['paginationPrev']?></a>
			<?php endif;
			if($page_number > 6){
				$left_page_list = $page_number - 6;
			}
			for($i = 1; $i <= $page_count; $i++):
				if($i > $left_page_list && $i <= 10 + $left_page_list):
			?>
				<a id = '<?=$i?>' href="index.php?page=blog&<?=$order_articles?>&pn=<?=$i?>"><?=$i?></a>
			<?php
				endif;
			endfor;
			if($page_number < $page_count):
			?>
				<a href="index.php?page=blog&<?=$order_articles?>&pn=<?=$page_number + 1;?>"><?=$langVals[$_COOKIE['language']]['paginationNext']?> &#8594;</a>
			<?php endif;?>
		</div>
		<script>
		$('#<?=$page_number?>').css('color','#0b2542');
		</script>
<?php endif;?>
</div>