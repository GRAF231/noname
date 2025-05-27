<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Landscaping_Theme
 */

?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e('Ничего не найдено', 'landscaping-theme'); ?></h1>
    </header><!-- .page-header -->

    <div class="page-content">
        <?php
        if (is_home() && current_user_can('publish_posts')) :

            printf(
                '<p>' . wp_kses(
                    /* translators: 1: link to WP admin new post page. */
                    __('Готовы опубликовать свою первую запись? <a href="%1$s">Начните здесь</a>.', 'landscaping-theme'),
                    array(
                        'a' => array(
                            'href' => array(),
                        ),
                    )
                ) . '</p>',
                esc_url(admin_url('post-new.php'))
            );

        elseif (is_search()) :
            ?>

            <p><?php esc_html_e('К сожалению, по вашему запросу ничего не найдено. Пожалуйста, попробуйте другие ключевые слова.', 'landscaping-theme'); ?></p>
            <?php
            get_search_form();

        else :
            ?>

            <p><?php esc_html_e('К сожалению, мы не можем найти то, что вы ищете. Возможно, поиск поможет.', 'landscaping-theme'); ?></p>
            <?php
            get_search_form();

        endif;
        ?>
    </div><!-- .page-content -->
</section><!-- .no-results -->