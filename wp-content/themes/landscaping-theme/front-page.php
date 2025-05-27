<?php
/**
 * The template for displaying the front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Landscaping_Theme
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <?php if (function_exists('is_woocommerce') && function_exists('woocommerce_content')) : ?>
        
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-slider">
                    <?php
                    // Проверяем, есть ли слайдер через ACF или другой плагин
                    if (function_exists('get_field') && have_rows('hero_slides')) :
                        while (have_rows('hero_slides')) : the_row();
                            $image = get_sub_field('slide_image');
                            $title = get_sub_field('slide_title');
                            $description = get_sub_field('slide_description');
                            $button_text = get_sub_field('slide_button_text');
                            $button_url = get_sub_field('slide_button_url');
                            ?>
                            <div class="hero-slide" style="background-image: url('<?php echo esc_url($image); ?>');">
                                <div class="hero-content">
                                    <h2><?php echo esc_html($title); ?></h2>
                                    <p><?php echo esc_html($description); ?></p>
                                    <?php if ($button_text && $button_url) : ?>
                                        <a href="<?php echo esc_url($button_url); ?>" class="btn"><?php echo esc_html($button_text); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php
                        endwhile;
                    else :
                        // Если нет слайдера, показываем статический баннер
                        ?>
                        <div class="hero-slide" style="background-image: url('<?php echo esc_url(get_theme_mod('hero_image', get_template_directory_uri() . '/assets/images/hero-bg.jpg')); ?>');">
                            <div class="hero-content">
                                <h2><?php echo esc_html(get_theme_mod('hero_title', 'Благоустройство территорий и продажа товаров для благоустройства')); ?></h2>
                                <p><?php echo esc_html(get_theme_mod('hero_description', 'Мы предлагаем широкий ассортимент товаров для благоустройства школ, садов и других учреждений, а также услуги по монтажу и обслуживанию.')); ?></p>
                                <a href="<?php echo esc_url(get_theme_mod('hero_button_url', '/product-category/blagoustrojstvo-gorodov-i-parkov/')); ?>" class="btn"><?php echo esc_html(get_theme_mod('hero_button_text', 'Смотреть каталог')); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="categories-section">
            <div class="container">
                <h2 class="section-title"><?php esc_html_e('Категории товаров', 'landscaping-theme'); ?></h2>
                <div class="categories-grid">
                    <?php
                    $product_categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => false,
                        'parent' => 0,
                        'number' => 4,
                    ));

                    if (!empty($product_categories) && !is_wp_error($product_categories)) {
                        foreach ($product_categories as $category) {
                            $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                            $image = wp_get_attachment_url($thumbnail_id);
                            ?>
                            <div class="category-item">
                                <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                    <?php if ($image) : ?>
                                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>">
                                    <?php else : ?>
                                        <div class="no-image"></div>
                                    <?php endif; ?>
                                    <h3><?php echo esc_html($category->name); ?></h3>
                                    <p><?php echo esc_html($category->description); ?></p>
                                </a>
                            </div>
                            <?php
                        }
                    } else {
                        // Если категорий нет, показываем примеры
                        $demo_categories = array(
                            array(
                                'name' => 'Благоустройство городов и парков',
                                'description' => 'Скамейки, урны, ограждения и другие элементы для благоустройства городских территорий.',
                                'image' => get_template_directory_uri() . '/assets/images/category-1.jpg',
                            ),
                            array(
                                'name' => 'Детские площадки и игровые комплексы',
                                'description' => 'Качели, горки, карусели, песочницы и другие элементы для детских площадок.',
                                'image' => get_template_directory_uri() . '/assets/images/category-2.jpg',
                            ),
                            array(
                                'name' => 'Спортивное оборудование и инвентарь',
                                'description' => 'Тренажеры, спортивные комплексы, оборудование для различных видов спорта.',
                                'image' => get_template_directory_uri() . '/assets/images/category-3.jpg',
                            ),
                            array(
                                'name' => 'Специализированная мебель и безопасность',
                                'description' => 'Мебель для детских садов, школ, офисов, а также оборудование для безопасности.',
                                'image' => get_template_directory_uri() . '/assets/images/category-4.jpg',
                            ),
                        );

                        foreach ($demo_categories as $category) {
                            ?>
                            <div class="category-item">
                                <a href="#">
                                    <img src="<?php echo esc_url($category['image']); ?>" alt="<?php echo esc_attr($category['name']); ?>">
                                    <h3><?php echo esc_html($category['name']); ?></h3>
                                    <p><?php echo esc_html($category['description']); ?></p>
                                </a>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="text-center">
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn"><?php esc_html_e('Все категории', 'landscaping-theme'); ?></a>
                </div>
            </div>
        </section>

        <!-- Featured Products Section -->
        <section class="featured-products-section">
            <div class="container">
                <h2 class="section-title"><?php esc_html_e('Популярные товары', 'landscaping-theme'); ?></h2>
                <div class="products-grid">
                    <?php
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 8,
                        'meta_key' => 'total_sales',
                        'orderby' => 'meta_value_num',
                    );
                    $featured_products = new WP_Query($args);

                    if ($featured_products->have_posts()) :
                        while ($featured_products->have_posts()) : $featured_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    else :
                        // Если товаров нет, показываем сообщение
                        echo '<p class="no-products">' . esc_html__('Товары не найдены.', 'landscaping-theme') . '</p>';
                    endif;
                    ?>
                </div>
                <div class="text-center">
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn"><?php esc_html_e('Все товары', 'landscaping-theme'); ?></a>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services-section">
            <div class="container">
                <h2 class="section-title"><?php esc_html_e('Наши услуги', 'landscaping-theme'); ?></h2>
                <div class="services-grid">
                    <?php
                    $args = array(
                        'post_type' => 'service',
                        'posts_per_page' => 4,
                    );
                    $services = new WP_Query($args);

                    if ($services->have_posts()) :
                        while ($services->have_posts()) : $services->the_post();
                            ?>
                            <div class="service-item">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium'); ?>
                                    <?php else : ?>
                                        <div class="no-image"></div>
                                    <?php endif; ?>
                                    <h3><?php the_title(); ?></h3>
                                    <div class="service-excerpt"><?php the_excerpt(); ?></div>
                                </a>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        // Если услуг нет, показываем примеры
                        $demo_services = array(
                            array(
                                'title' => 'Подбор товара и оказание помощи при выборе товаров',
                                'excerpt' => 'Наши специалисты помогут вам выбрать оптимальные товары для благоустройства с учетом ваших потребностей и бюджета.',
                                'image' => get_template_directory_uri() . '/assets/images/service-1.jpg',
                            ),
                            array(
                                'title' => 'Доставка товаров и оборудования',
                                'excerpt' => 'Мы осуществляем доставку товаров и оборудования по всему Крыму и Севастополю.',
                                'image' => get_template_directory_uri() . '/assets/images/service-2.jpg',
                            ),
                            array(
                                'title' => 'Монтаж элементов благоустройства и прочего оборудования',
                                'excerpt' => 'Наши специалисты выполнят профессиональный монтаж всех элементов благоустройства и оборудования.',
                                'image' => get_template_directory_uri() . '/assets/images/service-3.jpg',
                            ),
                            array(
                                'title' => 'Обслуживание и ремонт МАФ и уличного оборудования',
                                'excerpt' => 'Мы предоставляем услуги по обслуживанию и ремонту малых архитектурных форм и уличного оборудования.',
                                'image' => get_template_directory_uri() . '/assets/images/service-4.jpg',
                            ),
                        );

                        foreach ($demo_services as $service) {
                            ?>
                            <div class="service-item">
                                <a href="#">
                                    <img src="<?php echo esc_url($service['image']); ?>" alt="<?php echo esc_attr($service['title']); ?>">
                                    <h3><?php echo esc_html($service['title']); ?></h3>
                                    <div class="service-excerpt"><?php echo esc_html($service['excerpt']); ?></div>
                                </a>
                            </div>
                            <?php
                        }
                    endif;
                    ?>
                </div>
                <div class="text-center">
                    <a href="<?php echo esc_url(get_post_type_archive_link('service')); ?>" class="btn"><?php esc_html_e('Все услуги', 'landscaping-theme'); ?></a>
                </div>
            </div>
        </section>

        <!-- Map Section -->
        <section class="map-section">
            <div class="container">
                <h2 class="section-title"><?php esc_html_e('Наши объекты на карте', 'landscaping-theme'); ?></h2>
                <div class="map-container">
                    <?php
                    // Проверяем, есть ли карта через ACF или другой плагин
                    if (function_exists('get_field') && get_field('map')) :
                        echo get_field('map');
                    elseif (function_exists('wpgmp_create_map') && shortcode_exists('put_wpgmp_map')) :
                        echo do_shortcode('[put_wpgmp_map id="1"]');
                    else :
                        // Если нет карты, показываем статическую карту
                        ?>
                        <div class="static-map">
                            <img src="<?php echo esc_url(get_theme_mod('map_image', get_template_directory_uri() . '/assets/images/map.jpg')); ?>" alt="<?php esc_attr_e('Карта объектов', 'landscaping-theme'); ?>">
                        </div>
                    <?php endif; ?>
                </div>
                <p class="map-description"><?php echo esc_html(get_theme_mod('map_description', 'Благоустройство городов и парковых территорий является одной из основных задач городских и других муниципальных властей. Мы успешно реализуем проекты по благоустройству в Крыму и городе Севастополе.')); ?></p>
            </div>
        </section>

        <!-- Contact Form Section -->
        <section class="contact-form-section">
            <div class="container">
                <h2 class="section-title"><?php esc_html_e('Связаться с нами', 'landscaping-theme'); ?></h2>
                <div class="contact-form-container">
                    <?php landscaping_theme_display_contact_form(); ?>
                </div>
            </div>
        </section>

        <?php else : ?>
            <div class="container">
                <div class="woocommerce-notice">
                    <p><?php esc_html_e('Для корректной работы сайта необходимо установить и активировать плагин WooCommerce.', 'landscaping-theme'); ?></p>
                </div>
                <?php the_content(); ?>
            </div>
        <?php endif; ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();