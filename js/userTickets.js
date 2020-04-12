function filterTickets(filter) {
    $('#complaints tr').each(function (index, tr) {
        console.log($(filter).val());
        if(!$(tr).attr('data-number').toLowerCase().match($(filter).val().toLowerCase())){
            $(tr).hide();
        }else{
            $(tr).show();
        }
    });
}

function getAllTickets(status) {

    $('#complaints tr').remove();

    const request = {};
    request.get_all_tickets = true;

    $.ajax({
        method: "POST",
        url: "userManagmentApi.php",
        data: request,
        success: function (response) {
            console.log('success:' + JSON.stringify(response));

            let res = JSON.parse(response);
            let reason;


            let index = 0;
            let test = "";
            let unqiues = [];

            for(let i = 0; i < res.length; i++) {

                index = parseInt(res[i].number);

                console.log(res[i].reason);
                switch (res[i].reason) {
                    case "Cannot Login": {
                        reason = "cannot_login";
                        break;
                    }
                    case "Not Receiving Verification Email": {
                        reason = "not_receiving_verification_Email";
                        break;
                    }
                    case "Other": {
                        reason = "other";
                        break;
                    }
                    case "Continous Stalking":{
                        reason = "continous_stalking";
                        break;
                    }
                    case "Inapropiate Behaviour":{
                        reason = "inapropiate_behaviour";
                        break;
                    }
                    case "Abusive Messages":{
                        reason = "abusive_messages";
                        break;
                    }
                }

                let id = "#response_" + i;


                if (res[i].status === status) {

                    if (!unqiues.includes(index)) {

                             test += '<tr class="clickable-row" data-number="' + res[i].number + '" data-query="' + index + '" onclick="expand(\'#collapseme_' + i + '\')" data-status="' + reason + '">' +
                            '<td>' +
                            '<div class="ckbox">' +
                            '<input type="checkbox" id="checkbox5">' +
                            '<label for="checkbox5"></label>' +
                            '</div>' +
                            '</td>' +
                            '<td>' +
                            '<div class="media" style="width: 50px; height: 50px;">' +
                            '<img style="width: 50px; height: 50px;" src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">' +
                            '</div>' +
                            '</td>' +
                            '<td>' +
                            '<div class="media-body">' +
                            '<div class="pull-right"><span class="label label-danger pull-right">' + res[i].reason + '</span><br>' +
                            '<span class="media-meta">' + res[i].date + '</span></div>' +
                            '<div><h4 class="title" style="display: inline-block;">' + res[i].username + '</h4><h5 style="display: inline-block;" class="ml-3">Ticket number: ' + res[i].number + '</h5><div>' +
                            '<p class="summary" style="display: inline-block; text-overflow: ellipsis; width: 50%; height: 20px; overflow: hidden;"><strong>Message</strong>: ' + res[i].description + '</p>' +
                            '</td>' +
                            '<td>' +
                            '<div class="btn-group" style="display: block; height: 50px;">' +
                            '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>' +
                            '<div class="dropdown-menu" id="drop-menu-' + i + '">';

                            if(res[i].status !== "Closed") {
                                test += '<a class="dropdown-item" href="#" onclick="updateTicket(\'' + res[i].number + '\',\'Closed\')"><i class="fas fa-times-circle"></i> Mark as Closed</a>';
                            }
                                test += '<a class="dropdown-item" href="#" onclick="deleteTicket(\'' + res[i].number + '\')"><i class="fas fa-trash-alt"></i> Delete Ticket</a>' +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            '</tr>' +
                            '<tr id="collapseme_' + i + '" class="collapse out" data-number="' + res[i].number + '" data-status="' + reason + '" hidden>' +
                            '<td colspan="4">' +
                            '<div class="panel-body wrap"">' +
                            '<div>' +
                            '<div>' +
                            '<div id="message_pane' + i + '">' +
                            '</div>' +
                            '   <textarea class="form-control counted" name="message" placeholder="Reply to user" rows="5" id="response_' + i + '" style="margin-bottom:10px;"></textarea>' +
                            '   <h6 class="pull-right" id="counter">320 characters remaining</h6>' +
                            '<button class="btn btn-info" onclick="sendMessage(\'' + "message_pane" + i + '\',\'' + $(id).val() + '\',\'Bartek\',\'' + res[i].number + '\',\'' + res[i].reason + '\')" type="submit">Reply</button>' +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            '</tr>';

                        $('#complaints').append(test);

                        test = "";



                        let menu_id = "#drop-menu-" + i;
                        if (parseInt(res[i].archived) === 0) {
                            $(menu_id).append('<a class="dropdown-item" href="#" onclick="updateTicket(\'' + res[i].number + '\',\'' + "Archived" + '\')"><i class="fas fa-archive"></i> Mark as Archived</a>');
                        }

                        console.log(res[i].archived);
                    }

                    for (let j = 0; j < res.length; j++) {
                        if (index === parseInt(res[j].number) && !unqiues.includes(index)) {
                            $('#message_pane' + i).append(
                                '<div style="display: inline-block;">' +
                                '<h4 class="title" style="margin-bottom: 20px;" ">' + res[j].username + '</h4>' +
                                '<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">' +
                                '</div>' +
                                '<div style="margin-top: 20px;">' +
                                '   <p><span>' + res[j].description + '</span></p>' +
                                '<hr>' +
                                '<span class="media-meta pull-right" style="margin-bottom: 20px;">' + res[j].date + '</span>' +
                                '</div> '
                            );
                        }
                    }

                    unqiues.push(index);

                }
            }
        },
        failure: function (response) {
            console.log('failure:' + JSON.stringify(response));
        },
        error: function (response) {
            console.log('error:' + JSON.stringify(response));
        }
    });
}

