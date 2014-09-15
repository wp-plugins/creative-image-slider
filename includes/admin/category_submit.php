<?php 
global $wpdb;
$id = (int) $_POST['id'];
$task = isset($_REQUEST['task']) ? $_REQUEST['task'] : '';

if($id == 0) {
	
	$wpdb->query( $wpdb->prepare(
			"
			INSERT INTO ".$wpdb->prefix."cis_categories
			( 
				`name`, `published`
			)
			VALUES ( %s, %d)
			",
			$_POST['name'], $_POST['published']
	) );
	
	$insrtid = (int) $wpdb->insert_id;
	if($insrtid != 0) {
		if($task == 'save')
			$redirect = "admin.php?page=cis_categories&act=edit&id=".$insrtid;
		elseif($task == 'save_new')
			$redirect = "admin.php?page=cis_categories&act=new";
		else
			$redirect = "admin.php?page=cis_categories";
	}
	else
		$redirect = "admin.php?page=cis_categories&error=1";
}
else {
	$q = $wpdb->query( $wpdb->prepare(
			"
			UPDATE ".$wpdb->prefix."cis_categories
			SET
				`name` = %s, 
				`published` = %d
			WHERE
				`id` = '".$id."'
			",
			$_POST['name'], $_POST['published']
	) );
	
	if($q !== false) {
		if($task == 'save')
			$redirect = "admin.php?page=cis_categories&act=edit&id=".$id;
		elseif($task == 'save_new')
			$redirect = "admin.php?page=cis_categories&act=new";
		else
			$redirect = "admin.php?page=cis_categories";
	}
	else
		$redirect = "admin.php?page=cis_categories&error=1";
}
header("Location: ".$redirect);
exit();
?>