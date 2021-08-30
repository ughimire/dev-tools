<?php
/**
 * @package dineshghimire
 * @subpackage dev-tools
 *
 * @since 1.0.0
 *
 */

/**
 *
 * @since 1.0.0
 *
 * @param string $file_path, path from the theme
 * @return string full path of file inside theme
 *
 */
if( !function_exists('dev_tools_file_directory') ){

    function dev_tools_file_directory( $file_path ){

    	$plugin_file_path = trailingslashit( DG_DEV_TOOLS_PRO_PATH ) . $file_path;

    	return wp_normalize_path( $plugin_file_path );

    }

}

/**
 *
 * @since 1.0.0
 *
 * @param string $file_url, path from the theme
 * @return string full path of file inside theme
 *
 */
if( !function_exists('dev_tools_file_url') ){

    function dev_tools_file_url( $file_url ){

    	$plugin_url = trailingslashit( DG_DEV_TOOLS_URL ) . $file_url;

    	return esc_url( $plugin_url );

    }

}

/**
 *
 * @since 1.0.0
 *
 * enqueue css and js on backend wordpress
 *
 */
if( !function_exists( 'dev_tools_admin_enqueue_scripts' ) ){

	function dev_tools_admin_enqueue_scripts(){

		wp_enqueue_style( 'dev-tools-admin-css', dev_tools_file_url( 'assets/css/admin-style.css' ), false, '1.0.0' );
		wp_enqueue_script( 'dev-tools-admin-js', dev_tools_file_url( 'assets/js/admin.js' ), false, '1.0.0' );

	}	

}
add_action( 'admin_enqueue_scripts', 'dev_tools_admin_enqueue_scripts' );

if(!function_exists( 'dev_tools_admin_notice' ) ):

    function dev_tools_admin_notice(){

        $widget_sidebar = get_option('sidebars_widgets');
        ?>
        <div class="dg-button-wrapper">
            <button class="button button-primary dg-add-widgets" name="savewidgets" value="<?php echo wp_create_nonce('devtools-add-all-widgets'); ?>"><?php echo esc_html_e( 'Add All Widgets', 'dev-tools'); ?></button>
            <button class="button button-primary dg-clear-widgets" name="clearwidgets" value="<?php echo wp_create_nonce('devtools-clear-all-widgets'); ?>">
                <?php echo esc_html_e('Clear All Widgets', 'dev-tools'); ?>
            </button>
            <div class="widget-progress-wrapper">
                <span class="percentage"><?php esc_html_e( '0% Completed', 'dev-tools'); ?></span>
                <div class="widget-progress-bar"></div>
            </div>
        </div>
        <?php
    }

endif;
add_action( 'admin_notices', 'dev_tools_admin_notice');


require_once DG_DEV_TOOLS_PATH.'inc/ajax.php';

require_once DG_DEV_TOOLS_PATH.'inc/customizer.php';