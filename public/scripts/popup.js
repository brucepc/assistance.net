// Copyright © Assistance.net Inc
// ------------------------------
// popup.js - Provides multi-use dialogs and floating-menus that can be displayed at any time. Premade dialogs in widgets.js. See docs for usage


if (!String.prototype.format)
{
    String.prototype.format = function ()
    {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function (match, number)
            { return typeof args[number] !== undefined ? args[number] : match; });
    };
}

function Dialog() { };
Dialog.$dlg = null;
Dialog.modal = false;
Dialog.fadeLength = 200;
//Check if the dialog is open
Dialog.IsOpen = function (CheckVisibility)
{
    return (Dialog.$dlg !== null && (!CheckVisibility || Dialog.$dlg.is(':visible')));
}
//Show the dialog if it is hidden (does nothing if no dialog)
Dialog.Show = function()
{
    if (Dialog.$dlg)
        $('#dimbg').fadeIn(Dialog.fadeLength);
}
//Hide the dialog if it is visible (does nothing if no dialog)
Dialog.Hide = function()
{
    if (Dialog.$dlg)
        $('#dimbg').fadeOut(Dialog.fadeLength);
}
//// Show a popup dialog (not the system/alert() dialog)
/* Options:
title: the title/header of the dialog
text[/html]: the text/html content of the dialog
file: load a file (html) under the text section of the dialog
onFile($Dom): function called when 'file' has been loaded (not called if not loaded) -- $Dom is the contents of the file loaded
buttons {}: object with key=>value (text,function) pairs, function passes jQuery event
dflBtn: the default button (enter activates), 0 for none
theme: the theme for the dialog (profile/service/request, defaults to profile)
icon: the icon to display beside the title (css class based icon)
modal: [true/false] specifies that the dialog cannot be closed
width: the width of the dialog.
height: the height of the dialog. Will scroll file content if height > max-height (defaults to fit contents)
dontShow: [true|false] don't make the dialog visible (useful when modifying the DOM, only applies when showing a new dialog)
*/
Dialog.Open = function (Options)
{
    if (!Options)
        Options = {};
    if (!Options.theme)
        Options.theme = 'profile';
    if (Options.modal)
        this.modal = Options.modal;
    if (!Options.text && Options.html) //alias for text
        Options.text = Options.html;

    if (this.$dlg == null) //create the dialog if it doesn't exist
    {
        var $bg = $('<div>', { id: 'dimbg' }).hide();
        this.$dlg = $('<div>', { id: 'dialog', 'class': 'shadow theme-' + Options.theme });
        $bg.append(this.$dlg);
        $(document.body).append($bg);
    }
    else //update the existing dialog
    {
        this.$dlg.empty()
        .removeClass()
        .addClass('shadow')
        .addClass('theme-' + Options.theme);
        $('#dimbg').fadeOut(Dialog.fadeLength);
    }

    if (Options.width)
        this.$dlg.width(Options.width);
    if (Options.height)
        this.$dlg.height(Options.height);

    this.$dlg.append($('<div>', { 'class': 'gloss' })); //glossy background for effect

    //dialog contents
    if (Options.icon)
        this.$dlg.append($('<div>', { id: 'dlg-title-icon', 'class': Options.icon }));
    if (Options.title)
    {
        this.$dlg.append($('<h1>', { id: 'dlg-title-text' }).text(Options.title));
        this.$dlg.append('<hr>');
    }
    if (Options.text)
        this.$dlg.append(Options.text);

    if (Options.buttons) //buttons in the form of key-value pairs in an object
    {
        var $btm = $('<div>', { id: 'dlg-bottom' });

        for (var link in Options.buttons)
        {
            if (Options.buttons.hasOwnProperty(link))
            {
                $btm.append($('<div>', { 'class': 'vr' }));
                var $btn = $('<a>', { tabindex: 0, 'class': 'bbutton' }).text(link);
                //button activation
                $btn.on('click', { 'link': Options.buttons[link] }, function(ev) { ev.preventDefault(); ev.data.link(ev); });
                $btn.on('keypress', { 'link': Options.buttons[link] }, function(ev) { if (ev.which == 13 || ev.which == 32) { ev.preventDefault(); ev.data.link(ev); }}); //allow enter or space to activate
                $btm.append($btn);
            }
        }
    }

    //adds an html area to the dialog after the text
    if (Options.file)
    {
        var $ha = $('<div>', { 'class': 'html_area', tabindex: 0 });

        $ha.load(Options.file, function ()
        {
            if (Options.onFile)
                Options.onFile($ha);

            var height = ($btm ? $btm.height() : 0) + $ha.position().top - 20;

            //fix height
            if (!Options.height)
                Dialog.$dlg.height(height + $ha.height());

            //make sure that the dialog does not extend past its max height
            var maxh = Dialog.$dlg.css('max-height');
            if (maxh.indexOf('%') >= 0)
                maxh = (parseFloat(maxh) / 100.0) * $(window).height() - 10; //relative size
            else
                maxh = parseFloat(maxh) - 10; //absolute size

            $ha.css('max-height', maxh - height);
        });

        this.$dlg.append($ha);
    }

    //for proper dom ordering, this must go after the html file, however the html file relies on this for sizing
    if (Options.buttons)
        this.$dlg.append($btm);

    if (!Dialog.modal)
        this.$dlg.append($('<span>', { id: 'dlg-x-button', 'class': 'fico-x' }).on('click', function() { Dialog.Close() }));

    //set default buttons
    $(document).off('keyup.defaultdialog');
    if (Options.dflBtn)
    {
        $('#dlg-bottom a:eq(' + (Options.dflBtn - 1) + ')').addClass('dlg-dfl-btn');

        $(document).on('keyup.defaultdialog', function (ev)
        {
            if (ev.keyCode == 13)
            {
                var elm = $('#dlg-bottom a:eq(' + (Options.dflBtn - 1) + ')');
                window.location.href = elm.attr('href');
            }
        });
    }

    //mouse close handler
    $('#dimbg').on('click.closedialog', function (ev) { if (!Dialog.modal && !$(ev.target).parents('#dialog').length) Dialog.Close(); });
    $(document).on('keyup.closedialog', function (ev) { if (!Dialog.modal && ev.keyCode == 27) Dialog.Close(); }); //escape key closes dialog

    if (!Options.dontShow)
        $('#dimbg').fadeIn(Dialog.fadeLength);
};
Dialog.closer = function () { Dialog.Close(); };
Dialog.Close = function (FadeOutLength)
{
    FadeOutLength = (FadeOutLength ? FadeOutLength : Dialog.fadeLength);
    $('#dimbg').fadeOut(FadeOutLength, function ()
    {
        $(this).remove();
        Dialog.$dlg = null;

        $('head').find('link[dialog-insert]').remove(); //remove any dialog inserts
        $(this).off('.closedialog');
    });
    Dialog.modal = false;
};


