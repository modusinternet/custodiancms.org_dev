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
		let navActiveW3schoolsItem = ["nav-user_profile"];
	</script>
	<body>
		<main style="padding:20px 20px 20px 0">
			<h1 style="border-bottom:1px dashed var(--cl3)">User Profile</h1>
			<p>This section is still under development, but if you come across any unresolved issues please let us know at: <a class="oj" href="mailto:info@custodiancms.org?subject=unresolved+issue+report">info@custodiancms.org</a></p>

			<div class="tabs">
				<button class="tab active" id="tab01Title">Info</button>
				<button class="tab" id="tab02Title">Login</button>
				<button class="tab" id="tab03Title">Privileges</button>
			</div>

			<div id="tab01Content" class="tabContent" style="display:block">
				<div id="info_tab_form_success" role="alert" style="display:none;text-align:center"></div>
				<div id="info_tab_form_fail" role="alert" style="display:none;text-align:center"></div>

				<form id="info_tab_form" role="form">
					<div class="outer_grid">
						<div class="inner_grid_general">
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

						<div class="inner_grid_address">
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

						<div class="inner_grid_contact">
							<h3>Contact</h3>
							<label for="email">Email <span class="rd">*</span></label>
							<input id="email" name="email" data-rule-required="true" data-rule-email="true" placeholder="Type your email address here." type="text" value="<?php echo $ccms_user["email"]; ?>">
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

						<div class="inner_grid_other">
							<h3>Other</h3>
							<label for="note" class="control-label">Notes</label>
							<textarea id="note" name="note" placeholder="Type any notes you want to save within your account here." rows="4"><?php echo $ccms_user["note"]; ?></textarea>
							<label id="note_error" class="error" for="note" style="display:none"></label>

							<button>Update</button>
						</div>
					</div>
				</form>
			</div>

			<div id="tab02Content" class="tabContent">
				<div id="password_tab_form_success" role="alert" style="display:none;text-align:center"></div>
				<div id="password_tab_form_fail" role="alert" style="display:none;text-align:center"></div>

				<form id="password_tab_form" role="form">
					<div class="inner_grid_login">
						<input name="ajax_flag" type="hidden" value="1">
						<h3>Password</h3>
						<label for="ccms_login_password">Old Password <span class="rd">*</span></label>
						<input id="ccms_login_password" name="ccms_login_password" placeholder="Type your current password here." type="password">
						<label id="ccms_login_password_error" class="error" for="ccms_login_password" style="display:none"></label>

						<label for="ccms_pass_reset_part_2_pass_1">New Password</label>
						<input id="ccms_pass_reset_part_2_pass_1" name="ccms_pass_reset_part_2_pass_1" placeholder="Type your new password here." type="password">
						<label id="ccms_pass_reset_part_2_pass_1_error" class="error" for="ccms_pass_reset_part_2_pass_1" style="display:none"></label>

						<label for="ccms_pass_reset_part_2_pass_2">Retype</label>
						<input id="ccms_pass_reset_part_2_pass_2" name="ccms_pass_reset_part_2_pass_2" placeholder="Re-type your new password here." type="password">
						<label id="ccms_pass_reset_part_2_pass_2_error" class="error" for="ccms_pass_reset_part_2_pass_2" style="display:none"></label>
						<label for="2fa_checkbox" title="2-Factor Authentication">
							2FA?
							<a href="https://authy.com/what-is-2fa/" target="_blank" title="What is 2FA">
								<svg style="width:20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#d7680f" d="M18,10.82a1,1,0,0,0-1,1V19a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V8A1,1,0,0,1,5,7h7.18a1,1,0,0,0,0-2H5A3,3,0,0,0,2,8V19a3,3,0,0,0,3,3H16a3,3,0,0,0,3-3V11.82A1,1,0,0,0,18,10.82Zm3.92-8.2a1,1,0,0,0-.54-.54A1,1,0,0,0,21,2H15a1,1,0,0,0,0,2h3.59L8.29,14.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L20,5.41V9a1,1,0,0,0,2,0V3A1,1,0,0,0,21.92,2.62Z"/></svg>
							</a>
						</label>
						<input id="2fa_secret" type="hidden" name="2fa_secret">
						<div>
							<input type="radio" id="2fa_radio_0" name="2fa_radio" value="0">
							<label id="2fa_radio_0_label" for="2fa_radio_0">2FA Enabled</label><br>
							<input type="radio" id="2fa_radio_1" name="2fa_radio" value="1">
							<label for="2fa_radio_1">2FA Disabled</label><br>
							<input type="radio" id="2fa_radio_2" name="2fa_radio" value="2">
							<label for="2fa_radio_2">Generate new 2FA QR code</label>
						</div>
						<div id="ga_qr_div" style="display:none">
							<p>
								Scan or copy QR code into authentication tool (ie: Google Authenticator) before pressing the Update button.  You are going to be forced to relogin.
							</p>
							<h2 id="2fa_secret_text"></h2>
							<svg id="ga_qr_svg" style="display:none;width:75px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
								<path fill="#d7680f" d="M25,5A20.14,20.14,0,0,1,45,22.88a2.51,2.51,0,0,0,2.49,2.26h0A2.52,2.52,0,0,0,50,22.33a25.14,25.14,0,0,0-50,0,2.52,2.52,0,0,0,2.5,2.81h0A2.51,2.51,0,0,0,5,22.88,20.14,20.14,0,0,1,25,5Z">
									<animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="2s" repeatCount="indefinite"/>
								</path>
							</svg>
							<img id="ga_qr_img" style="display:none" />
						</div>
						<button>Update</button>
					</div>
				</form>
			</div>

			<div id="tab03Content" class="tabContent">
				<div id="privTree1"></div>
				<div id="privTree2"></div>
			</div>
			{CCMS_TPL:/footer.html}
		</main>

		{CCMS_TPL:/body-head.php}
		<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
			{CCMS_TPL:/_js/footer-1.php}

