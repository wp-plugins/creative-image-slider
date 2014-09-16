<?php 
global $wpdb;

if($id != 0) {
	//get the rows
	$sql = "SELECT * FROM ".$wpdb->prefix."cis_images WHERE id = '".$id."'";
	$row = $wpdb->get_row($sql);
}
else {
	$row = (object) array('id' => 0);
}

$sql = "SELECT id,name FROM ".$wpdb->prefix."cis_sliders";
$c_row = $wpdb->get_results($sql);
$slider_options = array();
if(is_array($c_row))
	foreach($c_row as $arr)
		$slider_options[$arr->id] = $arr->name;

$sql = "SELECT COUNT(id) FROM ".$wpdb->prefix."cis_images";
$count_items = $wpdb->get_var($sql);
if($id == 0 && $count_items >= 5) {
	?>
	<div style="color: rgb(235, 9, 9);font-size: 16px;font-weight: bold;">Please Upgrade to Comercial Version to have more than 5 Creative Items!</div>
	<div id="cpanel" style="float: left;">
		<div class="icon" style="float: right;">
			<a href="http://creative-solutions.net/wordpress/creative-image-slider" target="_blank" title="Buy Comercial version">
				<table style="width: 100%;height: 100%;text-decoration: none;">
					<tr>
						<td align="center" valign="middle">
							<img src="<?php echo plugins_url( '../images/shopping_cart.png' , __FILE__ );?>" /><br />
							Buy Comercial Version
						</td>
					</tr>
				</table>
			</a>
		</div>
	</div>
	<div style="font-style: italic;font-size: 12px;color: #949494;clear: both;">Updrading to Comercial is easy, and will take only <u style="color: rgb(44, 66, 231);font-weight: bold;">5 minutes!</u></div>
	<?php 
}
else {
//********************************************************************DEFAULTS *****************************************************************************************-
$slider_global_options = Array();
$slider_global_options["showreadmore"] = 1;
$slider_global_options["readmoretext"] = 'Read More!';
$slider_global_options["readmorestyle"] = 'red';
$slider_global_options["readmoreicon"] = 'pencil';
$slider_global_options["readmoresize"] = 'normal';
$slider_global_options["overlaycolor"] = '#000000';
$slider_global_options["overlayopacity"] = 50;
$slider_global_options["textcolor"] = '#ffffff';
$slider_global_options["overlayfontsize"] = 18;
$slider_global_options["textshadowcolor"] = '#000000';
$slider_global_options["textshadowsize"] = 2;
$slider_global_options["readmorealign"] = 1;
$slider_global_options["captionalign"] = 0;
$slider_global_options["readmoremargin"] = '0px 10px 10px 10px';
$slider_global_options["captionmargin"] = '10px 15px 10px 15px';
$slider_global_options['popup_open_event'] = 4;

//get slider global options
$slider_parent_options = array();
if($id != 0) {
	$sql = "SELECT * FROM ".$wpdb->prefix."cis_sliders WHERE id = '".$row->id_slider."'";
	$slider_parent_options = $wpdb->get_row($sql);
}
$slider_parent_options1 = $slider_parent_options;
$slider_parent_options = array();
foreach($slider_parent_options1 as $k => $val) {
	$slider_parent_options[$k] = $val;
}


//get item height
if($id != 0) {
	$sql = "SELECT `height` FROM ".$wpdb->prefix."cis_sliders WHERE id = '".$row->id_slider."'";
	$item_height = $wpdb->get_var($sql);
}

?>
<!-- ********************************************************************JAVASCRIPT ************************************************************************************* -->
<script type="text/javascript">
(function($) {
	$(document).ready(function() {
		//close preview
		$("#cis_preview_close").click(function() {
			$(this).parents('.preview_box').hide();
		});
		
		var top_offset = parseInt($(".preview_box").css('top'));
		//top_offset_moove = top_offset == 75 ? 75 : 100;
		top_offset_moove = 120;
		//animate preview
		$(window).scroll(function() {
			var off = $("#preview_dummy").offset().top;

			var off_0 = $("#c_div").offset().top;
			if(off > off_0 ) {
				delta = off - off_0 + top_offset_moove*1;
				$(".preview_box").stop(true).animate( {
					top: delta
				},500);
			}
			else {
				$(".preview_box").stop(true).animate( {
					top: top_offset
				},500);
			}
			
		});

		//add sliders
	    var select11 = $( "#cis_overlayopacity" );
	    var place11 = select11.parent('div').find('.cis_slider_insert_here');
	    var slider11 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place11 ).slider({
	      min: 1,
	      max: 11,
	      range: "min",
	      value: select11[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select11[ 0 ].selectedIndex = ui.value - 1;
	        select11.trigger("change");
	      }
	    });
	    $( "#cis_overlayopacity" ).change(function() {
	    	slider11.slider( "value", this.selectedIndex + 1 );
	    });
	    
	    var select12 = $( "#cis_textshadowsize" );
	    var place12 = select12.parent('div').find('.cis_slider_insert_here');
	    var slider12 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place12 ).slider({
	      min: 1,
	      max: 4,
	      range: "min",
	      value: select12[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select12[ 0 ].selectedIndex = ui.value - 1;
	        select12.trigger("change");
	      }
	    });
	    $( "#cis_textshadowsize" ).change(function() {
	    	slider12.slider( "value", this.selectedIndex + 1 );
	    });
	    
	    var select13 = $( "#cis_captionalign" );
	    var place13 = select13.parent('div').find('.cis_slider_insert_here');
	    var slider13 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place13 ).slider({
	      min: 1,
	      max: 3,
	      range: "min",
	      value: select13[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select13[ 0 ].selectedIndex = ui.value - 1;
	        select13.trigger("change");
	      }
	    });
	    $( "#cis_captionalign" ).change(function() {
	    	slider13.slider( "value", this.selectedIndex + 1 );
	    });
	    
	    var select14 = $( "#cis_overlayfontsize" );
	    var place14 = select14.parent('div').find('.cis_slider_insert_here');
	    var slider14 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place14 ).slider({
	      min: 1,
	      max: 46,
	      range: "min",
	      value: select14[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select14[ 0 ].selectedIndex = ui.value - 1;
	        select14.trigger("change");
	      }
	    });
	    $( "#cis_overlayfontsize" ).change(function() {
	    	slider14.slider( "value", this.selectedIndex + 1 );
	    });
	    
	    var select15 = $( "#cis_readmorestyle" );
	    var place15 = select15.parent('div').find('.cis_slider_insert_here');
	    var slider15 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place15 ).slider({
	      min: 1,
	      max: 7,
	      range: "min",
	      value: select15[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select15[ 0 ].selectedIndex = ui.value - 1;
	        select15.trigger("change");
	      }
	    });
	    $( "#cis_readmorestyle" ).change(function() {
	    	slider15.slider( "value", this.selectedIndex + 1 );
	    });
	    
	    var select16 = $( "#cis_readmorealign" );
	    var place16 = select16.parent('div').find('.cis_slider_insert_here');
	    var slider16 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place16 ).slider({
	      min: 1,
	      max: 3,
	      range: "min",
	      value: select16[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select16[ 0 ].selectedIndex = ui.value - 1;
	        select16.trigger("change");
	      }
	    });
	    $( "#cis_readmorealign" ).change(function() {
	    	slider16.slider( "value", this.selectedIndex + 1 );
	    });
	    
	    var select17 = $( "#cis_readmoresize" );
	    var place17 = select17.parent('div').find('.cis_slider_insert_here');
	    var slider17 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place17 ).slider({
	      min: 1,
	      max: 4,
	      range: "min",
	      value: select17[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select17[ 0 ].selectedIndex = ui.value - 1;
	        select17.trigger("change");
	      }
	    });
	    $( "#cis_readmoresize" ).change(function() {
	    	slider17.slider( "value", this.selectedIndex + 1 );
	    });
	    
	    var select18 = $( "#cis_readmoreicon" );
	    var place18 = select18.parent('div').find('.cis_slider_insert_here');
	    var slider18 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place18 ).slider({
	      min: 1,
	      max: 27,
	      range: "min",
	      value: select18[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select18[ 0 ].selectedIndex = ui.value - 1;
	        select18.trigger("change");
	      }
	    });
	    $( "#cis_readmoreicon" ).change(function() {
	    	slider18.slider( "value", this.selectedIndex + 1 );
	    });
		
		//show/hide overlay options///////////////////////////////////////////////////////////////////////////
		$("#cis_overlayusedefault").change(function() {
			var v = parseInt($(this).val());
			var $targetElement = $("#overlay_custom_options_block");
			if(v == 0) {
				$targetElement.hide();
				$(".cis_row_item_overlay_txt").removeAttr('style').addClass('cis_row_item_overlay_txt_important');
				$(".cis_row_item_overlay").removeAttr('style').css('display','block').addClass('cis_row_item_overlay_important');

			}
			else {
				$targetElement.show();
				$(".cis_row_item_overlay_txt").removeClass('cis_row_item_overlay_txt_important');
				$(".cis_row_item_overlay").removeClass('cis_row_item_overlay_important');
				cis_update_overlay_txt();
				cis_update_overlay_bg();
			}
		});
		//show/hide button options
		$("#cis_buttonusedefault").change(function() {
			var v = parseInt($(this).val());
			var $targetElement = $("#button_custom_options_block");
			$('.cis_row_item_overlay').removeClass('creative_button_wrapper_centered');
			if(v == 0) {
				$targetElement.hide();
				$('.creative_btn').hide();
				if(parseInt($('.creative_button_global').attr("parent_visible")) == 1) {
					if(parseInt($('.creative_button_global').attr("parent_aligned")) == 2)
						$('.cis_row_item_overlay').addClass('creative_button_wrapper_centered');
					$('.creative_button_global').show().css('display','inline-block');
				}
			}
			else {
				$targetElement.show();
				if(parseInt($("#cis_showreadmore").val()) == 1)
					$('.creative_btn').show().css('display','inline-block');
				else
					$('.creative_btn').hide();
				$('.creative_button_global').hide();
			}
		});

		
		//colorpicker
		var active_element;
		$('.colorSelector').click(function() {
			active_element = $(this).parent('div');
		})
		
		$('.colorSelector').ColorPicker({
			onBeforeShow: function () {
				$color = $(active_element).find('input').val();
				$(this).ColorPickerSetColor($color);
			},
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				active_element.find('input').val('#' + hex);
				$(active_element).children('#colorSelector').children('div').css('backgroundColor', '#' + hex);

				cis_update_overlay_txt();
				cis_update_overlay_bg();

				//$("#ssw_template_wrapper").css('background-color','#' + hex);
			}
		});

		//preview
		$("#cis_name").keyup(function() {
			var v = $(this).val();
			$(".cis_row_item_overlay_txt").html(v);
		});

		function cis_update_overlay_txt() {
			var $cis_element = $(".cis_row_item_overlay_txt");

			//generate styles
			var textShadowSize = parseInt($("#cis_textshadowsize").val());
			var textShadowColor = $("#cis_textshadowcolor").val();
			var textShadowRule = textShadowSize == 0 ? 'none' : (textShadowSize == 1 ? '1px 2px 0px ' + textShadowColor : (textShadowSize == 2 ? '1px 2px 2px ' + textShadowColor : '1px 2px 4px ' + textShadowColor));

			var textAlignVal = parseInt($("#cis_captionalign").val());
			var textAlign = textAlignVal == 0 ? 'left' : (textAlignVal == 1 ? 'right' : 'center');

			var textColor = $("#cis_textcolor").val();
			var textFontSize = parseInt($("#cis_overlayfontsize").val());
			var textMargin = $("#cis_captionmargin").val();

			//apply css

			$cis_element.css({
				'text-shadow' : textShadowRule,
				'color' : textColor,
				'font-size' : textFontSize,
				'margin' : textMargin,
				'text-align': textAlign
			});
		};

		function cis_hexToRgb(hex) {
		    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		    return result ? parseInt(result[1], 16) + ',' + parseInt(result[2], 16) + ',' + parseInt(result[3], 16) : null;
		};
		
		function cis_update_overlay_bg() {
			var $cis_element = $(".cis_row_item_overlay");

			//generate css
			var overlay_bg = $("#cis_overlaycolor").val();
			var overlay_opacity = $("#cis_overlayopacity").val() / 100;
			var overlay_bg_rgba = 'rgba(' + cis_hexToRgb(overlay_bg) + ',' + overlay_opacity + ')';

			$cis_element.css({
				'background-color' : overlay_bg,
				'background-color' : overlay_bg_rgba
			});
		};

		//overlay txt
		$("#cis_textshadowsize").change(function() {
			cis_update_overlay_txt();
		});
		$("#cis_captionalign").change(function() {
			cis_update_overlay_txt();
		});
		$("#cis_captionmargin").keyup(function() {
			cis_update_overlay_txt();
		});
		$("#cis_captionmargin").keyup(function() {
			cis_update_overlay_txt();
		});
		$("#cis_overlayfontsize").change(function() {
			cis_update_overlay_txt();
		});

		//overlay bg
		$("#cis_overlayopacity").change(function() {
			cis_update_overlay_bg();
		});

		//buttons preview///////////////////////////////////////
		$("#cis_showreadmore").change(function() {
			var v = parseInt($(this).val());
			var $targetElement = $(".creative_btn").not('.creative_button_global');
			if(v == 0) {
				$targetElement.hide();
			}
			else {
				$targetElement.show().css('display','inline-block');
			}
		});

		$("#cis_readmoretext").keyup(function() {
			var v = $(this).val();
			$(".cis_creative_btn_txt").html(v);
		});

		function cis_make_creative_button() {
			var $cis_element = $(".creative_btn").not('.creative_button_global');

			//generate css
			var margin = $("#cis_readmoremargin").val();
			var float = parseInt($("#cis_readmorealign").val()) == 0 ? 'left' : (parseInt($("#cis_readmorealign").val()) == 1 ? 'right' : 'none');
			var button_style_class = 'creative_btn-' + $("#cis_readmorestyle").val();
			var button_size_class = 'creative_btn-' + $("#cis_readmoresize").val();
			
			$cis_element.attr("class","creative_btn " + button_style_class + " " + button_size_class);

			//icon
			var cis_icon = $("#cis_readmoreicon").val() == 'none' ? '' : '<i class="creative_icon-white creative_icon-' + $("#cis_readmoreicon").val() + '"></i> ';
			$(".cis_creative_btn_icon").html(cis_icon);

			if(float == 'none')
				$cis_element.parent('div').css('text-align','center');
			else
				$cis_element.parent('div').css('text-align','left');
			
			$cis_element.css({
				'margin' : margin,
				'float' : float
			});
		};

		$("#cis_readmoremargin").keyup(function() {
			cis_make_creative_button();
		});
		$("#cis_readmorestyle").change(function() {
			cis_make_creative_button();
		});
		$("#cis_readmoresize").change(function() {
			cis_make_creative_button();
		});
		$("#cis_readmorealign").change(function() {
			cis_make_creative_button();
		});
		$("#cis_readmoreicon").change(function() {
			cis_make_creative_button();
		});

		// textarea animation
		$("#cis_caption").focus(function() {
			$(this).stop(true,false).animate({
				'height': '250px'
			},200);
		});
		$("#cis_caption").blur(function() {
			$(this).stop(true,false).animate({
				'height': '45px'
			},200);
		});


	});
})(jQuery);
</script>

