<?php
/**
 * Widget forms.
 *
 * @package    Search_In_Other_Blogs
 * @since      0.9.4
 * @author     Kostas Krevatas
 * @copyright  Copyright (c) 2017, Kostas Krevatas
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */
?>

<div class="siob-columns-3">

    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">
            <?php _e('Title', 'search-in-other-blogs'); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
    </p>

    <p>
        <?php
        $blog_list = get_blog_list(0, 'all');
        $blog_list = array_reverse($blog_list);
        $fid = 'blog_id';
        ?>
        <label for="<?php echo $this->get_field_id($fid); ?>">
            <?php _e('Blog source', 'search-in-other-blogs'); ?>
        </label>
        <select class="widefat" id="<?php echo $this->get_field_id($fid); ?>" name="<?php echo $this->get_field_name($fid); ?>" style="width:100%;">
            <?php foreach ($blog_list as $blog) { ?>
                <option value="<?php echo $blog[$fid]; ?>" <?php selected($instance['blog_id'], $blog[$fid]); ?>><?php echo esc_html(ucfirst($blog['path'])); ?></option>
            <?php } ?>
        </select>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('allresults_text'); ?>">
            <?php _e('Display all results text', 'search-in-other-blogs'); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id('allresults_text'); ?>"
               name="<?php echo $this->get_field_name('allresults_text'); ?>"
               type="text" value="<?php echo strip_tags($instance['allresults_text']); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('cssID'); ?>">
            <?php _e('CSS ID', 'search-in-other-blogs'); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id('cssID'); ?>" name="<?php echo $this->get_field_name('cssID'); ?>" type="text" value="<?php echo sanitize_html_class($instance['cssID']); ?>"/>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('css_class'); ?>">
            <?php _e('CSS Class', 'search-in-other-blogs'); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id('css_class'); ?>" name="<?php echo $this->get_field_name('css_class'); ?>" type="text" value="<?php echo sanitize_html_class($instance['css_class']); ?>"/>
    </p>

</div>

<div class="siob-columns-3">

    <p>
        <label for="<?php echo $this->get_field_id('post_status'); ?>">
            <?php _e('Post Status', 'search-in-other-blogs'); ?>
        </label>
        <select class="widefat" id="<?php echo $this->get_field_id('post_status'); ?>" name="<?php echo $this->get_field_name('post_status'); ?>" style="width:100%;">
            <?php foreach (get_available_post_statuses() as $status_value => $status_label) { ?>
                <option value="<?php echo esc_attr($status_label); ?>" <?php selected($instance['post_status'], $status_label); ?>><?php echo esc_html(ucfirst($status_label)); ?></option>
            <?php } ?>
        </select>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('order'); ?>">
            <?php _e('Order', 'search-in-other-blogs'); ?>
        </label>
        <select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>" style="width:100%;">
            <option value="DESC" <?php selected($instance['order'], 'DESC'); ?>><?php _e('Descending', 'siob') ?></option>
            <option value="ASC" <?php selected($instance['order'], 'ASC'); ?>><?php _e('Ascending', 'siob') ?></option>
        </select>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('orderby'); ?>">
            <?php _e('Orderby', 'search-in-other-blogs'); ?>
        </label>
        <select class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" style="width:100%;">
            <option value="ID" <?php selected($instance['orderby'], 'ID'); ?>><?php _e('ID', 'siob') ?></option>
            <option value="author" <?php selected($instance['orderby'], 'author'); ?>><?php _e('Author', 'siob') ?></option>
            <option value="relevance" <?php selected($instance['orderby'], 'relevance'); ?>><?php _e('Relevance', 'siob') ?></option>
            <option value="title" <?php selected($instance['orderby'], 'title'); ?>><?php _e('Title', 'siob') ?></option>
            <option value="date" <?php selected($instance['orderby'], 'date'); ?>><?php _e('Date', 'siob') ?></option>
            <option value="modified" <?php selected($instance['orderby'], 'modified'); ?>><?php _e('Modified', 'siob') ?></option>
            <option value="rand" <?php selected($instance['orderby'], 'rand'); ?>><?php _e('Random', 'siob') ?></option>
            <option value="menu_order" <?php selected($instance['orderby'], 'menu_order'); ?>><?php _e('Menu Order', 'siob') ?></option>


        </select>
    </p>
</div>

