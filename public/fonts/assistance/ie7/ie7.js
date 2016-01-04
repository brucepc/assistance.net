/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referring to this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'assistance\'">' + entity + '</span>' + html;
	}
	var icons = {
		'fico-extlink': '&#x5e;',
		'fico-settings': '&#x2a;',
		'fico-person': '&#x70;',
		'fico-people': '&#x50;',
		'fico-lock': '&#x25;',
		'fico-inbox': '&#x3d;',
		'fico-help': '&#x3f;',
		'fico-feedback': '&#x3a;',
		'fico-exclamation': '&#x21;',
		'fico-document': '&#x23;',
		'fico-assistance': '&#x7e;',
		'fico-a': '&#x41;',
		'fico-new': '&#x2b;',
		'fico-message': '&#x22;',
		'fico-location': '&#x40;',
		'fico-service': '&#x73;',
		'fico-request': '&#x72;',
		'fico-scales': '&#x24;',
		'fico-x': '&#x78;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/fico-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
