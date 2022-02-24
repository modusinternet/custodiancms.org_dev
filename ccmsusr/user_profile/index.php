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
		<title><?= $_SERVER["SERVER_NAME"];?> | User | User Profile</title>
		{CCMS_TPL:head-meta.html}
	</head>
	<style>
		{CCMS_TPL:/_css/head-css.html}
	</style>
	<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
		let navActiveItem = ["nav-user_profile"];
		let navActiveSub = [];
		</script>
	</head>
	<body>
		<main style="padding:20px 20px 20px 0">
			<h1 style="border-bottom:1px dashed var(--cl3)">User Profile</h1>
			<p>This section is still under development, but if you come across any unresolved issues please let us know at: <a class="oj" href="mailto:info@custodiancms.org?subject=unresolved+issue+report">info@custodiancms.org</a></p>





			<div class="tabs">
				<button class="tab" id="tab01Title"></button>
				<button class="tab" id="tab02Title"></button>
				<button class="tab" id="tab03Title"></button>
			</div>

			<!-- Welcome  -->
			<div id="tab01Content" class="tabContent">
				<p>tab content #1</p>
			</div>

			<div id="tab02Content" class="tabContent">
				<p>tab content #2</p>
			</div>

			<div id="tab03Content" class="tabContent">
				<p>tab content #3</p>
			</div>






			<div class="modal">
				<div>
					<span style="float:left">Security Logs</span>
					<button class="svg_icon svg_compress_button" id="ccms_compress_button" title="Compress Show/Hide"></button>
					<button class="svg_icon svg_reload_button" id="ccms_security_logs_reload_button" title="Reload"></button>
				</div>
				<div>
					<p>List of sessions and or form calls, found in the 'ccms_log' table, that failed.<?php if($CFG["LOG_EVENTS"] === 0){echo '<br><span class="blacklistIpAddress">Currently disabled in config. Only old logs displayed below for now, if any.</span>';}?></p>
					<div id="ccms_security_logs"></div>
					<div id="ccms_security_logs_hidden">Click the <svg class="svg_icon" style="bottom:-5px;cursor:text;fill:var(--cl4);position:relative" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17,20H13V16.41l.79.8a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-2.5-2.5a1,1,0,0,0-.33-.21,1,1,0,0,0-.76,0,1,1,0,0,0-.33.21l-2.5,2.5a1,1,0,0,0,1.42,1.42l.79-.8V20H7a1,1,0,0,0,0,2H17a1,1,0,0,0,0-2ZM7,4h4V7.59l-.79-.8A1,1,0,1,0,8.79,8.21l2.5,2.5a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l2.5-2.5a1,1,0,1,0-1.42-1.42l-.79.8V4h4a1,1,0,0,0,0-2H7A1,1,0,0,0,7,4Z"/></svg> icon above to show/hide the Security Logs table.</div>
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

















		<div id="wrapper">
			{CCMS_TPL:/header-body.php}
			<div id="page-wrapper">
				<div class="row">
					<div class="col-md-12">
						<h1 class="page-header">User Profile</h1>
						<div class="img-circle" style="background-color: #337AB7; height: 100px; width: 100px;">
							<i class="fa fa-user" style="color: #ffffff; font-size: 6em;"></i>
						</div>
						<h2><?php echo $ccms_user["firstname"] . " " . $ccms_user["lastname"] . " (" . $ccms_user["alias"] . ")"; ?></h2>
						<?php echo $ccms_user["position"]; ?><br />
						<br />
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#info_tab" data-toggle="tab" aria-expanded="false">Info</a>
							</li>
							<li>
								<a href="#password_tab" data-toggle="tab">Password</a>
							</li>
							<li>
								<a href="#privilege_tab" data-toggle="tab" aria-expanded="true">Privileges</a>
							</li>
						</ul>
					</div>
				</div>

				<!-- Tab panes -->
				<div class="tab-content" style="margin: 10px;">
					<div class="tab-pane fade active in" id="info_tab">
						<form class="form-horizontal" id="info_tab_form" role="form">
							<input name="ajax_flag" type="hidden" value="1">
							<div class="row">
								<div class="col-md-4">
									<h3>General</h3>
									<div id="info_tab_form_success" class="alert alert-success" role="alert" style="display: none;"></div>
									<div id="info_tab_form_fail" class="alert alert-danger" role="alert" style="display: none;"></div>
									<div class="form-group">
										<label for="firstname" class="control-label">Firstname</label>
										<div class="input-group">
											<div class="input-group-addon"><span class="fa fa-user"></span></div>
											<input class="form-control" id="firstname" name="firstname" placeholder="Type your Firstname here." type="text" value="<?php echo $ccms_user["firstname"]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="lastname" class="control-label">Lastname</label>
										<div class="input-group">
											<div class="input-group-addon"><span class="fa fa-user"></span></div>
											<input class="form-control" id="lastname" name="lastname" placeholder="Type your Lastname here." type="text" value="<?php echo $ccms_user["lastname"]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="alias" class="control-label">Alias *</label>
										<div class="input-group">
											<div class="input-group-addon"><span class="fa fa-user"></span></div>
											<input class="form-control" id="alias" name="alias" placeholder="Type your Alias here." type="text" value="<?php echo $ccms_user["alias"]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="position" class="control-label">Position</label>
										<div class="input-group">
											<div class="input-group-addon"><span class="fa fa-cog"></span></div>
											<input class="form-control" id="position" name="position" placeholder="Type your work Position or Title here." type="text" value="<?php echo $ccms_user["position"]; ?>">
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<h3>Address</h3>
									<div class="form-group">
										<label for="address1" class="control-label">Address Line 1</label>
										<div class="input-group">
											<div class="input-group-addon"><span class="fa fa-map-marker"></span></div>
											<input class="form-control" id="address1" name="address1" placeholder="Type your Address here." type="text" value="<?php echo $ccms_user["address1"]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="address2" class="control-label">Address Line 2</label>
										<div class="input-group">
											<div class="input-group-addon"><span class="fa fa-map-marker"></span></div>
											<input class="form-control" id="address2" name="address2" placeholder="Type your Address here." type="text" value="<?php echo $ccms_user["address2"]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="prov_state" class="control-label">Prov/State</label>
										<div class="input-group">
											<div class="input-group-addon"><span class="fa fa-map-marker"></span></div>
											<input class="form-control" id="prov_state" name="prov_state" placeholder="Type your Province or State here." type="text" value="<?php echo $ccms_user["prov_state"]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="country" class="control-label">Country</label>
										<div class="input-group">
											<div class="input-group-addon"><span class="fa fa-map-marker"></span></div>
											<input class="form-control" id="country" name="country" placeholder="Type your Country Name here." type="text" value="<?php echo $ccms_user["country"]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="post_zip" class="control-label">Post/Zip Code</label>
										<div class="input-group">
											<div class="input-group-addon"><span class="fa fa-map-marker"></span></div>
											<input class="form-control" id="post_zip" name="post_zip" placeholder="Type your Postal or Zip Code here." type="text" value="<?php echo $ccms_user["post_zip"]; ?>">
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<h3>Contact</h3>
									<div class="form-group">
										<label for="email" class="control-label">Email *</label>
										<div class="input-group">
											<div class="input-group-addon"><span class="fa fa-envelope"></span></div>
											<input class="form-control" id="email" name="email" placeholder="Type your Email Address here." type="text" value="<?php echo $ccms_user["email"]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="phone1" class="control-label">Phone #1</label>
										<div class="input-group">
											<div class="input-group-addon"><span class="fa fa-phone"></span></div>
											<input class="form-control" id="phone1" name="phone1" placeholder="Type your main Phone Number here." type="text" value="<?php echo $ccms_user["phone1"]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="phone2" class="control-label">Phone #2</label>
										<div class="input-group">
											<div class="input-group-addon"><span class="fa fa-phone"></span></div>
											<input class="form-control" id="phone2" name="phone2" placeholder="Type your secondary Phone Number here." type="text" value="<?php echo $ccms_user["phone2"]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="facebook" class="control-label">Facebook</label>
										<div class="input-group">
											<div class="input-group-addon"><span class="fa fa-facebook-official"></span></div>
											<input class="form-control" id="facebook" name="facebook" placeholder="Type your Facebook URI here." type="text" value="<?php echo $ccms_user["facebook"]; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="skype" class="control-label">Skype</label>
										<div class="input-group">
											<div class="input-group-addon"><span class="fa fa-skype"></span></div>
											<input class="form-control" id="skype" name="skype" placeholder="Type your Skype Account Name here." type="text" value="<?php echo $ccms_user["skype"]; ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h3>Other</h3>

									<div class="form-group">
										<label for="note" class="control-label">Notes</label>
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-file-text-o"></i></div>
											<textarea name="note" id="note" cols="30" rows="4" class="form-control" placeholder="Type any other notes you wish to attach to your account here."><?php echo $ccms_user["note"]; ?></textarea>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<button class="btn-primary btn">Update</button>
									<button class="btn-default btn">Cancel</button>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane fade" id="password_tab">
						<form class="form-horizontal" id="password_tab_form" role="form">
							<input name="ajax_flag" type="hidden" value="1">
							<div class="row">
								<div class="col-md-12">
									<h3>Manage Your Password Here</h3>
									<div id="password_tab_form_success" class="alert alert-success" role="alert" style="display: none;"></div>
									<div id="password_tab_form_fail" class="alert alert-danger" role="alert" style="display: none;"></div>
									<div class="form-group">
										<label for="password" class="control-label">Password *</label>
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-key"></i></div>
											<input class="form-control" id="password" name="password" placeholder="Type your current password here." type="password" value="" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
										</div>
									</div>
									<div class="form-group">
										<label for="password1" class="control-label">New Password *</label>
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-key"></i></div>
											<input class="form-control" id="password1" name="password1" placeholder="Type your new password here." type="password" value="" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
										</div>
									</div>
									<div class="form-group">
										<label for="password2" class="control-label">Repeat New Password *</label>
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-key"></i></div>
											<input class="form-control" id="password2" name="password2" placeholder="Type your new password here again." type="password" value="" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<button class="btn-primary btn">Update</button>
									<button class="btn-default btn">Cancel</button>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane fade" id="privilege_tab">
						<div class="row">
							<div class="col-md-12">
								<h3>Your User Privileges</h3>
								The string below is an exact copy of what the server reads in order to determine your personal read/write privileges for functions found throughout this site.  The data below that is the same content structured to help make it easier to read.  These setting <span style="text-decoration: underline;">can not</span> be modified here.  Changes can only be made by users with read/write access to the '<span class="oj">Admin / User Privileges</span>' area.<br />
								<div class="alert alert-success" style="word-wrap: break-word;">
