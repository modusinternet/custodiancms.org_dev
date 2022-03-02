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








		form:focus{
			border-color:#66afe9;
			outline:3px solid gold;
		}

		.inner-grid{display:grid}

		.inner-grid>button{
			background:var(--cl3);
			border:0;
			color:var(--cl0);
			padding:0.5em;
			width:100%
		}

		.inner-grid>button:hover{background:var(--cl3-tran)}

		.inner-grid>input{
			background:var(--cl0);
			border:1px solid var(--cl10);
			border-radius:4px;
			padding:0.7em;
			margin-bottom:0.5rem
		}

		.inner-grid>input:focus{outline:3px solid gold}

		.inner-grid>label{white-space:nowrap}

		.inner-grid>label.error{
			color:var(--cl11);
			margin-bottom:1rem;
			text-align:unset;
			white-space:unset
		}




		.outer-grid {
			display: grid;
			grid-gap: 8px;
		}
		.outer-grid > div {
			padding: 8px;
		}






		.tabs{
			border-bottom:1px solid var(--cl4);
			overflow:hidden
		}

		.tabs button{
			background-color:var(--cl8);
			border:1px solid var(--cl4);
			border-bottom:none;
			border-radius:4px 4px 0 0;
			color:var(--cl5);
			cursor:pointer;
			float:left;
			margin-right:2px;
			outline:none;
			padding:14px 16px;
			transition:0.3s
		}

		.tabs button:hover, .tabs button:hover svg path{
			background-color:var(--cl4);
			color:var(--cl0)
		}

		.tabs button.active, .tabs button.active svg path{
			background-color:var(--cl4);
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


		/* 500px or wider. */
		@media only screen and (min-width:500px){
			.inner-grid{
				grid-template-columns:1fr 1fr;
				grid-gap:15px
			}

			.inner-grid>button{grid-column:1 / span 2}

			.inner-grid>h3{grid-column:1 / span 2}

			.inner-grid>input{grid-column:2 / 3}

			.inner-grid>label{
				text-align:right;
				grid-column:1 / 2
			}

			.inner-grid>label.error{grid-column:1 / span 2}

			.outer-grid {
				grid-template-columns: 1fr 1fr 1fr;
			}
		}
	</style>
	<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
		let navActiveItem = [];
		let navActiveSub = [];
		let navActiveW3schoolsItem = ["nav-user_profile"];
	</script>
	<body>
		<main style="padding:20px 20px 20px 0">
			<h1 style="border-bottom:1px dashed var(--cl3)">User Profile</h1>
			<p>This section is still under development, but if you come across any unresolved issues please let us know at: <a class="oj" href="mailto:info@custodiancms.org?subject=unresolved+issue+report">info@custodiancms.org</a></p>











			<div class="tabs">
				<button class="tab active" id="tab01Title">Info</button>
				<button class="tab" id="tab02Title">Passwords</button>
				<button class="tab" id="tab03Title">Privileges</button>
			</div>

			<!-- Welcome  -->
			<div id="tab01Content" class="tabContent" style="display:block">

				<div class="alert alert-success" id="info_tab_form_success" role="alert" style="display:none"></div>
				<div class="alert alert-danger" id="info_tab_form_fail" role="alert" style="display:none"></div>

				<form id="info_tab_form" role="form">
					<div class="outer-grid">
						<div class="inner-grid">
							<input name="ajax_flag" type="hidden" value="1">
							<h3>General</h3>
							<label for="firstname">Firstname</label>
							<input id="firstname" name="firstname" placeholder="Type your firstname here." type="text" value="<?php echo $ccms_user["firstname"]; ?>">
							<label id="firstname_error" class="error" for="firstname" style="display:none"></label>

							<label for="lastname">Lastname</label>
							<input id="lastname" name="lastname" placeholder="Type your lastname here." type="text" value="<?php echo $ccms_user["lastname"]; ?>">
							<label id="lastname_error" class="error" for="lastname" style="display:none"></label>

							<label for="alias">Alias <span class="rd">*</span></label>
							<input id="alias" name="alias" placeholder="Type your alias here." type="text" value="<?php echo $ccms_user["alias"]; ?>">
							<label id="alias_error" class="error" for="alias" style="display:none"></label>

							<label for="position">Position</label>
							<input id="position" name="position" placeholder="Type your work Position or Title here." type="text" value="<?php echo $ccms_user["position"]; ?>">
							<label id="position_error" class="error" for="position" style="display:none"></label>
						</div>

						<div class="inner-grid">
							<h3>Address</h3>
							<label for="address1">Address Line #1</label>
							<input id="address1" name="address1" placeholder="Type your Address here." type="text" value="<?php echo $ccms_user["address1"]; ?>">
							<label id="address1_error" class="error" for="address1" style="display:none"></label>

							<label for="address2">Address Line #2</label>
							<input id="address2" name="address2" placeholder="Type other Address info here." type="text" value="<?php echo $ccms_user["address2"]; ?>">
							<label id="address2_error" class="error" for="address2" style="display:none"></label>

							<label for="prov_state">Prov/State</label>
							<input id="prov_state" name="prov_state" placeholder="Type your Province or State here." type="text" value="<?php echo $ccms_user["prov_state"]; ?>">
							<label id="prov_state_error" class="error" for="prov_state" style="display:none"></label>

							<label for="country">Country</label>
							<input id="country" name="country" placeholder="Type your Country name here." type="text" value="<?php echo $ccms_user["country"]; ?>">
							<label id="country_error" class="error" for="country" style="display:none"></label>

							<label for="post_zip">Postal/Zipcode</label>
							<input id="post_zip" name="post_zip" placeholder="Type your Postal/Zipcode here." type="text" value="<?php echo $ccms_user["post_zip"]; ?>">
							<label id="post_zip_error" class="error" for="post_zip" style="display:none"></label>
						</div>

						<div class="inner-grid">
							<h3>Contact</h3>
							<label for="email">Email <span class="rd">*</span></label>
							<input id="email" name="email" placeholder="Type your email address here." type="text" value="<?php echo $ccms_user["email"]; ?>">
							<label id="email_error" class="error" for="email" style="display:none"></label>

							<label for="phone1">Phone #1</label>
							<input id="phone1" name="phone1" placeholder="Type your main phone number here." type="text" value="<?php echo $ccms_user["phone1"]; ?>">
							<label id="phone1_error" class="error" for="phone1" style="display:none"></label>

							<label for="phone2">Phone #2</label>
							<input id="phone2" name="phone2" placeholder="Type your secondary phone number here." type="text" value="<?php echo $ccms_user["phone2"]; ?>">
							<label id="phone2_error" class="error" for="phone2" style="display:none"></label>

							<label for="facebook">Facebook</label>
							<input id="facebook" name="facebook" placeholder="Type your facebook URI here." type="text" value="<?php echo $ccms_user["facebook"]; ?>">
							<label id="facebook_error" class="error" for="facebook" style="display:none"></label>

							<label for="skype">Skype</label>
							<input id="skype" name="skype" placeholder="Type your skype account name here." type="text" value="<?php echo $ccms_user["skype"]; ?>">
							<label id="skype_error" class="error" for="skype" style="display:none"></label>
						</div>

						<div class="inner-grid">
							<h3>Other</h3>
							<label for="note" class="control-label">Notes</label>
							<textarea name="note" id="note" cols="30" rows="4" placeholder="Type any other notes you wish to attach to your account here."><?php echo $ccms_user["note"]; ?></textarea>

							<button>Update</button>
							<button>Cancel</button>
						</div>
					</div>
				</form>
			</div>

			<div id="tab02Content" class="tabContent">
				<p>tab content #2</p>
			</div>

			<div id="tab03Content" class="tabContent">
				<p>tab content #3</p>
			</div>

			{CCMS_TPL:/footer.html}
		</main>

		{CCMS_TPL:/body-head.php}
























		<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
			{CCMS_TPL:/_js/footer-1.php}

			/*
			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/bootstrap-3.3.7.min.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);
			*/

			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/custodiancms.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);

			/*
			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/metisMenu-2.4.0.min.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);
			*/
			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/metisMenu-3.0.6.min.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);

			/*
			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/font-awesome-4.7.0.min.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);
			*/

			function loadJSResources() {
				/*loadFirst("/ccmsusr/_js/jquery-2.2.0.min.js", function() {*/
				loadFirst("/ccmsusr/_js/jquery-3.6.0.min.js", function() {
					/*loadFirst("/ccmsusr/_js/bootstrap-3.3.7.min.js", function() { */
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
