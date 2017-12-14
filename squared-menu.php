<?php
/*
* VC Widget for box button with icon and text
*/

if (!defined('ABSPATH')) die('-1');

// Element Class
class cnr_BoxButton extends WPBakeryShortCode {

	// Element Init
	function __construct() {
		add_action( 'init', array( $this, 'vc_iconboxlink_mapping' ) );
		add_shortcode( 'vc_iconboxlink', array( $this, 'render_html' ) );
	}

	// Element Mapping

	public
	function vc_iconboxlink_mapping() {

		// Stop all if VC is not enabled
		if ( ! defined( 'WPB_VC_VERSION' ) ) {
			return;
		}

		// Map the block with vc_map()
		vc_map(
			array(
				'name'        => __( 'Icon box link', THEME_TEXT_DOMAIN ),
				'base'        => 'vc_iconboxlink',
				'description' => __( 'Another simple VC box', THEME_TEXT_DOMAIN ),
				'category'    => __( 'Custom Elements', THEME_TEXT_DOMAIN ),
				'icon'        =>  VC_CUSTOM_ELEMENTS_DIR . 'elements-icons/' . basename( __FILE__, '.php' ) . '.png',
				'params'      => array(

					array(
						'param_name'  => 'title',
						'type'        => 'textfield',
						'holder'      => 'div',
						'class'       => 'cnr-title',
						'heading'     => __( 'Title', THEME_TEXT_DOMAIN ),
						'value'       => '',
						'description' => __( 'Box Title', THEME_TEXT_DOMAIN ),
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'General',
					),
					array(
						'param_name' => 'icon_type',
						'type' => 'dropdown',
						'heading' => __( 'Icon Type', THEME_TEXT_DOMAIN ),
						'value' => array(
							__( 'Font icon set', THEME_TEXT_DOMAIN ) => 'font_icon',
							__( 'Custom Image', THEME_TEXT_DOMAIN ) => 'image',
							__( 'Custom css class', THEME_TEXT_DOMAIN ) => 'css_class',
						),
						'description' => __( 'Select icon Type.', 'js_composer' ),
						'group'       => 'General',
					),
					array(
						'param_name'  => 'icon_img',
						'type'        => 'attach_image',
						'holder'      => 'div',
						'class'       => 'cnr-icon-image',
						'heading'     => __( 'Icon image', THEME_TEXT_DOMAIN ),
						'value'       => '',
						'description' => __( 'Box Icon image', THEME_TEXT_DOMAIN ),
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'General',
						'dependency'  => array(
							'element'  => 'icon_type',
							'value'  => 'image'
						)
					),
					array(
						'param_name'  => 'icon_font',
						'type'        => 'iconpicker',
						'holder'      => 'div',
						'heading'     => __( 'Font Icon', THEME_TEXT_DOMAIN ),
						'value'       => '',
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'General',
						'settings' => array(
							'emptyIcon' => false,
							'iconsPerPage' => 500,
						),
						'dependency'  => array(
							'element'  => 'icon_type',
							'value'  => 'font_icon'
						)
					),
					array(
						'param_name'  => 'icon_css',
						'type'        => 'textfield',
						'holder'      => 'div',
						'class'       => 'cnr-icon-class',
						'heading'     => __( 'Icon css class', THEME_TEXT_DOMAIN ),
						'value'       => __( 'fa-', THEME_TEXT_DOMAIN ),
						'description' => __( 'Css class of icon', THEME_TEXT_DOMAIN ),
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'General',
						'dependency'  => array(
							'element'  => 'icon_type',
							'value'  => 'css_class'
						)
					),
					array(
						'param_name'  => 'href',
						'type'        => 'vc_link',
						'holder'      => 'div',
						'class'       => 'cnr-link-box',
						'heading'     => __( 'Link', THEME_TEXT_DOMAIN ),
						'value'       => 'http://',
						'description' => __( 'Url of the link', THEME_TEXT_DOMAIN ),
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'General',
					),
					array(
						'param_name'  => 'bg_color',
						'type'        => 'colorpicker',
						'holder'      => 'div',
						'class'       => 'cnr-color-box',
						'heading'     => __( 'Box background color', THEME_TEXT_DOMAIN ),
						'value'       => '',
						'description' => '',
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'Design',
					)

				),
			)
		);

	}