<form action="admin.php?page=cis_items&act=cis_submit_data&holder=items" method="post" id="wpcis_form">
<div style="overflow: hidden;margin: 0 0 10px 0;">
	<div style="float:right;">
		<button  id="wpcis_form_save" class="button-primary">Save</button>
		<button id="wpcis_form_save_close" class="button">Save & Close</button>
		<button id="wpcis_form_save_new" class="button">Save & New</button>
		<a href="admin.php?page=cis_items" id="wpcis_add" class="button"><?php echo $t = $id == 0 ? 'Cancel' : 'Close';?></a>
	</div>
</div>
<div id="c_div">
	<div>
		<table cellpadding="0" cellspacing="0" style="width: 100%;">
			<tr>
				<td style="width: 420px;vertical-align: top;" align="top">

<!-- ********************************************************FORM OPTIONS**************************************************************************************************************************************************************************************************************************************************************************************************** -->
					<div style="clear: both;margin: 0px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_MAIN_OPTIONS_LABEL' ];?></div>
							<div class="cis_control_label"><label id="" for="cis_name" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_NAME_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_NAME_LABEL' ];?><!-- <span class="star">&nbsp;*</span> --></label></div>
							<div class="cis_controls"><input type="text" name="name" id="cis_name" value="<?php echo $v = $row->id == 0 ? '' : $row->name;?>" class="inputbox required" size="40"   ></div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_caption" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_CAPTION_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_CAPTION_LABEL' ];?></label></div>
							<div class="cis_controls">
								<textarea name="caption" id="cis_caption" style="width: 218px;height: 45px;font-size: 13px;resize: none;color: #555;"><?php echo $v = $row->id == 0 ? '' : $row->caption;?></textarea>
							</div>
						
							<div style="clear: both;height: 7px;"></div>
							<div class="cis_control_label"><label id="" for="cis_img_name" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_IMAGE_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_IMAGE_LABEL' ];?></label></div>
							<div class="cis_controls">
								<div title="Preview" class="cis_preview_img"><div class="cis_upl_preview_box"><div class="cis_upl_title">Selected Image</div><div class="cis_upl_img_prw">No image selected.</div><img src="" style="display: none" /></div></div>
								<div title="Clear Image" class="cis_clear_img"></div>
								<input type="text" readonly="readonly" name="img_name" id="cis_img_name" value="<?php echo $v = $row->id == 0 ? '' : $row->img_name;?>" class="inputbox wpcis_upload_image_wrapper" size="40"  >
								<input type="button" value="Select" class="wpcis_upload_image" />
							</div>

							<div style="clear: both;height: 7px;"></div>
							<div class="cis_control_label"><label id="" for="cis_img_url" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_IMGURL_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_IMGURL_LABEL' ];?></label></div>
							<div class="cis_controls"><input type="text" name="img_url" id="cis_img_url" value="<?php echo $v = $row->id == 0 ? '' : $row->img_url;?>" class="inputbox" size="40"  ></div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_id_slider" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_SLIDER_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_SLIDER_LABEL' ];?></label></div>
							<div class="cis_controls">
									<?php 
									$default = $row->id == 0 ? 1 : $row->id_slider;
									//$opts = array(1 => 'Published', 0 => 'Unpublished');
									$opts = $slider_options;
									$options = array();
									echo '<select id="cis_id_slider" class="" name="id_slider">';
									foreach($opts as $key=>$value) :
										$selected = $key == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
									endforeach;
									echo '</select>';
									?>
							</div>


							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_open_event" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ITEM_OPENEVENT_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ITEM_OPENEVENT_LABEL' ];?></label></div>
							<div class="cis_controls">
									<?php 
									$default = $row->id == 0 ? $slider_global_options['popup_open_event'] : $row->popup_open_event;
									$opts = array(4 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_GLOBAL_LABEL'], 0 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_OPENEVENT_BUTTON'], 1 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_OPENEVENT_OVERLAY'], 2 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_OPENEVENT_LINK'], 3 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_OPENEVENT_NONE']);
									$options = array();
									echo '<select id="cis_popup_open_event" class="" name="popup_open_event">';
									foreach($opts as $key=>$value) :
										$selected = $key == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
									endforeach;
									echo '</select>';
									?>
							</div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_status" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_STATUS_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_STATUS_LABEL' ];?></label></div>
							<div class="cis_controls">
									<?php 
									$default = $row->id == 0 ? 1 : $row->published;
									$opts = array(1 => 'Published', 0 => 'Unpublished');
									$options = array();
									echo '<select id="cis_status" class="" name="published">';
									foreach($opts as $key=>$value) :
										$selected = $key == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
									endforeach;
									echo '</select>';
									?>
							</div>

							<div style="clear: both;margin: 15px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_OPTIONS_LABEL' ];?></div>
							
							<div style="clear: both;height: 7px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_img_name" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_IMAGE_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_IMAGE_LABEL' ];?></label></div>
							<div class="cis_controls">
								<div title="Preview" class="cis_preview_img"><div class="cis_upl_preview_box"><div class="cis_upl_title">Selected Image</div><div class="cis_upl_img_prw">No image selected.</div><img src="" style="display: none" /></div></div>
								<div title="Clear Image" class="cis_clear_img"></div>
								<input type="text" readonly="readonly" name="popup_img_name" id="cis_popup_img_name" value="<?php echo $v = $row->id == 0 ? '' : $row->popup_img_name;?>" class="inputbox wpcis_upload_image_wrapper" size="40"  >
								<input type="button" value="Select" class="wpcis_upload_image" />
							</div>
						
							<div style="clear: both;height: 7px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_img_url" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_IMGURL_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_IMGURL_LABEL' ];?></label></div>
							<div class="cis_controls"><input type="text" name="popup_img_url" id="cis_popup_img_url" value="<?php echo $v = $row->id == 0 ? '' : $row->popup_img_url;?>" class="inputbox" size="40"  ></div>

							<div style="clear: both;margin: 15px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAY_OPTIONS_LABEL' ];?></div>
							
							<div class="cis_control_label"><label id="" for="cis_overlayusedefault" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYUSEDEFAULT_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYUSEDEFAULT_LABEL' ];?></label></div>
							<div class="cis_controls">
									<?php 
									$default = $row->id == 0 ? 0 : $row->overlayusedefault;
									$opts = array(0 => $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_GLOBAL_LABEL'], 1 => $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_CUSTOM_LABEL']);
									$options = array();
									echo '<select id="cis_overlayusedefault" class="" name="overlayusedefault">';
									foreach($opts as $key=>$value) :
										$selected = $key == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
									endforeach;
									echo '</select>';
									?>
							</div>
							
							<div id="overlay_custom_options_block" <?php if($row->id == 0 || $row->overlayusedefault == 0) echo 'style="display: none;';?>">
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label  style="margin-top: 4px;" id="" for="cis_overlaycolor" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYCOLOR_LABEL' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYCOLOR_DESCRIPTION' ];?></label></div>
								<div class="cis_controls">
									<div id="colorSelector" class="colorSelector" style="float: left;"><div style="background-color: <?php echo $v = $row->id == 0 ? $slider_global_options['overlaycolor'] : $row->overlaycolor;?>"></div></div>
	               					<input class="colorSelector" type="text" value="<?php echo $v = $row->id == 0 ? $slider_global_options['overlaycolor'] : $row->overlaycolor;?>" name="overlaycolor" roll=""  id="cis_overlaycolor" style="width: 162px;margin: 4px 0 0 6px;" />
								</div>
								
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label id="" for="cis_overlayopacity" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYOPACITY_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYOPACITY_LABEL' ];?></label></div>
								<div class="cis_controls cis_slider_wrapper">
										<?php 
										$default = $row->id == 0 ? $slider_global_options['overlayopacity'] : $row->overlayopacity;
										$opts = array(0 => '0', 10 => '10%', 20 => '20%', 30 => '30%', 40 => '40%', 50 => '50%', 60 => '60%', 70 => '70%', 80 => '80%', 90 => '90%', 100 => '100%');
										$options = array();
										echo '<select id="cis_overlayopacity" class="cis_has_slider" name="overlayopacity">';
										foreach($opts as $key=>$value) :
											$selected = $key == $default ? 'selected="selected"' : '';
											echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
										endforeach;
										echo '</select>';
										?>
										<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
								</div>
								
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label id="" for="cis_captionalign" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_CAPTIONALIGN_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_CAPTIONALIGN_LABEL' ];?></label></div>
								<div class="cis_controls cis_slider_wrapper">
										<?php 
										$default = $row->id == 0 ? $slider_global_options['captionalign'] : $row->captionalign;
										$opts = array(0 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_LEFT'], 2 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_CENTER'], 1 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_RIGHT']);
										$options = array();
										echo '<select id="cis_captionalign" class="cis_has_slider" name="captionalign">';
										foreach($opts as $key=>$value) :
											$selected = $key == $default ? 'selected="selected"' : '';
											echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
										endforeach;
										echo '</select>';
										?>
										<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
								</div>
								
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label id="" for="cis_captionmargin" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_CAPTIONMARGIN_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_CAPTIONMARGIN_LABEL' ];?></label></div>
								<div class="cis_controls"><input type="text" name="captionmargin" id="cis_captionmargin" value="<?php echo $v = $row->id == 0 ? $slider_global_options['captionmargin'] : $row->captionmargin;?>" class="inputbox" size="40"  ></div>
							
								
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label  style="margin-top: 4px;" id="" for="cis_textcolor" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_TEXTCOLOR_LABEL' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_TEXTCOLOR_DESCRIPTION' ];?></label></div>
								<div class="cis_controls">
									<div id="colorSelector" class="colorSelector" style="float: left;"><div style="background-color: <?php echo $v = $row->id == 0 ? $slider_global_options['textcolor'] : $row->textcolor;?>"></div></div>
	               					<input class="colorSelector" type="text" value="<?php echo $v = $row->id == 0 ? $slider_global_options['textcolor'] : $row->textcolor;?>" name="textcolor" roll=""  id="cis_textcolor" style="width: 162px;margin: 4px 0 0 6px;" />
								</div>
										
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label  style="margin-top: 4px;" id="" for="cis_textshadowcolor" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_TEXTSHAOWCOLOR_LABEL' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_TEXTSHAOWCOLOR_DESCRIPTION' ];?></label></div>
								<div class="cis_controls">
									<div id="colorSelector" class="colorSelector" style="float: left;"><div style="background-color: <?php echo $v = $row->id == 0 ? $slider_global_options['textshadowcolor'] : $row->textshadowcolor;?>"></div></div>
	               					<input class="colorSelector" type="text" value="<?php echo $v = $row->id == 0 ? $slider_global_options['textshadowcolor'] : $row->textshadowcolor;?>" name="textshadowcolor" roll=""  id="cis_textshadowcolor" style="width: 162px;margin: 4px 0 0 6px;" />
								</div>
								
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label id="" for="cis_overlayfontsize" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYFONTSIZE_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYFONTSIZE_LABEL' ];?></label></div>
								<div class="cis_controls cis_slider_wrapper">
										<?php 
										$default = $row->id == 0 ? $slider_global_options['overlayfontsize'] : $row->overlayfontsize;
										$opts = array(5 => '5px', 6 => '6px', 7 => '7px', 8 => '8px', 9 => '9px', 10 => '10px', 11 => '11px', 12 => '12px', 13 => '13px', 14 => '14px', 15 => '15px', 16 => '16px', 17 => '17px', 18 => '18px', 19 => '19px', 20 => '20px', 21 => '21px', 22 => '22px', 23 => '23px', 24 => '24px', 25 => '25px', 26 => '26px', 27 => '27px', 28 => '28px', 29 => '29px', 30 => '30px', 31 => '31px', 32 => '32px', 33 => '33px', 34 => '34px', 35 => '35px', 36 => '36px');
										$options = array();
										echo '<select id="cis_overlayfontsize" class="cis_has_slider" name="overlayfontsize">';
										for($k = 5; $k <= 50; $k ++) :
											$selected = $k == $default ? 'selected="selected"' : '';
											echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
										endfor;
										echo '</select>';
										?>
										<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
								</div>
								
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label id="" for="cis_textshadowsize" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_TEXTSHADOWSIZE_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_TEXTSHADOWSIZE_LABEL' ];?></label></div>
								<div class="cis_controls cis_slider_wrapper">
										<?php 
										$default = $row->id == 0 ? $slider_global_options['textshadowsize'] : $row->textshadowsize;
										$opts = array(0 => $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_NONE_LABEL' ], 1 => $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_LOW_LABEL' ], 2 => $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_NORMAL_LABEL' ], 3 => $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_HIGH_LABEL' ]);
										$options = array();
										echo '<select id="cis_textshadowsize" class="cis_has_slider" name="textshadowsize">';
										foreach($opts as $key=>$value) :
											$selected = $key == $default ? 'selected="selected"' : '';
											echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
										endforeach;
										echo '</select>';
										?>
										<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
								</div>
							</div>
							
							<div style="clear: both;margin: 15px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_BUTTON_OPTIONS_LABEL' ];?></div>
							
							<div class="cis_control_label"><label id="" for="cis_buttonusedefault" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_BUTTONUSEDEFAULT_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_BUTTONUSEDEFAULT_LABEL' ];?></label></div>
							<div class="cis_controls">
									<?php 
									$default = $row->id == 0 ? 0 : $row->buttonusedefault;
									$opts = array(0 => $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_GLOBAL_LABEL'], 1 => $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_CUSTOM_LABEL']);
									$options = array();
									echo '<select id="cis_buttonusedefault" class="" name="buttonusedefault">';
									foreach($opts as $key=>$value) :
										$selected = $key == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
									endforeach;
									echo '</select>';
									?>
							</div>
							
							<div id="button_custom_options_block" <?php if($row->id == 0 || $row->buttonusedefault == 0) echo 'style="display: none;';?>">
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label id="" for="cis_showreadmore" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_SHOWREADMOREITEM_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_SHOWREADMOREITEM_LABEL' ];?></label></div>
								<div class="cis_controls">
										<?php 
										$default = $row->id == 0 ? $slider_global_options['showreadmore'] : $row->showreadmore;
										$opts = array(0 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_NO'], 1 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_YES']);
										$options = array();
										echo '<select id="cis_showreadmore" class="" name="showreadmore">';
										foreach($opts as $key=>$value) :
											$selected = $key == $default ? 'selected="selected"' : '';
											echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
										endforeach;
										echo '</select>';
										?>
								</div>
								
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label id="" for="cis_readmoretext" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMORETEXTITEM_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMORETEXT_LABEL' ];?></label></div>
								<div class="cis_controls"><input type="text" name="readmoretext" id="cis_readmoretext" value="<?php echo $v = $row->id == 0 ? $slider_global_options['readmoretext'] : $row->readmoretext;?>" class="inputbox" size="40"  ></div>
							
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label id="" for="cis_readmoremargin" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMOREMARGIN_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMOREMARGIN_LABEL' ];?></label></div>
								<div class="cis_controls"><input type="text" name="readmoremargin" id="cis_readmoremargin" value="<?php echo $v = $row->id == 0 ? $slider_global_options['readmoremargin'] : $row->readmoremargin;?>" class="inputbox" size="40"  ></div>
						
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label id="" for="cis_readmorestyle" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMORESTYLEITEM_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMORESTYLE_LABEL' ];?></label></div>
								<div class="cis_controls cis_slider_wrapper">
										<?php 
										$default = $row->id == 0 ? $slider_global_options['readmorestyle'] : $row->readmorestyle;
										$opts = array('gray' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMORESTYLE_GRAY'], 'blue' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMORESTYLE_BLUE'], 'raver' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMORESTYLE_RAVER'], 'green' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMORESTYLE_GREEN'], 'orange' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMORESTYLE_ORANGE'], 'red' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMORESTYLE_RED'], 'black' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMORESTYLE_BLACK']);
										$options = array();
										echo '<select id="cis_readmorestyle" class="cis_has_slider" name="readmorestyle">';
										foreach($opts as $key=>$value) :
											$selected = $key == $default ? 'selected="selected"' : '';
											echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
										endforeach;
										echo '</select>';
										?>
										<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
								</div>
								
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label id="" for="cis_readmorealign" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMOREALIGN_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMOREALIGN_LABEL' ];?></label></div>
								<div class="cis_controls cis_slider_wrapper">
										<?php 
										$default = $row->id == 0 ? $slider_global_options['readmorealign'] : $row->readmorealign;
										$opts = array(0 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_LEFT'], 2 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_CENTER'], 1 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_RIGHT']);
										$options = array();
										echo '<select id="cis_readmorealign" class="cis_has_slider" name="readmorealign">';
										foreach($opts as $key=>$value) :
											$selected = $key == $default ? 'selected="selected"' : '';
											echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
										endforeach;
										echo '</select>';
										?>
										<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
								</div>
								
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label id="" for="cis_readmoresize" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMORESIZEITEM_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMORESIZE_LABEL' ];?></label></div>
								<div class="cis_controls cis_slider_wrapper">
										<?php 
										$default = $row->id == 0 ? $slider_global_options['readmoresize'] : $row->readmoresize;
										$opts = array('mini' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMORESIZE_MINI'], 'small' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMORESIZE_SMALL'], 'normal' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMORESIZE_NORMAL'], 'large' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMORESIZE_LARGE']);
										$options = array();
										echo '<select id="cis_readmoresize" class="cis_has_slider" name="readmoresize">';
										foreach($opts as $key=>$value) :
											$selected = $key == $default ? 'selected="selected"' : '';
											echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
										endforeach;
										echo '</select>';
										?>
										<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
								</div>
							
								<div style="clear: both;height: 5px;"></div>
								<div class="cis_control_label"><label id="" for="cis_readmoreicon" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMOREICON_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMOREICON_LABEL' ];?></label></div>
								<div class="cis_controls cis_slider_wrapper">
										<?php 
										$default = $row->id == 0 ? $slider_global_options['readmoreicon'] : $row->readmoreicon;
										$opts = array('none' =>  $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_NONE'], 'play' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_PLAY'], 'ok' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_OK'], 'check' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_CHECK'], 'pencil' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_PENCIL'], 'star' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_STAR'], 'star-empty' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_STAR_EMPTY'], 'user' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_USER'], 'download' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_DOWNLOAD'], 'home' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_HOME'], 'music' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_MUSIC'], 'list' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_LIST'], 'glass' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_GLASS'], 'time' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_TIME'], 'tag' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_TAG'], 'tags' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_TAGS'], 'book' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_BOOK'], 'picture' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_PICTURE'], 'tint' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_TINT'], 'fire' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_FIRE'], 'comment' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_COMMENT'], 'magnet' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_MAGNET'], 'chevron-down' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_CHEVRON_DOWN'], 'chevron-up' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_CHEVRON_UP'], 'bell' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_BELL'], 'like' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_LIKE'], 'globe' => $slider_dictionary['COM_CREATIVEIMAGESLIDER_READMOREICON_GLOBE']);
										$options = array();
										echo '<select id="cis_readmoreicon" class="cis_has_slider" name="readmoreicon">';
										foreach($opts as $key=>$value) :
											$selected = $key == $default ? 'selected="selected"' : '';
											echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
										endforeach;
										echo '</select>';
										?>
										<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
								</div>
							</div>
							
							<div style="clear: both;margin: 15px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_BUTTON_LINK_OPTIONS_LABEL' ];?></div>
							<div class="cis_control_label"><label id="" for="cis_redirect_url" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_REDIRECT_URL_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_REDIRECT_URL_LABEL' ];?></label></div>
							<div class="cis_controls"><input type="text" name="redirect_url" id="cis_redirect_url" value="<?php echo $v = $row->id == 0 ? '#' : $row->redirect_url;?>" class="inputbox" size="40"  ></div>
							

							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_redirect_target" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_REDIRECT_TARGET_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_REDIRECT_TARGET_LABEL' ];?></label></div>
							<div class="cis_controls">
									<?php 
									$default = $row->id == 0 ? 0 : $row->redirect_target;
									$opts = array(0 => 'Same Window', 1 => 'New Window');
									$options = array();
									echo '<select id="cis_redirect_target" class="" name="redirect_target">';
									foreach($opts as $key=>$value) :
										$selected = $key == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
									endforeach;
									echo '</select>';
									?>
							</div>
					
