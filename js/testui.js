


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
                    if(parseInt(obj[i].registered) === 0){
                        un_reg++;
                    }else if(parseInt(obj[i].blocked) === 1){
                        blocked++;
                    }

                }

                $('#all_users').text(obj.length);
                $('#unverified_users').text(0);
                $('#blocked_users').text(0);


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
    $('#searchFilter').attr('data-matches', false);
    loadMatches();
    getAllProfiles();

    if($('#searchFilter').val().length > 0){
        $('#searchFilter').val("");
        $('#searchResults').prop('hidden', true);
    }else {
        if($('#matching').attr('hidden')){
            $('#searchResults').prop('hidden', false);
        }
    }

    hideChat();
    hideUserManagment();
    hideUserProfile();
    hideTickets();
    $('#matcharea').prop('hidden', false);
    $('#matching').prop('hidden', false);
}

function showUerMatches(user_id) {
    $('#searchFilter').attr('data-matches', true);
    $('#my_matches_place_holder').attr('hidden', false);
    $('#searchResults').attr('hidden',false);
    hideUserManagment();
    hideMatching();
    hideUserProfile();
    hideTickets();
    hideChat();
    getUserMatches(user_id);
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
                        '<a href="#" class="btn btn-sm btn-info mr-4" onclick="openReportPane(\''+res.username+'\')">Report</a>'+
                        '<a href="#" onclick="showProfile(\''+res.id+'\',\''+$('#username-header').attr('user-name')+'\',true)" class="btn btn-sm btn-default float-right">Profile</a>'+
                        '</div>'+
                        '</div>'+
                        '<div class="card-body pt-0 pt-md-4">'+
                        '<div class="row">'+
                        '<div class="col">'+
                        '<div class="card-profile-stats d-flex justify-content-center mt-md-5">'+
                        '<div>'+
                        '<span class="heading">'+res.smoker+'</span>'+
                        '<span class="description">Smoker</span>'+
                        '</div>'+
                        '<div>'+
                        '<span class="heading">'+res.drinker+'</span>'+
                        '<span class="description">Drinker</span>'+
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
                    // let test = "<div onclick='openUserProfile("+ obj[i].id + ")'  class='grid-item'><img class='popimg' src='https://placekitten.com/100/100'/><h4>" + obj[i].name + "</h4></div>\n";
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
                    /*
                let test = '<div >'+
                 '<div class="row">' +
                 '<div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">' +
                 '<div class="card card-profile shadow">'+
                 '<div class="row justify-content-center">'+
                 '<div class="col-lg-3 order-lg-2">'+
                 '<div class="card-profile-image">'+
                 '<a href="#">'+
                 '<img src="../images/icons/userIcon.png" class="rounded-circle">'+
                 '</a>'+
                 '</div>'+
                 '</div>'+
                 '</div>'+
                 '<div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">'+
                 '<div class="d-flex justify-content-between">'+
                 '<a href="#" class="btn btn-sm btn-info mr-4">Connect</a>'+
                 '<a href="#" class="btn btn-sm btn-default float-right">Message</a>'+
                 '</div>'+
                 '</div>'+
                 '<div class="card-body pt-0 pt-md-4">'+
                 '<div class="row">'+
                 '<div class="col">'+
                 '<div class="card-profile-stats d-flex justify-content-center mt-md-5">'+
                 '<div>'+
                 '<span class="heading">22</span>'+
                 '<span class="description">Matches</span>'+
                 '</div>'+
                 '<div>'+
                 '<span class="heading">10</span>'+
                 '<span class="description">Photos</span>'+
                 '</div>'+
                 '<div>'+
                 '<span class="heading">89</span>'+
                 '<span class="description">Connections</span>'+
                 '</div>'+
                 '</div>'+
                 '</div>'+
                 '</div>'+
                 '<div class="text-center">'+
                 '<h3>'+obj[i].name+'<span class="font-weight-light">, '+obj[i].age+'</span> </h3>'+
                 '<div class="h5 font-weight-300">'+
                 '<i class="ni location_pin mr-2"></i>City, Country'+
                 '</div>'+
                 '<div class="h5 mt-4">'+
                 '</div>'+
                 '<div>'+
                 '</div>'+
                 '<hr class="my-4">'+
                 '<p>Ryan — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes, performs and records all of his own music.</p>'+
                 '</div>'+
                 '</div>'+
                 '</div>'+
                 '</div>';

                */
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
                 '<a href="#" class="btn btn-sm btn-info mr-4" onclick="connect(\''+ress.id+'\',\''+$('#username-header').attr('user-id') + '\',\'' + ress.photoId + '\',\'' + (ress.name + ' ' + ress.lastname) + '\',\'' + $('#username-header').attr('user-name') + '\',\'' + false + '\',\'' + true + '\')">Connect</a>'+
                 '<a href="#" onclick="showProfile(\''+ress.id+'\',\''+$('#username-header').attr('user-name')+'\',false)" class="btn btn-sm btn-default float-right">Profile</a>'+
                 '</div>'+
                 '</div>'+
                 '<div class="card-body pt-0 pt-md-4">'+
                 '<div class="row">'+
                 '<div class="col">'+
                 '<div class="card-profile-stats d-flex justify-content-center mt-md-5">'+
                 '<div>'+
                 '<span class="heading">'+ress.smoker+'</span>'+
                 '<span class="description">Smoker</span>'+
                 '</div>'+
                 '<div>'+
                 '<span class="heading">'+ress.drinker+'</span>'+
                 '<span class="description">Drinker</span>'+
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


                /*

                        '<div class="row active-with-click">' +
                        '<div class="col-xs-12">' +
                        '<article class="material-card Red">' +
                        '<h2><span >'+obj[i].name+'</span><strong><i class="fas fa-birthday-cake"><i class="ml-3"></i>' +obj[i].age+ '</i><i class="fas fa-map-pin ml-3"><i class="ml-3">'  + (obj[i].location > 0 ?  obj[i].location : "Unknown" )   + '</i></i></strong></h2>'+
                        '<div class="mc-content">' +
                        '<div class="img-container">' +
                        '<img  id="person_image" style="width: 100%; height: 100%;" src="https://source.unsplash.com/random">' +
                        '</div>' +
                        '<div class="mc-description">' +
                        '<div class="modal-body">' +
                        '<table id="popup_user_info">' +
                        '<tr><td></td><td>Name</td><td id="person_fullname">'+obj[i].name+'</td>' +
                        '<tr><td><td>Age :'+obj[i].age+'</td><td></td></td></tr>' +
                        '<tr><td><td>Gender : '+obj[i].gender+'</td></td></tr>' +
                        '</table>' +
                        '</div>' +
                        '</div></div>' +
                        '<a class="mc-btn-action" onclick="epxand(this)">' +
                        '<i class="fa fa-bars"></i>' +
                        '</a>' +
                        '<div class="mc-footer">'+
                        '<button target=_parent type="button" class="btn btn-danger mt-2 match-user-button"><i class="fas fa-user-plus"></i></button>'+
                        '<button target=_parent type="button" class="ml-3 btn btn-success mt-2 message-user-button"><i class="fas fa-comments"></i></button>'+
                        '</article></div></div></div>';

                   // let test = "<div onclick='openUserProfile("+ obj[i].id + ")'  class='grid-item'><img class='popimg' src='https://placekitten.com/100/100'/><h4>" + obj[i].name + "</h4></div>\n";
                    document.getElementById("searchResults").innerHTML += test;

                 */
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

/*
<section class="container">

    <div class="row active-with-click">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <article class="material-card Red">
                <h2>
                    <span>Shahnur Alam</span>
                    <strong>
                        <i class="fa fa-fw fa-magic"></i>
                        Qui Maleficus
                    </strong>
                </h2>
                <div class="mc-content">
                    <div class="img-container">
                        <img class="img-responsive" src="https://scontent.fcgp2-1.fna.fbcdn.net/v/t1.0-9/64622894_10157744391564026_2243513133849116672_o.jpg?_nc_cat=103&_nc_ohc=3LqOQPKa3LAAQkhNs6IycYd_UEZkq70P1ODj1pCG2E1SdYBAURRB9C5Rg&_nc_ht=scontent.fcgp2-1.fna&oh=64f4a0143ea114c3583a7d0be3114df5&oe=5EAB9485">
                    </div>
                    <div class="mc-description">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ...
                    </div>
                </div>
                <a class="mc-btn-action">
                    <i class="fa fa-bars"></i>
                </a>

            </article>
        </div>

    </div>
</section>

 */

function connect(user_id, logged_in_id, src, name, username, matchingPane, searchpane) {


    console.log(user_id + " " + logged_in_id + " " + src + " " + name + " " + username + " " + matchingPane + " " + searchpane);

    const request = {};
    request.create_match_api = true;
    request.id1 = user_id;
    request.id2 = logged_in_id;
    $.ajax({
        method: "POST",
        url: "api.php",
        data: request,
        success: function (response) {
            let les = JSON.parse(response);
            console.log(response);
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
    let age = $('#ageSlider').val();
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


    console.log("Drinker " + drinker + " smoker " + smoker + " age " + age);

    request.filter_get_users = true;
    request.userId = $('#username-header').attr('user-id');

    if($('#age_check_box').val() === true){
        request.age = age;
    }

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
        '<a href="#" class="btn btn-sm btn-info mr-4" onclick="connect(\'' + ress.id + '\',\'' + $('#username-header').attr('user-id') + '\',\'' + ress.photoId + '\',\'' + (ress.firstName + ' ' + ress.lastName) + '\',\'' + $('#username-header').attr('user-name') + '\',\'' + false + '\',\'' + true + '\')">Connect</a>' +
        '<a href="#" onclick="showProfile(\'' + ress.id + '\',\'' + $('#username-header').attr('user-name') + '\',false)" class="btn btn-sm btn-default float-right">Profile</a>' +
        '</div>' +
        '</div>' +
        '<div class="card-body pt-0 pt-md-4">' +
        '<div class="row">' +
        '<div class="col">' +
        '<div class="card-profile-stats d-flex justify-content-center mt-md-5">' +
        '<div>' +
        '<span class="heading">' + ress.smoker + '</span>' +
        '<span class="description">Smoker</span>' +
        '</div>' +
        '<div>' +
        '<span class="heading">' + ress.dinker + '</span>' +
        '<span class="description">Drinker</span>' +
        '</div>' +
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