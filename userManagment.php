<script src="https://kit.fontawesome.com/2530adff57.js" crossorigin="anonymous"></script>
<script src="js/userManagment.js"></script>

<script>

    window.onload = function () {
        getUserData();
    };

</script>

<div id="usermng" class="container-fluid" style="height: 100%; width: 100%;" hidden>
    <div class="container bootstrap snippet" style="height: 40%; width: 90%;">
        <div class="flex-row">
                    <div class="col-sm-3" style="padding-top: 20px;">
                        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar">
                    </div>
                    <div class="col-sm-10"  style="width: 70%;margin-bottom: 20px; margin-left: 30px;">
                        <h2 id="user_profile_header">User Profile</h2>
                        <hr>
                    <div class="col-sm-5">
                            <div class="flex-w">
                                <label for="first_name" style="float: left;"><h4>First name</h4></label>
                                <a href="#" class="flex-grow-1 mt-3" id="user_edit_first_name" style="float: right;" data-id="first_name" onclick="editField(this)" hidden><i class="fas fa-pen"></i></a>
                                <input type="text" class="form-control hide-input" data-active="false" name="first_name" id="first_name">
                            </div>
                        <div>
                            <label for="location" style="float: left;"><h4>Location</h4></label>
                            <input type="text" class="form-control hide-input" name="location" id="location">
                        </div>
                    </div>
                    <div class="col-sm-5" style="margin-left: 20px;">
                        <div class=flex-w>
                            <label class="flex-grow-1 h" for="last_name" style="float: left;"><h4>Last name</h4></label>
                            <a href="#" class="flex-grow-1 mt-3" id="user_edit_last_name" style="float: right;" data-id="user_last_name_input" onclick="editField(this)" hidden><i class="fas fa-pen"></i></a>
                            <input class="form-control hide-input" data-active="false" name="last_name" id="user_last_name_input"/>
                        </div>
                        <div class="flex-w">
                            <label class="flex-grow-1" for="email" style="float: left;"><h4>Email</h4></label>
                            <a href="#" class="flex-grow-1 mt-3" id="user_edit_email" style="float: right;" data-id="user_email_input" onclick="editField(this)" hidden><i class="fas fa-pen"></i></a>
                            <input type="text" class="form-control hide-input" data-active="false" name="email" id="user_email_input" >
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
