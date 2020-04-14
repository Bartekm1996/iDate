
<div id="usermng" class="container-fluid" style="height: 100%; width: 100%;" hidden>
    <div class="container bootstrap snippet" style="height: 40%; width: 90%;">
        <div class="flex-row">
                    <div class="col-sm-3" style="display: table; margin: auto auto;" >
                        <img  src="images/icons/userIcon.png" id="mang_pro" class="img-circle img-thumbnail" style="margin-top: 20px; margin-right: 20px; height: 200px; width: 200px;"  alt="avatar">
                    </div>
                    <div class="col-sm-10"  style="width: 70%;margin-bottom: 20px; margin-left: 30px;">
                        <h2 id="user_profile_header" style="display: inline-block">User Profile</h2>
                        <button style="display:inline-block;" class="pull-right btn btn-primary mt-5" onclick="saveUserData()">Save</button>
                        <hr>
                    <div class="col-sm-5">
                            <div class="flex-w">
                                <label for="first_name" style="float: left;"><h4>First name</h4></label>
                                <a href="#" class="flex-grow-1 mt-3" id="user_edit_first_name" style="float: right;" data-id="first_name" onclick="editField(this)" hidden><i class="fas fa-pen"></i></a>
                                <input type="text" class="hide-input" data-active="false" name="first_name" id="first_name">
                            </div>
                        <div>
                            <label for="location" style="float: left;"><h4>Location</h4></label>
                            <input type="text" class="hide-input" name="location" id="location">
                        </div>
                    </div>
                    <div class="col-sm-5" style="margin-left: 20px;">
                        <div class=flex-w>
                            <label class="flex-grow-1 h" for="last_name" style="float: left;"><h4>Last name</h4></label>
                            <a href="#" class="flex-grow-1 mt-3" id="user_edit_last_name" style="float: right;" data-id="user_last_name_input" onclick="editField(this)" hidden><i class="fas fa-pen"></i></a>
                            <input class="hide-input" data-active="false" name="last_name" id="user_last_name_input" readonly/>
                        </div>
                        <div class="flex-w">
                            <label class="flex-grow-1" for="email" style="float: left;"><h4>Email</h4></label>
                            <input type="text" class="hide-input" data-active="false" name="email" id="user_email_input" readonly/>
                        </div>
                    </div>
                    </div>
        </div>
    </div>
    <div style="height:50%; width: 100%; overflow-y: scroll; margin-bottom: 20px;">
    <table class="table" id="data_table">
        <thead>
        <tr>
            <th>
                <select id="status" onchange="filter(this, '#status')">
                    <option value="status">Status</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="blocked">Blocked</option>
                </select>
            </th>
            <th>
                <input id="username" placeholder="Username" oninput="filter(this, '#userName')">
            </th>
            <th>
                <input id="name" placeholder="Name" oninput="filter(this, '#user_name')">
            </th>
            <th>
                <input id="user_email" placeholder="Email" oninput="filter(this, '#userEmail')">
            </th>
            <th>
                <select id="role" onchange="filter(this, '#role')">
                    <option value="role">Role</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </th>
            <th>Options</th>
        </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>
    </div>
    <div>
        <h3 id="column_size"></h3>
    </div>
</div>
