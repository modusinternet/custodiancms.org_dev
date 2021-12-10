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
?><!DOCTYPE html>
<html lang="{CCMS_LIB:_default.php;FUNC:ccms_lng}">
	<head>
		<title><?= $CFG["DOMAIN"];?> | User | Dashboard</title>
		{CCMS_TPL:head-meta.html}
	</head>
	<style>
		{CCMS_TPL:/_css/head-css.html}

		p{margin:0 0 20px}

		.modal{
			background-color:var(--cl0);
			border:1px solid var(--cl2-tran);
			border-radius:6px;
			box-shadow:2px 2px 5px 0px rgba(0,0,0,.2);
			margin-bottom:20px
		}

		.modal>div{padding:10px 20px}

		.modal>div:first-child{
			background-color:var(--cl4);
			border-radius:6px 6px 0 0;
			color:var(--cl0)
		}
	</style>
	<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
		let navActiveItem = ["nav-dashboard"];
		let navActiveSub = [];
	</script>
	<body>
		<main style="padding:20px 20px 20px 0">
			<h1 style="padding-bottom:20px;margin:40px 0 20px;border-bottom:1px solid #eee">Dashboard</h1>

			<p>This section of the Custodian CMS admin is currently under development.</p>

			<div class="modal">
				<div>System Info</div>
				<div>
					<p>PHP Version: <?= phpversion();?></p>
					<p>System Address: <?= $_SERVER['SERVER_ADDR'];?></p>
					<p>Web Server: <?= $_SERVER['SERVER_ADDR'];?></p>






					<?php $a=explode(" ", $_SERVER["SERVER_SOFTWARE"]); echo $a[1];?>


				</div>
			</div>

			<div class="modal">
				<div>Security Logs</div>
				<div>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quid de Platone aut de Democrito loquar? Scisse enim te quis coarguere possit? Duo Reges: constructio interrete.</p>
				</div>
			</div>

			<div class="modal">
				<div>News</div>
				<div>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quid de Platone aut de Democrito loquar? Scisse enim te quis coarguere possit? Duo Reges: constructio interrete.</p>
				</div>
			</div>

			<ul>
				<li>HTML Minify</li>
				<li>Templates in Database Cache</li>
				<li>Clear Cache</li>
				<li>Backup/Restore</li>
				<li>Password Recovery attempts currently in the ccms_password_recovery table</li>
				<li></li>
				<li></li>
				<li></li>

				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin nec ligula id nisl fringilla finibus. Vestibulum rhoncus, felis at fringilla ullamcorper, ante mi tincidunt nunc, ac ultrices odio odio vitae lorem. Morbi quis elit id urna efficitur aliquam ut et sapien. Fusce porttitor vel ligula faucibus tempor. Pellentesque tincidunt imperdiet enim, id lobortis ipsum tempus id. In facilisis elementum dictum. Donec suscipit ornare tortor, sed volutpat mauris volutpat at. Pellentesque porttitor ut augue at ultrices. Proin egestas semper lorem quis suscipit. Vivamus eget magna tincidunt, semper sem eu, molestie quam. Praesent nisl velit, ultricies ac malesuada id, dapibus in dui. Mauris luctus velit non mi condimentum rhoncus. Nullam sit amet aliquet turpis, id malesuada nulla. Ut sit amet nisl nec ante commodo eleifend.



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
							loadFirst("/ccmsusr/_js/jquery-validate-1.19.3.min.js", function() {






$(() => {
	const menu = $('#menu-ctn'),
	bars = $('.menu-bars'),
	content = $('#menu-cnt');

	let firstClick = true,
	menuClosed = true;

	let handleMenu = event => {
		if(!firstClick) {
			bars.toggleClass('crossed hamburger');
		} else {
			bars.addClass('crossed');
			firstClick = false;
		}

		menuClosed = !menuClosed;
		content.toggleClass('dropped');
		event.stopPropagation();
	};

	menu.on('click', event => {
		handleMenu(event);
	});

	$('body').not('#menu-cnt, #menu-ctn').on('click', event => {
		if(!menuClosed) handleMenu(event);
	});

	$('#menu-cnt, #menu-ctn').on('click', event => event.stopPropagation());
});




/* When the user clicks on the svg button add the 'show' class to the dropdown box below it. */
$("#user_dropdown_btn").click(function() {
	$("#user_dropdown_list").addClass("show");
});

// Hide dropdown menu on click outside
$(document).on("click", function(e){
	if(!$(e.target).closest("#user_dropdown_btn").length){
		$("#user_dropdown_list").removeClass("show");
	}
});





							});
						});
					});
				});
			}
		</script>
	</body>
</html>
