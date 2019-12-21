$(document).ready(function () {

    renderScreen();
    function renderScreen() {
        setTimeout(renderScreen,500);
        $.ajax('arcade.php?output', {
            success: function(data) {
                let response = JSON.parse(data);
                $('#screen').html(response.screen);
            }
        });
    }

    $("#sb").on("click", function () {
        $.ajax('arcade.php?sb', {
            success: function(data) {
                let response = JSON.parse(data);
                console.log(response.sb);
            }
        });
    });

    $("#lb").on("click", function () {
        $.ajax('arcade.php?lb', {
            success: function(data) {
                console.log('left button');
            }
        });
    });

    $("#rb").on("click", function () {
        $.ajax('arcade.php?rb', {
            success: function(data) {
                console.log('right button');
            }
        });
    });

});