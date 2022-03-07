<?php
header("Content-Type:text/html; charset=UTF-8");
header("Expires: on, 01 Jan 1970 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if($_SERVER["SCRIPT_NAME"] != "/ccmsusr/index.php") {
	echo "This script can NOT be called directly.";
	exit;
}

$msgArry = array();

if($CLEAN["id"] == "") {
	$msgArry = array("error","No ID provided.");
} elseif($CLEAN["id"] == "MINLEN") {
	$msgArry = array("error","This field must be between 1 to 8 characters");
} elseif($CLEAN["id"] == "MAXLEN") {
	$msgArry = array("error","This field must be between 1 to 8 characters");
} elseif($CLEAN["id"] == "INVAL") {
	$msgArry = array("error","'Name' field contains invalid characters.  ( > < & # )  You have used characters in this field which are either not supported by this field or we do not permitted on this system.");
}

if(!isset($msgArry["error"])) {
	// no problems
	/*
	$qry = $CFG["DBH"]->prepare("DELETE FROM `ccms_log` WHERE `id` = :id LIMIT 1;");
	$qry->execute(array(':id' => $CLEAN["id"]));
	$count = $qry->rowCount();
	if($count > 0) {
		echo "0"; // success
	} else {
		echo "1"; // already deleted
	}
	exit;
	*/
	$msgArry = "0";

}
echo json_encode($msgArry);
