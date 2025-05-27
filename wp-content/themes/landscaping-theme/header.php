<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Landscaping_Theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'landscaping-theme'); ?></a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-top">
                <div class="site-branding">
                    <?php
                    if (has_custom_logo()) :
                        the_custom_logo();
                    else :
                    ?>
                        <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                        <?php
                        $landscaping_theme_description = get_bloginfo('description', 'display');
                        if ($landscaping_theme_description || is_customize_preview()) :
                        ?>
                            <p class="site-description"><?php echo $landscaping_theme_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div><!-- .site-branding -->

                <div class="header-contact">
                    <div class="header-phone">
                        <i class="fas fa-phone"></i> <?php echo esc_html(get_theme_mod('header_phone', '+7 (978) 742-85-95')); ?>
                    </div>
                    <div class="header-email">
                        <i class="fas fa-envelope"></i> <?php echo esc_html(get_theme_mod('header_email', 'info@example.com')); ?>
                    </div>
                    <?php landscaping_theme_cart_icon(); ?>
                </div>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <i class="fas fa-bars"></i> <?php esc_html_e('Menu', 'landscaping-theme'); ?>
                </button>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'menu',
                        'container'      => false,
                    )
                );
                ?>
            </nav><!-- #site-navigation -->

            <?php landscaping_theme_search_form(); ?>
        </div>
    </header><!-- #masthead -->

    <div id="content" class="site-content">