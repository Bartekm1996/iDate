function getAllTickets() {

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


            for(let i = 0; i < res.length; i++) {


                switch (res[i].reason) {
                    case "Cannot Login":{
                        reason = "cannot_login";
                        break;
                    }
                    case "Not Receiving Verification Email":{
                        reason = "not_receiving_verification_Email";
                        break;
                    }
                    case "Other":{
                        reason = "other";
                        break;
                    }
                }

                $('#complaints').append(
                    '<tr class="clickable-row" onclick="expand(\'#collapseme_'+i+'\')" data-status="'+reason+'">' +
                    '<td>' +
                    '<div class="ckbox">' +
                    '<input type="checkbox" id="checkbox5">' +
                    '<label for="checkbox5"></label>' +
                    '</div>' +
                    '</td>' +
                    '<td>' +
                    '</td>' +
                    '<td>' +
                    '<div class="media">' +
                    '<a href="#" class="pull-left">' +
                    '<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">' +
                    '</a>' +
                    '<div class="media-body">' +
                    '<span class="media-meta pull-right">'+res[i].date+'</span>' +
                    '<h4 class="title">'+res[i].username+'<span class="pull-right label label-danger">'+res[i].reason+'</span></h4>' +
                    '<p class="summary" style="display: inline-block; text-overflow: ellipsis; width: 50%; height: 20px; overflow: hidden;"><strong>Message</strong>: '+res[i].description+'</p>' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '</tr>'+
                    '<tr id="collapseme_'+i+'" class="collapse out" data-status="'+reason+'" hidden>' +
                    '<td colspan="4">' +
                    '<div class="panel-body wrap"">' +
                    '<di>' +
                    '   <div>' +
                    '<div style="display: inline-block;">' +
                    '<h4 class="title" style="margin-bottom: 20px;" ">'+res[i].username+'</h4>' +
                    '<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">' +
                    '   </div>' +
                    '   <div style="display: inline-block; margin-top: 20px;">' +
                    '   <p><span>'+res[i].description+'</span></p>' +
                    '   </div> '+
                    '   </div>'+
                    '   <hr>'+
                    '   <span class="media-meta pull-right" style="margin-bottom: 20px;">'+res[i].date+'</span>'+
                    '   <textarea class="form-control counted" name="message" placeholder="Reply to user" rows="5" style="margin-bottom:10px;"></textarea>' +
                    '   <h6 class="pull-right" id="counter">320 characters remaining</h6>' +
                    '<button class="btn btn-info" type="submit">Reply</button>' +
                    '</di>'+
                    '</div>' +
                    '</td>' +
                    '</tr>'
                );
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
