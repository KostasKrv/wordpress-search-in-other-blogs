<?php

/**
 * Various functions used by the plugin.
 *
 * @package    Search_In_Other_Blogs
 * @author     Kostas Krevatas
 * @copyright  Copyright (c) 2017, Kostas Krevatas
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Sets up the default arguments.
 *
 */
function siob_get_default_args()
{
    $defaults = array(
        'title' => esc_attr__('Search results for "{$search}"', 'siob'),
        'limit' => 5,
        'offset' => 0,
        'order' => 'DESC',
        'orderby' => 'relevance',
        'post_status' => 'publish',
        'excerpt' => false,
        'length' => 10,
        'thumb' => true,
        'thumb_height' => 45,
        'thumb_width' => 45,
        'thumb_default' => 'http://placehold.it/45x45/f0f0f0/ccc',
        'thumb_align' => 'siob-alignleft',
        'date' => true,
        'date_relative' => false,
        'date_modified' => false,
        'readmore' => false,
        'readmore_text' => __('Read More &raquo;', 'search-in-other-blogs'),
        'allresults_text' => __('More results &raquo;', 'search-in-other-blogs'),
        'styles_default' => true,
        'css' => '',
        'cssID' => '',
        'css_class' => '',
    );

    // Allow plugins/themes developer to filter the default arguments.
    return apply_filters('siob_default_args', $defaults);
}

/**
 * Generates the posts markup.
 *
 * @param  array  $args
 * @return string|array The HTML for the random posts.
 */
