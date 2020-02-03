$(document).ready(function(){

    function GetLateral(){
        $.ajax({
            type: "POST",
            url: "application/src/routes.php?op=70",
            success: function(data) {
                $('#lateral').html(data);
            }
        });
    }


setInterval(GetLateral, 3000);


}); // termina query