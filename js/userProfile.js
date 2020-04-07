function showProfile(currentProfile, username, matched) {
    hideMatchArea();
    hideUserManagment();
    hideMatching();
    hideChat();
    hideTickets();
    getMyInterest($('#username-header').attr('user-id'));

    if(username !== null){
        if(matched === true){
            $('#card_message_button').attr('hidden', false);
            $('#card_report_button').attr('hidden', false);
        }else{
            $('#connect_button').attr('hidden', false);
        }
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
            console.log(JSON.parse(response));
            let res = JSON.parse(response);
            let defImage = res.photoId;

            if(defImage === null) {
                defImage = res.gender === 'Male' ? 'images/male.png' : 'images/female.png';
            }


            $('#user_profile_name').text("Hello " + res.firstName + " " + res.lastName);
            $('#profile_input_user_name').val(res.userName);
            $('#profile_input_user_email').val(res.email);
            $('#profile_input_user_first_name').val(res.firstName);
            $('#profile_input_user_last_name').val(res.lastName);
            $('#profile_bio').val(res.descripion);
            $('#profile_card_description').text(res.descripion);
            $('#profile_user_card_name').attr('user_age', res.age);
            $('#profile_user_card_name').text(res.firstName + " " + res.lastName + " , " +res.age);
            $('#seeking').text("Seeking : " + (res.seeking === "female" ? "Women" : "Men"));

            document.getElementById("upro_img").src = defImage;

        },
        failure: function (response) {
            console.log('failure:' + JSON.stringify(response));
        },
        error: function (response) {
            console.log('error:' + JSON.stringify(response));
        }
    });
}

function loadHistoryTable(username) {

    const request = {};
    request.last_logged_in = true;
    request.username = username;

    $.ajax({
        method: "GET",
        url: "Mongo.php",
        data: request,
        success: function (response) {
            console.log(response);
            if(response == null || response.length == 0) return;
            

            let res = JSON.parse(response);
            console.log(res.events[0].timestamp);

            if(res.events.length === 1){
                msg("Welcome " + username);
            }else {
                for (let i = (res.events.length - 1); i > -1; i--) {
                    if (res.events[i].event === "Log In") {
                        msg('Last Signed In ' + res.events[i].timestamp)
                        break;
                    }
                }
            }

            let table = $('#history_table_body');
            for(let i = 0; i < res.events.length; i++){
                table.append(
                    '<tr><td>' +
                    '<small>'+res.events[i].timestamp+'</small>'+
                    '</td>' +
                    '<td>' +
                    '<small>'+res.events[i].event+'</small>'+
                    '</td>' +
                    '<td>' +
                    '<small>'+res.events[i].description+'</small>'+
                    '</td></tr>'
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

function getMyInterest(userid) {
    const request = {};
    request.get_my_interests_api = true;
    request.userid = userid;

    $.ajax({
        method: "POST",
        url: "api.php",
        data: request,
        success: function (response) {
            let res = JSON.parse(response);
            console.log(res);
            let table = $('#interestResult');
            for(let i = 0; i < res.ints.length; i++){
                let ress = JSON.parse(res.ints[i]);
                table.append(
                    '<div style="height: 100px; width: 100px;">'+
                        '<div class="in-card">'+
                        '<div class="in-card-header">'+ress.name+'</div>'+
                        '<div class="in-card-main">'+
                        '<img src="'+ress.picture+'" width="100px" height="100px">'+
                        '<div class="in-main-description"'+ress.name+'</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'

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

function msg(txt){
    Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    }).fire({
        icon: 'success',
        title: txt
    })
}

function saveuserinformation() {
    const request = {};
    request.save_user_info = true;
    request.firstname = $('#profile_input_user_first_name').val();
    request.email = $('#profile_input_user_email').val();
    request.lastname = $('#profile_input_user_last_name').val();
    saveDate(request);
}

function saveaboutme() {
    const request = {};
    request.save_user_info = true;
    request.about_me = $('#profile_bio').val();
    request.user_id = $('#username-header').attr('user-id');
    saveDate(request);
}

function saveuserinfo() {

}

function saveDate(request) {
    $.ajax({
        method: "POST",
        url: "userManagmentApi.php",
        data: request,
        success: function (response) {
            let res = JSON.parse(response);
            Swal.fire(res.title, res.message, res.type);
            if(request.firstname !== " "){
                $('#user_profile_name').text("Hello " + request.firstname + " " + request.lastname);
                $('#profile_user_card_name').text(request.firstname + " " + request.lastname + " , " + $('#profile_user_card_name').attr('user_age'));
                $('#username-header').text(request.firstname);
            }else if(request.about_me !== " "){
                $('#profile_card_description').text(request.about_me);
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