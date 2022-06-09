$(document).ready(function (){
    $('#logintoggle').bind('click', function (){
        $('#loginform').toggleClass('hidden');
        $(this).hide();
    });
});