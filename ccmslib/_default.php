<?php
function ccms_cfgDomain() {
	global $CFG;
	echo $CFG["DOMAIN"];
}


function ccms_cfgLibDir() {
	global $CFG;
	echo $CFG["LIBDIR"];
}


function ccms_cfgPreDir() {
	global $CFG;
	echo $CFG["PREDIR"];
}


function ccms_cfgTplDir() {
	global $CFG;
	echo $CFG["TPLDIR"];
}


function ccms_cfgUsrDir() {
	global $CFG;
	echo $CFG["USRDIR"];
}


function ccms_cfgCookieSessionExpire() {
	global $CFG;
	echo $CFG["COOKIE_SESSION_EXPIRE"];
}


function ccms_csp_nounce() {
	global $CFG;
	echo $CFG["nonce"];
}


function ccms_csp_nounce_ret() {
	global $CFG;
	return $CFG["nonce"];
}


function ccms_googleRecapPubKey() {
	global $CFG;
	echo $CFG["GOOGLE_RECAPTCHA_PUBLICKEY"];
}

function ccms_googleCredKey() {
	global $CFG;
	echo $CFG["GOOGLE_CREDENTIALS_KEY"];
}

function ccms_hrefLang_list() {
	// International targeting by listing alternate language pages.
	// https://support.google.com/webmasters/answer/189077
	// DONT FORGET to add <link rel="alternate" hreflang="x-default" href="//{CCMS_LIB:_default.php;FUNC:ccms_cfgDomain}/">
	// on your homepage below the area where this content is being generated.  It only needs to be on the home page.
	global $CFG, $CLEAN;

	$tpl1 = htmlspecialchars(preg_replace('/^\/([\pL\pN\-]*)\/?(.*)\z/i', '${2}', $_SERVER['REQUEST_URI']));
	echo "<link rel=\"alternate\" hreflang=\"x-default\" href=\"" . $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"] . "/" . $CFG["DEFAULT_SITE_CHAR_SET"] . "/" . $tpl1 . "\">";
	$qry1 = $CFG["DBH"]->prepare("SELECT * FROM `ccms_lng_charset` WHERE `status` = 1 ORDER BY lngDesc ASC;");
	if($qry1->execute()) {
		while($row = $qry1->fetch()) {
			if($row["ptrLng"]) {
				if($row["ptrLng"] != $CLEAN["ccms_lng"]) {
					// Make sure to show pointers to languages that we are currently not looking at.
					echo "<link rel=\"alternate\" hreflang=\"" . $row["ptrLng"] . "\" href=\"" . $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"] . "/" . $row["ptrLng"] . "/" . $tpl1 . "\">";
				}
			} else {
				if($row["lng"] != $CLEAN["ccms_lng"]) {
					// Make sure to show pointers to languages that we are currently not looking at.
					echo "<link rel=\"alternate\" hreflang=\"" . $row["lng"] . "\" href=\"" . $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"] . "/" . $row["lng"] . "/" . $tpl1 . "\">";
				}
			}
		}
	}
}

function ccms_canonical() {
	global $CFG, $CLEAN;

	// Only use this feature on the homepage to help prevent dupicate indexing attempts
	// by search engines when dealing with language dir.
	// ie:
	// https://yourdomain.com
	// vs
	// https://yourdomain.com/en/
	//
	// Both would contain the same content so we want Google to not index the normal domain, an index the one containing the /en/ dir instead.
	// The reason for this is, depending on what language page your currently viewing a site in, (eg: /en/, /fr/, /sp/). the root page
	// content will look exactly the same, when using CustodianCMS, as the one found in the language specific sub dir.
	// ie:
	// https://somedomain.com and https://somedomain.com/cx/
	//
	// We need to tell search engines not to index the content on the https://somedomain.com but go ahead and index the content on the
	// https://somedomain.com/cx/ page.

	if($_SERVER['REQUEST_URI'] === "/"){
		// if the visitor is looking at the root of the website WITHOUT the language dir.
		// ie: https://yourdomain.com
		echo '<meta name="robots" content="noindex" />';
		echo '<link rel="canonical" href="' . $_SERVER['REQUEST_SCHEME'] . "://" . $CFG["DOMAIN"] . "/" . $CLEAN["ccms_lng"] . '/" />';
	} else {
		// if the visitor is looking at the root of the website WITH the language dir.
		// ie: https://yourdomain.com/en/
		echo '<link rel="canonical" href="' . $_SERVER['REQUEST_SCHEME'] . "://" . $CFG["DOMAIN"] . $_SERVER['REQUEST_URI'] . '" />';
	}
}





