<?php if(!empty($ccms_user["2fa_secret"])): ?>
			document.getElementById("2fa_radio_0").checked = true;
<? else: ?>
			document.getElementById("2fa_radio_0").disabled = true;
			document.getElementById("2fa_radio_0").style.display = "none";
			document.getElementById("2fa_radio_0_label").style.display = "none";
			document.getElementById("2fa_radio_1").checked = true;
<? endif ?>

			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/custodiancms.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);

			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/metisMenu-3.0.6.min.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);

			/*
			var tab03Content = document.getElementById('tab03Content');
			var ul = document.createElement('ul');
			console.log("data length = [" + data.length + "]");



			for(var i = 0; i < data.length; ++i) {
				if(typeof data[i] === 'object') {
					console.log("data an object");
				} else {
					console.log("data NOT an object");
				}

				//var li = document.createElement('li');
				//li.innerHTML = data[i];
				//ul.appendChild(li);
			}
			tab03Content.appendChild(ul);



			// (B1) JSON STRING TO OBJECT
			//var data = '{"Fruits":["Durian","Elderberries","Feijoa"],"Vegetables":["Corn","Daikon","Eggplant"]}';
			//data = JSON.parse(data);

			// (B2) CREATE LIST
			var list = document.createElement("ul");
			for (let i in data) {
			  // LIST ITEM
			  let item = document.createElement("li");
			  list.appendChild(item);

			  // SUB-SECTION TITLE
			  let head = document.createElement("strong");
			  head.innerHTML = i;
			  item.appendChild(head);

			  // SUB-SECTION ITEMS
			  let sublist = document.createElement("ul");
			  item.appendChild(sublist);
			  for (let j of data[i]) {
			    let subitem = document.createElement("li");
			    subitem.innerHTML = j;
			    sublist.appendChild(subitem);
			  }
			}

			// (B3) APPEND LIST TO CONTAINER
			document.getElementById("tab03Content").appendChild(list);



			Object.entries(obj).forEach(([key, value]) => {
				if(typeof value !== 'object') {
					console.log(`${key} ${value}`);
				} else {
					console.log(`${key}`);
				}

				//const liParent = document.createElement('li');
				//liParent.innerHTML = data.value;
				//this.appendChild(liParent);
			}



						this.ul = document.getElementById("privTree");
						//this.data = {};
						//const data = JSON.parse('< ? = $ccms_user["priv"];?>');
						//this.data = JSON.parse('< ? = $ccms_user["priv"];?>');
						//const obj = JSON.parse(data);
						//console.log(JSON.stringify(obj[0]));
						//console.log(obj.dashboard);
						//console.log(obj[1].dashboard);
						//document.getElementById("tab03Content").innerHTML = JSON.stringify(obj[0][0]);

						function childs(liParent, data) {
						  // Create a new unordered list for children
						  const childList = document.createElement('ul');
						  data.children.forEach(child => {
						    const liChild = document.createElement('li');
						    liChild.innerHTML = child.value;
						    childList.appendChild(liChild);
						    if(child.children !== undefined) {
						      this.childs(liChild, child);
						    }
						  });
						  liParent.appendChild(childList);
						}

						// Hide childs function
						function hide() {
						  var ulChildren = Array.from(this.querySelectorAll('ul'));
						  var liChildren = Array.from(this.querySelectorAll('li'));

						  ulChildren.forEach(ul => {
						    ul.style.display = 'none';
						  });

						  liChildren.forEach(li => {
						    var childrenText = li.childNodes[0];
						    if(li.querySelector('ul') != null) {
						      const span = document.createElement('span');
						      span.textContent = childrenText.textContent;
						      span.style.cursor = 'pointer';
						      childrenText.parentNode.insertBefore(span, childrenText);
						      childrenText.parentNode.removeChild(childrenText);
						      span.onclick = (event) => {
						        var next = event.target.nextElementSibling;
						        if(next.style.display == '') {
						          next.style.display = 'none';
						        } else {
						          next.style.display = '';
						        }
						      }
						    }
						  });
						}

						this.data.forEach(data => {
							const liParent = document.createElement(`li`);
							liParent.innerHTML = data.value;
							this.appendChild(liParent);
							if(data.children !== undefined) {
								this.childs(liParent, data);
								this.hide();
							}
						});



			function search(array, fn) {
			    var result = [];
			    array.forEach(function iter(o) {
			        if (!o || typeof o !== 'object') {
			            return;
			        }
			        if (fn(o)) {
			            result.push(o);
			            return;
			        }
			        Object.keys(o).forEach(function (k) {
			            iter(o[k]);
			        });
			    });
			    return result;
			}

			var data = [{ tuple: { old: { MetaCategory: { MetaCatID: 517, ParentMetaCatRef: 0, Name: "D Application" } } }, MetaCatID: 517, ParentMetaCatRef: 0, Name: "D Application", subCategories: [{ tuple: { old: { MetaCategory: { MetaCatID: 518, ParentMetaCatRef: 517, Name: "Compass" } } }, MetaCatID: 518, ParentMetaCatRef: 517, Name: "Compass" }, { tuple: { old: { MetaCategory: { MetaCatID: 519, ParentMetaCatRef: 517, Name: "Orbe" } } }, MetaCatID: 519, ParentMetaCatRef: 517, Name: "Orbe" }, { tuple: { old: { MetaCategory: { MetaCatID: 520, ParentMetaCatRef: 517, Name: "PSI" } } }, MetaCatID: 520, ParentMetaCatRef: 517, Name: "PSI" }, { tuple: { old: { MetaCategory: { MetaCatID: 521, ParentMetaCatRef: 517, Name: "SAP" } } }, MetaCatID: 521, ParentMetaCatRef: 517, Name: "SAP" }] }, { tuple: { old: { MetaCategory: { MetaCatID: 541, ParentMetaCatRef: 0, Name: "D Versions" } } }, MetaCatID: 541, ParentMetaCatRef: 0, Name: "D Versions", subCategories: [{ tuple: { old: { MetaCategory: { MetaCatID: 542, ParentMetaCatRef: 541, Name: "Baseline 2016-12-31" } } }, MetaCatID: 542, ParentMetaCatRef: 541, Name: "Baseline 2016-12-31" }, { tuple: { old: { MetaCategory: { MetaCatID: 543, ParentMetaCatRef: 541, Name: "CLS step 3 2017-04-15" } } }, MetaCatID: 543, ParentMetaCatRef: 541, Name: "CLS step 3 2017-04-15" }] }, { tuple: { old: { MetaCategory: { MetaCatID: 365, ParentMetaCatRef: 0, Name: "Market" } } }, MetaCatID: 365, ParentMetaCatRef: 0, Name: "Market", subCategories: [{ tuple: { old: { MetaCategory: { MetaCatID: 366, ParentMetaCatRef: 365, Name: "Sector" } } }, MetaCatID: 366, ParentMetaCatRef: 365, Name: "Sector", subCategories: [{ tuple: { old: { MetaCategory: { MetaCatID: 463, ParentMetaCatRef: 366, Name: "term" } } }, MetaCatID: 463, ParentMetaCatRef: 366, Name: "term" }, { tuple: { old: { MetaCategory: { MetaCatID: 464, ParentMetaCatRef: 366, Name: "category" } } }, MetaCatID: 464, ParentMetaCatRef: 366, Name: "category" }, { tuple: { old: { MetaCategory: { MetaCatID: 367, ParentMetaCatRef: 366, Name: "Subsector" } } }, MetaCatID: 367, ParentMetaCatRef: 366, Name: "Subsector" }] }] }];
			console.log(data);
			console.log(search(data, function (o) { return o.MetaCatID > 500; }));
			console.log(search(data, function (o) { return o.Name && o.Name.includes('P'); }));

			document.getElementById("privTree1").innerHTML = JSON.stringify(search(data, function (o) { return o.MetaCatID > 500; }));
			document.getElementById("privTree2").innerHTML = JSON.stringify(search(data, function (o) { return o.Name && o.Name.includes('P'); }));



			for (var i = 0; i < data.length; i++) {
			  tr = $('<tr/>');
			  tr.append("<td>" + data[i].User_Name + "</td>");
			  tr.append("<td>" + data[i].score + "</td>");
			  tr.append("<td>" + data[i].team + "</td>");
			  $('table').append(tr);
			}



			var tb = document.createElement("table");
			if(data !=null) {
			  var keyOfobj = Object.keys(data);
			  var ValOfObj = Object.values(data);
			  for (var i = 0; i < keyOfobj.length; i++) {
			    var tr = document.createElement('tr');
			    var td = document.createElement('td');
			    var key = document.createTextNode(keyOfobj[i]);
			    td.appendChild(key);
			    tr.appendChild(td);
			    tb.appendChild(tr);
			    if(typeof(ValOfObj[i]) == "object") {
			      if(ValOfObj[i] !=null) {
			        tr.setAttribute("style","font-weight: bold");
			        isObject(ValOfObj[i]);
			      } else {
			        var td = document.createElement('td');
			        var value = document.createTextNode(ValOfObj[i]);
			        td.appendChild(value);
			        tr.appendChild(td);
			        tb.appendChild(tr);
			      }
			    } else {
			      var td = document.createElement('td');
			      var value = document.createTextNode(ValOfObj[i]);
			      td.appendChild(value);
			      tr.appendChild(td);
			      tb.appendChild(tr);
			    }
			  }
			}
			*/



			/*
			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/font-awesome.min.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);
			*/

			/*
			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/pickle.css";
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

								loadFirst("/ccmsusr/_js/jquery-validate-1.19.3.min.js", function() {

									loadFirst("/ccmsusr/_js/additional-methods-1.17.0.min.js", function() {

										//loadFirst("/ccmsusr/_js/pickletree.js", function() {


/*
//let data = '{}';
let data = '<  ?= $ccms_user["priv"];?>';
let target = '.root';
jsonView.format(data, target);



fetch('/{CCMS_LIB:_default.php;FUNC:ccms_lng}/user/user_profile/priv_json.php').then((res)=> {
	return res.text();
}).then((data) => {
	const tree = jsonview.create(data);
	jsonview.render(tree, document.querySelector('.root'));
	jsonview.expand(tree);
}).catch((err) => {
	console.log(err);
})
*/