<?php
	$json = json_decode($ccms_user["priv"]);
	echo json_encode($json, JSON_UNESCAPED_SLASHES);
?>
									<pre><?=json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);?></pre>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>








		<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
			{CCMS_TPL:/_js/footer-1.php}

			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/bootstrap-3.3.7.min.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);

			/*
			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/metisMenu-2.4.0.min.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);
			*/
			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/metisMenu-3.0.6.min.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);

			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/custodiancms.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);

			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/font-awesome-4.7.0.min.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);

			function loadJSResources() {
				/*loadFirst("/ccmsusr/_js/jquery-2.2.0.min.js", function() {*/
				loadFirst("/ccmsusr/_js/jquery-3.6.0.min.js", function() {
					loadFirst("/ccmsusr/_js/bootstrap-3.3.7.min.js", function() { /* Bootstrap is loaded */
						loadFirst("/ccmsusr/_js/metisMenu-3.0.7.min.js", function() {
							loadFirst("/ccmsusr/_js/custodiancms.js", function() {

								// Load MetisMenu
								//$('#side-menu').metisMenu();

								/*
								$("#menu-toggle").click(function(e) {
									e.preventDefault();
									$("#wrapper").toggleClass("toggled");
									$("#wrapper.toggled").find("#sidebar-wrapper").find(".collapse").collapse("hide");
									$("#sidebar-wrapper").toggle();
								});

								$(function(){$(window).bind("load resize",function(){showHideNav();})});
								*/

								/*loadFirst("//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js", function() { /* jquery.validate.js */
								loadFirst("/ccmsusr/_js/jquery-validate-1.19.3.min.js", function() { /* JQuery Validate */
									/*loadFirst("//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/additional-methods.min.js", function(){ /* additional-methods.js */
									loadFirst("/ccmsusr/_js/additional-methods-1.17.0.min.js", function() { /* JQuery Validate Additional Methods */









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

											//evt.currentTarget.className += " active";
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



















										$.validator.addMethod(
											"badCharRegex",
											function(value, element, regexp) {
												var re = new RegExp(regexp);
												return this.optional(element) || re.test(value);
											}, "Please check your input."
										);

										$('#info_tab_form').each(function() {
											$(this).validate({
												rules: {
													firstname: {
														maxlength: 64,
														badCharRegex: /^[^\<\>&#]+$/i
													},
													lastname: {
														maxlength: 64,
														badCharRegex: /^[^\<\>&#]+$/i
													},
													alias: {
														required: true,
														minlength: 4,
														maxlength: 32,
														badCharRegex: /^[^\<\>&#]+$/i
													},
													position: {
														maxlength: 128,
														badCharRegex: /^[^\<\>&#]+$/i
													},
													address1: {
														maxlength: 128,
														badCharRegex: /^[^\<\>&#]+$/i
													},
													address2: {
														maxlength: 128,
														badCharRegex: /^[^\<\>&#]+$/i
													},
													prov_state: {
														maxlength: 32,
														badCharRegex: /^[^\<\>&#]+$/i
													},
													country: {
														maxlength: 64,
														badCharRegex: /^[^\<\>&#]+$/i
													},
													post_zip: {
														maxlength: 32,
														badCharRegex: /^[^\<\>&#]+$/i
													},
													email: {
														required: true,
														email: true,
														maxlength: 255
													},
													phone1: {
														maxlength: 64,
														badCharRegex: /^[^\<\>&#]+$/i
													},
													phone2: {
														maxlength: 64,
														badCharRegex: /^[^\<\>&#]+$/i
													},
													skype: {
														maxlength: 32,
														badCharRegex: /^[^\<\>&#]+$/i
													},
													facebook: {
														maxlength: 128,
														badCharRegex: /^[^\<\>&#]+$/i
													},
													note: {
														maxlength: 1024,
														badCharRegex: /^[^\<\>&#]+$/i
													}
												},
												messages: {
													firstname: {
														maxlength: "This field has a maximum length of 64 characters or less.",
														badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													lastname: {
														maxlength: "This field has a maximum length of 64 characters or less.",
														badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													alias: {
														required: "This field is required.",
														minlength: "This field has a minimum length of 4 characters or more.",
														maxlength: "This field has a maximum length of 32 characters or less.",
														badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													position: {
														maxlength: "This field has a maximum length of 32 characters or less.",
														badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													address1: {
														maxlength: "This field has a maximum length of 128 characters or less.",
														badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													address2: {
														maxlength: "This field has a maximum length of 128 characters or less.",
														badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													prov_state: {
														maxlength: "This field has a maximum length of 32 characters or less.",
														badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													country: {
														maxlength: "This field has a maximum length of 64 characters or less.",
														badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													post_zip: {
														maxlength: "This field has a maximum length of 32 characters or less.",
														badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													email: {
														required: "Please enter a valid email address.",
														maxlength: "This field has a maximum length of 255 characters or less."
													},
													phone1: {
														maxlength: "This field has a maximum length of 64 characters or less.",
														badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													phone2: {
														maxlength: "This field has a maximum length of 64 characters or less.",
														badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													skype: {
														maxlength: "This field has a maximum length of 32 characters or less.",
														badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													facebook: {
														maxlength: "This field has a maximum length of 128 characters or less.",
														badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													note: {
														maxlength: "This field has a maximum length of 1024 characters or less.",
														badCharRegex: "The following characters are not permitted in this field.  ( > < & # )"
													}
												},
												submitHandler: function(form) {
													var request;
													// Abort any pending request.
													if (request) request.abort();
													var $inputs = $(form).find("input, select, textarea, button");
													var serializedData = $(form).serialize();
													// Disable the inputs for the duration of the ajax request.
													$inputs.prop("disabled", true);
													request = $.ajax({
														url: "/{CCMS_LIB:_default.php;FUNC:ccms_lng}/user/user_profile/info-ajax.html",
														cache: false,
														type: "post",
														data: serializedData
													});
													// Called on success.
													request.done(function(msg) {
														//console.log(msg);
														if(msg == "1") {
															//$(form).find('[name="form-status"]').html("Info form updated.");
															$("#info_tab_form_fail").css("display", "none");
															$("#info_tab_form_success").html('<span class="fa fa-check" aria-hidden="true" style="margin-right: 10px;"></span>'+"Success: Updates saved.");
															$("#info_tab_form_success").css("display", "block");
															$("#info_tab_form_success").scrollView();
															setTimeout(function() {
																//$(form).find('[name="form-status"]').html("");
																//$(form).find('[name="FromEmail"]').val("");
																//$(form).find('[name="ToEmail"]').val("");
																//$(form).find('[name="Message"]').val("");
																$("#info_tab_form_success").css("display", "none");
															}, 10000);
														} else {
															//$(form).find('[name="form-status"]').html(msg);
															$("#info_tab_form_success").css("display", "none");
															$("#info_tab_form_fail").html(msg);
															$("#info_tab_form_fail").css("display", "block");
															$("#info_tab_form_fail").scrollView();
														}
													});
													// Called on failure.
													request.fail(function (jqXHR, textStatus, errorThrown){
														// log the error to the console
														//console.error( "The following error occured: " + textStatus, errorThrown );
														//$(form).find('[name="form-status"]').html("The following error occured: " + textStatus, errorThrown);
														$("#info_tab_form_success").css("display", "none");
														$("#info_tab_form_fail").css("display", "block");
														$("#info_tab_form_fail").html("The following error occured: " + textStatus, errorThrown);
													});
													// Called if the request failed or succeeded.
													request.always(function () {
														// reenable the inputs
														setTimeout(function() {
															$inputs.prop("disabled", false);
														}, 5000);
													});
													// Prevent default posting of form.
													return false;
												}
											});
										});


										$('#password_tab_form').each(function() {
											$(this).validate({
												rules: {
													password: {
														required: true,
														minlength: 8
													},
													password1: {
														required: true,
														minlength: 8,
														equalTo: "#password2"
													},
													password2: {
														required: true,
														minlength: 8,
														equalTo: "#password1"
													}
												},
												messages: {
													password: {
														required: "This field is required.",
														maxlength: "This field has a minimum length of 8 characters or more."
													},
													password1: {
														required: "This field is required.",
														maxlength: "This field has a minimum length of 8 characters or more.",
														equalTo: "'New Password' and 'Repeat New Password' are not the same."
													},
													password2: {
														required: "This field is required.",
														maxlength: "This field has a minimum length of 8 characters or more.",
														equalTo: "'New Password' and 'Repeat New Password' are not the same."
													}
												},
												submitHandler: function(form) {
													var request;
													// Abort any pending request.
													if (request) request.abort();
													var $inputs = $(form).find("input, select, textarea, button");
													var serializedData = $(form).serialize();
													// Disable the inputs for the duration of the ajax request.
													$inputs.prop("disabled", true);
													request = $.ajax({
														url: "/{CCMS_LIB:_default.php;FUNC:ccms_lng}/user/user_profile/password-ajax.html",
														cache: false,
														type: "post",
														data: serializedData
													});
													// Called on success.
													request.done(function(msg) {
														//console.log(msg);
														if(msg == "1") {
															//$(form).find('[name="form-status"]').html("Password form updated.");
															$("#password_tab_form_fail").css("display", "none");
															$("#password_tab_form_success").html('<span class="fa fa-check" aria-hidden="true" style="margin-right: 10px;"></span>'+"Success: Updates saved.");
															$("#password_tab_form_success").css("display", "block");
															$("#password_tab_form_success").scrollView();
															setTimeout(function() {
																//$(form).find('[name="form-status"]').html("");
																//$(form).find('[name="FromEmail"]').val("");
																//$(form).find('[name="ToEmail"]').val("");
																//$(form).find('[name="Message"]').val("");
																$("#password_tab_form_success").css("display", "none");
															}, 10000);
														} else {
															//$(form).find('[name="form-status"]').html(msg);
															$("#password_tab_form_success").css("display", "none");
															$("#password_tab_form_fail").html(msg);
															$("#password_tab_form_fail").css("display", "block");
															$("#password_tab_form_fail").scrollView();
														}
													});
													// Called on failure.
													request.fail(function (jqXHR, textStatus, errorThrown){
														// log the error to the console
														//console.error( "The following error occured: " + textStatus, errorThrown );
														//$(form).find('[name="form-status"]').html("The following error occured: " + textStatus, errorThrown);
														$("#password_tab_form_success").css("display", "none");
														$("#password_tab_form_fail").css("display", "block");
														$("#password_tab_form_fail").html("The following error occured: " + textStatus, errorThrown);
													});
													// Called if the request failed or succeeded.
													request.always(function () {
														// reenable the inputs
														setTimeout(function() {
															$inputs.prop("disabled", false);
															$("#password").val("");
															$("#password1").val("");
															$("#password2").val("");
														}, 5000);
													});
													// Prevent default posting of form.
													return false;
												}
											});
										});
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
