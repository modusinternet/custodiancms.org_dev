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

		/*
		.cssGrid-Dashboard-01>{grid-area:c1}
		.cssGrid-Dashboard-01>{grid-area:c2}
		*/

		.cssGrid-Dashboard-01{
			display:grid;
			grid-gap:1em;
			/*
			grid-template-areas:
				"c1"
				"c2"
			*/
		}

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

		#ccms_news_items{padding-left:30px}
		#ccms_news_items li{margin-bottom:10px}

		/* 824px or larger. Pixel Xl Landscape resolution is 411 x 823. */
		/* 875px or larger. Pixel Xl Landscape resolution is 411 x 823. */
		@media only screen and (min-width: 875px){
			.cssGrid-Dashboard-01{
				grid-template-areas:
					"c1 c2"
			}
		}





		.table{
			display:table;
			width:100%
		}

		.tableCell,.tableHead{
			display:table-cell;
			border:1px solid #f3f3f3;
			padding:.5em
		}

		.tableHead{
			background:#e8e8e8;
			color:black;
			font-family:"Open Sans",sans-serif;
			font-size:larger;
			text-align:center;
			text-transform:capitalize
		}

		.tableRow{display:table-row}

		.tableRow:nth-child(odd){background-color:#f9f9f9}
	</style>
	<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
		let navActiveItem = ["nav-dashboard"];
		let navActiveSub = [];
	</script>
	<body>
		<main style="padding:20px 20px 20px 0">
			<h1 style="border-bottom:1px dashed var(--cl3)">Dashboard</h1>
			<p>This section is still under development, but if you come across any unresolved issues please let us know at: <a class="oj" href="mailto:info@custodiancms.org?subject=unresolved+issue+report">info@custodiancms.org</a></p>

			<div class="modal">
				<div>Security Logs
					<svg id="ccms_security_logs_reload" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width:28px;position:relative;float:right;top:5px;cursor:pointer">
						<title>Reload</title>
						<path fill="#fff" d="M19.91,15.51H15.38a1,1,0,0,0,0,2h2.4A8,8,0,0,1,4,12a1,1,0,0,0-2,0,10,10,0,0,0,16.88,7.23V21a1,1,0,0,0,2,0V16.5A1,1,0,0,0,19.91,15.51ZM15,12a3,3,0,1,0-3,3A3,3,0,0,0,15,12Zm-4,0a1,1,0,1,1,1,1A1,1,0,0,1,11,12ZM12,2A10,10,0,0,0,5.12,4.77V3a1,1,0,0,0-2,0V7.5a1,1,0,0,0,1,1h4.5a1,1,0,0,0,0-2H6.22A8,8,0,0,1,20,12a1,1,0,0,0,2,0A10,10,0,0,0,12,2Z"/></svg>
				</div>
				<div>
					<p>List of sessions and or form calls, found in the 'ccms_log' table, that failed.</p>
					<div id="ccms_security_logs"></div>
				</div>
			</div>

			<div class="cssGrid-Dashboard-01">
				<div class="modal">
					<div>System Info</div>
					<div>
						<p>Server Name: <?= $_SERVER["SERVER_NAME"];?></p>
						<p>Document Root: <?=$_SERVER["DOCUMENT_ROOT"];?></p>
						<p>System Address: <?= $_SERVER["SERVER_ADDR"];?></p>
						<p>Web Server: <?php $a = explode(" ",$_SERVER["SERVER_SOFTWARE"]);echo $a[0];?></p>
						<p>PHP Version: <?= phpversion();?></p>
						<p>PHP Memory Limit: <?= ini_get("memory_limit");?></p>
						<p>MySQL Version: <?= $CFG["DBH"]->getAttribute(PDO::ATTR_SERVER_VERSION);?></p>
						<p>COOKIE_SESSION_EXPIRE: <?= $CFG["COOKIE_SESSION_EXPIRE"];?></p>
						<p>HTML_MIN: <?= $CFG["HTML_MIN"];?></p>
						<p>CACHE: <?= $CFG["CACHE"];?></p>
						<p>CACHE_EXPIRE: <?= $CFG["CACHE_EXPIRE"];?></p>
						<p>LOG_EVENTS: <?= $CFG["LOG_EVENTS"];?></p>
						<p>EMAIL_FROM: <?= $CFG["EMAIL_FROM"];?></p>
						<p>EMAIL_BOUNCES_RETURNED_TO: <?= $CFG["EMAIL_BOUNCES_RETURNED_TO"];?></p>
					</div>
				</div>

				<div class="modal">
					<div>News From CustodianCMS.org
						<svg id="ccms_news_reload" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width:28px;position:relative;float:right;top:5px;cursor:pointer">
							<title>Reload</title>
							<path fill="#fff" d="M19.91,15.51H15.38a1,1,0,0,0,0,2h2.4A8,8,0,0,1,4,12a1,1,0,0,0-2,0,10,10,0,0,0,16.88,7.23V21a1,1,0,0,0,2,0V16.5A1,1,0,0,0,19.91,15.51ZM15,12a3,3,0,1,0-3,3A3,3,0,0,0,15,12Zm-4,0a1,1,0,1,1,1,1A1,1,0,0,1,11,12ZM12,2A10,10,0,0,0,5.12,4.77V3a1,1,0,0,0-2,0V7.5a1,1,0,0,0,1,1h4.5a1,1,0,0,0,0-2H6.22A8,8,0,0,1,20,12a1,1,0,0,0,2,0A10,10,0,0,0,12,2Z"/></svg>
					</div>
					<div id="ccms_news_items">
						<p>Nothing to see at the moment.</p>
					</div>
				</div>
			</div>

			<div class="modal">
				<div>License Info</div>
				<div>
					@Version
					<p style="margin-left:20px;">
						{CCMS_LIB:_default.php;FUNC:ccms_version} (Release Date: {CCMS_LIB:_default.php;FUNC:ccms_release_date})
					</p>
					@Copyright
					<p style="margin-left:20px;">
						&copy; {CCMS_LIB:_default.php;FUNC:ccms_dateYear} assigned by Vincent Hallberg of <a class='oj' href="https://custodiancms.org" rel="noopener" target="_blank">custodiancms.org</a> and <a class='oj' href="https://modusinternet.com" rel="noopener" target="_blank">modusinternet.com</a>
					</p>
					<span style="margin:0 20px">License (MIT)</span>
					<p>Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:</p>
					<p>The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.</p>
					<p>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</p>
				</div>
			</div>


			<ul>
				<li>HTML Minify</li>
				<li>Templates in Database Cache</li>
				<li>Clear Cache</li>
				<li>Backup/Restore</li>
				<li>Password Recovery attempts currently in the ccms_password_recovery table</li>
			</ul>


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
							loadFirst("/ccmsusr/_js/jquery-validate-1.19.3.min.js", function() {


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




							});
						});
					});
				});
			}

			const cachedFetch = (url, options) => {
				let expiry = 5 * 60; // 5 min default
				if(typeof options === 'number') {
					expiry = options;
					options = undefined;
				} else if(typeof options === 'object') {
					// Don't set it to 0 seconds
					expiry = options.seconds || expiry;
				}
				let cached = localStorage.getItem(url);
				let whenCached = localStorage.getItem(url + ':ts');
				if(cached !== null && whenCached !== null) {
					let age = (Date.now() - whenCached) / 1000;
					if(age < expiry) {
						let response = new Response(new Blob([cached]));
						return Promise.resolve(response);
					} else {
						// Clean up the old key
						localStorage.removeItem(url);
						localStorage.removeItem(url + ':ts');
					}
				}

				return fetch(url + "?token=" + Math.random() + "&ajax_flag=1", options).then(response => {
					if(response.status === 200) {
						response.clone().text().then(content => {
							localStorage.setItem(url, content);
							localStorage.setItem(url+':ts', Date.now());
						});
					}
					return response;
				});
			}

			// (URL to call, Max expire time after saved in localhost) 3600 = seconds is equivalent to 1 hour
			cachedFetch('https://custodiancms.org/cross-origin-resources/news.php', 3600)
				.then(r => r.text())
				.then(content => {
					document.getElementById("ccms_news_items").innerHTML = content;
			});

			document.getElementById("ccms_news_reload").addEventListener("click", () => {
				const url = "https://custodiancms.org/cross-origin-resources/news.php";
				localStorage.removeItem(url);
				localStorage.removeItem(url + ":ts");
				// 3600 = seconds is equivalent to 1 hour
				cachedFetch(url, 3600)
					.then(r => r.text())
					.then(content => {
						document.getElementById("ccms_news_items").innerHTML = content;
				});
			});















			function securityLogTable(data) {
				if(data !== null) {
					document.getElementById("ccms_security_logs").innerHTML = "";
				}


//{"errorMsg":"Session Error"}
console.log(data[0].errorMsg);

				if(typeof data !== 'object') {
					document.getElementById("ccms_security_logs").innerHTML = "<p>Nothing to see at the moment.</p>";
					return;
				}

				var mainContainer = document.getElementById("ccms_security_logs");

				// Get values for the table headers.
				// ie: {'ID', 'Date', 'IP' , 'URL','Log'}
				var tablecolumns = [];
				for(var i = 0; i < data.length; i++) {
					for(var key in data[i]) {
						if(tablecolumns.indexOf(key) === -1) {
							tablecolumns.push(key);
						}
					}
				}

				var divTable = document.createElement("div");
				divTable.className = 'table';

				var divTableHeaderRow = document.createElement("div");
				divTableHeaderRow.className = 'tableRow';
				divTable.appendChild(divTableHeaderRow);

				for(var i = 0; i < tablecolumns.length; i++) {
					//console.log(tablecolumns[i]);
					var div = document.createElement("div");
					div.className = 'tableCell tableHead';
					div.innerHTML = tablecolumns[i];
					divTableHeaderRow.appendChild(div);
				}

				// Add one more empty div at the end of the header to contain stuff like a delete or edit button.
				var div = document.createElement("div");
				div.className = 'tableCell tableHead';
				div.innerHTML = "";
				divTableHeaderRow.appendChild(div);

				for(var i = 0; i < data.length; i++) {
					var divTableRow = document.createElement("div");
					divTableRow.className = 'tableRow';

					const date = new Date(data[i].date*1000);
					// Year
					var year = date.getFullYear();
					// Month
					var month = date.getMonth();
					// Day
					var day = date.getDate();
					// Hours
					var hours = date.getHours();
					// Minutes
					var minutes = "0" + date.getMinutes();
					// Seconds
					var seconds = "0" + date.getSeconds();
					// Display date time in MM-dd-yyyy h:m:s format
					const convdataTime = year+'-'+month+'-'+day+'<br>'+hours+':'+minutes.substr(-2)+':'+seconds.substr(-2);

					divTableRow.innerHTML = '<div class="tableCell">' + data[i].id
					+ '</div><div class="tableCell">' + convdataTime
					+ '</div><div class="tableCell">' + data[i].ip
					+ '</div><div class="tableCell">' + data[i].url
					+ '</div><div class="tableCell">' + data[i].log
					+ '</div><div class="tableCell">[' + data[i].id
					+ ']</div>';
					divTable.appendChild(divTableRow);
				}

				mainContainer.appendChild(divTable);
			}

			// (URL to call, Max expire time after saved in localhost) 3600 = seconds is equivalent to 1 hour
			cachedFetch('/{CCMS_LIB:_default.php;FUNC:ccms_lng}/user/dashboard/logs.php', 240)
				.then(r => r.json())
				.then(content => {
					securityLogTable(content);
				}
			);

			document.getElementById("ccms_security_logs_reload").addEventListener("click", () => {
				const url = "/{CCMS_LIB:_default.php;FUNC:ccms_lng}/user/dashboard/logs.php";
				localStorage.removeItem(url);
				localStorage.removeItem(url + ":ts");
				//document.getElementById("ccms_security_logs").innerHTML = "";
				// 3600 = seconds is equivalent to 1 hour
				cachedFetch(url, 240)
					.then(r => r.json())
					.then(content => {
						securityLogTable(content);
					}
				);
			});

















			// Combined with fetch's options object but called with a custom name
			//let init = {
			//	mode: 'same-origin',
			//	seconds: 3 * 60 // 3 minutes
			//}
			//cachedFetch('https://httpbin.org/get', init)
			//	.then(r => r.json())
			//	.then(info => {
			//		console.log('3) ********** Your origin is ' + info.origin)
			//	}
			//)

			//cachedFetch('https://httpbin.org/image/png')
			// .then(r => r.blob())
			// .then(image => {
			//   console.log('Image is ' + image.size + ' bytes')
			// }
			//)

		</script>
	</body>
</html>
