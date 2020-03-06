<?php
    include ("Email.php");

    
    $cont = file_get_contents(__DIR__."/emailTemplates/passWordReset.html");
    $res = str_replace("{{user_name}}", 'Bartlomiej', $cont);
    $email = new Email("noreply@idate.com", "bmlynarkiewicz1996@gmail.com", "Firsts Email", $res);
    $email -> sendEmail();
    echo "Email sent";


