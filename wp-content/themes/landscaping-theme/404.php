<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Landscaping_Theme
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <section class="error-404 not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e('Упс! Страница не найдена.', 'landscaping-theme'); ?></h1>
                </header><!-- .page-header -->

                <div class="page-content">
                    <div class="error-404-content">
                        <div class="error-404-number">404</div>
                        <p><?php esc_html_e('К сожалению, запрашиваемая вами страница не существует. Возможно, она была удалена, переименована или временно недоступна.', 'landscaping-theme'); ?></p>
                        <p><?php esc_html_e('Вы можете вернуться на главную страницу или воспользоваться поиском.', 'landscaping-theme'); ?></p>
                        
                        <div class="error-404-actions">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn"><?php esc_html_e('На главную', 'landscaping-theme'); ?></a>
                        </div>

                        <div class="error-404-search">
                            <?php get_search_form(); ?>
                        </div>
                    </div>

                    <div class="widget-area">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="widget widget_categories">
                                    <h2 class="widget-title"><?php esc_html_e('Популярные категории', 'landscaping-theme'); ?></h2>
                                    <ul>
                                        <?php
                                        wp_list_categories(
                                            array(
                                                'orderby'    => 'count',
                                                'order'      => 'DESC',
                                                'show_count' => 1,
                                                'title_li'   => '',
                                                'number'     => 10,
                                            )
                                        );
                                        ?>
                                    </ul>
                                </div><!-- .widget -->
                            </div>
                            <div class="col-md-6">
                                <div class="widget widget_recent_entries">
                                    <h2 class="widget-title"><?php esc_html_e('Последние записи', 'landscaping-theme'); ?></h2>
                                    <ul>
                                        <?php
                                        wp_get_archives(
                                            array(
                                                'type'      => 'postbypost',
                                                'limit'     => 10,
                                            )
                                        );
                                        ?>
                                    </ul>
                                </div><!-- .widget -->
                            </div>
                        </div>
                    </div>
                </div><!-- .page-content -->
            </section><!-- .error-404 -->
        </div>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();