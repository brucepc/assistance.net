$(window).on('scroll', function()
{
	var yscroll = $(this).scrollTop();
	if (yscroll > 0)
	{
		$('#module-top').css('box-shadow', '0 4px 16px -2px rgba(0, 0, 0, ' + Math.min(yscroll / 300, 0.2) + ')');
		var gotoTop = $('#goto-top');
		gotoTop.css('opacity', Math.min(yscroll / 600, 0.3));

		if (yscroll < 1)
			gotoTop.css('opacity', 0);
		if (gotoTop.css('opacity') <= 0.05)
			gotoTop.css('display', 'none');
		else
			gotoTop.css('display', 'block');
	}
	else
		$('#module-top').css('box-shadow', '0 4px 2px -2px rgba(0, 0, 0, 0)');
});