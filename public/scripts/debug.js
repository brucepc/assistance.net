//Various debug functions to assist with testing
function Debug() { }

// -- PAPER LAYOUT FUNCTIONS -- //

Debug.SetPaperMaxWidth = function(Width)
{
	$('body').css('max-width', Width);
	$('#topbar').css('max-width', Width + 20);
}
Debug.SetTheme = function(Theme)
{
	if (!Theme)
		return;

	$('body,[class*=theme-]').each(function()
	{
		$(this).attr('class', $(this).attr('class').replace(/(btm|theme)-(color-)?\w+/gi, '$1-$2' + Theme));
	});
}
Debug.AddRibbon = function(Message, Theme)
{
	if (!Theme)
		Theme = 'indeterminate';
	$('#topbar-spacer').after('<div class="top-ribbon bold theme-' + Theme + '">' + Message + '</div>');
}

// -- METAL LAYOUT FUNCTIONS -- //


// -- DOCUMENT BASED HELPERS -- //
$(document).ready(function()
{
	if (typeof DebugMenu == 'function')
		DebugMenu();
});