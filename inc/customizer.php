<?php
/**
 * @package dineshghimire
 * @subpackage dev-tools
 *
 * @since 1.0.0
 *
 */

if(!function_exists('dev_tools_customizer')){

	function dev_tools_customizer($wp_customize){

		$wp_customize->add_section(
			'sidebar-widgets-template_builder_options', 
			array(
				'type' => 'meta-sidebar',
				'title' => esc_html__( 'Widget Builders', 'blogmagazine-pro' ),
				'panel' => 'newspaper_lite_additional_settings_panel',
				'priority' => 90,
			)
		);

		$widget_priority = 10;

		//$all_widgets = get_post_meta( 81, 'blogmagazine_post_widget_builder', array() );

		$all_widgets = get_option('sidebars_widgets');

		$sidebar_detail = $all_widgets['sidebar-1'];

		foreach( $sidebar_detail as $key => $widget_id){

			$wp_customize->add_setting(
				'widget_'.$widget_id
			);
			$wp_customize->add_control(
				new WP_Widget_Form_Customize_Control(
					$wp_customize, 
					'widget_'.$widget_id, 
					array(
						'widget_id' => $widget_id,
						'label' => esc_html__('Test Widget', 'blogmagazine-pro'),
						'section' => 'sidebar-widgets-template_builder_options',
						'priority' => $widget_priority,
						'description'=> esc_html__('You can enable reaction to show after post details.', 'blogmagazine-pro'),
						'active_callback' => '__return_true',
					)
				)
			);

			$widget_priority+= 10;

		}

		$wp_customize->add_setting(
			'blogmagazine_post_widget_builder', 
			array(
        //'sanitize_callback' => 'sanitize_text_field',
        //'default' => 'enable',
			)
		);
		$wp_customize->add_control(
			new WP_Widget_Area_Customize_Control(
				$wp_customize, 
				'blogmagazine_post_widget_builder', 
				array(
					'type' => 'sidebar_widgets',
					'label' => esc_html__('Enable Widget', 'blogmagazine-pro'),
					'section' => 'sidebar-widgets-template_builder_options',
					'priority' => $widget_priority,
					'description'=> esc_html__('You can enable reaction to show after post details.', 'blogmagazine-pro'),
				)
			)
		);

	}
}

//add_action('customize_register', 'dev_tools_customizer');