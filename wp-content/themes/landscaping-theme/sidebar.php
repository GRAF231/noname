<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Landscaping_Theme
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area">
    <?php dynamic_sidebar('sidebar-1'); ?>
    
    <?php if (!dynamic_sidebar('sidebar-1')) : ?>
        <div class="widget">
            <h3 class="widget-title"><?php esc_html_e('Категории товаров', 'landscaping-theme'); ?></h3>
            <ul>
                <?php
                $product_categories = get_terms(array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => false,
                    'parent' => 0,
                ));

                if (!empty($product_categories) && !is_wp_error($product_categories)) {
                    foreach ($product_categories as $category) {
                        echo '<li><a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a></li>';
                    }
                }
                ?>
            </ul>
        </div>

        <div class="widget">
            <h3 class="widget-title"><?php esc_html_e('Популярные товары', 'landscaping-theme'); ?></h3>
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 5,
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
            );
            $popular_products = new WP_Query($args);

            if ($popular_products->have_posts()) :
                echo '<ul>';
                while ($popular_products->have_posts()) : $popular_products->the_post();
                    echo '<li>';
                    echo '<a href="' . esc_url(get_permalink()) . '">';
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('thumbnail');
                    }
                    echo '<span>' . get_the_title() . '</span>';
                    echo '</a>';
                    echo '</li>';
                endwhile;
                echo '</ul>';
                wp_reset_postdata();
            endif;
            ?>
        </div>
    <?php endif; ?>

    <!-- Форма обратной связи -->
    <div class="widget">
        <h3 class="widget-title"><?php esc_html_e('Связаться с нами', 'landscaping-theme'); ?></h3>
        <?php landscaping_theme_display_contact_form(); ?>
    </div>
</aside><!-- #secondary -->