<div class="siob-columns-3 siob-column-last">

    <p>
        <label for="<?php echo $this->get_field_id('limit'); ?>">
            <?php _e('Number of posts to show', 'search-in-other-blogs'); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" step="1" min="-1" value="<?php echo (int) ( $instance['limit'] ); ?>" />
    </p>

    <?php if (current_theme_supports('post-thumbnails')) { ?>
        <p>
            <input id="<?php echo $this->get_field_id('thumb'); ?>" name="<?php echo $this->get_field_name('thumb'); ?>" type="checkbox" <?php checked($instance['thumb']); ?> />
            <label for="<?php echo $this->get_field_id('thumb'); ?>">
                <?php _e('Display Thumbnail', 'search-in-other-blogs'); ?>
            </label>
        </p>

        <p>
            <label class="siob-block" for="<?php echo $this->get_field_id('thumb_height'); ?>">
                <?php _e('Thumbnail (width,height,align)', 'search-in-other-blogs'); ?>
            </label>

            <input class="small-input" id="<?php echo $this->get_field_id('thumb_width'); ?>" name="<?php echo $this->get_field_name('thumb_width'); ?>" type="number" step="1" min="0" value="<?php echo (int) ( $instance['thumb_width'] ); ?>"/>
            <input class= "small-input" id="<?php echo $this->get_field_id('thumb_height'); ?>" name="<?php echo $this->get_field_name('thumb_height'); ?>" type="number" step="1" min="0" value="<?php echo (int) ( $instance['thumb_height'] ); ?>" />

            <select class="small-input" id="<?php echo $this->get_field_id('thumb_align'); ?>" name="<?php echo $this->get_field_name('thumb_align'); ?>">
                <option value="siob-alignleft" <?php selected($instance['thumb_align'], 'siob-alignleft'); ?>><?php _e('Left', 'search-in-other-blogs') ?></option>
                <option value="siob-alignright" <?php selected($instance['thumb_align'], 'siob-alignright'); ?>><?php _e('Right', 'search-in-other-blogs') ?></option>
                <option value="siob-aligncenter" <?php selected($instance['thumb_align'], 'siob-aligncenter'); ?>><?php _e('Center', 'search-in-other-blogs') ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('thumb_default'); ?>">
                <?php _e('Default Thumbnail', 'search-in-other-blogs'); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('thumb_default'); ?>" name="<?php echo $this->get_field_name('thumb_default'); ?>" type="text" value="<?php echo $instance['thumb_default']; ?>"/>
            <small><?php _e('Leave it blank to disable.', 'search-in-other-blogs'); ?></small>
        </p>

    <?php } ?>

    <p>
        <input id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="checkbox" <?php checked($instance['excerpt']); ?> />
        <label for="<?php echo $this->get_field_id('excerpt'); ?>">
            <?php _e('Display Excerpt', 'search-in-other-blogs'); ?>
        </label>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('length'); ?>">
            <?php _e('Excerpt Length', 'search-in-other-blogs'); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="number" step="1" min="0" value="<?php echo (int) ( $instance['length'] ); ?>" />
    </p>

    <p>
        <input id="<?php echo $this->get_field_id('readmore'); ?>" name="<?php echo $this->get_field_name('readmore'); ?>" type="checkbox" <?php checked($instance['readmore']); ?> />
        <label for="<?php echo $this->get_field_id('readmore'); ?>">
            <?php _e('Display Readmore', 'search-in-other-blogs'); ?>
        </label>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('readmore_text'); ?>">
            <?php _e('Readmore Text', 'search-in-other-blogs'); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id('readmore_text'); ?>" name="<?php echo $this->get_field_name('readmore_text'); ?>" type="text" value="<?php echo strip_tags($instance['readmore_text']); ?>" />
    </p>

    <p>
        <input id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" type="checkbox" <?php checked($instance['date']); ?> />
        <label for="<?php echo $this->get_field_id('date'); ?>">
            <?php _e('Display Date', 'search-in-other-blogs'); ?>
        </label>
    </p>

    <p>
        <input id="<?php echo $this->get_field_id('date_modified'); ?>" name="<?php echo $this->get_field_name('date_modified'); ?>" type="checkbox" <?php checked($instance['date_modified']); ?> />
        <label for="<?php echo $this->get_field_id('date_modified'); ?>">
            <?php _e('Display Modification Date', 'search-in-other-blogs'); ?>
        </label>
    </p>

    <p>
        <input id="<?php echo $this->get_field_id('date_relative'); ?>" name="<?php echo $this->get_field_name('date_relative'); ?>" type="checkbox" <?php checked($instance['date_relative']); ?> />
        <label for="<?php echo $this->get_field_id('date_relative'); ?>">
            <?php _e('Use Relative Date. eg: 5 days ago', 'search-in-other-blogs'); ?>
        </label>
    </p>


</div>

<div class="clear"></div>

<p>
    <input id="<?php echo $this->get_field_id('styles_default'); ?>" name="<?php echo $this->get_field_name('styles_default'); ?>" type="checkbox" <?php checked($instance['styles_default']); ?> />
    <label for="<?php echo $this->get_field_id('styles_default'); ?>">
        <?php _e('Add Default Styles', 'search-in-other-blogs'); ?>
    </label>
</p>

<p>
    <label for="<?php echo $this->get_field_id('css'); ?>">
        <?php _e('Add your custom CSS', 'search-in-other-blogs'); ?>
    </label>
    <textarea class="widefat" id="<?php echo $this->get_field_id('css'); ?>" name="<?php echo $this->get_field_name('css'); ?>" style="height:180px;"><?php echo $instance['css']; ?></textarea>
    <small><?php _e('If you turn off the default styles, you can use these css code to customize the posts style.', 'search-in-other-blogs'); ?></small>
</p>
