<?php get_header(); ?>
<div class="content-area container">
    <div class="site-content">
        <section class="page-single" id="post-<?php the_ID();?>">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <div class="single-wrapper">

                <article class="article">


                    <!-- <div class="title">
                        <h1>
                            <?php // the_title(); ?>
                        </h1>
                    </div>

                    <time class="date" datetime="<?php // the_time('YY-MM-dd'); ?>">
            	<?php //the_time('Y-m-d'); ?>
            </time> -->


                    <div class="content">
                        <?php the_content(); ?>
                    </div>

                    <div class="single_meta" id="single_meta">
                        <!-- <div class="meta cf">
                            <span class="icon-folder"></span>
                            <?php //the_category(', '); ?>

                        </div> -->
                        <!-- <div class="meta cf">
                            <span class="icon-tag"></span>
                            <?php //the_tags(''); ?>
                        </div> -->

                        <div class="post-actions">
                            <?php if(function_exists('wp_postlike')) wp_postlike(get_the_ID(),'<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14"><path d="M533.504 268.288q33.792-41.984 71.68-75.776 32.768-27.648 74.24-50.176t86.528-19.456q63.488 5.12 105.984 30.208t67.584 63.488 34.304 87.04 6.144 99.84-17.92 97.792-36.864 87.04-48.64 74.752-53.248 61.952q-40.96 41.984-85.504 78.336t-84.992 62.464-73.728 41.472-51.712 15.36q-20.48 1.024-52.224-14.336t-69.632-41.472-79.872-61.952-82.944-75.776q-26.624-25.6-57.344-59.392t-57.856-74.24-46.592-87.552-21.504-100.352 11.264-99.84 39.936-83.456 65.536-61.952 88.064-35.328q24.576-5.12 49.152-1.536t48.128 12.288 45.056 22.016 40.96 27.648q45.056 33.792 86.016 80.896z"></path></svg>');?>
                        </div>
                                             <div class="meta cc cf">
                            <span class="icon-cc"></span>Contents licensed under Creative Commons <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.zh" target="_blank">by-nc-sa 3.0</a>.
                        </div>
                        <!-- author-->
                        <!-- <div class="author-field u-textAlignCenter">
                            <?php //echo get_avatar(get_the_author_meta( 'user_email' ),64)?>
                            <h3>
                                <a href="<?php //echo get_author_posts_url( get_the_author_meta('ID') );?>">
                                    <?php //the_author();?>
                                </a>
                            </h3>
                            <p>
                                <?php // echo get_the_author_meta( 'description' );?>
                            </p>
                        </div> -->
   
                    </div>

                    <div class="navipost cf">

<!--
                        <?php //$prev_post = get_previous_post(); if (!empty( $prev_post )): ?>
                        <p>上一篇：<a href="<?php //echo get_permalink( $prev_post->ID ); ?>"><?php echo $prev_post->post_title; ?></a></p>
                        <?php //endif; ?>
-->

<!--
                        <?php //$next_post = get_next_post(); if (!empty( $next_post )): ?>
                        <p>下一篇：<a href="<?php //echo get_permalink( $next_post->ID ); ?>"><?php echo $next_post->post_title; ?></a></p>
                        <?php //endif; ?>
-->
                        <?php the_post_navigation( array(
                        'next_text' => '<span class="meta-nav">Next</span><span class="post-title">%title</span>',
                        'prev_text' => '<span class="meta-nav">Previous</span><span class="post-title">%title</span>',
                        'screen_reader_text'=>' ',
                    ) );?>

                    </div>

                </article>
                 <div class="go_to_reply cf">
                    <a class="go_reply">
                        <span class="icon-chat"></span>
                    </a>
                </div>
                <div class="comment_container cf">
                    <?php comments_template(); ?>
                </div>   


            </div>

            <?php endwhile; else: ?>
            <?php endif; ?>

        </section>

    </div>
</div>
<?php get_footer(); ?>
<?php get_footer(); ?>