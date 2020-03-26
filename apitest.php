<!DOCTYPE html>
<html lang="en">
<head>
    <title>iDate</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

    <link rel="stylesheet" type="text/css" href="vendorv/bootstrap/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendorv/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendorv/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendorv/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="vendorv/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="vendorv/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">


    <link href="vendorv/sweetalert/sweetalert.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<!--    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
<!--    <script src="//geodata.solutions/includes/statecity.js"></script>-->
<!--    <script src="//geodata.solutions/includes/countrystatecity.js"></script>-->

    <script>
        //<!-- Ajax post test-->
        function loadFiles() {
            const files = document.querySelector('[type=file]').files;
            var ufiles = [];
            var formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                formData.append('files[]', file)
            }

            var request = {};
            request.upload_files_api = true;
            request.formData = formData;
            sendFormDataTest(request, "api.php");
        }

        function getAllUsers() {
            var request = {};
            request.get_all_users_api = true;
            sendDataTest(request, "api.php");
        }

        function loadUserImages() {
            var request = {};
            request.get_user_images_api = true;
            request.user_id = $('#user_id').val();
            sendDataTest(request, "api.php");
        }

        function getUserConnections() {
            var request = {};
            request.get_connections_api = true;
            request.user_id = $('#user_id').val();
            sendDataTest(request, "api.php");
        }

        function getUserMatches() {
            var request = {};
            request.get_user_matches_api = true;
            request.user_id = $('#user_id').val();
            sendDataTest(request, "api.php");
        }

        function getAvailableInterests() {
            var request = {};
            request.get_available_interests_api = true;
            sendDataTest(request, "api.php");
        }

        function createMatch() {
            var request = {};
            request.create_match_api = true;
            request.id1 = $('#user_id').val();
            request.id2 = $('#match_id').val();
            sendDataTest(request, "api.php");
        }

        function sendFormDataTest(request, urll) {
            console.log(request);
            $.ajax({
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                url: urll,
                data: request,
                success: function (response) {
                    console.log(response);
                    $('#resultTxt').text(response);
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
                    $('#resultTxt').text(response);
                },
                failure: function (response) {
                    console.log('failure:' + JSON.stringify(response));
                    },
                error: function (response) {
                    console.log('error:' + JSON.stringify(response));
                }
            });
        }

    </script>
</head>
<body style="background-color: #999999;">

<div class="limiter">
    <div class="row">
        <div class="col-12">
            <textarea id="resultTxt" class="form-control" style="width:90%; height: 300px; margin-left: 3%; margin-right: 3%"></textarea>
        </div>
        <div class="col-2" style="margin-left: 3%;margin-top: 1%;">
            <input class="form-control" id="user_id" type="text" placeholder="user id"/>
        </div>
        <div class="col-2" style="margin-left: 3%;margin-top: 1%;">
            <input class="form-control" id="match_id" type="text" placeholder="match id"/>
        </div>
        <div class="col-2" style="margin-left: 3%;margin-top: 1%;">
            <input class="form-control" id="photo_id" type="text" placeholder="Upload image title"/>
        </div>
        <div class="col-12" style="margin-left: 3%;margin-top: 1%;">
            <button class="btn btn-warning" onclick="getAllUsers()">getAllUsers()</button>
            <button class="btn btn-primary" onclick="createMatch()">createMatch()</button>
            <button class="btn btn-success" onclick="loadUserImages()">loadUserImages()</button>
            <button class="btn btn-info" onclick="getAvailableInterests()">getAvailableInterests()</button>
            <button class="btn btn-danger" onclick="getUserConnections()">getUserConnections()</button>
            <button class="btn btn-warning" onclick="getUserMatches()">getUserMatches()</button>
            <button class="btn btn-primary" onclick="getAllUsers()">Get all users</button>
            <button class="btn btn-success" onclick="getAllUsers()">Get all users</button>

            <div method="post" enctype="multipart/form-data">
                <input type="file" name="files[]" multiple />
                <button class="btn btn-warning" onclick="loadFiles()">Upload</button>
            </div>
        </div>
    </div>

</div>



<script src="vendorv/jquery/jquery-3.2.1.min.js"></script>
<script src="vendorv/animsition/js/animsition.min.js"></script>
<script src="vendorv/bootstrap/js/popper.js"></script>
<script src="vendorv/bootstrap/js/bootstrap.min.js"></script>
<script src="vendorv/select2/select2.min.js"></script>
<script src="vendorv/daterangepicker/moment.min.js"></script>
<script src="vendorv/daterangepicker/daterangepicker.js"></script>
<script src="vendorv/countdowntime/countdowntime.js"></script>
<script src="js/main.js"></script>

</body>
</html>

