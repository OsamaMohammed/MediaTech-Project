let img = null;
let formData = new FormData();
const vid = $('video')[0];
navigator.mediaDevices.getUserMedia({
        video: true
    }) // Cam Request
    .then(stream => {
        vid.srcObject = stream;
        return vid.play();
    })
    .then(() => { // enable the button
        $('#snapshot').attr('disabled', false);
        $('#snapshot').click(function () {
            snapshot()
                .then(readURL);
        });
    });

function snapshot() {
    const canvas = document.createElement('canvas'); // create a canvas
    const ctx = canvas.getContext('2d'); // get its context
    canvas.width = vid.videoWidth; // set its size to the one of the video
    canvas.height = vid.videoHeight;
    ctx.drawImage(vid, 0, 0); // the video
    return new Promise((res, rej) => {
        canvas.toBlob(res, 'image/jpeg'); // request a Blob from the canvas
        // console.log(canvas.toDataURL("image/png"));
    });
}

function readURL(image) {
    if (image != null) {
        var reader = new FileReader();
        // Hide cam and show image to crop
        $('video').hide();
        $('#my-image-crop-view').show();
        $('#retake').show();
        $('#snapshot').hide();

        reader.onload = function (e) {
            $('#my-image-crop-view').attr('src', URL.createObjectURL(image));
            var resize = new Croppie($('#my-image-crop-view')[0], {
                viewport: {
                    width: 400,
                    height: 300
                },
                boundary: {
                    width: 500,
                    height: 400
                },
                // enableResize: true,
                enableOrientation: true
            });
            $('#crop-button').show();
            $('#crop-button').on('click', function () {
                resize.result('base64').then(function (dataImg) {
                    img = dataImg; // testing
                    formData.append('image', dataImg);
                    removeCrop();
                    $('#finalImageRes').attr('src', dataImg);
                    $('#finalImageRes').show();

                })
            })
        }
        reader.readAsDataURL(image);
    }
}

$('#retake').click(function(){
    removeCrop();
    $('#snapshot').show();
    $('video').show();
});

$('#submit').click(function(e){
    e.preventDefault();
    if ($('textarea.textarea').val() == ""){
        alert("message is required");
    }else{
        formData.append('message', $('textarea.textarea').val())
        $.ajax({
            url: '/upload.php',
            data: formData,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function(msg) {
                alert('success');
                window.location.href = "/";
            },
            error: function() {
                alert('failed');
            }
        });
    }
});

function removeCrop(){
    $('#my-image-crop-view').hide();
    $('.croppie-container').replaceWith('<img style="display: none;" id="my-image-crop-view"/>');
    $('#retake').hide();
    $('#crop-button').hide();
}
