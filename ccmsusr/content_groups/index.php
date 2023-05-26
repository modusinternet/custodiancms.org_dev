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

/* Confirm privilages to access this page. */
$json_a = json_decode($_SESSION["PRIV"], true);
if(($json_a["content_groups"] ?? null) < 1) {
	echo "Access denied.";
	die();
}

?><!DOCTYPE html>
<html lang="{CCMS_LIB:_default.php;FUNC:ccms_lng}">
	<head>
		<title><?= $_SERVER["SERVER_NAME"];?> | User | Content Groups</title>
		{CCMS_TPL:head-meta.html}
	</head>
	<style>
		{CCMS_TPL:/_css/head-css.html}
	</style>
	<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
		let navActiveItem = ["nav-content_groups"];
		let navActiveSub = [];
		let navActiveW3schoolsItem = [];
	</script>
	<body>
		<main style="padding:20px 20px 20px 0">
			<h1 style="border-bottom:1px dashed var(--cl3)">Content Groups</h1>
			<p>This section is still under development, but if you come across any unresolved issues please let us know at: <a class="ccms_a" href="mailto:info@custodiancms.org?subject=unresolved+issue+report">info@custodiancms.org</a></p>



			{CCMS_TPL:/footer.html}
		</main>

		{CCMS_TPL:/body-head.php}
		<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
			{CCMS_TPL:/_js/footer-1.php}

			/*
			Argument details for ccms_build_js_link() and example_build_js_link() function calls:
			arg1 = (1 = append AWS link), (empty = do not append AWS link)
			arg2 = (1 = append language code to link), (empty = do not append language code to link)	In other words, send it through the parser first like a normal template. ie: https://yourdomain.com/en/somefile.css, adding the 'en' will push this template through the parser first before outputting it to the browser.
			arg3 = a variable found in the config file that represents a partial pathway to the style sheet, not including and details about AWS, language code, or language direction)
			arg4 = (1 = append language direction to link), (empty = do not append language direction to link)
			arg5 = Version number, this is very helpful when trying to update files like css and js that don't get called by serviceWorker after they are stored. (empty = do not append '?v=some_number' to the URL.)

			Argument details for example_build_js_sri() function calls:
			arg1 = 1 = build sri code based on version stored on AWS.  empty = build sri code based on version stored on our own server.
			arg2 = a variable found in the config file that represents a partial pathway to the style sheet. (Not including details about AWS, language code, or language direction)
			*/
			{CCMS_LIB:_default.php;FUNC:ccms_build_css_link("","","CSS-02","","")}
			{CCMS_LIB:_default.php;FUNC:ccms_build_css_link("","","metisCSS","","")}

			function loadJSResources() {
				loadFirst("{CCMS_LIB:_default.php;FUNC:ccms_build_js_link("","","JQUERY","","")}", function() {
					loadFirst("/ccmsusr/_js/metisMenu-3.0.7.min.js", function() {
						loadFirst("/ccmsusr/_js/custodiancms.js", function() {
							loadFirst("/ccmsusr/_js/jquery-validate-1.19.3.min.js", function() {
								loadFirst("/ccmsusr/_js/additional-methods-1.17.0.min.js", function() {




								});
							});
						});
					});
				});
			}
		</script>
	</body>
</html>