const data = {Parent: {img: "father.png",name: "Jan Doe",age: "50",children: [{child: {img: "child_1.png",name: "child 1",age: "25",},},{child: {img: "child_2.png",name: "child 2",age: "22",children: [{grandChild: {img: "child_3.png",name: "grand child 1",age: "12",},},],},},{child: {img: "child_4.png",name: "child 3",age: "16",children: [{grandChild: {img: "child_5.png",name: "grand child 1",age: "18",children: [{grandgrandChild: {img: "child_6.png",name: "great grand child 1",age: "13",},},{grandgrandChild: {img: "child_7.png",name: "great grand child 2",age: "10",},},],},},],},},],},};

//const data2 = {dashboard: "1",admin: "0",sub: [{blacklist_settings: "1",github:  "1",language_support: "1",other_controls: "1",user_privileges: "1"}]},content_groups: "1",content_manager: "0",lng: {ar: 1,bn: 1,de: 1,de-at: 1,de-ch: 1,de-de: 1,de-li: 1,de-lu: 1,en: 1,en-au: 1,en-bz: 1,en-ca: 1,en-gb: 1,en-ie: 1,en-jm: 1,en-nz: 1,en-ph: 1,en-tt: 1,en-us: 1,en-za: 1,en-zw: 1,es: 1,es-ar: 1,es-bo: 1,es-cl: 1,es-co: 1,es-cr: 1,es-do: 1,es-ec: 1,es-es: 1,es-gt: 1,es-hn: 1,es-mx: 1,es-ni: 1,es-pa: 1,es-pe: 1,es-pr: 1,es-py: 1,es-sv: 1,es-uy: 1,es-ve: 1,fr: 1,fr-be: 1,fr-ca: 1,fr-ch: 1,fr-fr: 1,fr-lu: 1,fr-mc: 1,he: 1,hi: 1,ja: 1,ko: 1,ko-kp: 1,ko-kr: 1,ms: 1,nb-no: 1,pt: 1,ru: 1,vi: 1,zh: 1,zh-cn: 1,zh-tw: 1}}};

