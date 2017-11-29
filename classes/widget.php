<?php

/**
 * The custom recent posts widget.
 * This widget gives total control over the output to the user.
 *
 * @package    Search_In_Other_Blogs
 * @since      0.1
 * @author     Kostas Krevatas
 * @copyright  Copyright (c) 2017, Kostas Krevatas
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */
class Search_In_Other_Blogs extends WP_Widget
{

    /**
     * Sets up the widgets.
     *
     * @since 0.1
     */
    public function __construct()
    {

        /* Set up the widget options. */
        $widget_options = array(
            'classname' => 'siob_widget search-in-other-blogs',
            'description' => __('Displays search results widget from other blogs.', 'search-in-other-blogs'),
            'customize_selective_refresh' => true
        );

        $control_options = array(
            'width' => 750,
            'height' => 350
        );

        /* Create the widget. */
        parent::__construct(
                'siob_widget', // $this->id_base
                __('Search In Other Blogs', 'search-in-other-blogs'), // $this->name
                $widget_options, // $this->widget_options
                $control_options                                               // $this->control_options
        );

        $this->alt_option_name = 'siob_widget';
    }

    /**
     * Outputs the widget based on the arguments input through the widget controls.
     *
     * @since 0.1
     */
    public function widget($args, $instance)
    {
        if (!is_search()) {
            return;
        }

        extract($args);

        $searchd = siob_get_search_results($instance);

        if ($searchd) {

            // Output the theme's $before_widget wrapper.
            echo $before_widget;

            $tpl = $instance['title'];
            $searchTerm = esc_html(get_search_query(false));

            $blog = get_blog_details((int) $instance['blog_id']);
            $linkDomain = rtrim($blog->domain, '/')
                    . rtrim($blog->path, '/')
                    . '/?s=' . $searchTerm;

            $title = str_replace(array('{$search}'), array($searchTerm), $tpl);

            $moreA = esc_attr($instance['allresults_text']);

            echo $before_title . '<a target="_blank" href="'
                        . esc_url($linkDomain)
                        . '" title="' . esc_attr($title)
                        . '">' . apply_filters('widget_title', $title, $instance, $this->id_base)
                        //. (!empty($moreA)?"<small>$moreA</small>":'')
                        . '</a>' . $after_title;

            // Get the recent posts query.
            echo $searchd;


            if (!empty($moreA)) {
                echo '<a target="_blank" href="'
                        . esc_url($linkDomain)
                        . '" title="' . esc_attr($title)
                        . '" class="footer-link">' . $moreA
                        . '</a>' ;
            }

            // Close the theme's widget wrapper.
            echo $after_widget;
        }
    }

    /**
     * Updates the widget control options for the particular instance of the widget.
     *
     * @since 0.1
     */
    public function update($new_instance, $old_instance)
    {

        $types[] = 'post';

        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);

        $instance['blog_id'] = intval($new_instance['blog_id']);
        $instance['limit'] = intval($new_instance['limit']);
        $instance['order'] = stripslashes($new_instance['order']);
        $instance['orderby'] = stripslashes($new_instance['orderby']);
        $instance['post_type'] = $types;
        $instance['post_status'] = stripslashes($new_instance['post_status']);

        $instance['excerpt'] = isset($new_instance['excerpt']) ? (bool) $new_instance['excerpt'] : false;
        $instance['length'] = intval($new_instance['length']);
        $instance['date'] = isset($new_instance['date']) ? (bool) $new_instance['date'] : false;
        $instance['date_relative'] = isset($new_instance['date_relative']) ? (bool) $new_instance['date_relative'] : false;
        $instance['date_modified'] = isset($new_instance['date_modified']) ? (bool) $new_instance['date_modified'] : false;
        $instance['readmore'] = isset($new_instance['readmore']) ? (bool) $new_instance['readmore'] : false;
        $instance['readmore_text'] = sanitize_text_field($new_instance['readmore_text']);
        $instance['allresults_text'] = sanitize_text_field($new_instance['allresults_text']);

        $instance['thumb'] = isset($new_instance['thumb']) ? (bool) $new_instance['thumb'] : false;
        $instance['thumb_height'] = intval($new_instance['thumb_height']);
        $instance['thumb_width'] = intval($new_instance['thumb_width']);
        $instance['thumb_default'] = esc_url_raw($new_instance['thumb_default']);
        $instance['thumb_align'] = esc_attr($new_instance['thumb_align']);

        $instance['styles_default'] = isset($new_instance['styles_default']) ? (bool) $new_instance['styles_default'] : false;
        $instance['cssID'] = sanitize_html_class($new_instance['cssID']);
        $instance['css_class'] = sanitize_html_class($new_instance['css_class']);
        $instance['css'] = $new_instance['css'];

        return $instance;
    }

    /**
     * Displays the widget control options in the Widgets admin screen.
     *
     */
    public function form($instance)
    {

        // Merge the user-selected arguments with the defaults.
        $instance = wp_parse_args((array) $instance, siob_get_default_args());

        // Extract the array to allow easy use of variables.
        extract($instance);

        // Loads the widget form.
        include( SIOB_INCLUDES . 'form.php' );
    }

}
