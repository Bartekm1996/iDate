
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
                            <input type="email" class="form-control" id="email_support" placeholder="Enter Email" required/>
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
                            <input type="button" onclick="sendReportMessage(false)" id="send_message" name="btnSubmit" class="btnContact" value="Send Message" required/>
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