//// Create a new floating menu
/* Options:
id: the ID of the menu
x: X-Position of menu relative to the document
y: Y-Position of menu relative to the document
width: Forced width for the menu
height: Forced height for the menu
fixed: Is the menu fixed on screen (defaults to absolute)
ignoreBounds: ignore the boundaries of the menu on screen, allowing the menu to go off screen.
noClickClose: menu will close if an item is clicked
noBlurClose: menu will close if clicked outside of
noEscClose: menu will close if escape key is pressed

onClose(): the function that is called when the menu is closed. (Happens before closing, return false to cancel close)

[new FloatingMenu()]: create a new floating menu and open it
Close(): close the menu
Focus(): focus the menu object

items {}: a collection of key-value pairs for each item in the menu where key=text and value=link (use null for no link and FloatingMenu.separator for a separator) or a composite object with the following properties
html: The html of the item, this is used if present regardless of any other parameters
text: The text of the item, can be HTML
data: optional data to be stored with the item (stored in the item's jquery data: 'fm-data')
onSelect: call a custom js function when the item is clicked/selected, does not prevent link activation
link: The link that the item points to, undefined not to point anywhere
icon: An optional icon to display beside the text (must be a CSS class-based icon)
id: The optional ID for the menu item
classes: Optional classes to apply to the menu item
hint: The hint text for the item (title attribute)
*/

