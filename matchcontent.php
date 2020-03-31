<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="css/usermatch.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous">
<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="css/sidebar.css">
<!------ Include the above in your HEAD tag ---------->

<script type="text/javascript">
    $(function() {
        var Accordion = function(el, multiple) {
            this.el = el || {};
            this.multiple = multiple || false;

            // Variables privadas
            var links = this.el.find('.link');
            // Evento
            links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
        }

        Accordion.prototype.dropdown = function(e) {
            var $el = e.data.el;
            $this = $(this),
                $next = $this.next();

            $next.slideToggle();
            $this.parent().toggleClass('open');

            if (!e.data.multiple) {
                $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
            };
        }

        var accordion = new Accordion($('#accordion'), false);
    });

</script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<div class="container">
    <div class="row">


        <!-- Contenedor -->
        <ul id="accordion" class="accordion">
            <li>
                <div class="col col_4 iamgurdeep-pic">
                    <img class="img-responsive iamgurdeeposahan" alt="iamgurdeeposahan" src="http://webncc.in/img/user/gurdeep-singh-osahan.jpg">
                    <div class="username">
                        <h2>Gurdeep Osahan  <small><i class="fa fa-map-marker"></i> India (Punjab)</small></h2>
                        <p><i class="fa fa-briefcase"></i> Web Design and Development.</p>

                        <a href="https://web.facebook.com/iamgurdeeposahan" target="_blank" class="btn-o"> <i class="fa fa-user-plus"></i> Add Friend </a>
                        <a href="https://www.instagram.com/gurdeeposahan/" target="_blank"  class="btn-o"> <i class="fa fa-plus"></i> Follow </a>
                    </div>
                </div>

            </li>
            <li>
                <div class="link"><i class="fa fa-globe"></i>About<i class="fa fa-chevron-down"></i></div>
                <ul class="submenu">
                    <li><a href="#"> Date of Birth : 03/09/1994</a></li>
                    <li><a href="#">Address : INDIA,Punjab</a></li>
                    <li><a href="mailto:gurdeepjawaddi94@gmail.com">Email : gurdeepjawaddi94@gmail.com</a></li>
                    <li><a href="#">Phone : +91 85680-79956</a></li>
                </ul>
            </li>
            <li>
                <div class="link"><i class="fa fa-picture-o"></i>Photos <small><?php echo rand(1,10)?></small><i class="fa fa-chevron-down"></i></div>
                <ul class="submenu">
                    <li class="photosgurdeep"><a href="#"><img class="img-responsive iamgurdeeposahan" alt="iamgurdeeposahan" src="http://webncc.in/img/user/gurdeep-singh-osahan.jpg">
                        </a>
                        <a href="#"><img class="img-responsive iamgurdeeposahan" alt="iamgurdeeposahan" src="http://webncc.in/img/user/gurdeep-singh-osahan.jpg">
                        </a>
                        <a href="#"><img class="img-responsive iamgurdeeposahan" alt="iamgurdeeposahan" src="http://webncc.in/img/user/gurdeep-singh-osahan.jpg">
                        </a>
                        <a href="#"><img class="img-responsive iamgurdeeposahan" alt="iamgurdeeposahan" src="http://webncc.in/img/user/gurdeep-singh-osahan.jpg">
                        </a>

                        <a class="view-all" href="https://web.facebook.com/iamgurdeeposahan" target="_blank" >15+
                        </a>

                    </li>
                </ul>
            </li>
        </ul>
    </div>





</div>