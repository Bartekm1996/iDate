var testImgs = [];
var myMatches = [];
var searchUsers = [];

function showChat() {
    $('#matcharea').prop('hidden', true);
    $('#chatarea').prop('hidden', false);
}

function showSearch() {
    $('#searchFilter').val('');
    searchUsers = [];
    document.getElementById("searchResults").innerHTML = '';
    $('#matcharea').prop('hidden', false);
    $('#chatarea').prop('hidden', true);
}

function  openSearchProfile(event) {
    var res = getSearchData(event);
    clearProfileModal();
    hideModalButtons();
    if(res != null) {
        console.log(res);

        var genImage = res.gender == 'Male' ? 'images/male.png' : 'images/female.png';
        var defImage = res.photoId.length == 0 ? genImage: res.photoId;
        $('#person_image').attr('src', defImage);

        document.getElementById('profile_modal_title').innerHTML = "<b>Profile Information</b>";
        $('#person_age').text(res.age);
        $('#person_gender').text(res.gender);
        $('#person_location').text(res.location.length == 0 ? 'N/A': res.location);
        $('#person_is_smoker').text(res.smoker);
        $('#person_is_drinker').text(res.drinker);
        $('#person_fullname').text(res.name + ' ' + res.lastname);
        $('#btnModalMatch').show();
        $('#profileModal').show();
    }

}

function  openUserProfile(event) {
    var res = getMatchData(event);
    clearProfileModal();
    hideModalButtons();

    if(res != null) {
        console.log(res);

        var genImage = res.gender == 'Male' ? 'images/male.png' : 'images/female.png';
        var defImage = res.photoId.length == 0 ? genImage: res.photoId;
        $('#person_image').attr('src', defImage);

        document.getElementById('profile_modal_title').innerHTML = "<b>Connection Date:</b> " + res.connectionDate;

        $('#person_age').text(res.age);
        $('#person_gender').text(res.gender);
        $('#person_location').text(res.location.length == 0 ? 'N/A': res.location);
        $('#person_is_smoker').text(res.smoker);
        $('#person_is_drinker').text(res.drinker);
        $('#person_fullname').text(res.name + ' ' + res.lastname);
        $('#btnModalChat').show();
        $('#btnModalUnMatch').show();
        $('#profileModal').show();
    }

}

function clearProfileModal() {
    $('#conndate').text('');
    $('#person_fullname').text('');
    $('#person_age').text('');
    $('#person_gender').text('');
    $('#person_location').text('');
    $('#person_is_smoker').text('');
    $('#person_is_drinker').text('');
}


function getMatchData(uid) {
    var res;

    if(myMatches.length > 0) {
        for(let i = 0; i < myMatches.length; i++) {
            if(myMatches[i].id == uid) {
                res = myMatches[i];
                break;
            }
        }
    }

    return res;
}

function getSearchData(uid) {
    var res;

    if(searchUsers.length > 0) {
        for(let i = 0; i < searchUsers.length; i++) {
            if(searchUsers[i].id == uid) {
                res = searchUsers[i];
                break;
            }
        }
    }

    return res;
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
            searchUsers = obj;
            document.getElementById("searchResults").innerHTML = '';
            //TODO: where are the images going to be stored

            if(obj != null) {
                for(var i = 0; i < obj.length;i++) {
                    var genImage = obj[i].gender == 'Male' ? 'images/male.png' : 'images/female.png';
                    var defImage = obj[i].photoId.length == 0 ? genImage: obj[i].photoId;
                    let test = "<div onclick='openSearchProfile("+ obj[i].id + ")'  class='grid-item'><img class='popimg' src='"+defImage+"'/><h4>" + obj[i].name + "</h4></div>\n";
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

    var request = {};
    request.get_user_matches_api = true;
    request.user_id = userID;
    $.ajax({
        method: "POST",
        url: "api.php",
        data: request,
        success: function (response) {
            console.log('getUserMatches', response);
            let obj = JSON.parse(response);
            //TODO: where are the images going to be stored
            if(obj != null) {
                myMatches = obj;

                for(var i = 0; i < obj.length;i++) {
                    var genImage = obj[i].gender == 'Male' ? 'images/male.png' : 'images/female.png';
                    var defImage = obj[i].photoId.length == 0 ? genImage: obj[i].photoId;
                    let test = "<div onclick='openUserProfile("+ obj[i].id + ")'  class='grid-item'><img class='popimg' src='"+  defImage +"'/><h4>" + obj[i].name + "</h4></div>\n";
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

function hideModalButtons() {
    $('#btnModalChat').hide();
    $('#btnModalMatch').hide();
    $('#btnModalUnMatch').hide();
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