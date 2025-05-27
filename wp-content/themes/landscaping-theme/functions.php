<?php
/**
 * Landscaping Theme functions and definitions
 *
 * @package Landscaping_Theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define theme constants
define('LANDSCAPING_THEME_VERSION', '1.0.0');
define('LANDSCAPING_THEME_DIR', get_template_directory());
define('LANDSCAPING_THEME_URI', get_template_directory_uri());

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function landscaping_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Enable support for HTML5 markup
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Add support for WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'landscaping-theme'),
        'footer'  => esc_html__('Footer Menu', 'landscaping-theme'),
    ));

    // Set content width
    if (!isset($content_width)) {
        $content_width = 1140;
    }
}
add_action('after_setup_theme', 'landscaping_theme_setup');

/**
 * Register widget areas.
 */
function landscaping_theme_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'landscaping-theme'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here to appear in your sidebar.', 'landscaping-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 1', 'landscaping-theme'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here to appear in the first footer column.', 'landscaping-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 2', 'landscaping-theme'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here to appear in the second footer column.', 'landscaping-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 3', 'landscaping-theme'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Add widgets here to appear in the third footer column.', 'landscaping-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 4', 'landscaping-theme'),
        'id'            => 'footer-4',
        'description'   => esc_html__('Add widgets here to appear in the fourth footer column.', 'landscaping-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'landscaping_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function landscaping_theme_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap', array(), null);

    // Enqueue Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), '5.15.3');

    // Enqueue main stylesheet
    wp_enqueue_style('landscaping-theme-style', get_stylesheet_uri(), array(), LANDSCAPING_THEME_VERSION);

    // Enqueue custom scripts
    wp_enqueue_script('landscaping-theme-navigation', LANDSCAPING_THEME_URI . '/js/navigation.js', array('jquery'), LANDSCAPING_THEME_VERSION, true);

    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'landscaping_theme_scripts');

/**
 * Custom template tags for this theme.
 */
require LANDSCAPING_THEME_DIR . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require LANDSCAPING_THEME_DIR . '/inc/extras.php';

/**
 * WooCommerce compatibility functions.
 */
if (class_exists('WooCommerce')) {
    require LANDSCAPING_THEME_DIR . '/inc/woocommerce.php';
}

/**
 * Create the required directories if they don't exist
 */
function landscaping_theme_create_directories() {
    // Create the inc directory
    if (!file_exists(LANDSCAPING_THEME_DIR . '/inc')) {
        mkdir(LANDSCAPING_THEME_DIR . '/inc', 0755);
    }

    // Create the js directory
    if (!file_exists(LANDSCAPING_THEME_DIR . '/js')) {
        mkdir(LANDSCAPING_THEME_DIR . '/js', 0755);
    }

    // Create the css directory
    if (!file_exists(LANDSCAPING_THEME_DIR . '/css')) {
        mkdir(LANDSCAPING_THEME_DIR . '/css', 0755);
    }

    // Create the template-parts directory
    if (!file_exists(LANDSCAPING_THEME_DIR . '/template-parts')) {
        mkdir(LANDSCAPING_THEME_DIR . '/template-parts', 0755);
    }

    // Create the template-parts/content directory
    if (!file_exists(LANDSCAPING_THEME_DIR . '/template-parts/content')) {
        mkdir(LANDSCAPING_THEME_DIR . '/template-parts/content', 0755);
    }
}
add_action('after_switch_theme', 'landscaping_theme_create_directories');

/**
 * Custom function to display the contact form on every page
 */
function landscaping_theme_display_contact_form() {
    if (function_exists('wpcf7_contact_form')) {
        $contact_form_id = 1; // Replace with your contact form ID
        echo do_shortcode('[contact-form-7 id="' . $contact_form_id . '" title="Contact Form"]');
    } else {
        echo '<div class="contact-form">';
        echo '<h3>' . esc_html__('Связаться с нами', 'landscaping-theme') . '</h3>';
        echo '<form action="#" method="post">';
        echo '<div class="form-group">';
        echo '<input type="text" name="name" class="form-control" placeholder="' . esc_attr__('Ваше имя', 'landscaping-theme') . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<input type="email" name="email" class="form-control" placeholder="' . esc_attr__('Ваш email', 'landscaping-theme') . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<input type="tel" name="phone" class="form-control" placeholder="' . esc_attr__('Ваш телефон', 'landscaping-theme') . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<textarea name="message" class="form-control" rows="5" placeholder="' . esc_attr__('Ваше сообщение', 'landscaping-theme') . '" required></textarea>';
        echo '</div>';
        echo '<button type="submit" class="btn">' . esc_html__('Отправить', 'landscaping-theme') . '</button>';
        echo '</form>';
        echo '</div>';
    }
}