const data2 = {
	parent: {
		dashboard: "1",
		admin: "0",
		children: [
			{
				blacklist_settings: "1",
				github: "1",
				language_support: "1",
				other_controls: "1",
				user_privileges: "1"
			}
		],
		content_groups: "1",
		content_manager: "0"
	}
};

// array to hold HTML tags
let markupArray = ["<ul>"];

// evaluate expressions
const createList = (items) => {
  switch ($.type(items)) {
    case "object":
      getItems(items);
      break;
  }
};

// get items in the object
const getItems = (items) => {
  for (const item in items) {
    markupArray.push(`<li>${item}`);
    // fetch the parent object
    let details = items[item];
    getDetails(details);
    // push the closing tag for parent
    markupArray.push("</li>");
  }
};

// get details
const getDetails = (details) => {
  // iterate over the detail items of object
  for (const detail in details) {
    // fetch the value of each item
    if(detail == "img") {
      markupArray.push(
        ` img=[${details[detail]}] "> `
      );
    } else if(detail == "children") {
      markupArray.push("<ul>");
      details[detail].forEach((element) => {
        getItems(element);
      });
      markupArray.push("</ul>");
		} else if(detail == "sub"){
			markupArray.push("<ul>");
			details[detail].forEach((element) => {
				getItems(element);
			});
			markupArray.push("</ul>");
		} else {
      markupArray.push(` otherDetails=[${details[detail]}] `);
    }
  }
};

