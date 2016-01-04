$(document).ready(function ()
{
    $('#q').on('keypress', function (ev) { if (ev.which == 13) { ev.preventDefault(); $('#topbar-search').submit(); } });
    $('#top-feedback-button').on('click', function(ev)
    {
        ev.preventDefault();
        Dialogs.Feedback();
    });

    $('#top-login-button').on('click', function(ev)
    {
        ev.preventDefault();
        Dialogs.Login();
    });

    $('#top-new-button').on('click', function(ev)
    {
        ev.preventDefault();
        var options = {
            width: 200,
            x: ev.pageX - 100 - ($(this).outerWidth(true) / 4),
            y: $(this).position().top + $(this).height(),
            id: 'new-menu',
            fixed: true,
            items:
            {
                sitem:
                {
                    text: 'New Service',
                    link: '/service/new',
                    id: 'new-service',
                    classes: 'button-service text-center',
                    hint: 'Create a New Service'
                },
                sep: FloatingMenu.spacer,
                ritem:
                {
                    text: 'New Request',
                    link: '/request/new',
                    id: 'new-request',
                    classes: 'button-request text-center',
                    hint: 'Create a New Request'
                }
            }
        };
        new FloatingMenu(options);
    });

    $('#top-inbox-button').on('click', function(ev)
    {
        ev.preventDefault();
        var options = {
            width: 200,
            height: 48,
            x: ev.pageX - 100 - ($(this).outerWidth(true) / 4),
            y: $(this).position().top + $(this).height(),
            id: 'mail-menu',
            fixed: true,
            items:
            {
                load: { html: '<div class="loader theme-profile"></div>' }
            }
        };
        var mailm = new FloatingMenu(options);

        $.ajax(
        {
            url: '/submit/mail/list',
            dataType: 'json'
        }).done(function (data)
        {
            mailm.$menu.css('height', '').children().remove();
            for (var i = 0; i < data.length; i++)
            {
                mailm.AddItem(
                {
                    html: '<a class="small" href="{0}"><strong {5}>{1}</strong><br><span class="underline space-right">{2}</span><span class="hint pull-right">{3}</span><br><div>{4}</div></a>'
                    .format(
                        '/mail/inbox/' + data[i]['id'],
                        data[i]['subject'],
                        data[i]['sender_name'],
                        data[i]['time_string'],
                        data[i]['preview'] + '&hellip;',
                        data[i]['unread'] ? 'class="text-pad theme-indeterminate"' : ''
                    )
                });
            }
            mailm.AddItem(FloatingMenu.separator);
            mailm.AddItem({ text: 'Go to inbox', link: '/mail', classes: 'small underline tcenter' });
        }).fail(function(data)
        {
            mailm.$menu.css('height', '').children().remove();
            mailm.AddItem({ html: '<strong class="block text-pad tcenter">Error loading mail</strong>' });
            mailm.AddItem(FloatingMenu.separator);
            mailm.AddItem({ text: 'Go to inbox', link: '/mail', classes: 'small underline tcenter' });
        });
    });

    var mailRefresher = setInterval(function()
    {
        $.ajax('')
        .done(function(data)
        {
            $('#top-mail-notif-counter').text(isNaN(data) ? '' : (data > 99 ? '#' : data));
            if (isNaN(data) || data < 1)
                $('#top-mail-notif').fadeOut(200);
            else
                $('#top-mail-notif').fadeIn(200);
        });
    }, 10000);
    
    //temp
    clearInterval(mailRefresher);

    $(document).ready(function() { $('#top-debug-btn').on('click', function(ev) { ev.preventDefault(); if (DebugMenu) { $('#dbgmenu').fadeIn(200); new DebugMenu(); } }); });
});