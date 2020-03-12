<!DOCTYPE html>
<html lang="en">
<head>
    <title>iDate</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


    <link href="vendorv/sweetalert/sweetalert.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $(document).ready(function() {
            $(".btn-pref .btn").click(function () {
                $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
                // $(".tab").addClass("active"); // instead of this do the below
                $(this).removeClass("btn-default").addClass("btn-primary");
            });
        });
    </script>

    <style>

        .panel.with-nav-tabs .panel-heading{
            padding: 5px 5px 0 5px;
        }
        .panel.with-nav-tabs .nav-tabs{
            border-bottom: none;
        }
        .panel.with-nav-tabs .nav-justified{
            margin-bottom: -1px;
        }
        /********************************************************************/
        /*** PANEL DEFAULT ***/
        .with-nav-tabs.panel-default .nav-tabs > li > a,
        .with-nav-tabs.panel-default .nav-tabs > li > a:hover,
        .with-nav-tabs.panel-default .nav-tabs > li > a:focus {
            color: #777;
        }
        .with-nav-tabs.panel-default .nav-tabs > .open > a,
        .with-nav-tabs.panel-default .nav-tabs > .open > a:hover,
        .with-nav-tabs.panel-default .nav-tabs > .open > a:focus,
        .with-nav-tabs.panel-default .nav-tabs > li > a:hover,
        .with-nav-tabs.panel-default .nav-tabs > li > a:focus {
            color: #777;
            background-color: #ddd;
            border-color: transparent;
        }
        .with-nav-tabs.panel-default .nav-tabs > li.active > a,
        .with-nav-tabs.panel-default .nav-tabs > li.active > a:hover,
        .with-nav-tabs.panel-default .nav-tabs > li.active > a:focus {
            color: #555;
            background-color: #fff;
            border-color: #ddd;
            border-bottom-color: transparent;
        }
        .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu {
            background-color: #f5f5f5;
            border-color: #ddd;
        }
        .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a {
            color: #777;
        }
        .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
        .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
            background-color: #ddd;
        }
        .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a,
        .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
        .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
            color: #fff;
            background-color: #555;
        }

        .matches td {
            padding: 5px 5px 5px 5px;
        }

        .matches h4 {
            text-align: center;
        }

        .matches img {
            border-radius: 5px 5px;
        }

        .matches-msg img {
            border-radius: 20px 20px;
        }

        .matches-msg {
            display: inline-flex;
            width: 100%;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto;
            padding: 5px 5px 5px 5px;
        }

        .grid-item {
            padding: 5px;
            font-size: 10px;
            text-align: center;
        }

        .grid-item img { border-radius: 5px 5px; }
    </style>

</head>
<body style="background-color: #999999;">

<div style="background-color: pink">
    <div class="row">
        <div class="col-md-4" >
            <div class="card">
                <div class="card-body" style="display: inline-flex">
                    <img src="https://via.placeholder.com/150"/>
                    <h1>Profile</h1>
                </div>
            </div>

            <div>
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Matches</a></li>
                            <li><a href="#tab2default" data-toggle="tab">Messages</a></li>
                            <li><a href="#tab3default" data-toggle="tab">Search</a></li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#tab4default" data-toggle="tab">Default 4</a></li>
                                    <li><a href="#tab5default" data-toggle="tab">Default 5</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1default">
                                <div class="grid-container">
                                    <?php

                                        for($i = 0; $i < 20;$i++) {
                                            echo"<div class='grid-item'><img src=\"https://i.pravatar.cc/100\"/><h4>Name</h4></div>\n";
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab2default">
                                <ul class="list-group">
                                <?php

                                for($i = 0; $i < 10;$i++) {
                                    echo "\n<li class='list-group-item matches-msg'><img src='https://i.pravatar.cc/100'/><p>This is some text</p></li>";
                                }
                                echo "\n";
                                ?>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="tab3default">Default 3</div>
                            <div class="tab-pane fade" id="tab4default">Default 4</div>
                            <div class="tab-pane fade" id="tab5default">Default 5</div>
                        </div>
                    </div>
                </div>
            </div>
            <div>list</div>
        </div>
        <div class="col-md-8" style="background-color: #0056b3">content</div>
    </div>
</div>


</div>




<script src="vendorv/jquery/jquery-3.2.1.min.js"></script>
<script src="vendorv/animsition/js/animsition.min.js"></script>
<script src="vendorv/bootstrap/js/popper.js"></script>
<script src="vendorv/bootstrap/js/bootstrap.js"></script>
<script src="js/main.js"></script>

</body>
</html>

