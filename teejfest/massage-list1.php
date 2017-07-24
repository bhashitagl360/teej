<?php require_once "inc/admin.php"; ?>
<!DOCTYPE html>
<html>
    <?php require_once 'inc/meta.php'; ?>
    <body class="skin-blue">
        <?php require_once 'inc/header.php'; ?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php require_once 'inc/left-sidebar.php'; ?>
            <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Manage
                    <small>Massages</small>
                </h1>

            </section>

            <!-- Main content -->
            <section class="blog_section">
                <div class="wrapper">
                    <div class="blogs">
                        <div class="blog1">
                            <ul id="container" class="news_list">
                                <?php
                                $sqlSelect = "SELECT firstname, email, message, image, created_date, status, document_type FROM visitor where deleted=0 order by id desc limit 10";
                                $result = $mysqli->query($sqlSelect);
                                if ($result->num_rows > 0) {
                                    foreach ($result as $rs) {
                                        $postID = $rs["id"];
                                        $status = $rs["status"];
//                                        echo $status;
                                        
                                        ?>
                                <li id="main_<?php echo $postID; ?>">
                                            <div class="main doc">

                                                <div class="queto"> 
                                                    <img src="<?php echo siteUrl; ?>/images/top_qeto.png" alt="<?php echo $rs['firstname']; ?>" />
                                                </div>

                                                <div class="right_icon">
                                                    <a href="javascript:void(0);" class="icon-btn" title="Delete" onclick="deleteMessage('<?php echo $postID; ?>');"><i class="fa fa-trash"></i></a>
                                                    
                                                    
                                                    <a href="javascript:void(0);" <?php echo ($status == 1) ? '' : "style='display:none'" ?> class="icon-btn" title="Inactive" id="inactive_<?php echo $postID; ?>" onclick="inactiveMessage('<?php echo $postID; ?>');"><i class="fa fa-close"></i></a>
                                                    <a href="javascript:void(0);" <?php echo ($status == 0) ? '' : "style='display:none'" ?> class="icon-btn" title="Active" id="active_<?php echo $postID; ?>" onclick="activeMessage('<?php echo $postID; ?>');"><i class="fa fa-check"></i></a>

                                                    <?php if ($rs['document_type'] == 'text') { ?>
                                                        <img src="<?php echo siteUrl; ?>/images/doc.png" alt="<?php echo $rs['firstname']; ?>" />
                                                    <?php } else if ($rs['document_type'] == 'image') { ?>
                                                        <img src="<?php echo siteUrl; ?>/images/img_icon.png" alt="<?php echo $rs['firstname']; ?>" />
                                                    <?php } ?> 
                                                </div>
                                                <div class="name">
                                                    <?php echo $rs['firstname']; ?>
                                                </div>
                                                <div class="tag">
                                                    #Teej
                                                </div>
                                                <?php if ($rs['document_type'] == 'image') { ?>
                                                    <div class="video_box">  
                                                        <img src="<?php echo siteUrl . '/upload/' . $rs['image']; ?>" alt="<?php echo $rs['firstname']; ?>" />  
                                                    </div>
                                                <?php } ?>
                                                <p><?php echo $rs['message']; ?></p>

                                            </div>
                                        </li> 
                                    <?php }
                                } ?>





                            </ul>
                            <input type="hidden" id="result_no" value="10">
                            <li class="loadbutton">
                                <button class="loadmore" >Load More</button>
                            </li>

                        </div>  

                    </div>
                </div>   







            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->
        </div>
        <?php require_once 'inc/footer.php'; ?>
    </body>
</html>