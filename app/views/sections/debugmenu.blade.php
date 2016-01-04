<style type='text/css'>
	#dbgmenu {
		position: fixed;
		cursor: pointer;
		user-select: none;
		-webkit-user-select: none;
		-moz-user-select: none;
		top: 10px;
		left: 10px;
		border: 1px solid #222;
		background: #fff;
		width: 200px;
		z-index: 100000;
		box-shadow: 0 0 8px rgba(0,0,0,0.5);
		opacity: 0.6;
		transition: 0.2s opacity;
		font-size: 10pt;
		font-family: sans-serif;
		display: none; /* start hidden */
	}
	#dbgmenu:hover { opacity: 1; }
	#dbgmenu-tbar {
		height: 16px;
		overflow: hidden;
		border-bottom: 1px solid #000;
		padding-left: 5px;
		color: #fff;
		background: #335;
		text-shadow: 0 -1px rgba(0, 0, 0, 0.8);
		box-shadow: inset 0 8px rgba(255, 255, 255, 0.1);
	}
	#dbgmenu-min, #dbgmenu-close {
		float: right;
		width: 16px;
		border-left: 1px solid #000;
		text-align: center;
	}
	#dbgmenu-min:hover, #dbgmenu-close:hover {
		background: rgba(255, 255, 255, 0.2);
	}
	#dbgmenu-min:active, #dbgmenu-close:active {
		background: rgba(0, 0, 0, 0.4);
	}
	#dbgmenu-min:focus, #dbgmenu-close:focus {
		outline: 0;
		background: rgba(0, 128, 255, 0.2);
	}
	#dbgmenu-content {
		padding: 5px;
	}
</style>

<script type='text/javascript' src='{{ asset('scripts/debug.js') }}'></script>
<script type='text/javascript'>
//called in debug.js
function DebugMenu()
{
	var dbgmnu_mx, dbgmnu_my, dbgmnu_drag;
	var $dbgmenu = $('#dbgmenu');
	$dbgmenu.on('mousedown', function(ev)
	{
		dbgmnu_mx = ev.pageX - $dbgmenu.offset().left;
		dbgmnu_my = ev.pageY - $dbgmenu.offset().top;
		dbgmnu_drag = true;
	});
	$(document).on('mousemove', function(ev)
	{
		if (ev.which == 1 && dbgmnu_drag)
			$dbgmenu.offset({ top: (ev.pageY - dbgmnu_my), left: (ev.pageX - dbgmnu_mx) })
	});
	$dbgmenu.on('mouseup', function(ev) { dbgmnu_drag = false });
	$('#dbgmenu-min').on('click', function(ev) { $('#dbgmenu-content').slideToggle(200); });
	$('#dbgmenu-close').on('click', function(ev) { $dbgmenu.fadeOut(200, function() { $(this).fadeOut(200); }); });

	//content specific stuff
	$('#dbgmenu-settheme').on('click', function(ev) { ev.preventDefault(); Debug.SetTheme(window.prompt('Enter the theme name', 'profile')); });
	$('#dbgmenu-addribbon').on('click', function(ev) { ev.preventDefault(); Debug.AddRibbon(window.prompt('Enter the text of the ribbon'), window.prompt('Enter the theme of the ribbon', 'indeterminate')); });
}
</script>

<div id='dbgmenu'>
	<div id='dbgmenu-tbar'>
		Debug Menu
		<div tabindex='0' id='dbgmenu-close'>&#10006;</div>
		<div tabindex='0' id='dbgmenu-min'>&#9644;</div>
	</div>
	<div id='dbgmenu-content'>
		<div id='dbgmenu-settheme' class='button button-profile'>Set Theme</div>
		<div id='dbgmenu-addribbon' class='button button-default'>Add Ribbon Message</div>
	</div>
</div>