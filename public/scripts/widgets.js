//defines various functions for widgets and implementations of specific popups (floating-menus/dialogs)

function GetIEUserAgent()
{
    var iev = -1;
    var ua = navigator.userAgent;
    var rgx = new RegExp("Trident\/([0-9]{1,}[\.0-9]{0,})");
    if (rgx.exec(ua) != null)
        iev = parseFloat(RegExp.$1);
    return iev;
}

(function($)
{
    $.fn.GetCaretPos = function()
    {
        var input = this.get(0);
        if (!input)
            return; // No (input) element found

        if ('selectionStart' in input) //Standard-compliant browsers
            return input.selectionStart;

        else if (document.selection) //IE
        {
            input.focus();
            var sel = document.selection.createRange();
            var selLen = document.selection.createRange().text.length;
            sel.moveStart('character', -input.value.length);
            return sel.text.length - selLen;
        }
    }
})(jQuery);

//various widgets
$(document).ready(function ()
{
    //styled checkboxes
    $('.check-label').on('click', function (ev)
    {
        if (GetIEUserAgent() == 4)
        {
            var match = $('#' + $(this).attr('for'));
            match.prop('checked', !match.prop('checked'));

            if (match.is(':checked'))
                $(this).css('background', '#000');
            else
                $(this).css('background', '#fff');
        }
    });


    //topbar messages (click to close)
    $(document).on('click', '.top-ribbon', function(ev) { $(this).fadeOut(200, function() { $(this).remove(); }); });

    //placeholder fallback for old browsers
    //scriptiny.com
    if (!("placeholder" in document.createElement("input")))
    {
        $("input[placeholder], textarea[placeholder]").each(function ()
        {
            var val = $(this).attr("placeholder");
            if (this.value == "")
                this.value = val;
            $(this).focus(function ()
            {
                if (this.value == val)
                    this.value = "";
            }).blur(function ()
            {
                if ($.trim(this.value) == "")
                    this.value = val;
            })
        });

        // Clear default placeholder values on form submit
        $('form').submit(function ()
        {
            $(this).find("input[placeholder], textarea[placeholder]").each(function ()
            {
                if (this.value == $(this).attr("placeholder"))
                    this.value = "";
            });
        });
    }
});

