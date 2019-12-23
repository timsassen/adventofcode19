$(document).ready(function () {

    function paint(screen, meta)
    {
        var canvas = document.getElementById("screen");
        if (canvas.getContext) {
            let ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            let padding = 15;

            $.each(screen, function (key, pixel) {
                if (pixel[0] != -1) {
                    console.log(pixel);
                    ctx.font = '20px serif';
                    let topDistance = 40;
                    let leftDistance = 40;
                    ctx.strokeText(pixel[2], pixel[0] * padding + leftDistance, pixel[1] * padding + topDistance);
                }
            });

            if (meta['lastInstruction'] == 99) {
                ctx.font = '200px serif';
                ctx.strokeText("game over", 600, 400);
            }
        }
    }



    renderScreen();
    function renderScreen() {
        setTimeout(renderScreen,500);
        $.ajax('arcade.php?output', {
            success: function(data) {
                let response = JSON.parse(data);
                paint(
                    JSON.parse(response.screen),
                    JSON.parse(response.meta)
                );
                // $('#screen').html(response.screen);
                $('#meta').html(response.meta);
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