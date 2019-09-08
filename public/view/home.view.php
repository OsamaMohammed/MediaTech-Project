<div id="list">
    <!-- API calls will handle the listing -->
</div>

<?php
// Handle URL with tags (passthrough to api)
if (isset($_GET['tag'])){
    echo '<script>window.pageTag="'.$_GET['tag'] . '"</script>';
}
?>
<script src="/js/home.js"></script>