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

if($CLEAN["firstname"] == "MAXLEN") {
	$msg = "'Firstname' field exceeded its maximum number of 64 character.";
} elseif($CLEAN["firstname"] == "INVAL") {
	$msg = "'Firstname' field contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";

} elseif($CLEAN["lastname"] == "MAXLEN") {
	$msg = "'Lastname' field exceeded its maximum number of 64 character.";
} elseif($CLEAN["lastname"] == "INVAL") {
	$msg = "'Lastname' field contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";

} elseif($CLEAN["alias"] == "") {
	$msg = "'Alias' field missing content.";
} elseif($CLEAN["alias"] == "MAXLEN") {
	$msg = "'Alias' field exceeded its maximum number of 32 character.";
} elseif($CLEAN["alias"] == "INVAL") {
	$msg = "'Alias' field contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";

} elseif($CLEAN["position"] == "MAXLEN") {
	$msg = "'Position' field exceeded its maximum number of 128 character.";
} elseif($CLEAN["position"] == "INVAL") {
	$msg = "'Position' field contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";

} elseif($CLEAN["address1"] == "MAXLEN") {
	$msg = "'Address Line 1' field exceeded its maximum number of 128 character.";
} elseif($CLEAN["address1"] == "INVAL") {
	$msg = "'Address Line 1' field contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";

} elseif($CLEAN["address2"] == "MAXLEN") {
	$msg = "'Address Line 2' field exceeded its maximum number of 128 character.";
} elseif($CLEAN["address2"] == "INVAL") {
	$msg = "'Address Line 2' field contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";

} elseif($CLEAN["prov_state"] == "MAXLEN") {
	$msg = "'Prov/State' field exceeded its maximum number of 32 character.";
} elseif($CLEAN["prov_state"] == "INVAL") {
	$msg = "'Prov/State' field contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";

} elseif($CLEAN["country"] == "MAXLEN") {
	$msg = "'Country' field exceeded its maximum number of 64 character.";
} elseif($CLEAN["country"] == "INVAL") {
	$msg = "'Country' field contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";

} elseif($CLEAN["post_zip"] == "MAXLEN") {
	$msg = "'Postal/Zip Code' field exceeded its maximum number of 32 character.";
} elseif($CLEAN["post_zip"] == "INVAL") {
	$msg = "'Postal/Zip Code' field contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";

} elseif($CLEAN["email"] == "") {
	$msg = "'Email' field missing content.";
} elseif($CLEAN["email"] == "MAXLEN") {
	$msg = "Please try to keep your 'Email' address to 255 characters or less.";
} elseif($CLEAN["email"] == "INVAL") {
	$msg = "Please enter a valid 'Email' address.";

} elseif($CLEAN["phone1"] == "MAXLEN") {
	$msg = "'Phone #1' field exceeded its maximum number of 64 character.";
} elseif($CLEAN["phone1"] == "INVAL") {
	$msg = "'Phone #1' field contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";

} elseif($CLEAN["phone2"] == "MAXLEN") {
	$msg = "'Phone #2' field exceeded its maximum number of 64 character.";
} elseif($CLEAN["phone2"] == "INVAL") {
	$msg = "'Phone #2' field contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";

} elseif($CLEAN["skype"] == "MAXLEN") {
	$msg = "'Skype' field exceeded its maximum number of 32 character.";
} elseif($CLEAN["skype"] == "INVAL") {
	$msg = "'Skype' field contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";

} elseif($CLEAN["facebook"] == "MAXLEN") {
	$msg = "'Facebook' field exceeded its maximum number of 128 character.";
} elseif($CLEAN["facebook"] == "INVAL") {
	$msg = "'Facebook' field contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";

} elseif($CLEAN["note"] == "MAXLEN") {
	$msg = "'Note' field exceeded its maximum number of 1024 character.";
} elseif($CLEAN["note"] == "INVAL") {
	$msg = "'Note' field contains invalid characters.  The following characters are not permitted in this field. ( > < & # )";
}

if(!$msg) {
	$qry = $CFG["DBH"]->prepare("UPDATE `ccms_user` SET `firstname` = :firstname, `lastname` = :lastname, `alias` = :alias, `position` = :position, `address1` = :address1, `address2` = :address2, `prov_state` = :prov_state, `country` = :country, `post_zip` = :post_zip, `email` = :email, `phone1` = :phone1, `phone2` = :phone2, `skype` = :skype, `facebook` = :facebook, `note` = :note WHERE `id` = :id LIMIT 1;");

	$qry->execute(array(':firstname' => $CLEAN["firstname"], ':lastname' => $CLEAN["lastname"], ':alias' => $CLEAN["alias"], ':position' => $CLEAN["position"], ':address1' => $CLEAN["address1"], ':address2' => $CLEAN["address2"], ':prov_state' => $CLEAN["prov_state"], ':country' => $CLEAN["country"], ':post_zip' => $CLEAN["post_zip"], ':email' => $CLEAN["email"], ':phone1' => $CLEAN["phone1"], ':phone2' => $CLEAN["phone2"], ':skype' => $CLEAN["skype"], ':facebook' => $CLEAN["facebook"], ':note' => $CLEAN["note"], ':id' => $_SESSION["USER_ID"] ));

	echo "1";
} else {
	echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style="margin-right: 10px;"></span>'.$msg;
}
