<?php
/*
 * @package: dineshghimire
 * @subpackage: dev-tools
 * @since: 1.0.0
 */
if(!function_exists('dev_tools_clear_all_widgets')):

    function dev_tools_clear_all_widgets(){

        check_ajax_referer( 'devtools-clear-all-widgets', 'clearwidgets' );

        $wp_widget_factory = $GLOBALS['wp_widget_factory'];
        $widget_list = $wp_widget_factory->widgets;

        foreach($widget_list as $widget_details){

            $option_name = $widget_details->option_name;

            $current_val = get_option($option_name);
            $new_widget_value = array();
            $new_widget_value['_multiwidget'] = isset($current_val['_multiwidget']) ? $current_val['_multiwidget'] : '';
            update_option($option_name, $new_widget_value);

        }
        
        $sidebars_widgets = get_option('sidebars_widgets');
        $new_sidebars_val = array();
        foreach($sidebars_widgets as $sidebar_slug => $sidebar_widgets){
            $new_sidebars_val[$sidebar_slug] = array();
        }
        $new_sidebars_val['array_version'] = (isset($sidebars_widgets['array_version'])) ? $sidebars_widgets['array_version'] : '';
        update_option( 'sidebars_widgets', $new_sidebars_val);

        $data = array(
            'message' => esc_html__( 'Successfully cleared widget', 'dev-tools' ),
        );
        wp_send_json_success($data);

    }

endif;
add_action( 'wp_ajax_clear_all_widgets', 'dev_tools_clear_all_widgets' );


function dvtls_sanitize_form_values(){

    parse_str($_POST['form_values'], $form_values);
    $id_base = $form_values['id_base'];
    $widget_index = $_POST['widget_index'];
    unset($form_values['widget-id']);
    unset($form_values['id_base']);
    unset($form_values['widget-height']);
    unset($form_values['widget-width']);
    unset($form_values['widget_number']);
    unset($form_values['multi_number']);
    unset($form_values['add_new']);
    if(isset($form_values['widget-'.$id_base]['__i__']['title'])){
        $form_values['widget-'.$id_base]['__i__']['title'] = $id_base.'-'.$widget_index;
    }
    if(isset($form_values['widget-'.$id_base]['__i__']['newspaper_lite_block_title'])){
        $form_values['widget-'.$id_base]['__i__']['newspaper_lite_block_title'] = $id_base.'-'.$widget_index;
    }
    if(isset($form_values['widget-'.$id_base]['__i__']['newspaper_lite_carousel_title'])){
        $form_values['widget-'.$id_base]['__i__']['newspaper_lite_carousel_title'] = $id_base.'-'.$widget_index;
    }

    
    return $form_values['widget-'.$id_base]['__i__'];
}

if(!function_exists('dev_tools_add_single_widget')){

    function dev_tools_add_single_widget(){

        check_ajax_referer( 'devtools-add-all-widgets', 'addwidget' );

        $basename = $_POST['basename'];
        $form_values = dvtls_sanitize_form_values();

        $widget_slug = 'widget_'.$basename;
        $widget_values = get_option($widget_slug);

        $current_number = key(end($widget_values));
        $widget_number = absint($current_number)+1;
        $widget_id = $basename.'-'.$widget_number;
        
        $widget_values[$widget_number] = $form_values;
        update_option($widget_slug, $widget_values); // update widget
        
        $sidebar_id = $_POST['sidebar_id'];
        $sidebars_widgets = get_option('sidebars_widgets');
        $sidebars_widgets[$sidebar_id][] = $widget_id;
        update_option( 'sidebars_widgets', $sidebars_widgets ); // update sidebar

        wp_send_json_success(array(
            'widget_id' => $widget_id,
            'sidebar_id' => $sidebar_id,
            'message' => esc_html__('Successfully added widget.', 'dev-tools'),
        ));

    }

}
add_action( 'wp_ajax_add_single_widget', 'dev_tools_add_single_widget' );