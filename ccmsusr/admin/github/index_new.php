<?php
header("Content-Type: text/html; charset=UTF-8");
header("Expires: on, 01 Jan 1970 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if($_SERVER["SCRIPT_NAME"] != "/ccmsusr/index.php") {
	echo "This script can NOT be called directly.";
	die();
}

$qry = $CFG["DBH"]->prepare("SELECT * FROM `ccms_user` WHERE `id` = :id LIMIT 1;");
$qry->execute(array(':id' => $_SESSION["USER_ID"]));
$ccms_user = $qry->fetch(PDO::FETCH_ASSOC);



$msg = array();

// Test to see if shell_exce() is disabled.
if(!is_callable('shell_exec') && true === stripos(ini_get('disable_functions'), 'shell_exec')) {
	// shell_exce() is disabled.
	$msg["shell_exce"]["error"] = TRUE;
} else {
	// shell_exce() is enabled.
	// Test to see if git is installed.
	$output = trim(shell_exec("git --version"));

	// test to confirm git is installed.
	if(preg_match("/^git version .*/i", $output)) {
		// git is installed.
		$msg["git"]["version"] = $output;

		$output = trim(shell_exec("git status"));
		if($output == "") {
			 $output = "not a git repository";
		}
		if(preg_match("/not a git repository/i", $output)) {
			// git has not been setup to work with a repository under this directory yet.
			$msg["git"]["status"]["error"] = $output;
		} elseif(!preg_match("/nothing to commit/i", $output)) {
			// There is something wrong with this repository, you might need to access it from the commandline and add/commit/push unresolved files first.
			$msg["git"]["status"]["warning"] = $output;

			// build and easier list of problem files to read from.
			$output = trim(shell_exec("git status --porcelain | cut -c4-"));
			$msg["git"]["status2"]["output"] = $output;
		} else {
			// All is well, looks like there is nothing to commit here.
			$msg["git"]["status"] = $output;
		}

		$output = trim(shell_exec("git config --list"));
		$msg["git"]["config"] = $output;

		if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/.gitignore")) {
			$msg["gitignore"] = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/.gitignore");
		}
	} else {
		// git is NOT installed.
		$msg["git"]["error"] = $output;
	}
}
?><!DOCTYPE html>
<html lang="{CCMS_LIB:_default.php;FUNC:ccms_lng}">
	<head>
		<title><?= $_SERVER["SERVER_NAME"];?> | User | GitHub</title>
		{CCMS_TPL:head-meta.html}
	</head>
	<style>
		{CCMS_TPL:/_css/head-css.html}

		.inner_grid_general{grid-area:inner_grid_general}

		.inner_grid_address{grid-area:inner_grid_address}

		.inner_grid_contact{grid-area:inner_grid_contact}

		.inner_grid_other{grid-area:inner_grid_other}

		.inner_grid_login{grid-area:inner_grid_login}

		.inner_grid_general,
		.inner_grid_address,
		.inner_grid_contact,
		.inner_grid_other,
		.inner_grid_login{
			display:grid;
			grid-gap:8px
		}

		.inner_grid_general>h3,
		.inner_grid_address>h3,
		.inner_grid_contact>h3,
		.inner_grid_other>h3,
		.inner_grid_login>h3{
			margin:10px 0 0;
			text-align:center
		}

		.inner_grid_general>input,
		.inner_grid_address>input,
		.inner_grid_contact>input,
		.inner_grid_other>input,
		.inner_grid_login>input{height:fit-content}

		.inner_grid_general>label,
		.inner_grid_address>label,
		.inner_grid_contact>label,
		.inner_grid_other>label,
		.inner_grid_login>label{white-space:nowrap}

		.inner_grid_general>label.error,
		.inner_grid_address>label.error,
		.inner_grid_contact>label.error,
		.inner_grid_other>label.error,
		.inner_grid_login>label.error{
			text-align:center;
			white-space:unset;
			grid-column:unset
		}

		.outer_grid{
			display:grid;
			grid-gap:8px;
			grid-template-areas:
				"inner_grid_general"
				"inner_grid_address"
				"inner_grid_contact"
				"inner_grid_other"
		}

		.tabs{
			border-bottom:1px solid var(--cl3);
			overflow:hidden
		}

		.tabs button{
			background-color:var(--cl4);
			border-radius:4px 4px 0 0;
			color:var(--cl8);
			cursor:pointer;
			float:left;
			font-family:inherit;
			font-size:inherit;
			font-weight:inherit;
			margin-right:2px;
			outline:none;
			padding:14px 16px;
			transition:0.3s;
			width: unset
		}

		.tabs button:hover, .tabs button:hover svg path{
			background-color:var(--cl3);
			color:var(--cl0)
		}

		.tabs button.active, .tabs button.active svg path{
			background-color:var(--cl3);
			color:var(--cl0)
		}

		.tabs button:hover svg path{
			background-color:var(--cl4);
			fill:var(--cl0)
		}

		.tabs button.active svg path{
			background-color:var(--cl4);
			fill:var(--cl0)
		}

		.tabs button svg path{fill:var(--cl5)}

		.tabContent{
			display:none;
			padding:20px 0px
		}

		#tab03Content>div>ul{margin-left:20px}

		#tab03Content>div>ul li{padding-left:20px}


		/* 435px or wider. */
		@media only screen and (min-width:435px){
			.inner_grid_general,
			.inner_grid_address,
			.inner_grid_contact,
			.inner_grid_other,
			.inner_grid_login{grid-template-columns:100%}

			.inner_grid_general>label.error,
			.inner_grid_address>label.error,
			.inner_grid_contact>label.error,
			.inner_grid_other>label.error,
			.inner_grid_login>label.error{
				text-align:center;
				white-space:unset
			}
		}


		/* 600px or wider. */
		@media only screen and (min-width:600px){
			.inner_grid_general,
			.inner_grid_address,
			.inner_grid_contact,
			.inner_grid_other,
			.inner_grid_login{grid-template-columns:minmax(100px, 200px) 1fr}

			.inner_grid_other>button,
			.inner_grid_login>button{grid-column:1 / span 2}

			.inner_grid_login>div{grid-column:2 / 3}

			.inner_grid_general>h3,
			.inner_grid_address>h3,
			.inner_grid_contact>h3,
			.inner_grid_other>h3,
			.inner_grid_login>h3{grid-column:1 / span 2}

			.inner_grid_general>input,
			.inner_grid_address>input,
			.inner_grid_contact>input,
			.inner_grid_other>input,
			.inner_grid_login>input{grid-column:2 / 3}

			.inner_grid_general>label,
			.inner_grid_address>label,
			.inner_grid_contact>label,
			.inner_grid_other>label,
			.inner_grid_login>label{
				grid-column:1 / 2;
				text-align:right
			}

			.inner_grid_general>label.error,
			.inner_grid_address>label.error,
			.inner_grid_contact>label.error,
			.inner_grid_other>label.error,
			.inner_grid_login>label.error{grid-column:1 / span 2}
		}


		/* 950px or wider. */
		@media only screen and (min-width:950px){
			.outer_grid{
				display:grid;
				grid-gap:8px;
				grid-template-areas:
					"inner_grid_general inner_grid_address"
					"inner_grid_contact inner_grid_other"
			}
		}


		/* 1400px or wider. */
		@media only screen and (min-width:1400px){
			.outer_grid{
				display:grid;
				grid-gap:8px;
				grid-template-areas:
					"inner_grid_general inner_grid_address inner_grid_contact"
					"inner_grid_other inner_grid_other inner_grid_other"
			}
		}
	</style>
	<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
		/*var navActiveArray = ["admin","admin_nav","admin_blacklist_settings"];*/
		let navActiveItem = ["nav-admin","nav-admin-github"];
		let navActiveSub = [];
		/*let navActiveW3schoolsItem = ["nav-user_admin_blacklist_settings"];*/
	</script>
	<body>
		<main style="padding:20px 20px 20px 0">
			<h1 style="border-bottom:1px dashed var(--cl3)">Admin | GitHub</h1>
			<p>GitHub is the premier tool used by website developers and software engineers to collaborate on more than 100 million repositories and projects around the world.</p>

			<div class="tabs">
				<button class="tab active" id="tab01Title" role="tab">Status</button>
				<button class="tab" id="tab02Title" role="tab">Details</button>
				<button class="tab" id="tab03Title" role="tab">Setup</button>
			</div>






			<div id="tab01Content" class="tabContent" style="display:block">
				<div class="modal">
					<div>git status</div>
					<div>