//Use the following items to add custom function to the menu (Must use the items verbatim and not their contents)
FloatingMenu.separator = '-'; //adds a visual separating line between items
FloatingMenu.spacer = ' '; //adds a few pixel spacer between items for items with colored backgrounds

function FloatingMenu(Options)
{
    //Close the open popup. Does nothing if not open
    this.Close = function ()
    {
        if (this.$menu !== undefined)
        {
            //check to see if the menu is allowed to close
            if (typeof this.onClose != 'function' || this.onClose() !== false)
                this.$menu.fadeOut(150, function () { $(this).remove(); });
        }
    };

    //Focus the popup document object
    this.Focus = function ()
    {
        if (this.$menu !== undefined)
            this.$menu.trigger('focus');
    };

    //Add an item to the menu (Item syntax same as in main function)
    this.AddItem = function(Item, Value)
    {
        //predefined special menu items
        if (Item === FloatingMenu.separator)
            this.$menu.append($('<div>', { 'class': 'separator' }));
        else if (Item === FloatingMenu.spacer)
            this.$menu.append($('<div>', { 'class': 'space' }));

        else if (Item !== null && typeof Item == 'object') //complex object (allows for more options)
        {
            if (Item.html)
                this.$menu.append(Item.html);
            else
            {
                var $item = $('<a>');
                if (Item.id) $item.attr('id', Item.id);
                if (Item.classes) $item.addClass(Item.classes);
                if (Item.link) $item.attr('href', Item.link);
                if (Item.hint) $item.attr('title', Item.hint);
                if (Item.icon) $item.prepend($('<i>').addClass('space-right ' + Item.icon));
                if (Item.text) $item.text(Item.text);
                if (Item.data) $item.data('fm-data', Item.data);
                if (Item.onSelect) $item.on('click', function() { Item.onSelect(Item.data) });
                this.$menu.append($item);
            }
        }
        else //simple text=>Item
        {
            var $item = $('<a>', { tabindex: 0, title: item });
            if (Item !== null) $item.attr('href', Item);
            this.$menu.append($item);
        }
    }

    if (!Options)
        return;

    //events
    this.onClose = Options.onClose;

    //basic menu DO
    this.$menu = $('<div>', { 'class': 'floating-menu' });
    if (Options.id)
        this.$menu.attr('id', Options.id);
    if (Options.fixed)
        this.$menu.css('position', 'fixed');
    else
        this.$menu.css('position', 'absolute'); //fix for IE

    if (Options.width) this.$menu.width(Options.width);
    if (Options.height) this.$menu.height(Options.height);

    //Add all of the items to the menu
    for (var item in Options.items)
        if (Options.items.hasOwnProperty(item))
            this.AddItem(Options.items[item]);

        this.$menu.offset({ left: Options.x, top: Options.y })
        .hide()
        .prependTo($('body'));

    //make sure that menu stays on screen
    if (!Options.ignoreBounds)
    {
        var w = this.$menu.outerWidth(true);
        var h = this.$menu.outerHeight(true);
        var dw = $(document).width();
        var dh = $(document).height();

        if (Options.x < 0)
            this.$menu.css('left', 0);
        else if (Options.x + w >= dw)
            this.$menu.css('left', dw - w);

        if (Options.y < 0)
            this.$menu.css('top', 0);
        else if (Options.y + h >= dh)
            this.$menu.css('top', dh - h);
    }

    this.$menu.fadeIn(150);

    var $this = this;
    var $owner = $(window);

    if (!Options.noBlurClose)
    {
        $owner.on('mousedown.floatingmenu', function (ev)
        {
            if ($this.$menu.has($(ev.target)).length < 1 && !$this.$menu.is(ev.target))
                $this.Close();
        });
    }
    if (!Options.noClickClose)
        this.$menu.children('a').on('click.floatingmenu', function (ev) { $this.Close(); });
    if (!Options.noEscClose)
        $owner.on('keypress.floatingmenu, keydown.floatingmenu', function (ev) { if (ev.keyCode == 27) $this.Close(); });
}

