<?php
class cnr_VideoTutorials {
    function __construct() {
        add_action( 'init', array( $this, 'integrateWithVC' ) );
        add_shortcode( 'cnr_vid_tutorials', array( $this, 'renderElement' ) );
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
	        	"name"			=> __("Video Tutorials", 'cnr'),
				"base"			=> "cnr_vid_tutorials",
				"class"			=> "",
				"controls"		=> "full",
				"icon"			=> get_template_directory_uri() . '/img/element-icon.png',
				"category"		=> 'Custom Elements',
				
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
    
    public function renderElement( $atts, $content = null ) {
      	extract( shortcode_atts( array(
			//'hide_element' => false,
		), $atts ) );
		include get_stylesheet_directory() . '/vendor/autoload.php';
		// fix unclosed/unwanted paragraph tags in $content
		$content = wpb_js_remove_wpautop($content, true);
		$search = '';
		$vimeo_user_id       = of_get_option( 'vimeo-channel', false );
		$vimeo_client_id     = of_get_option( 'vimeo-client', false );
		$vimeo_client_secret = of_get_option( 'vimeo-secret', false );
		
		$vimeo = new \Vimeo\Vimeo( $vimeo_client_id, $vimeo_client_secret );	
		
		$token = $vimeo->clientCredentials( 'public' );
		$vimeo->setToken( $token['body']['access_token'] );
		
		$videos = $vimeo->request( '/users/' . $vimeo_user_id . '/videos?direction=desc&filter=embeddable&filter_embeddable=true&per_page=100&sort=date&page=1' . $search );

		$vimeo_videos = $videos['body']['data'];
		$videoCats    = $videos = [];
		$video_id	  = 0;
		$vid_button = [];
		
		foreach ( $vimeo_videos as $video ) {
			$video_id++;
			$title = $video['name'];
			$link  = $video['link'];
			$embed = $video['embed']['html'];
			$img   = $video['pictures']['sizes'][3]['link_with_play_button'];
			$tags  = $video['tags'];
			$desc  = $video['description'];
			$video_tags = [];
			$active = ($video_id == 1) ? 'active' : '';
			$id = 'vim-' . $video_id;
			
			if ( ! empty( $tags ) ) {


				foreach ( $tags as $tag ) {
					$catName = $video_tags[ str_replace( ' ', '_', $tag['tag'] ) ] = ucwords( $tag['name'] );
				}

				$videoCats += $video_tags;
			}


			$tags_to_classes = implode( ' vtag_', array_keys( $video_tags ) );
			if( ! empty( $tags_to_classes ) ){
			    $tags_to_classes = 'vtag_' . $tags_to_classes ;
            }
			if( $video_id < 6) {
				$videos[] = '<div role="tabpanel" class="tab-pane '.$active.'" id="'.$id.'">' . $embed . '</div>';
				$vid_button[] = '<li role="presentation" class="'.$active.'"><a href="#'.$id.'" aria-controls="'.$id.'" role="tab" data-toggle="tab">'.$title.'</a></li>';
			}
		}
		
		
				
		// start the output
		
		$output  = '<div class="cnr-vidtut-widget">';
		//$output .= '	<ul class="nav nav-tabs" role="tablist">';
		//$output .= '		<li role="presentation" class="active"><a href="#training" aria-controls="training" role="tab" data-toggle="tab">Training</a></li>';
		//$output .= '		<li role="presentation"><a href="#promos" aria-controls="promos" role="tab" data-toggle="tab">Promos</a></li>';
		//$output .= '	</ul>';
		//$output .= '	<div class="tab-content">';
		//$output .= '		<div role="tabpanel" class="tab-pane active" id="training">';
		
		$output .= '			<div class="row">';
		
		
		
		$output .= '				<div class="col-sm-5">';
		$output .= '					<ul class="menu" role="tablist">';
		$output .= 						implode( PHP_EOL, $vid_button );
		$output .= '					</ul>';
		$output .= '				</div>';
		
		$output .= '				<div class="col-sm-7 tab-content">';
		$output .= 						implode( PHP_EOL, $videos );
		$output .= '				</div>';
		$output .= '			</div>';
		//$output .= '		</div>';
		//$output .= '		<div role="tabpanel" class="tab-pane" id="promos">';
		//$output .= '			<div class="row">sadfsd';
		//$output .= '			</div>';
		//$output .= '		</div>';
		//$output .= '	</div>';
		$output .= '</div>';

 
        
		return $output;
    }
}
new cnr_VideoTutorials();