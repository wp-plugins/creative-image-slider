<?php
global $wpdb;

function wpcis_creativeslider_shortcode_function( $atts ) {
	extract( shortcode_atts( array(
			'id' => 0,
	), $atts ) );
	
	wpcis_enqueue_front_scripts($id);
	return wpcis_render_slider($id);

}
add_shortcode( 'creativeslider', 'wpcis_creativeslider_shortcode_function' );

//add_action('template_redirect','wpcis_my_shortcode_head');
function wpcis_my_shortcode_head(){
	global $posts;
	$pattern = get_shortcode_regex();
	preg_match('/(\[(creativeslider) id="([0-9]+)"\])/s', $posts[0]->post_content, $matches);
	if (is_array($matches) && $matches[2] == 'creativeslider') {
		$slider_id = (int) $matches[3];
		wpcis_enqueue_front_scripts($slider_id);
	}
}

function wpcis_enqueue_front_scripts($slider_id) {
	global $wpdb;
	
	wp_enqueue_style('wpcis-styles1', plugin_dir_url( __FILE__ ) . 'assets/css/main.css');
	wp_enqueue_style('wpcis-styles2', plugin_dir_url( __FILE__ ) . 'assets/css/creative_buttons.css');
	wp_enqueue_style('wpcis-styles3', plugin_dir_url( __FILE__ ) . 'assets/css/creativecss-ui.css');

	wp_enqueue_script('wpcis-script1', plugin_dir_url( __FILE__ ) . 'assets/js/mousewheel.js', array('jquery','jquery-ui-core','jquery-ui-widget'));
	wp_enqueue_script('wpcis-script2', plugin_dir_url( __FILE__ ) . 'assets/js/easing.js', array('jquery','jquery-ui-core','jquery-ui-widget'));
	wp_enqueue_script('wpcis-script3', plugin_dir_url( __FILE__ ) . 'assets/js/creativeimageslider.js', array('jquery','jquery-ui-core','jquery-ui-widget'));
}

if(!function_exists('cis_hex2rgb')) {

	function cis_hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);

		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		return implode(",", $rgb); // returns the rgb values separated by commas
		//return $rgb; // returns an array with the rgb values
	}
}