	// Element HTML
	public
	function render_html(
		$atts
	) {

		// Params extraction
		extract(
			shortcode_atts(
				array(
					'title' => '',
					'icon_type' => '',
					'icon_css'  => '',
					'icon_font'  => '',
					'icon_img'  => '',
					'href'  => '',
					'bg_color'  => '',
				),
				$atts
			)
		);

		// Fill $html var with data
		
		
		$href = vc_build_link($href);
		$href = $href['url'];
		$html = '<a class="cnr-box-btn" href="' . $href . '">';
		if( $icon_font ) $html .= '<i class="' . $icon_font . '" aria-hidden="true"></i>';
		if( $icon_img ) $html .= '<div class="img">'.wp_get_attachment_image($icon_img, 'full', false).'</div>';
		if( $title ) $html .= '<p>' . $title . '</p>';
        $html .= '</a>';

		return $html;

	}

} 

class cnr_BoxesMenu extends WPBakeryShortCode {
	function __construct() {
		add_action( 'init', array( $this, 'vc_iconboxlink_mapping' ) );
		add_shortcode( 'boxes_menu', array( $this, 'render_html' ) );
	}
	public function vc_iconboxlink_mapping() {
		if ( ! defined( 'WPB_VC_VERSION' ) )
			return;

		vc_map(
			array(
				'name'        => __( 'Icon Boxes Menu', THEME_TEXT_DOMAIN ),
				'base'        => 'boxes_menu',
				//'description' => __( 'Another simple VC box', THEME_TEXT_DOMAIN ),
				'category'    => __( 'Custom Elements', THEME_TEXT_DOMAIN ),
				//'icon'        =>  VC_CUSTOM_ELEMENTS_DIR . 'elements-icons/' . basename( __FILE__, '.php' ) . '.png',
				'params'      => array(
					array(
						'param_name'  => 'box-1-title',
						'type'        => 'textfield',
						'holder'      => 'div',
						'class'       => 'box-1-title',
						'heading'     => __( 'Title', THEME_TEXT_DOMAIN ),
						'value'       => '',
						'description' => __( 'Box 1 Title', THEME_TEXT_DOMAIN ),
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'Box 1',
					),
					array(
						'param_name' => 'box-1-icon',
						'type' => 'attach_image',
						'heading' => __( 'Box 1 Icon', THEME_TEXT_DOMAIN ),
						'value' => '',
						'description' => __( 'Select Icon image', THEME_TEXT_DOMAIN ),
						'group'       => 'Box 1',
					),
					array(
						'param_name'  => 'box-1-link',
						'type'        => 'vc_link',
						'holder'      => 'div',
						'class'       => 'box-1-link',
						'heading'     => __( 'Link', THEME_TEXT_DOMAIN ),
						'value'       => 'http://',
						'description' => __( 'Box 1 Link', THEME_TEXT_DOMAIN ),
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'Box 1',
					),
					array(
						'param_name'  => 'box-1-bg',
						'type'        => 'colorpicker',
						'holder'      => 'div',
						'class'       => 'box-1-bg',
						'heading'     => __( 'Box 1 Background Color', THEME_TEXT_DOMAIN ),
						'value'       => '',
						'description' => '',
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'Box 1',
					),
					
					// box 2
					
					array(
						'param_name'  => 'box-2-title',
						'type'        => 'textfield',
						'holder'      => 'div',
						'class'       => 'box-2-title',
						'heading'     => __( 'Title', THEME_TEXT_DOMAIN ),
						'value'       => '',
						'description' => __( 'Box 2 Title', THEME_TEXT_DOMAIN ),
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'Box 2',
					),
					array(
						'param_name' => 'box-2-icon',
						'type' => 'attach_image',
						'heading' => __( 'Box 2 Icon', THEME_TEXT_DOMAIN ),
						'value' => '',
						'description' => __( 'Select Icon image', THEME_TEXT_DOMAIN ),
						'group'       => 'Box 2',
					),
					array(
						'param_name'  => 'box-2-link',
						'type'        => 'vc_link',
						'holder'      => 'div',
						'class'       => 'box-2-link',
						'heading'     => __( 'Link', THEME_TEXT_DOMAIN ),
						'value'       => 'http://',
						'description' => __( 'Box 2 Link', THEME_TEXT_DOMAIN ),
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'Box 2',
					),
					array(
						'param_name'  => 'box-2-bg',
						'type'        => 'colorpicker',
						'holder'      => 'div',
						'class'       => 'box-2-bg',
						'heading'     => __( 'Box 2 Background Color', THEME_TEXT_DOMAIN ),
						'value'       => '',
						'description' => '',
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'Box 2',
					),
					
					// box 3
					array(
						'param_name'  => 'box-3-title',
						'type'        => 'textfield',
						'holder'      => 'div',
						'class'       => 'box-3-title',
						'heading'     => __( 'Title', THEME_TEXT_DOMAIN ),
						'value'       => '',
						'description' => __( 'Box 3 Title', THEME_TEXT_DOMAIN ),
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'Box 3',
					),
					array(
						'param_name' => 'box-3-icon',
						'type' => 'attach_image',
						'heading' => __( 'Box 3 Icon', THEME_TEXT_DOMAIN ),
						'value' => '',
						'description' => __( 'Select Icon image', THEME_TEXT_DOMAIN ),
						'group'       => 'Box 3',
					),
					array(
						'param_name'  => 'box-3-link',
						'type'        => 'vc_link',
						'holder'      => 'div',
						'class'       => 'box-3-link',
						'heading'     => __( 'Link', THEME_TEXT_DOMAIN ),
						'value'       => 'http://',
						'description' => __( 'Box 3 Link', THEME_TEXT_DOMAIN ),
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'Box 3',
					),
					array(
						'param_name'  => 'box-3-bg',
						'type'        => 'colorpicker',
						'holder'      => 'div',
						'class'       => 'box-3-bg',
						'heading'     => __( 'Box 3 Background Color', THEME_TEXT_DOMAIN ),
						'value'       => '',
						'description' => '',
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'Box 3',
					),
					
					// box 4
					array(
						'param_name'  => 'box-4-title',
						'type'        => 'textfield',
						'holder'      => 'div',
						'class'       => 'box-4-title',
						'heading'     => __( 'Title', THEME_TEXT_DOMAIN ),
						'value'       => '',
						'description' => __( 'Box 4 Title', THEME_TEXT_DOMAIN ),
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'Box 4',
					),
					array(
						'param_name' => 'box-4-icon',
						'type' => 'attach_image',
						'heading' => __( 'Box 4 Icon', THEME_TEXT_DOMAIN ),
						'value' => '',
						'description' => __( 'Select Icon image', THEME_TEXT_DOMAIN ),
						'group'       => 'Box 4',
					),
					array(
						'param_name'  => 'box-4-link',
						'type'        => 'vc_link',
						'holder'      => 'div',
						'class'       => 'box-4-link',
						'heading'     => __( 'Link', THEME_TEXT_DOMAIN ),
						'value'       => 'http://',
						'description' => __( 'Box 4 Link', THEME_TEXT_DOMAIN ),
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'Box 4',
					),
					array(
						'param_name'  => 'box-4-bg',
						'type'        => 'colorpicker',
						'holder'      => 'div',
						'class'       => 'box-4-bg',
						'heading'     => __( 'Box 4 Background Color', THEME_TEXT_DOMAIN ),
						'value'       => '',
						'description' => '',
						'admin_label' => true,
						'weight'      => 0,
						'group'       => 'Box 4',
					),
				),
			)
		);

	}


