<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Landscaping_Theme
 */

?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-widgets">
                <div class="footer-widget">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <?php dynamic_sidebar('footer-1'); ?>
                    <?php else : ?>
                        <h3><?php echo esc_html(get_bloginfo('name')); ?></h3>
                        <p><?php echo esc_html(get_bloginfo('description')); ?></p>
                        <p><?php esc_html_e('Компания по благоустройству территорий и продаже товаров для благоустройства школ, садов и других учреждений.', 'landscaping-theme'); ?></p>
                    <?php endif; ?>
                </div>

                <div class="footer-widget">
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <?php dynamic_sidebar('footer-2'); ?>
                    <?php else : ?>
                        <h3><?php esc_html_e('Контакты', 'landscaping-theme'); ?></h3>
                        <ul>
                            <li><i class="fas fa-map-marker-alt"></i> <?php echo esc_html(get_theme_mod('footer_address', 'г. Крым и Севастополь')); ?></li>
                            <li><i class="fas fa-phone"></i> <?php echo esc_html(get_theme_mod('header_phone', '+7 (978) 742-85-95')); ?></li>
                            <li><i class="fas fa-envelope"></i> <?php echo esc_html(get_theme_mod('header_email', 'info@example.com')); ?></li>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="footer-widget">
                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <?php dynamic_sidebar('footer-3'); ?>
                    <?php else : ?>
                        <h3><?php esc_html_e('Категории товаров', 'landscaping-theme'); ?></h3>
                        <ul>
                            <?php
                            $product_categories = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => false,
                                'parent' => 0,
                                'number' => 5,
                            ));

                            if (!empty($product_categories) && !is_wp_error($product_categories)) {
                                foreach ($product_categories as $category) {
                                    echo '<li><a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a></li>';
                                }
                            } else {
                                echo '<li><a href="#">' . esc_html__('Благоустройство городов и парков', 'landscaping-theme') . '</a></li>';
                                echo '<li><a href="#">' . esc_html__('Детские площадки и игровые комплексы', 'landscaping-theme') . '</a></li>';
                                echo '<li><a href="#">' . esc_html__('Спортивное оборудование и инвентарь', 'landscaping-theme') . '</a></li>';
                                echo '<li><a href="#">' . esc_html__('Специализированная мебель и безопасность', 'landscaping-theme') . '</a></li>';
                                echo '<li><a href="#">' . esc_html__('Плавание и спасательное оборудование', 'landscaping-theme') . '</a></li>';
                            }
                            ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="footer-widget">
                    <?php if (is_active_sidebar('footer-4')) : ?>
                        <?php dynamic_sidebar('footer-4'); ?>
                    <?php else : ?>
                        <h3><?php esc_html_e('Услуги', 'landscaping-theme'); ?></h3>
                        <ul>
                            <?php
                            $services = get_posts(array(
                                'post_type' => 'service',
                                'posts_per_page' => 5,
                            ));

                            if (!empty($services)) {
                                foreach ($services as $service) {
                                    echo '<li><a href="' . esc_url(get_permalink($service->ID)) . '">' . esc_html($service->post_title) . '</a></li>';
                                }
                            } else {
                                echo '<li><a href="#">' . esc_html__('Подбор товара', 'landscaping-theme') . '</a></li>';
                                echo '<li><a href="#">' . esc_html__('Доставка товаров', 'landscaping-theme') . '</a></li>';
                                echo '<li><a href="#">' . esc_html__('Монтаж оборудования', 'landscaping-theme') . '</a></li>';
                                echo '<li><a href="#">' . esc_html__('Обслуживание и ремонт', 'landscaping-theme') . '</a></li>';
                                echo '<li><a href="#">' . esc_html__('Проектирование', 'landscaping-theme') . '</a></li>';
                            }
                            ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>. <?php esc_html_e('Все права защищены.', 'landscaping-theme'); ?></p>
                <ul class="social-links">
                    <?php if (get_theme_mod('social_facebook')) : ?>
                        <li><a href="<?php echo esc_url(get_theme_mod('social_facebook')); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <?php endif; ?>
                    <?php if (get_theme_mod('social_twitter')) : ?>
                        <li><a href="<?php echo esc_url(get_theme_mod('social_twitter')); ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                    <?php endif; ?>
                    <?php if (get_theme_mod('social_instagram')) : ?>
                        <li><a href="<?php echo esc_url(get_theme_mod('social_instagram')); ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <?php endif; ?>
                    <?php if (get_theme_mod('social_youtube')) : ?>
                        <li><a href="<?php echo esc_url(get_theme_mod('social_youtube')); ?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
                    <?php endif; ?>
                    <?php if (get_theme_mod('social_vk')) : ?>
                        <li><a href="<?php echo esc_url(get_theme_mod('social_vk')); ?>" target="_blank"><i class="fab fa-vk"></i></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>