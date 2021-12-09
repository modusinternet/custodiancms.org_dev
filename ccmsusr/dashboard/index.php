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

		.formDiv{
			background-color:var(--cl0);
			border:1px solid var(--cl2-tran);
			border-radius:6px;
			box-shadow:2px 2px 5px 0px rgba(0,0,0,.2)
		}

		.formDiv>div{padding:10px 20px}

		.formDiv>div:first-child{
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
		<main style="">


			<h1 style="padding-bottom: 9px;
margin: 40px 0 20px;
border-bottom: 1px solid #eee;">Dashboard</h1>
			<p>This section of the Custodian CMS admin is currently under development.</p>

			<div class="formDiv">
				<div>Security Logs</div>
				<div>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quid de Platone aut de Democrito loquar? Scisse enim te quis coarguere possit? Duo Reges: constructio interrete. </p>

<p>Contineo me ab exemplis. Non laboro, inquit, de nomine. Respondeat totidem verbis. Ego vero isti, inquam, permitto. Beatum, inquit. Primum quid tu dicis breve? </p>

<p>Summum ením bonum exposuit vacuitatem doloris; Tollitur beneficium, tollitur gratia, quae sunt vincla concordiae. Bonum incolumis acies: misera caecitas. Falli igitur possumus. </p>

<dl>
	<dt><dfn>Eam stabilem appellas.</dfn></dt>
	<dd>Huius ego nunc auctoritatem sequens idem faciam.</dd>
	<dt><dfn>Sullae consulatum?</dfn></dt>
	<dd>An vero displicuit ea, quae tributa est animi virtutibus tanta praestantia?</dd>
	<dt><dfn>Equidem e Cn.</dfn></dt>
	<dd>Rhetorice igitur, inquam, nos mavis quam dialectice disputare?</dd>
</dl>


<p>Suo genere perveniant ad extremum; Que Manilium, ab iisque M. Quam ob rem tandem, inquit, non satisfacit? In schola desinis. </p>

<p>Itaque his sapiens semper vacabit. Sed quod proximum fuit non vidit. Idem iste, inquam, de voluptate quid sentit? Nonne igitur tibi videntur, inquit, mala? Apparet statim, quae sint officia, quae actiones. De vacuitate doloris eadem sententia erit. </p>


				</div>
			</div>


			<ul>
				<li>About Custodian CMS</li>
				<li>Security Logs</li>
				<li>News</li>
				<li>System Info</li>


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
