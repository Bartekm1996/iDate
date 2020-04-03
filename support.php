<script src="vendorv/jquery/jquery-3.2.1.min.js"></script>
<script src="js/main.js"></script>
<link rel="stylesheet" type="text/css" href="css/support.css">
<script type="text/javascript">

    function hiddeSupport() {
        $('#contact_form').attr('hidden', true);
    }

    function sendMessage() {

        const request = {};
        request.send_query_message = true;
        request.userName = document.getElementById("txtUserName").value;
        request.userEmail = document.getElementById("email").value;
        request.userDesc = document.getElementById("txtMsg").value;
        request.userReason = document.getElementById("reason").value;

        if(validate(request)) {
            $.ajax({
                method: "POST",
                url: "api.php",
                data: request,
                success: function (response) {
                    console.log(response);
                    let res = JSON.parse(response);
                    Swal.fire(res.title, res.message, res.type);
                    hiddeSupport();
                },
                failure: function (response) {
                    console.log('failure:' + JSON.stringify(response));
                },
                error: function (response) {
                    console.log('error:' + JSON.stringify(response));
                }
            });
        }else{
                document.getElementById("txtUserName").style.border = request.userName.length === 0 ? "2px solid red" : "";
                document.getElementById("email").style.border = request.userEmail.length === 0 ? "2px solid red" : "";
                document.getElementById("txtMsg").style.border = request.userDesc.length === 0 ? "2px solid red" : "";
                document.getElementById("reason").style.border = request.userReason.length === 0 ? "2px solid red" : "";
        }

    }

    function validate(request) {
        return request.userEmail.length > 0 && request.userName.length > 0 && request.userDesc.length > 0 && request.userReason.length > 0;
    }



</script>


<div id="contact_form" class="container contact-form" hidden>
            <button class="close-button" onclick="hiddeSupport()"><i class="zmdi zmdi-close"></i></button>
            <form method="post" >
                <h3>Got a Problem ? <br>Drop Us a Message</h3>
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="txtUserName" class="form-control" placeholder="Enter User Name" required/>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" placeholder="Enter Email" required/>
                        </div>
                        <div class="form-group">
                            <select id="reason" class="form-control" required>
                                <option value="" disabled selected hidden>Choose a Reason</option>
                                <option value="Cannot Login">Cannot Login</option>
                                <option value="Not Receiving Verification Email">Not Receiving Verification Email</option>
                                <option value="Verification Not Working">Verification Not Working</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="button" onclick="sendMessage()" id="send_message" name="btnSubmit" class="btnContact" value="Send Message" required/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea id="txtMsg" class="form-control" placeholder="Enter your message" style="width: 100%; height: 150px; resize: none;" required></textarea>
                        </div>
                    </div>
                </div>
            </form>
</div>
