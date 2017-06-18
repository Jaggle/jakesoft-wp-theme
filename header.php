<!DOCTYPE html>
<html>
<head>
	<?php if (is_home()) { ?><title><?php bloginfo( 'name'); ?>
        | <?php bloginfo( 'description'); ?></title>
    <?php } ?>
    
	<?php if (is_search()) { ?><title>搜索结果 | <?php bloginfo( 'name'); ?></title><?php } ?>
    
	<?php if(is_single()) { ?><title><?php echo trim( wp_title( '', 0)); ?>
        | <?php bloginfo( 'name'); ?></title><?php } ?>
    
	<?php if(is_page()) { ?><title><?php echo trim( wp_title( '', 0)); ?>
        | <?php bloginfo( 'name'); ?></title><?php } ?>
	
    <?php if(is_category()) { ?><title><?php single_cat_title(); ?> | <?php bloginfo( 'name'); ?></title><?php } ?>
	
    <?php if(is_month()) { ?><title><?php the_time( 'F'); ?> | <?php bloginfo( 'name'); ?></title><?php } ?>
	
    <?php if (function_exists( 'is_tag')) {
		if (is_tag()) { ?>
            <title><?php single_tag_title( "", true); ?>| <?php bloginfo( 'name'); ?></title>
        <?php } ?>
    <?php } ?>
    
	<?php if (is_author()) { ?><title><?php wp_title( ''); ?>发表的所有文章 | <?php bloginfo( 'name'); ?></title><?php } ?>

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url'); ?>"/>

    <link rel="shortcut icon" href="<?php bloginfo('template_directory'); echo '/images/favicon.ico' ?> />

	<?php if(is_home()) {
		$keywords    = "夜色空凝,Jake's Blog,yeskn.com";
		$description = "如果你也能看得到的话……";
	} elseif(is_single()) {
		if($post->post_excerpt) {
			$description = $post->post_excerpt;
		} else {
			$description = substr( strip_tags( $post->post_content), 0, 220);
		}
		$keywords = "";
		$tags     = wp_get_post_tags( $post->ID);
		foreach($tags as $tag) {
			$keywords = $keywords . $tag->name . ", ";
		}
	} else {
		$keywords    = "夜色空凝,Jake's Blog,yeskn.com";
		$description = "如果你也能看得到的话……";
	}
	?>

    <meta name="keywords" content="<?= $keywords ?>" />
    <meta name="description" content="<?= $description ?>" />
	<?php //wp_head(); ?>
</head>
<body>

<div id="header">
    <div class="jmail" style="position:absolute;right:50px;top:50px;">
        <!--<a target=_blank href="http://www.qxwenyi.com/mail.php">Mail to J.（admin@qxwenyi.com）</a>-->
    </div><!--Jmail-->
    <div>
        <h1 class="site-title">
            <a
                    href="<?php echo home_url( '/'); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display')); ?>"
                    rel="home"><?php bloginfo( 'name'); ?>
            </a>
        </h1>
        <div id="site-description">
            <?php echo [
                'IF YOU CAN SEE...',
                '上善若水，厚德载物'][rand( 0, 2)];
            ?>
        </div>
    </div><!--Blog name-->
</div><!--header-->