//// A single context selection textbox that allows for custom queries to place 'contexts'; Commandeers an existing div
/* Options:
obj: [required] The document object to convert to a selector textbox (does not modify the object's contents)
refresh (Context, Search): Called when retrieving query results for the dropdown list. Must call Suggest with jquery result data to show menu; Context is the caller, Search is the text
dupes: Allow duplicates (must have id and type to compare; otherwise just compares name)

Suggest(Data): the callback for the ajax call from query. data should be as array of strings and/or objects in the format of {id,type,name,[classes]} where classes are css classes applied
GetContexts(): return an array of all of the contexts (not including that currently being typed) as objects as {id,name,type}
*/
function ContextTextbox(Options)
{
    var _this = this; //passthrough inside of functions

    if (!Options && !Options.obj)
        return;

    //special hidden div for sizing the input box according to text size
    if (!ContextTextbox.$sizer)
    {
        ContextTextbox.$sizer = $('<span>'); //tool to automatically size input area
        ContextTextbox.$sizer.css({ margin: '0', padding: '0', visibility: 'hidden', width: 'auto', height: 'auto', position: 'fixed' });
        $(document.body).append(ContextTextbox.$sizer);
    }

    //The refresh function that retrieves values given new inputs
    this.Refresh = Options.refresh;

    //The handler that converts query results into a dropdown list for the input box
    this.Suggest = function (Data)
    {
        var opt = {
            id: 'context-fm',
            x: this.$input.offset().left,
            y: this.$input.offset().top + this.$input.outerHeight(false),
            items: {}
        };

        if (Data.length < 1)
        {
            this.$input.data('context', null);
            return;
        }

        for (var i = 0; i < Data.length; i++)
        {
            var itm = Data[i];

            //convert simple to complex
            if (typeof itm != 'object')
                itm = { name: itm, id: null, type: null };

            //ignore duplicates (if enabled)
            if (!Options.dupes && _this.HasContext(itm))
                continue;

            opt.items[i] = {
                text: itm['name'],
                data: itm,
                onSelect: function (Item) { _this.AddContext(Item); }
            };
        }
        if ($.isEmptyObject(opt.items)) //don't show an empty menu
            menu = null;
        else
            menu = new FloatingMenu(opt);
        this.$input.data('suggest', menu);
    };


    //Get all contexts and return just Field. If field is not set, get the full object. Returns an array
    this.GetContexts = function (Field)
    {
        var items = [];
        this.$box.children().each(function (idx)
        {
            if ($(this).hasClass('context'))
            {
                if (Field)
                {
                    if (Field == 'name')
                        items.push($(this).children('.cxttext').text());
                    else if (Field == 'id')
                        items.push($(this).attr('cxt-id'));
                    else if (Field == 'type')
                        items.push($(this).attr('cxt-type'));
                    else if (Field == 'classes')
                        items.push($(this).attr('class'));
                }
                else
                {
                    var item = {
                        name: $(this).children('.cxttext').text(),
                        id: $(this).attr('cxt-id'),
                        type: $(this).attr('cxt-type')
                    };
                    items.push(item);
                }
            }
        });
        return items;
    }
    //Add a context to the list
    //Context: { name, id, text, classes }
    this.AddContext = function(Context)
    {
        if (!Context)
            return;

        //add the item to the list
        var dat = $(this).data('fm-data');

        //create the context div as [text|X]
        var $div = $('<div>', { 'class': 'context', 'cxt-id': Context.id, 'cxt-type': Context.type });
        if (Context.classes)
            $div.addClass(Context.classes);

        var $txt = $('<div>', { 'class': 'cxttext' });
        if (Context.name.length > 0)
            $txt.text(Context.name);
        else
            $txt.html('&nbsp;');
        $div.append($txt);

        var $del = $('<div>', { 'class': 'cxtdel' });
        $del.html('&times;');
        $del.on('click', function () { _this.RemoveContext($div) });
        $div.append($del);

        //add it to the list
        this.$input.before($div);
        this.$input.val('').trigger('focus');
    };
    this.CountContexts = function()
    {
        return this.$input.prevAll().length;
    }

    //Remove an existing context
    this.RemoveContext = function (Context)
    {
        if (!Context)
            return;

        Context.animate(
        {
            width: 0,
            opacity: 0,
            height: Context.height()
        }, 200, function () { Context.remove() });
    }
    //Checks to see if there is already a matching context. Returns a list of matched contexts, false if empty
    //If Context is not an object, checks name, else checks for full object (Does not include classes)
    this.HasContext = function (Context)
    {
        if (!Context)
            return false;

        var retval = [];
        this.$input.prevAll().each(function()
        {
            if (typeof Context == 'object')
            {
                if (Context['name'] && Context['name'] != $(this).children('.cxttext').text())
                    return;
                if (Context['class'] && Context['class'] != $(this).attr('class'))
                    return;
                if (Context['name'] && Context['Name'] != $(this).attr('class'))
                    return;
                if (Context['name'] && Context['Name'] != $(this).attr('class'))
                    return;

                retval.push(this);
            }
            else
            {
                if ($(this).text() == Context)
                    retval.push(this);
            }
        });
        return (retval.length > 0 ? retval : false);
    }

    if (Options.OnUnfocus)
        this.OnUnfocus = Options.OnUnfocus;
    else
    {
        //Called when the selection box is unfocused. Defaults to clearing the input
        this.OnUnfocus = function() { _this.$input.val(''); }
    }

    this.$box = $(Options.obj);
    this.$box.addClass('cxtsel-box');

    this.$input = $('<input>', { type: 'text' });
    this.$input.on('blur', function (ev) { _this.OnUnfocus(); });
    this.$input.on('keydown', function (ev)
    {
        var menu = $(this).data('suggest');
        if (menu && ev.which == 40) //keydown focuses dropdown list
        {
            console.log('test keydown suggest');
            menu.Focus();
        }

        //adjust textbox to fit text
        ContextTextbox.$sizer.text($(this).val() + String.fromCharCode(ev.which));
        $(this).width(ContextTextbox.$sizer.width() + 24);

        if (ev.which == 8 && $(this).val().length < 1) //delete existing entries if there is no text and the backspace key is pressed
            _this.RemoveContext($(this).prev());
    });

    this.$input.on('keyup', function (ev)
    {
        var $tgt = $(this);

        //fit exactly
        ContextTextbox.$sizer.text($tgt.val());
        $tgt.width(ContextTextbox.$sizer.width());

        var menu = $tgt.data('context');
        if (menu)
            menu.Close();

        if (_this.Refresh)
            _this.Refresh(_this, $tgt.val());
    });

    this.$box.on('click', function () { $(this).children('input').trigger('focus'); });
    this.$box.append(this.$input);
}
