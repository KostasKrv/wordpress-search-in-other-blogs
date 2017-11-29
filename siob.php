<?php

/**
 * Plugin Name:  Search in other blogs
 * Plugin URI:   https://www.theme-junkie.com/plugins/recent-posts-widget-extended/
 * Description:  Enables search results widget from other blogs
 * Version:      0.9.6.1
 * Author:       Kostas Krevatas
 * Author URI:   http://kostas.krevatas.net
 * Author Email: k_krevatas@Kostas Krevatas.gr
 * Text Domain:  search-in-other-blogs
 * Domain Path:  /languages
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Search_In_Other_Blogs
 * @since      0.1
 * @author     Kostas Krevatas
 * @copyright  Copyright (c) 2017, Kostas Krevatas
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

class siob
{

    /**
     * PHP5 constructor method.
     *
     * @since  0.1
     */
    public function __construct()
    {

        // Set the constants needed by the plugin.
        add_action('plugins_loaded', array(&$this, 'constants'), 1);

        // Internationalize the text strings used.
        add_action('plugins_loaded', array(&$this, 'i18n'), 2);

        // Load the functions files.
        add_action('plugins_loaded', array(&$this, 'includes'), 3);

        // Load the admin style.
        add_action('admin_enqueue_scripts', array(&$this, 'admin_style'));

        // Register widget.
        add_action('widgets_init', array(&$this, 'register_widget'));

        // Register new image size.
        add_action('init', array(&$this, 'register_image_size'));
    }

    /**
     * Defines constants used by the plugin.
     *
     * @since  0.1
     */
    public function constants()
    {

        // Set constant path to the plugin directory.
        define('SIOB_DIR', trailingslashit(plugin_dir_path(__FILE__)));

        // Set the constant path to the plugin directory URI.
        define('SIOB_URI', trailingslashit(plugin_dir_url(__FILE__)));

        // Set the constant path to the includes directory.
        define('SIOB_INCLUDES', SIOB_DIR . trailingslashit('includes'));

        // Set the constant path to the includes directory.
        define('SIOB_CLASS', SIOB_DIR . trailingslashit('classes'));

        // Set the constant path to the assets directory.
        define('SIOB_ASSETS', SIOB_URI . trailingslashit('assets'));
    }

    /**
     * Loads the translation files.
     *
     * @since  0.1
     */
    public function i18n()
    {
        load_plugin_textdomain('recent-posts-widget-extended', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /**
     * Loads the initial files needed by the plugin.
     *
     * @since  0.1
     */
    public function includes()
    {
        require_once( SIOB_INCLUDES . 'resizer.php' );
        require_once( SIOB_INCLUDES . 'functions.php' );
        require_once( SIOB_INCLUDES . 'shortcode.php' );
        require_once( SIOB_INCLUDES . 'helpers.php' );
    }

    /**
     * Register custom style for the widget settings.
     *
     * @since  0.8
     */
    public function admin_style()
    {
        // Loads the widget style.
        wp_enqueue_style('siob-admin-style', trailingslashit(SIOB_ASSETS) . 'css/siob-admin.css', null, null);
    }

    /**
     * Register the widget.
     *
     * @since  0.9.1
     */
    public function register_widget()
    {
        require_once( SIOB_CLASS . 'widget.php' );
        register_widget('Search_In_Other_Blogs');
    }

    /**
     * Register new image size.
     *
     * @since  0.9.4
     */
    function register_image_size()
    {
        add_image_size('siob-thumbnail', 45, 45, true);
    }

}

new siob;
