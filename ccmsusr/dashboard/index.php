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

		.blacklistIpAddress{
			font-size:.8em;
			color:var(--cl11);
			cursor:pointer
		}

		.cssGrid-Dashboard-01{
			display:grid;
			grid-gap:1em;
			/*
			grid-template-areas:
				"c1"
				"c2"
			*/
		}

		.svg_icon{
			background-color:transparent;
			border:none;
			cursor:pointer;
			height:25px;
			width:25px
		}

		.svg_delete_button {
			background-image:url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%23d7680f" d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18ZM20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Zm-3-1a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z"/></svg>')
		}

		.svg_reload_button{
			background-image:url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%23fff" d="M19.91,15.51H15.38a1,1,0,0,0,0,2h2.4A8,8,0,0,1,4,12a1,1,0,0,0-2,0,10,10,0,0,0,16.88,7.23V21a1,1,0,0,0,2,0V16.5A1,1,0,0,0,19.91,15.51ZM15,12a3,3,0,1,0-3,3A3,3,0,0,0,15,12Zm-4,0a1,1,0,1,1,1,1A1,1,0,0,1,11,12ZM12,2A10,10,0,0,0,5.12,4.77V3a1,1,0,0,0-2,0V7.5a1,1,0,0,0,1,1h4.5a1,1,0,0,0,0-2H6.22A8,8,0,0,1,20,12a1,1,0,0,0,2,0A10,10,0,0,0,12,2Z"/></svg>')
		}

		.svg_compress_button{
			background-image:url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%23fff" d="M17,20H13V16.41l.79.8a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-2.5-2.5a1,1,0,0,0-.33-.21,1,1,0,0,0-.76,0,1,1,0,0,0-.33.21l-2.5,2.5a1,1,0,0,0,1.42,1.42l.79-.8V20H7a1,1,0,0,0,0,2H17a1,1,0,0,0,0-2ZM7,4h4V7.59l-.79-.8A1,1,0,1,0,8.79,8.21l2.5,2.5a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l2.5-2.5a1,1,0,1,0-1.42-1.42l-.79.8V4h4a1,1,0,0,0,0-2H7A1,1,0,0,0,7,4Z"/></svg>')
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
			color:var(--cl0);
			height:53px
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

		#ccms_compress_button{
			float:left;
			left:10px;
			position:relative;
			top:5px
		}

		#ccms_news_items{padding-left:30px}

		#ccms_news_items li{margin-bottom:10px}

		#ccms_news_reload_button,#ccms_security_logs_reload_button{
			float:right;
			position:relative;
			right:0;
			top:5px
		}

		#ccms_security_logs{display:none}

		#ccms_security_logs_hidden{display:block}

		/* 875px or larger. Pixel Xl Landscape resolution is 411 x 823. */
		@media only screen and (min-width: 875px){
			.cssGrid-Dashboard-01{
				grid-template-areas:
					"c1 c2"
			}
		}
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
				<div>
					<span style="float:left">Security Logs</span>
					<button class="svg_icon svg_compress_button" id="ccms_compress_button" title="Compress Show/Hide"></button>
					<button class="svg_icon svg_reload_button" id="ccms_security_logs_reload_button" title="Reload"></button>
				</div>
				<div>
					<p>List of sessions and or form calls, found in the 'ccms_log' table, that failed.<?php if($CFG["LOG_EVENTS"] === 0){echo '<br><span class="blacklistIpAddress">Currently disabled in config. Only old logs displayed below for now, if any.</span>';}?></p>
					<div id="ccms_security_logs"></div>
					<div id="ccms_security_logs_hidden">Click the <svg class="svg_icon" style="bottom:-5px;fill:var(--cl4);position:relative" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%23d7680f" d="M17,20H13V16.41l.79.8a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-2.5-2.5a1,1,0,0,0-.33-.21,1,1,0,0,0-.76,0,1,1,0,0,0-.33.21l-2.5,2.5a1,1,0,0,0,1.42,1.42l.79-.8V20H7a1,1,0,0,0,0,2H17a1,1,0,0,0,0-2ZM7,4h4V7.59l-.79-.8A1,1,0,1,0,8.79,8.21l2.5,2.5a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l2.5-2.5a1,1,0,1,0-1.42-1.42l-.79.8V4h4a1,1,0,0,0,0-2H7A1,1,0,0,0,7,4Z"/></svg> icon above to show or hide log table.</div>
				</div>
			</div>

			<div class="cssGrid-Dashboard-01">
				<div class="modal">
					<div>System Info</div>
					<div>
						<p style="word-break:break-all">Server Name: <span class="oj"><?= $_SERVER["SERVER_NAME"];?></span></p>
						<p style="word-break:break-all">Document Root: <span class="oj"><?=$_SERVER["DOCUMENT_ROOT"];?></span></p>
						<p>System Address: <span class="oj"><?= $_SERVER["SERVER_ADDR"];?></p>
						<p>Web Server: <span class="oj"><?php $a = explode(" ",$_SERVER["SERVER_SOFTWARE"]);echo $a[0];?></span></p>
						<p>PHP Version: <span class="oj"><?= phpversion();?></span></p>
						<p>PHP Memory Limit: <span class="oj"><?= ini_get("memory_limit");?></span></p>
						<p>MySQL Version: <span class="oj"><?= $CFG["DBH"]->getAttribute(PDO::ATTR_SERVER_VERSION);?></span></p>
						<p>COOKIE_SESSION_EXPIRE: <span class="oj"><?= $CFG["COOKIE_SESSION_EXPIRE"];?></span></p>
						<p>HTML_MIN: <span class="oj"><?= $CFG["HTML_MIN"];?></span></p>
						<p>CACHE: <span class="oj"><?= $CFG["CACHE"];?></span></p>
						<p>CACHE_EXPIRE: <span class="oj"><?= $CFG["CACHE_EXPIRE"];?></span></p>
						<p>LOG_EVENTS: <span class="oj"><?= $CFG["LOG_EVENTS"];?></span></p>
						<p>EMAIL_FROM: <span class="oj"><?= $CFG["EMAIL_FROM"];?></span></p>
						<p style="word-break:break-all">EMAIL_BOUNCES_RETURNED_TO: <span class="oj"><?= $CFG["EMAIL_BOUNCES_RETURNED_TO"];?></span></p>
					</div>
				</div>

				<div class="modal">
					<div>CustodianCMS.org News
						<button class="svg_icon svg_reload_button" id="ccms_news_reload_button" title="Reload"></button>
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
					if(cached[0].errorMsg !== null || age > expiry) {
						// Clean up the old key
						localStorage.removeItem(url);
						localStorage.removeItem(url + ':ts');
					} else {
						let response = new Response(new Blob([cached]));
						return Promise.resolve(response);
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

			document.getElementById("ccms_news_reload_button").addEventListener("click", () => {
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
				document.getElementById("ccms_security_logs").innerHTML = "";

				if(data === null) {
					document.getElementById("ccms_security_logs").innerHTML = '<p class="blacklistIpAddress">Nothing to see at the moment.</p>';
					return;
				}

				if(data[0].errorMsg) {
					document.getElementById("ccms_security_logs").innerHTML = "<p>" + data[0].errorMsg + "</p>";
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
					divTableRow.setAttribute("class", "tableRow");
					divTableRow.setAttribute("id", "sec-log-row-id-" + data[i].id);

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
					const convdataTime = '<span style="white-space:nowrap">'+year+'-'+month+1+'-'+day+'</span><br>'+hours+':'+minutes.substr(-2)+':'+seconds.substr(-2);

					divTableRow.innerHTML = '<div class="tableCell">'+ data[i].id
					+ '</div><div class="tableCell">' + convdataTime
					+ '</div><div class="tableCell">' + data[i].ip
					+ '<br><span class="blacklistIpAddress" data-ip="' + data[i].ip
					+ '">(Blacklist)</span></div><div class="tableCell" style="line-break:anywhere;min-width:300px">' + data[i].url
					+ '</div><div class="tableCell" style="min-width:500px;width:100%">' + data[i].log
					+ '</div><div class="tableCell" style="text-align:center"><button class="svg_icon svg_delete_button" data-id="' + data[i].id
					+ '" title="Delete"></button></div>';

					divTable.appendChild(divTableRow);
				}

				mainContainer.appendChild(divTable);

				var delBut = document.getElementsByClassName('svg_delete_button');
				for(var i = 0; i < delBut.length; i++){
					const id = delBut[i].getAttribute('data-id');
					delBut[i].onclick = function(){
						let url = "/{CCMS_LIB:_default.php;FUNC:ccms_lng}/user/dashboard/logs_delete.php";
						fetch(url + "?token=" + Math.random() + "&ajax_flag=1&id=" + id)
							.then(x => x.text())
							.then(y => {
								if(y === "0") { // success
									console.log(id + " deleted");
									document.getElementById("sec-log-row-id-" + id).outerHTML = "";
								} else if(y === "1") { // already deleted
									console.log(id + " already deleted");
									document.getElementById("sec-log-row-id-" + id).outerHTML = "";
								} else if(y === '[{"errorMsg":"Session Error"}]') {
									document.getElementById("ccms_security_logs").innerHTML = "<p>Session Error</p>";
								} else {
									alert(y);
								}
							}
						);
					}
				}

				var blacklistBut = document.getElementsByClassName('blacklistIpAddress');
				for(var i = 0; i < blacklistBut.length; i++){
					const ip = blacklistBut[i].getAttribute('data-ip');
					blacklistBut[i].onclick = function(){
						let url = "/{CCMS_LIB:_default.php;FUNC:ccms_lng}/user/dashboard/addIpAddressToBlacklist.php";
						fetch(url + "?token=" + Math.random() + "&ajax_flag=1&ip=" + ip)
							.then(x => x.text())
							.then(y => {
								if(y === "0") { // already blocked
									console.log(ip + " already blocked");
									alert(ip + " already blocked");
								} else if(y === "1") { // success
									console.log(ip + " blocked");
									alert(ip + " blocked");
								} else if(y === '[{"errorMsg":"Session Error"}]') {
									console.log("Session Error");
									document.getElementById("ccms_security_logs").innerHTML = "<p>Session Error</p>";
								} else {
									console.log(y);
									alert(y);
								}
							}
						);
					}
				}
			}

			// (URL to call, Max expire time after saved in localhost) 3600 = seconds is equivalent to 1 hour
			//cachedFetch('/{CCMS_LIB:_default.php;FUNC:ccms_lng}/user/dashboard/logs.php', 3600)
			cachedFetch('/{CCMS_LIB:_default.php;FUNC:ccms_lng}/user/dashboard/logs.php')
				.then(r => r.json())
				.then(content => {
					securityLogTable(content);
				}
			);

			document.getElementById("ccms_security_logs_reload_button").addEventListener("click", () => {
				const url = "/{CCMS_LIB:_default.php;FUNC:ccms_lng}/user/dashboard/logs.php";
				localStorage.removeItem(url);
				localStorage.removeItem(url + ":ts");
				//document.getElementById("ccms_security_logs").innerHTML = "";
				// 3600 = seconds is equivalent to 1 hour
				//cachedFetch(url, 3600)
				cachedFetch(url)
					.then(r => r.json())
					.then(content => {
						securityLogTable(content);
					}
				);
			});





			function ccms_security_logs() {
				let compressed = localStorage.getItem("ccms_security_logs_compress");
				let a = document.querySelector('#ccms_security_logs');
				let b = document.querySelector('#ccms_security_logs_hidden');
				if(compressed == null || compressed == 0) {
					a.style.display = 'block';
					b.style.display = 'none';
					localStorage.setItem("ccms_security_logs_compress", 0);
				} else {
					a.style.display = 'none';
					b.style.display = 'block';
					localStorage.setItem("ccms_security_logs_compress", 1);
				}
			}



			document.getElementById("ccms_compress_button").addEventListener("click", () => {
				let compressed = localStorage.getItem("ccms_security_logs_compress");
				let a = document.querySelector('#ccms_security_logs');
				let b = document.querySelector('#ccms_security_logs_hidden');
				if(compressed == null || compressed == 1) {
					a.style.display = 'block';
					b.style.display = 'none';
					localStorage.setItem("ccms_security_logs_compress", 0);
				} else {
					a.style.display = 'none';
					b.style.display = 'block';
					localStorage.setItem("ccms_security_logs_compress", 1);
				}
			});

			setTimeout(function() {ccms_security_logs();}, 1000);

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
