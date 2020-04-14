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
<script>
    (function($) {

        $.fn.charCounter = function (max, settings) {
            max = max || 100;
            settings = $.extend({
                container: "<span></span>",
                classname: "charcounter",
                format: "(%1 characters remaining)",
                pulse: true,
                delay: 0
            }, settings);
            var p, timeout;

            function count(el, container) {
                el = $(el);
                if (el.val().length > max) {
                    el.val(el.val().substring(0, max));
                    if (settings.pulse && !p) {
                        pulse(container, true);
                    };
                };
                if (settings.delay > 0) {
                    if (timeout) {
                        window.clearTimeout(timeout);
                    }
                    timeout = window.setTimeout(function () {
                        container.html(settings.format.replace(/%1/, (max - el.val().length)));
                    }, settings.delay);
                } else {
                    container.html(settings.format.replace(/%1/, (max - el.val().length)));
                }
            };

            function pulse(el, again) {
                if (p) {
                    window.clearTimeout(p);
                    p = null;
                };
                el.animate({ opacity: 0.1 }, 100, function () {
                    $(this).animate({ opacity: 1.0 }, 100);
                });
                if (again) {
                    p = window.setTimeout(function () { pulse(el) }, 200);
                };
            };

            return this.each(function () {
                var container;
                if (!settings.container.match(/^<.+>$/)) {
                    // use existing element to hold counter message
                    container = $(settings.container);
                } else {
                    // append element to hold counter message (clean up old element first)
                    $(this).next("." + settings.classname).remove();
                    container = $(settings.container)
                        .insertAfter(this)
                        .addClass(settings.classname);
                }
                $(this)
                    .unbind(".charCounter")
                    .bind("keydown.charCounter", function () { count(this, container); })
                    .bind("keypress.charCounter", function () { count(this, container); })
                    .bind("keyup.charCounter", function () { count(this, container); })
                    .bind("focus.charCounter", function () { count(this, container); })
                    .bind("mouseover.charCounter", function () { count(this, container); })
                    .bind("mouseout.charCounter", function () { count(this, container); })
                    .bind("paste.charCounter", function () {
                        var me = this;
                        setTimeout(function () { count(me, container); }, 10);
                    });
                if (this.addEventListener) {
                    this.addEventListener('input', function () { count(this, container); }, false);
                };
                count(this, container);
            });
        };

    })(jQuery);
</script>