<? if(isset($msg["shell_exce"]["error"])): ?>
						<p>Unable to call shell_exce().  Confirm your account has access to this function with your administrator before continuing.</p>
<? elseif(isset($msg["git"]["error"])): ?>
						<p>.git is either NOT installed or you do not have access to git from this account.  Confirm with your administrator before continuing.</p>
						<pre style="padding: 15px; margin: 15px 0px 20px;"><?=$msg["git"]["error"];?></pre>
<? else: ?>
	<? if(isset($msg["git"]["status"]["error"])): ?>
						<p>No .git repository setup in this directory or any of it's parent directories yet.  <a class="href-to-setup" href="#setup">Click here</a> to learn more about how to set up and connect this website to your own GitHub repository.</p>
						<pre style="padding:15px;margin:15px 0px 20px">fatal: not a git repository (or any of the parent directories): .git</pre>
	<? elseif(isset($msg["git"]["status"]["warning"])): ?>
						<p>There is something wrong with this repository, you might need to access it from the command-line and run add/commit/push manunally to fix it.</p>
						<pre style="padding: 15px; margin: 15px 0px 20px;"><?=$msg["git"]["status"]["warning"];?></pre>
						<p>(Easier to read file list, remember all files listed are located relative to the document root of your website.)</p>
						<pre style="padding: 15px; margin: 15px 0px 20px;"><?=$msg["git"]["status2"]["output"];?></pre>
						<p>Note: Pushing from your server to a GitHub repository is not recommended for security reasons which is why it is not an automated feature in Custodian CMS.  Use the two commands below if needed.</p>
						<p class="boxed">
							git commit -am "from server"<br>
							git push
						</p>
						<p>
							Note: Or, if all you want to do is overwrite a single file on your server with what's currently on the GitHub repo you can try the following command. (NOTE: You may need to navigate into the dir that contains the file you want to overwrite first.)
						</p>
						<p class="boxed">
							git checkout origin/master -- {filename}<br>
							git checkout -- .htaccess<br>
							git checkout origin/main -- ccmstpl/examples/index.html
						</p>
	<? else: ?>
					<pre style="padding: 15px; margin: 15px 0px 20px;"><?= $msg["git"]["status"];?></pre>
	<? endif ?>
