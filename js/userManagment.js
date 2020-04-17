
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


function getBlockedInfo(username){
    const request = {};
    request.get_block_reason = true;
    request.username = username;

    $.ajax({
        method: "POST",
        url: 'userManagmentApi.php',
        data: request,
        success: function (response) {
            console.log('success:' + JSON.stringify(response));
            let res =JSON.parse(response);
            let reason = "";
            switch (res.reason) {
                case "breach_of_terms_and_conditiosn":{
                    reason = "Breach of Terms And Conditions";
                    break;
                }
                case "continous_incmopliance":{
                    reason = "Continous Incompliance";
                    break;
                }
                case "reported_by_use":{
                    reason = "Reported By Users";
                    break;
                }
            }
            Swal.fire({
                title: 'Blocked Info',
                text :  username + " has been blocked for " + reason + " on the " + res.date,
                icon: 'info'
            });
        },
        failure: function (response) {
            console.log('failure:' + JSON.stringify(response));
        },
        error: function (response) {
            console.log('error:' + JSON.stringify(response));
        }
    });
}

async function userActionTwo(action, user, name, email, id) {


    let inputOptions = {};
    inputOptions.sender_name = "iDate Customer Service Team";
    inputOptions.update_user = true;
    inputOptions.name = name;
    inputOptions.email = email;

    if(action === 'delete'){
        inputOptions.action = 'delete';
    }else if(action === 'block'){
        inputOptions.action = 'block';
    }


    let ops = {};

    if(action === 'delete'){
        inputOptions.user = id;
        console.log("fjwkbfuweufuweugfigew "  + id);
        ops = {
            inactive_account: 'Inactive Account',
            breach_of_terms_and_conditiosn: 'Breach Of Terms And Conditions',
            reported_by_several_users: 'Reported By Several Users',
        }
    }else if(action === 'block'){
        inputOptions.user = user;
        ops = {
            breach_of_terms_and_conditiosn: 'Breach Of Terms And Conditions',
            continous_incmopliance: 'Continous Incompliance',
            reported_by_use: 'Reported By User'
        }
    }

    const { value: reason } = await Swal.fire({
        title: 'Select A Reason',
        text: 'Select A Reason for taking this action against ' + user,
        input: 'select',
        inputOptions: ops,
        inputPlaceholder: 'Select A Reason',
        showCancelButton: true,
        inputValidator: (value) => {
            return new Promise((resolve) => {
                if (value !== '') {
                    resolve()
                } else {
                    resolve('You need to select oranges :)')
                }
            })
        }
    });

    console.log("reason " + reason);
    if (reason) {

        inputOptions.reason = reason;

        $.ajax({
            method: "POST",
            url: 'userManagmentApi.php',
            data: inputOptions,
            success: function (response) {

                console.log(response);
                if(action === 'block'){
                    Swal.fire({
                        title : "User Blocked",
                        text : "User has been blocked Successfully",
                        icon : "success"
                    });
                }else if(action === 'delete'){
                    Swal.fire({
                        title : "User Deleted",
                        text : "User has been deleted Successfully",
                        icon : "success"
                    });
                }
                showUserManagment(null);
                fillMembersNumbers();

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

}


function editField(elem) {
   let res = $(elem).attr('data-id');
   res = "#"+res;



   if($(res).attr('data-active') === 'false'){
       $(res).attr('data-active', 'true');
       $(res).removeClass('hide-input');
       $(elem).text("Save");
   }else{
       saveUserData();
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


function clearValues() {
    $("#user_nm").val("");
    $("#first_name").val("");
    $('#user_email_input').val("");
    $('#user_last_name_input').val("");
    $('#location').val("");
    $('#user_profile_header').text("User Profile");
}

function editProfile(elem) {

    document.getElementById('mang_pro').src = "";
    showAllEditButton();
    let userName = $(elem).find("#userName").text();
    let name = $(elem).find("#user_name").text().split(" ");
    let email = $(elem).find('#userEmail').text();

    $('#user_profile_header').text(userName);
    $('#user_email_input').val(email);
    $('#first_name').val(name[0]);
    $('#user_last_name_input').val(name[1]);
    $('#location').val(($(elem).attr('data-town') === null ? "Unknown" : ($(elem).attr('data-town'))));

    let gender = $(elem).attr('data-gender');
    let photoId = $(elem).attr('data-photoId');

    if(photoId !== "null"){
        document.getElementById('mang_pro').src = photoId;
    }else{
        document.getElementById('mang_pro').src = (gender === 'Male' ? 'images/male.png' : 'images/female.png');
    }



    let res = $('#tableBody').find('.active');

    if($(elem).attr('data-id') === $(res).attr('data-id')){
        $(res).removeClass('active');
        clearValues();
        hideAllEditButtons();
        document.getElementById('mang_pro').src = "images/icons/userIcon.png";
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

function activateUser(username, email) {

    const request = {};
    request.user = username;
    request.action = 'activate';
    request.update_user = true;
    request.email = email;
    $.ajax({
        method: "POST",
        url: 'userManagmentApi.php',
        data: request,
        success: function (response) {
            let res = JSON.parse(response);
            if(res.statusCode === 1) {
                Swal.fire({
                    title: "User Activated Successfully",
                    text: 'User '+username+" has been activated successfully",
                    icon: 'success'
                });

            }else if(res.statusCode === 2){
                Swal.fire({
                    title: "Failed to activate user",
                    text: 'Failed to activate user '+username+" successfully",
                    icon: 'error'
                })
            }
            showUserManagment(0);
            fillMembersNumbers();
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

function saveUserData() {
    const request = {};
    request.username = $('#user_profile_header').text();
    request.email = $('#user_email_input').val();
    request.firstname = $('#first_name').val();
    request.lastname = $('#user_last_name_input').val();
    request.save_user_info = true;



    if(request.username === ""){
        Swal.fire("Select a user to update his info");
    }
    else {

        if(request.firstname.length === 0 || request.email.length === 0 || request.lastname.length === 0){
                Swal.fire({
                    title: "Please Fill In All Fields",
                    text: "All Fields Have To Be Filled In",
                    icon: "warning"
                });
        }else {
            if ($('#profile_input_user_last_name').val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                    Swal.fire({
                        title: "Email Error",
                        text: "Email is not valid",
                        icon: "warning"
                    });
            } else {
                $.ajax({
                    method: "POST",
                    url: 'userManagmentApi.php',
                    data: request,
                    success: function (response) {
                        let res = JSON.parse(response);
                        if (res.statusCode === 1) {
                            Swal.fire({
                                title: "User info has been successfully updated",
                                text: 'User ' + username + " details have been updated successfully",
                                icon: 'success'
                            });
                        } else if (res.statusCode === 2) {
                            Swal.fire({
                                title: "Failed to update User info successfully",
                                text: 'Failed to update users ' + username + " details",
                                icon: 'error'
                            });
                        }
                            showUserManagment(null);
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
            }
        }
}


function unblockUser(username, email) {

    const request = {};
    request.user = username;
    request.action = 'unblock';
    request.update_user = true;
    request.email = email;
    $.ajax({
        method: "POST",
        url: 'userManagmentApi.php',
        data: request,
        success: function (response) {
            let res = JSON.parse(response);
            if(res.statusCode === 1) {
                Swal.fire({
                    title: 'Unblocked ' + username + " Successfully",
                    text: 'User '+username+" has been unblocked successfully",
                    icon: 'success'
                });

            }else if(res.statusCode === 2){
                Swal.fire({
                    title: "Failed to unblock user",
                    text: 'Failed to unblock user '+username+" successfully",
                    icon: 'error'
                })
            }
            showUserManagment(null);
            fillMembersNumbers();
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

function resetEmail(username, email) {

    const request = {};
    request.password_reset_email = true;
    request.reset_uname = username;
    request.reset_email = email;
    $.ajax({
        method: "POST",
        url: 'api.php',
        data: request,
        success: function (response) {
            console.log(response);
                Swal.fire({
                    title: "Password reset sent",
                    text: 'Password reset email sent successfully',
                    icon: 'success'
                });
        },
        failure: function (response) {
            console.log('failure:' + JSON.stringify(response));
        },
        error: function (response) {
            console.log('error:' + JSON.stringify(response));
        }
    });
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

            let ress = response.replace(/.$/,"]");
            let res = JSON.parse(ress);
            console.log(res);


            for(let i = 0; i < res.length; i++)
            {

                let def = JSON.parse(res[i]);
                let node =
                    '<tr data-id='+i+' class="clickable-row" onclick="editProfile(this)"  data-town='+def.town+' data-status='+def.blocked+' data-gender="'+def.gender+'" data-photoId="'+def.photoId+'" style="padding-top: 5px;">' +
                    '<td>'+(parseInt(def.registered) === 0 ? "<span class=\"label label-warning\" id='status'>Pending</span>" : (parseInt(def.blocked) === 0 ? "<span class=\"label label-success\" id='status'>Active</span>" : "<span class=\"label label-danger\" id='status'>Blocked</span>"))+'</small></td>'+
                    '<td><small id="userName">'+def.userName+'</small></td>'+
                    '<td><small id="user_name">'+def.name+'</small></td>'+
                    '<td><small id="userEmail">'+def.email+'</small></td>'+
                    '<td><small>'+(parseInt(def.admin) === 0 ? "<span class=\"label label-primary\" id='role'>User</span>" : "<span class=\"label label-info\" id='role'>Admin</span>")+'</small></td>'+
                    '<td>';
                if(def.userName !== $('#username-header').attr('user-name')) {
                    node += '<div class="btn-group">' +
                        '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>' +
                        '<div class="dropdown-menu">';

                    if (parseInt(def.registered) === 0) {
                        node += '<a class="dropdown-item" href="#" onclick="activateUser(\'' + def.userName + '\',\''+def.email+'\')"><i class="fas fa-user-plus mr-2"></i>Activate</a>';
                    }

                    if (parseInt(def.blocked) === 1) {
                        node += '<a class="dropdown-item" href="#" onclick="getBlockedInfo(\'' + def.userName + '\')"><i class="fas fa-user-lock mr-2"></i>Block Info</a>'+
                                '<a class="dropdown-item" href="#" onclick="unblockUser(\'' + def.userName + '\',\''+def.email+'\')"><i class="fas fa-user-lock mr-2"></i>Unblock</a>';
                    } else node += '<a class="dropdown-item" href="#" onclick="userActionTwo(\'block\',\'' + def.userName + '\',\'' + def.name + '\',\'' + def.email + '\',\'' + null + '\')"><i class="fas fa-user-lock mr-2"></i>Block</a>'+
                        '<a class="dropdown-item" href="#" onclick="userActionTwo(\'delete\',\'' + def.userName + '\',\'' + def.name + '\',\'' + def.email + '\',\'' + def.userId + '\')"><i class="fas fa-user-lock mr-2"></i>Delete</a>';

                    if (parseInt(def.admin) === 0) {
                        node += '<a class="dropdown-item" href="#" onclick="userAdmin(\'' + def.userName + '\',\'Add\')"><i class="fas fa-user-plus"></i>Add User as Admin</a>';
                    } else {
                        node += '<a class="dropdown-item" href="#" onclick="userAdmin(\'' + def.userName + '\',\'Remove\')"><i class="fas fa-user-minus"></i>Remove User a Admin</a>';
                    }

                    if (parseInt(def.registered) === 0) {
                        node +=
                            '<div class="dropdown-divider"></div>' +
                            '<a class="dropdown-item" href="#" onclick="sendVerificationEmail(\'' + def.email + '\',\'' + def.userName + '\')"><i class="fas fa-paper-plane mr-2"></i>Resend Activation Email</a>';
                    }

                    node +=
                        '<a class="dropdown-item" href="#" onclick="resetEmail(\'' + def.userName + '\',\'' + def.email + '\')"><i class="fas fa-paper-plane mr-2"></i>Send Password Reset Email</a>';

                }

                    node +='</div>'+
                            '</div>'+
                            '</td>'+
                            '</tr>';

                    if(verified !== null && parseInt(def.registered) === 0 && verified === 0){
                        $('#tableBody').append(node);
                        counter++;
                    }else if(verified !== null && verified === 1 && parseInt(def.blocked) === 1){
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