<?php 
global $wpdb;
$id = (int) $_POST['id'];
$task = isset($_REQUEST['task']) ? $_REQUEST['task'] : '';

$sql = "SELECT COUNT(id) FROM ".$wpdb->prefix."cis_sliders";
$count_sliders = $wpdb->get_var($sql);

if($id == 0 && $count_sliders < 10) {
	$sql = "SELECT MAX(`ordering`) FROM `".$wpdb->prefix."cis_sliders`";
	$max_order = $wpdb->get_var($sql) + 1;

	$wpdb->query( $wpdb->prepare(
			"
			INSERT INTO ".$wpdb->prefix."cis_sliders
			( 
				`name`,
				`published`,
				`id_category`,
				`width`,
				`height`,
				`itemsoffset`,
				`margintop`,
				`marginbottom`,
				`paddingtop`,
				`paddingbottom`,
				`bgcolor`,
				`showarrows`,
				`showreadmore`,
				`readmoretext`,
				`readmorestyle`,
				`readmoreicon`,
				`readmoresize`,
				`overlaycolor`,
				`overlayopacity`,
				`textcolor`,
				`overlayfontsize`,
				`textshadowcolor`,
				`textshadowsize`,
				`readmorealign`,
				`captionalign`,
				`readmoremargin`,
				`captionmargin`,
				`arrow_template`,
				`arrow_width`,
				`arrow_left_offset`,
				`arrow_center_offset`,
				`arrow_passive_opacity`,
				`move_step`,
				`move_time`,
				`move_ease`,
				`autoplay`,
				`autoplay_start_timeout`,
				`autoplay_hover_timeout`,
				`autoplay_step_timeout`,
				`autoplay_evenly_speed`,
				`overlayanimationtype`,
				`popup_max_size`,
				`popup_item_min_width`,
				`popup_use_back_img`,
				`popup_arrow_passive_opacity`,
				`popup_arrow_left_offset`,
				`popup_arrow_min_height`,
				`popup_arrow_max_height`,
				`popup_showarrows`,
				`popup_image_order_opacity`,
				`popup_image_order_top_offset`,
				`popup_show_orderdata`,
				`popup_icons_opacity`,
				`popup_show_icons`,
				`popup_autoplay_default`,
				`popup_closeonend`,
				`popup_autoplay_time`,
				`popup_open_event`,
				`ordering`
			)
			VALUES ( %s, %d, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %d )
			",
			$_POST['name'],
			$_POST['published'],
			$_POST['id_category'],
			$_POST['width'],
			$_POST['height'],
			$_POST['itemsoffset'],
			$_POST['margintop'],
			$_POST['marginbottom'],
			$_POST['paddingtop'],
			$_POST['paddingbottom'],
			$_POST['bgcolor'],
			$_POST['showarrows'],
			$_POST['showreadmore'],
			$_POST['readmoretext'],
			$_POST['readmorestyle'],
			$_POST['readmoreicon'],
			$_POST['readmoresize'],
			$_POST['overlaycolor'],
			$_POST['overlayopacity'],
			$_POST['textcolor'],
			$_POST['overlayfontsize'],
			$_POST['textshadowcolor'],
			$_POST['textshadowsize'],
			$_POST['readmorealign'],
			$_POST['captionalign'],
			$_POST['readmoremargin'],
			$_POST['captionmargin'],
			$_POST['arrow_template'],
			$_POST['arrow_width'],
			$_POST['arrow_left_offset'],
			$_POST['arrow_center_offset'],
			$_POST['arrow_passive_opacity'],
			$_POST['move_step'],
			$_POST['move_time'],
			$_POST['move_ease'],
			$_POST['autoplay'],
			$_POST['autoplay_start_timeout'],
			$_POST['autoplay_hover_timeout'],
			$_POST['autoplay_step_timeout'],
			$_POST['autoplay_evenly_speed'],
			$_POST['overlayanimationtype'],
			$_POST['popup_max_size'],
			$_POST['popup_item_min_width'],
			$_POST['popup_use_back_img'],
			$_POST['popup_arrow_passive_opacity'],
			$_POST['popup_arrow_left_offset'],
			$_POST['popup_arrow_min_height'],
			$_POST['popup_arrow_max_height'],
			$_POST['popup_showarrows'],
			$_POST['popup_image_order_opacity'],
			$_POST['popup_image_order_top_offset'],
			$_POST['popup_show_orderdata'],
			$_POST['popup_icons_opacity'],
			$_POST['popup_show_icons'],
			$_POST['popup_autoplay_default'],
			$_POST['popup_closeonend'],
			$_POST['popup_autoplay_time'],
			$_POST['popup_open_event'],
			$max_order
	) );

	$insrtid = (int) $wpdb->insert_id;
	if($insrtid != 0) {
		if($task == 'save')
			$redirect = "admin.php?page=cis_sliders&act=edit&id=".$insrtid;
		elseif($task == 'save_new')
			$redirect = "admin.php?page=cis_sliders&act=new";
		else
			$redirect = "admin.php?page=cis_sliders";
	}
	else
		$redirect = "admin.php?page=cis_sliders&error=1";
}
else {
	$q = $wpdb->query( $wpdb->prepare(
			"
			UPDATE ".$wpdb->prefix."cis_sliders
			SET
				`name` = %s,
				`published` = %d,
				`id_category` = %d,
				`width` = %s,
				`height` = %s,
				`itemsoffset` = %s,
				`margintop` = %s,
				`marginbottom` = %s,
				`paddingtop` = %s,
				`paddingbottom` = %s,
				`bgcolor` = %s,
				`showarrows` = %s,
				`showreadmore` = %s,
				`readmoretext` = %s,
				`readmorestyle` = %s,
				`readmoreicon` = %s,
				`readmoresize` = %s,
				`overlaycolor` = %s,
				`overlayopacity` = %s,
				`textcolor` = %s,
				`overlayfontsize` = %s,
				`textshadowcolor` = %s,
				`textshadowsize` = %s,
				`readmorealign` = %s,
				`captionalign` = %s,
				`readmoremargin` = %s,
				`captionmargin` = %s,
				`arrow_template` = %s,
				`arrow_width` = %s,
				`arrow_left_offset` = %s,
				`arrow_center_offset` = %s,
				`arrow_passive_opacity` = %s,
				`move_step` = %s,
				`move_time` = %s,
				`move_ease` = %s,
				`autoplay` = %s,
				`autoplay_start_timeout` = %s,
				`autoplay_hover_timeout` = %s,
				`autoplay_step_timeout` = %s,
				`autoplay_evenly_speed` = %s,
				`overlayanimationtype` = %s,
				`popup_max_size` = %s,
				`popup_item_min_width` = %s,
				`popup_use_back_img` = %s,
				`popup_arrow_passive_opacity` = %s,
				`popup_arrow_left_offset` = %s,
				`popup_arrow_min_height` = %s,
				`popup_arrow_max_height` = %s,
				`popup_showarrows` = %s,
				`popup_image_order_opacity` = %s,
				`popup_image_order_top_offset` = %s,
				`popup_show_orderdata` = %s,
				`popup_icons_opacity` = %s,
				`popup_show_icons` = %s,
				`popup_autoplay_default` = %s,
				`popup_closeonend` = %s,
				`popup_autoplay_time` = %s,
				`popup_open_event` = %s
			WHERE
				`id` = '".$id."'
			",
			$_POST['name'],
			$_POST['published'],
			$_POST['id_category'],
			$_POST['width'],
			$_POST['height'],
			$_POST['itemsoffset'],
			$_POST['margintop'],
			$_POST['marginbottom'],
			$_POST['paddingtop'],
			$_POST['paddingbottom'],
			$_POST['bgcolor'],
			$_POST['showarrows'],
			$_POST['showreadmore'],
			$_POST['readmoretext'],
			$_POST['readmorestyle'],
			$_POST['readmoreicon'],
			$_POST['readmoresize'],
			$_POST['overlaycolor'],
			$_POST['overlayopacity'],
			$_POST['textcolor'],
			$_POST['overlayfontsize'],
			$_POST['textshadowcolor'],
			$_POST['textshadowsize'],
			$_POST['readmorealign'],
			$_POST['captionalign'],
			$_POST['readmoremargin'],
			$_POST['captionmargin'],
			$_POST['arrow_template'],
			$_POST['arrow_width'],
			$_POST['arrow_left_offset'],
			$_POST['arrow_center_offset'],
			$_POST['arrow_passive_opacity'],
			$_POST['move_step'],
			$_POST['move_time'],
			$_POST['move_ease'],
			$_POST['autoplay'],
			$_POST['autoplay_start_timeout'],
			$_POST['autoplay_hover_timeout'],
			$_POST['autoplay_step_timeout'],
			$_POST['autoplay_evenly_speed'],
			$_POST['overlayanimationtype'],
			$_POST['popup_max_size'],
			$_POST['popup_item_min_width'],
			$_POST['popup_use_back_img'],
			$_POST['popup_arrow_passive_opacity'],
			$_POST['popup_arrow_left_offset'],
			$_POST['popup_arrow_min_height'],
			$_POST['popup_arrow_max_height'],
			$_POST['popup_showarrows'],
			$_POST['popup_image_order_opacity'],
			$_POST['popup_image_order_top_offset'],
			$_POST['popup_show_orderdata'],
			$_POST['popup_icons_opacity'],
			$_POST['popup_show_icons'],
			$_POST['popup_autoplay_default'],
			$_POST['popup_closeonend'],
			$_POST['popup_autoplay_time'],
			$_POST['popup_open_event']
	) );
	
	if($q !== false) {
		if($task == 'save')
			$redirect = "admin.php?page=cis_sliders&act=edit&id=".$id;
		elseif($task == 'save_new')
			$redirect = "admin.php?page=cis_sliders&act=new";
		else
			$redirect = "admin.php?page=cis_sliders";
	}
	else
		$redirect = "admin.php?page=cis_sliders&error=1";
}
header("Location: ".$redirect);
exit();
?>