function showProfile(currentProfile, username, matched) {

    console.log(currentProfile + " currentProfile");

    hideMatchArea();
    hideUserManagment();
    hideMatching();
    hideChat();
    hideTickets();

    console.log($('#person_fullname').attr('data-id'));


    if(username !== null){
        $('#user_ints').attr('hidden',true);
        if(matched === true){
            $('#card_message_button').attr('hidden', false);
            $('#card_report_button').attr('hidden', false);
            $('#connect_button').attr('hidden',true);
        }else{
            $('#card_report_button').attr('hidden', true);
            $('#connect_button').attr('hidden', false);
        }
        disableFields();
        $('#history_user_table').attr('hidden',true);
    }else{
        $('#user_ints').attr('hidden',false);
        $('#connect_button').attr('hidden', true);
        $('#card_message_button').attr('hidden', true);
        $('#history_user_table').attr('hidden',false);
        $('#card_report_button').attr('hidden',true);
        enableFields();
        getCitites();
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
            let defImage = res.photoId;

            if(defImage === null) {
                defImage = res.gender === 'Male' ? 'images/male.png' : 'images/female.png';
            }
            getMyInterest(res.id);

            $('#user_profile_name').text("Hello " + res.firstName + " " + res.lastName);
            $('#profile_input_user_name').val(res.userName);
            $('#profile_input_user_email').val(res.email);
            $('#profile_input_user_first_name').val(res.firstName);
            $('#profile_input_user_last_name').val(res.lastName);
            $('#profile_bio').val(res.descripion);
            $('#seeking_picker').val(res.seeking);
            $('#drinker_picker').val(res.drinker);
            $('#smoking_picker').val(res.smoker);
            $('#gender_picker').val(res.gender);
            $('#upro_img').attr('data-id',res.id);
            $('#upro_img').attr('data-gender', res.gender);
            $('#upro_img').attr('data-seeking', res.seeking);
            $('#city_select').val((res.town === null ? "Unknown" : res.town));
            $('#city_selected').text((res.town === null ? "Unknown" : res.town) + ",Ireland");
            $('#profile_card_description').text(res.descripion);
            $('#profile_user_card_name').attr('user_age', res.age);
            $('#profile_user_card_name').text(res.firstName + " " + res.lastName + " , " +res.age);
            $('#seeking').text("Seeking : " + (res.seeking === "female" ? "Women" : (res.seeking === "male" ? "Man" : "Other [Maybe Even Sheep]")));

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


function saveUserInfo() {
    const request = {};
    request.update_user_info = true;
    request.userId =  $('#username-header').attr('user-id');
    request.smoker = $('#smoking_picker').val();
    request.drinker = $('#drinker_picker').val();
    request.gender = $('#gender_picker').val();
    request.seeking = $('#seeking_picker').val();

    $.ajax({
        method: "POST",
        url: "userManagmentApi.php",
        data: request,
        success: function (response) {
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

function closeAccount(id) {

    const request = {};
    request.delete_user = true;
    request.userId = id;

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    method: "POST",
                    url: "userManagmentApi.php",
                    data: request,
                    success: function (response) {
                        console.log(JSON.parse(response));
                        let timerInterval
                        Swal.fire({
                            title: 'You\'re Account Is Being Closed!',
                            html: 'You will be redirect to Login Page In <b></b> milliseconds.',
                            timer: 2000,
                            icon: 'success',
                            timerProgressBar: true,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                                timerInterval = setInterval(() => {
                                    const content = Swal.getContent()
                                    if (content) {
                                        const b = content.querySelector('b')
                                        if (b) {
                                            b.textContent = Swal.getTimerLeft()
                                        }
                                    }
                                }, 100)
                            },
                            onClose: () => {
                                clearInterval(timerInterval);
                                killSessiosn();
                                window.location.href = 'index.php';
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                console.log('Account Was Closed We\'re Sad to see you go')
                            }
                        })
                    },
                    failure: function (response) {
                        console.log('failure:' + JSON.stringify(response));
                    },
                    error: function (response) {
                        console.log('error:' + JSON.stringify(response));
                    }
                });

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your profile is safe :)',
                    'error'
                )
            }
        })

}