// call the function on page load
//window.onload = () => {
  createList(data2);
  markupArray.push("</ul>");
  $("#privTree1").html(markupArray.join(""));
//};












//const data = '< ? = $ccms_user["priv"];?>';
/*
const data2 = '{sub: {dashboard: {rw: 1},admin: {rw: 0,sub: [{blacklist_settings: {rw: 1},github: {rw: 1},language_support: {rw: 1},other_controls: {rw: 1},user_privileges: {rw: 1}}]},content_groups: {rw: 1},content_manager: {rw: 0,lng: {ar: 1,bn: 1,de: 1,de-at: 1,de-ch: 1,de-de: 1,de-li: 1,de-lu: 1,en: 1,en-au: 1,en-bz: 1,en-ca: 1,en-gb: 1,en-ie: 1,en-jm: 1,en-nz: 1,en-ph: 1,en-tt: 1,en-us: 1,en-za: 1,en-zw: 1,es: 1,es-ar: 1,es-bo: 1,es-cl: 1,es-co: 1,es-cr: 1,es-do: 1,es-ec: 1,es-es: 1,es-gt: 1,es-hn: 1,es-mx: 1,es-ni: 1,es-pa: 1,es-pe: 1,es-pr: 1,es-py: 1,es-sv: 1,es-uy: 1,es-ve: 1,fr: 1,fr-be: 1,fr-ca: 1,fr-ch: 1,fr-fr: 1,fr-lu: 1,fr-mc: 1,he: 1,hi: 1,ja: 1,ko: 1,ko-kp: 1,ko-kr: 1,ms: 1,nb-no: 1,pt: 1,ru: 1,vi: 1,zh: 1,zh-cn: 1,zh-tw: 1}}}}';

// array to hold HTML tags
let markupArray2 = ["<ul>"];

// evaluate expressions
const createList2 = (items) => {
	switch($.type(items)) {
		case "object":
			getItems2(items);
			break;
	}
};

// get items in the object
const getItems2 = (items) => {
	for(const item2 in items) {
		markupArray2.push(`<li> <div class="test"><span>${item2}</span>`);
		// fetch the parent object
		let details2 = items[item2];
		getDetails2(details2);
		// push the closing tag for parent
		markupArray2.push("</li>");
	}
};

// get details2
const getDetails2 = (details2) => {
	// iterate over the detail2 items of object
	for(const detail2 in details2) {
		// fetch the value of each item2
		if(detail2 == "img") {
			markupArray2.push(
				`<img src="./img/${details2[detail2]}" alt="${details2[detail2]}">`
			);
		} else if(detail2 == "children") {
			markupArray2.push("</div><ul>");
			details2[detail2].forEach((element) => {
				getItems2(element);
			});
			markupArray2.push("</ul>");
		} else {
			markupArray2.push(`<span> ${details2[detail2]} </span>`);
		}
	}
};

createList2(data2);
markupArray2.push("</ul>");
$("#privTree2").html(markupArray2.join(""));
*/






















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

										/* https://stackoverflow.com/questions/29781848/how-to-disable-browser-save-password-functionality */

										$.validator.addMethod(
											"matchRegex",
											function(value, element, regexp) {
												let re = new RegExp(regexp);
												return this.optional(element) || re.test(value);
											}, "Please check your input."
										);

										$('#info_tab_form').each(function() {
											$(this).validate({
												rules: {
													firstname: {
														maxlength: 64,
														matchRegex: /^[^\<\>&#]+$/i
													},
													lastname: {
														maxlength: 64,
														matchRegex: /^[^\<\>&#]+$/i
													},
													alias: {
														required: true,
														minlength: 4,
														maxlength: 32,
														matchRegex: /^[^\<\>&#]+$/i
													},
													position: {
														maxlength: 128,
														matchRegex: /^[^\<\>&#]+$/i
													},
													address1: {
														maxlength: 128,
														matchRegex: /^[^\<\>&#]+$/i
													},
													address2: {
														maxlength: 128,
														matchRegex: /^[^\<\>&#]+$/i
													},
													prov_state: {
														maxlength: 32,
														matchRegex: /^[^\<\>&#]+$/i
													},
													country: {
														maxlength: 64,
														matchRegex: /^[^\<\>&#]+$/i
													},
													post_zip: {
														maxlength: 32,
														matchRegex: /^[^\<\>&#]+$/i
													},
													email: {
														required: true,
														/*email: true,*/
														matchRegex: /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+([A-Z0-9]{2,4})$/i
													},
													phone1: {
														maxlength: 64,
														matchRegex: /^[^\<\>&#]+$/i
													},
													phone2: {
														maxlength: 64,
														matchRegex: /^[^\<\>&#]+$/i
													},
													skype: {
														maxlength: 32,
														matchRegex: /^[^\<\>&#]+$/i
													},
													facebook: {
														maxlength: 128,
														matchRegex: /^[^\<\>&#]+$/i
													},
													note: {
														maxlength: 1024,
														matchRegex: /^[^\<\>&#]+$/i
													}
												},
												messages: {
													firstname: {
														maxlength: "This field has a maximum length of 64 characters or less.",
														matchRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													lastname: {
														maxlength: "This field has a maximum length of 64 characters or less.",
														matchRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													alias: {
														required: "This field is required.",
														minlength: "This field has a minimum length of 4 characters or more.",
														maxlength: "This field has a maximum length of 32 characters or less.",
														matchRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													position: {
														maxlength: "This field has a maximum length of 32 characters or less.",
														matchRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													address1: {
														maxlength: "This field has a maximum length of 128 characters or less.",
														matchRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													address2: {
														maxlength: "This field has a maximum length of 128 characters or less.",
														matchRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													prov_state: {
														maxlength: "This field has a maximum length of 32 characters or less.",
														matchRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													country: {
														maxlength: "This field has a maximum length of 64 characters or less.",
														matchRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													post_zip: {
														maxlength: "This field has a maximum length of 32 characters or less.",
														matchRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													email: {
														required: "Please enter a valid email address.",
														matchRegex: "Please enter a valid email address. FYI: The following characters are not permitted in this field.  ( > < & # )"
													},
													phone1: {
														maxlength: "This field has a maximum length of 64 characters or less.",
														matchRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													phone2: {
														maxlength: "This field has a maximum length of 64 characters or less.",
														matchRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													skype: {
														maxlength: "This field has a maximum length of 32 characters or less.",
														matchRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													facebook: {
														maxlength: "This field has a maximum length of 128 characters or less.",
														matchRegex: "The following characters are not permitted in this field.  ( > < & # )"
													},
													note: {
														maxlength: "This field has a maximum length of 1024 characters or less.",
														matchRegex: "The following characters are not permitted in this field.  ( > < & # )"
													}
												},
												submitHandler: function(form) {
													let request;
													// Abort any pending request.
													if(request) request.abort();
													let $inputs = $(form).find("input, select, textarea, button");
													let serializedData = $(form).serialize();
													// Disable the inputs for the duration of the ajax request.
													$inputs.prop("disabled", true);
													request = $.ajax({
														url: "/{CCMS_LIB:_default.php;FUNC:ccms_lng}/user/user_profile/info_ajax.php",
														cache: false,
														type: "post",
														data: serializedData
													});
													// Called on success.
													request.done(function(msg) {
														var obj = JSON.parse(msg);
														if(obj.success === "1") {
															//$(form).find('[name="form-status"]').html("Info form updated.");
															$("#info_tab_form_fail").css("display", "none");
															$("#info_tab_form_success").html("Changes saved.");
															$("#info_tab_form_success").css("display", "block");
															$("#info_tab_form_success").scrollView();
															setTimeout(function() {
																//$(form).find('[name="form-status"]').html("");
																//$(form).find('[name="FromEmail"]').val("");
																//$(form).find('[name="ToEmail"]').val("");
																//$(form).find('[name="Message"]').val("");
																$("#info_tab_form_success").css("display", "none");
															}, 15000);
														} else {
															//$(form).find('[name="form-status"]').html(msg);
															$("#info_tab_form_success").css("display", "none");
															$("#info_tab_form_fail").html(obj.error);
															$("#info_tab_form_fail").css("display", "block");
															$("#info_tab_form_fail").scrollView();
														}
													});
													// Called on failure.
													request.fail(function (jqXHR, textStatus, errorThrown){
														// log the error to the console
														//console.error( "The following error occured: " + textStatus, errorThrown );
														console.error( "textStatus: " + textStatus );
														console.error( "errorThrown: " + errorThrown );
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

										/* Administrator QR Generator START */
 										document.getElementById("2fa_radio_2").addEventListener("click", () => {
 											var twofa_checkbox = document.getElementById('2fa_radio_2');
 											if(twofa_checkbox.checked){
 												document.getElementById("ga_qr_img").style.display = "none";
 												document.getElementById("ga_qr_div").style.display = "block";
 												document.getElementById("ga_qr_svg").style.display = "block";
												fetch("https://custodiancms.org/cross-origin-resources/ga-qr-generater.php<?php if(isset($CFG["DOMAIN"])){echo "?domain=" . $CFG["DOMAIN"];}?>")
		 										.then(response => response.json())
		 										.then(data => {
													document.getElementById("2fa_secret").value = data.ga_qr_secret;
													document.getElementById("2fa_secret_text").innerHTML = data.ga_qr_secret;
													document.getElementById("ga_qr_img").src = data.ga_qr_url;
													window.setTimeout(function() {
														document.getElementById("ga_qr_img").style.display = "block";
														document.getElementById("ga_qr_svg").style.display = "none";
													},3000);
		 										}).catch(console.error);
											}
										});
										/* Administrator QR Generator END */

										/* If '2FA Disabled' selected, remove posible generated QR code from view. */
										document.getElementById("2fa_radio_1").addEventListener("click", () => {
											document.getElementById("2fa_secret").value = "";
											document.getElementById("2fa_secret_text").innerHTML = "";
											document.getElementById("ga_qr_img").style.display = "none";
											document.getElementById("ga_qr_div").style.display = "none";
											document.getElementById("ga_qr_svg").style.display = "none";
										});

										$('#password_tab_form').each(function() {
											$(this).validate({
												rules: {
													ccms_login_password: {
														required: true,
														minlength: 8
													},
													ccms_pass_reset_part_2_pass_1: {
														minlength: 8,
														equalTo: "#ccms_pass_reset_part_2_pass_2"
													},
													ccms_pass_reset_part_2_pass_2: {
														minlength: 8,
														equalTo: "#ccms_pass_reset_part_2_pass_1"
													}
												},
												messages: {
													ccms_login_password: {
														required: "This field is required.",
														maxlength: "This field has a minimum length of 8 characters or more."
													},
													ccms_pass_reset_part_2_pass_1: {
														maxlength: "This field has a minimum length of 8 characters or more.",
														equalTo: "'New Password' and 'Repeat New Password' are not the same."
													},
													ccms_pass_reset_part_2_pass_2: {
														maxlength: "This field has a minimum length of 8 characters or more.",
														equalTo: "'New Password' and 'Repeat New Password' are not the same."
													}
												},
												submitHandler: function(form) {
													let request;
													// Abort any pending request.
													if (request) request.abort();
													let $inputs = $(form).find("input, select, textarea, button");
													let serializedData = $(form).serialize();
													// Disable the inputs for the duration of the ajax request.
													$inputs.prop("disabled", true);
													request = $.ajax({
														url: "/{CCMS_LIB:_default.php;FUNC:ccms_lng}/user/user_profile/password_ajax.php",
														cache: false,
														type: "post",
														data: serializedData
													});
													// Called on success.
													request.done(function(msg) {
														var obj = JSON.parse(msg);
														/*
														if(data.success === "0") { // already blocked
			 												console.log(ip + " already blocked");
			 												alert(ip + " already blocked");
			 											} else if(data.success === "1") { // blocked
			 												console.log(ip + " blocked");
			 												alert(ip + " blocked");
			 											} else if(data.error === "Session Error") {
			 												document.getElementById("ccms_security_logs").innerHTML = "Session Error";
			 											} else {
			 												document.getElementById("ccms_security_logs").innerHTML = "Error: See console for more detail.";
			 												console.log(data);
			 											}
														*/

														if(obj.success === "1") {
															//$(form).find('[name="form-status"]').html("Password form updated.");
															$("#password_tab_form_fail").css("display", "none");
															$("#password_tab_form_success").html("Success: Updates saved.");
															$("#password_tab_form_success").css("display", "block");
															$("#password_tab_form_success").scrollView();
															document.getElementById("2fa_secret").value = "";
															document.getElementById("2fa_secret_text").innerHTML = "";
															document.getElementById("ga_qr_img").style.display = "none";
															document.getElementById("ga_qr_div").style.display = "none";
															document.getElementById("ga_qr_svg").style.display = "none";
															var twoFa_but = document.querySelector("input[type='radio'][name='2fa_radio']:checked");
															if(twoFa_but.value == "1"){
																document.getElementById("2fa_radio_0").disabled = true;
																document.getElementById("2fa_radio_0").style.display = "none";
																document.getElementById("2fa_radio_0_label").style.display = "none";
																document.getElementById("2fa_radio_1").checked = true;
															} else if(twoFa_but.value == "2"){
																document.getElementById("2fa_radio_0").disabled = false;
																document.getElementById("2fa_radio_0").style.display = "initial";
																document.getElementById("2fa_radio_0_label").style.display = "initial";
																document.getElementById("2fa_radio_0").checked = true;
																location.reload(true);
															}
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
															$("#password_tab_form_fail").html(obj.error);
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
															$("#ccms_login_password").val("");
															$("#ccms_pass_reset_part_2_pass_1").val("");
															$("#ccms_pass_reset_part_2_pass_2").val("");
														}, 5000);
													});
													// Prevent default posting of form.
													return false;
												}
											});
										});




										//});
									});
								});
							});
						/*});*/
					});
				});
			}
		</script>
	</body>
</html>