//standard dialogs (and their helper functions)

function Dialogs() { }
Dialogs.prototype = Dialog;

Dialogs.ModalError = function (ErrorTitle, ErrorMessage) //show a fatal/non-closable (modal) error
{
    var options = {
        title: ErrorTitle,
        text: ErrorMessage,
        buttons: { 'Refresh page': function() { location.reload(true) } },
        icon: 'fico-x',
        theme: 'error',
        modal: true
    };
    Dialog.Open(options);
};
Dialogs.Warning = function (WarningTitle, WarningMessage)
{
    var options = {
        title: WarningTitle,
        text: WarningMessage,
        buttons: { 'Close': Dialog.closer },
        icon: 'fico-exclamation',
        theme: 'warning'
    };
    Dialog.Open(options);
};

//special function; loads login page from actual login rather than creating a dialog
Dialogs.Login = function ()
{
    $("<link>",
    { 
        rel: 'stylesheet', 
        type: 'text/css', 
        href: '/style/login.css'
    }).appendTo("head");

    $login = $('<div>', { 'id': 'dimbg' });
    $login.on('click.closelogin', function(ev) //click dimbg to fade out
    {
        if (!$(ev.target).parents('#login-page').length)
            $login.fadeOut(200, function() { $login.remove(); });
    });
    $login.load('/login #login-page', function()
    {
        $login.hide().appendTo($('body')).fadeIn(200);
        $('#login-page').hide().fadeIn(400);


        $('#login-submit').on('click', function(ev)
        {
            ev.preventDefault();
            PerformLogin();
        });
        $('#login-cancel').on('click', function(ev)
        {
            ev.preventDefault();
            $login.trigger('click.closelogin');
        });
    });
};

function PerformLogin()
{
    var dat = $('#login-form').serialize();
    $('.login-form').children().animate({ opacity: 0 }, 100);
    $('.login-form').append('<div class="loader"></div>');
    $.ajax(
    {
        url: '/submit/login?async=true',
        data: dat,
        async: true,
        type: 'post'
    }).success(function (data, status, xhr) { window.location.reload(); })
    .fail(function (data, status, xhr)
    {
        //console.log(data, status, xhr);
        $('.login-form .loader').remove();
        $('.login-form').children().animate({ opacity: 1 }, 100);
        $('#login-invalid').remove();
        $('.login-form').prepend("<label class='bold big' id='login-invalid'>" + data.responseText + "</label>");
    });
}

