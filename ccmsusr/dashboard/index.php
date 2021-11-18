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

#menu-ctn {
	cursor:pointer;
	float:right;
	height:40px;
	margin:10px;
	/*
	position:absolute;
	right:20px;
	top:20px;
	*/
}

#menu-cnt {
  display:none;
	position:fixed;
	top:80px;
	left:0px;
	height:80%;
	overflow:auto
}

#menu-cnt svg{
	width:30px;
	position:relative;
	top:5px;
}

#menu-cnt a>svg>path{fill:var(--cl0)}

/* ELEMENT PROPERTIES */
.menu-bars {
  height: 4px;
  width: 30px;
  list-style: none;
  background: var(--cl4);
  margin: 0 7px;
  position: relative;
  top: 18px;
  transition: 0.4s all ease-in;
}

.crossed {
  background: var(--cl1);
}

.dropped{
	display:block!important;
	transition:0.4s all ease-in
}

.menu-bars::before, .menu-bars::after {
  content: '';
  position: absolute;
  height: 4px;
  width: 30px;
  list-style: none;
  background: var(--cl4);
}

.menu-bars::before {
  transform: translateY(-10px);
}

.menu-bars::after {
  transform: translateY(10px);
}

.crossed::before {
  animation: rotate-top-bar 0.4s forwards;
}

.crossed::after {
  animation: rotate-bottom-bar 0.4s forwards;
}

.hamburger::before {
  animation: rotate-top-bar-2 0.4s reverse;
}

.hamburger::after {
  animation: rotate-bottom-bar-2 0.4s reverse;
}

#menu-ctn{filter:drop-shadow(2px 2px 4px rgba(0,0,0,.2))}

/* ANIMATION KEYFRAMES */
@keyframes rotate-top-bar {
  40% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(0) rotate(45deg);
  }
}

@keyframes rotate-bottom-bar {
  40% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(0) rotate(-45deg);
  }
}

@keyframes rotate-top-bar-2 {
  40% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(0) rotate(45deg);
  }
}

@keyframes rotate-bottom-bar-2 {
  40% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(0) rotate(-45deg);
  }
}





#user_dropdown_btn>*{pointer-events:none}


	</style>
	<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
		let navActiveItem = ["nav-dashboard"];
		let navActiveSub = [];
	</script>
	<body>
		<main style="">


			<h1>Dashboard</h1>
			<p>This section of the Custodian CMS admin is currently under development.</p>
			<ul>
				<li>Security Alerts</li>
				<li>Access Logs</li>
				<li>System Info</li>
				<li>HTML Minify</li>
				<li>Cache Rendered Templates in Database</li>
				<li>Clear Cache</li>
				<li>About Custodian CMS</li>
				<li>News</li>
				<li>Content Changes/Updates</li>
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




/* When the user clicks on the svg button, toggle between hiding and showing the dropdown content */
/*
document.getElementById("user_dropdown_btn").addEventListener("click",function(){
	document.getElementById("user_dropdown").classList.toggle("show");
});
*/

document.addEventListener("click", function (event) {
	if(!event.target.closest("#user_dropdown_btn")) return;
	document.getElementById("user_dropdown").classList.toggle("show");
}, false);






// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
	if(!event.target.matches('.dropbtn')){
		var dropdowns = document.getElementsByClassName("dropdown-content");
		var i;
		for(i=0;i<dropdowns.length;i++){
			var openDropdown = dropdowns[i];
			if(openDropdown.classList.contains('show')){
				openDropdown.classList.remove('show');
			}
		}
	}
}






							});
						});
					});
				});
			}
		</script>
	</body>
</html>
