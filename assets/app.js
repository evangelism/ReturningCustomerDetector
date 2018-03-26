Webcam.set({
    width: 420,
    height: 320,
    image_format: 'jpeg',
    jpeg_quality: 90
});
Webcam.attach( '#camera' );

function take_snapshot() {

    Webcam.snap( function(data_uri) {


        var img = $('<img id="dynamic">');
        img.attr('src', data_uri);
        img.attr('width', 480);


        $("#results").html(img);
        
        setTimeout(function()
        {
            $("#dynamic").faceDetection({
                complete: function (faces) {
                    if(faces.length > 0) {
                        $.ajax({
                            url: "./detect.php",
                            data: {
                                photo: data_uri
                            },
                            method: "POST",
                            context: document.body
                        }).done(function(data) {
                            $("#results").append(data);
                        });
                    }
                },
                error: function() {
                    console.log(code);
                }
            });

        }, 500);

    } );
}

function take_customer_snapshot() {
    // take snapshot and get image data
    Webcam.snap( function(data_uri) {
        // display results in page

        $.ajax({
            url: "./create.php",
            data: {
                photo: data_uri,
                name: $("#name").val()
            },
            method: "POST",
            context: document.body
        }).done(function(data) {
            $("#results").append(data);
        });

        document.getElementById('results').innerHTML =
            '<h2>Here is customers photo:</h2>' +
            '<img src="'+data_uri+'"/><br />';
    } );
}

$(document).ready(function() {
    $('#camera').faceDetection({
        complete: function (faces) {
            console.log(faces);
        }
    });
});