/**
 * Custom function to display the cart icon in the header
 */
function landscaping_theme_cart_icon() {
    if (class_exists('WooCommerce')) {
        $cart_count = WC()->cart->get_cart_contents_count();
        $cart_url = wc_get_cart_url();

        echo '<a href="' . esc_url($cart_url) . '" class="header-cart">';
        echo '<i class="fas fa-shopping-cart"></i>';
        if ($cart_count > 0) {
            echo '<span class="cart-count">' . esc_html($cart_count) . '</span>';
        }
        echo '</a>';
    }
}

/**
 * Custom function to display the search form
 */
function landscaping_theme_search_form() {
    echo '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">';
    echo '<input type="search" class="search-field" placeholder="' . esc_attr__('Поиск товаров...', 'landscaping-theme') . '" value="' . get_search_query() . '" name="s" />';
    echo '<input type="hidden" name="post_type" value="product" />';
    echo '<button type="submit" class="search-submit"><i class="fas fa-search"></i></button>';
    echo '</form>';
}

/**
 * Register Custom Post Type for Services
 */
function landscaping_theme_register_services_post_type() {
    $labels = array(
        'name'                  => _x('Услуги', 'Post Type General Name', 'landscaping-theme'),
        'singular_name'         => _x('Услуга', 'Post Type Singular Name', 'landscaping-theme'),
        'menu_name'             => __('Услуги', 'landscaping-theme'),
        'name_admin_bar'        => __('Услуга', 'landscaping-theme'),
        'archives'              => __('Архивы услуг', 'landscaping-theme'),
        'attributes'            => __('Атрибуты услуги', 'landscaping-theme'),
        'parent_item_colon'     => __('Родительская услуга:', 'landscaping-theme'),
        'all_items'             => __('Все услуги', 'landscaping-theme'),
        'add_new_item'          => __('Добавить новую услугу', 'landscaping-theme'),
        'add_new'               => __('Добавить новую', 'landscaping-theme'),
        'new_item'              => __('Новая услуга', 'landscaping-theme'),
        'edit_item'             => __('Редактировать услугу', 'landscaping-theme'),
        'update_item'           => __('Обновить услугу', 'landscaping-theme'),
        'view_item'             => __('Просмотреть услугу', 'landscaping-theme'),
        'view_items'            => __('Просмотреть услуги', 'landscaping-theme'),
        'search_items'          => __('Искать услугу', 'landscaping-theme'),
        'not_found'             => __('Не найдено', 'landscaping-theme'),
        'not_found_in_trash'    => __('Не найдено в корзине', 'landscaping-theme'),
        'featured_image'        => __('Изображение услуги', 'landscaping-theme'),
        'set_featured_image'    => __('Установить изображение услуги', 'landscaping-theme'),
        'remove_featured_image' => __('Удалить изображение услуги', 'landscaping-theme'),
        'use_featured_image'    => __('Использовать как изображение услуги', 'landscaping-theme'),
        'insert_into_item'      => __('Вставить в услугу', 'landscaping-theme'),
        'uploaded_to_this_item' => __('Загружено для этой услуги', 'landscaping-theme'),
        'items_list'            => __('Список услуг', 'landscaping-theme'),
        'items_list_navigation' => __('Навигация по списку услуг', 'landscaping-theme'),
        'filter_items_list'     => __('Фильтровать список услуг', 'landscaping-theme'),
    );
    $args = array(
        'label'                 => __('Услуга', 'landscaping-theme'),
        'description'           => __('Услуги компании', 'landscaping-theme'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-hammer',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'rewrite'               => array('slug' => 'services'),
    );
    register_post_type('service', $args);
}
add_action('init', 'landscaping_theme_register_services_post_type');

/**
 * ACF JSON save and load points
 */
if (function_exists('acf_add_local_field_group')) {
    // Автоматическая синхронизация полей ACF
    add_filter('acf/settings/save_json', 'landscaping_theme_acf_json_save_point');
    function landscaping_theme_acf_json_save_point($path) {
        $path = get_stylesheet_directory() . '/acf-json';
        return $path;
    }

    add_filter('acf/settings/load_json', 'landscaping_theme_acf_json_load_point');
    function landscaping_theme_acf_json_load_point($paths) {
        unset($paths[0]);
        $paths[] = get_stylesheet_directory() . '/acf-json';
        return $paths;
    }
}