//Create a new categories tree
//Options:
//	obj: The location to place the category
//	loader: The loader to show when loading categories

//	noAutoload: Don't autoload the categories
//	defaultCategory: Optional default category, null or #
//	debug: print debug messages when creating a category
function Categories(Options)
{
	if (!Options || !Options.obj)
		return; //no obj to load into

	if (!Options.noAutoload)
		MakeLayer(!Options.DefaultCategory ? null : Options.DefaultCategory);

	var $xhr;

	//creates a select item with at the selected layer (LayerID). Fetches layer from the database
	function MakeLayer(LayerID, $Div)
	{
		//cancel previous request
		if ($xhr)
			$xhr.abort();

		if ($Div)
			$Div.nextAll().animate({ 'opacity': 0, 'width': '0px' }, 200, function() { $(this).remove() });

		if (Options.debug)
			console.log('Creating category for ID: ' + LayerID);

		if (Options.loader)
			Options.loader.fadeIn(100);
		$xhr = $.ajax(
		{
			url: '/submit/info/loadcat',
			type: 'post',
			dataType: 'json',
			data: 'cat=' + (LayerID == null ? 0 : LayerID)
		}).done(function (Data)
		{
			if (Data.length < 1)
			{
				Options.loader.fadeOut(100);
				return;
			}

			var $sel = $("<select style='width: 0px; opacity: 0' size='10'></select>");
			$sel.on('change', function(ev) { $(this).find(':selected').trigger('select'); });

	        //always display other last
	        if (Data[0].name == 'Other')
	            hasOther = true;

	        //Add all the categories to the select
			for (var i = (hasOther ? 1 : 0); i < Data.length; i++)
				AddCategory(Data[i].id, Data[i].name, $sel);

			//add 'Other' to the end
			if (hasOther)
				AddCategory(Data[0].id, Data[0].name, $sel);

			Options.loader.fadeOut(100);
			$sel.appendTo(Options.obj).delay($Div ? 200 : 0).animate({ 'opacity': 1, 'width': '250px' }, 200);
		}).always(function() { $xhr = null; });
	}

	//Add a category to a layer of the tree
	//Returns the newly created category after adding to the tree
	function AddCategory(CategoryID, CategoryName, $Select)
	{
		var newCat = $('<option cat-id="' + CategoryID + '">' + CategoryName + '</option>');
		newCat.on('select', function(ev) { MakeLayer(CategoryID, $Select); });
		newCat.appendTo($Select);

		return newCat;
	}

	//Gets the selected category in a { name, id } pair
	//Returns null if no category selected
	this.GetSelectedCategory = function()
	{
		//$('#category-selection select:last option:selected').val(); also works
		var $cat = $(Options.obj).children().last();

		//none selected
		if ($cat[0].selectedIndex <= 0)
			return null;

		//find category up the tree
		// var catval = $cat.val();
		// while (catval == undefined && !$cat.is(':first-child'))
		// {
		// 	$cat = $cat.prev();
		// 	catval = $cat.val();
		// }

		var $sel = $cat.children(':selected');
		return { name: $sel.text(), id: $sel.attr('cat-id') };
	};
}

