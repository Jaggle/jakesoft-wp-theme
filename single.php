<?php include("header.php") ?>

<style> 
	.comment-form label{
		display:block;
		position:relative;
		left:-45;
	}
	
	input[type="submit"] {
		display:block;
		position:relative;
		left:-20;
	}
</style>

<?php

// check if wap 
function check_wap(){
  // 先检查是否为wap代理，准确度高
  if(stristr($_SERVER['HTTP_VIA'],"wap")){
    return true;
  }
  // 检查浏览器是否接受 WML.
  elseif(strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0){
    return true;
  }
  //检查USER_AGENT
  elseif(preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])){
    return true;       
  }
  else{
    return false;  
  }
}

if (!check_wap()) {
	include("sidebar.php");
}

 ?>


<div id="main" <?php if(check_wap()) : ?> style="width:100% !important;overflow:hidden;margin-left:0;padding:10px"  <?php endif; ?>>

<div class="post">
<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>
	<h2 id="blink"><blink><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></blink></h2>
	 <div class="post-meta">
	作者：<span class="post-author"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="Posts by <?php the_author(); ?>"><?php the_author(); ?></a></span>
	<em>&bull; </em>时间：<span class="post-date"><?php the_time(__('m-j, Y')) ?></span> 
	<em>&bull; </em><?php comments_popup_link(__('评论'), __('1条评论'), __('%条评论'), '', __('评论关闭')); ?>
	<em>&bull; </em>分类：<?php the_category(', ') ?>
	<em>&bull; </em><?php the_tags('标签: ', ', '); ?>
	<?php edit_post_link( __( '编辑'), '<em>&bull; </em>'); ?>
            </div>
	<?php the_content();?>
		<?php endwhile; ?>
 <?php comments_template();?>
<?php endif; ?>
</div>

</div>

<?php include("footer.php") ?>

</body>
</html>