function killSessiosn() {
    let request = {};
    request.logout_api = true;
    sendDataTest(request, 'api.php');
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
            

            console.log(response);
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

    console.log("User id " + userid);

    const request = {};
    request.get_my_interests_api = true;
    request.userid = userid;

    $('#interestResult').empty();
    $('#card_interest_results').empty();

    let interests_edits = $('#user_profile_interest_save_button');
    let res_id = [];
    let res_name = [];

    $.ajax({
        method: "POST",
        url: "api.php",
        data: request,
        success: function (response) {
            console.log(response);
            if(response.length > 0) {
                let res = JSON.parse(response);
                console.log(res);
                let table = $('#interestResult');
                let sideTable = $('#card_interest_results');
                for (let i = 0; i < res.ints.length; i++) {
                    let ress = JSON.parse(res.ints[i]);
                    table.append(
                        '<div style="height: 100px; width: 100px;">' +
                        '<div class="in-card">' +
                        '<div class="in-card-header">' + ress.name + '</div>' +
                        '<div class="in-card-main">' +
                        '<img src="' + ress.picture + '" width="100px" height="100px">' +
                        '<div class="in-main-description"' + ress.name + '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>');

                    res_id.push(parseInt(ress.id));
                    res_name.push(ress.name);

                    sideTable.append(
                        '<span class="badge badge-primary" style="height: 25px; text-align: center; background: #2565AE">' + ress.name + '</span>'
                    );
                }
            }
            interests_edits.attr('data-ints-ids', res_id);
            interests_edits.attr('data-ints-names', res_name);
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
    $('#profile_bio').attr('disabled',true);
    $('#profile_bio').attr('read-only',true);
    $('#input-address').attr('disabled',true);
    $('#input-city').attr('disabled',true);
    $('#input-country').attr('disabled',true);
    $('#input-postal-code').attr('disabled',true);
    $('#gender_picker').attr('disabled',true);
    $('#seeking_picker').attr('disabled',true);
    $('#drinker_picker').attr('disabled',true);
    $('#smoking_picker').attr('disabled',true);
    $('#close_account_button').attr('hidden',true);
    $('#city_select').attr('disabled',true);
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
    $('#profile_bio').attr('disabled',false);
    $('#profile_bio').attr('read-only',false);
    $('#input-address').attr('disabled',false);
    $('#input-city').attr('disabled',false);
    $('#input-country').attr('disabled',false);
    $('#input-postal-code').attr('disabled',false);
    $('#gender_picker').attr('disabled',false);
    $('#gender_picker').attr('disabled',false);
    $('#drinker_picker').attr('disabled',false);
    $('#smoking_picker').attr('disabled',false);
    $('#close_account_button').attr('hidden',false);
    $('#city_select').attr('disabled',false);
}

function hideUserProfile() {
    $('#user_profile').attr('hidden', true);
}

function setActive(elem) {
    let children = $(elem).children();
    console.log(children);
    if($(elem).hasClass('in-card-active')){
        $(elem).removeClass('in-card-active');
        $(elem).addClass('in-card');
        $(children[0]).removeClass('in-card-header-active');
        $(children[0]).addClass('in-card-header');
    }else{
        $(elem).removeClass('in-card');
        $(elem).addClass('in-card-active');
        $(children[0]).removeClass('in-card-header');
        $(children[0]).addClass('in-card-header-active');
    }


}

function saveInterest() {
    let inter = $('#interests_select');
    let childs = ($(inter).children());
    let newNodes = [], newNodesIndexes = [];

    for(let i = 0; i < $(childs[1]).children().length; i++){
        if($(($(childs[1]).children())[i]).hasClass('in-card-active')){
            let child = $(($(childs[1]).children())[i]).children();
            let txt  = $(child[0]).children()[0].innerText;
            newNodes.push(txt);
        }
    }

    const request = {};
    request.updates_users_interests = true;
    request.newNodes = newNodes;
    request.userId = $('#username-header').attr('user-id');

    $.ajax({
        method: "POST",
        url: "api.php",
        data: request,
        success: function (response) {
            let res = JSON.parse(response);
            Swal.fire(res.title, res.message, res.type);
            showProfile( $('#username-header').attr('user-name'),null,false);
        },
        failure: function (response) {
            console.log('failure:' + JSON.stringify(response));
        },
        error: function (response) {
            console.log('error:' + JSON.stringify(response));
        }
    });

}

function editInterests(action) {
    let inter = $('#interests_select');
    let childs = ($(inter).children());

    let ids = $('#user_profile_interest_save_button').attr('data-ints-ids');
    let names = $('#user_profile_interest_save_button').attr('data-ints-names');
    let namesSplit = names.split(",");


    if(action === 'open'){
        for(let i = 0; i < $(childs[1]).children().length; i++){
            let child = $(($(childs[1]).children())[i]).children();
            console.log(child);
            if(namesSplit.includes(($(child[0]).children()[0]).innerText)){
                $(($(childs[1]).children())[i]).removeClass('in-card');
                $(($(childs[1]).children())[i]).addClass('in-card-active');
                $(child[0]).removeClass('in-card-header');
                $(child[0]).addClass('in-card-header-active');
            }
        }
    }else if(action === 'close'){

        for(let i = 0; i < $(childs[1]).children().length; i++){
            let child = $(($(childs[1]).children())[i]).children();
            if($(($(childs[1]).children())[i]).hasClass('in-card-active')){
                $(($(childs[1]).children())[i]).removeClass('in-card-active');
                $(($(childs[1]).children())[i]).addClass('in-card');
                $(child[0]).removeClass('in-card-header-active');
                $(child[0]).addClass('in-card-header');
            }
        }
    }

    if(inter.attr('hidden')){
        inter.attr('hidden', false);
    }else{
        inter.attr('hidden',true);
    }
}

function saveCity(){

    const request = {};
    request.save_user_city = true;
    request.userId =  $('#username-header').attr('user-id');
    request.city = $('#city_select').val();

    $.ajax({
        method: "POST",
        url: "userManagmentApi.php",
        data: request,
        success: function (response) {
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

function getCitites(){
    const request = {};
    request.get_citites = true;
    $.ajax({
        method: "POST",
        url: "userManagmentApi.php",
        data: request,
        success: function (response) {
            let res = JSON.parse(response);
            let city = $('#city_select');
            let cities = $('#city_select_picker');
            console.log(response);
            for(let i = 0; i < res.length; i++){
                city.append(
                    '<option value="'+res[i]+'">'+res[i]+'</option>'
                );
                cities.append(
                    '<option value="'+res[i]+'">'+res[i]+'</option>'
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
