/**
 * Initial variables
 */
let page = 0;
let perPage = 3;

// load first page
$(document).ready(function(){
    addContent(page++);
});

/**
 * Infinite scroll
 */
window.onscroll = function() {
    let scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : document.body.scrollTop;
    if (scrollTop < document.body.scrollHeight - window.innerHeight) return;
    // My method of adding content
    addContent(page++);
};

function addContent(page) {
    // switch for Tag listing
    let tag = window.pageTag ? "&tag=" + window.pageTag : "";

    // API Calls
    $.ajax({
            url: '/api.php?page=' + page + tag,
            type: 'GET',
            contentType: false,
            processData: false,
            success: function(msg) {
                if (msg.trim() == ""){
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
