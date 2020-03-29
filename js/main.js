
(function ($) {
    "use strict";

    /*==================================================================
    [ Focus Contact2 ]*/
    $('.input100').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })    
    })

    $('#password').on('keydown', function () {
        if($(this).val().length === 0){
            if($('#passWordId').classList.contains('bg-danger')){
                $('#confirmPassWordBar').removeClass('bg-danger');
                $('#passWordId').removeClass('bg-danger');
            }else if($('#passWordId').classList.contains('bg-success')){
                $('#confirmPassWordBar').removeClass('bg-success');
                $('#passWordId').removeClass('bg-success');
            }else if($('#passWordId').classList.contains('bg-warning')){
                $('#confirmPassWordBar').removeClass('bg-warning');
                $('#passWordId').removeClass('bg-warning');
            }

        }
    });

    $('#password').on('input', function(){
        let strength = parseInt($('#passWordId').attr('aria-valuenow'));

        console.log($('#passWordId').attr('aria-valuenow'));

        if($(this).val().length === 0){
            strength = 0;
            $('#passWordId').attr('data-password-length', 0);
            $('#passWordId').attr('data-password-digit', 0);
            $('#passWordId').attr('data-password-lower-case', 0);
            $('#passWordId').attr('data-password-upper-case', 0);
            $('#passWordId').attr('data-password-special-case', 0);

        }


        if($(this).val().length > 7){
            if(parseInt( $('#passWordId').attr('data-password-length')) !== 1) {
                $('#passWordId').attr('data-password-length', 1);
                strength += 20;
                console.log("Password length");
            }
        }else{
            if(parseInt( $('#passWordId').attr('data-password-length')) === 1) {
                $('#passWordId').attr('data-password-length', 0);
                strength -= 20;
            }
        }


        if(/\d/.test($(this).val().trim())){
            if(parseInt($('#passWordId').attr('data-password-digit')) !== 1){
                $('#passWordId').attr('data-password-digit', 1);
                strength += 20;
                console.log("Contians digit")
            }
        }else {
            console.log("Doesnt Contians digit")
            if(parseInt($('#passWordId').attr('data-password-digit')) === 1){
                $('#passWordId').attr('data-password-digit', 0);
                strength -= 20;
            }
        }


        if(/[a-z]{2,}/.test($(this).val())){
            if(parseInt($('#passWordId').attr('data-password-lower-case')) !== 1){
                $('#passWordId').attr('data-password-lower-case', 1);
                strength += 20;
                console.log("Contians lower case")
            }
        }else {
            console.log("Doesnt Contians lower case")
            if(parseInt($('#passWordId').attr('data-password-lower-case')) === 1){
                $('#passWordId').attr('data-password-lower-case', 0);
                strength -= 20;
            }
        }

        if(/[A-Z]+/.test($(this).val().trim())){
            if(parseInt($('#passWordId').attr('data-password-upper-case')) !== 1){
                $('#passWordId').attr('data-password-upper-case', 1);
                strength += 20;
                console.log("Contians upper case")
            }
        }else {
            console.log("Doesnt Contians upper case")
            if(parseInt($('#passWordId').attr('data-password-upper-case')) === 1){
                $('#passWordId').attr('data-password-upper-case', 0);
                strength -= 20;
            }
        }

        if(/[!@#$%&*?]+/.test($(this).val().trim())){
            if(parseInt($('#passWordId').attr('data-password-special-case')) !== 1){
                $('#passWordId').attr('data-password-special-case', 1);
                strength += 20;
                console.log("Contians special case")
            }
        }else {
            console.log("Doesnt Contians special case")
            if(parseInt($('#passWordId').attr('data-password-special-case')) === 1){
                $('#passWordId').attr('data-password-special-case', 0);
                strength -= 20;
            }
        }

        console.log(strength);

        switch (strength) {
            case 0:{
                $('#passWordId').attr('aria-valuenow', strength).css('width', strength+"%");
                $('#confirmPassWordBar').attr('aria-valuenow', strength).css('width', strength+"%");
                break;
            }
            case 20:{
                $('#passWordId').addClass('bg-danger progress-bar').attr('aria-valuenow', strength).css('width', strength+"%");
                $('#confirmPassWordBar').addClass('bg-danger progress-bar').attr('aria-valuenow', strength).css('width', strength+"%");
                break;
            }
            case 40: case 60: case 80: {
                $('#passWordId').removeClass('bg-danger').addClass('bg-warning').attr('aria-valuenow', strength).css('width', strength+"%");
                $('#confirmPassWordBar').removeClass('bg-danger').addClass('bg-warning').attr('aria-valuenow', strength).css('width', strength+"%");
                break;
            }
            case 100:{
                $('#passWordId').removeClass('bg-warning').addClass('bg-success').attr('aria-valuenow', strength).css('width', strength+"%");
                $('#confirmPassWordBar').removeClass('bg-warning').addClass('bg-success').attr('aria-valuenow', strength).css('width', strength+"%");
                break;
            }
        }


    });


    /*==================================================================
    [ Validate after type ]*/
    $('.validate-input .input100').each(function(){
        $(this).on('blur', function(){
            if(validate(this) === false){
                showValidate(this);
            }
            else {
                $(this).parent().addClass('true-validate');
            }
        })    
    })

    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
           $(this).parent().removeClass('true-validate');
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();
        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();
        $(thisAlert).removeClass('alert-validate');
    }

    $('#signUp').click(function(){
        const isLoginVisible = $('#loginForm').is(':not(:hidden)');

        if(isLoginVisible) {
            $('#loginForm').hide();
            $('#signUpHeader').html("Sign Up");
            $('#signUp').html("Sing In");
            $('#registerForm').show();
        } else {
            $('#loginForm').show();
            $('#signUpHeader').html("Sign In");
            $('#signUp').html("Sing Up");
            $('#registerForm').hide();
        }
    })
    


})(jQuery);