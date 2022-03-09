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

if($CLEAN["password"] == "") {
	$msg["error"] = "'Password' field missing content.";
} elseif($CLEAN["password"] == "MINLEN") {
	$msg["error"] = "'Password' field is too short, must be 8 or more characters in length.";
} elseif($CLEAN["password"] == "INVAL") {
	$msg["error"] = "'Password' field error, indeterminate.";

} elseif($CLEAN["password1"] == "") {
	$msg["error"] = "'New Password' field missing content.";
} elseif($CLEAN["password1"] == "MINLEN") {
	$msg["error"] = "'New Password' field is too short, must be 8 or more characters in length.";
} elseif($CLEAN["password1"] == "INVAL") {
	$msg["error"] = "Something is wrong with your 'New Password', it came up as INVALID when testing is with with an open (.+) expression.";

} elseif($CLEAN["password2"] == "") {
	$msg["error"] = "'Repeat New Password' field missing content.";
} elseif($CLEAN["password2"] == "MINLEN") {
	$msg["error"] = "'Repeat New Password' field is too short, must be 8 or more characters in length.";
} elseif($CLEAN["password2"] == "INVAL") {
	$msg["error"] = "Something is wrong with your 'Repeat New Password', it came up as INVALID when testing is with with an open (.+) expression.";

} elseif($CLEAN["password1"] != $CLEAN["password2"]) {
	$msg["error"] = "'New Password' and 'Repeat New Password' fields are not the same.";

} elseif($CLEAN["2fa_radio"] == "") {
	$msg["error"] = "No 2FA option selected.";
} elseif($CLEAN["2fa_radio"] == "MINLEN") {
	$msg["error"] = "'2FA' variable too short, must be 1 or more characters in length.";
} elseif($CLEAN["2fa_radio"] == "INVAL") {
	$msg["error"] = "'2FA' variable contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";

} elseif($CLEAN["2fa_radio"] === "2" && $CLEAN["2fa_secret"] === "") {
	$msg["error"] = "Problem reading '2FA secret', not found.";
} elseif($CLEAN["2fa_radio"] === "2" && $CLEAN["2fa_secret"] === "MINLEN") {
	$msg["error"] = "'2FA secret' too short, must be 16 or more characters in length.";
	} elseif($CLEAN["2fa_radio"] === "2" && $CLEAN["2fa_secret"] === "INVAL") {
	$msg["error"] = "'2FA secret' variable contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";
}

if(!isset($msg["error"])) {
	$qry = $CFG["DBH"]->prepare("SELECT * FROM `ccms_user` WHERE `id` = :user_id LIMIT 1;");
	$qry->execute(array(':user_id' => $_SESSION["USER_ID"]));
	$row = $qry->fetch(PDO::FETCH_ASSOC);

	if($row) {
		if(password_verify($CLEAN["password"], $row["hash"])) {
			// The submitted password matches the hashed password stored on the server.
			// Rehash the password and replace original password hash on the server to make even more secure.
			// See https://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/ for more details.
			$options = ['cost' => 10];
			$hash = password_hash($CLEAN["password1"], PASSWORD_BCRYPT, $options);

			$tmp = "UPDATE `ccms_user` SET `hash` = :hash";
			if($CLEAN["2fa_radio"] === "1") {
				// Delete 2fa_secret field in database
				$tmp .= ",`2fa_secret` = ''";
			} elseif($CLEAN["2fa_radio"] === "2"){
				// Add/Update 2fa_secret field in database
				$tmp .= ",`2fa_secret` = :2fa_secret";
			}
			$tmp .= " WHERE `id` = :id;";

			//$qry = $CFG["DBH"]->prepare("UPDATE `ccms_user` SET `hash` = :hash WHERE `id` = :user_id;");
			$qry = $CFG["DBH"]->prepare($tmp);
			$qry->execute(array(':hash' => $hash, ':2fa_secret' => $CLEAN["2fa_secret"], ':id' => $_SESSION["USER_ID"]));
			//echo "1";
			$msg["success"] = "1"; // update successful
		} else {
			//echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style="margin-right: 10px;"></span>'."Password failed, please try again.";
			$msg["error"] = "Password failed, please try again.";
		}
	} else {
		//echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style="margin-right: 10px;"></span>'."Password update failed, your account is not found on the server anymore.";
		$msg["error"] = "Password update failed, account not found on the server.";
	}
}

echo json_encode($msg);
