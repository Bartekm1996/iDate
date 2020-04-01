


function showChat() {
    $('#matcharea').prop('hidden', true);
    $('#frame').prop('hidden', false);
    $('#matching').prop('hidden', true);
}

function showSearch() {
    getAllProfiles();
    $('#matcharea').prop('hidden', false);
    $('#frame').prop('hidden', true);
    $('#matching').prop('hidden', false);
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



function getAllProfiles() {

    let filter = $('#searchFilter').val();

    if(filter.length === 0){
        $('#searchResults').prop('hidden', true);
        $('#matching').prop('hidden', false);
    }else {
        $('#searchResults').prop('hidden', false);
        $('#matching').prop('hidden', true);
    }

    var request = {};
    request.get_profiles_api = true;

    if(filter.length !== 0){
        request.filter = filter;
    }

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
                for(var i = 0; i < obj.length;i++) {
                    let test = '<div style="height: 100%; width: 100%;"><section class="container"' +
                        '<div class="row active-with-click">' +
                        '<div class="col-xs-12">' +
                        '<article class="material-card Red">' +
                        '<h2><span>'+obj[i].name+'</span><strong ><i class="fas fa-birthday-cake"></i>' +obj[i].age+ '<i class="fas fa-map-pin"></i>'  + (obj[i].location > 0 ?  obj[i].location : "Unknown" )   + '</strong></h2>' +
                        '<div class="mc-content">' +
                        '<div class="img-container">' +
                        '<img  id="person_image" src="https://scontent.fcgp2-1.fna.fbcdn.net/v/t1.0-9/64622894_10157744391564026_2243513133849116672_o.jpg?_nc_cat=103&_nc_ohc=3LqOQPKa3LAAQkhNs6IycYd_UEZkq70P1ODj1pCG2E1SdYBAURRB9C5Rg&_nc_ht=scontent.fcgp2-1.fna&oh=64f4a0143ea114c3583a7d0be3114df5&oe=5EAB9485">' +
                        '</div>' +
                        '<div class="mc-description">' +
                        '<div class="modal-body">' +
                        '<table id="popup_user_info">' +
                        '<tr><td></td><td>Name</td><td id="person_fullname">'+obj[i].name+'</td>' +
                        '<tr><td><td>Age :'+obj[i].age+'</td><td></td></td></tr>' +
                        '<tr><td><td>Gender : Male</td></td></tr>' +
                        '<tr><td><td>Gender : Male</td></td></tr>' +
                        '<tr><td><td>Gender : Male</td></td></tr>' +
                        '</table>' +
                        '</div>' +
                        '</div></div>' +
                        '<a class="mc-btn-action" onclick="epxand(this)">' +
                        '<i class="fa fa-bars"></i>' +
                        '</a>' +
                        '<div class="mc-footer">'+
                        '<button target=_parent type="button" class="btn btn-danger mt-2 match-user-button"><i class="fas fa-user-plus"></i> Match User</button>'+
                        '<button target=_parent type="button" class="ml-3 btn btn-success mt-2 message-user-button"><i class="fas fa-comments"></i> Messages ' + obj[i].name +'</button>'+
                        '</article></div></div></section></div>';

                   // let test = "<div onclick='openUserProfile("+ obj[i].id + ")'  class='grid-item'><img class='popimg' src='https://placekitten.com/100/100'/><h4>" + obj[i].name + "</h4></div>\n";
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

function getUserMatches() {

    var request = {};
    request.get_user_matches_api = true;
    request.user_id = userID;
    $.ajax({
        method: "POST",
        url: "api.php",
        data: request,
        success: function (response) {
            console.log(response);
            let obj = JSON.parse(response);
            //TODO: where are the images going to be stored
            if(obj != null) {
                for(var i = 0; i < obj.length;i++) {

                    //let test = "<div onclick='openUserProfile("+ obj[i].id + ")'  class='grid-item'><img class='popimg' src='https://placekitten.com/100/100'/><h4>" + obj[i].name + "</h4></div>\n";
                    document.getElementById("mymatches").innerHTML += test;
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
    // var request = {};
    // request.create_match_api = true;
    // request.match_id = users[curPos].id;
    // sendDataTest(request, "api.php");
    // nextUser();
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

    getUserMatches();
    showSearch();

});