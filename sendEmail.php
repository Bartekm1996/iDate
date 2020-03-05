<?php

    $email = new Email("bmlynarkiewicz1996@gmail.com", "bmlynarkiewicz1996@gmail.com", "Hello from iDate", "Test email from heroku");
    $email -> sendEmail();
    echo "Email sent";


