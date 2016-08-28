$().ready(function(){
    $("#userForm").validate({
        rules: {
            first_name: {
                required: true,
                minlength: 2,
                maxlength: 25
            },
            last_name: {
                required: true,
                minlength: 2,
                maxlength: 25
            },
            country: "required",
            email: {
                required: true,
                email:true
            },
            password: {
                required: true,
                minlength: 5,
                maxlength: 25
            },
            password_confirmation: {
                required:true,
                equalTo: '#password'
            }
        },
        messages: {
            first_name: {
                required: "Please enter your first name",
                minlength: "Your first name must consist of at least 2 characters",
                maxlength: "Your first name must consist a maximum of 25 characters"
            },
            last_name: {
                required: "Please enter your last name",
                minlength: "Your last name must consist of at least 2 characters",
                maxlength: "Your last name must consist a maximum of 25 characters"
            },
            country: "Please select your gender",
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address"
            },
            password: {
                require: "Please enter a password",
                minlength: "Your password must consist of at least 5 characters",
                maxlength: "Your password must consist a maximum of 25 characters"
            },
            password_confirmation: {
                required: "Please confirm your password",
                equalTo: "Your confirmation does not match with the password"
            }
        }
    })
});