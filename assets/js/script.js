// MODAL NAVIGATOR LOGIN AND REGISTER
$(document).ready(function() {
    $('#loginForm').show();
    $('#registerForm').hide();

    $('#showRegister').click(function(e) {
        e.preventDefault();
        $('#loginForm').hide();
        $('#registerForm').show();
    });

    $('#showLogin').click(function(e) {
        e.preventDefault();
        $('#registerForm').hide();
        $('#loginForm').show();
    });
});
// 

