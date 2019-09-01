<div id="list"></div>

<?php
function postImage($imgName, $fullName, $username, $comment, $uploadTime)
{
    return "<div class='card'><div class='card-image'><figure class='image is-3by3'><img src='/upload/$imgName'></figure></div><div class='card-content'><div class='media'><div class='media-content'><p class='title is-4'>$fullName</p><p class='subtitle is-6'>@$username</p></div></div><div class='content'>$comment<br><time datetime='2016-1-1'>$uploadTime</time></div></div></div>";
}



// echo postImage('logo.png', "Osamah Saadallah", "osamah_mohammed", 'Comment HERE', date("D, d M Y H:i:s"));
?>

<script>
    let page = 0;
    let perPage = 3;

    // load first page
    $(document).ready(function(){
        addContent(page++);
    });
    
    window.onscroll = function() {
        let scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : document.body.scrollTop;
        if (scrollTop < document.body.scrollHeight - window.innerHeight) return;
        addContent(page++);
    };

    function addContent(page) {
        $.ajax({
                url: '/api.php?page=' + page,
                type: 'GET',
                contentType: false,
                processData: false,
                success: function(msg) {
                    if (msg == ""){
                        window.onscroll = null;
                        $('#list').append('<div class="card"><div class="card-content"><div class="content has-text-centered">No more data<br></div></div></div>');
                    }else{
                        $('#list').append(msg);
                    }
                },
                error: function() {
                    alert('failed');
                }
            });

    }
</script>