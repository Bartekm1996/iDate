

<div class="main-content" id="user_profile" hidden style="height: 100%; width: 100%; overflow-y: scroll;" >
    <!-- Top navbar -->
    <!-- Header -->
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(https://source.unsplash.com/random); background-size: cover; background-position: center top;">
        <!-- Mask -->
        <span class="mask bg-gradient-default opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
            <div class="row">
                <div class="col-lg-7 col-md-10">
                    <h1 class="display-2 text-white" id="user_profile_name"></h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <img src="https://source.unsplash.com/random" style="width: 118px; height: 118px;" class="rounded-circle avatar">
                            </div>
                        </div>
                    </div>
                    <div id="buttons" class="text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4 mr-1 ml-1">
                        <div class="d-flex justify-content-between">
                            <a href="#" id="connect_button" class="btn btn-sm btn-info mr-4" hidden>Connect</a>
                            <a href="#" id="card_report_button" class="btn btn-sm btn-default float-right" hidden>Report</a>
                            <a href="#" id="card_message_button" class="btn btn-sm btn-default float-right" hidden>Message</a>
                        </div>
                    </div>
                    <div class="card-body pt-0 pt-md-4">
                        <div class="row">
                            <div class="col">
                                <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                    <div>
                                        <span class="heading">22</span>
                                        <span class="description">Friends</span>
                                    </div>
                                    <div>
                                        <span class="heading">10</span>
                                        <span class="description">Photos</span>
                                    </div>
                                    <div>
                                        <span class="heading">89</span>
                                        <span class="description">Comments</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3 id="profile_user_card_name">
                            </h3>
                            <div class="h5 font-weight-300">
                                <i class="ni location_pin mr-2"></i>City, Country
                            </div>
                            <div class="h5 mt-4">
                                <span id="seeking"></span>
                            </div>
                            <div>
                            </div>
                            <hr class="my-4">
                            <p>Description</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">My account</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="container" style="width: 100%;">
                                <h6 style="display: inline-block;" class="heading-small text-muted mb-4 pull-left">User information</h6>
                                <a  style="display: inline-block;" id="user_profile_save_button" href="#!" class="btn btn-sm btn-primary pull-right">Save</a>
                            </div>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-username">Username</label>
                                            <input type="text" class="form-control form-control-alternative" placeholder="Username" id="profile_input_user_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-email">Email address</label>
                                            <input type="email" class="form-control form-control-alternative" placeholder="abc@example.com" id="profile_input_user_email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-first-name">First name</label>
                                            <input type="text" class="form-control form-control-alternative" placeholder="First name" id="profile_input_user_first_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-last-name">Last name</label>
                                            <input type="text"  class="form-control form-control-alternative" placeholder="Last name" id="profile_input_user_last_name" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <!-- Address -->
                            <div class="container" style="width: 100%;">
                                <h6 style="display: inline-block;" class="heading-small text-muted mb-4 pull-left">Contact information</h6>
                                <a  style="display: inline-block;" href="#!" class="btn btn-sm btn-primary pull-right" id="user_profile_contact_save_button">Save</a>
                            </div>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-address">Address</label>
                                            <input id="input-address" class="form-control form-control-alternative" placeholder="Home Address" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-city">City</label>
                                            <input type="text" id="input-city" class="form-control form-control-alternative" placeholder="City">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-country">Country</label>
                                            <input type="text" id="input-country" class="form-control form-control-alternative" placeholder="Country">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-country">Postal code</label>
                                            <input type="number" id="input-postal-code" class="form-control form-control-alternative" placeholder="Postal code">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <!-- Description -->
                            <div class="container" style="width: 100%;">
                                <h6 style="display: inline-block;" class="heading-small text-muted mb-4 pull-left">About Me</h6>
                                <a  style="display: inline-block;" href="#!" class="btn btn-sm btn-primary pull-right" id="user_profile_about_me_save_button">Save</a>
                            </div>
                            <div class="pl-lg-4">
                                <div class="form-group focused">
                                    <label>About Me</label>
                                    <textarea rows="4" class="form-control form-control-alternative" placeholder="A few words about you ..."></textarea>
                                </div>
                            </div>
                            <hr class="my-4">
                            <!-- About -->
                            <div class="container" style="width: 100%;">
                                <h6 style="display: inline-block;" class="heading-small text-muted mb-4 pull-left">Info</h6>
                                <a  style="display: inline-block;" href="#!" class="btn btn-sm btn-primary pull-right" id="user_profile_info_save_button">Save</a>
                            </div>
                            <div class="pl-lg-4">
                                <div class="form-group focused">
                                </div>
                            </div>
                            <hr class="my-4">
                            <!-- Interests -->
                            <div class="container" style="width: 100%;">
                                <h6 style="display: inline-block;" class="heading-small text-muted mb-4 pull-left">Interests</h6>
                                <a  style="display: inline-block;" href="#!" class="btn btn-sm btn-primary pull-right" id="user_profile_interest_save_button">Save</a>
                            </div>
                            <div class="pl-lg-4">
                                <div class="form-group focused">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