function deleteTicket(number) {
    const request = {};
    request.deleteTicket = true;
    request.number = parseInt(number);

    $.ajax({
        method: "POST",
        url: "userManagmentApi.php",
        data: request,
        success: function (response) {

            let res = JSON.parse(response);
            console.log('success:' + JSON.stringify(response));
            $('#complaints tr').each(function (index, tr) {
                if(parseInt($(this).attr('data-number')) === number){
                    $('#complaints').removeChild(tr);
                }
            });

            Swal.fire(res.title, res.message, res.type);
            fillTicketsNumbers();
            getAllTickets('Opened');

        },
        failure: function (response) {
            console.log('failure:' + JSON.stringify(response));
        },
        error: function (response) {
            console.log('error:' + JSON.stringify(response));
        }
    });
}

function updateTicket(number, status) {

    const request = {};
    request.updateTicket = true;
    request.number = parseInt(number);

    console.log(number);

    switch (status) {
        case "Archived":{
            request.archived_ticket = true;
            break;
        }
        case "Closed":{
            request.close_ticket = true;
            break;
        }
        case "Unresolved":{
            request.unresolved_ticket = true;
            break;
        }
    }

    $.ajax({
        method: "POST",
        url: "userManagmentApi.php",
        data: request,
        success: function (response) {
            console.log('success:' + JSON.stringify(response));

            $('#complaints tr').each(function (index, tr) {
                if(parseInt($(this).attr('data-number')) === number){
                    $('#complaints').removeChild(tr);
                }
            });

            fillTicketsNumbers();
            let res = JSON.parse(response);
            Swal.fire(res.title, res.message, res.type);

        },
        failure: function (response) {
            console.log('failure:' + JSON.stringify(response));
        },
        error: function (response) {
            console.log('error:' + JSON.stringify(response));
        }
    });

}