function ccms_user_admin_slider() {
	global $CFG, $CLEAN;

	/*
	$qry = $CFG["DBH"]->prepare("SELECT b.alias, b.priv FROM `ccms_session` AS a INNER JOIN `ccms_user` AS b On b.id = a.user_id WHERE a.code = :code AND a.ip = :ip AND b.status = '1' LIMIT 1;");
	$qry->execute(array(':code' => $CLEAN["SESSION"]["code"], ':ip' => $_SERVER["REMOTE_ADDR"]));
	$row = $qry->fetch(PDO::FETCH_ASSOC);
	if($row) {
		//$CFG['loggedIn'] = TRUE;
		$CLEAN['alias'] = $row["alias"];
		//echo $CLEAN["CCMS_DB_Preload_Content"]["all"]["login2"][$CLEAN["ccms_lng"]]["content"] . ": <a href='/" . $CLEAN["ccms_lng"] . "/user/'>" . $row["alias"] . "</a> (<a href='/" . $CLEAN["ccms_lng"] . "/user/?logout=1'>" . $CLEAN["CCMS_DB_Preload_Content"]["all"]["login3"][$CLEAN["ccms_lng"]]["content"] . "</a>)";
		$json_a = json_decode($row["priv"], true);
		$json_a[priv][content_manager][r] == 1 ? $CFG['loggedIn'] = TRUE : $CFG['loggedIn'] = FALSE;
	} else {
		$CFG['loggedIn'] = FALSE;
		//echo "<a href='/" . $CLEAN["ccms_lng"] . "/user/'>" . $CLEAN["CCMS_DB_Preload_Content"]["all"]["login1"][$CLEAN["ccms_lng"]]["content"] . "</a>";
	}
	//echo $CLEAN["CCMS_DB_Preload_Content"]["all"]["login2"][$CLEAN["ccms_lng"]]["content"] . ": <a href='/" . $CLEAN["ccms_lng"] . "/user/'>" . $row["alias"] . "</a> (<a href='/" . $CLEAN["ccms_lng"] . "/user/?logout=1'>" . $CLEAN["CCMS_DB_Preload_Content"]["all"]["login3"][$CLEAN["ccms_lng"]]["content"] . "</a>)";
	if($CFG['loggedIn'] == TRUE) { ?>
	*/


	if(isset($_SESSION["USER_ID"])) {
		$json_a = json_decode($_SESSION["PRIV"], true);
	}

	//$json_a[priv][content_manager][r] == 1 ? $CFG['loggedIn'] = TRUE : $CFG['loggedIn'] = FALSE;

	if(($json_a["priv"]["content_manager"]["r"] ?? null) === 1): ?>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" charset="utf-8">
<style>
	#CCMSTab-slide{position:fixed;top:90px;right:0;z-index:99999999;font: 16px/1.8 'Open Sans';-webkit-transition-duration:.3s;-moz-transition-duration:.3s;-o-transition-duration:.3s;transition-duration:.3s;box-shadow:10px 10px 10px #888}#CCMSTab-slide-tab{position:relative;top:0;left:0;display:inline;padding:12px 6px 12px 12px;text-align:center;background:#86B135;color:#fff;cursor:pointer;-webkit-border-radius:5px 0 0 5px;-moz-border-radius:5px 0 0 5px;border-radius:5px 0 0 5px}#CCMSTab-slide-outer{position:absolute;top:-70px;left:35px;width:265px;background:#86B135;border-radius:5px 0 0 5px;box-shadow:10px 5px 10px #888;-webkit-border-radius:5px 0 0 5px;-moz-border-radius:5px 0 0 5px;}#CCMSTab-slide-inner{color:#fff;margin:15px;}#CCMSTab-slide-tab-checkbox:checked + #CCMSTab-slide{right:265px}#CCMSTab-slide-tab-checkbox{display:none}.CCMSTab-slide-header{font-size:18px;font-weight:700;text-align:center;color:inherit;border-bottom:1px solid #fff;padding-bottom:10px;margin-bottom:20px}#CCMSEdit-edit-mode-switch,#CCMSEdit-edit-mode-switch > p{color:inherit}#CCMSEdit-edit-mode-switch > p{float:right!important}#CCMSEdit-edit-mode-switch > p > label{float:left!important}#CCMSEdit-edit-mode-switch-label{position:relative;top:-7px;display:inline-block;width:60px;height:34px}#CCMSEdit-edit-mode-switch-label input{display:none}.slider{position:absolute;cursor:pointer;top:4px;left:0;right:0;bottom:-3px;background-color:#ccc;-webkit-transition:.4s;transition:.4s}.slider:before{position:absolute;content:"";height:26px;width:26px;left:4px;bottom:4px;background-color:#fff;-webkit-transition:.4s;transition:.4s}#CCMSEdit-edit-mode-switch-label input{display:none}#CCMSEdit-edit-mode-switch-label input:checked + .slider{background-color:#A2D345}#CCMSEdit-edit-mode-switch-label input:focus + .slider{box-shadow:0 0 1px #A2D345}#CCMSEdit-edit-mode-switch-label input:checked + .slider:before{-webkit-transform:translateX(26px);-ms-transform:translateX(26px);transform:translateX(26px)}.slider.round{border-radius:34px}.slider.round:before{border-radius:50%}#CCMSlng-list{list-style:none;margin:0 0 15px 0;padding:0;max-height:200px;overflow-y:scroll;overflow-x:hidden;width:100%}#CCMSlng-list li{margin:5px 0;}#CCMSlng-list li > a:link,#CCMSlng-list li > a:visited{color:#fff;text-decoration:none}#CCMSlng-list li > a:hover,#CCMSlng-list li > a:active{color:#fff;text-decoration:none;border-bottom:1px solid #fff}@media (max-height:340px){#CCMSlng-list{max-height:90px;overflow-y:scroll;overflow-x:hidden}}.CCMSEdit-logout:link,.CCMSEdit-logout:visited{color:#fff;font-size:22px;text-decoration:none}.CCMSEdit-logout:hover,.CCMSEdit-logout:active{color:#fff;text-decoration:none}.CCMS-wrap{position:relative}.CCMSEdit-edit-link-border{border:1px dashed #86B135;padding:30px 10px 0 5px;display:block;background-color:#E5F2CD}.CCMS-editor-but{position:absolute;top:-10px;right:20px;z-index:9999999;padding:4px 8px;font-size:16px;line-height:1.5;border-radius:3px;color:#fff;background-color:#86B135;border:1px solid transparent;cursor:pointer;vertical-align:middle;text-align:center;box-shadow:5px 5px 10px #888}.CCMS-editor-savebut{right:110px}.CCMS-editor-textarea{width:99%;overflow-y:auto;font-family:inherit;font-style:inherit;font-variant:inherit;font-weight:inherit;font-stretch:inherit;font-size:inherit;line-height:inherit;resize:both}.hidden{display:none}#CCMS-loadingSpinner{display:none;position:absolute;background:#fff}#CCMS-loadingSpinner-load{position:absolute}#CCMSEdit-edit-mode-lng{width:100%;height:34px;padding:6px 12px;margin-bottom:10px;font-size:14px;line-height:1.42857143;color:#555;background-color:#fff;background-image:none;border:1px solid #ccc;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s}
</style>
<input type="checkbox" id="CCMSTab-slide-tab-checkbox" onclick="ccms_tab_switch();">
<div id="CCMSTab-slide">
	<label id="CCMSTab-slide-tab" for="CCMSTab-slide-tab-checkbox" title="User Admin Slider">
		<i class="fa fa-cogs fa-spin"></i>
	</label>
	<div id="CCMSTab-slide-outer">
	<div id="CCMSTab-slide-inner">
		<div class="CCMSTab-slide-header">User Admin Slider</div>
		<div id="CCMSEdit-edit-mode-switch">
			<p>Edit Mode</p>
			<label id="CCMSEdit-edit-mode-switch-label">
				<input id="CCMSEdit-edit-mode-switch-check" type="checkbox" onclick="ccms_edit_mode_switch();">
				<span class="slider round"></span>
			</label>
		</div>
		<ul id="CCMSlng-list">
		<?php
		$tpl = htmlspecialchars(preg_replace('/^\/([\pL\pN-]*)\/?(.*)\z/i', '${2}', $_SERVER['REQUEST_URI']));
		$qry = $CFG["DBH"]->prepare("SELECT * FROM `ccms_lng_charset` ORDER BY lngDesc ASC;");
		if($qry->execute()) {
			while($row = $qry->fetch()) {
				if($json_a["priv"]["content_manager"]["lng"][$row["lng"]] == 1 || $json_a["priv"]["content_manager"]["lng"][$row["lng"]] == 2) {
					if($row["ptrLng"]) {
						echo "\t\t\t<li id=\"ccms-lng-" . $row["lng"] . "\" onclick=\"ccms_lcu('" . $row["ptrLng"] . "');\" title=\"Points to lng code: " . $row["ptrLng"] . "\"><a href=\"/" . $row["ptrLng"] . "/" . $tpl . "\">" . $row["lngDesc"] . "</a></li>\n";
					} else {
						echo "\t\t\t<li id=\"ccms-lng-" . $row["lng"] . "\" onclick=\"ccms_lcu('" . $row["lng"] . "');\" title=\"lng code: " . $row["lng"] . "\"><a href=\"/" . $row["lng"] . "/" . $tpl . "\">" . $row["lngDesc"] . "</a></li>\n";
					}
				}
			}
		}
		?>
		</ul>
		<div id="CCMSEdit-user">
			<a class="CCMSEdit-alias" href="/<?php echo $CLEAN["ccms_lng"]; ?>/user/" title="Dashboard">
				<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24"><path fill="#fff" d="M10,13H4a1,1,0,0,0-1,1v6a1,1,0,0,0,1,1h6a1,1,0,0,0,1-1V14A1,1,0,0,0,10,13ZM9,19H5V15H9ZM20,3H14a1,1,0,0,0-1,1v6a1,1,0,0,0,1,1h6a1,1,0,0,0,1-1V4A1,1,0,0,0,20,3ZM19,9H15V5h4Zm1,7H18V14a1,1,0,0,0-2,0v2H14a1,1,0,0,0,0,2h2v2a1,1,0,0,0,2,0V18h2a1,1,0,0,0,0-2ZM10,3H4A1,1,0,0,0,3,4v6a1,1,0,0,0,1,1h6a1,1,0,0,0,1-1V4A1,1,0,0,0,10,3ZM9,9H5V5H9Z"/></svg>
				<!-- a href="https://iconscout.com/">Unicons by Iconscout</a -->
			</a>
			<span>
				<a class="CCMSEdit-logout" href="/<?php echo $CLEAN["ccms_lng"]; ?>/user/?ccms_logout=1" title="<?php echo $CLEAN["CCMS_DB_Preload_Content"]["all"]["login3"][$CLEAN["ccms_lng"]]["content"]; ?>">
					<i class="fa fa-sign-out fa-fw"></i>
				</a>
			</span>
		</div>
	</div>
	</div>
</div>
<div id="CCMS-loadingSpinner">
  <i class="fa fa-spinner fa-spin fa-5x" id="CCMS-loadingSpinner-load" aria-hidden="true"></i>
</div>
















	<?php endif;
}




