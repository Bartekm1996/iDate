<!DOCTYPE html>
<?php
if(ISSET($_POST["email"])) {
	$email = $_POST["email"];
	$cwd = getcwd();
shell_exec("sendmail $email < $cwd/templates/reg.txt");
echo "<pre>sent to $email</pre>";	
}

?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <script src='js/__code.jquery.com_jquery-1.12.3.js'></script>
    <script src='js/http_cdn.datatables.net_1.10.12_js_dataTables.bootstrap.js'></script>
    <script src="js/http_cdn.datatables.net_1.10.12_js_jquery.dataTables.js"></script>
    <script src="js/http_cdnjs.cloudflare.com_ajax_libs_popper.js_1.14.0_umd_popper.js"></script>
    <script src="js/http_cdnjs.cloudflare.com_ajax_libs_sweetalert_2.1.2_sweetalert.min.js"></script>
    <script src="js/site.js"></script>

    <link rel="stylesheet" href="css/http_cdn.datatables.net_1.10.12_css_dataTables.bootstrap.css">
    <link rel="stylesheet" href="css/http_cdn.datatables.net_responsive_2.1.0_css_responsive.bootstrap.css">
    <link rel="stylesheet" href="css/http_cdnjs.cloudflare.com_ajax_libs_bootstrap-sweetalert_1.0.1_sweetalert.css">
    <link rel="stylesheet" href="css/http_maxcdn.bootstrapcdn.com_bootstrap_3.3.6_css_bootstrap.css">
    <link rel="stylesheet" href="css/http_stackpath.bootstrapcdn.com_font-awesome_4.7.0_css_font-awesome.css">

    <title>Hello World</title>
</head>
<body>
<div class="container">
<form class="form" action="index.php" method="post">
<div class="row">
<div class="col-sm-3">
<label>To</label>
<input placeholder="person@site.com" class="form-control" type="text" name="email"><br>
<input class="btn btn-primary" type="submit">
</div>
</div>
</form>
</div>
</body>
</html>