	// Element HTML
	public
	function render_html(
		$atts
	) {

		// Params extraction
		extract(
			shortcode_atts(
				array(
					'box-1-title' => '',
					'box-1-icon' => '',
					'box-1-link' => '',
					'box-1-bg' => '',
					
					'box-2-title' => '',
					'box-2-icon' => '',
					'box-2-link' => '',
					'box-2-bg' => '',
					
					'box-3-title' => '',
					'box-3-icon' => '',
					'box-3-link' => '',
					'box-3-bg' => '',
					
					'box-4-title' => '',
					'box-4-icon' => '',
					'box-4-link' => '',
					'box-4-bg' => '',
				),
				$atts
			)
		);
		
		$box_1_title	= ( isset($atts['box-1-title']) ) ? $atts['box-1-title'] : '';
		$box_1_icon		= ( isset($atts['box-1-icon']) ) ? $atts['box-1-icon'] : '';
		$box_1_link		= ( isset($atts['box-1-link']) ) ? vc_build_link($atts['box-1-link']) : '';
		$box_1_href		= $box_1_link['url'];
		$box_1_bg		= ( isset($atts['box-1-bg']) ) ? $atts['box-1-bg'] : '';
		
		$box_2_title	= ( isset($atts['box-2-title']) ) ? $atts['box-2-title'] : '';
		$box_2_icon		= ( isset($atts['box-2-icon']) ) ? $atts['box-2-icon'] : '';
		$box_2_link		= ( isset($atts['box-2-link']) ) ? vc_build_link($atts['box-2-link']) : '';
		$box_2_href		= $box_2_link['url'];
		$box_2_bg		= ( isset($atts['box-2-bg']) ) ? $atts['box-2-bg'] : '';
		
		$box_3_title	= ( isset($atts['box-3-title']) ) ? $atts['box-3-title'] : '';
		$box_3_icon		= ( isset($atts['box-3-icon']) ) ? $atts['box-3-icon'] : '';
		$box_3_link		= ( isset($atts['box-3-link']) ) ? vc_build_link($atts['box-3-link']) : '';
		$box_3_href		= $box_3_link['url'];
		$box_3_bg		= ( isset($atts['box-3-bg']) ) ? $atts['box-3-bg'] : '';
		
		$box_4_title	= ( isset($atts['box-4-title']) ) ? $atts['box-4-title'] : '';
		$box_4_icon		= ( isset($atts['box-4-icon']) ) ? $atts['box-4-icon'] : '';
		$box_4_link		= ( isset($atts['box-4-link']) ) ? vc_build_link($atts['box-4-link']) : '';
		$box_4_href		= $box_4_link['url'];
		$box_4_bg		= ( isset($atts['box-4-bg']) ) ? $atts['box-4-bg'] : '';
				
		$html = '';
		
		$html .= '<div class="cnr-boxes-menu quick-nav">';
		$html .= '	<div class="boxes-menu">';
		
		if( isset($box_1_title) && $box_1_title != '' && isset($box_1_icon) && $box_1_icon != '' && isset($box_1_href) && $box_1_href != '') {
			$html .= '		<a class="cnr-box-btn" href="' . $box_1_href . '"><div class="wrapper">';
			$html .= '			<div class="img">'.wp_get_attachment_image($box_1_icon, 'full', false).'</div>';
			$html .= '			<p>' . $box_1_title . '</p>';
	        $html .= '		</div></a>';
		}
		if( isset($box_2_title) && $box_2_title != '' && isset($box_2_icon) && $box_2_icon != '' && isset($box_2_href) && $box_2_href != '') {
			$html .= '		<a class="cnr-box-btn" href="' . $box_2_href . '"><div class="wrapper">';
			$html .= '			<div class="img">'.wp_get_attachment_image($box_2_icon, 'full', false).'</div>';
			$html .= '			<p>' . $box_2_title . '</p>';
	        $html .= '		</div></a>';
		}
		if( isset($box_3_title) && $box_3_title != '' && isset($box_3_icon) && $box_3_icon != '' && isset($box_3_href) && $box_3_href != '') {
			$html .= '		<a class="cnr-box-btn" href="' . $box_3_href . '"><div class="wrapper">';
			$html .= '			<div class="img">'.wp_get_attachment_image($box_3_icon, 'full', false).'</div>';
			$html .= '			<p>' . $box_3_title . '</p>';
	        $html .= '		</div></a>';
		}
		if( isset($box_4_title) && $box_4_title != '' && isset($box_4_icon) && $box_4_icon != '' && isset($box_4_href) && $box_4_href != '') {
			$html .= '		<a class="cnr-box-btn" href="' . $box_4_href . '"><div class="wrapper">';
			$html .= '			<div class="img">'.wp_get_attachment_image($box_4_icon, 'full', false).'</div>';
			$html .= '			<p>' . $box_4_title . '</p>';
	        $html .= '		</div></a>';
		}
		
		$html .= '	</div>';
		$html .= '</div>';
		
		

		return $html;

	}

}

new cnr_BoxesMenu();
new cnr_BoxButton();