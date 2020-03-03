<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IDate</title>
    <!-- JS -->
	      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

			<script>
			$(document).ready(function() {
			  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.autocomplete');
    var instances = M.Autocomplete.init(elems, options);
  });
  
      $('input.autocomplete').autocomplete({
      data: {
        "Apple": null,
        "Microsoft": null,
        "Google": 'https://placehold.it/250x250'
      },
    });
  });
  </script>
  
              <style>
			body {
				background-image: url("images/bg.jpg");
		}

		.test {
		margin-top:10%;
  min-height: 400px;
}
.center {
  margin: auto;
  width: 50%;
  padding: 10px;
}
.column {
  float: left;
  width: 50%;
  padding: 10px;
}


/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}


@media screen and (max-width: 600px) {
  .smallscreen {
      display: none;
   }
   
}

h1 {
        font-family: 'Lobster', serif;
        font-size: 78px;
      }
			</style>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
		  
</head>
<body>

	<div class="container">

  <div class="row">

      <div style="border-radius: 30px 3px;" class="card test">
        <div class="card-content center-align">
				<h1 style="text-align:center">iDate</h1>
			  <div class="row">
			  
				  <div class="col m6 s12">
					<div class="input-field">
					  <i class=	"material-icons prefix">email</i>
					  <input type="text" id="autocomplete-input" class="autocomplete">
					  <label for="autocomplete-input">Email</label>
					</div>

					<div class="input-field">
					  <i class="material-icons prefix">lock</i>
					  <input type="text" id="autocomplete-input" class="autocomplete">
					  <label for="autocomplete-input">Passsword</label>
					</div>
				
					<a class="waves-effect waves-light btn purple"><i class="material-icons left">play_arrow</i>Login</a>
				</div>
			  <div class="col s6 center-align hide-on-small-only">
				<img style="border-radius: 20px 20px 0px 0px;"  height="300px" width="100%" src="https://image.shutterstock.com/image-vector/vector-app-user-illustration-flat-600w-1229510083.jpg"/>
			  </div>

			</div>
        </div>
      </div>
   
  </div>
</div>


</body>
</html>