function sendMessage(id, message, username,number, reason) {
    const request = {};
    request.send_query_message = true;
    request.userDesc = message;
    request.userName = username;
    request.userEmail = username+'@idate.ie';
    request.number = number;
    request.userReason = reason;
    request.date = getDate();
    request.archived = false;

    let message_id = "#"+id;

    $.ajax({
        method: "POST",
        url: "api.php",
        data: request,
        success: function (response) {
            console.log('success:' + JSON.stringify(response));
            $(message_id).append(
                '<div>' +
                '<div style="display: inline-block;" class="pull-right">' +
                '<h4 class="title" style="margin-bottom: 20px;" ">'+username+'</h4>' +
                '<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo pull-right">' +
                '</div>' +
                '<div style="display: inline-block; margin-top: 20px;">' +
                '   <p><span>'+message+'</span></p>' +
                '<hr>'+
                '<span class="media-meta pull-left" style="margin-bottom: 20px;">'+request.date+'</span>'+
                '</div> '+
                '</div>'
            );
        },
        failure: function (response) {
            console.log('failure:' + JSON.stringify(response));
        },
        error: function (response) {
            console.log('error:' + JSON.stringify(response));
        }
    });


}

function getDate() {
    let m = new Date();
    return m.getUTCFullYear() + "-" +
        ("0" + (m.getUTCMonth() + 1)).slice(-2) + "-" +
        ("0" + m.getUTCDate()).slice(-2) + " " +
        ("0" + m.getUTCHours()).slice(-2) + ":" +
        ("0" + m.getUTCMinutes()).slice(-2) + ":" +
        ("0" + m.getUTCSeconds()).slice(-2);
}

function expand(res){
    if($(res).hasClass("out")) {
        $(res).attr('hidden',false);
        $(res).addClass("in");
        $(res).removeClass("out");
    } else {
        $(res).addClass("out");
        $(res).removeClass("in");
        $(res).attr('hidden',true);
    }
}

$(document).ready(function () {

    $('.ckbox label').on('click', function () {
        $(this).parents('tr').toggleClass('selected');
    });

    $('.btn-filter').on('click', function () {
        const $target = $(this).data('target');
        if ($target != 'all') {
            $('.table tr').css('display', 'none');
            $('.table tr[data-status="' + $target + '"]').fadeIn('slow');
        } else {
            $('.table tr').css('display', 'none').fadeIn('slow');
        }
    });

});



(function($) {

    $.fn.charCounter = function (max, settings) {
        max = max || 100;
        settings = $.extend({
            container: "<span></span>",
            classname: "charcounter",
            format: "(%1 characters remaining)",
            pulse: true,
            delay: 0
        }, settings);
        var p, timeout;

        function count(el, container) {
            el = $(el);
            if (el.val().length > max) {
                el.val(el.val().substring(0, max));
                if (settings.pulse && !p) {
                    pulse(container, true);
                };
            };
            if (settings.delay > 0) {
                if (timeout) {
                    window.clearTimeout(timeout);
                }
                timeout = window.setTimeout(function () {
                    container.html(settings.format.replace(/%1/, (max - el.val().length)));
                }, settings.delay);
            } else {
                container.html(settings.format.replace(/%1/, (max - el.val().length)));
            }
        };

        function pulse(el, again) {
            if (p) {
                window.clearTimeout(p);
                p = null;
            };
            el.animate({ opacity: 0.1 }, 100, function () {
                $(this).animate({ opacity: 1.0 }, 100);
            });
            if (again) {
                p = window.setTimeout(function () { pulse(el) }, 200);
            };
        };

        return this.each(function () {
            var container;
            if (!settings.container.match(/^<.+>$/)) {
                // use existing element to hold counter message
                container = $(settings.container);
            } else {
                // append element to hold counter message (clean up old element first)
                $(this).next("." + settings.classname).remove();
                container = $(settings.container)
                    .insertAfter(this)
                    .addClass(settings.classname);
            }
            $(this)
                .unbind(".charCounter")
                .bind("keydown.charCounter", function () { count(this, container); })
                .bind("keypress.charCounter", function () { count(this, container); })
                .bind("keyup.charCounter", function () { count(this, container); })
                .bind("focus.charCounter", function () { count(this, container); })
                .bind("mouseover.charCounter", function () { count(this, container); })
                .bind("mouseout.charCounter", function () { count(this, container); })
                .bind("paste.charCounter", function () {
                    var me = this;
                    setTimeout(function () { count(me, container); }, 10);
                });
            if (this.addEventListener) {
                this.addEventListener('input', function () { count(this, container); }, false);
            };
            count(this, container);
        });
    };

})(jQuery);