function ccms_dateYear() {
	echo date("Y");
}


function ccms_lng() {
	global $CLEAN;
	echo $CLEAN["ccms_lng"];
}


function ccms_lng_ret() {
	/* Used to return a value without submitting it to a template buffer prematurely. */
	global $CLEAN;
	return $CLEAN["ccms_lng"];
}


function ccms_lng_dir() {
	global $CFG;
	echo $CFG["CCMS_LNG_DIR"];
}


function ccms_lng_dir_ret() {
	/* Used to return a value without submitting it to a template buffer prematurely. */
	global $CFG;
	return $CFG["CCMS_LNG_DIR"];
}


function ccms_token() {
	echo md5(time());
}


function ccms_printrClean() {
	global $CLEAN;
	echo "<br />\$CLEAN=[<pre>";
	print_r($CLEAN);
	echo "</pre>]\n";
}


function ccms_version() {
	global $CFG;
	echo $CFG["VERSION"];
}


function ccms_release_date() {
	global $CFG;
	echo $CFG["RELEASE_DATE"];
}


function ccms_tpl() {
	global $CLEAN;
	echo $CLEAN["ccms_tpl"];
}


function _phpinfo() {
	return phpinfo();
}


function ccms_badIPCheck($ip) {
	global $CFG;

	$qry = $CFG["DBH"]->prepare("SELECT * FROM `ccms_blacklist` WHERE `id` = 1;");
	$qry->execute();
	$row = $qry->fetch(PDO::FETCH_ASSOC);

	if(isset($row["data"])) {
		if(strstr($row["data"], $ip)) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}


function bad_word_check($sentence) {
	global $CFG;
	$qry = $CFG["DBH"]->prepare("SELECT * FROM ccms_blacklist;");
	$qry->execute();
	$qry->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $qry->fetch()) {
		if($row["id"] == 1) {
			$badIPAddressData = $row["data"];
		} elseif($row["id"] == 2) {
			$badWordData = $row["data"];
		}
	}
	$found = 0;
	$pos = false;
	$word_array = explode("|", $badWordData);
	foreach($word_array as $the_word) {
		$pos = @strpos(strtoupper($sentence), strtoupper($the_word));
		if($pos !== false) {
			$found = 1;
			break;
		}
	}
	if($found == 1) {
		return false;
	} else {
		return true;
	}
}
