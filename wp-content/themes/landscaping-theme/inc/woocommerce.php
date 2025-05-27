<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Landscaping_Theme
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 *
 * @return void
 */
function landscaping_theme_woocommerce_setup() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'landscaping_theme_woocommerce_setup');

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function landscaping_theme_woocommerce_scripts() {
    wp_enqueue_style('landscaping-theme-woocommerce-style', get_template_directory_uri() . '/css/woocommerce.css', array(), LANDSCAPING_THEME_VERSION);

    $font_path   = WC()->plugin_url() . '/assets/fonts/';
    $inline_font = '@font-face {
            font-family: "star";
            src: url("' . $font_path . 'star.eot");
            src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
                url("' . $font_path . 'star.woff") format("woff"),
                url("' . $font_path . 'star.ttf") format("truetype"),
                url("' . $font_path . 'star.svg#star") format("svg");
            font-weight: normal;
            font-style: normal;
        }';

    wp_add_inline_style('landscaping-theme-woocommerce-style', $inline_font);
}
add_action('wp_enqueue_scripts', 'landscaping_theme_woocommerce_scripts');

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function landscaping_theme_woocommerce_active_body_class($classes) {
    $classes[] = 'woocommerce-active';

    return $classes;
}
add_filter('body_class', 'landscaping_theme_woocommerce_active_body_class');

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function landscaping_theme_woocommerce_related_products_args($args) {
    $defaults = array(
        'posts_per_page' => 4,
        'columns'        => 4,
    );

    $args = wp_parse_args($defaults, $args);

    return $args;
}
add_filter('woocommerce_output_related_products_args', 'landscaping_theme_woocommerce_related_products_args');

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if (!function_exists('landscaping_theme_woocommerce_wrapper_before')) {
    /**
     * Before Content.
     *
     * Wraps all WooCommerce content in wrappers which match the theme markup.
     *
     * @return void
     */
    function landscaping_theme_woocommerce_wrapper_before() {
        ?>
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
        <?php
    }
}
add_action('woocommerce_before_main_content', 'landscaping_theme_woocommerce_wrapper_before');

if (!function_exists('landscaping_theme_woocommerce_wrapper_after')) {
    /**
     * After Content.
     *
     * Closes the wrapping divs.
     *
     * @return void
     */
    function landscaping_theme_woocommerce_wrapper_after() {
        ?>
                        </div>
                        <div class="col-md-4">
                            <?php get_sidebar(); ?>
                        </div>
                    </div>
                </div>
            </main><!-- #main -->
        </div><!-- #primary -->
        <?php
    }
}
add_action('woocommerce_after_main_content', 'landscaping_theme_woocommerce_wrapper_after');

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
 * <?php
 * if ( function_exists( 'landscaping_theme_woocommerce_header_cart' ) ) {
 *     landscaping_theme_woocommerce_header_cart();
 * }
 * ?>
 */

if (!function_exists('landscaping_theme_woocommerce_cart_link_fragment')) {
    /**
     * Cart Fragments.
     *
     * Ensure cart contents update when products are added to the cart via AJAX.
     *
     * @param array $fragments Fragments to refresh via AJAX.
     * @return array Fragments to refresh via AJAX.
     */
    function landscaping_theme_woocommerce_cart_link_fragment($fragments) {
        ob_start();
        landscaping_theme_woocommerce_cart_link();
        $fragments['a.cart-contents'] = ob_get_clean();

        return $fragments;
    }
}
add_filter('woocommerce_add_to_cart_fragments', 'landscaping_theme_woocommerce_cart_link_fragment');

if (!function_exists('landscaping_theme_woocommerce_cart_link')) {
    /**
     * Cart Link.
     *
     * Displayed a link to the cart including the number of items present and the cart total.
     *
     * @return void
     */
    function landscaping_theme_woocommerce_cart_link() {
        ?>
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('Просмотр корзины', 'landscaping-theme'); ?>">
            <i class="fas fa-shopping-cart"></i>
            <span class="count"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span>
        </a>
        <?php
    }
}

if (!function_exists('landscaping_theme_woocommerce_header_cart')) {
    /**
     * Display Header Cart.
     *
     * @return void
     */
    function landscaping_theme_woocommerce_header_cart() {
        if (is_cart()) {
            $class = 'current-menu-item';
        } else {
            $class = '';
        }
        ?>
        <div id="site-header-cart" class="site-header-cart">
            <div class="<?php echo esc_attr($class); ?>">
                <?php landscaping_theme_woocommerce_cart_link(); ?>
            </div>
            <div class="cart-dropdown">
                <?php
                $instance = array(
                    'title' => '',
                );

                the_widget('WC_Widget_Cart', $instance);
                ?>
            </div>
        </div>
        <?php
    }
}

/**
 * Customize WooCommerce product columns
 */
function landscaping_theme_woocommerce_loop_columns() {
    return 3;
}
add_filter('loop_shop_columns', 'landscaping_theme_woocommerce_loop_columns');

/**
 * Customize WooCommerce products per page
 */
function landscaping_theme_woocommerce_products_per_page() {
    return 12;
}
add_filter('loop_shop_per_page', 'landscaping_theme_woocommerce_products_per_page');

/**
 * Customize WooCommerce breadcrumbs
 */
function landscaping_theme_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => ' &rsaquo; ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => _x('Главная', 'breadcrumb', 'landscaping-theme'),
    );
}
add_filter('woocommerce_breadcrumb_defaults', 'landscaping_theme_woocommerce_breadcrumbs');

/**
 * Add contact form to single product page
 */
function landscaping_theme_woocommerce_after_single_product() {
    ?>
    <div class="product-contact-form">
        <h3><?php esc_html_e('Связаться с нами по поводу этого товара', 'landscaping-theme'); ?></h3>
        <?php landscaping_theme_display_contact_form(); ?>
    </div>
    <?php
}
add_action('woocommerce_after_single_product', 'landscaping_theme_woocommerce_after_single_product');