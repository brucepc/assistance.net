<?php

//Custom form macros

//Get all of the attributes from an array of attributes. Copied from HtmlBuilder::attributes()
function AttributesToHtml(array $Attributes)
{
	$html = array();

	// For numeric keys we will assume that the key and the value are the same
	// as this will convert HTML attributes such as "required" to a correct
	// form like required="required" instead of using incorrect numerics.
	foreach ((array)$Attributes as $key => $value)
	{
		if (is_numeric($key))
			$key = $value;
		if (!is_null($value))
			$element = "$key='" . e($value) . "'";

		if (!is_null($element))
			$html[] = $element;
	}

	return (count($html) > 0 ? ' ' . implode(' ', $html) : '');
}

//form macros
Form::macro('stylecheck', function($Name, $Label, $Value = 1, $Checked = null, array $Attributes = array())
{
	$v = Form::getValueAttribute($Name);
	if (!empty($v))
		$Value = $v;

	$Attributes['class'] = implode(' ', [ @$Attributes['class'], 'style-check' ]);
	$Attributes['id'] = $Name;
	$check = Form::checkbox($Name, $Value, $Checked, $Attributes);
	$check .= "<label class='style-check-label' for='$Name'></label>";
	$check .= "<label for='$Name'>$Label</label>";
	return $check;
});

Form::macro('infolabel', function($Name, $Text, $Info, array $Attributes = array())
{
	$attr = AttributesToHtml($Attributes);
	return "<label for='$Name'$attr>$Text <span class='hint'>$Info</span></label>";
});

//Input type=date, auto converts data if int or DateTime
Form::macro('date', function($Name, $Date = '', array $Attributes = array())
{
	$v = Form::getValueAttribute($Name);
	if (!empty($v))
		$Date = $v;

	$attr = AttributesToHtml($Attributes);
	if ($Date instanceof DateTime)
		$Date = $Date->format('o-m-d');
	else if (is_int($Date))
		$Date = date('o-m-d', $Date);
	else if (is_string($Date))
		$Date = date('o-m-d', strtotime($Date)); //make sure the date is in the correct format

	return "<input type='date' id='$Name' name='$Name' value='$Date'$attr>";
});

//custom HTML macros

//Create a safe link to an external page
HTML::macro('safelink', function($Link, $Body, array $Attributes= array())
{
	$attr = AttributesToHtml($Attributes);
	return "<a data-safe href='$Link' $attr>$Body</a>";
});