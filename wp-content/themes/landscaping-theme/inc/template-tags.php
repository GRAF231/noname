<?php
/**
 * Custom template tags for this theme
 *
 * @package Landscaping_Theme
 */

if (!function_exists('landscaping_theme_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function landscaping_theme_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x('Опубликовано %s', 'post date', 'landscaping-theme'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on"><i class="fas fa-calendar-alt"></i> ' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('landscaping_theme_posted_by')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function landscaping_theme_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x('Автор %s', 'post author', 'landscaping-theme'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"><i class="fas fa-user"></i> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('landscaping_theme_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function landscaping_theme_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'landscaping-theme'));
            if ($categories_list) {
                /* translators: 1: list of categories. */
                printf('<span class="cat-links"><i class="fas fa-folder"></i> ' . esc_html__('Категории: %1$s', 'landscaping-theme') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'landscaping-theme'));
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<span class="tags-links"><i class="fas fa-tags"></i> ' . esc_html__('Метки: %1$s', 'landscaping-theme') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link"><i class="fas fa-comments"></i> ';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __('Оставить комментарий<span class="screen-reader-text"> к %s</span>', 'landscaping-theme'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Редактировать<span class="screen-reader-text"> %s</span>', 'landscaping-theme'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ),
            '<span class="edit-link"><i class="fas fa-edit"></i> ',
            '</span>'
        );
    }
endif;

if (!function_exists('landscaping_theme_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function landscaping_theme_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>

            <div class="post-thumbnail">
                <?php the_post_thumbnail('large'); ?>
            </div><!-- .post-thumbnail -->

        <?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail(
                    'medium',
                    array(
                        'alt' => the_title_attribute(
                            array(
                                'echo' => false,
                            )
                        ),
                    )
                );
                ?>
            </a>

        <?php
        endif; // End is_singular().
    }
endif;

if (!function_exists('landscaping_theme_comment')) :
    /**
     * Template for comments and pingbacks.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     * @param object $comment Comment to display.
     * @param array  $args    Arguments passed to wp_list_comments().
     * @param int    $depth   Depth of comment.
     */
    function landscaping_theme_comment($comment, $args, $depth) {
        if ('pingback' === $comment->comment_type || 'trackback' === $comment->comment_type) :
            ?>

            <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
                <div class="comment-body">
                    <?php esc_html_e('Пингбэк:', 'landscaping-theme'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(esc_html__('Редактировать', 'landscaping-theme'), '<span class="edit-link">', '</span>'); ?>
                </div>

            <?php
        else :
            ?>

            <li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>
                <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                    <footer class="comment-meta">
                        <div class="comment-author vcard">
                            <?php
                            if (0 !== $args['avatar_size']) {
                                echo get_avatar($comment, $args['avatar_size']);
                            }
                            ?>
                            <?php
                            /* translators: %s: comment author link */
                            printf(
                                '<b class="fn">%s</b>',
                                get_comment_author_link()
                            );
                            ?>
                        </div><!-- .comment-author -->

                        <div class="comment-metadata">
                            <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                                <time datetime="<?php comment_time('c'); ?>">
                                    <?php
                                    /* translators: 1: comment date, 2: comment time */
                                    printf(esc_html__('%1$s в %2$s', 'landscaping-theme'), get_comment_date(), get_comment_time());
                                    ?>
                                </time>
                            </a>
                            <?php edit_comment_link(esc_html__('Редактировать', 'landscaping-theme'), '<span class="edit-link">', '</span>'); ?>
                        </div><!-- .comment-metadata -->

                        <?php if ('0' === $comment->comment_approved) : ?>
                            <p class="comment-awaiting-moderation"><?php esc_html_e('Ваш комментарий ожидает модерации.', 'landscaping-theme'); ?></p>
                        <?php endif; ?>
                    </footer><!-- .comment-meta -->

                    <div class="comment-content">
                        <?php comment_text(); ?>
                    </div><!-- .comment-content -->

                    <?php
                    comment_reply_link(
                        array_merge(
                            $args,
                            array(
                                'add_below' => 'div-comment',
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth'],
                                'before'    => '<div class="reply">',
                                'after'     => '</div>',
                            )
                        )
                    );
                    ?>
                </article><!-- .comment-body -->

            <?php
        endif;
    }
endif;

if (!function_exists('landscaping_theme_breadcrumbs')) :
    /**
     * Display breadcrumbs
     */
    function landscaping_theme_breadcrumbs() {
        if (function_exists('yoast_breadcrumb')) {
            yoast_breadcrumb('<div class="breadcrumbs">', '</div>');
        } elseif (function_exists('rank_math_the_breadcrumbs')) {
            rank_math_the_breadcrumbs();
        } else {
            echo '<div class="breadcrumbs">';
            echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Главная', 'landscaping-theme') . '</a>';

            if (is_category() || is_single()) {
                echo ' &rsaquo; ';
                $categories = get_the_category();
                if (!empty($categories)) {
                    echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
                }

                if (is_single()) {
                    echo ' &rsaquo; ';
                    the_title();
                }
            } elseif (is_page()) {
                echo ' &rsaquo; ';
                the_title();
            } elseif (is_search()) {
                echo ' &rsaquo; ' . esc_html__('Результаты поиска для', 'landscaping-theme') . ' "' . get_search_query() . '"';
            } elseif (is_tag()) {
                echo ' &rsaquo; ' . esc_html__('Записи с меткой', 'landscaping-theme') . ' "' . single_tag_title('', false) . '"';
            } elseif (is_author()) {
                echo ' &rsaquo; ' . esc_html__('Архив автора', 'landscaping-theme');
            } elseif (is_archive()) {
                if (is_day()) {
                    echo ' &rsaquo; ' . esc_html__('Архив за', 'landscaping-theme') . ' ' . get_the_date();
                } elseif (is_month()) {
                    echo ' &rsaquo; ' . esc_html__('Архив за', 'landscaping-theme') . ' ' . get_the_date('F Y');
                } elseif (is_year()) {
                    echo ' &rsaquo; ' . esc_html__('Архив за', 'landscaping-theme') . ' ' . get_the_date('Y');
                } else {
                    echo ' &rsaquo; ' . esc_html__('Архив', 'landscaping-theme');
                }
            }

            echo '</div>';
        }
    }
endif;