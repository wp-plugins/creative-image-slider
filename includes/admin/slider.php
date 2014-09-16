<?php 
global $wpdb;

if($id != 0) {
	//get the rows
	$sql = "SELECT * FROM ".$wpdb->prefix."cis_sliders WHERE id = '".$id."'";
	$row = $wpdb->get_row($sql);
}

$sql = "SELECT id,name FROM ".$wpdb->prefix."cis_categories";
$c_row = $wpdb->get_results($sql);
$cat_options = array();
if(is_array($c_row))
	foreach($c_row as $arr)
		$cat_options[$arr->id] = $arr->name;


$sql = "SELECT COUNT(id) FROM ".$wpdb->prefix."cis_sliders";
$count_sliders = $wpdb->get_var($sql);
if($id == 0 && $count_sliders >= 1) {
	?>
	<div style="color: rgb(235, 9, 9);font-size: 16px;font-weight: bold;">Please Upgrade to Comercial Version to have more than one Creative Slider!</div>
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
$slider_global_options["readmoretext"] = 'View Image';
$slider_global_options["readmorestyle"] = 'blue';
$slider_global_options["readmoreicon"] = 'picture';
$slider_global_options["readmoresize"] = 'mini';
$slider_global_options["overlaycolor"] = '#000000';
$slider_global_options["overlayopacity"] = 50;
$slider_global_options["textcolor"] = '#ffffff';
$slider_global_options["overlayfontsize"] = 17;
$slider_global_options["textshadowcolor"] = '#000000';
$slider_global_options["textshadowsize"] = 2;
$slider_global_options["readmorealign"] = 1;
$slider_global_options["captionalign"] = 0;
$slider_global_options["readmoremargin"] = '0px 15px 10px 10px';
$slider_global_options["captionmargin"] = '10px 15px 10px 15px';

//slider options
$slider_global_options["height"] = 250;
$slider_global_options["itemsoffset"] = 2;
$slider_global_options["margintop"] = 0;
$slider_global_options["marginbottom"] = 0;
$slider_global_options["paddingtop"] = 2;
$slider_global_options["paddingbottom"] = 2;

$slider_global_options["showarrows"] = 1;//on hover
$slider_global_options["arrow_template"] = 26;
$slider_global_options["arrow_width"] = 28;
$slider_global_options["arrow_left_offset"] = 15;
$slider_global_options["arrow_center_offset"] = 0;
$slider_global_options["arrow_passive_opacity"] = 50;

$slider_global_options["move_step"] = 600;
$slider_global_options["move_time"] = 600;
$slider_global_options["move_ease"] = 60;
$slider_global_options["autoplay"] = 1;
$slider_global_options["autoplay_start_timeout"] = 5000;
$slider_global_options["autoplay_hover_timeout"] = 2000;
$slider_global_options["autoplay_step_timeout"] = 1000;
$slider_global_options["autoplay_evenly_speed"] = 25;

$slider_global_options["overlayanimationtype"] = 0;
$slider_global_options["popup_max_size"] = 90;
$slider_global_options["popup_item_min_width"] = 300;
$slider_global_options["popup_use_back_img"] = 1;
$slider_global_options["popup_arrow_passive_opacity"] = 50;
$slider_global_options["popup_arrow_left_offset"] = 12;
$slider_global_options["popup_arrow_min_height"] = 25;
$slider_global_options["popup_arrow_max_height"] = 50;
$slider_global_options["popup_showarrows"] = 1;
$slider_global_options["popup_image_order_opacity"] = 70;
$slider_global_options["popup_image_order_top_offset"] = 12;
$slider_global_options["popup_show_orderdata"] = 1;
$slider_global_options["popup_icons_opacity"] = 50;
$slider_global_options["popup_show_icons"] = 1;
$slider_global_options["popup_autoplay_default"] = 1;
$slider_global_options["popup_closeonend"] = 1;
$slider_global_options["popup_autoplay_time"] = 5000;
$slider_global_options["popup_open_event"] = 0;
?>
<!-- ********************************************************************JACASCRIPT ************************************************************************************* -->

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
	    
	    var select19 = $( "#cis_itemsoffset" );
	    var place19 = select19.parent('div').find('.cis_slider_insert_here');
	    var slider19 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place19 ).slider({
	      min: 1,
	      max: 41,
	      range: "min",
	      value: select19[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select19[ 0 ].selectedIndex = ui.value - 1;
	        select19.trigger("change");
	      }
	    });
	    $( "#cis_itemsoffset" ).change(function() {
	    	slider19.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select20 = $( "#cis_margintop" );
	    var place20 = select20.parent('div').find('.cis_slider_insert_here');
	    var slider20 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place20 ).slider({
	      min: 1,
	      max: 41,
	      range: "min",
	      value: select20[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select20[ 0 ].selectedIndex = ui.value - 1;
	        select20.trigger("change");
	      }
	    });
	    $( "#cis_margintop" ).change(function() {
	    	slider20.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select21 = $( "#cis_marginbottom" );
	    var place21 = select21.parent('div').find('.cis_slider_insert_here');
	    var slider21 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place21 ).slider({
	      min: 1,
	      max: 41,
	      range: "min",
	      value: select21[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select21[ 0 ].selectedIndex = ui.value - 1;
	        select21.trigger("change");
	      }
	    });
	    $( "#cis_marginbottom" ).change(function() {
	    	slider21.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select22 = $( "#cis_paddingtop" );
	    var place22 = select22.parent('div').find('.cis_slider_insert_here');
	    var slider22 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place22 ).slider({
	      min: 1,
	      max: 41,
	      range: "min",
	      value: select22[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select22[ 0 ].selectedIndex = ui.value - 1;
	        select22.trigger("change");
	      }
	    });
	    $( "#cis_paddingtop" ).change(function() {
	    	slider22.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select23 = $( "#cis_paddingbottom" );
	    var place23 = select23.parent('div').find('.cis_slider_insert_here');
	    var slider23 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place23 ).slider({
	      min: 1,
	      max: 41,
	      range: "min",
	      value: select23[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select23[ 0 ].selectedIndex = ui.value - 1;
	        select23.trigger("change");
	      }
	    });
	    $( "#cis_paddingbottom" ).change(function() {
	    	slider23.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select24 = $( "#cis_showarrows" );
	    var place24 = select24.parent('div').find('.cis_slider_insert_here');
	    var slider24 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place24 ).slider({
	      min: 1,
	      max: 3,
	      range: "min",
	      value: select24[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select24[ 0 ].selectedIndex = ui.value - 1;
	        select24.trigger("change");
	      }
	    });
	    $( "#cis_showarrows" ).change(function() {
	    	slider24.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select25 = $( "#cis_height" );
	    var place25 = select25.parent('div').find('.cis_slider_insert_here');
	    var slider25 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place25 ).slider({
	      min: 1,
	      max: 651,
	      range: "min",
	      value: select25[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select25[ 0 ].selectedIndex = ui.value - 1;
	        select25.trigger("change");
	      }
	    });
	    $( "#cis_height" ).change(function() {
	    	slider25.slider( "value", this.selectedIndex + 1 );
	    });


	    var select26 = $( "#cis_arrow_template" );
	    var place26 = select26.parent('div').find('.cis_slider_insert_here');
	    var slider26 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place26 ).slider({
	      min: 1,
	      max: 45,
	      range: "min",
	      value: select26[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select26[ 0 ].selectedIndex = ui.value - 1;
	        select26.trigger("change");
	      }
	    });
	    $( "#cis_arrow_template" ).change(function() {
	    	slider26.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select27 = $( "#cis_arrow_width" );
	    var place27 = select27.parent('div').find('.cis_slider_insert_here');
	    var slider27 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place27 ).slider({
	      min: 1,
	      max: 53,
	      range: "min",
	      value: select27[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select27[ 0 ].selectedIndex = ui.value - 1;
	        select27.trigger("change");
	      }
	    });
	    $( "#cis_arrow_width" ).change(function() {
	    	slider27.slider( "value", this.selectedIndex + 1 );
	    });
		
		
	    var select28 = $( "#cis_arrow_left_offset" );
	    var place28 = select28.parent('div').find('.cis_slider_insert_here');
	    var slider28 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place28 ).slider({
	      min: 1,
	      max: 101,
	      range: "min",
	      value: select28[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select28[ 0 ].selectedIndex = ui.value - 1;
	        select28.trigger("change");
	      }
	    });
	    $( "#cis_arrow_left_offset" ).change(function() {
	    	slider28.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select29 = $( "#cis_arrow_center_offset" );
	    var place29 = select29.parent('div').find('.cis_slider_insert_here');
	    var slider29 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place29 ).slider({
	      min: 1,
	      max: 501,
	      range: "min",
	      value: select29[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select29[ 0 ].selectedIndex = ui.value - 1;
	        select29.trigger("change");
	      }
	    });
	    $( "#cis_arrow_center_offset" ).change(function() {
	    	slider29.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select30 = $( "#cis_arrow_passive_opacity" );
	    var place30 = select30.parent('div').find('.cis_slider_insert_here');
	    var slider30 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place30 ).slider({
	      min: 1,
	      max: 21,
	      range: "min",
	      value: select30[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select30[ 0 ].selectedIndex = ui.value - 1;
	        select30.trigger("change");
	      }
	    });
	    $( "#cis_arrow_passive_opacity" ).change(function() {
	    	slider30.slider( "value", this.selectedIndex + 1 );
	    });









	    var select31 = $( "#cis_popup_max_size" );
	    var place31 = select31.parent('div').find('.cis_slider_insert_here');
	    var slider31 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place31 ).slider({
	      min: 1,
	      max: 15,
	      range: "min",
	      value: select31[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select31[ 0 ].selectedIndex = ui.value - 1;
	        select31.trigger("change");
	      }
	    });
	    $( "#cis_popup_max_size" ).change(function() {
	    	slider31.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select32 = $( "#cis_popup_item_min_width" );
	    var place32 = select32.parent('div').find('.cis_slider_insert_here');
	    var slider32 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place32 ).slider({
	      min: 1,
	      max: 41,
	      range: "min",
	      value: select32[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select32[ 0 ].selectedIndex = ui.value - 1;
	        select32.trigger("change");
	      }
	    });
	    $( "#cis_popup_item_min_width" ).change(function() {
	    	slider32.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select33 = $( "#cis_popup_arrow_passive_opacity" );
	    var place33 = select33.parent('div').find('.cis_slider_insert_here');
	    var slider33 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place33 ).slider({
	      min: 1,
	      max: 21,
	      range: "min",
	      value: select33[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select33[ 0 ].selectedIndex = ui.value - 1;
	        select33.trigger("change");
	      }
	    });
	    $( "#cis_popup_arrow_passive_opacity" ).change(function() {
	    	slider33.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select34 = $( "#cis_popup_arrow_left_offset" );
	    var place34 = select34.parent('div').find('.cis_slider_insert_here');
	    var slider34 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place34 ).slider({
	      min: 1,
	      max: 101,
	      range: "min",
	      value: select34[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select34[ 0 ].selectedIndex = ui.value - 1;
	        select34.trigger("change");
	      }
	    });
	    $( "#cis_popup_arrow_left_offset" ).change(function() {
	    	slider34.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select35 = $( "#cis_popup_arrow_min_height" );
	    var place35 = select35.parent('div').find('.cis_slider_insert_here');
	    var slider35 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place35 ).slider({
	      min: 1,
	      max: 21,
	      range: "min",
	      value: select35[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select35[ 0 ].selectedIndex = ui.value - 1;
	        select35.trigger("change");
	      }
	    });
	    $( "#cis_popup_arrow_min_height" ).change(function() {
	    	slider35.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select36 = $( "#cis_popup_arrow_max_height" );
	    var place36 = select36.parent('div').find('.cis_slider_insert_here');
	    var slider36 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place36 ).slider({
	      min: 1,
	      max: 35,
	      range: "min",
	      value: select36[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select36[ 0 ].selectedIndex = ui.value - 1;
	        select36.trigger("change");
	      }
	    });
	    $( "#cis_popup_arrow_max_height" ).change(function() {
	    	slider36.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select37 = $( "#cis_popup_showarrows" );
	    var place37 = select37.parent('div').find('.cis_slider_insert_here');
	    var slider37 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place37 ).slider({
	      min: 1,
	      max: 3,
	      range: "min",
	      value: select37[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select37[ 0 ].selectedIndex = ui.value - 1;
	        select37.trigger("change");
	      }
	    });
	    $( "#cis_popup_showarrows" ).change(function() {
	    	slider37.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select38 = $( "#cis_popup_image_order_opacity" );
	    var place38 = select38.parent('div').find('.cis_slider_insert_here');
	    var slider38 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place38 ).slider({
	      min: 1,
	      max: 21,
	      range: "min",
	      value: select38[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select38[ 0 ].selectedIndex = ui.value - 1;
	        select38.trigger("change");
	      }
	    });
	    $( "#cis_popup_image_order_opacity" ).change(function() {
	    	slider38.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select39 = $( "#cis_popup_image_order_top_offset" );
	    var place39 = select39.parent('div').find('.cis_slider_insert_here');
	    var slider39 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place39 ).slider({
	      min: 1,
	      max: 101,
	      range: "min",
	      value: select39[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select39[ 0 ].selectedIndex = ui.value - 1;
	        select39.trigger("change");
	      }
	    });
	    $( "#cis_popup_image_order_top_offset" ).change(function() {
	    	slider39.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select40 = $( "#cis_popup_show_orderdata" );
	    var place40 = select40.parent('div').find('.cis_slider_insert_here');
	    var slider40 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place40 ).slider({
	      min: 1,
	      max: 3,
	      range: "min",
	      value: select40[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select40[ 0 ].selectedIndex = ui.value - 1;
	        select40.trigger("change");
	      }
	    });
	    $( "#cis_popup_show_orderdata" ).change(function() {
	    	slider40.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select41 = $( "#cis_popup_icons_opacity" );
	    var place41 = select41.parent('div').find('.cis_slider_insert_here');
	    var slider41 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place41 ).slider({
	      min: 1,
	      max: 21,
	      range: "min",
	      value: select41[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select41[ 0 ].selectedIndex = ui.value - 1;
	        select41.trigger("change");
	      }
	    });
	    $( "#cis_popup_icons_opacity" ).change(function() {
	    	slider41.slider( "value", this.selectedIndex + 1 );
	    });
		
	    var select42 = $( "#cis_popup_show_icons" );
	    var place42 = select42.parent('div').find('.cis_slider_insert_here');
	    var slider42 = $( "<div id='cis_overlayopacity_slider' class='cis_options_slider'></div>" ).insertAfter( place42 ).slider({
	      min: 1,
	      max: 3,
	      range: "min",
	      value: select42[ 0 ].selectedIndex + 1,
	      slide: function( event, ui ) {
	        select42[ 0 ].selectedIndex = ui.value - 1;
	        select42.trigger("change");
	      }
	    });
	    $( "#cis_popup_show_icons" ).change(function() {
	    	slider42.slider( "value", this.selectedIndex + 1 );
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
				cis_make_slider_css();

				//$("#ssw_template_wrapper").css('background-color','#' + hex);
			}
		});

		//preview//////////////////////////////////////////////////////////////////////////
		function cis_update_overlay_txt() {
			var $cis_element = $(".cis_row_item_overlay_txt").not('.cis_preset');

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
			var $cis_element = $(".cis_row_item_overlay").not('.cis_preset');

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
			var $targetElement = $(".creative_btn").not('.cis_preset');
			if(v == 0) {
				$targetElement.hide();
			}
			else {
				$targetElement.show().css('display','inline-block');
			}
		});

		$("#cis_readmoretext").keyup(function() {
			var v = $(this).val();
			$(".creative_btn").not('.cis_preset').find(".cis_creative_btn_txt").html(v);
		});

		function cis_make_creative_button() {
			var $cis_element = $(".creative_btn").not('.cis_preset');

			//generate css
			var margin = $("#cis_readmoremargin").val();
			var float = parseInt($("#cis_readmorealign").val()) == 0 ? 'left' : (parseInt($("#cis_readmorealign").val()) == 1 ? 'right' : 'none');
			var button_style_class = 'creative_btn-' + $("#cis_readmorestyle").val();
			var button_size_class = 'creative_btn-' + $("#cis_readmoresize").val();
			
			$cis_element.attr("class","creative_btn " + button_style_class + " " + button_size_class);

			//icon
			var cis_icon = $("#cis_readmoreicon").val() == 'none' ? '' : '<i class="creative_icon-white creative_icon-' + $("#cis_readmoreicon").val() + '"></i> ';
			$(".creative_btn").not('.cis_preset').find(".cis_creative_btn_icon").html(cis_icon);

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

		//////////////////////////////////////////////////////////////////slider main preview
		$("#cis_margintop").change(function() {
			cis_make_slider_css();
		});
		$("#cis_marginbottom").change(function() {
			cis_make_slider_css();
		});
		$("#cis_paddingtop").change(function() {
			cis_make_slider_css();
		});
		$("#cis_paddingbottom").change(function() {
			cis_make_slider_css();
		});
		$("#cis_itemsoffset").change(function() {
			cis_make_slider_css();
		});
		$("#cis_height").change(function() {
			cis_make_slider_css();
			cis_make_arrows_css();
		});
		$("#cis_width").blur(function() {
			cis_make_slider_css();
		});

		function cis_make_slider_css() {
			var $cis_element = $(".cis_main_wrapper");

			//get css
			var margintop = parseInt($("#cis_margintop").val());
			var marginbottom = parseInt($("#cis_marginbottom").val());
			var paddingtop = parseInt($("#cis_paddingtop").val());
			var paddingbottom = parseInt($("#cis_paddingbottom").val());
			var itemsoffset = parseInt($("#cis_itemsoffset").val());
			var itemsheight = parseInt($("#cis_height").val());
			var backgroundcolor = $("#cis_bgcolor").val();
			var width = $("#cis_width").val();

			//set big width
			$('.cis_images_holder').css('width','9999999px');

			//apply css
			$cis_element.css({
				'width' : width,
				'margin-top' : margintop,
				'margin-bottom' : marginbottom,
				'padding-top' : paddingtop,
				'padding-bottom' : paddingbottom,
				'background-color' : backgroundcolor
			}).find('.cis_row_item').css({
				'margin-right' : itemsoffset
			}).find('img').css({
				'height' : itemsheight
			});

			cis_calculate_backend_width();
		};

		function cis_calculate_backend_width() {
			$('.cis_images_holder').each(function() {
				var $wrapper = $(this);
				var total_w = 0;
				$wrapper.find('.cis_row_item').each(function() {
					$(this).find('img').css('width','auto');
					var w = parseInt($(this).find('img').width());
					$(this).find('img').width(w);
					var m_r = isNaN(parseFloat($(this).css('margin-right'))) ? 0 : parseFloat($(this).css('margin-right'));
					var m_l = isNaN(parseFloat($(this).css('margin-left'))) ? 0 : parseFloat($(this).css('margin-left'));
					total_w += w + m_r*1 + m_l*1;
				});
				$wrapper.width(total_w);
			});
		};

		//arrows
		function cis_make_arrows_css() {
			var $cis_element = $(".cis_main_wrapper");

			var $left_arrow = $cis_element.find('.cis_button_left');
			var $right_arrow = $cis_element.find('.cis_button_right');


			//get arrows data
			var arrow_width = $("#cis_arrow_width").val();
			var arrow_corner_offset = $("#cis_arrow_left_offset").val();
			var arrow_middle_offset = $("#cis_arrow_center_offset").val();
			var arrow_opacity = $("#cis_arrow_passive_opacity").val() / 100;
			var show_arrows = $("#cis_showarrows").val();

			if(show_arrows == 0) {
				$left_arrow.hide();
				$right_arrow.hide();
				return;
			}
			else {
				$left_arrow.show();
				$right_arrow.show();
			}

			//set images
			var plg_url = '<?php echo plugin_dir_url( __FILE__ );?>';
			var img_src1 = plg_url + '../assets/images/arrows/cis_button_left' + $("#cis_arrow_template").val() + '.png';
			var img_src2 = plg_url + '../assets/images/arrows/cis_button_right' + $("#cis_arrow_template").val() + '.png';

			$left_arrow.attr("src",img_src1);
			$right_arrow.attr("src",img_src2)

			//set data
			$left_arrow.attr("op",arrow_opacity);
			$left_arrow.attr("corner_offset",arrow_corner_offset);
			$right_arrow.attr("op",arrow_opacity);
			$right_arrow.attr("corner_offset",arrow_corner_offset);
			
			//set styles
			$left_arrow.css('width',arrow_width);
			$right_arrow.css('width',arrow_width);

			setTimeout(function() {
				var arrow_height = parseInt ($left_arrow.height());
				var wrapper_height = parseFloat ($cis_element.height());
				var p_t = isNaN(parseFloat($cis_element.css('padding-top'))) ? 0 : parseFloat($cis_element.css('padding-top'));
				var p_b = isNaN(parseFloat($cis_element.css('padding-bottom'))) ? 0 : parseFloat($cis_element.css('padding-bottom'));
				var arrow_top_position = ((wrapper_height + 1 * p_t + 1 * p_b - arrow_height) / 2 ) + 1 * arrow_middle_offset;

				var c_off = arrow_corner_offset + 'px';
				$left_arrow.css({
					'top': arrow_top_position,
					'left': c_off,
					'opacity': arrow_opacity
				});
				$right_arrow.css({
					'top': arrow_top_position,
					'right': c_off,
					'opacity': arrow_opacity
				});
			},200);
			
		};

		$("#cis_arrow_template").change(function() {
			cis_make_arrows_css();
		});
		$("#cis_arrow_width").change(function() {
			cis_make_arrows_css();
		});
		$("#cis_arrow_left_offset").change(function() {
			cis_make_arrows_css();
		});
		$("#cis_arrow_center_offset").change(function() {
			cis_make_arrows_css();
		});
		$("#cis_arrow_passive_opacity").change(function() {
			cis_make_arrows_css();
		});
		$("#cis_showarrows").change(function() {
			cis_make_arrows_css();
		});
		
	})
})(jQuery);
</script>

<form action="admin.php?page=cis_sliders&act=cis_submit_data&holder=sliders" method="post" id="wpcis_form">
<div style="overflow: hidden;margin: 0 0 10px 0;">
	<div style="float:right;">
		<button  id="wpcis_form_save" class="button-primary">Save</button>
		<button id="wpcis_form_save_close" class="button">Save & Close</button>
		<button id="wpcis_form_save_new" class="button">Save & New</button>
		<a href="admin.php?page=cis_sliders" id="wpcis_add" class="button"><?php echo $t = $id == 0 ? 'Cancel' : 'Close';?></a>
	</div>
</div>
<div id="c_div">
	<div>
		<table cellpadding="0" cellspacing="0" style="width: 100%;">
			<tr>
				<td style="width: 420px;vertical-align: top;" align="top">

<!-- ********************************************************FORM OPTIONS**************************************************************************************************************************************************************************************************************************************************************************************************** -->

					<div style="clear: both;margin: 0px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary['COM_CREATIVEIMAGESLIDER_MAIN_OPTIONS_LABEL'];?></div>

					<div class="cis_control_label"><label id="" for="cis_name" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_NAME_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_NAME_LABEL' ];?><!-- <span class="star">&nbsp;*</span> --></label></div>
					<div class="cis_controls"><input type="text" name="name" id="cis_name" value="<?php echo $v = $id == 0 ? '' : $row->name;?>" class="inputbox required" size="40" =""  ></div>

					<div style="clear: both;height: 5px;"></div>
					<div class="cis_control_label"><label id="" for="cis_id_category" class="hasTooltip" title="<?php echo $slider_dictionary['COM_CREATIVEIMAGESLIDER_CATEGORY_DESCRIPTION'];?>" ><?php echo $slider_dictionary['COM_CREATIVEIMAGESLIDER_CATEGORY_LABEL'];?></label></div>
					<div class="cis_controls">
							<?php 
							$default = $id == 0 ? 1 : $row->id_category;
							//$opts = array(1 => 'Published', 0 => 'Unpublished');
							$opts = $cat_options;
							$options = array();
							echo '<select id="cis_id_category" class="" name="id_category">';
							foreach($opts as $key=>$value) :
								$selected = $key == $default ? 'selected="selected"' : '';
								echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
							endforeach;
							echo '</select>';
							?>
					</div>

					<div style="clear: both;height: 5px;"></div>
					<div class="cis_control_label"><label id="" for="cis_status" class="hasTooltip" title="<?php echo $slider_dictionary['COM_CREATIVEIMAGESLIDER_STATUS_DESCRIPTION'];?>" ><?php echo $slider_dictionary['COM_CREATIVEIMAGESLIDER_STATUS_LABEL'];?></label></div>
					<div class="cis_controls">
							<?php 
							$default = $id == 0 ? 1 : $row->published;
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

					<div style="clear: both;margin: 15px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_SLIDER_OPTIONS_LABEL' ];?></div>
							
							<div class="cis_control_label"><label id="" for="cis_width" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_WIDTH_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_WIDTH_LABEL' ];?></label></div>
							<div class="cis_controls"><input type="text" name="width" id="cis_width" value="<?php echo $v = $id == 0 ? '100%' : $row->width;?>" class="inputbox required" size="40" =""  ></div>
						
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_height" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_HEIGHT_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_HEIGHT_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['height'] : $row->height;
									echo '<select id="cis_height" class="cis_has_slider" name="height">';
									for($k = 50; $k <= 700; $k ++) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>

							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_open_event" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_OPENEVENT_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_OPENEVENT_LABEL' ];?></label></div>
							<div class="cis_controls">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_open_event'] : $row->popup_open_event;
									$opts = array(0 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_OPENEVENT_BUTTON'], 1 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_OPENEVENT_OVERLAY'], 2 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_OPENEVENT_LINK'], 3 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_OPENEVENT_NONE']);
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
							<div class="cis_control_label"><label style="margin-top: 4px;" id="" for="cis_bgcolor" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_BGCOLOR_LABEL' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_BGCOLOR_DESCRIPTION' ];?></label></div>
							<div class="cis_controls">
								<div id="colorSelector" class="colorSelector" style="float: left;"><div style="background-color: <?php echo $v = $id == 0 ? '#000000' : $row->bgcolor;?>"></div></div>
               					<input class="colorSelector" type="text" value="<?php echo $v = $id == 0 ? '#000000' : $row->bgcolor;?>" name="bgcolor" roll=""  id="cis_bgcolor" style="width: 162px;margin: 4px 0 0 6px;" />
							</div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_itemsoffset" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_ITEMSOFFSET_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_ITEMSOFFSET_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['itemsoffset'] : $row->itemsoffset;
									$opts = array(0 => '0px', 1 => '1px', 2 => '2px', 3 => '3px', 4 => '4px', 5 => '5px', 6 => '6px', 7 => '7px', 8 => '8px', 9 => '9px', 10 => '10px', 11 => '11px', 12 => '12px', 13 => '13px', 14 => '14px', 15 => '15px', 16 => '16px', 17 => '17px', 18 => '18px', 19 => '19px', 20 => '20px');
									$options = array();
									echo '<select id="cis_itemsoffset" class="cis_has_slider" name="itemsoffset">';
									for($k = 0; $k <= 40; $k ++) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_margintop" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_MARGINTOP_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_MARGINTOP_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['margintop'] : $row->margintop;
									$opts = array(0 => '0px', 1 => '1px', 2 => '2px', 3 => '3px', 4 => '4px', 5 => '5px', 6 => '6px', 7 => '7px', 8 => '8px', 9 => '9px', 10 => '10px', 11 => '11px', 12 => '12px', 13 => '13px', 14 => '14px', 15 => '15px', 16 => '16px', 17 => '17px', 18 => '18px', 19 => '19px', 20 => '20px');
									$options = array();
									echo '<select id="cis_margintop" class="cis_has_slider" name="margintop">';
									for($k = 0; $k <= 40; $k ++) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_marginbottom" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_MARGINBOTTOM_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_MARGINBOTTOM_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['marginbottom'] : $row->marginbottom;
									$opts = array(0 => '0px', 1 => '1px', 2 => '2px', 3 => '3px', 4 => '4px', 5 => '5px', 6 => '6px', 7 => '7px', 8 => '8px', 9 => '9px', 10 => '10px', 11 => '11px', 12 => '12px', 13 => '13px', 14 => '14px', 15 => '15px', 16 => '16px', 17 => '17px', 18 => '18px', 19 => '19px', 20 => '20px');
									$options = array();
									echo '<select id="cis_marginbottom" class="cis_has_slider" name="marginbottom">';
									for($k = 0; $k <= 40; $k ++) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_paddingtop" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_PADDINGTOP_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_PADDINGTOP_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['paddingtop'] : $row->paddingtop;
									$opts = array(0 => '0px', 1 => '1px', 2 => '2px', 3 => '3px', 4 => '4px', 5 => '5px', 6 => '6px', 7 => '7px', 8 => '8px', 9 => '9px', 10 => '10px', 11 => '11px', 12 => '12px', 13 => '13px', 14 => '14px', 15 => '15px', 16 => '16px', 17 => '17px', 18 => '18px', 19 => '19px', 20 => '20px');
									$options = array();
									echo '<select id="cis_paddingtop" class="cis_has_slider" name="paddingtop">';
									for($k = 0; $k <= 40; $k ++) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_paddingbottom" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_PADDINGBOTTOM_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_PADDINGBOTTOM_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['paddingbottom'] : $row->paddingbottom;
									$opts = array(0 => '0px', 1 => '1px', 2 => '2px', 3 => '3px', 4 => '4px', 5 => '5px', 6 => '6px', 7 => '7px', 8 => '8px', 9 => '9px', 10 => '10px', 11 => '11px', 12 => '12px', 13 => '13px', 14 => '14px', 15 => '15px', 16 => '16px', 17 => '17px', 18 => '18px', 19 => '19px', 20 => '20px');
									$options = array();
									echo '<select id="cis_paddingbottom" class="cis_has_slider" name="paddingbottom">';
									for($k = 0; $k <= 40; $k ++) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>
							
							<div style="clear: both;margin: 15px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_ARROW_OPTIONS_LABEL' ];?></div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_arrow_template" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_ARROW_TEMPLATE_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_ARROW_TEMPLATE_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['arrow_template'] : $row->arrow_template;
									echo '<select id="cis_arrow_template" class="cis_has_slider" name="arrow_template">';
									for($k = 1; $k <= 45; $k ++) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">Tmp-'.$k.'</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_arrow_width" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_ARROW_WIDTH_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_ARROW_WIDTH_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['arrow_width'] : $row->arrow_width;
									echo '<select id="cis_arrow_width" class="cis_has_slider" name="arrow_width">';
									for($k = 12; $k <= 64; $k ++) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_arrow_left_offset" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_ARROW_LEFT_OFFSET_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_ARROW_LEFT_OFFSET_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['arrow_left_offset'] : $row->arrow_left_offset;
									echo '<select id="cis_arrow_left_offset" class="cis_has_slider" name="arrow_left_offset">';
									for($k = 0; $k <= 100; $k ++) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_arrow_center_offset" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_ARROW_CENTER_OFFSET_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_ARROW_CENTER_OFFSET_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['arrow_center_offset'] : $row->arrow_center_offset;
									echo '<select id="cis_arrow_center_offset" class="cis_has_slider" name="arrow_center_offset">';
									for($k = -250; $k <= 250; $k ++) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_arrow_passive_opacity" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_ARROW_PASSIVE_OPACITY_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_ARROW_PASSIVE_OPACITY_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['arrow_passive_opacity'] : $row->arrow_passive_opacity;
									echo '<select id="cis_arrow_passive_opacity" class="cis_has_slider" name="arrow_passive_opacity">';
									for($k = 0; $k <= 100; $k += 5) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'%</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>
							
							
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_showarrows" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_SHOWARROWS_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_SHOWARROWS_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['showarrows'] : $row->showarrows;
									$opts = array(0 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_SHOWARROWS_NEVER'], 1 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_SHOWARROWS_ONHOVER'], 2 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_SHOWARROWS_ALWAYS']);
									$options = array();
									echo '<select id="cis_showarrows" class="cis_has_slider" name="showarrows">';
									foreach($opts as $key=>$value) :
										$selected = $key == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
									endforeach;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>
							
							<div style="clear: both;margin: 15px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAY_OPTIONS_LABEL' ];?></div>
							
							<!-- TODO -->
							<div class="cis_control_label"><label id="" for="cis_overlayanimationtype" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYANIMTYPE_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYANIMTYPE_LABEL' ];?></label></div>
							<div class="cis_controls">
									<?php 
									$default = $id == 0 ? $slider_global_options['overlayanimationtype'] : $row->overlayanimationtype;
									$opts = array(0 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_SLIDE_UP'], 1 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_KEEP_VISIBLE'], 2 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_SPECIAL']);
									$options = array();
									echo '<select id="cis_overlayanimationtype" class="" name="overlayanimationtype">';
									foreach($opts as $key=>$value) :
										$selected = $key == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
									endforeach;
									echo '</select>';
									?>
							</div>

							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label  style="margin-top: 4px;" id="" for="cis_overlaycolor" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYCOLOR_LABEL' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYCOLOR_DESCRIPTION' ];?></label></div>
							<div class="cis_controls">
								<div id="colorSelector" class="colorSelector" style="float: left;"><div style="background-color: <?php echo $v = $id == 0 ? $slider_global_options['overlaycolor'] : $row->overlaycolor;?>"></div></div>
               					<input class="colorSelector" type="text" value="<?php echo $v = $id == 0 ? $slider_global_options['overlaycolor'] : $row->overlaycolor;?>" name="overlaycolor" roll=""  id="cis_overlaycolor" style="width: 162px;margin: 4px 0 0 6px;" />
							</div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_overlayopacity" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYOPACITY_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYOPACITY_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['overlayopacity'] : $row->overlayopacity;
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
									$default = $id == 0 ? $slider_global_options['captionalign'] : $row->captionalign;
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
							<div class="cis_controls"><input type="text" name="captionmargin" id="cis_captionmargin" value="<?php echo $v = $id == 0 ? $slider_global_options['captionmargin'] : $row->captionmargin;?>" class="inputbox" size="40" ="" ></div>
						
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label  style="margin-top: 4px;" id="" for="cis_textcolor" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_TEXTCOLOR_LABEL' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_TEXTCOLOR_DESCRIPTION' ];?></label></div>
							<div class="cis_controls">
								<div id="colorSelector" class="colorSelector" style="float: left;"><div style="background-color: <?php echo $v = $id == 0 ? $slider_global_options['textcolor'] : $row->textcolor;?>"></div></div>
               					<input class="colorSelector" type="text" value="<?php echo $v = $id == 0 ? $slider_global_options['textcolor'] : $row->textcolor;?>" name="textcolor" roll=""  id="cis_textcolor" style="width: 162px;margin: 4px 0 0 6px;" />
							</div>
									
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label  style="margin-top: 4px;" id="" for="cis_textshadowcolor" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_TEXTSHAOWCOLOR_LABEL' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_TEXTSHAOWCOLOR_DESCRIPTION' ];?></label></div>
							<div class="cis_controls">
								<div id="colorSelector" class="colorSelector" style="float: left;"><div style="background-color: <?php echo $v = $id == 0 ? $slider_global_options['textshadowcolor'] : $row->textshadowcolor;?>"></div></div>
               					<input class="colorSelector" type="text" value="<?php echo $v = $id == 0 ? $slider_global_options['textshadowcolor'] : $row->textshadowcolor;?>" name="textshadowcolor" roll=""  id="cis_textshadowcolor" style="width: 162px;margin: 4px 0 0 6px;" />
							</div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_overlayfontsize" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYFONTSIZE_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_OVERLAYFONTSIZE_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['overlayfontsize'] : $row->overlayfontsize;
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
									$default = $id == 0 ? $slider_global_options['textshadowsize'] : $row->textshadowsize;
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
							
							<div style="clear: both;margin: 15px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_BUTTON_OPTIONS_LABEL' ];?></div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_showreadmore" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_SHOWREADMORE_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_SHOWREADMORE_LABEL' ];?></label></div>
							<div class="cis_controls">
									<?php 
									$default = $id == 0 ? $slider_global_options['showreadmore'] : $row->showreadmore;
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
							<div class="cis_control_label"><label id="" for="cis_readmoretext" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMORETEXT_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMORETEXT_LABEL' ];?></label></div>
							<div class="cis_controls"><input type="text" name="readmoretext" id="cis_readmoretext" value="<?php echo $v = $id == 0 ? $slider_global_options['readmoretext'] : $row->readmoretext;?>" class="inputbox" size="40" ="" ></div>
						
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_readmoremargin" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMOREMARGIN_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMOREMARGIN_LABEL' ];?></label></div>
							<div class="cis_controls"><input type="text" name="readmoremargin" id="cis_readmoremargin" value="<?php echo $v = $id == 0 ? $slider_global_options['readmoremargin'] : $row->readmoremargin;?>" class="inputbox" size="40" ="" ></div>
					
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_readmorestyle" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMORESTYLE_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMORESTYLE_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['readmorestyle'] : $row->readmorestyle;
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
									$default = $id == 0 ? $slider_global_options['readmorealign'] : $row->readmorealign;
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
							<div class="cis_control_label"><label id="" for="cis_readmoresize" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMORESIZE_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_READMORESIZE_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['readmoresize'] : $row->readmoresize;
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
									$default = $id == 0 ? $slider_global_options['readmoreicon'] : $row->readmoreicon;
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
							
							
							<div style="clear: both;margin: 15px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_AUTOPLAY_OPTIONS_LABEL' ];?></div>
							
							<div class="cis_control_label"><label id="" for="cis_move_step" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_MOVESTEP_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_MOVESTEP_LABEL' ];?></label></div>
							<div class="cis_controls"><input type="text" name="move_step" id="cis_move_step" value="<?php echo $v = $id == 0 ? $slider_global_options['move_step'] : $row->move_step;?>" class="inputbox required" size="40" ="" ></div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_move_time" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_MOVETIME_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_MOVETIME_LABEL' ];?></label></div>
							<div class="cis_controls"><input type="text" name="move_time" id="cis_move_time" value="<?php echo $v = $id == 0 ? $slider_global_options['move_time'] : $row->move_time;?>" class="inputbox required" size="40" ="" ></div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_move_ease" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_MOVEEASE_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_MOVEEASE_LABEL' ];?></label></div>
							<div class="cis_controls"><input type="text" name="move_ease" id="cis_move_ease" value="<?php echo $v = $id == 0 ? $slider_global_options['move_ease'] : $row->move_ease;?>" class="inputbox required" size="40" ="" ></div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_autoplay" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_AUTOPLAY_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_AUTOPLAY_LABEL' ];?></label></div>
							<div class="cis_controls">
									<?php 
									$default = $id == 0 ? $slider_global_options['autoplay'] : $row->autoplay;
									$opts = array(0 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_AUTOPLAY_NEVER'], 1 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_AUTOPLAY_EVENLY'], 2 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_AUTOPLAY_STEPS']);
									$options = array();
									echo '<select id="cis_autoplay" class="" name="autoplay">';
									foreach($opts as $key=>$value) :
										$selected = $key == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
									endforeach;
									echo '</select>';
									?>
							</div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_autoplay_start_timeout" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_AUTOPLAY_START_TIMEOUT_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_AUTOPLAY_START_TIMEOUT_LABEL' ];?></label></div>
							<div class="cis_controls"><input type="text" name="autoplay_start_timeout" id="cis_autoplay_start_timeout" value="<?php echo $v = $id == 0 ? $slider_global_options['autoplay_start_timeout'] : $row->autoplay_start_timeout;?>" class="inputbox required" size="40" ="" ></div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_autoplay_hover_timeout" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_AUTOPLAY_HOVER_TIMEOUT_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_AUTOPLAY_HOVER_TIMEOUT_LABEL' ];?></label></div>
							<div class="cis_controls"><input type="text" name="autoplay_hover_timeout" id="cis_autoplay_hover_timeout" value="<?php echo $v = $id == 0 ? $slider_global_options['autoplay_hover_timeout'] : $row->autoplay_hover_timeout;?>" class="inputbox required" size="40" ="" ></div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_autoplay_step_timeout" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_AUTOPLAY_STEP_TIMEOUT_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_AUTOPLAY_STEP_TIMEOUT_LABEL' ];?></label></div>
							<div class="cis_controls"><input type="text" name="autoplay_step_timeout" id="cis_autoplay_step_timeout" value="<?php echo $v = $id == 0 ? $slider_global_options['autoplay_step_timeout'] : $row->autoplay_step_timeout;?>" class="inputbox required" size="40" ="" ></div>
							
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_autoplay_evenly_speed" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_AUTOPLAY_EVENLY_SPEED_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_AUTOPLAY_EVENLY_SPEED_LABEL' ];?></label></div>
							<div class="cis_controls"><input type="text" name="autoplay_evenly_speed" id="cis_autoplay_evenly_speed" value="<?php echo $v = $id == 0 ? $slider_global_options['autoplay_evenly_speed'] : $row->autoplay_evenly_speed;?>" class="inputbox required" size="40" ="" ></div>
							



							<div style="clear: both;margin: 25px 0 20px 17px;color: #575757;font-size: 20px;list-style-type: disc;display: list-item;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_OPTIONS_LABEL' ];?></div>

							<div style="clear: both;margin: 15px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_MAIN_OPTIONS_LABEL' ];?></div>

							<!-- TODO -->


							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_max_size" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_MAX_SIZE_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_MAX_SIZE_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_max_size'] : $row->popup_max_size;
									echo '<select id="cis_popup_max_size" class="cis_has_slider" name="popup_max_size">';
									for($k = 30; $k <= 100; $k += 5) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'%</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>

							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_item_min_width" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ITEM_MIN_WIDTH_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ITEM_MIN_WIDTH_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_item_min_width'] : $row->popup_item_min_width;
									echo '<select id="cis_popup_item_min_width" class="cis_has_slider" name="popup_item_min_width">';
									for($k = 100; $k <= 500; $k += 10) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>
							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_closeonend" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_CLOSEONEND_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_CLOSEONEND_LABEL' ];?></label></div>
							<div class="cis_controls">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_closeonend'] : $row->popup_closeonend;
									$opts = array(0 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_NO'], 1 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_YES']);
									$options = array();
									echo '<select id="cis_popup_closeonend" class="" name="popup_closeonend">';
									foreach($opts as $key=>$value) :
										$selected = $key == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
									endforeach;
									echo '</select>';
									?>
							</div>

							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_use_back_img" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_USE_BACK_IMG_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_USE_BACK_IMG_LABEL' ];?></label></div>
							<div class="cis_controls">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_use_back_img'] : $row->popup_use_back_img;
									$opts = array(0 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_NO'], 1 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_YES']);
									$options = array();
									echo '<select id="cis_popup_use_back_img" class="" name="popup_use_back_img">';
									foreach($opts as $key=>$value) :
										$selected = $key == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
									endforeach;
									echo '</select>';
									?>
							</div>

							<div style="clear: both;margin: 15px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ARROW_OPTIONS_LABEL' ];?></div>

							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_arrow_passive_opacity" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ARROW_PASSIVE_OPACITY_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ARROW_PASSIVE_OPACITY_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_arrow_passive_opacity'] : $row->popup_arrow_passive_opacity;
									echo '<select id="cis_popup_arrow_passive_opacity" class="cis_has_slider" name="popup_arrow_passive_opacity">';
									for($k = 0; $k <= 100; $k += 5) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'%</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>

							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_arrow_left_offset" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ARROW_LEFT_OFFSET_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ARROW_LEFT_OFFSET_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_arrow_left_offset'] : $row->popup_arrow_left_offset;
									echo '<select id="cis_popup_arrow_left_offset" class="cis_has_slider" name="popup_arrow_left_offset">';
									for($k = 0; $k <= 100; $k ++) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>

							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_arrow_min_height" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ARROW_MIN_HEIGHT_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ARROW_MIN_HEIGHT_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_arrow_min_height'] : $row->popup_arrow_min_height;
									echo '<select id="cis_popup_arrow_min_height" class="cis_has_slider" name="popup_arrow_min_height">';
									for($k = 10; $k <= 30; $k ++) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>
							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_arrow_max_height" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ARROW_MAX_HEIGHT_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ARROW_MAX_HEIGHT_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_arrow_max_height'] : $row->popup_arrow_max_height;
									echo '<select id="cis_popup_arrow_max_height" class="cis_has_slider" name="popup_arrow_max_height">';
									for($k = 30; $k <= 64; $k ++) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>
							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_showarrows" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_SHOWARROWS_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_SHOWARROWS_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_showarrows'] : $row->popup_showarrows;
									$opts = array(0 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_SHOWARROWS_NEVER'], 1 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_SHOWARROWS_ONHOVER'], 2 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_SHOWARROWS_ALWAYS']);
									$options = array();
									echo '<select id="cis_popup_showarrows" class="cis_has_slider" name="popup_showarrows">';
									foreach($opts as $key=>$value) :
										$selected = $key == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
									endforeach;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>


							<div style="clear: both;margin: 15px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_IMAGE_ORDER_LABEL' ];?></div>

							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_image_order_opacity" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_IMAGE_ORDER_OPACITY_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_IMAGE_ORDER_OPACITY_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_image_order_opacity'] : $row->popup_image_order_opacity;
									echo '<select id="cis_popup_image_order_opacity" class="cis_has_slider" name="popup_image_order_opacity">';
									for($k = 0; $k <= 100; $k += 5) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'%</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>

							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_image_order_top_offset" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_IMAGE_ORDER_TOP_OFFSET_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_IMAGE_ORDER_TOP_OFFSET_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_image_order_top_offset'] : $row->popup_image_order_top_offset;
									echo '<select id="cis_popup_image_order_top_offset" class="cis_has_slider" name="popup_image_order_top_offset">';
									for($k = 0; $k <= 100; $k ++) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'px</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>

							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_show_orderdata" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_SHOWORDERDATA_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_SHOWORDERDATA_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_show_orderdata'] : $row->popup_show_orderdata;
									$opts = array(0 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_SHOWARROWS_NEVER'], 1 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_SHOWARROWS_ONHOVER'], 2 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_SHOWARROWS_ALWAYS']);
									$options = array();
									echo '<select id="cis_popup_show_orderdata" class="cis_has_slider" name="popup_show_orderdata">';
									foreach($opts as $key=>$value) :
										$selected = $key == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
									endforeach;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>


							<div style="clear: both;margin: 15px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ICONS_OPTIONS_LABEL' ];?></div>

							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_icons_opacity" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ICONS_OPACITY_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_ICONS_OPACITY_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_icons_opacity'] : $row->popup_icons_opacity;
									echo '<select id="cis_popup_icons_opacity" class="cis_has_slider" name="popup_icons_opacity">';
									for($k = 0; $k <= 100; $k += 5) :
										$selected = $k == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$k.'">'.$k.'%</option>';
									endfor;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>

							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_show_icons" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_SHOWICONS_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_SHOWICONS_LABEL' ];?></label></div>
							<div class="cis_controls cis_slider_wrapper">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_show_icons'] : $row->popup_show_icons;
									$opts = array(0 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_SHOWARROWS_NEVER'], 1 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_SHOWARROWS_ONHOVER'], 2 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_SHOWARROWS_ALWAYS']);
									$options = array();
									echo '<select id="cis_popup_show_icons" class="cis_has_slider" name="popup_show_icons">';
									foreach($opts as $key=>$value) :
										$selected = $key == $default ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
									endforeach;
									echo '</select>';
									?>
									<div class="cis_slider_wrapper_inner"><div class="cis_slider_insert_here" style="display: none;"></div></div>
							</div>

							<div style="clear: both;margin: 15px 0 10px 0px;color: #08c; font-style: italic;font-size: 12px;text-decoration: underline;"><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_AUTOPLAY_OPTIONS_LABEL' ];?></div>

							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_autoplay_time" class="hasTooltip " title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_AUTOPLAY_TIME_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_AUTOPLAY_TIME_LABEL' ];?></label></div>
							<div class="cis_controls"><input type="text" name="popup_autoplay_time" id="cis_popup_autoplay_time" value="<?php echo $v = $id == 0 ? $slider_global_options['popup_autoplay_time'] : $row->popup_autoplay_time;?>" class="inputbox required" size="40" ="" ></div>
							<!-- TODO -->
							<div style="clear: both;height: 5px;"></div>
							<div class="cis_control_label"><label id="" for="cis_popup_autoplay_default" class="hasTooltip" title="<?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_AUTOPLAY_DEFAULT_DESCRIPTION' ];?>" ><?php echo $slider_dictionary[ 'COM_CREATIVEIMAGESLIDER_POPUP_AUTOPLAY_DEFAULT_LABEL' ];?></label></div>
							<div class="cis_controls">
									<?php 
									$default = $id == 0 ? $slider_global_options['popup_autoplay_default'] : $row->popup_autoplay_default;
									$opts = array(0 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_NO'], 1 => $slider_dictionary['COM_CREATIVEIMAGESLIDER_YES']);
									$options = array();
									echo '<select id="cis_popup_autoplay_default" class="" name="popup_autoplay_default">';
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
					if($id != 0) {
					$sql = 'SELECT '.
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
							'sa.buttonusedefault ' .
							'FROM '.
							$wpdb->prefix.'cis_sliders sp '.
							'JOIN '.
							$wpdb->prefix.'cis_images sa ON sa.id_slider = sp.id '.
							'AND sa.published = \'1\' '.
							'WHERE sp.published = \'1\' '.
							'AND sp.id = '.$id.' '.
							'ORDER BY sp.ordering,sp.id,sa.ordering,sa.id';
					$rows = $wpdb->get_results($sql);

					if(sizeof($rows) == 0)
						$slider_options = array();
					else
						for ($i=0, $n=count( $rows ); $i < $n; $i++) {
						$slider_options[$rows[$i]->slider_id][] = $rows[$i];
					}

					if(sizeof($rows) != 0 && sizeof($slider_options) > 0) {?>
					<div id="preview_dummy" style="position: fixed;left:0;top: 0;"></div>
					<div class="preview_box" style="position: absolute;width: 100%;top: 75px;">
						<img alt="Close Preview Box" title="Close Preview Box" src="<?php echo plugin_dir_url( __FILE__ );?>../images/close.png" id="cis_preview_close" />
						<div  id="cis_preview">Preview</div>
						<div id="cis_preview_wrapper1" style="position: relative;overflow: hidden;">
							<div id="cis_preview_inner1" style="padding-bottom: 32px;">
								<div style="margin: 0px auto 0px;color: #444;font-style: italic;">Slider preview (active state)</div>
								<div style="height: 5px;width: 100%;">&nbsp;</div>
								<?php 
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

								reset($slider_options);
								$first_key = key($slider_options);
								
								$slider_options_value = $slider_options[$first_key][0];
								
								$slider_width = $slider_options_value->width;
								$slider_item_height = (int) $slider_options_value->height;
								$slider_id_template = (int) $slider_options_value->id_template;
								$slider_margintop = (int) $slider_options_value->margintop;
								$slider_marginbottom = (int) $slider_options_value->marginbottom;
								$slider_paddingtop = (int) $slider_options_value->paddingtop;
								$slider_paddingbottom = (int) $slider_options_value->paddingbottom;
								$slider_itemsoffset = (int) $slider_options_value->itemsoffset;
								$slider_showarrows = (int) $slider_options_value->showarrows;
								$slider_bgcolor =  $slider_options_value->bgcolor;
								$slider_showreadmore = (int) $slider_options_value->showreadmore;
								$slider_readmoretext =  $slider_options_value->readmoretext;
								$slider_readmorestyle =  $slider_options_value->readmorestyle;
								$slider_readmoresize =  $slider_options_value->readmoresize;
								$slider_readmoreicon =  $slider_options_value->readmoreicon;
								$slider_readmorealign =  (int) $slider_options_value->readmorealign;
								$slider_readmoremargin =  $slider_options_value->readmoremargin;
								$slider_overlaycolor =  $slider_options_value->overlaycolor;
								$slider_overlayopacity = (int) $slider_options_value->overlayopacity;
								$slider_textcolor = $slider_options_value->textcolor;
								$slider_overlayfontsize = (int) $slider_options_value->overlayfontsize;
								$slider_textshadowcolor =  $slider_options_value->textshadowcolor;
								$slider_textshadowsize = (int) $slider_options_value->textshadowsize;
								$slider_captionalign = (int) $slider_options_value->captionalign;
								$slider_captionmargin = $slider_options_value->captionmargin;
								
								$slider_arrow_template = $slider_options_value->arrow_template;
								$slider_arrow_width = $slider_options_value->arrow_width;
								$slider_arrow_left_offset = $slider_options_value->arrow_left_offset;
								$slider_arrow_center_offset = $slider_options_value->arrow_center_offset;
								$slider_arrow_passive_opacity = $slider_options_value->arrow_passive_opacity;
								
								$slider_move_step = $slider_options_value->move_step;
								$slider_move_time = $slider_options_value->move_time;
								$slider_move_ease = $slider_options_value->move_ease;
								$slider_autoplay = $slider_options_value->autoplay;
								$slider_autoplay_start_timeout = $slider_options_value->autoplay_start_timeout;
								$slider_autoplay_hover_timeout = $slider_options_value->autoplay_hover_timeout;
								$slider_autoplay_step_timeout = $slider_options_value->autoplay_step_timeout;
								$slider_autoplay_evenly_speed = $slider_options_value->autoplay_evenly_speed;
								
								$slider_autoplay = 0;//turn off autoplay
								
								
								$cache_dir = __DIR__ . '/../../../../../../cache/com_creativeimageslider/';
								$cached_img_dir = plugin_dir_url( __FILE__ ) . '/../cache/com_creativeimageslider/';
								$uploaded_img_dir = plugin_dir_url( __FILE__ ) . '/../';
								
								$id_slider = $id;
								//start render html
								echo '<div id="cis_slider_'.$id_slider.'" roll="'.$id_slider.'" class="cis_main_wrapper" style="position: relative !important;">';
								echo '<div class="cis_images_row">';
								
								//buttons
								$img_src1 = plugin_dir_url( __FILE__ ) .'../assets/images/arrows/cis_button_left'.$slider_arrow_template.'.png';
								$img_src2 = plugin_dir_url( __FILE__ ) .'../assets/images/arrows/cis_button_right'.$slider_arrow_template.'.png';
								echo '<img class="cis_button_left" src="'.$img_src1.'" />';
								echo '<img class="cis_button_right" src="'.$img_src2.'" />';
								echo '<div class="cis_arrow_data" style="display: none;">'.$slider_arrow_width.','.$slider_arrow_left_offset.','.$slider_arrow_center_offset.','.$slider_arrow_passive_opacity.','.$slider_showarrows.'</div>';
								echo '<div class="cis_moving_data" style="display: none;">'.$slider_move_step.','.$slider_move_time.','.$slider_move_ease.','.$slider_autoplay.','.$slider_autoplay_start_timeout.','.$slider_autoplay_step_timeout.','.$slider_autoplay_evenly_speed.','.$slider_autoplay_hover_timeout.'</div>';
								
								echo '<div class="cis_images_holder">';
								
								$items_css = '';
								$loader_color_class = 'cis_row_item_loader_color1';
								foreach( $slider_options[$first_key] as $cis_index => $image_info) {
									//get image
									$img_path = $image_info->img_path != '' ? $image_info->img_path : $image_info->img_url_path;
									if($image_info->img_path != '') {
										//check to see if cached file exists
										$img_parts = explode('/',$image_info->img_path);
										$filename = $img_parts[sizeof($img_parts) - 1];
										preg_match('/^(.*)\.([a-z]{3,4}$)/i',$filename,$matches);
										$img_path_cache = $matches[1] . '-tmb-h' . $slider_item_height . '.' . $matches[2];
										$img_fullpath_cache = $cache_dir . $img_path_cache;
										if(file_exists($img_fullpath_cache)) {
											$img_path = $cached_img_dir . $img_path_cache;
										}
										else {
											$img_path = $uploaded_img_dir . $image_info->img_path;
										}
									}
										
									echo '<div class="cis_row_item" id="cis_item_'.$image_info->img_id.'">';
									$loader_color_class = $loader_color_class == 'cis_row_item_loader_color1' ? 'cis_row_item_loader_color2' : 'cis_row_item_loader_color1';
									echo '<div class="cis_row_item_loader '.$loader_color_class.'" style="height: '.$slider_item_height.'px;"></div>';
									echo '<div class="cis_row_item_inner cis_row_hidden_element">';
									//image
									echo '<img src="'.$img_path.'" style="height: '.$slider_item_height.'px;"  />';
								
									//overlay
									$custom_rule_class = $image_info->overlayusedefault == 1 ? ' cis_preset' : '';
									$custom_rule_class_button = $image_info->buttonusedefault == 1 ? ' cis_preset' : '';
									echo '<div class="cis_row_item_overlay'.$custom_rule_class.'">';
									//caption
									if($image_info->img_name != '')
										echo '<div class="cis_row_item_overlay_txt'.$custom_rule_class.'">'.$image_info->img_name.'</div>';
										
									//button
									if(($image_info->buttonusedefault == 0 && $slider_showreadmore == 1) || ($image_info->buttonusedefault == 1 && $image_info->item_showreadmore == 1)) {
										//get click url
										$click_url = '#';
								
										//read more text
										$item_readmoretext = $image_info->overlayusedefault == 0 ? $slider_readmoretext : $image_info->item_readmoretext;
								
										//button styles
										if($image_info->buttonusedefault == 0) {
											$button_style = 'creative_btn-' . $slider_readmorestyle;
											$button_size = 'creative_btn-' . $slider_readmoresize;
											$button_icon_color = $slider_readmorestyle == 'gray' ? 'white' : 'white';
											$button_icon_html = $slider_readmoreicon == 'none' ? '' : '<i class="creative_icon-'.$button_icon_color.' creative_icon-'.$slider_readmoreicon.'"></i> ';
										}
										else {
											$button_style = 'creative_btn-' . $image_info->item_readmorestyle;
											$button_size = 'creative_btn-' . $image_info->item_readmoresize;
											$button_icon_color = $image_info->item_readmorestyle == 'gray' ? 'white' : 'white';
											$button_icon_html = $image_info->item_readmoreicon == 'none' ? '' : '<i class="creative_icon-'.$button_icon_color.' creative_icon-'.$image_info->item_readmoreicon.'"></i> ';
										}
										echo '<a href="'.$click_url.'" class="creative_btn '.$button_style.' '.$button_size.$custom_rule_class_button.'"><span class="cis_creative_btn_icon">'.$button_icon_html .'</span><span class="cis_creative_btn_txt">'. $item_readmoretext.'</span></a>';
								

										//generate css
										if($image_info->overlayusedefault == 1) {
											$item_overlaycolor_rgb = cis_hex2rgb($image_info->item_overlaycolor);
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
								
								//print css
								$slider_overlaycolor_rgb = cis_hex2rgb($slider_overlaycolor);
								$slider_overlayopacity = $slider_overlayopacity / 100;
								$slider_overlaycolor_rgba = 'rgba('.$slider_overlaycolor_rgb.','.$slider_overlayopacity.')';
								
								//get txt text shadow;
								if($slider_textshadowsize == 0)
									$slider_textshadow_rule = 'text-shadow: none;';
								elseif($slider_textshadowsize == 1)
								$slider_textshadow_rule = 'text-shadow: -1px 2px 0px '.$slider_textshadowcolor.';';
								elseif($slider_textshadowsize == 2)
								$slider_textshadow_rule = 'text-shadow: -1px 2px 2px '.$slider_textshadowcolor.';';
								elseif($slider_textshadowsize == 3)
								$slider_textshadow_rule = 'text-shadow: -1px 2px 4px '.$slider_textshadowcolor.';';
								
								$cis_css = '';
								$cis_css .= '#cis_slider_'.$id_slider.'.cis_main_wrapper {';
								$cis_css .= 'width: '.$slider_width.';';
								$cis_css .= 'margin: '.$slider_margintop.'px auto '.$slider_marginbottom.'px;';
								$cis_css .= 'padding: '.$slider_paddingtop.'px 0px '.$slider_paddingbottom.'px 0px;';
								$cis_css .= 'background-color: '.$slider_bgcolor.';';
								$cis_css .= '}';
								$cis_css .= '#cis_slider_'.$id_slider.' .cis_row_item_overlay {';
								$cis_css .= 'background-color: '.$slider_overlaycolor.';';
								$cis_css .= 'background-color: '.$slider_overlaycolor_rgba.';';
								$cis_ta = $slider_readmorealign == 2 ? 'center' : 'left';
								$cis_css .= 'text-align: '.$cis_ta.';';
								$cis_css .= '}';
								$cis_css .= '#cis_slider_'.$id_slider.' .cis_row_item {';
								$cis_css .= 'margin-right: '.$slider_itemsoffset.'px;';
								$cis_css .= '}';
								$cis_css .= '#cis_slider_'.$id_slider.' .cis_row_item_overlay_txt {';
								$cis_css .= $slider_textshadow_rule;
								$cis_css .= 'font-size: '.$slider_overlayfontsize.'px;';
								$cis_css .= 'color: '.$slider_textcolor.';';
								$cis_css .= 'margin: '.$slider_captionmargin.';';
								$cis_text_align = $slider_captionalign == 0 ? 'left' : ($slider_captionalign == 1 ? 'right' : 'center');
								$cis_css .= 'text-align: '.$cis_text_align.';';
								$cis_css .= '}';
								$cis_css .= '#cis_slider_'.$id_slider.' .creative_btn {';
								$cis_css .= 'margin: '.$slider_readmoremargin.';';
								$cis_float = $slider_readmorealign == 0 ? 'left' : ($slider_readmorealign == 1 ? 'right' : 'none');
								$cis_css .= 'float: '.$cis_float.';';
								$cis_css .= '}';
								
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