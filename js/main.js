
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


    $('#password').on('input', function(){
        let strength = parseInt($('#passWordId').attr('aria-valuenow'));

        if(document.getElementById('passWordInfo').getAttribute('hidden') !== null) {
            document.getElementById('passWordInfo').removeAttribute('hidden');
        }

        if($(this).val().length === 0){
            strength = 0;
            $('#passWordId').attr('data-password-length', 0);
            $('#passWordId').attr('data-password-digit', 0);
            $('#passWordId').attr('data-password-lower-case', 0);
            $('#passWordId').attr('data-password-upper-case', 0);
            $('#passWordId').attr('data-password-special-case', 0);
            $('#digit').css({'color': 'red'});
            $('#upperCase').css({'color': 'red'});
            $('#lowerCase').css({'color': 'red'});
            $('#passLength').css({'color': 'red'});
            $('#specialChar').css({'color': 'red'});


        }

        if($(this).val().length > 7){
            if(parseInt( $('#passWordId').attr('data-password-length')) !== 1) {
                $('#passWordId').attr('data-password-length', 1);
                $('#passLength').css({'color': 'green'});
                strength += 20;
            }
        }else{
            if(parseInt( $('#passWordId').attr('data-password-length')) === 1) {
                $('#passWordId').attr('data-password-length', 0);
                $('#passLength').css({'color': 'red'});
                strength -= 20;
            }
        }


        if(/\d/.test($(this).val().trim())){
            if(parseInt($('#passWordId').attr('data-password-digit')) !== 1){
                $('#passWordId').attr('data-password-digit', 1);
                strength += 20;
                $('#digit').css({'color': 'green'});
            }
        }else {
            if(parseInt($('#passWordId').attr('data-password-digit')) === 1){
                $('#passWordId').attr('data-password-digit', 0);
                $('#digit').css({'color': 'red'});
                strength -= 20;
            }
        }


        if(/[a-z]+/.test($(this).val())){
            if(parseInt($('#passWordId').attr('data-password-lower-case')) !== 1){
                $('#passWordId').attr('data-password-lower-case', 1);
                $('#lowerCase').css({'color': 'green'});
                strength += 20;
            }
        }else {
            if(parseInt($('#passWordId').attr('data-password-lower-case')) === 1){
                $('#passWordId').attr('data-password-lower-case', 0);
                $('#lowerCase').css({'color': 'red'});
                strength -= 20;
            }
        }

        if(/[A-Z]+/.test($(this).val().trim())){
            if(parseInt($('#passWordId').attr('data-password-upper-case')) !== 1){
                $('#passWordId').attr('data-password-upper-case', 1);
                $('#upperCase').css({'color': 'green'});
                strength += 20;
            }
        }else {
            if(parseInt($('#passWordId').attr('data-password-upper-case')) === 1){
                $('#passWordId').attr('data-password-upper-case', 0);
                $('#upperCase').css({'color': 'red'});
                strength -= 20;
            }
        }

        if(/[!@#$%()&*?{}\[\]\/]+/.test($(this).val().trim())){
            if(parseInt($('#passWordId').attr('data-password-special-case')) !== 1){
                $('#passWordId').attr('data-password-special-case', 1);
                $('#specialChar').css({'color': 'green'});
                strength += 20;
            }
        }else {
            if(parseInt($('#passWordId').attr('data-password-special-case')) === 1){
                $('#passWordId').attr('data-password-special-case', 0);
                $('#specialChar').css({'color': 'red'});
                strength -= 20;
            }
        }


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