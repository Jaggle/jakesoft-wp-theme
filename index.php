<?php

include( "header.php");

if(function_exists( 'check_wap') && ! check_wap()) {
	include( "sidebar.php");
}

?>

<div id="main" <?php if(check_wap()) : ?> style="width:100% !important;overflow:hidden;margin-left:0;padding:10px"  <?php endif; ?>>
    <div class="post">
        <!-- 分页导航开始 -->
        <div id="nav" style="display:block;width:100%;height:20px;">
            <div class="pagenav">
                <?php wp_pagenavi(); ?>
            </div>
            <?php if(is_category()) { ?>
                <div style="float:right;margin:10px 0;">
                    <?php the_category( ', ') ?>
                </div>
            <?php } ?>
        </div>

        <?php if(have_posts()) : ?>
            <?php while(have_posts()) : the_post(); ?>
                <?php if(has_post_format( 'status')): // 引语 ?>
                    <div class="post-meta">
                        <ul class="post-list-info">
                            <li>
                                <?php the_time( 'm月d日'); ?>
                            </li>
                        </ul>
                        <div class="post-list-text">
                            <?php
                                if(check_wap()) {
                                    echo mb_substr( get_the_content(), 0, 250) . '...';
                                } else {
                                    the_content();
                                }
                            ?>
                        </div>
                    </div>
                <?php else: //默认 ?>
                    <h2 id="blink">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    <?php
                        if(check_wap()) {
                            echo mb_substr( get_the_content(), 0, 250) . '...';
                        } else {
                            the_content();
                        }
                    ?>

                    <div class="post-meta">
                    作者：
                    <span class="post-author">
                        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID')); ?>" title="Posts by <?php the_author(); ?>">
                            <?php the_author(); ?>
                        </a>
                    </span>
                    <em>·</em>
                    时间：
                    <span class="post-date">
                        <?php the_time( __( 'Y-m-d')) ?>
                    </span>
                    <?php comments_popup_link( __( '评论'), __( '1条评论'), __( '%条评论'), '', __( '评论关闭')); ?>
                    <em>&bull; </em>

                    <?php
                        if(function_exists( 'the_views')) {
                            print '点击';
                            print '(';
                            the_views();
                            print ')';
                        }
                    ?>

                    <em>&bull;</em> 分类：<?php the_category( ', ') ?>
                    <em>&bull;</em> <?php the_tags( '标签: ', ', '); ?>
                    <?php edit_post_link( __( '编辑'), '<em>&bull; </em>'); ?>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>

        <div class="pagenav">
            <?php wp_pagenavi(); ?>
        </div>
    </div>
    <!--end post-->
</div>

<?php include( "footer.php") ?>