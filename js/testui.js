


function showMatching() {
    loadMatches();
    getAllProfiles();
    hideChat();
    hideUserManagment();
    hideUserProfile();
    hideTickets();
    hideMatchArea();
    $('#matching').attr('hidden', false);
}

function hideMatching() {
    epxand ($('#expandable'));
    $('#filter').attr('hidden', true);
    $('#matching').attr('hidden', true);
}

function showMatchArea() {
    hideChat();
    hideUserManagment();
    hideMatching();
    hideUserProfile();
    hideTickets();
    $('#matcharea').attr('hidden', false);
}

function hideMatchArea() {
    $('#my_matches_place_holder').attr('hidden',true);
    $('#matcharea').prop('hidden', true);
}

function showUserManagment(verified) {
    hideChat();
    hideMatchArea();
    hideMatching();
    hideUserProfile();
    hideTickets();
    $('.filter').attr('hidden', true);
    $('#usermng').attr('hidden', false);
    getUserData(verified);
}

function hideUserManagment() {
    $('#usermng').attr('hidden', true);
}

function hideTickets() {
    $('#main_cont').attr('hidden',true);
}

function showTickets(status) {
    hideMatching();
    hideMatchArea();
    hideChat();
    hideUserManagment();
    hideUserProfile();
    $('.filter').attr('hidden', true);
    $('#main_cont').attr('hidden',false);
    getAllTickets(status);
}