function siob_get_search_results($args = array())
{

    // Set up a default, empty variable.
    $html = '';

    // Merge the input arguments and the defaults.
    $args = wp_parse_args($args, siob_get_default_args());

    // Extract the array to allow easy use of variables.
    extract($args);

    // Allow devs to hook in stuff before the loop.
    do_action('siob_before_loop');

    // Display the default style of the plugin.
    if ($args['styles_default'] === true) {
        siob_custom_styles();
    }

    // If the default style is disabled then use the custom css if it's not empty.
    if (!empty($args['css'])) {
        echo '<style>' . $args['css'] . '</style>';
    }

    // Get the posts query.
    $query_args = siob_get_search_args($args);

    switch_to_blog($args['blog_id']);
    $posts = new WP_Query($query_args);

    if ($posts->have_posts()) :

        // Recent posts wrapper
        $html = '<div ' . (!empty($args['cssID']) ? 'id="' . sanitize_html_class($args['cssID']) . '"' : '' ) . ' class="siob-block ' . (!empty($args['css_class']) ? '' . sanitize_html_class($args['css_class']) . '' : '' ) . '">';

        $html .= '<ul class="siob-ul">';

        while ($posts->have_posts()) : $posts->the_post();

            // Thumbnails
            $thumb_id = get_post_thumbnail_id(); // Get the featured image id.
            $img_url = wp_get_attachment_url($thumb_id); // Get img URL.
            // Display the image url and crop using the resizer.
            $image = siob_resize($img_url, $args['thumb_width'], $args['thumb_height'], true);

            // Start recent posts markup.
            $html .= '<li class="siob-li siob-clearfix">';

            if ($args['thumb']) :

                // Check if post has post thumbnail.
                if (has_post_thumbnail()) :
                    $html .= '<a class="siob-img" href="' . esc_url(get_permalink()) . '"  rel="bookmark">';
                    if ($image) :
                        $html .= '<img class="' . esc_attr($args['thumb_align']) . ' siob-thumb" src="' . esc_url($image) . '" alt="' . esc_attr(get_the_title()) . '">';
                    else :
                        $html .= get_the_post_thumbnail(get_the_ID(), array($args['thumb_width'], $args['thumb_height']), array(
                            'class' => $args['thumb_align'] . ' siob-thumb the-post-thumbnail',
                            'alt' => esc_attr(get_the_title())
                                )
                        );
                    endif;
                    $html .= '</a>';

                // If no post thumbnail found, check if Get The Image plugin exist and display the image.
                elseif (function_exists('get_the_image')) :
                    $html .= get_the_image(array(
                        'height' => (int) $args['thumb_height'],
                        'width' => (int) $args['thumb_width'],
                        'image_class' => esc_attr($args['thumb_align']) . ' siob-thumb get-the-image',
                        'image_scan' => true,
                        'echo' => false,
                        'default_image' => esc_url($args['thumb_default'])
                    ));

                // Display default image.
                elseif (!empty($args['thumb_default'])) :
                    $html .= sprintf('<a class="siob-img" href="%1$s" rel="bookmark"><img class="%2$s siob-thumb siob-default-thumb" src="%3$s" alt="%4$s" width="%5$s" height="%6$s"></a>', esc_url(get_permalink()), esc_attr($args['thumb_align']), esc_url($args['thumb_default']), esc_attr(get_the_title()), (int) $args['thumb_width'], (int) $args['thumb_height']
                    );

                endif;

            endif;

            $html .= '<h3 class="siob-title"><a href="' . esc_url(get_permalink()) . '" title="' . sprintf(esc_attr__('Permalink to %s', 'recent-posts-widget-extended'), the_title_attribute('echo=0')) . '" rel="bookmark">' . esc_attr(get_the_title()) . '</a></h3>';

            if ($args['date']) :
                $date = get_the_date();
                if ($args['date_relative']) :
                    $date = sprintf(__('%s ago', 'recent-posts-widget-extended'), human_time_diff(get_the_date('U'), current_time('timestamp')));
                endif;
                $html .= '<time class="siob-time published" datetime="' . esc_html(get_the_date('c')) . '">' . esc_html($date) . '</time>';
            elseif ($args['date_modified']) : // if both date functions are provided, we use date to be backwards compatible
                $date = get_the_modified_date();
                if ($args['date_relative']) :
                    $date = sprintf(__('%s ago', 'recent-posts-widget-extended'), human_time_diff(get_the_modified_date('U'), current_time('timestamp')));
                endif;
                $html .= '<time class="siob-time modfied" datetime="' . esc_html(get_the_modified_date('c')) . '">' . esc_html($date) . '</time>';
            endif;

            if ($args['comment_count']) :
                if (get_comments_number() == 0) {
                    $comments = __('No Comments', 'recent-posts-widget-extended');
                } elseif (get_comments_number() > 1) {
                    $comments = sprintf(__('%s Comments', 'recent-posts-widget-extended'), get_comments_number());
                } else {
                    $comments = __('1 Comment', 'recent-posts-widget-extended');
                }
                $html .= '<a class="siob-comment comment-count" href="' . get_comments_link() . '">' . $comments . '</a>';
            endif;

            if ($args['excerpt']) :
                $html .= '<div class="siob-summary">';
                $html .= wp_trim_words(apply_filters('siob_excerpt', get_the_excerpt()), $args['length'], ' &hellip;');
                if ($args['readmore']) :
                    $html .= '<a href="' . esc_url(get_permalink()) . '" class="more-link">' . $args['readmore_text'] . '</a>';
                endif;
                $html .= '</div>';
            endif;

            $html .= '</li>';

        endwhile;

        $html .= '</ul>';

        $html .= '</div><!-- Generated by Search in other blogs -->';

    endif;

    // Restore original Post Data.
    wp_reset_postdata();
    restore_current_blog();

    // Allow devs to hook in stuff after the loop.
    do_action('siob_after_loop');

    // Return the  posts markup.
    return wp_kses_post($args['before']) . apply_filters('siob_markup', $html) . wp_kses_post($args['after']);
}

/**
 * The posts query.
 *
 * @param  array  $args
 * @return array
 */
function siob_get_search_args($args = array())
{
    $search_string = esc_html(get_search_query(false));

    // Query arguments.
    $query = array(
        's'                 => $search_string,
        'posts_per_page'    => $args['limit'],
        'orderby'           => $args['orderby'],
        'order'             => $args['order'],
        'post_status'       => $args['post_status'],
    );

    return $query;
}

/**
 * Default Styles.
 *
 */
function siob_custom_styles()
{
    echo '<!-- Default style from Search in other blogs plugin -->';
    echo '<style type="text/css">'
    . file_get_contents(dirname(__FILE__) . '/../assets/css/default-style.css')
    . '</style>';
}
