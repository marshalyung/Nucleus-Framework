/*
 * Pop up a confirmation window
 * Parameters:
 *  - message: Question to be shown on the pop up window
 */
function confirmation(message) {
    return confirm(message);
}

/*
 * Pop up a new window
 *
 * Parameters:
 *	- url:	filename and url parameters assigned to popup window
 */
function openWindow(url) {
	window.open(url, "theWin", "width=850,height=500,scrollbars=1,status=0,resizable=1,location=0,menubar=0,toolbar=0");
}

/*
 * Handles multiple submit button in a form
 *
 * Parameters:
 *	- frm: 		form name
 *	- target:	name of the hidden action field
 *	- action:	action field value to be submitted
 */
function doAction(frm, val) {
    frm.action.value = val;
    frm.submit();
}

/*
 * Collapse and expand sections
 *
 * Parameters:
 *	- id:		tag name of Show/Hide button
 *	- element:	tag name of targeted section to show or hide
 */
function showHide(id, element) {
	if (document.getElementById) { // DOM3 = IE5, NS6
		if (document.getElementById(element).style.display == "none") {
			document.getElementById(element).style.display = 'block';
			document.getElementById(id).value = "Hide";
			document.getElementById(id).innerHTML = "Hide";
		}
		else {
			document.getElementById(id).value = "Show";
			document.getElementById(id).innerHTML = "Show";
			document.getElementById(element).style.display = 'none';
		}
	}
	else {
		if (document.layers) {
			if (document.element.display == "none") {
				document.element.display = 'block';
				document.getElementById(id).value = "Hide";
			}
			else {
				document.getElementById(id).value = "Show";
				document.element.display = 'none';
			}
		}
		else {
			if (document.all.element.style.visibility == "none") {
				document.all.element.style.display = 'block';
				document.getElementById(id).value = "Hide";
			}
			else {
				document.getElementById(id).value = "Show";
				document.all.element.style.display = 'none';
			}
		}
	}
}