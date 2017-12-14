<?php
class cnr_QuickTopics {
    function __construct() {
	    
        // Integrate with VC
        add_action( 'init', array( $this, 'integrateWithVC' ) );
 
        // Create our Shortcode
        add_shortcode( 'cnr_quick_topics', array( $this, 'renderElement' ) );
    }
    
    /*
		Integration
	*/
    public function integrateWithVC() {
	    
	    // if vc dosn't exist
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            return;
        }
		vc_map(
        	array(
	        	"name"			=> __("Quick Topics", 'textdomain'),						// element name
				//"description"	=> __("Element description", 'textdomain'),						// element description
				"base"			=> "cnr_quick_topics",										// element base shortcode
				"class"			=> "",														// element special class
				"controls"		=> "full",
				"icon"			=> get_template_directory_uri() . '/img/element-icon.png',	// element icon
				"category"		=> 'Custom Elements',									// element category
				
				// Widget options
				"params"		=> array(
					/*
					// hide meta content
	            	array(
	            		"type"			=> "checkbox",
	            		"holder"		=> "div",
	            		"class"			=> "",
						"heading"		=> __("Hide element", 'newa'),
						"param_name"	=> "hide_element",
						"value"			=> "",
					),*/
				)
			)
		);
    }
    
    // Shortcode logic & rendering
    public function renderElement( $atts, $content = null ) {
      	extract( shortcode_atts( array(
			//'hide_element' => false,
		), $atts ) );
		
		// fix unclosed/unwanted paragraph tags in $content
		$content = wpb_js_remove_wpautop($content, true);
		
		
		// start the output
		
		$output = '';
		
		$output .= '<div class="row tabs">';
		$output .= '	<ul class="nav flex-column col-sm-4 text-left" id="myTab" role="tablist">';
		$output .= '		<li class="nav-item active">';
		$output .= '			<a class="nav-link" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-expanded="true">
									<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
									<span>Popular Topics</span>
								</a>';
		$output .= '		</li>';
		$output .= '		<li class="nav-item">';
		$output .= '			<a class="nav-link" data-toggle="tab" href="#recent_activities" role="tab" aria-controls="recent_activities">
									<i class="fa fa-clock-o" aria-hidden="true"></i>
									<span>Recent Activities</span>
								</a>';
		$output .= '		</li>';
		$output .= '	</ul>';
		
		/// TAB CONTENT
		
		$output .= '<div class="tab-content col-sm-8">';
		$output .= '	<div class="tab-pane active" id="home" role="tabpanel">';
		$output .= '		<div class="quick-topics-tabs">';
		
		$topics = new WP_Query(array(
			'post_type'		=> 'topic',
			'posts_per_page'	=> 5,
			'orderby'			=> 'meta_value',
			'meta_key'			=> 'views'
		));
		if( $topics->have_posts() ) {
			while($topics->have_posts()) {
				$topics->the_post();
				
				$likes = intval(get_post_meta(get_the_id(), 'cnr-like', true));
				
				$output .= '			<div class="item row">';
				$output .= '				 <div class="col-sm-10 col-xs-9">
										        <h3><a href="'.get_permalink().'">' . get_the_title() . '</a></h3>
										        <sub>'.get_the_date().'</sub>
									        </div>';
				$output .= '				<div class="col-sm-2 col-xs-3 likes-count">' . $likes . ' <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>';
				$output .= '			</div>';
			}
		}
		$output .= '		</div>';
		$output .= '	</div>';
		$output .= '	<div class="tab-pane" id="recent_activities" role="tabpanel">';
		$output .= '		<div class="quick-topics-tabs">';
		
		$topics = new WP_Query(array(
			'post_type'		=> 'topic',
			'posts_per_page'	=> 5,
			'orderby'			=> 'meta_value',
			'meta_key'			=> '_bbp_last_active_time'
		));
		if( $topics->have_posts() ) {
			while($topics->have_posts()) {
				$topics->the_post();
				
				$likes = intval(get_post_meta(get_the_id(), 'cnr-like', true));
				
				$output .= '			<div class="item row">';
				$output .= '				 <div class="col-sm-10 col-xs-9">
										        <h3><a href="'.get_permalink().'">' . get_the_title() . '</a></h3>
										        <sub>'.get_the_date().'</sub>
									        </div>';
				$output .= '				<div class="col-sm-2 col-xs-3 likes-count">' . $likes . ' <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>';
				$output .= '			</div>';
			}
		}
		$output .= '		</div>';
		$output .= '	</div>';
        $output .= '</div>';
        $output .= '</div>';
        
		return $output;
    }
}
new cnr_QuickTopics();