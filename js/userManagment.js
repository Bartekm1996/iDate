
function filter(elem, attr) {
    let res = $('#tableBody tr');
    let input;

    if(elem.id !== "status" || elem.id !== "role"){
        input = $(elem).val();
    }else{
        input = document.getElementById(elem.id).value;
    }

    console.log(input);

    let counter = 0;

    for(let i = 0; i < res.length; i++){
        if(input === 'status' || input === 'role'){
            $(res[i]).attr('hidden',false);
        }else {
            if (!$(res[i]).find(attr).text().toLowerCase().match(input.toLowerCase())) {
                $(res[i]).attr('hidden', true);
                counter++;
            } else {
                $(res[i]).attr('hidden',false);
            }
        }
    }

    counter = res.length - counter;

    $('#column_size').html("Showing  entries " + counter);


}

async function userActionTwo(action, user) {
    let inputOptions = {};

    if(action === 'delete'){
        inputOptions.inactiveaccount = 'Inactive Account',
        inputOptions.breachOfTermsAndConditions = 'Breach Of Terms And Conditions',
        inputOptions.reportedBySeveralUsers = 'Reported By Several Users'
    }else if(action === 'block'){
        inputOptions.breachOfTermsAndConditions = 'Breach Of Terms And Conditions',
        inputOptions.continousincompliance = 'Continous Incompliance',
        inputOptions.reportedByUser = 'Reported By User'
    }



    const {value: reason} = await Swal.fire({
        title: 'Select A Reason',
        text: 'Select A Reason for taking this action against ' + user,
        input: 'select',
        inputOptions: inputOptions,
        inputPlaceholder: 'Select A Reason',
        showCancelButton: true,
        inputValidator: (value) => {
            return new Promise((resolve) => {
                if (value.length === 0) {
                    resolve('You need to select a reason')
                }
            })
        }
    })

    if (reason) {
       sendEmail(reason);
    }

    }

}


function editField(elem) {
   let res = $(elem).attr('data-id');
   res = "#"+res;

   if($(res).attr('data-active') === 'false'){
       $(res).attr('data-active', 'true');
       $(res).removeClass('hide-input');
       $(elem).text("Save");
   }else{
       $(res).attr('data-active', 'false');
       $(res).addClass('hide-input');
       $(elem).text("");
       $(elem).html('<i class="fas fa-pen"></i>');

   }

}

function showAllEditButton() {
    $("#user_edit_first_name").attr('hidden',false);
    $("#user_edit_user_name").attr('hidden',false);
    $('#user_edit_last_name').attr('hidden',false);
    $('#user_edit_email').attr('hidden',false);
}

function hideAllEditButtons() {
    $("#user_edit_first_name").attr('hidden',true);
    $("#user_edit_user_name").attr('hidden',true);
    $('#user_edit_last_name').attr('hidden',true);
    $('#user_edit_email').attr('hidden',true);
}

function sendEmail(reason) {
    const request = {};
    request.get_all_users = true;

    $.ajax({
        method: "POST",
        url: 'userManagmentApi.php',
        data: request,
        success: function (response) {
            Swal.fire(`And Email Has Been Sent To The User`);
            console.log('success:' + JSON.stringify(response));
        },
        failure: function (response) {
            console.log('failure:' + JSON.stringify(response));
        },
        error: function (response) {
            console.log('error:' + JSON.stringify(response));
        }
    });
}

function clearValues() {
    $("#user_nm").val("");
    $("#first_name").val("");
    $('#user_email_input').val("");
    $('#user_last_name_input').val("");
    $('#location').val("");
    $('#user_profile_header').text("User Profile");
}

function editProfile(elem) {

    showAllEditButton();
    let userName = $(elem).find("#userName").text();
    let name = $(elem).find("#user_name").text().split(" ");
    let email = $(elem).find('#userEmail').text();


    $('#user_profile_header').text(userName);
    $('#user_email_input').val(email);
    $('#first_name').val(name[0]);
    $('#user_last_name_input').val(name[1]);
    $('#location').val("Unknown");

    let res = $('#tableBody').find('.active');

    if($(elem).attr('data-id') === $(res).attr('data-id')){
        $(res).removeClass('active');
        clearValues();
        hideAllEditButtons();
    }else{
        $(res).removeClass('active');
        $(elem).addClass('active');
    }
}

function  sendVerificationEmail(email, username) {
    const request = {};
    request.resend_verification_email = true;
    request.email = email;
    request.username = username;


    $.ajax({
        method: "POST",
        url: 'userManagmentApi.php',
        data: request,
        success: function (response) {
            Swal.fire(`And Email Has Been Sent To The User`);
            console.log('success:' + JSON.stringify(response));
        },
        failure: function (response) {
            console.log('failure:' + JSON.stringify(response));
        },
        error: function (response) {
            console.log('error:' + JSON.stringify(response));
        }
    });

}

