<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Landscaping_Theme
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <?php if (have_posts()) : ?>

                        <header class="page-header">
                            <?php
                            the_archive_title('<h1 class="page-title">', '</h1>');
                            the_archive_description('<div class="archive-description">', '</div>');
                            ?>
                        </header><!-- .page-header -->

                        <div class="archive-posts">
                            <?php
                            /* Start the Loop */
                            while (have_posts()) :
                                the_post();
                                ?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class('archive-item'); ?>>
                                    <div class="row">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="col-md-4">
                                                <div class="post-thumbnail">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail('medium'); ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                        <?php else : ?>
                                            <div class="col-md-12">
                                        <?php endif; ?>
                                                <header class="entry-header">
                                                    <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>

                                                    <?php if ('post' === get_post_type()) : ?>
                                                        <div class="entry-meta">
                                                            <span class="posted-on">
                                                                <i class="fas fa-calendar-alt"></i>
                                                                <?php echo get_the_date(); ?>
                                                            </span>
                                                            <span class="byline">
                                                                <i class="fas fa-user"></i>
                                                                <?php the_author(); ?>
                                                            </span>
                                                            <?php if (has_category()) : ?>
                                                                <span class="cat-links">
                                                                    <i class="fas fa-folder"></i>
                                                                    <?php the_category(', '); ?>
                                                                </span>
                                                            <?php endif; ?>
                                                        </div><!-- .entry-meta -->
                                                    <?php endif; ?>
                                                </header><!-- .entry-header -->

                                                <div class="entry-summary">
                                                    <?php the_excerpt(); ?>
                                                </div><!-- .entry-summary -->

                                                <footer class="entry-footer">
                                                    <a href="<?php the_permalink(); ?>" class="btn btn-sm"><?php esc_html_e('Читать далее', 'landscaping-theme'); ?></a>
                                                </footer><!-- .entry-footer -->
                                            </div>
                                    </div>
                                </article><!-- #post-<?php the_ID(); ?> -->
                                <?php
                            endwhile;

                            the_posts_pagination(array(
                                'prev_text' => '<i class="fas fa-arrow-left"></i> ' . esc_html__('Предыдущая', 'landscaping-theme'),
                                'next_text' => esc_html__('Следующая', 'landscaping-theme') . ' <i class="fas fa-arrow-right"></i>',
                            ));

                        else :

                            ?>
                            <p><?php esc_html_e('Записей не найдено.', 'landscaping-theme'); ?></p>
                            <?php

                        endif;
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();