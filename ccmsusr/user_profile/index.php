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



















		.swal2-popup.swal2-toast{flex-direction:row;align-items:center;width:auto;padding:.625em;overflow-y:hidden;background:#fff;box-shadow:0 0 .625em #d9d9d9}.swal2-popup.swal2-toast .swal2-header{flex-direction:row;padding:0}.swal2-popup.swal2-toast .swal2-title{flex-grow:1;justify-content:flex-start;margin:0 .6em;font-size:1em}.swal2-popup.swal2-toast .swal2-footer{margin:.5em 0 0;padding:.5em 0 0;font-size:.8em}.swal2-popup.swal2-toast .swal2-close{position:static;width:.8em;height:.8em;line-height:.8}.swal2-popup.swal2-toast .swal2-content{justify-content:flex-start;padding:0;font-size:1em}.swal2-popup.swal2-toast .swal2-icon{width:2em;min-width:2em;height:2em;margin:0}.swal2-popup.swal2-toast .swal2-icon .swal2-icon-content{display:flex;align-items:center;font-size:1.8em;font-weight:700}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-popup.swal2-toast .swal2-icon .swal2-icon-content{font-size:.25em}}.swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line]{top:.875em;width:1.375em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:.3125em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:.3125em}.swal2-popup.swal2-toast .swal2-actions{flex-basis:auto!important;width:auto;height:auto;margin:0 .3125em}.swal2-popup.swal2-toast .swal2-styled{margin:0 .3125em;padding:.3125em .625em;font-size:1em}.swal2-popup.swal2-toast .swal2-styled:focus{box-shadow:0 0 0 1px #fff,0 0 0 3px rgba(50,100,150,.4)}.swal2-popup.swal2-toast .swal2-success{border-color:#a5dc86}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line]{position:absolute;width:1.6em;height:3em;transform:rotate(45deg);border-radius:50%}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=left]{top:-.8em;left:-.5em;transform:rotate(-45deg);transform-origin:2em 2em;border-radius:4em 0 0 4em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=right]{top:-.25em;left:.9375em;transform-origin:0 1.5em;border-radius:0 4em 4em 0}.swal2-popup.swal2-toast .swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-success .swal2-success-fix{top:0;left:.4375em;width:.4375em;height:2.6875em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line]{height:.3125em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=tip]{top:1.125em;left:.1875em;width:.75em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=long]{top:.9375em;right:.1875em;width:1.375em}.swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-tip{-webkit-animation:swal2-toast-animate-success-line-tip .75s;animation:swal2-toast-animate-success-line-tip .75s}.swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-long{-webkit-animation:swal2-toast-animate-success-line-long .75s;animation:swal2-toast-animate-success-line-long .75s}.swal2-popup.swal2-toast.swal2-show{-webkit-animation:swal2-toast-show .5s;animation:swal2-toast-show .5s}.swal2-popup.swal2-toast.swal2-hide{-webkit-animation:swal2-toast-hide .1s forwards;animation:swal2-toast-hide .1s forwards}.swal2-container{display:flex;position:fixed;z-index:1060;top:0;right:0;bottom:0;left:0;flex-direction:row;align-items:center;justify-content:center;padding:.625em;overflow-x:hidden;transition:background-color .1s;-webkit-overflow-scrolling:touch}.swal2-container.swal2-backdrop-show,.swal2-container.swal2-noanimation{background:rgba(0,0,0,.4)}.swal2-container.swal2-backdrop-hide{background:0 0!important}.swal2-container.swal2-top{align-items:flex-start}.swal2-container.swal2-top-left,.swal2-container.swal2-top-start{align-items:flex-start;justify-content:flex-start}.swal2-container.swal2-top-end,.swal2-container.swal2-top-right{align-items:flex-start;justify-content:flex-end}.swal2-container.swal2-center{align-items:center}.swal2-container.swal2-center-left,.swal2-container.swal2-center-start{align-items:center;justify-content:flex-start}.swal2-container.swal2-center-end,.swal2-container.swal2-center-right{align-items:center;justify-content:flex-end}.swal2-container.swal2-bottom{align-items:flex-end}.swal2-container.swal2-bottom-left,.swal2-container.swal2-bottom-start{align-items:flex-end;justify-content:flex-start}.swal2-container.swal2-bottom-end,.swal2-container.swal2-bottom-right{align-items:flex-end;justify-content:flex-end}.swal2-container.swal2-bottom-end>:first-child,.swal2-container.swal2-bottom-left>:first-child,.swal2-container.swal2-bottom-right>:first-child,.swal2-container.swal2-bottom-start>:first-child,.swal2-container.swal2-bottom>:first-child{margin-top:auto}.swal2-container.swal2-grow-fullscreen>.swal2-modal{display:flex!important;flex:1;align-self:stretch;justify-content:center}.swal2-container.swal2-grow-row>.swal2-modal{display:flex!important;flex:1;align-content:center;justify-content:center}.swal2-container.swal2-grow-column{flex:1;flex-direction:column}.swal2-container.swal2-grow-column.swal2-bottom,.swal2-container.swal2-grow-column.swal2-center,.swal2-container.swal2-grow-column.swal2-top{align-items:center}.swal2-container.swal2-grow-column.swal2-bottom-left,.swal2-container.swal2-grow-column.swal2-bottom-start,.swal2-container.swal2-grow-column.swal2-center-left,.swal2-container.swal2-grow-column.swal2-center-start,.swal2-container.swal2-grow-column.swal2-top-left,.swal2-container.swal2-grow-column.swal2-top-start{align-items:flex-start}.swal2-container.swal2-grow-column.swal2-bottom-end,.swal2-container.swal2-grow-column.swal2-bottom-right,.swal2-container.swal2-grow-column.swal2-center-end,.swal2-container.swal2-grow-column.swal2-center-right,.swal2-container.swal2-grow-column.swal2-top-end,.swal2-container.swal2-grow-column.swal2-top-right{align-items:flex-end}.swal2-container.swal2-grow-column>.swal2-modal{display:flex!important;flex:1;align-content:center;justify-content:center}.swal2-container.swal2-no-transition{transition:none!important}.swal2-container:not(.swal2-top):not(.swal2-top-start):not(.swal2-top-end):not(.swal2-top-left):not(.swal2-top-right):not(.swal2-center-start):not(.swal2-center-end):not(.swal2-center-left):not(.swal2-center-right):not(.swal2-bottom):not(.swal2-bottom-start):not(.swal2-bottom-end):not(.swal2-bottom-left):not(.swal2-bottom-right):not(.swal2-grow-fullscreen)>.swal2-modal{margin:auto}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-container .swal2-modal{margin:0!important}}.swal2-popup{display:none;position:relative;box-sizing:border-box;flex-direction:column;justify-content:center;width:32em;max-width:100%;padding:1.25em;border:none;border-radius:.3125em;background:#fff;font-family:inherit;font-size:1rem}.swal2-popup:focus{outline:0}.swal2-popup.swal2-loading{overflow-y:hidden}.swal2-header{display:flex;flex-direction:column;align-items:center;padding:0 1.8em}.swal2-title{position:relative;max-width:100%;margin:0 0 .4em;padding:0;color:#595959;font-size:1.875em;font-weight:600;text-align:center;text-transform:none;word-wrap:break-word}.swal2-actions{display:flex;z-index:1;flex-wrap:wrap;align-items:center;justify-content:center;width:100%;margin:1.25em auto 0}.swal2-actions:not(.swal2-loading) .swal2-styled[disabled]{opacity:.4}.swal2-actions:not(.swal2-loading) .swal2-styled:hover{background-image:linear-gradient(rgba(0,0,0,.1),rgba(0,0,0,.1))}.swal2-actions:not(.swal2-loading) .swal2-styled:active{background-image:linear-gradient(rgba(0,0,0,.2),rgba(0,0,0,.2))}.swal2-actions.swal2-loading .swal2-styled.swal2-confirm{box-sizing:border-box;width:2.5em;height:2.5em;margin:.46875em;padding:0;-webkit-animation:swal2-rotate-loading 1.5s linear 0s infinite normal;animation:swal2-rotate-loading 1.5s linear 0s infinite normal;border:.25em solid transparent;border-radius:100%;border-color:transparent;background-color:transparent!important;color:transparent!important;cursor:default;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.swal2-actions.swal2-loading .swal2-styled.swal2-cancel{margin-right:30px;margin-left:30px}.swal2-actions.swal2-loading :not(.swal2-styled).swal2-confirm::after{content:"";display:inline-block;width:15px;height:15px;margin-left:5px;-webkit-animation:swal2-rotate-loading 1.5s linear 0s infinite normal;animation:swal2-rotate-loading 1.5s linear 0s infinite normal;border:3px solid #999;border-radius:50%;border-right-color:transparent;box-shadow:1px 1px 1px #fff}.swal2-styled{margin:.3125em;padding:.625em 2em;box-shadow:none;font-weight:500}.swal2-styled:not([disabled]){cursor:pointer}.swal2-styled.swal2-confirm{border:0;border-radius:.25em;background:initial;background-color:#3085d6;color:#fff;font-size:1.0625em}.swal2-styled.swal2-cancel{border:0;border-radius:.25em;background:initial;background-color:#aaa;color:#fff;font-size:1.0625em}.swal2-styled:focus{outline:0;box-shadow:0 0 0 1px #fff,0 0 0 3px rgba(50,100,150,.4)}.swal2-styled::-moz-focus-inner{border:0}.swal2-footer{justify-content:center;margin:1.25em 0 0;padding:1em 0 0;border-top:1px solid #eee;color:#545454;font-size:1em}.swal2-timer-progress-bar-container{position:absolute;right:0;bottom:0;left:0;height:.25em;overflow:hidden;border-bottom-right-radius:.3125em;border-bottom-left-radius:.3125em}.swal2-timer-progress-bar{width:100%;height:.25em;background:rgba(0,0,0,.2)}.swal2-image{max-width:100%;margin:1.25em auto}.swal2-close{position:absolute;z-index:2;top:0;right:0;align-items:center;justify-content:center;width:1.2em;height:1.2em;padding:0;overflow:hidden;transition:color .1s ease-out;border:none;border-radius:0;background:0 0;color:#ccc;font-family:serif;font-size:2.5em;line-height:1.2;cursor:pointer}.swal2-close:hover{transform:none;background:0 0;color:#f27474}.swal2-close::-moz-focus-inner{border:0}.swal2-content{z-index:1;justify-content:center;margin:0;padding:0 1.6em;color:#545454;font-size:1.125em;font-weight:400;line-height:normal;text-align:center;word-wrap:break-word}.swal2-checkbox,.swal2-file,.swal2-input,.swal2-radio,.swal2-select,.swal2-textarea{margin:1em auto}.swal2-file,.swal2-input,.swal2-textarea{box-sizing:border-box;width:100%;transition:border-color .3s,box-shadow .3s;border:1px solid #d9d9d9;border-radius:.1875em;background:inherit;box-shadow:inset 0 1px 1px rgba(0,0,0,.06);color:inherit;font-size:1.125em}.swal2-file.swal2-inputerror,.swal2-input.swal2-inputerror,.swal2-textarea.swal2-inputerror{border-color:#f27474!important;box-shadow:0 0 2px #f27474!important}.swal2-file:focus,.swal2-input:focus,.swal2-textarea:focus{border:1px solid #b4dbed;outline:0;box-shadow:0 0 3px #c4e6f5}.swal2-file::-moz-placeholder,.swal2-input::-moz-placeholder,.swal2-textarea::-moz-placeholder{color:#ccc}.swal2-file:-ms-input-placeholder,.swal2-input:-ms-input-placeholder,.swal2-textarea:-ms-input-placeholder{color:#ccc}.swal2-file::-ms-input-placeholder,.swal2-input::-ms-input-placeholder,.swal2-textarea::-ms-input-placeholder{color:#ccc}.swal2-file::placeholder,.swal2-input::placeholder,.swal2-textarea::placeholder{color:#ccc}.swal2-range{margin:1em auto;background:#fff}.swal2-range input{width:80%}.swal2-range output{width:20%;color:inherit;font-weight:600;text-align:center}.swal2-range input,.swal2-range output{height:2.625em;padding:0;font-size:1.125em;line-height:2.625em}.swal2-input{height:2.625em;padding:0 .75em}.swal2-input[type=number]{max-width:10em}.swal2-file{background:inherit;font-size:1.125em}.swal2-textarea{height:6.75em;padding:.75em}.swal2-select{min-width:50%;max-width:100%;padding:.375em .625em;background:inherit;color:inherit;font-size:1.125em}.swal2-checkbox,.swal2-radio{align-items:center;justify-content:center;background:#fff;color:inherit}.swal2-checkbox label,.swal2-radio label{margin:0 .6em;font-size:1.125em}.swal2-checkbox input,.swal2-radio input{margin:0 .4em}.swal2-validation-message{display:none;align-items:center;justify-content:center;padding:.625em;overflow:hidden;background:#f0f0f0;color:#666;font-size:1em;font-weight:300}.swal2-validation-message::before{content:"!";display:inline-block;width:1.5em;min-width:1.5em;height:1.5em;margin:0 .625em;border-radius:50%;background-color:#f27474;color:#fff;font-weight:600;line-height:1.5em;text-align:center}.swal2-icon{position:relative;box-sizing:content-box;justify-content:center;width:5em;height:5em;margin:1.25em auto 1.875em;border:.25em solid transparent;border-radius:50%;font-family:inherit;line-height:5em;cursor:default;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.swal2-icon .swal2-icon-content{display:flex;align-items:center;font-size:3.75em}.swal2-icon.swal2-error{border-color:#f27474;color:#f27474}.swal2-icon.swal2-error .swal2-x-mark{position:relative;flex-grow:1}.swal2-icon.swal2-error [class^=swal2-x-mark-line]{display:block;position:absolute;top:2.3125em;width:2.9375em;height:.3125em;border-radius:.125em;background-color:#f27474}.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:1.0625em;transform:rotate(45deg)}.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:1em;transform:rotate(-45deg)}.swal2-icon.swal2-error.swal2-icon-show{-webkit-animation:swal2-animate-error-icon .5s;animation:swal2-animate-error-icon .5s}.swal2-icon.swal2-error.swal2-icon-show .swal2-x-mark{-webkit-animation:swal2-animate-error-x-mark .5s;animation:swal2-animate-error-x-mark .5s}.swal2-icon.swal2-warning{border-color:#facea8;color:#f8bb86}.swal2-icon.swal2-info{border-color:#9de0f6;color:#3fc3ee}.swal2-icon.swal2-question{border-color:#c9dae1;color:#87adbd}.swal2-icon.swal2-success{border-color:#a5dc86;color:#a5dc86}.swal2-icon.swal2-success [class^=swal2-success-circular-line]{position:absolute;width:3.75em;height:7.5em;transform:rotate(45deg);border-radius:50%}.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=left]{top:-.4375em;left:-2.0635em;transform:rotate(-45deg);transform-origin:3.75em 3.75em;border-radius:7.5em 0 0 7.5em}.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=right]{top:-.6875em;left:1.875em;transform:rotate(-45deg);transform-origin:0 3.75em;border-radius:0 7.5em 7.5em 0}.swal2-icon.swal2-success .swal2-success-ring{position:absolute;z-index:2;top:-.25em;left:-.25em;box-sizing:content-box;width:100%;height:100%;border:.25em solid rgba(165,220,134,.3);border-radius:50%}.swal2-icon.swal2-success .swal2-success-fix{position:absolute;z-index:1;top:.5em;left:1.625em;width:.4375em;height:5.625em;transform:rotate(-45deg)}.swal2-icon.swal2-success [class^=swal2-success-line]{display:block;position:absolute;z-index:2;height:.3125em;border-radius:.125em;background-color:#a5dc86}.swal2-icon.swal2-success [class^=swal2-success-line][class$=tip]{top:2.875em;left:.8125em;width:1.5625em;transform:rotate(45deg)}.swal2-icon.swal2-success [class^=swal2-success-line][class$=long]{top:2.375em;right:.5em;width:2.9375em;transform:rotate(-45deg)}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-tip{-webkit-animation:swal2-animate-success-line-tip .75s;animation:swal2-animate-success-line-tip .75s}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-long{-webkit-animation:swal2-animate-success-line-long .75s;animation:swal2-animate-success-line-long .75s}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-circular-line-right{-webkit-animation:swal2-rotate-success-circular-line 4.25s ease-in;animation:swal2-rotate-success-circular-line 4.25s ease-in}.swal2-progress-steps{align-items:center;margin:0 0 1.25em;padding:0;background:inherit;font-weight:600}.swal2-progress-steps li{display:inline-block;position:relative}.swal2-progress-steps .swal2-progress-step{z-index:20;width:2em;height:2em;border-radius:2em;background:#3085d6;color:#fff;line-height:2em;text-align:center}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step{background:#3085d6}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step{background:#add8e6;color:#fff}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step-line{background:#add8e6}.swal2-progress-steps .swal2-progress-step-line{z-index:10;width:2.5em;height:.4em;margin:0 -1px;background:#3085d6}[class^=swal2]{-webkit-tap-highlight-color:transparent}.swal2-show{-webkit-animation:swal2-show .3s;animation:swal2-show .3s}.swal2-hide{-webkit-animation:swal2-hide .15s forwards;animation:swal2-hide .15s forwards}.swal2-noanimation{transition:none}.swal2-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}.swal2-rtl .swal2-close{right:auto;left:0}.swal2-rtl .swal2-timer-progress-bar{right:0;left:auto}@supports (-ms-accelerator:true){.swal2-range input{width:100%!important}.swal2-range output{display:none}}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-range input{width:100%!important}.swal2-range output{display:none}}@-moz-document url-prefix(){.swal2-close:focus{outline:2px solid rgba(50,100,150,.4)}}@-webkit-keyframes swal2-toast-show{0%{transform:translateY(-.625em) rotateZ(2deg)}33%{transform:translateY(0) rotateZ(-2deg)}66%{transform:translateY(.3125em) rotateZ(2deg)}100%{transform:translateY(0) rotateZ(0)}}@keyframes swal2-toast-show{0%{transform:translateY(-.625em) rotateZ(2deg)}33%{transform:translateY(0) rotateZ(-2deg)}66%{transform:translateY(.3125em) rotateZ(2deg)}100%{transform:translateY(0) rotateZ(0)}}@-webkit-keyframes swal2-toast-hide{100%{transform:rotateZ(1deg);opacity:0}}@keyframes swal2-toast-hide{100%{transform:rotateZ(1deg);opacity:0}}@-webkit-keyframes swal2-toast-animate-success-line-tip{0%{top:.5625em;left:.0625em;width:0}54%{top:.125em;left:.125em;width:0}70%{top:.625em;left:-.25em;width:1.625em}84%{top:1.0625em;left:.75em;width:.5em}100%{top:1.125em;left:.1875em;width:.75em}}@keyframes swal2-toast-animate-success-line-tip{0%{top:.5625em;left:.0625em;width:0}54%{top:.125em;left:.125em;width:0}70%{top:.625em;left:-.25em;width:1.625em}84%{top:1.0625em;left:.75em;width:.5em}100%{top:1.125em;left:.1875em;width:.75em}}@-webkit-keyframes swal2-toast-animate-success-line-long{0%{top:1.625em;right:1.375em;width:0}65%{top:1.25em;right:.9375em;width:0}84%{top:.9375em;right:0;width:1.125em}100%{top:.9375em;right:.1875em;width:1.375em}}@keyframes swal2-toast-animate-success-line-long{0%{top:1.625em;right:1.375em;width:0}65%{top:1.25em;right:.9375em;width:0}84%{top:.9375em;right:0;width:1.125em}100%{top:.9375em;right:.1875em;width:1.375em}}@-webkit-keyframes swal2-show{0%{transform:scale(.7)}45%{transform:scale(1.05)}80%{transform:scale(.95)}100%{transform:scale(1)}}@keyframes swal2-show{0%{transform:scale(.7)}45%{transform:scale(1.05)}80%{transform:scale(.95)}100%{transform:scale(1)}}@-webkit-keyframes swal2-hide{0%{transform:scale(1);opacity:1}100%{transform:scale(.5);opacity:0}}@keyframes swal2-hide{0%{transform:scale(1);opacity:1}100%{transform:scale(.5);opacity:0}}@-webkit-keyframes swal2-animate-success-line-tip{0%{top:1.1875em;left:.0625em;width:0}54%{top:1.0625em;left:.125em;width:0}70%{top:2.1875em;left:-.375em;width:3.125em}84%{top:3em;left:1.3125em;width:1.0625em}100%{top:2.8125em;left:.8125em;width:1.5625em}}@keyframes swal2-animate-success-line-tip{0%{top:1.1875em;left:.0625em;width:0}54%{top:1.0625em;left:.125em;width:0}70%{top:2.1875em;left:-.375em;width:3.125em}84%{top:3em;left:1.3125em;width:1.0625em}100%{top:2.8125em;left:.8125em;width:1.5625em}}@-webkit-keyframes swal2-animate-success-line-long{0%{top:3.375em;right:2.875em;width:0}65%{top:3.375em;right:2.875em;width:0}84%{top:2.1875em;right:0;width:3.4375em}100%{top:2.375em;right:.5em;width:2.9375em}}@keyframes swal2-animate-success-line-long{0%{top:3.375em;right:2.875em;width:0}65%{top:3.375em;right:2.875em;width:0}84%{top:2.1875em;right:0;width:3.4375em}100%{top:2.375em;right:.5em;width:2.9375em}}@-webkit-keyframes swal2-rotate-success-circular-line{0%{transform:rotate(-45deg)}5%{transform:rotate(-45deg)}12%{transform:rotate(-405deg)}100%{transform:rotate(-405deg)}}@keyframes swal2-rotate-success-circular-line{0%{transform:rotate(-45deg)}5%{transform:rotate(-45deg)}12%{transform:rotate(-405deg)}100%{transform:rotate(-405deg)}}@-webkit-keyframes swal2-animate-error-x-mark{0%{margin-top:1.625em;transform:scale(.4);opacity:0}50%{margin-top:1.625em;transform:scale(.4);opacity:0}80%{margin-top:-.375em;transform:scale(1.15)}100%{margin-top:0;transform:scale(1);opacity:1}}@keyframes swal2-animate-error-x-mark{0%{margin-top:1.625em;transform:scale(.4);opacity:0}50%{margin-top:1.625em;transform:scale(.4);opacity:0}80%{margin-top:-.375em;transform:scale(1.15)}100%{margin-top:0;transform:scale(1);opacity:1}}@-webkit-keyframes swal2-animate-error-icon{0%{transform:rotateX(100deg);opacity:0}100%{transform:rotateX(0);opacity:1}}@keyframes swal2-animate-error-icon{0%{transform:rotateX(100deg);opacity:0}100%{transform:rotateX(0);opacity:1}}@-webkit-keyframes swal2-rotate-loading{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}@keyframes swal2-rotate-loading{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow:hidden}body.swal2-height-auto{height:auto!important}body.swal2-no-backdrop .swal2-container{top:auto;right:auto;bottom:auto;left:auto;max-width:calc(100% - .625em * 2);background-color:transparent!important}body.swal2-no-backdrop .swal2-container>.swal2-modal{box-shadow:0 0 10px rgba(0,0,0,.4)}body.swal2-no-backdrop .swal2-container.swal2-top{top:0;left:50%;transform:translateX(-50%)}body.swal2-no-backdrop .swal2-container.swal2-top-left,body.swal2-no-backdrop .swal2-container.swal2-top-start{top:0;left:0}body.swal2-no-backdrop .swal2-container.swal2-top-end,body.swal2-no-backdrop .swal2-container.swal2-top-right{top:0;right:0}body.swal2-no-backdrop .swal2-container.swal2-center{top:50%;left:50%;transform:translate(-50%,-50%)}body.swal2-no-backdrop .swal2-container.swal2-center-left,body.swal2-no-backdrop .swal2-container.swal2-center-start{top:50%;left:0;transform:translateY(-50%)}body.swal2-no-backdrop .swal2-container.swal2-center-end,body.swal2-no-backdrop .swal2-container.swal2-center-right{top:50%;right:0;transform:translateY(-50%)}body.swal2-no-backdrop .swal2-container.swal2-bottom{bottom:0;left:50%;transform:translateX(-50%)}body.swal2-no-backdrop .swal2-container.swal2-bottom-left,body.swal2-no-backdrop .swal2-container.swal2-bottom-start{bottom:0;left:0}body.swal2-no-backdrop .swal2-container.swal2-bottom-end,body.swal2-no-backdrop .swal2-container.swal2-bottom-right{right:0;bottom:0}@media print{body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow-y:scroll!important}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown)>[aria-hidden=true]{display:none}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) .swal2-container{position:static!important}}body.swal2-toast-shown .swal2-container{background-color:transparent}body.swal2-toast-shown .swal2-container.swal2-top{top:0;right:auto;bottom:auto;left:50%;transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-top-end,body.swal2-toast-shown .swal2-container.swal2-top-right{top:0;right:0;bottom:auto;left:auto}body.swal2-toast-shown .swal2-container.swal2-top-left,body.swal2-toast-shown .swal2-container.swal2-top-start{top:0;right:auto;bottom:auto;left:0}body.swal2-toast-shown .swal2-container.swal2-center-left,body.swal2-toast-shown .swal2-container.swal2-center-start{top:50%;right:auto;bottom:auto;left:0;transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-center{top:50%;right:auto;bottom:auto;left:50%;transform:translate(-50%,-50%)}body.swal2-toast-shown .swal2-container.swal2-center-end,body.swal2-toast-shown .swal2-container.swal2-center-right{top:50%;right:0;bottom:auto;left:auto;transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-left,body.swal2-toast-shown .swal2-container.swal2-bottom-start{top:auto;right:auto;bottom:0;left:0}body.swal2-toast-shown .swal2-container.swal2-bottom{top:auto;right:auto;bottom:0;left:50%;transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-end,body.swal2-toast-shown .swal2-container.swal2-bottom-right{top:auto;right:0;bottom:0;left:auto}body.swal2-toast-column .swal2-toast{flex-direction:column;align-items:stretch}body.swal2-toast-column .swal2-toast .swal2-actions{flex:1;align-self:stretch;height:2.2em;margin-top:.3125em}body.swal2-toast-column .swal2-toast .swal2-loading{justify-content:center}body.swal2-toast-column .swal2-toast .swal2-input{height:2em;margin:.3125em auto;font-size:1em}body.swal2-toast-column .swal2-toast .swal2-validation-message{font-size:1em}












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
				<!-- div id="div_tree" class="tree"></div>
				<label>Add New Item</label><br>
				<input id="in_item" class="form-control form-control-sm" type="text"/>
				<button id="btn_add" class="btn btn-sm btn-danger" style="margin-left: 10px;">Add</button><br>
				<button id="btn_getSelected" class="btn btn-sm btn-danger btn-block">Get Selected Items From Tree</button><br>
				<textarea id="txt_log" rows="5" class="form-control"></textarea -->
				<p style="font-weight:bold">Original</p><br>
				{ tuple: { old: { MetaCategory: { MetaCatID: 517, ParentMetaCatRef: 0, Name: "D Application" } } }, MetaCatID: 517, ParentMetaCatRef: 0, Name: "D Application", subCategories: [{ tuple: { old: { MetaCategory: { MetaCatID: 518, ParentMetaCatRef: 517, Name: "Compass" } } }, MetaCatID: 518, ParentMetaCatRef: 517, Name: "Compass" }, { tuple: { old: { MetaCategory: { MetaCatID: 519, ParentMetaCatRef: 517, Name: "Orbe" } } }, MetaCatID: 519, ParentMetaCatRef: 517, Name: "Orbe" }, { tuple: { old: { MetaCategory: { MetaCatID: 520, ParentMetaCatRef: 517, Name: "PSI" } } }, MetaCatID: 520, ParentMetaCatRef: 517, Name: "PSI" }, { tuple: { old: { MetaCategory: { MetaCatID: 521, ParentMetaCatRef: 517, Name: "SAP" } } }, MetaCatID: 521, ParentMetaCatRef: 517, Name: "SAP" }] }, { tuple: { old: { MetaCategory: { MetaCatID: 541, ParentMetaCatRef: 0, Name: "D Versions" } } }, MetaCatID: 541, ParentMetaCatRef: 0, Name: "D Versions", subCategories: [{ tuple: { old: { MetaCategory: { MetaCatID: 542, ParentMetaCatRef: 541, Name: "Baseline 2016-12-31" } } }, MetaCatID: 542, ParentMetaCatRef: 541, Name: "Baseline 2016-12-31" }, { tuple: { old: { MetaCategory: { MetaCatID: 543, ParentMetaCatRef: 541, Name: "CLS step 3 2017-04-15" } } }, MetaCatID: 543, ParentMetaCatRef: 541, Name: "CLS step 3 2017-04-15" }] }, { tuple: { old: { MetaCategory: { MetaCatID: 365, ParentMetaCatRef: 0, Name: "Market" } } }, MetaCatID: 365, ParentMetaCatRef: 0, Name: "Market", subCategories: [{ tuple: { old: { MetaCategory: { MetaCatID: 366, ParentMetaCatRef: 365, Name: "Sector" } } }, MetaCatID: 366, ParentMetaCatRef: 365, Name: "Sector", subCategories: [{ tuple: { old: { MetaCategory: { MetaCatID: 463, ParentMetaCatRef: 366, Name: "term" } } }, MetaCatID: 463, ParentMetaCatRef: 366, Name: "term" }, { tuple: { old: { MetaCategory: { MetaCatID: 464, ParentMetaCatRef: 366, Name: "category" } } }, MetaCatID: 464, ParentMetaCatRef: 366, Name: "category" }, { tuple: { old: { MetaCategory: { MetaCatID: 367, ParentMetaCatRef: 366, Name: "Subsector" } } }, MetaCatID: 367, ParentMetaCatRef: 366, Name: "Subsector" }] }] }<br>
				<br>
				<br>
				<p style="font-weight:bold">search(data, function (o) { return o.MetaCatID > 500; })</p><br>
				<div id="privTree1"></div><br>
				<br>
				<p style="font-weight:bold">search(data, function (o) { return o.Name && o.Name.includes('P'); })</p><br>
				<div id="privTree2"></div><br>
			</div>











			{CCMS_TPL:/footer.html}
		</main>

		{CCMS_TPL:/body-head.php}




<!-- script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}" type="module">
	import {Page} from '/ccmsusr/_js/page.js';
	const page = new Page();
</script -->




		<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
			{CCMS_TPL:/_js/footer-1.php}







			const priv_tree = '<?= $ccms_user["priv"];?>';
			const pt = JSON.parse(priv_tree);
			//console.log(pt[0].dashboard);
			//console.log(pt[1].dashboard);

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

								loadFirst("/ccmsusr/_js/jquery-validate-1.19.3.min.js", function() { /* JQuery Validate */
									loadFirst("/ccmsusr/_js/additional-methods-1.17.0.min.js", function() { /* JQuery Validate Additional Methods */

										//loadFirst("/ccmsusr/_js/pickletree.js", function() { /* https://github.com/pgrabovets/json-view/ */


/*
//let data = '{}';
let data = '<  ?= $ccms_user["priv"];?>';
let target = '.root';
jsonView.format(data, target);
*/


/*
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