//Message a user/service/request/etc
//Who (who to send to), can be array: { type, id }
//Dialog options
Dialogs.Mail = function (Who, DialogOptions)
{
    if (!DialogOptions)
        DialogOptions = {};
    
    DialogOptions.title = 'Send Message';
    DialogOptions.buttons = { 'Send': PerformSendMail, 'Cancel': Dialog.closer };
    DialogOptions.icon = 'fico-message';
    DialogOptions.theme = 'silver';
    DialogOptions.file = '/fun/tmpl/message.html';
    DialogOptions.onFile = function($HA)
    {
        var cxt = $('#sendmsg-form #msg-who').data('cxt');
        if (cxt)
        {
            if ($.isArray(Who))
            {
                for (var w in Who)
                    cxt.AddContext(w);
            }
            else
                cxt.AddContext(Who);
        }
    };

    Dialog.Open(DialogOptions);
};
//Contexts is the list of contexts as recpients (should be from a ContextTextbox)
//Does not add &who= ...
function SerializeMailWho($Contexts)
{
    var cxts = '';

    for (var i = 0; i < $Contexts.length; i++)
        cxts += $Contexts[i].id + ':' + $Contexts[i].type + ',';

    return cxts;
}
//send a message (for the SendMail dialog)
function PerformSendMail()
{
    //save subject and message
    var subj = $('#sendmsg-form #subject').text();
    var mesg = $('#sendmsg-form #message').text();

    var dat = $('#sendmsg-form').serialize();
    //add context
    var cxts = SerializeMailWho($('#sendmsg-form #msg-who').data('cxt').GetContexts());
    dat += '&who=' + cxts;

    $.ajax({
        url: '/submit/mail/send?async=true',
        method: 'post',
        data: dat,
        async: true
    }).done(function(data)
    {
        $('#topbar-spacer').after($('<div>', { 'class': 'top-ribbon bold theme-success' }).text('Message sent'));
    })
    .fail(function(data)
    {
        Dialogs.SendMessage(
        { 
            onFile: function ()
            {
                $('#sendmsg-form #subject').text(subj); $('#sendmsg-form #message').text(mesg);
                $('#sendmsg-error').text(data);
            }
        });
    });
    Dialog.Close();
}
//Create a feedback submission dialog that lets users submit feedback in various categories
//DefaultBox specifies the default checkbox/radio box to be selected (should be an HTML id), DialogOptions allows for customizing of dialog options
Dialogs.Feedback = function(DefaultBox, DialogOptions)
{
    if (!DialogOptions)
        DialogOptions = {};
    if (!DialogOptions.title)
        DialogOptions.title = 'Submit Feedback';
    if (!DialogOptions.icon)
        DialogOptions.icon = 'fico-feedback';

    DialogOptions.buttons = { 'Submit': FeedbackSubmit, 'Cancel': Dialog.closer };
    DialogOptions.file = '/fun/tmpl/feedback.html #feedback-form';
    DialogOptions.onFile = function($Dom) { $Dom.find('br,#feedback-submit').remove(); $Dom.find(DefaultBox).prop('checked', true); };
    Dialog.Open(DialogOptions);
}
//The submit function for the Feedback dialog
function FeedbackSubmit()
{
    $.ajax({
        url: '/submit/feedback?async=true',
        type: 'post',
        data: $('#feedback-form').serialize()
    })
    .done(function(data)
    {
        var options = {
            title: 'Feedback Submitted',
            buttons: { 'Close': Dialog.closer },
            icon: 'fico-feedback',
            height: '250px',
            text: '<h2>Thanks for submitting feedback!</h2>' + data
        };
        Dialog.Open(options);
    });
}