function cis_get_data($slider_id) {
	global $wpdb;
	
	$query = 'SELECT '.
			'sp.id slider_id, ' .
			'sp.id_template, ' .
			'sp.width, ' .
			'sp.height, ' .
			'sp.itemsoffset, ' .
			'sp.margintop, ' .
			'sp.marginbottom, ' .
			'sp.paddingtop, ' .
			'sp.paddingbottom, ' .
			'sp.showarrows, ' .
			'sp.bgcolor, ' .
			'sp.showreadmore, ' .
			'sp.readmoretext, ' .
			'sp.readmorestyle, ' .
			'sp.readmoresize, ' .
			'sp.readmoreicon, ' .
			'sp.readmorealign, ' .
			'sp.readmoremargin, ' .
			'sp.captionalign, ' .
			'sp.captionmargin, ' .
			'sp.overlaycolor, ' .
			'sp.overlayopacity, ' .
			'sp.textcolor, ' .
			'sp.overlayfontsize, ' .
			'sp.textshadowcolor, ' .
			'sp.textshadowsize, ' .
			'sp.arrow_template, ' .
			'sp.arrow_width, ' .
			'sp.arrow_left_offset, ' .
			'sp.arrow_center_offset, ' .
			'sp.arrow_passive_opacity, ' .
			'sp.move_step, ' .
			'sp.move_time, ' .
			'sp.move_ease, ' .
			'sp.autoplay, ' .
			'sp.autoplay_start_timeout, ' .
			'sp.autoplay_hover_timeout, ' .
			'sp.autoplay_step_timeout, ' .
			'sp.autoplay_evenly_speed, ' .

			'sp.overlayanimationtype, ' .
			'sp.popup_max_size, ' .
			'sp.popup_item_min_width, ' .
			'sp.popup_use_back_img, ' .
			'sp.popup_arrow_passive_opacity, ' .
			'sp.popup_arrow_left_offset, ' .
			'sp.popup_arrow_min_height, ' .
			'sp.popup_arrow_max_height, ' .
			'sp.popup_showarrows, ' .
			'sp.popup_image_order_opacity, ' .
			'sp.popup_image_order_top_offset, ' .
			'sp.popup_show_orderdata, ' .
			'sp.popup_icons_opacity, ' .
			'sp.popup_show_icons, ' .
			'sp.popup_autoplay_default, ' .
			'sp.popup_closeonend, ' .
			'sp.popup_autoplay_time, ' .
			'sp.popup_open_event, ' .

			'sa.id img_id, ' .
			'sa.name img_name, ' .
			'sa.img_name img_path, ' .
			'sa.img_url img_url_path ,' .
			'sa.caption ,' .
			'sa.showarrows item_showarrows, ' .
			'sa.showreadmore item_showreadmore, ' .
			'sa.readmoretext item_readmoretext, ' .
			'sa.readmorestyle item_readmorestyle, ' .
			'sa.readmoresize item_readmoresize, ' .
			'sa.readmoreicon item_readmoreicon, ' .
			'sa.readmorealign item_readmorealign, ' .
			'sa.readmoremargin item_readmoremargin, ' .
			'sa.captionalign item_captionalign, ' .
			'sa.captionmargin item_captionmargin, ' .
			'sa.overlaycolor item_overlaycolor, ' .
			'sa.overlayopacity item_overlayopacity, ' .
			'sa.textcolor item_textcolor, ' .
			'sa.overlayfontsize item_overlayfontsize, ' .
			'sa.textshadowcolor item_textshadowcolor, ' .
			'sa.textshadowsize item_textshadowsize, ' .
			'sa.overlayusedefault, ' .
			'sa.buttonusedefault, ' .
			'sa.redirect_url, ' .
			'sa.redirect_itemid, ' .
			'sa.redirect_target, ' .

			'sa.popup_img_name, ' .
			'sa.popup_img_url, ' .
			'sa.popup_open_event item_popup_open_event ' .

			'FROM '.
			$wpdb->prefix.'cis_sliders sp '.
			'JOIN '.
			$wpdb->prefix.'cis_images sa ON sa.id_slider = sp.id '.
			'AND sa.published = \'1\' '.
			'WHERE sp.published = \'1\' '.
			'AND sp.id = '.$slider_id.' '.
			'ORDER BY sp.ordering,sp.id,sa.ordering,sa.id';
	$results = $wpdb->get_results($query);
	return $results;
}

