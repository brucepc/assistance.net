@extends('layouts.paper')
<?php $page_title=trans('request/contact.title'); ?>

@section('content')
@include('sections.topbar')
@include('sections.noscript')
@include('sections.topribbons')

<div id='box'>
    <div id='main'>
        <div id='contact_info' class='row'>
            <h2>{{ trans('request/contact.title') }}</h2>
        </div>
    </div>
</div>

@include('sections.footer')
@stop

<!--
<?php
/*
$editMode = false;
if ($vars['isme'])
{
    if ($vars['edit'] == 'contact')
    {
        $editMode = true;
        $url = Router::BuildUrl('request', $vars['request']['rid'], null, false, true);
        echo "<a href='{$url}' class='cancel-edit-btn'>Cancel</a>";
    }
    else
    {
        $url = Router::BuildUrl('service', $vars['request']['rid'], array('edit' => 'contact'), false, true);
        echo "<a href='{$url}' class='edit-btn'>Edit</a>";
    }
}

$PrintContactItem = function($Value, $Name, $Link, $Icon, $Id, $PostName, $Mask = '', $InputType = 'text') use ($editMode)
{
    if ($editMode)
    {
        echo "<i class='$Icon'></i><input type='$InputType' id='$Id' name='$PostName' value='$Value' title='$Name' placeholder='$Name'>";
        return 1;
    }
    else if (!empty($Value))
    {
        echo "<i class='$Icon'></i><a href='$Link' title='$Name' id='$Id' editable='$Mask'>$Value</a>";
        return 1;
    }
    else
        return 0;
}
*/
?>
<hr>
<script>
    $(document).ready(function()
    {
        $('#service-msg-me-btn').on('click', function(ev)
        {
            ev.preventDefault();
            <?php /* if (UserAuth\IsLoggedIn()): ?>
            Dialogs.Mail(
            { 
                type: 'request',
                id: <?php echo $vars['request']['creator_uid']; ?>,
                name: '<?php echo $vars['creator']['name']; ?>'
            });
        <?php else: ?>
        Dialogs.Login();
    <?php endif; ?>
});
    });
</script>
<?php
/*
if (!$vars['isme'])
    echo "<a href='" . Router::BuildUrl('mail', 'new') . "' class='button theme-profile space-bottom' id='service-msg-me-btn'>Message provider</a>";

if ($editMode)
    echo '<form method="post" action="' . Router::BuildUrl('service', $vars['service']['sid'], array('edit' => 'contact'), true, true) . '" class="contact-list icon-list" style="margin-left: 0; line-height: 200%">';
else
    echo '<div class="contact-list icon-list" style="margin-left: 0; line-height: 200%">';

$i += $PrintContactItem(@$vars['service']['phone'], 'Phone', '', 'fa fa-phone', 'cnt_phone', 'phone', 'mask:phone');

if ($editMode)
    echo '<button class="space-top full-width theme-success">Update</button></form>';
else
    echo '</div>';
*/
?>
-->