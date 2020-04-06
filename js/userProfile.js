function showProfile(currentProfile, username) {


    console.log(currentProfile + " " + username);

    hideMatchArea();
    hideUserManagment();
    hideMatching();
    hideChat();
    hideTickets();

    if(username !== null){
        $('#connect_button').attr('hidden', false);
        $('#card_message_button').attr('hidden', false);
        disableFields();
    }else{
        $('#connect_button').attr('hidden', true);
        $('#card_message_button').attr('hidden', true);
        enableFields();
    }

    $('#user_profile').attr('hidden', false);


    const request = {};
    request.get_user_info = true;
    request.username = currentProfile;

    $.ajax({
        method: "POST",
        url: "userManagmentApi.php",
        data: request,
        success: function (response) {
            console.log(response);
            let res = JSON.parse(response);
            $('#user_profile_name').text("Hello " + res.firstName + " " + res.lastName);
            $('#profile_input_user_name').val(res.userName);
            $('#profile_input_user_email').val(res.email);
            $('#profile_input_user_first_name').val(res.firstName);
            $('#profile_input_user_last_name').val(res.lastName);
            $('#profile_user_card_name').text(res.firstName + " " + res.lastName + " , " +res.age);
        },
        failure: function (response) {
            console.log('failure:' + JSON.stringify(response));
        },
        error: function (response) {
            console.log('error:' + JSON.stringify(response));
        }
    });
}

function disableFields() {
    $('#profile_input_user_last_name').addClass('hide-input');
    $('#profile_input_user_last_name').attr('disabled',true);
    $('#profile_input_user_first_name').addClass('hide-input');
    $('#profile_input_user_first_name').attr('disabled',true);
    $('#profile_input_user_email').addClass('hide-input');
    $('#profile_input_user_email').attr('disabled',true);
    $('#profile_input_user_name').addClass('hide-input');
    $('#profile_input_user_name').attr('disabled',true);
    $('#user_profile_save_button').attr('hidden', true);
    $('#user_profile_contact_save_button').attr('hidden',true);
    $('#user_profile_about_me_save_button').attr('hidden',true);
    $('#user_profile_info_save_button').attr('hidden',true);
    $('#user_profile_interest_save_button').attr('hidden',true);
}

function enableFields(){
    $('#profile_input_user_last_name').removeClass('hide-input');
    $('#profile_input_user_last_name').attr('disabled',false);
    $('#profile_input_user_first_name').removeClass('hide-input');
    $('#profile_input_user_first_name').attr('disabled',false);
    $('#profile_input_user_email').removeClass('hide-input');
    $('#profile_input_user_email').attr('disabled',false);
    $('#profile_input_user_name').removeClass('hide-input');
    $('#profile_input_user_name').attr('disabled',false);
    $('#user_profile_save_button').attr('hidden', false);
    $('#user_profile_contact_save_button').attr('hidden',false);
    $('#user_profile_about_me_save_button').attr('hidden',false);
    $('#user_profile_info_save_button').attr('hidden',false);
    $('#user_profile_interest_save_button').attr('hidden',false);
}

function hideUserProfile() {
    $('#user_profile').attr('hidden', true);
}