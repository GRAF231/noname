<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * @package Landscaping_Theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function landscaping_theme_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'landscaping_theme_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function landscaping_theme_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'landscaping_theme_pingback_header');

/**
 * Customize excerpt length
 */
function landscaping_theme_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'landscaping_theme_excerpt_length');

/**
 * Customize excerpt more
 */
function landscaping_theme_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'landscaping_theme_excerpt_more');

/**
 * Add custom image sizes
 */
function landscaping_theme_add_image_sizes() {
    add_image_size('landscaping-theme-featured', 1200, 600, true);
    add_image_size('landscaping-theme-thumbnail', 600, 400, true);
}
add_action('after_setup_theme', 'landscaping_theme_add_image_sizes');

/**
 * Add custom image sizes to media library
 */
function landscaping_theme_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'landscaping-theme-featured' => __('Featured Image', 'landscaping-theme'),
        'landscaping-theme-thumbnail' => __('Thumbnail Image', 'landscaping-theme'),
    ));
}
add_filter('image_size_names_choose', 'landscaping_theme_custom_image_sizes');

/**
 * Customize search form
 */
function landscaping_theme_search_form($form) {
    $form = '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">
        <label>
            <span class="screen-reader-text">' . _x('Поиск:', 'label', 'landscaping-theme') . '</span>
            <input type="search" class="search-field" placeholder="' . esc_attr_x('Поиск &hellip;', 'placeholder', 'landscaping-theme') . '" value="' . get_search_query() . '" name="s" />
        </label>
        <button type="submit" class="search-submit"><i class="fas fa-search"></i><span class="screen-reader-text">' . _x('Поиск', 'submit button', 'landscaping-theme') . '</span></button>
    </form>';

    return $form;
}
add_filter('get_search_form', 'landscaping_theme_search_form');

/**
 * Add custom styles to admin
 */
function landscaping_theme_admin_styles() {
    echo '<style>
        .editor-styles-wrapper {
            font-family: "Open Sans", sans-serif;
        }
        .editor-styles-wrapper h1,
        .editor-styles-wrapper h2,
        .editor-styles-wrapper h3,
        .editor-styles-wrapper h4,
        .editor-styles-wrapper h5,
        .editor-styles-wrapper h6 {
            font-family: "Montserrat", sans-serif;
            color: #2E7D32;
        }
        .editor-styles-wrapper a {
            color: #2E7D32;
        }
    </style>';
}
add_action('admin_head', 'landscaping_theme_admin_styles');

/**
 * Add custom styles to login page
 */
function landscaping_theme_login_styles() {
    echo '<style>
        .login h1 a {
            background-image: url(' . get_template_directory_uri() . '/assets/images/logo.png) !important;
            background-size: contain !important;
            width: 320px !important;
            height: 80px !important;
        }
        .login #backtoblog a, .login #nav a {
            color: #2E7D32 !important;
        }
        .wp-core-ui .button-primary {
            background: #2E7D32 !important;
            border-color: #2E7D32 !important;
        }
    </style>';
}
add_action('login_head', 'landscaping_theme_login_styles');

/**
 * Change login logo URL
 */
function landscaping_theme_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'landscaping_theme_login_logo_url');

/**
 * Change login logo title
 */
function landscaping_theme_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'landscaping_theme_login_logo_url_title');

/**
 * Add custom dashboard widget
 */
function landscaping_theme_dashboard_widget() {
    wp_add_dashboard_widget(
        'landscaping_theme_dashboard_widget',
        __('Landscaping Theme', 'landscaping-theme'),
        'landscaping_theme_dashboard_widget_content'
    );
}
add_action('wp_dashboard_setup', 'landscaping_theme_dashboard_widget');

/**
 * Dashboard widget content
 */
function landscaping_theme_dashboard_widget_content() {
    echo '<p>' . __('Добро пожаловать в Landscaping Theme! Это современная тема для компании, продающей товары для благоустройства школ, садов и других учреждений.', 'landscaping-theme') . '</p>';
    echo '<p>' . __('Для настройки темы перейдите в раздел "Внешний вид" > "Настроить".', 'landscaping-theme') . '</p>';
    echo '<p>' . __('Если у вас возникли вопросы, обратитесь к документации или свяжитесь с нами.', 'landscaping-theme') . '</p>';
}

/**
 * Add custom shortcodes
 */
function landscaping_theme_contact_form_shortcode() {
    ob_start();
    landscaping_theme_display_contact_form();
    return ob_get_clean();
}
add_shortcode('contact_form', 'landscaping_theme_contact_form_shortcode');

/**
 * Add custom widgets
 */
function landscaping_theme_register_widgets() {
    register_widget('Landscaping_Theme_Contact_Widget');
}
add_action('widgets_init', 'landscaping_theme_register_widgets');

/**
 * Contact Widget
 */
class Landscaping_Theme_Contact_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'landscaping_theme_contact_widget', // Base ID
            esc_html__('Landscaping Theme: Контакты', 'landscaping-theme'), // Name
            array('description' => esc_html__('Виджет для отображения контактной информации', 'landscaping-theme')) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        echo '<ul class="contact-info">';
        if (!empty($instance['address'])) {
            echo '<li><i class="fas fa-map-marker-alt"></i> ' . esc_html($instance['address']) . '</li>';
        }
        if (!empty($instance['phone'])) {
            echo '<li><i class="fas fa-phone"></i> ' . esc_html($instance['phone']) . '</li>';
        }
        if (!empty($instance['email'])) {
            echo '<li><i class="fas fa-envelope"></i> ' . esc_html($instance['email']) . '</li>';
        }
        echo '</ul>';

        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Контакты', 'landscaping-theme');
        $address = !empty($instance['address']) ? $instance['address'] : '';
        $phone = !empty($instance['phone']) ? $instance['phone'] : '';
        $email = !empty($instance['email']) ? $instance['email'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Заголовок:', 'landscaping-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('address')); ?>"><?php esc_attr_e('Адрес:', 'landscaping-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('address')); ?>" name="<?php echo esc_attr($this->get_field_name('address')); ?>" type="text" value="<?php echo esc_attr($address); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('phone')); ?>"><?php esc_attr_e('Телефон:', 'landscaping-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('phone')); ?>" name="<?php echo esc_attr($this->get_field_name('phone')); ?>" type="text" value="<?php echo esc_attr($phone); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php esc_attr_e('Email:', 'landscaping-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('email')); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" type="text" value="<?php echo esc_attr($email); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['address'] = (!empty($new_instance['address'])) ? sanitize_text_field($new_instance['address']) : '';
        $instance['phone'] = (!empty($new_instance['phone'])) ? sanitize_text_field($new_instance['phone']) : '';
        $instance['email'] = (!empty($new_instance['email'])) ? sanitize_email($new_instance['email']) : '';

        return $instance;
    }
}