function userAdmin(username, change) {

    const request = {};
    request.change_user_admin_status = true;
    request.username = username;
    request.change = change;

    let info = (change === "Remove" ? "Removed" : "Added");


    console.log(username);
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure you want to '+ change + " " + username + ' as Admin',
        text: 'This can be changed anytime',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes !',
        cancelButtonText: 'No !',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                method: "POST",
                url: 'userManagmentApi.php',
                data: request,
                success: function (response) {
                    let res = JSON.parse(response);

                    getUserData(null);

                    if(res.statusCode === 1) {
                        Swal.fire({
                            title: 'User ' + info + " as Admin",
                            text: 'User has been added ' + info + " as Admin",
                            icon: 'success'
                        });

                    }else if(res.statusCode === 2){
                        Swal.fire({
                           title: 'Failed User to ' +info + " as Admin",
                           text: 'Failed User to ' +info + " as Admin",
                           icon: 'warning'
                        })
                    }
                    console.log('success:' + JSON.stringify(response));
                },
                failure: function (response) {
                    console.log('failure:' + JSON.stringify(response));
                },
                error: function (response) {
                    console.log('error:' + JSON.stringify(response));
                }
            });

        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your action has been cancelled by you',
                'error'
            )
        }
    })

}

function getUserData(verified) {

    $('#tableBody tr').remove();

    const request = {};
    request.get_all_users = true;

    let counter = 0;

    $.ajax({
        method: "POST",
        url: 'userManagmentApi.php',
        data: request,
        success: function (response) {
            console.log('success:' + JSON.parse(response)[0].userId);

            let res = JSON.parse(response);

            for(let i = 0; i < res.length; i++)
            {
                let node =
                    '<tr data-id='+i+' class="clickable-row" onclick="editProfile(this)" style="padding-top: 5px;">' +
                    '<td>'+(parseInt(res[i].registered) === 0 ? "<span class=\"label label-warning\" id='status'>Pending</span>" : (parseInt(res[i].blocked) === 0 ? "<span class=\"label label-success\" id='status'>Active</span>" : "<span class=\"label label-danger\" id='status'>Blocked</span>"))+'</small></td>'+
                    '<td><small id="userName">'+res[i].userName+'</small></td>'+
                    '<td><small id="user_name">'+res[i].name+'</small></td>'+
                    '<td><small id="userEmail">'+res[i].email+'</small></td>'+
                    '<td><small>'+(parseInt(res[i].admin) === 0 ? "<span class=\"label label-primary\" id='role'>User</span>" : "<span class=\"label label-info\" id='role'>Admin</span>")+'</small></td>'+
                    '<td>'+
                    '<div class="btn-group">' +
                    '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>'+
                    '<div class="dropdown-menu">';

                    if(parseInt(res[i].registered) === 0){
                        node += '<a class="dropdown-item" href="#"><i class="fas fa-user-plus mr-2"></i>Activate</a>';
                    }

                    node +=
                        '<a class="dropdown-item" href="#" onclick="userActionTwo(\'block\',\''+res[i].userName+'\')"><i class="fas fa-user-lock mr-2"></i>Block</a>'+
                        '<a class="dropdown-item" href="#" onclick="userActionTwo(\'delete\',\''+res[i].userName+'\')"><i class="fas fa-user-minus mr-2"></i>Delete</a>';

                    if(parseInt(res[i].admin) === 0){
                        node +=  '<a class="dropdown-item" href="#" onclick="userAdmin(\''+res[i].userName+'\',\'Add\')"><i class="fas fa-user-plus"></i>Add User as Admin</a>';
                    }else{
                        node += '<a class="dropdown-item" href="#" onclick="userAdmin(\''+res[i].userName+'\',\'Remove\')"><i class="fas fa-user-minus"></i>Remove User a Admin</a>';
                    }

                    if(parseInt(res[i].registered) === 0) {
                        node +=
                            '<div class="dropdown-divider"></div>'+
                            '<a class="dropdown-item" href="#" onclick="sendVerificationEmail(\'' + res[i].email + '\',\'' + res[i].userName + '\')"><i class="fas fa-paper-plane mr-2"></i>Resend Activation Email</a>';
                    }

                    node +='</div>'+
                            '</div>'+
                            '</td>'+
                            '</tr>';

                    if(verified !== null && parseInt(res[i].registered) === 0 && verified === 0){
                        $('#tableBody').append(node);
                        counter++;
                    }else if(verified !== null && verified === 1 && parseInt(res[i].blocked) === 1){
                        $('#tableBody').append(node);
                        counter++;
                    }else if(verified === null){
                        $('#tableBody').append(node);
                        counter++;
                    }




            }

            $('#column_size').text("Total entries " + counter);

        },
        failure: function (response) {
            console.log('failure:' + JSON.stringify(response));
        },
        error: function (response) {
            console.log('error:' + JSON.stringify(response));
        }
    });
}