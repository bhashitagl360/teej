<?php require_once 'inc/config.php'; 
$curr_url = "http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$site = siteUrl;
if($curr_url== $site.'/index.php')
{
header("HTTP/1.1 301 Moved Permanently");
header("location: ".siteUrl);
}
?>
<!doctype html>
<html>
<?php require_once 'inc/meta.php'; ?>
<body>
    <?php 
        require_once 'inc/header.php'; 
        require_once 'inc/middle.php'; 
        require_once 'inc/recent_post.php'; 
        require_once 'inc/footer.php'; 
        require_once 'inc/script.php'; 
    ?>
    <div id="popupContent" class="modal fade" role="dialog">

    </div>
</body>
</html>
