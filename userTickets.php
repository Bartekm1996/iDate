<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/userTickets.css">
<script src="js/userTickets.js"></script>
<script src="vendorv/jquery/jquery-3.2.1.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


<!------ Include the above in your HEAD tag ---------->


<div class="container" id="main_cont" hidden>
    <div class="row">
        <div class="panel">
            <div style="display: inline-block;">
                <input class="form-control ml-2 mt-4" placeholder="Enter ticket number" onkeyup="filterTickets(this)">
            </div>
            <div class="pull-right" style="display: inline-block;">
                <div class="btn-group">
                    <button type="button" class="btn btn-success btn-filter" data-target="other">Other</button>
                    <button type="button" class="btn btn-warning btn-filter" data-target="not_receiving_verification_Email">Not Receiving Verification Email</button>
                    <button type="button" class="btn btn-danger btn-filter" data-target="cannot_login">Cannot Login</button>
                    <button type="button" class="btn btn-danger btn-filter" data-target="abusive_messages">Abusive Messages</button>
                    <button type="button" class="btn btn-warning btn-filter" data-target="continous_stalking">Continous Stalking</button>
                    <button type="button" class="btn btn-danger btn-filter" data-target="inapropiate_behaviour">Inappropiate Behaviour</button>
                    <button type="button" class="btn btn-default btn-filter" data-target="all">All</button>
                </div>
            </div>
            <div class="table-container">
                <table class="table table-filter">
                    <tbody id="complaints">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>




