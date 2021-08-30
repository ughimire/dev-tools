<?php
/*
 * Plugin Name:Add All Widgets on all sidebars in single click
 * Plugin URI: 
 * Author: Umesh Ghimire
 * Author URI: profiles.wordpress.org/ughimire1
 * Description: Add All Widgets on all sidebars in single click
 * Version: 1.0.0
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Tags: one-column, two-columns, right-sidebar, custom-header, custom-menu, editor-style, featured-images, microformats, post-formats, rtl-language-support, sticky-post, translation-ready
 * Text Domain: blogmagazine-pro

This theme, like WordPress, is licensed under the GPL.
Use it to make something cool, have fun, and share what you've learned with others.
*/

if (!class_exists('DG_DEV_TOOLS')):

    class DG_DEV_TOOLS
    {

        public function __construct()
        {

            $this->constants();
            $this->dependencies();

        }

        public function constants()
        {

            define('DG_DEV_TOOLS_URL', plugin_dir_url(__FILE__));
            define('DG_DEV_TOOLS_PATH', plugin_dir_path(__FILE__));

        }

        public function dependencies()
        {

            require_once DG_DEV_TOOLS_PATH . 'inc/init.php';

        }

        public function __destruct()
        {

        }

    }

endif;

new DG_DEV_TOOLS();