function fillMembersNumbers(){

    const request = {};
    request.get_all_users = true;



    $.ajax({
        method: "POST",
        url: "userManagmentApi.php",
        data: request,
        success: function (response) {
            console.log(response);

            // preserve newlines, etc - use valid JSON

            let obj = JSON.parse(response);

            let un_reg = 0, blocked = 0;


                for(let i = 0; i < obj.length; i++){
                    let res = JSON.parse(obj[i]);
                    if(parseInt(res.registered) === 0){
                        un_reg++;
                    }
                    if(parseInt(res.blocked) === 1){
                        blocked++;
                    }

                }

                $('#all_users').text(obj.length);
                $('#unverified_users').text(un_reg);
                $('#blocked_users').text(blocked);


                if(un_reg > 0){
                    $('#unverified_users').removeClass('label-success');
                    $('#unverified_users').addClass('label-warning');
                    $('#unverified_users').text(un_reg);
                }
                if(blocked > 0){
                    $('#blocked_users').removeClass('label-success');
                    $('#blocked_users').addClass('label-danger');
                    $('#blocked_users').text(blocked);
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

function fillTicketsNumbers(){

    var request = {};
    request.get_all_tickets = true;
    let unqiues = [];
    let csr = 0;


    $.ajax({
        method: "POST",
        url: "userManagmentApi.php",
        data: request,
        success: function (response) {
            console.log(response);
            let obj = JSON.parse(response);
            let counter = 0, archived = 0;

            for(let i = 0; i < obj.length; i++){
                if(!unqiues.includes(obj[i].status)){
                    unqiues.push(obj[i].status);
                }

                if(parseInt(obj[i].archived) === 1){
                    archived++;
                }
            }

            $('#archived_tickets').text(counter);
            $('#unresolved_tickets').text(0);
            $('#closed_tickets').text(0);

            for(let i = 0; i < unqiues.length; i++){
                for(let j = 0; j < obj.length; j++){
                    if(unqiues[i] === obj[j].status && csr !== parseInt(obj[j].number)){
                        counter++;
                    }
                    csr = parseInt(obj[j].number);
                }

                console.log(unqiues[i] + " " + counter);
                switch (unqiues[i]) {
                    case 'Unresolved':{
                        addTicketLabel('#unresolved_tickets', counter)
                        $('#unresolved_tickets').text(counter);
                        break;
                    }
                    case 'Opened':{
                        addTicketLabel('#opened_tickets', counter)
                        $('#opened_tickets').text(counter);
                        break;
                    }
                    case 'Closed':{
                        $('#closed_tickets').text(counter);
                        break;
                    }
                }
                counter = 0;
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

function addTicketLabel(node, counter){
    if(counter > 0 && counter < 10){
        $(node).addClass('label-success');
    }else if(counter > 10 && counter < 50){
        $(node).addClass('label-warning');
    }else{
        $(node).addClass('label-danger');
    }
}


function showSearch() {
    loadMatches();
    getAllProfiles();
    if($('#upro_img').attr('details') === 'true') {

        $('#searchFilter').attr('data-matches', false);


        if ($('#searchFilter').val().length > 0) {
            $('#searchFilter').val("");
            $('#searchResults').prop('hidden', true);
        } else {
            if ($('#matching').attr('hidden')) {
                $('#searchResults').prop('hidden', false);
            }
        }

        hideChat();
        hideUserManagment();
        hideUserProfile();
        hideTickets();
        $('#matcharea').prop('hidden', false);
        $('#matching').prop('hidden', false);
    }else {
        Swal.fire({
            title: "Fill In Profile Information",
            text: "Please Fill In Your Profile Information before accessing other services",
            icon: "warning"
        });
    }

}


function showUerMatches(user_id) {
    console.log("True " + $('#upro_img').attr('details'));
    if($('#upro_img').attr('details') === 'true') {
        $('#searchFilter').attr('data-matches', true);
        $('#my_matches_place_holder').attr('hidden', false);
        $('#searchResults').attr('hidden', false);
        hideUserManagment();
        hideMatching();
        hideUserProfile();
        hideTickets();
        hideChat();
        getUserMatches(user_id);
    }else {
        Swal.fire({
            title: "Fill In Profile Information",
            text:"Please Fill In Your Profile Information before accessing other services",
            icon: "warning"
        });
    }
}

function  openUserProfile(event) {
    $('#profileModal').show();
}

function  closeUserProfile() {
    $('#profileModal').hide();
}


function epxand (elem) {
    let card = $(elem).parent('.material-card');
    let icon = $(elem).children('i');
    icon.addClass('fa-spin-fast');

    if (card.hasClass('mc-active')) {
        card.removeClass('mc-active');

        window.setTimeout(function () {
            icon
                .removeClass('fa-arrow-left')
                .removeClass('fa-spin-fast')
                .addClass('fa-bars');

        }, 800);
    } else {
        card.addClass('mc-active');

        window.setTimeout(function () {
            icon
                .removeClass('fa-bars')
                .removeClass('fa-spin-fast')
                .addClass('fa-arrow-left');

        }, 800);
    }
}


function getUserMatches(user_id) {
    $('#matcharea').attr('hidden', false);
    $('#searchResults').empty();

    const request = {};
    request.get_user_matches_api = true;
    request.user_id = user_id;
    $.ajax({
        method: "POST",
        url: "api.php",
        data: request,
        success: function (response) {
            console.log(response);
            let obj = JSON.parse(response);
            if(obj != null) {
                if(obj.length === 0){
                    $('#my_matches_place_holder').attr('hidden', false);
                }else{
                    $('#my_matches_place_holder').attr('hidden', true);
                }
                for(let i = 0; i < obj.length; i++) {

                    let res = JSON.parse(obj[i]);

                    console.log(res);
                    let defImage = (res.photoId === null ? (res.gender === 'Male' ? 'images/male.png' : 'images/female.png') : res.photoId);


                    let test = '<div style="width: 300px; height: 100%;">'+
                        '<div class="image-flip" ontouchstart="this.classList.toggle(\'hover\');">' +
                        '<div class="mainflip">'+
                        '<div class="frontside">'+
                        '<div class="card card-profile shadow">'+
                        '<div class="row justify-content-center">'+
                        '<div class="col-lg-3 order-lg-2">'+
                        '<div class="card-profile-image">'+
                        '<img src="' + defImage +'" style="width: 118px; height: 118px;" class="rounded-circle avatar">'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '<div class="text-center pt-8 pt-md-4 pb-0 pb-md-4">'+
                        '<div class="d-flex justify-content-between">'+
                        '<a href="#" class="btn btn-sm btn-info mr-4 ml-2" onclick="openReportPane(\''+res.username+'\')">Report</a>'+
                        '<a href="#" onclick="showProfile(\''+res.id+'\',\''+$('#username-header').attr('user-name')+'\',true)" class="btn btn-sm btn-default float-right mr-2">Profile</a>'+
                        '</div>'+
                        '</div>'+
                        '<div class="card-body pt-0 pt-md-4">'+
                        '<div class="row">'+
                        '<div class="col">'+
                        '<div class="card-profile-stats d-flex justify-content-center mt-md-5">'+
                        '<div>'+
                        '<span class="heading"><strong>'+res.smoker+'</strong></span>'+
                        '<span class="description" style="font-size: 12px;"><strong><i class="fas fa-smoking mr-2"></i>Smoker</strong></span>'+
                        '</div>'+
                        '<div>'+
                        '<span class="heading"><strong>'+res.drinker+'</strong></span>'+
                        '<span class="description" style="font-size: 12px;"><strong><i class="fas fa-cocktail mr-2"></i>Drinker</strong></span>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '<div class="text-center">'+
                        '<h3>'+res.name+'<span class="font-weight-light">, '+res.age+'</span> </h3>'+
                        '<div class="h5 font-weight-300">'+
                        '<i class="ni location_pin mr-2"></i>'+(res.town === null ? "Unknown" : res.town) +', Ireland'+
                        '</div>'+
                        '<div class="h5 mt-4">'+
                        '</div>'+
                        '<div>'+
                        '</div>'+
                        '<hr class="my-4">'+
                        '<p>'+res.desc+'</p>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '</div>';

                    $('#searchResults').append(test);
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


function getAllProfiles(smoker, drinker, age) {

    let filter = $('#searchFilter').val();

    if(filter.length === 0){
        $('#searchResults').prop('hidden', true);
        $('#matching').prop('hidden', false);
    }else {
        $('#my_matches_place_holde').attr('hidden', true);
        $('#searchResults').prop('hidden', false);
        $('#matching').prop('hidden', true);
    }

    const request = {};
    request.user_id =  $('#username-header').attr('user-id');


    if($('#searchFilter').attr('data-matches') === true){
        request.get_user_matches_api = true;
    }else{
        request.get_profiles_api = true;
    }

    if(smoker !== null && drinker && null && age !== null){
        request.smoker = smoker;
        request.drinker = drinker;
        request.age = age;
    }

    if(filter.length !== 0){
        request.filter = filter;
    }

    console.log("Filter " + filter);

    $.ajax({
        method: "POST",
        url: "api.php",
        data: request,
        success: function (response) {


            console.log(response);
            let obj = JSON.parse(response);
            document.getElementById("searchResults").innerHTML = '';
            //TODO: where are the images going to be stored
            if(obj != null) {
                for(let i = 0; i < obj.length; i++) {

                    let ress = JSON.parse(obj[i]);

                let test =
                 '<div style="width: 300px; height: 100%;">'+
                 '<div class="image-flip" >' +
                 '<div >'+
                 '<div class="frontside">'+
                 '<div class="card card-profile shadow">'+
                 '<div class="row justify-content-center">'+
                 '<div class="col-lg-3 order-lg-2">'+
                 '<div class="card-profile-image">'+
                 '<img src="'+(ress.photoId === null ? (ress.gender === "Male" ? "images/male.png" : "images/female.png") : ress.photoId)+'" style="width: 118px; height: 118px;" class="rounded-circle avatar">'+
                 '</div>'+
                 '</div>'+
                 '</div>'+
                 '<div class="text-center pt-8 pt-md-4 pb-0 pb-md-4">'+
                 '<div class="d-flex justify-content-between">'+
                 '<a href="#" class="btn btn-sm btn-info mr-4 ml-2" onclick="connect(\''+ress.id+'\',\''+$('#username-header').attr('user-id') + '\',\'' + ress.photoId + '\',\'' + (ress.name + ' ' + ress.lastname) + '\',\'' + $('#username-header').attr('user-name') + '\',\'' + false + '\',\'' + true + '\')">Connect</a>'+
                 '<a href="#" onclick="showProfile(\''+ress.id+'\',\''+$('#username-header').attr('user-name')+'\',false)" class="btn btn-sm btn-default float-right mr-2">Profile</a>'+
                 '</div>'+
                 '</div>'+
                 '<div class="card-body pt-0 pt-md-4">'+
                 '<div class="row">'+
                 '<div class="col">'+
                 '<div class="card-profile-stats d-flex justify-content-center mt-md-5">'+
                 '<div>'+
                 '<span class="heading"><strong>'+ress.smoker+'</strong></span>'+
                 '<span class="description" style="font-size: 12px;"><strong><i class="fas fa-smoking mr-2"></i>Smoker</strong></span>'+
                 '</div>'+
                 '<div>'+
                 '<span class="heading"><strong>'+ress.drinker+'</strong></span>'+
                 '<span class="description" style="font-size: 12px;"><strong><i class="fas fa-cocktail mr-2"></i>Drinker</strong></span>'+
                 '</div>'+
                 '</div>'+
                 '</div>'+
                 '</div>'+
                 '<div class="text-center text-desc mainflip" ontouchstart="this.classList.toggle(\'hover\');">'+
                 '<h3>'+ress.name+'<span class="font-weight-light">, '+ress.age+'</span> </h3>'+
                 '<div class="h5 font-weight-300">'+
                 '<i class="ni location_pin mr-2"></i>'+(ress.town === null ? "Unknown" : ress.town)+', Ireland'+
                 '</div>'+
                 '<div class="h5 mt-4">'+
                 '</div>'+
                 '<div>'+
                 '</div>'+
                 '<hr class="my-4">'+
                 '<p>'+ress.desc+'</p>'+
                 '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>';

                    document.getElementById("searchResults").innerHTML += test;

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


function connect(user_id, logged_in_id, src, name, username, matchingPane, searchpane) {

    const request = {};
    request.create_match_api = true;
    request.id1 = user_id;
    request.id2 = logged_in_id;
    $.ajax({
        method: "POST",
        url: "api.php",
        data: request,
        success: function (response) {
            console.log(response);

            let les = JSON.parse(response);
            switch (les.statusCode) {
                case 1:{
                    $('#card_message_button').attr('hidden', false);
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    })

                    if(matchingPane === true){
                        nextMatch(null);
                    }

                    if(searchpane === true){
                        getAllProfiles();
                    }

                    swalWithBootstrapButtons.fire({
                        title: 'You just matched with ' + name,
                        html: '<img src="'+src+'" alt="" style="width: 150px; height: 150px; border-radius: 75px; border: 2px solid gray;" class="avatar img-thumbnail">',
                        showCancelButton: true,
                        confirmButtonText: 'View Profile',
                        cancelButtonText: 'Message',
                        reverseButtons: true,
                        width: 400,
                        height: 400,
                        backdrop: `
                            rgba(0,0,123,0.4)
                            url("https://media.giphy.com/media/d3MK2JGObFW0NPSE/giphy.gif")
                            center
                            no-repeat
                          `
                    }).then((result) => {
                        if (result.value) {
                            showProfile(user_id,username, true);
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            showUserChar(username);
                        }
                    })
                    break;
                }
                case 2:{
                    Swal.fire(les.title, les.message, les.type);
                    break;
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


function sendDataTest(request, urll) {
    console.log(request);
    $.ajax({
        method: "POST",
        url: urll,
        data: request,
        success: function (response) {
            console.log(response);
        },
        failure: function (response) {
            console.log('failure:' + JSON.stringify(response));
        },
        error: function (response) {
            console.log('error:' + JSON.stringify(response));
        }
    });
}


function match() {
    var request = {};
    request.create_match_api = true;
    request.match_id = users[curPos].id;
    sendDataTest(request, "api.php");
    nextUser();
}

function unlink() {

}

function nomatch() {
    nextUser();
}

function nextUser() {
    curPos++;
    if(curPos >= users.length) curPos = 0;
    $('#uname').text(users[curPos].name);
    $('#uage').text(users[curPos].age);
}


function nextImg() {
    curPos++;
    if(curPos >= testImgs.length) curPos = 0;
    $('#imgP').attr("src",testImgs[curPos].imgurl);
}

function prevImg() {
    curPos--;
    if(curPos < 0) curPos = testImgs.length -1;
    $('#imgP').attr("src",testImgs[curPos].imgurl);
}

$('#profileModal').on('shown.bs.modal', function () {
    $('#profileModal').trigger('focus')
})

$(document).ready(function() {

    $(".btn-pref .btn").click(function () {
        $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
        // $(".tab").addClass("active"); // instead of this do the below
        $(this).removeClass("btn-default").addClass("btn-primary");
    });



    $('#myTab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })


});

function loadMyProfile() {

    const request = {};
    request.get_user_profile_api = true;
    request.userId = $('#username-header').attr('user-id');
    console.log('request:loadMyProfile->', request);
    $.ajax({
        method: "POST",
        url: "api.php",
        data: request,
        success: function (response) {
            console.log('loadMyProfile:response->', response);
            let res = JSON.parse(response);

            let defImage = res.photoId;

            if(defImage == null || defImage.length == 0) {
                defImage = res.gender == 'Male' ? 'images/male.png' : 'images/female.png';
            }

            document.getElementById("profilePicture").src = defImage;
        },
        failure: function (response) {
            console.log('failure:' + JSON.stringify(response));
        },
        error: function (response) {
            console.log('error:' + JSON.stringify(response));
        }
    });

}

function openReportPane(name) {
    if($('#report_pane').attr('hidden')){
        $('#report_pane').attr('hidden', false);
    }else{
        $('#report_pane').attr('hidden', true);
    }

    $('#user_report_username').val(name);
    $('#user_report_name').val($('#username-header').attr('user-name'));
    $('#user_report_email').val( $('#username-header').attr('user_email'));
}

function profileFilterButton() {


    document.getElementById("searchResults").innerHTML = '';

    const request = {};

    let input = $('#searchFilter').val();

    let smoker = $('#smoker_select_picker').val();
    let drinker = $('#drinker_select_picker').val();
    let interest = $('#interest_box').children();
    let city = $('#city_select_picker').val();
    let ints = [];



    if(drinker !== null && drinker.length > 0){
        request.drinker = drinker;
    }
    if(smoker !== null && smoker.length > 0){
        request.smoker = smoker;
    }
    if(city !== null && city.length > 0){
        request.city = city;
    }
    if(input !== null && input.length > 0){
        request.input = input;
    }



    request.filter_get_users = true;
    request.userId = $('#username-header').attr('user-id');
    request.minValue = slider.getValue().minValue;
    request.maxValue = slider.getValue().maxValue;
    request.gender = $('#upro_img').attr('data-gender');
    request.seeking = $('#upro_img').attr('data-seeking');

    for(let i = 0; i < interest.length; i++){
        let childs = $(interest[i]).children();
        for(let j = 0; j < childs.length; j++){
            if($(childs[j]).hasClass('active')){
                ints.push($(childs[j]).text());
            }
        }
    }

    if(ints.length > 0){
        request.interests = true;
    }

    let names = [];


    $.ajax({
        method: "POST",
        url: "api.php",
        data: request,
        success: function (response) {
            console.log(response);
            if(response.length > 0) {
                $('#my_matches_place_holder').attr('hidden', true);
                $('#searchResults').prop('hidden', false);
                $('#matching').prop('hidden', true);
                let res = JSON.parse(response);
                if (ints.length > 0) {
                    let name = "";
                    let obj = [];
                    for (let i = 0; i < res.length; i++) {
                        let ress = JSON.parse(res[i]);
                        name = ress.firstName;
                        if (ints.includes(ress.interest)) {
                            if (!names.includes(ress.firstName)) {
                                names.push(ress.firstName);
                                obj.push(ress);
                            }
                        }
                    }
                    for (let i = 0; i < obj.length; i++) {
                        append(obj[i]);
                    }
                }else{
                    for (let i = 0; i < res.length; i++) {
                        let ress = JSON.parse(res[i]);
                        append(ress);
                    }
                }

            }else {
                $('#my_matches_place_holder').attr('hidden', false);
                $('#my_matches_place_holder').text("No Results");
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

function append(ress) {
    let test =
        '<div style="width: 300px; height: 100%;">' +
        '<div class="image-flip" >' +
        '<div >' +
        '<div class="frontside">' +
        '<div class="card card-profile shadow">' +
        '<div class="row justify-content-center">' +
        '<div class="col-lg-3 order-lg-2">' +
        '<div class="card-profile-image">' +
        '<img src="' + (ress.photoId === null ? (ress.gender === "Male" ? "images/male.png" : "images/female.png") : ress.photoId) + '" style="width: 118px; height: 118px;" class="rounded-circle avatar">' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="text-center pt-8 pt-md-4 pb-0 pb-md-4">' +
        '<div class="d-flex justify-content-between">' +
        '<a href="#" class="btn btn-sm btn-info mr-4 ml-2" onclick="connect(\'' + ress.id + '\',\'' + $('#username-header').attr('user-id') + '\',\'' + ress.photoId + '\',\'' + (ress.firstName + ' ' + ress.lastName) + '\',\'' + $('#username-header').attr('user-name') + '\',\'' + false + '\',\'' + true + '\')">Connect</a>' +
        '<a href="#" onclick="showProfile(\'' + ress.id + '\',\'' + $('#username-header').attr('user-name') + '\',false)" class="btn btn-sm btn-default float-right mr-2">Profile</a>' +
        '</div>' +
        '</div>' +
        '<div class="card-body pt-0 pt-md-4">' +
        '<div class="row">' +
        '<div class="col">' +
        '<div class="card-profile-stats d-flex justify-content-center mt-md-5">' +
        '<div>'+
        '<span class="heading"><strong>'+ress.smoker+'</strong></span>'+
        '<span class="description" style="font-size: 12px;"><strong><i class="fas fa-smoking mr-2"></i>Smoker</strong></span>'+
        '</div>'+
        '<div>'+
        '<span class="heading"><strong>'+ress.dinker+'</strong></span>'+
        '<span class="description" style="font-size: 12px;"><strong><i class="fas fa-cocktail mr-2"></i>Drinker</strong></span>'+
        '</div>'+
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="text-center text-desc mainflip" ontouchstart="this.classList.toggle(\'hover\');">' +
        '<h3>' + (ress.firstName + " " + ress.lastName) + '<span class="font-weight-light">, ' + ress.age + '</span> </h3>' +
        '<div class="h5 font-weight-300">' +
        '<i class="ni location_pin mr-2"></i>' + (ress.town === null ? "Unknown" : ress.town) + ', Ireland' +
        '</div>' +
        '<div class="h5 mt-4">' +
        '</div>' +
        '<div>' +
        '</div>' +
        '<hr class="my-4">' +
        '<p>' + ress.descripion + '</p>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';

    $('#searchResults').append(test);
}