<?php 
global $wpdb;
$id = (int) $_POST['id'];
$task = isset($_REQUEST['task']) ? $_REQUEST['task'] : '';

$sql = "SELECT COUNT(id) FROM ".$wpdb->prefix."cis_images";
$count_fields = $wpdb->get_var($sql);

if($id == 0 && $count_fields < 10 && $_POST['img_name'] != '' && $_POST['img_url'] != '') {
	$sql = "SELECT MAX(`ordering`) FROM `".$wpdb->prefix."cis_images` WHERE `id_slider` = ". (int) $_POST['id_slider'];
	$max_order = $wpdb->get_var($sql) + 1;
	
		$wpdb->query( $wpdb->prepare(
			"
			INSERT INTO ".$wpdb->prefix."cis_images
			( 
				`name`,
				`published`,
				`id_slider`,
				`img_name`,
				`img_url`,
				`caption`,
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
				`overlayusedefault`,
				`buttonusedefault`,
				`readmorealign`,
				`captionalign`,
				`readmoremargin`,
				`captionmargin`,
				`redirect_url`,
				`redirect_target`,
				`popup_img_name`,
				`popup_img_url`,
				`popup_open_event`,
				`ordering`
			)
			VALUES ( %s, %d, %d, %s, %s, %s, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %d)
			",
			$_POST['name'],
			$_POST['published'],
			$_POST['id_slider'],
			$_POST['img_name'],
			$_POST['img_url'],
			$_POST['caption'],
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
			$_POST['overlayusedefault'],
			$_POST['buttonusedefault'],
			$_POST['readmorealign'],
			$_POST['captionalign'],
			$_POST['readmoremargin'],
			$_POST['captionmargin'],
			$_POST['redirect_url'],
			$_POST['redirect_target'],
			$_POST['popup_img_name'],
			$_POST['popup_img_url'],
			$_POST['popup_open_event'],
			$max_order
	) );
	
	$insrtid = (int) $wpdb->insert_id;
	if($insrtid != 0) {
		if($task == 'save')
			$redirect = "admin.php?page=cis_items&act=edit&id=".$insrtid;
		elseif($task == 'save_new')
			$redirect = "admin.php?page=cis_items&act=new";
		else
			$redirect = "admin.php?page=cis_items";
	}
	else
		$redirect = "admin.php?page=cis_items&error=1";
}
elseif($id != 0) {
	$q = $wpdb->query( $wpdb->prepare(
			"
			UPDATE ".$wpdb->prefix."cis_images
			SET
				`name` = %s,
				`published` = %d,
				`id_slider` = %d,
				`img_name` = %s,
				`img_url` = %s,
				`caption` = %s,
				`showreadmore` = %d,
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
				`overlayusedefault` = %s,
				`buttonusedefault` = %s,
				`readmorealign` = %s,
				`captionalign` = %s,
				`readmoremargin` = %s,
				`captionmargin` = %s,
				`redirect_url` = %s,
				`redirect_target` = %s,
				`popup_img_name` = %s,
				`popup_img_url` = %s,
				`popup_open_event` = %s
			WHERE
				`id` = '".$id."'
			",
			$_POST['name'],$_POST['published'],$_POST['id_slider'],$_POST['img_name'],$_POST['img_url'],$_POST['caption'],$_POST['showreadmore'],$_POST['readmoretext'],$_POST['readmorestyle'],$_POST['readmoreicon'],$_POST['readmoresize'],$_POST['overlaycolor'],$_POST['overlayopacity'],$_POST['textcolor'],$_POST['overlayfontsize'],$_POST['textshadowcolor'],$_POST['textshadowsize'],$_POST['overlayusedefault'],$_POST['buttonusedefault'],$_POST['readmorealign'],$_POST['captionalign'],$_POST['readmoremargin'],$_POST['captionmargin'],$_POST['redirect_url'],$_POST['redirect_target'],$_POST['popup_img_name'],$_POST['popup_img_url'],$_POST['popup_open_event']
	) );
	if($q !== false) {
		if($task == 'save')
			$redirect = "admin.php?page=cis_items&act=edit&id=".$id;
		elseif($task == 'save_new')
			$redirect = "admin.php?page=cis_items&act=new";
		else
			$redirect = "admin.php?page=cis_items";
	}
	else
		$redirect = "admin.php?page=cis_items&error=1";
}
else {
	$redirect = "admin.php?page=cis_items&error=1";
}
header("Location: ".$redirect);
exit();
?>