

function hiddeSupport() {
    $('#contact_form').attr('hidden', true);
}

function getDate() {
    let m = new Date();
    return m.getUTCFullYear() + "-" +
        ("0" + (m.getUTCMonth() + 1)).slice(-2) + "-" +
        ("0" + m.getUTCDate()).slice(-2) + " " +
        ("0" + m.getUTCHours()).slice(-2) + ":" +
        ("0" + m.getUTCMinutes()).slice(-2) + ":" +
        ("0" + m.getUTCSeconds()).slice(-2);
}

function sendReportMessage(userReport) {

    const request = {};
    request.send_query_message = true;
    request.status = "Opened";
    if(userReport){
        request.userName = $('#user_report_name').val();
        request.userEmail = $('#user_report_email').val();
        request.userDesc = ("User reported : " + $('#user_report_username').val() + ("\n" + $('#reason_text').val()));
        request.userReason = $('#report_select_reason').val();
    }else {
        request.userName = document.getElementById("txtUserName").value;
        request.userEmail = document.getElementById("email_support").value;
        request.userDesc = document.getElementById("txtMsg").value;
        request.userReason = document.getElementById("reason").value;
    }

    console.log(request.userName + " " + request.userEmail + " " + request.userDesc + " " + request.userReason);
    request.date = getDate();

    if(validate(request)) {
        $.ajax({
            method: "POST",
            url: "api.php",
            data: request,
            success: function (response) {
                console.log(response);
                let res = JSON.parse(response);
                Swal.fire(res.title, res.message, res.type);
                if(userReport){
                    openReportPane();
                }else {
                    hiddeSupport();
                }
                fillTicketsNumbers();
            },
            failure: function (response) {
                console.log('failure:' + JSON.stringify(response));
            },
            error: function (response) {
                console.log('error:' + JSON.stringify(response));
            }
        });
    }else {
        if (!userReport){
            document.getElementById("txtUserName").style.border = request.userName.length === 0 ? "2px solid red" : "";
            document.getElementById("email_support").style.border = request.userEmail.length === 0 ? "2px solid red" : "";
            document.getElementById("txtMsg").style.border = request.userDesc.length === 0 ? "2px solid red" : "";
            document.getElementById("reason").style.border = request.userReason.length === 0 ? "2px solid red" : "";
        }else{
            Swal.fire("Pleas Fill In All Fields");
        }
    }

}

function validate(request) {
    return request.userEmail.length > 0 && request.userName.length > 0 && request.userDesc.length > 0 && request.userReason.length > 0;
}

