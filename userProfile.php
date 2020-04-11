

<div class="main-content" id="user_profile" style="height: 100%; width: 100%; overflow-y: scroll;" >
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
                                <img id="upro_img" src="https://source.unsplash.com/random" style="width: 118px; height: 118px;border: 2px solid white;" class="rounded-circle avatar">
                            </div>
                        </div>
                    </div>
                    <div id="buttons" class="text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4 mr-1 ml-1">
                        <div class="d-flex justify-content-between">
                            <a href="#" id="connect_button" class="btn btn-sm btn-info mr-4"  onclick="connect($('#upro_img').attr('data-id'),$('#username-header').attr('user-id'))" hidden>Connect</a>
                            <a href="#" id="card_report_button" class="btn btn-sm btn-default float-right" onclick="openReportPane($('#profile_input_user_name').val())" hidden>Report</a>
                            <button id="card_message_button" class="btn btn-sm btn-default float-right" onclick="showUserChar($('#profile_input_user_name').val())"  hidden>Message</button>
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
                                <i class="ni location_pin mr-2" id="city_selected"></i>
                            </div>
                            <div class="h5 mt-4">
                                <span id="seeking"></span>
                            </div>
                            <div>
                            </div>
                            <hr class="my-4">
                            <p id="profile_card_description"></p>
                            <hr class="my-4">
                            <div style="margin-top: 25px;">
                                <div style="width: 100%; height: 100px;">
                                    <div style="display: grid; grid-template-columns: auto auto auto; height:100px; overflow-y: scroll; grid-gap: 10px;" id="card_interest_results">
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <button id="close_account_button" class="btn btn-danger" style="width: 100%;" onclick="closeAccount('\''+$('#upro_img').attr('data-id')+'\'')">Close Account</button>
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
                                <a  style="display: inline-block;" id="user_profile_save_button" href="#!" class="btn btn-sm btn-primary pull-right" onclick="saveuserinformation()">Save</a>
                            </div>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-username">Username</label>
                                            <input type="text" class="form-control form-control-alternative" placeholder="Username" id="profile_input_user_name" readonly="readonly">
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
                                <a  style="display: inline-block;" href="#!" class="btn btn-sm btn-primary pull-right" id="user_profile_contact_save_button" onclick="saveCity()">Save</a>
                            </div>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-city">City</label>
                                            <select class="form-control" name="input_city" id="city_select">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-country">Country</label>
                                            <input type="text" id="input-country" class="form-control form-control-alternative" value="Ireland" readonly placeholder="Country">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <!-- Description -->
                            <div class="container" style="width: 100%;">
                                <h6 style="display: inline-block;" class="heading-small text-muted mb-4 pull-left">About Me</h6>
                                <a  style="display: inline-block;" href="#!" class="btn btn-sm btn-primary pull-right" id="user_profile_about_me_save_button" onclick="saveaboutme()">Save</a>
                            </div>
                            <div class="pl-lg-4">
                                <div class="form-group focused">
                                    <label>About Me</label>
                                    <textarea rows="4" class="form-control form-control-alternative" id="profile_bio" placeholder="A few words about you ..."></textarea>
                                </div>
                            </div>
                            <hr class="my-4">
                            <!-- About -->
                            <div class="container" style="width: 100%;">
                                <h6 style="display: inline-block;" class="heading-small text-muted mb-4 pull-left">Info</h6>
                                <a  style="display: inline-block;" href="#!" class="btn btn-sm btn-primary pull-right" id="user_profile_info_save_button" onclick="saveUserInfo()">Save</a>
                            </div>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <i class="mdi mdi-account icon-sm "></i><span class="form-control-label mb-2"><strong>Gender</strong> </span>
                                        <select id="gender_picker" class="form-control mb-3">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Can't Decide</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <i class="mdi mdi-account icon-sm "></i><span class="form-control-label mb-2"><strong>Seeking</strong></span>
                                        <select id="seeking_picker" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Can't Decide</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <i class="mdi mdi-account icon-sm "></i><span class="form-control-label mb-2"><strong>Drinker</strong></span>
                                        <select id="drinker_picker" class="form-control mb-3">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            <option value="ocasionally">Ocasionally</option>
                                            <option value="party smoker">Party Smoker</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <i class="mdi mdi-account icon-sm "></i><span class="form-control-label mb-2"><strong>Smoker</strong></span>
                                        <select id="smoking_picker" class="form-control">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            <option value="ocasionally">Ocasionally</option>
                                            <option value="party drinker">Party Drinker</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Interests -->
                            <div class="container" style="width: 100%; height: 300px;" hidden id="user_ints">
                                <hr class="my-4">
                                <h6 style="display: inline-block;" class="heading-small text-muted mb-4 pull-left">Interests</h6>
                                <a  style="display: inline-block;" href="#" class="btn btn-sm btn-primary pull-right" id="user_profile_interest_save_button" onclick="editInterests('open')">Edit</a>
                                <div style="display: grid; grid-template-columns: auto auto auto; height: 250px; margin-top: 50px; margin-bottom: 20px; position: center; overflow-y: scroll; grid-row-gap: 75px;" id="interestResult" >
                                </div>
                            </div>
                            <div class="pl-lg-4">
                                <div class="form-group focused">
                                </div>
                            </div>
                            <div id="history_user_table" hidden>
                                <div class="container" style="width: 100%;">
                                    <h6 style="display: inline-block;" class="heading-small text-muted mb-4 pull-left">User Profile History</h6>
                                </div>
                                <hr class="my-4">
                                <div class="pl-lg-4" >
                                    <div class="form-group focused" id="profile_history" style="height: 250px; overflow-y: scroll;">
                                        <table class="table table-striped table-borderless table-hover" id="history_table" style="width: 100%; height: 250px; overflow-y: scroll;">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th>
                                                    <span>Date</span>
                                                </th>
                                                <th>
                                                    <span>Event</span>
                                                </th>
                                                <th>
                                                    <span>Description</span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody id="history_table_body">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="interests_select" style="padding: 10px; position: absolute; ; left: 20%; top: 10%; right: 20%; bottom: 10%;background: whitesmoke; z-index: 100;;  overflow-y: scroll;" hidden>
    <div role="group" class="btn-group mt-2 pull-right">
        <button class="btn btn-warning ml-2" type="button" onclick="editInterests('close')">Close</button>
        <button class="btn btn-primary ml-2" type="button" onclick="saveInterest()">Save</button>
    </div>
    <div style="display: grid;grid-template-columns: auto auto auto auto;grid-row-gap: 25px; width: 50%; height: 100%; margin-left: 15px; margin-top: 50px;">
        <div class="in-card" onclick="setActive(this)">
            <div class="in-card-header"><span>Football</span></div>
            <div class="in-card-main"><img src="https://firebasestorage.googleapis.com/v0/b/inventory-b7072.appspot.com/o/iDare%2Ficonfinder_football_172468.png?alt=media&amp;token=57ccb570-6d86-4a3d-8d93-4ea1949c4b58" style="width: 100px;height: 100px;" /></div>
        </div>
        <div class="in-card" onclick="setActive(this)">
            <div class="in-card-header"><span>Cinema</span></div>
            <div class="in-card-main"><img src="https://firebasestorage.googleapis.com/v0/b/inventory-b7072.appspot.com/o/iDare%2Ficonfinder_cinema_103271.png?alt=media&amp;token=128052b1-f064-4a5e-8fd7-d7209440a3fa" style="height: 100px;width: 100px;" /></div>
        </div>
        <div class="in-card" onclick="setActive(this)">
            <div class="in-card-header"><span>Fashion</span></div>
            <div class="in-card-main"><img src="https://firebasestorage.googleapis.com/v0/b/inventory-b7072.appspot.com/o/iDare%2Ficonfinder___clothes_tshirt_fashion_outfit_3668861.png?alt=media&amp;token=cefca41c-1fff-43ff-8266-b119099b0ebc" style="width: 100px;height: 100px;"
                /></div>
        </div>
        <div class="in-card" onclick="setActive(this)">
            <div class="in-card-header"><span>Running</span></div>
            <div class="in-card-main"><img src="https://firebasestorage.googleapis.com/v0/b/inventory-b7072.appspot.com/o/iDare%2Ficonfinder_running_172541.png?alt=media&amp;token=60bea11b-9422-4fea-8528-185ee11941f4" style="height: 100px;width: 100px;" /></div>
        </div>
        <div class="in-card" onclick="setActive(this)">
            <div class="in-card-header"><span>CrossFit</span></div>
            <div class="in-card-main"><img src="https://firebasestorage.googleapis.com/v0/b/inventory-b7072.appspot.com/o/iDare%2Ficons8-crossfit-100.png?alt=media&amp;token=518e825f-497b-4f35-b003-439acd36aa73" style="width: 100px;height: 100px;" /></div>
        </div>
        <div class="in-card" onclick="setActive(this)">
            <div class="in-card-header"><span>Swimming</span></div>
            <div class="in-card-main"><img src="https://firebasestorage.googleapis.com/v0/b/inventory-b7072.appspot.com/o/iDare%2Ficonfinder_swimming_309010.png?alt=media&amp;token=f13a05f3-67fc-472b-a953-b0140949431d" style="width: 100px;height: 100px;" /></div>
        </div>
        <div class="in-card" onclick="setActive(this)">
            <div class="in-card-header"><span>Diving</span></div>
            <div class="in-card-main"><img src="https://firebasestorage.googleapis.com/v0/b/inventory-b7072.appspot.com/o/iDare%2Ficonfinder_icon-47-diving-goggles_315797.png?alt=media&amp;token=39bd658a-1718-4bd0-b482-6ced101e6aa0" style="width: 100px;height: 100px;" /></div>
        </div>
        <div class="in-card" onclick="setActive(this)">
            <div class="in-card-header"><span>Programming</span></div>
            <div class="in-card-main"><img src="https://firebasestorage.googleapis.com/v0/b/inventory-b7072.appspot.com/o/iDare%2Ficonfinder_java_2333414.png?alt=media&amp;token=c0d71c44-92b3-4456-8e1f-4dc6c86f4d40" style="width: 100px;height: 100px;" /></div>
        </div>
        <div class="in-card" onclick="setActive(this)">
            <div class="in-card-header"><span>Travelling</span></div>
            <div class="in-card-main"><img src="https://firebasestorage.googleapis.com/v0/b/inventory-b7072.appspot.com/o/iDare%2Ficonfinder___clothes_tshirt_fashion_outfit_3668861.png?alt=media&amp;token=cefca41c-1fff-43ff-8266-b119099b0ebc" style="width: 100px;height: 100px;"
                /></div>
        </div>
        <div class="in-card" onclick="setActive(this)">
            <div class="in-card-header"><span>Horse Riding</span></div>
            <div class="in-card-main"><img src="https://firebasestorage.googleapis.com/v0/b/inventory-b7072.appspot.com/o/iDare%2Ficonfinder_horse_384872.png?alt=media&amp;token=0a8f5921-182b-4e9f-9234-abcadae9913e" style="width: 100px;height: 100px;" /></div>
        </div>
    </div>
</section>