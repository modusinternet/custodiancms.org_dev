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

$msg = array();

if(ccms_badIPCheck($_SERVER["REMOTE_ADDR"])) {
	$msg["error"] = "There is a problem with your login, your IP Address is currently being blocked.  Please contact the website administrators directly if you feel this message is in error.";

} elseif($CLEAN["id"] == "") {
	$msg["error"] = "No ID provided.";
} elseif($CLEAN["id"] == "MINLEN") {
	$msg["error"] = "This field must be between 1 to 8 characters";
} elseif($CLEAN["id"] == "MAXLEN") {
	$msg["error"] = "This field must be between 1 to 8 characters";
} elseif($CLEAN["id"] == "INVAL") {
	$msg["error"] = "'Name' field contains invalid characters.  ( > < & # )  You have used characters in this field which are either not supported by this field or we do not permitted on this system.";
}

if(!isset($msg["error"])) {
	// no problems
	$qry = $CFG["DBH"]->prepare("DELETE FROM `ccms_log` WHERE `id` = :id LIMIT 1;");
	$qry->execute(array(':id' => $CLEAN["id"]));
	$count = $qry->rowCount();
	if($count > 0) {
		$msg["success"] = "0"; // success
	} else {
		$msg["success"] = "1"; // already deleted
	}
}

echo json_encode($msg);