<? endif ?>


					</div>
				</div>
















<? if(isset($msg["shell_exce"]["error"])): ?>
				<div class="panel panel-danger">
					<div class="panel-heading">Error</div>
					<div class="panel-body">
						<p>Unable to call shell_exce().  Confirm your account has access to this function with your administrator before continuing.</p>
					</div>
				</div>
<? elseif(isset($msg["git"]["error"])): ?>
				<div class="panel panel-danger">
					<div class="panel-heading">Error</div>
					<div class="panel-body">
						<p>.git is either NOT installed or you do not have access to git from this account.  Confirm with your administrator before continuing.</p>
						<pre style="padding: 15px; margin: 15px 0px 20px;"><?=$msg["git"]["error"];?></pre>
					</div>
				</div>
<? else: ?>
				<h2>git status</h2>
	<? if(isset($msg["git"]["status"]["error"])): ?>
				<div class="panel panel-danger">
					<div class="panel-heading">Error</div>
					<div class="panel-body">
						<p>No .git repository setup in this directory or any of it's parent directories yet.  <a class="href-to-setup" href="#setup">Click here</a> to learn more about how to set up and connect this website to your own GitHub repository.</p>
						<pre style="padding:15px;margin:15px 0px 20px">fatal: not a git repository (or any of the parent directories): .git</pre>
					</div>
				</div>
	<? elseif(isset($msg["git"]["status"]["warning"])): ?>
				<div class="panel panel-warning">
					<div class="panel-heading">Warning</div>
					<div class="panel-body">
						<p>There is something wrong with this repository, you might need to access it from the command-line and run add/commit/push manunally to fix it.</p>
						<pre style="padding: 15px; margin: 15px 0px 20px;"><?=$msg["git"]["status"]["warning"];?></pre>
						<p>(Easier to read file list, remember all files listed are located relative to the document root of your website.)</p>
						<pre style="padding: 15px; margin: 15px 0px 20px;"><?=$msg["git"]["status2"]["output"];?></pre>
						<p>Note: Pushing from your server to a GitHub repository is not recommended for security reasons which is why it is not an automated feature in Custodian CMS.  Use the two commands below if needed.</p>
						<p class="boxed">
							git commit -am "from server"<br>
							git push
						</p>
						<p>
							Note: Or, if all you want to do is overwrite a single file on your server with what's currently on the GitHub repo you can try the following command. (NOTE: You may need to navigate into the dir that contains the file you want to overwrite first.)
						</p>
						<p class="boxed">
							git checkout origin/master -- {filename}<br>
							git checkout -- .htaccess<br>
							git checkout origin/main -- ccmstpl/examples/index.html
						</p>
					</div>
				</div>
	<? else: ?>
				<div class="panel panel-success">
					<div class="panel-heading">Success</div>
					<div class="panel-body">
						<pre style="padding: 15px; margin: 15px 0px 20px;"><?=$msg["git"]["status"];?></pre>
					</div>
				</div>
	<? endif ?>
