
function showChat() {
    $('#matcharea').prop('hidden', true);
    $('#chatarea').prop('hidden', false);
}

function showSearch() {
    $('#matcharea').prop('hidden', false);
    $('#chatarea').prop('hidden', true);
}
function  openUserProfile(event) {
    $('#profileModal').show();
}

function  closeUserProfile() {
    $('#profileModal').hide();
}

function getAllProfiles() {

    let filter = $('#searchFilter').val();


    console.log(filter);

    if(filter.length == 0) {
        document.getElementById("searchResults").innerHTML = '<h4>No Results Found</h4>';
        return;
    }

    var request = {};
    request.get_profiles_api = true;
    request.filter = filter;
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
                    let test = "<div onclick='openUserProfile("+ obj[i].id + ")'  class='grid-item'><img class='popimg' src='https://placekitten.com/100/100'/><h4>" + obj[i].name + "</h4></div>\n";
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

function getUserMatches() {
    /*
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
                    let test = "<div onclick='openUserProfile("+ obj[i].id + ")'  class='grid-item'><img class='popimg' src='https://placekitten.com/100/100'/><h4>" + obj[i].name + "</h4></div>\n";
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

     */
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