<?php
header("Content-Type: text/html; charset=UTF-8");
header("Expires: on, 01 Jan 1970 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if($_SERVER["SCRIPT_NAME"] != "/ccmsusr/index.php") {
	echo "This script can NOT be called directly.";
	exit;
}
?><!DOCTYPE html>
<html lang="{CCMS_LIB:_default.php;FUNC:ccms_lng}">
	<head>
		<meta charset="utf-8">
		<title><?= $CFG["DOMAIN"];?> | User | Content Groups</title>
		{CCMS_TPL:head-meta.html}
		<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
			var navActiveItem = ["nav-content_groups"];
		</script>
	</head>
	<body>
		<div id="wrapper">



			<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">
							<div class="navbar-header" style="width: 100%;">
								<button class="btn btn-default btn-xs" data-toggle="button" id="menu-toggle" style="padding: 8px 10px; position: absolute; left: 250px; top: 7px;" title="Navigation Toggle" type="button">
									<i class="fa fa-exchange fa-fw" style="font-size: 1.6em;"></i>
								</button>
								<button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse" type="button">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<ul class="nav navbar-top-links" style="float: right;">
									<li class="dropdown">
										<a class="dropdown-toggle line-height-1-4" data-toggle="dropdown" href="#">
											<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
										</a>
										<ul class="dropdown-menu dropdown-user">
											<li id="user_profile">
												<a href="/en/user/user_profile/"><i class="fa fa-user fa-fw"></i> User Profile</a>
											</li>
											<li>
												<a href="/{CCMS_LIB:_default.php;FUNC:ccms_lng}/?ccms_token={CCMS_LIB:_default.php;FUNC:ccms_token}"><i class="fa fa-home fa-fw"></i> Back to Homepage</a>
											</li>
											<li class="divider"></li>
											<li>
												<a href="/en/user/login.html?logout=1"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
											</li>
										</ul>
									</li>
								</ul>
								<a class="navbar-brand line-height-1-4" href="/en/user/" style="padding: 3px 0 0 0;">
									<img alt="Custodian CMS Banner" src="/{CCMS_LIB:_default.php;FUNC:ccms_cfgUsrDir}/_img/ccms-535x107.png" style="height: 45px;" title="Custodian CMS Bannver.  Easy gears no spilled beers.">
								</a>
							</div>

							<div id="sidebar-wrapper">
								<div class="navbar-default sidebar" role="navigation">
									<div class="sidebar-nav navbar-collapse">
										<ul class="nav" id="side-menu">
											<li>
												<a class="line-height-1-4" id="dashboard" href="/en/user/dashboard/">
													<i class="fa fa-dashboard fa-fw"></i> Dashboard
												</a>
											</li>
											<li id="admin">
												<a class="line-height-1-4" id="admin_nav" href="#">
													<i class="fa fa-cogs fa-fw"></i> Admin <span class="fa arrow"></span>
												</a>
												<ul class="nav nav-second-level">
													<li>
														<a class="line-height-1-4" id="admin_user_privileges" href="/en/user/admin/user_privileges/">
															<i class="fa fa-user fa-fw"></i> User Privileges
														</a>
													</li>
													<li>
														<a class="line-height-1-4" id="admin_language_support" href="/en/user/admin/language_support/">
															<i class="fa fa-language fa-fw"></i> Language Support
														</a>
													</li>
													<li>
														<a class="line-height-1-4" id="admin_blacklist_settings" href="/en/user/admin/blacklist_settings/">
															<i class="fa fa-shield fa-fw"></i> Blacklist Settings
														</a>
													</li>
												</ul>
											</li>
											<li>
												<a class="line-height-1-4" id="content_manager" href="/en/user/content_manager/">
													<i class="fa fa-pencil-square-o fa-fw"></i> Content Manager
												</a>
											</li>
											<li>
												<a class="line-height-1-4" id="content_groups" href="/en/user/content_groups/">
													<i class="fa fa-picture-o fa-fw"></i> Content Groups
												</a>
											</li>
											<li>
												<a class="line-height-1-4" id="github" href="/en/user/github/">
													<i class="fa fa-github fa-fw"></i> GitHub
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</nav>



			<div id="page-wrapper">
				<div class="row">
					<div class="col-md-12">
						<h1 class="page-header">Content Groups</h1>
						<div class="panel panel-danger">
							<div class="panel-heading">
								Notice
							</div>
							<div class="panel-body">
								<p>This section of the Custodian CMS admin is currently under development.</p>
							</div>
						</div>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin nec ligula id nisl fringilla finibus. Vestibulum rhoncus, felis at fringilla ullamcorper, ante mi tincidunt nunc, ac ultrices odio odio vitae lorem. Morbi quis elit id urna efficitur aliquam ut et sapien. Fusce porttitor vel ligula faucibus tempor. Pellentesque tincidunt imperdiet enim, id lobortis ipsum tempus id. In facilisis elementum dictum. Donec suscipit ornare tortor, sed volutpat mauris volutpat at. Pellentesque porttitor ut augue at ultrices. Proin egestas semper lorem quis suscipit. Vivamus eget magna tincidunt, semper sem eu, molestie quam. Praesent nisl velit, ultricies ac malesuada id, dapibus in dui. Mauris luctus velit non mi condimentum rhoncus. Nullam sit amet aliquet turpis, id malesuada nulla. Ut sit amet nisl nec ante commodo eleifend.


					</div>
				</div>
			</div>
		</div>

		<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
			function loadFirst(e,t){var a=document.createElement("script");a.async = true;a.readyState?a.onreadystatechange=function(){("loaded"==a.readyState||"complete"==a.readyState)&&(a.onreadystatechange=null,t())}:a.onload=function(){t()},a.src=e,document.body.appendChild(a)}

			var cb = function() {
				var l = document.createElement('link'); l.rel = 'stylesheet';
				l.href = "/ccmsusr/_css/bootstrap-3.3.7.min.css";
				var h = document.getElementsByTagName('head')[0]; h.parentNode.insertBefore(l, h);

				var l = document.createElement('link'); l.rel = 'stylesheet';
				l.href = "/ccmsusr/_css/metisMenu-2.4.0.min.css";
				var h = document.getElementsByTagName('head')[0]; h.parentNode.insertBefore(l, h);

				var l = document.createElement('link'); l.rel = 'stylesheet';
				l.href = "/ccmsusr/_css/custodiancms-old.css";
				/*l.href = "/ccmsusr/_css/custodiancms.min.css";*/
				var h = document.getElementsByTagName('head')[0]; h.parentNode.insertBefore(l, h);

				var l = document.createElement('link'); l.rel = 'stylesheet';
				l.href = "/ccmsusr/_css/font-awesome-4.7.0.min.css";
				var h = document.getElementsByTagName('head')[0]; h.parentNode.insertBefore(l, h);
			};

			var raf = requestAnimationFrame || mozRequestAnimationFrame || webkitRequestAnimationFrame || msRequestAnimationFrame;
			if (raf) raf(cb);
			else window.addEventListener('load', cb);

			function loadJSResources() {
				//loadFirst("/ccmsusr/_js/jquery-2.2.0.min.js", function() {
				loadFirst("/ccmsusr/_js/jquery-3.6.0.min.js", function() {
					loadFirst("/ccmsusr/_js/bootstrap-3.3.7.min.js", function() {
						loadFirst("/ccmsusr/_js/metisMenu-2.4.0.min.js", function() {
							loadFirst("/ccmsusr/_js/custodiancms.js", function() {
							//loadFirst("/ccmsusr/_js/custodiancms.min.js", function() {

								// Load MetisMenu
								$('#side-menu').metisMenu();

								// Fade in web page.
								//$("#no-fouc").delay(200).animate({"opacity": "1"}, 500);

								$("#menu-toggle").click(function(e) {
									e.preventDefault();
									$("#wrapper").toggleClass("toggled");
									$("#wrapper.toggled").find("#sidebar-wrapper").find(".collapse").collapse("hide");
									$("#sidebar-wrapper").toggle();
								});


							});
						});
					});
				});
			}

			if (window.addEventListener)
				window.addEventListener("load", loadJSResources, false);
			else if (window.attachEvent)
				window.attachEvent("onload", loadJSResources);
			else window.onload = loadJSResources;
		</script>
	</body>
</html>