<? endif ?>
			</div>










			<div id="tab02Content" class="tabContent">

			</div>

			<div id="tab03Content" class="tabContent">

			</div>








			{CCMS_TPL:/footer.html}
		</main>

		{CCMS_TPL:/body-head.php}
		<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
			{CCMS_TPL:/_js/footer-1.php}

			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/custodiancms.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);

			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/metisMenu-3.0.6.min.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);

			function loadJSResources() {
				loadFirst("/ccmsusr/_js/jquery-3.6.0.min.js", function() {
					loadFirst("/ccmsusr/_js/metisMenu-3.0.7.min.js", function() {
						loadFirst("/ccmsusr/_js/custodiancms.js", function() {


							/* user_dropdown START */
							/* When the user clicks on the svg button add the 'show' class to the dropdown box below it. */
							$("#user_dropdown_btn").click(function() {
								$("#user_dropdown_list").addClass("show");
							});


							/* Hide dropdown menu on click outside */
							$(document).on("click", function(e){
								if(!$(e.target).closest("#user_dropdown_btn").length){
									$("#user_dropdown_list").removeClass("show");
								}
							});
							/* user_dropdown END */


							loadFirst("/ccmsusr/_js/jquery-validate-1.19.3.min.js", function() {
								loadFirst("/ccmsusr/_js/additional-methods-1.17.0.min.js", function() {




									document.getElementById("tab01Title").addEventListener("click", () => {
										let i, tabContent, tab;
										/* De-activate all tabs. */
										tab = document.getElementsByClassName("tab");
										for(i=0; i<tab.length; i++){
											tab[i].className = tab[i].className.replace(" active","");
										}
										/* Hide all tab content areas. */
										tabContent = document.getElementsByClassName("tabContent");
										for(i=0; i<tabContent.length; i++){
											tabContent[i].style.display = "none";
										}
										/* Activate the tab. */
										document.getElementById("tab01Title").className += " active";
										/* Display the content area for the above tab. */
										document.getElementById("tab01Content").style.display = "block";
									});


									document.getElementById("tab02Title").addEventListener("click", () => {
										let i, tabContent, tab;
										/* De-activate all tabs. */
										tab = document.getElementsByClassName("tab");
										for(i=0; i<tab.length; i++){
											tab[i].className = tab[i].className.replace(" active","");
										}
										/* Hide all tab content areas. */
										tabContent = document.getElementsByClassName("tabContent");
										for(i=0; i<tabContent.length; i++){
											tabContent[i].style.display = "none";
										}
										/* Activate the tab. */
										document.getElementById("tab02Title").className += " active";
										/* Display the content area for the above tab. */
										document.getElementById("tab02Content").style.display = "block";
									});


									document.getElementById("tab03Title").addEventListener("click", () => {
										let i, tabContent, tab;
										/* De-activate all tabs. */
										tab = document.getElementsByClassName("tab");
										for(i=0; i<tab.length; i++){
											tab[i].className = tab[i].className.replace(" active","");
										}
										/* Hide all tab content areas. */
										tabContent = document.getElementsByClassName("tabContent");
										for(i=0; i<tabContent.length; i++){
											tabContent[i].style.display = "none";
										}
										/* Activate the tab. */
										document.getElementById("tab03Title").className += " active";
										/* Display the content area for the above tab. */
										document.getElementById("tab03Content").style.display = "block";
									});




								});
							});
						});
					});
				});
			}
		</script>
	</body>
</html>
