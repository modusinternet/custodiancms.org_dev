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

?><!DOCTYPE html>
<html lang="{CCMS_LIB:_default.php;FUNC:ccms_lng}">
	<head>
		<title><?= $_SERVER["SERVER_NAME"];?> | User | Blacklist Settings</title>
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
		let navActiveItem = [];
		let navActiveSub = [];
		//let navActiveW3schoolsItem = ["nav-user_admin_blacklist_settings"];
	</script>
	<body>
		<main style="padding:20px 20px 20px 0">
			<h1 style="border-bottom:1px dashed var(--cl3)">Admin | Blacklist Settings</h1>
			<p>This section is still under development, but if you come across any unresolved issues please let us know at: <a class="ccms_a" href="mailto:info@custodiancms.org?subject=unresolved+issue+report">info@custodiancms.org</a></p>



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
				/*loadFirst("/ccmsusr/_js/jquery-2.2.0.min.js", function() {*/
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




								});
							});
						});
					});
				});
			}
		</script>
	</body>
</html>