//ShowMediaBox generates an autosized lightbox-style gallery with directional arrows and a view full size button
//mlist : list of json encoded objects, only required field is uri, all other fields are optional
//ind - the index of the passed array that is to be displayed
function ShowMediaBox(mlist, ind) //takes an array of objects and the index of the object
{
    var newImg = new Image();

    newImg.onload = function ()
    {
        var h = newImg.height;
        var w = newImg.width;
        if (h > window.innerHeight - 120)
        {
            h = window.innerHeight - 120;
            w = h / newImg.height * newImg.width;
        }
        if (w > window.innerWidth - 120)
        {
            w = window.innerWidth - 120;
            h = w / newImg.width * newImg.height;
        }
        var desc = mlist[ind]['description'];
        if (desc == null)
            desc = "";
        var cont = '<img id="dialog-image" height="' + h + 'px" data-index=' + ind + ' style="padding:10px; padding-bottom:0px; margin-bottom:-5px;" src="' + mlist[ind]['uri'] + '" alt="alternate text"><div id="dialog-description" style="text-align:center; position:relative;">' + desc + '';
        cont += '<a id="img-full" href="' + mlist[ind]['uri'] + '" target="_blank"> <div class="fa fa-external-link iblock hint" style=""></div></a></div>';
        cont += '<div id="img-next" class="block hint fa fa-angle-double-right" onclick="GalleryNext()" style="font-size: 150%; position:absolute; right:5px; top:' + (h + 40) / 2 + 'px;"></div>';
        cont += '<div id="img-prev" class="block hint fa fa-angle-double-left" onclick="GalleryPrev()" style="font-size: 150%; position:absolute; left:5px; top:' + (h + 40) / 2 + 'px;"></div>';



        var options = {
            text: cont,
            width: w + 20 + 'px',
            height: h + 20 + 'px',
            theme: 'page-dark'
        };
        Dialog.Open(options);
    }
    newImg.src = mlist[ind]['uri'];


}
//Does the actual work of changing and animating when moving through the gallery
//the data-index attribute of the image (#dialog-image) contains the index of the array you are currently on
//if no description is present, none is displayed
function SwapContent()
{
    var gallery = GetMediaArray();

    $('#dialog').stop();
    $('#dialog-image').stop();
    $('#img-prev').stop();
    $('#img-next').stop();
    $('#dialog-description').stop();
    $('#img-full').stop();

    var desc = gallery[$('#dialog-image').attr('data-index')]['description'];
    if (desc == null)
        desc = "";
    desc += '<a id="img-full" href="' + gallery[$('#dialog-image').attr('data-index')]['uri'] + '" target="_blank"> <div class="fa fa-external-link iblock hint" style=""></div></a>';

    var newImg = new Image();
    newImg.src = gallery[$('#dialog-image').attr('data-index')]['uri'];
    var h = newImg.height;
    var w = newImg.width;
    if (h > window.innerHeight - 120)
    {
        h = window.innerHeight - 120;
        w = h / newImg.height * newImg.width;
    }
    if (w > window.innerWidth - 120)
    {
        w = window.innerWidth - 120;
        h = w / newImg.width * newImg.height;
    }
    $('#img-full').attr('href', gallery[$('#dialog-image').attr('data-index')]['uri']);
    //$('#img-next').fadeOut(200, function(){$('#img-next').css('top' , (h+40)/2).fadeIn()});
    //$('#img-prev').fadeOut(200, function(){$('#img-prev').css('top' , (h+40)/2).fadeIn()});
    $('#img-next').animate({ top: (h + 40) / 2 }, 100);
    $('#img-prev').animate({ top: (h + 40) / 2 }, 100);
    $('#dialog-description').fadeOut(50);
    $('#dialog').animate({ width: w + 20, height: h + 20 }, 200, function ()
    {
    });

    $('#dialog-image').fadeOut(200, function ()
    {

        $('#dialog-image').css('width', w);
        $('#dialog-image').css('height', h);
        //$('#dialog-image').animate({width: w, height: h}, 200);
        $('#dialog-image').attr('src', gallery[$('#dialog-image').attr('data-index')]['uri']);

        $('#dialog-description').html(desc).fadeIn(50);



    });
    $('#dialog-image').fadeIn(200);

}
//increments data-index to next position in media array and calls SwapContent()
function GalleryNext()
{
    var gallery = GetMediaArray();

    var newIndex = Number($('#dialog-image').attr('data-index')) + 1;
    if (newIndex >= gallery.length)
    {
        newIndex = 0;
    }
    $('#dialog-image').attr('data-index', newIndex);
    SwapContent();
}
//decrements data-index to previous position in media array and calls SwapContent()
function GalleryPrev()
{
    var gallery = GetMediaArray();

    var newIndex = Number($('#dialog-image').attr('data-index')) - 1;
    if (newIndex < 0)
    {
        newIndex = gallery.length - 1;
    }
    $('#dialog-image').attr('data-index', newIndex);
    SwapContent();
}