function wpcis_render_slider($slider_id) {
	global $wpdb;
	
	$data = cis_get_data($slider_id);

	$cis_options = array();
		
	for ($i=0, $n=count( $data ); $i < $n; $i++) {
		$cis_options[$data[$i]->slider_id][] = $data[$i];
	}

	if(sizeof($cis_options) > 0) {

			reset($cis_options);
			$first_key = key($cis_options);
		
			$cis_options_value = $cis_options[$first_key][0];
		
			$cis_width = $cis_options_value->width;
			$cis_item_height = (int) $cis_options_value->height;
			$cis_id_template = (int) $cis_options_value->id_template;
			$cis_margintop = (int) $cis_options_value->margintop;
			$cis_marginbottom = (int) $cis_options_value->marginbottom;
			$cis_paddingtop = (int) $cis_options_value->paddingtop;
			$cis_paddingbottom = (int) $cis_options_value->paddingbottom;
			$cis_itemsoffset = (int) $cis_options_value->itemsoffset;
			$cis_showarrows = (int) $cis_options_value->showarrows;
			$cis_bgcolor =  $cis_options_value->bgcolor;
			$cis_showreadmore = (int) $cis_options_value->showreadmore;
			$cis_readmoretext =  $cis_options_value->readmoretext;
			$cis_readmorestyle =  $cis_options_value->readmorestyle;
			$cis_readmoresize =  $cis_options_value->readmoresize;
			$cis_readmoreicon =  $cis_options_value->readmoreicon;
			$cis_readmorealign =  (int) $cis_options_value->readmorealign;
			$cis_readmoremargin =  $cis_options_value->readmoremargin;
			$cis_overlaycolor =  $cis_options_value->overlaycolor;
			$cis_overlayopacity = (int) $cis_options_value->overlayopacity;
			$cis_textcolor = $cis_options_value->textcolor;
			$cis_overlayfontsize = (int) $cis_options_value->overlayfontsize;
			$cis_textshadowcolor =  $cis_options_value->textshadowcolor;
			$cis_textshadowsize = (int) $cis_options_value->textshadowsize;
			$cis_captionalign = (int) $cis_options_value->captionalign;
			$cis_captionmargin = $cis_options_value->captionmargin;
			
			$cis_arrow_template = $cis_options_value->arrow_template;
			$cis_arrow_width = $cis_options_value->arrow_width;
			$cis_arrow_left_offset = $cis_options_value->arrow_left_offset;
			$cis_arrow_center_offset = $cis_options_value->arrow_center_offset;
			$cis_arrow_passive_opacity = $cis_options_value->arrow_passive_opacity;
			
			$cis_move_step = $cis_options_value->move_step;
			$cis_move_time = $cis_options_value->move_time;
			$cis_move_ease = $cis_options_value->move_ease;
			$cis_autoplay = $cis_options_value->autoplay;
			$cis_autoplay_start_timeout = $cis_options_value->autoplay_start_timeout;
			$cis_autoplay_hover_timeout = $cis_options_value->autoplay_hover_timeout;
			$cis_autoplay_step_timeout = $cis_options_value->autoplay_step_timeout;
			$cis_autoplay_evenly_speed = $cis_options_value->autoplay_evenly_speed;

			$cis_overlayanimationtype = (int) $cis_options_value->overlayanimationtype;

			// this section is used for js in cis_popup_data element
			$cis_popup_max_size = (int) $cis_options_value->popup_max_size;
			$cis_popup_item_min_width = (int) $cis_options_value->popup_item_min_width;
			$cis_popup_use_back_img = (int) $cis_options_value->popup_use_back_img;
			$cis_popup_arrow_passive_opacity = (int) $cis_options_value->popup_arrow_passive_opacity;//3
			$cis_popup_arrow_left_offset = (int) $cis_options_value->popup_arrow_left_offset;
			$cis_popup_arrow_min_height= (int) $cis_options_value->popup_arrow_min_height;
			$cis_popup_arrow_max_height = (int) $cis_options_value->popup_arrow_max_height;
			$cis_popup_showarrows = (int) $cis_options_value->popup_showarrows;//7
			$cis_popup_image_order_opacity = (int) $cis_options_value->popup_image_order_opacity;
			$cis_popup_image_order_top_offset = (int) $cis_options_value->popup_image_order_top_offset;
			$cis_popup_show_orderdata= (int) $cis_options_value->popup_show_orderdata;
			$cis_popup_icons_opacity = (int) $cis_options_value->popup_icons_opacity;
			$cis_popup_show_icons = (int) $cis_options_value->popup_show_icons;//12
			$cis_popup_autoplay_default = (int) $cis_options_value->popup_autoplay_default;
			$cis_popup_closeonend = (int) $cis_options_value->popup_closeonend;
			$cis_popup_autoplay_time = (int) $cis_options_value->popup_autoplay_time;
			// end section

			$cis_popup_open_event = (int) $cis_options_value->popup_open_event;
		
			ob_start();
			
			$id_slider = $slider_id;
			$module_id = 0;
			
			//start render html
			$cis_class_suffix = '';
			echo '<div id="cis_slider_'.$id_slider.'" cis_overlay_type="'.$cis_overlayanimationtype.'" roll="'.$module_id.'_'.$id_slider.'" cis_slider_id="'.$id_slider.'" class="cis_main_wrapper'.$cis_class_suffix.' cis_wrapper_'.$module_id.'_'.$id_slider.'" cis_base="'.plugin_dir_url( __FILE__ ).'">';
			echo '<div class="cis_images_row">';
			
			$img_src1 = plugin_dir_url( __FILE__ ) .'/assets/images/arrows/cis_button_left'.$cis_arrow_template.'.png';
			$img_src2 = plugin_dir_url( __FILE__ ) .'/assets/images/arrows/cis_button_right'.$cis_arrow_template.'.png';
			echo '<img class="cis_button_left" src="'.$img_src1.'" style="display: none !important;" />';
			echo '<img class="cis_button_right" src="'.$img_src2.'" style="display: none !important;" />';
			echo '<div class="cis_arrow_data" style="display: none !important;">'.$cis_arrow_width.','.$cis_arrow_left_offset.','.$cis_arrow_center_offset.','.$cis_arrow_passive_opacity.','.$cis_showarrows.'</div>';
			echo '<div class="cis_moving_data" style="display: none !important;">'.$cis_move_step.','.$cis_move_time.','.$cis_move_ease.','.$cis_autoplay.','.$cis_autoplay_start_timeout.','.$cis_autoplay_step_timeout.','.$cis_autoplay_evenly_speed.','.$cis_autoplay_hover_timeout.'</div>';

			echo '<div class="cis_popup_data" style="display: none !important;">'.$cis_popup_max_size.','.$cis_popup_item_min_width.','.$cis_popup_use_back_img.','.$cis_popup_arrow_passive_opacity.','.$cis_popup_arrow_left_offset.','.$cis_popup_arrow_min_height.','.$cis_popup_arrow_max_height.','.$cis_popup_showarrows.','.$cis_popup_image_order_opacity.','.$cis_popup_image_order_top_offset.','.$cis_popup_show_orderdata.','.$cis_popup_icons_opacity.','.$cis_popup_show_icons.','.$cis_popup_autoplay_default.','.$cis_popup_closeonend.','.$cis_popup_autoplay_time.'</div>';
			echo '<div class="cis_images_holder" style="height: '.$cis_item_height.'px !important;">';
		
			$items_css = '';
			$items_css_predefined = '<style type="text/css">';
			$items_css_postdefined = '</style>';
			$loader_color_class = 'cis_row_item_loader_color1';
			foreach( $cis_options[$first_key] as $cis_index => $image_info) {
				//get image
				$img_path = $image_info->img_path != '' ? $image_info->img_path : $image_info->img_url_path;

				//get popup image
				$popup_img_src = '';
				if( ($image_info->item_popup_open_event != 2 && $image_info->item_popup_open_event != 3)  && !($image_info->item_popup_open_event == 4 && ($cis_popup_open_event == 2 && $cis_popup_open_event == 3)) ) {//check if popup enabled
					//if we have uploaded popup image
					if($image_info->popup_img_name != '') {
						$popup_img_src = $image_info->popup_img_name;
					}
					elseif($image_info->popup_img_url != '') {
						$popup_img_src = $image_info->popup_img_url;
					}
					else {
						$popup_img_src = ($image_info->img_path != '') ? $image_info->img_path : $image_info->img_url_path;
					}
				}
				
				echo '<div class="cis_row_item" id="cis_item_'.$image_info->img_id.'" cis_popup_link="'.$popup_img_src.'" item_id="'.$image_info->img_id.'">';

				// set caption
				echo '<div class="cis_popup_caption" style="display: none !important;">'.$image_info->caption.'</div>';
				$loader_color_class = $loader_color_class == 'cis_row_item_loader_color1' ? 'cis_row_item_loader_color2' : 'cis_row_item_loader_color1';
				echo '<div class="cis_row_item_loader '.$loader_color_class.'" style="height: '.$cis_item_height.'px !important;"></div>';
				echo '<div class="cis_row_item_inner cis_row_hidden_element">';
				//image
				echo '<img src="'.$img_path.'" style="height: '.$cis_item_height.'px !important;"  />';

				//get click url
				$click_url = $image_info->redirect_url;

				//is button visible
				$cis_button_visible = (($image_info->buttonusedefault == 0 && $cis_showreadmore == 1) || ($image_info->buttonusedefault == 1 && $image_info->item_showreadmore == 1)) ? 1 : 0;
		
				// get overlay event type
				$cis_overlay_event = $image_info->item_popup_open_event == 4 ? $cis_popup_open_event : $image_info->item_popup_open_event;
				//overlay
				echo '<div class="cis_row_item_overlay" cis_popup_event="'.$cis_overlay_event.'" cis_click_url="'.$click_url.'" cis_click_target="'.$image_info->redirect_target.'" cis_button_visible="'.$cis_button_visible.'">';
				//name
				echo '<div class="cis_row_item_overlay_txt">'.$image_info->img_name.'</div>';
					
				//button
				if(($image_info->buttonusedefault == 0 && $cis_showreadmore == 1) || ($image_info->buttonusedefault == 1 && $image_info->item_showreadmore == 1)) {
					
					//click target
					$click_target = $image_info->redirect_target == 0 ? '' : ' target="_blank"';
		
					//read more text
					$item_readmoretext = $image_info->overlayusedefault == 0 ? $cis_readmoretext : $image_info->item_readmoretext;
		
					//button styles
					if($image_info->buttonusedefault == 0) {
						$button_style = 'creative_btn-' . $cis_readmorestyle;
						$button_size = 'creative_btn-' . $cis_readmoresize;
						$button_icon_color = $cis_readmorestyle == 'gray' ? 'white' : 'white';
						$button_icon_html = $cis_readmoreicon == 'none' ? '' : '<i class="creative_icon-'.$button_icon_color.' creative_icon-'.$cis_readmoreicon.'"></i> ';
					}
					else {
						$button_style = 'creative_btn-' . $image_info->item_readmorestyle;
						$button_size = 'creative_btn-' . $image_info->item_readmoresize;
						$button_icon_color = $image_info->item_readmorestyle == 'gray' ? 'white' : 'white';
						$button_icon_html = $image_info->item_readmoreicon == 'none' ? '' : '<i class="creative_icon-'.$button_icon_color.' creative_icon-'.$image_info->item_readmoreicon.'"></i> ';
					}
					echo '<a href="'.$click_url.'" class="creative_btn '.$button_style.' '.$button_size.'"'.$click_target.'>'.$button_icon_html . $item_readmoretext.'</a>';
		
					//generate css
					if($image_info->overlayusedefault == 1) {
						$item_overlaycolor_rgb = $this->cis_hex2rgb($image_info->item_overlaycolor);
						$item_overlayopacity = $image_info->item_overlayopacity / 100;
						$item_overlaycolor_rgba = 'rgba('.$item_overlaycolor_rgb.','.$item_overlayopacity.')';
							
						//get txt text shadow;
						if($image_info->item_textshadowsize == 0)
							$item_textshadow_rule = 'text-shadow: none;';
						elseif($image_info->item_textshadowsize == 1)
						$item_textshadow_rule = 'text-shadow: -1px 2px 0px '.$image_info->item_textshadowcolor.';';
						elseif($image_info->item_textshadowsize == 2)
						$item_textshadow_rule = 'text-shadow: -1px 2px 2px '.$image_info->item_textshadowcolor.';';
						elseif($image_info->item_textshadowsize == 3)
						$item_textshadow_rule = 'text-shadow: -1px 2px 4px '.$image_info->item_textshadowcolor.';';
							
						//text align
						$cis_ta = $image_info->item_readmorealign == 2 ? 'center' : 'left';
						$cis_text_align = $image_info->item_captionalign == 0 ? 'left' : ($image_info->item_captionalign == 1 ? 'right' : 'center');
							
						$items_css .= '#cis_slider_'.$id_slider.' #cis_item_'.$image_info->img_id.' .cis_row_item_overlay {';
						$items_css .= 'background-color: '.$image_info->item_overlaycolor.';';
						$items_css .= 'background-color: '.$item_overlaycolor_rgba.';';
						$items_css .= 'text-align: '.$cis_ta.';';
						$items_css .= '}';
						$items_css .= '#cis_slider_'.$id_slider.' #cis_item_'.$image_info->img_id.' .cis_row_item_overlay_txt {';
						$items_css .= $item_textshadow_rule;
						$items_css .= 'font-size: '.$image_info->item_overlayfontsize.'px;';
						$items_css .= 'color: '.$image_info->item_textcolor.';';
						$items_css .= 'margin: '.$image_info->item_captionmargin.';';
						$items_css .= 'text-align: '.$cis_text_align.';';
						$items_css .= '}';
					}
					if($image_info->overlayusedefault == 1) {
						$cis_float = $image_info->item_readmorealign == 0 ? 'left' : ($image_info->item_readmorealign == 1 ? 'right' : 'none');
							
						$items_css .= '#cis_slider_'.$id_slider.' #cis_item_'.$image_info->img_id.' .creative_btn {';
						$items_css .= 'margin: '.$image_info->item_readmoremargin.';';
						$items_css .= 'float: '.$cis_float.';';
						$items_css .= '}';
					}
				}
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}
				
			echo '</div>';
			echo '</div>';
			echo '</div>';

			//backlink
			echo '<a href="http://creative-solutions.net/wordpress/creative-image-slider" style="position: absolute;top: -10000px;left: -10000px;visibility: hidden;">Powered By Creative Image Slider</a>';
			
			//print css
			$cis_overlaycolor_rgb = cis_hex2rgb($cis_overlaycolor);
			$cis_overlayopacity = $cis_overlayopacity / 100;
			$cis_overlaycolor_rgba = 'rgba('.$cis_overlaycolor_rgb.','.$cis_overlayopacity.')';
			
			//get txt text shadow;
			if($cis_textshadowsize == 0)
				$cis_textshadow_rule = 'text-shadow: none;';
			elseif($cis_textshadowsize == 1)
			$cis_textshadow_rule = 'text-shadow: -1px 2px 0px '.$cis_textshadowcolor.';';
			elseif($cis_textshadowsize == 2)
			$cis_textshadow_rule = 'text-shadow: -1px 2px 2px '.$cis_textshadowcolor.';';
			elseif($cis_textshadowsize == 3)
			$cis_textshadow_rule = 'text-shadow: -1px 2px 4px '.$cis_textshadowcolor.';';
			
			$cis_css = '';
			$cis_css .= '#cis_slider_'.$id_slider.'.cis_main_wrapper {';
			$cis_css .= 'width: '.$cis_width.'!important;';
			$cis_css .= 'margin: '.$cis_margintop.'px auto '.$cis_marginbottom.'px;';
			$cis_css .= 'padding: '.$cis_paddingtop.'px 0px '.$cis_paddingbottom.'px 0px;';
			$cis_css .= 'background-color: '.$cis_bgcolor.';';
			$cis_css .= '}';
			$cis_css .= '#cis_slider_'.$id_slider.' .cis_row_item_overlay {';
			$cis_css .= 'background-color: '.$cis_overlaycolor.';';
			$cis_css .= 'background-color: '.$cis_overlaycolor_rgba.';';
			$cis_ta = $cis_readmorealign == 2 ? 'center' : 'left';
			$cis_css .= 'text-align: '.$cis_ta.';';
			$cis_css .= '}';
			$cis_css .= '#cis_slider_'.$id_slider.' .cis_row_item {';
			$cis_css .= 'margin-right: '.$cis_itemsoffset.'px;';
			$cis_css .= '}';
			$cis_css .= '#cis_slider_'.$id_slider.' .cis_row_item_overlay_txt {';
			$cis_css .= $cis_textshadow_rule;
			$cis_css .= 'font-size: '.$cis_overlayfontsize.'px;';
			$cis_css .= 'color: '.$cis_textcolor.';';
			$cis_css .= 'margin: '.$cis_captionmargin.';';
			$cis_text_align = $cis_captionalign == 0 ? 'left' : ($cis_captionalign == 1 ? 'right' : 'center');
			$cis_css .= 'text-align: '.$cis_text_align.';';
			$cis_css .= '}';
			$cis_css .= '#cis_slider_'.$id_slider.' .creative_btn {';
			$cis_css .= 'margin: '.$cis_readmoremargin.';';
			$cis_float = $cis_readmorealign == 0 ? 'left' : ($cis_readmorealign == 1 ? 'right' : 'none');
			$cis_css .= 'float: '.$cis_float.';';
			$cis_css .= '}';
			
			echo '<style>'.$cis_css.$items_css.'</style>';
		}
		else
			echo 'Creative Image Slider: There is nothing to show!';
		
		return $render_html1 = ob_get_clean();
	?>
	Creative Image Slider
<?php
return ob_get_clean();
}
?>