<!-- ******************************************************** END FORM OPTIONS**************************************************************************************************************************************************************************************************************************************************************************************************** -->
				</td>
				<td style="vertical-align: top;position: relative;"align="top">
<!-- ******************************************************** SLIDER PREVEW**************************************************************************************************************************************************************************************************************************************************************************************************** -->
				<?php 
				if($row->id != 0) {
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

					$img_name =  $row->img_name != '' ? $row->img_name : $row->img_url;
					if($img_name != '') {?>
					<div id="preview_dummy" style="position: fixed;left:0;top: 0;"></div>
					<div class="preview_box" style="position: absolute;width: 100%;top: 75px;">
						<img alt="Close Preview Box" title="Close Preview Box" src="<?php echo plugin_dir_url( __FILE__ );?>../images/close.png" id="cis_preview_close" />
						<div  id="cis_preview">Preview</div>
						<div id="cis_preview_wrapper1" style="position: relative;overflow: hidden;">
							<div id="cis_preview_inner1">
								<div style="margin: 0px auto 5px;color: #444;font-style: italic;">Item preview (active state)</div>
								
								<?php 
									//item preview
								?>
								<div class="cis_main_wrapper" style="display: block;position: relative !important;margin-bottom: 15px;">
									<div class="cis_row_item" id="cis_item_<?php echo $row->id?>" style="float: none;display: inline-block;">
										<img src="<?php echo $img_name;?>" style="height: <?php echo $item_height;?>px" />
										<div class="cis_row_item_overlay" style="display: block;">
											<div class="cis_row_item_overlay_txt"><?php echo $row->name;?></div>
											<?php 
											if(($row->buttonusedefault == 0 && $slider_parent_options['showreadmore'] == 1) || ($row->buttonusedefault == 1 && $row->showreadmore == 1))
												$cis_readmorevisible_style = 'style="display:inline-block;"';
											else
												$cis_readmorevisible_style = 'style="display:none;"';;
											//read more text
											$item_readmoretext = $row->buttonusedefault == 0 ? $slider_parent_options['readmoretext'] : $row->readmoretext;
											
											//button styles
											if($row->buttonusedefault == 0) {
												$button_style = 'creative_btn-' . $slider_parent_options['readmorestyle'];
												$button_size = 'creative_btn-' . $slider_parent_options['readmoresize'];
												$button_icon_color = 'white';
												$button_icon_html = $slider_parent_options['readmoreicon'] == 'none' ? '' : '<i class="creative_icon-'.$button_icon_color.' creative_icon-'.$slider_parent_options['readmoreicon'].'"></i> ';
											}
											else {
												$button_style = 'creative_btn-' . $row->readmorestyle;
												$button_size = 'creative_btn-' . $row->readmoresize;
												$button_icon_color = 'white';
												$button_icon_html = $row->readmoreicon == 'none' ? '' : '<i class="creative_icon-'.$button_icon_color.' creative_icon-'.$row->readmoreicon.'"></i> ';
											}
											echo '<a href="#" '.$cis_readmorevisible_style.' onclick="return false;" class="creative_btn '.$button_style.' '.$button_size.'"><span class="cis_creative_btn_icon">'.$button_icon_html . '</span><span class="cis_creative_btn_txt">' . $item_readmoretext.'</span></a>';
											
											//button with global options
											$button_style = 'creative_btn-' . $slider_parent_options['readmorestyle'];
											$button_size = 'creative_btn-' . $slider_parent_options['readmoresize'];
											$button_icon_color = 'white';
											$button_icon_html = $slider_parent_options['readmoreicon'] == 'none' ? '' : '<i class="creative_icon-'.$button_icon_color.' creative_icon-'.$slider_parent_options['readmoreicon'].'"></i> ';
											echo '<a href="#" parent_visible="'.$slider_parent_options['showreadmore'].'" parent_aligned="'.$slider_parent_options['readmorealign'].'" style="display: none" onclick="return false;" class="creative_btn '.$button_style.' '.$button_size.' creative_button_global"><span class="">'.$button_icon_html . '</span><span class="cis_creative_btn_txt">' . $slider_parent_options['readmoretext'].'</span></a>';
											?>
										</div>
									</div>
								</div>
								<?php 
								$items_css = '';
								//generate css
								if($row->overlayusedefault == 1) {
									$item_overlaycolor_rgb = cis_hex2rgb($row->overlaycolor);
									$item_overlayopacity = $row->overlayopacity / 100;
									$item_overlaycolor_rgba = 'rgba('.$item_overlaycolor_rgb.','.$item_overlayopacity.')';
										
									//get txt text shadow;
									if($row->textshadowsize == 0)
										$item_textshadow_rule = 'text-shadow: none;';
									elseif($row->textshadowsize == 1)
										$item_textshadow_rule = 'text-shadow: -1px 2px 0px '.$row->textshadowcolor.';';
									elseif($row->textshadowsize == 2)
										$item_textshadow_rule = 'text-shadow: -1px 2px 2px '.$row->textshadowcolor.';';
									elseif($row->textshadowsize == 3)
										$item_textshadow_rule = 'text-shadow: -1px 2px 4px '.$row->textshadowcolor.';';
										
									//text align
									$cis_ta = ($row->readmorealign == 2 || ($row->buttonusedefault == 0 && $slider_parent_options["readmorealign"] == 2)) ? 'center' : 'left';
									$cis_text_align = $row->captionalign == 0 ? 'left' : ($row->captionalign == 1 ? 'right' : 'center');
										
									$id_slider = $row->id_slider;
									$items_css .= '#cis_item_'.$row->id.' .cis_row_item_overlay {';
									$items_css .= 'background-color: '.$row->overlaycolor.';';
									$items_css .= 'background-color: '.$item_overlaycolor_rgba.';';
									$items_css .= 'text-align: '.$cis_ta.';';
									$items_css .= '}';
									$items_css .= '#cis_item_'.$row->id.' .cis_row_item_overlay_txt {';
									$items_css .= $item_textshadow_rule;
									$items_css .= 'font-size: '.$row->overlayfontsize.'px;';
									$items_css .= 'color: '.$row->textcolor.';';
									$items_css .= 'margin: '.$row->captionmargin.';';
									$items_css .= 'text-align: '.$cis_text_align.';';
									$items_css .= '}';
								}
								if($row->buttonusedefault == 1) {
									$cis_float = $row->readmorealign == 0 ? 'left' : ($row->readmorealign == 1 ? 'right' : 'none');
										
									$items_css .= '#cis_item_'.$row->id.' .creative_btn {';
									$items_css .= 'margin: '.$row->readmoremargin.' !important;';
									$items_css .= 'float: '.$cis_float.';';
									$items_css .= '}';
								}
								
								//global css
								$slider_overlaycolor_rgb = cis_hex2rgb($slider_parent_options["overlaycolor"]);
								$slider_overlayopacity = $slider_parent_options["overlayopacity"] / 100;
								$slider_overlaycolor_rgba = 'rgba('.$slider_overlaycolor_rgb.','.$slider_overlayopacity.')';
								
								//get txt text shadow;
								if($slider_parent_options["textshadowsize"] == 0)
									$slider_textshadow_rule = 'text-shadow: none;';
								elseif($slider_parent_options["textshadowsize"] == 1)
									$slider_textshadow_rule = 'text-shadow: -1px 2px 0px '.$slider_parent_options["textshadowcolor"].';';
								elseif($slider_parent_options["textshadowsize"] == 2)
									$slider_textshadow_rule = 'text-shadow: -1px 2px 2px '.$slider_parent_options["textshadowcolor"].';';
								elseif($slider_parent_options["textshadowsize"] == 3)
									$slider_textshadow_rule = 'text-shadow: -1px 2px 4px '.$slider_parent_options["textshadowcolor"].';';
								
								$cis_css = '';
								$cis_css .= '.cis_row_item_overlay {';
								$cis_css .= 'background-color: '.$slider_parent_options["overlaycolor"].';';
								$cis_css .= 'background-color: '.$slider_overlaycolor_rgba.';';
								$cis_ta = $slider_parent_options["readmorealign"] == 2 ? 'center' : 'left';
								$cis_css .= 'text-align: '.$cis_ta.';';
								$cis_css .= '}';
								$cis_css .= '.cis_row_item_overlay_txt {';
								$cis_css .= $slider_textshadow_rule;
								$cis_css .= 'font-size: '.$slider_parent_options["overlayfontsize"].'px;';
								$cis_css .= 'color: '.$slider_parent_options["textcolor"].';';
								$cis_css .= 'margin: '.$slider_parent_options["captionmargin"].';';
								$cis_text_align = $slider_parent_options["captionalign"] == 0 ? 'left' : ($slider_parent_options["captionalign"] == 1 ? 'right' : 'center');
								$cis_css .= 'text-align: '.$cis_text_align.';';
								$cis_css .= '}';
								$cis_css .= '.creative_btn {';
								$cis_css .= 'margin: '.$slider_parent_options["readmoremargin"].' !important;';
								$cis_float = $slider_parent_options["readmorealign"] == 0 ? 'left' : ($slider_parent_options["readmorealign"] == 1 ? 'right' : 'none');
								$cis_css .= 'float: '.$cis_float.';';
								$cis_css .= '}';
								$cis_css .= '.cis_main_wrapper {';
								$cis_css .= 'padding: '.$slider_parent_options["paddingtop"].'px 0px '.$slider_parent_options["paddingbottom"].'px 0px;';
								$cis_css .= 'background-color: '.$slider_parent_options["bgcolor"].';';
								$cis_css .= 'text-align: center;';
								$cis_css .= '}';
								
								//get txt text shadow;
								if($slider_parent_options["textshadowsize"] == 0)
									$slider_textshadow_rule = 'text-shadow: none !important;';
								elseif($slider_parent_options["textshadowsize"] == 1)
									$slider_textshadow_rule = 'text-shadow: -1px 2px 0px '.$slider_parent_options["textshadowcolor"].' !important;';
								elseif($slider_parent_options["textshadowsize"] == 2)
									$slider_textshadow_rule = 'text-shadow: -1px 2px 2px '.$slider_parent_options["textshadowcolor"].' !important;';
								elseif($slider_parent_options["textshadowsize"] == 3)
									$slider_textshadow_rule = 'text-shadow: -1px 2px 4px '.$slider_parent_options["textshadowcolor"].' !important;';
								
								//global !important css
								$cis_css .= '.cis_row_item_overlay_important {';
								$cis_css .= 'background-color: '.$slider_parent_options["overlaycolor"].' !important;';
								$cis_css .= 'background-color: '.$slider_overlaycolor_rgba.' !important;';
								$cis_ta = $slider_parent_options["readmorealign"] == 2 ? 'center' : 'left';
								$cis_css .= 'text-align: '.$cis_ta.' !important;';
								$cis_css .= '}';
								$cis_css .= '.cis_row_item_overlay_txt_important {';
								$cis_css .= $slider_textshadow_rule;
								$cis_css .= 'font-size: '.$slider_parent_options["overlayfontsize"].'px !important;';
								$cis_css .= 'color: '.$slider_parent_options["textcolor"].' !important;';
								$cis_css .= 'margin: '.$slider_parent_options["captionmargin"].' !important;';
								$cis_text_align = $slider_parent_options["captionalign"] == 0 ? 'left' : ($slider_parent_options["captionalign"] == 1 ? 'right' : 'center');
								$cis_css .= 'text-align: '.$cis_text_align.' !important;';
								$cis_css .= '}';
								$cis_css .= '.creative_btn_important {';
								$cis_css .= 'margin: '.$slider_parent_options["readmoremargin"].' !important;';
								$cis_float = $slider_parent_options["readmorealign"] == 0 ? 'left' : ($slider_parent_options["readmorealign"] == 1 ? 'right' : 'none');
								$cis_css .= 'float: '.$cis_float.' !important;';
								$cis_css .= '}';
								
								//readmore
								$cis_float = $slider_parent_options['readmorealign'] == 0 ? 'left' : ($slider_parent_options['readmorealign'] == 1 ? 'right' : 'none');
								
								$items_css .= '.creative_button_global {';
								$items_css .= 'margin: '.$slider_parent_options["readmoremargin"].' !important;';
								$items_css .= 'float: '.$cis_float.' !important;';
								$items_css .= '}';
								$items_css .= '.creative_button_wrapper_centered {';
								$items_css .= 'text-align: center !important;';
								$items_css .= '}';
								
								echo '<style>'.$cis_css.$items_css.'</style>';
								?>
								
							</div>
						</div>
					</div>
					<?php }
				}?>
<!-- ******************************************************** END SLIDER PREVIEW**************************************************************************************************************************************************************************************************************************************************************************************************** -->
				</td>
			</tr>
		</table>
	</div>
</div>
<input type="hidden" name="task" value="" id="wpcis_task">
<input type="hidden" name="id" value="<?php echo $id;?>" >
</form>
<?php }?>


<style>
.form-horizontal .cis_controls {
margin-left: 200px !important;
}
.cis_row_item_overlay {
	height: auto !important;
}
.cis_button_left, .cis_button_right {
	-webkit-transition:  top linear 0.2s;
	-moz-transition: top linear 0.2s;
	-o-transition: top linear 0.2s;
	transition: top linear 0.2s;
}
</style>