<?php require_once "inc/admin.php"; ?>
<!DOCTYPE html>
<html>
    <?php require_once 'inc/meta.php'; ?>
    <body class="skin-blue">
        <?php require_once 'inc/header.php'; ?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php require_once 'inc/left-sidebar.php'; ?>
            <aside class="right-side">
                <section class="content-header">
                    <h1>
                        Manage
                        <small>Massages</small>
                    </h1>
                </section>

                <section class="blog_section">
                    <div class="wrapper">
                        <div class="blogs">
                            <div class="blog1">
                                <ul id="container" class="news_list">
                                    <?php
                                        $sqlSelect = "SELECT id, firstname, email, message, image, created_date, status, document_type FROM visitor where deleted=0 order by id desc limit 10";
                                        $result = $mysqli->query($sqlSelect);
                                        if ($result->num_rows > 0) {
                                            foreach ($result as $rs) {
                                                $postID = $rs["id"];
                                                $status = $rs["status"];
                                                $firstname = $rs["firstname"];
                                                $image = $rs["image"];
                                            
                                    ?>
                                            <li id="main_<?php echo $postID; ?>">
                                                <div class="main doc">
                                                    <div class="queto"> 
                                                        <img src="<?php echo siteUrl; ?>/images/top_qeto.png" alt="<?php echo $firstname; ?>" />
                                                    </div>

                                                    <div class="right_icon">
                                                        <a href="javascript:void(0);" class="icon-btn" title="Delete" onclick="deleteMessage('<?php echo $postID; ?>');"><i class="fa fa-trash"></i></a>
                                                        <a href="javascript:void(0);" <?php echo ($status == 1) ? '' : "style='display:none'" ?> class="icon-btn" title="Inactive" id="inactive_<?php echo $postID; ?>" onclick="inactiveMessage('<?php echo $postID; ?>');"><i class="fa fa-close"></i></a>
                                                        <a href="javascript:void(0);" <?php echo ($status == 0) ? '' : "style='display:none'" ?> class="icon-btn" title="Active" id="active_<?php echo $postID; ?>" onclick="activeMessage('<?php echo $postID; ?>');"><i class="fa fa-check"></i></a>
                                                        <?php 
                                                            switch( $rs['document_type'] ) {
                                                                case "text":
                                                                    echo '<img src="' . siteUrl . '/images/text-image.png" alt="' . $firstname . '" />';
                                                                break;

                                                                case "image":
                                                                    echo '<img src="' . siteUrl . '/images/photoicon.png" alt="' . $firstname . '" />';
                                                                break;

                                                                case "video":
                                                                    echo '<img src="' . siteUrl . '/images/videoicon.png" alt="' . $firstname . '" />';
                                                                break;
                                                            }
                                                        ?> 
                                                    </div>
                                                    <div class="name">
                                                        <?php echo $firstname; ?>
                                                    </div>
                                                    <?php 
                                                        switch( $rs['document_type'] ) {
                                                            case "image":
                                                                echo '<div class="video_box"><img src="' . siteUrl . '/upload/' . $image . '" alt="' . $firstname . '" /></div>';
                                                            break;

                                                            case "video":
                                                                $videoURL = siteUrl.'/upload/'.$image;
                                                                echo '<p> <video controls><source src="'.$videoURL.'" type="video/mp4">Your browser does not support the video tag.</video> </p>';
                                                            break;
                                                        }
                                                    ?>
                                                    <p>
                                                        <?php 
                                                            if( strlen( $rs['message'] ) > 100 ) {
                                                                echo substr($rs['message'], 0, 100).' ...';
                                                            } else {
                                                                echo $rs['message']; 
                                                            }
                                                            
                                                        ?>
                                                    </p>
                                                </div>
                                            </li> 
                                    <?php } } ?>
                                </ul>
                                <input type="hidden" id="result_no" value="10">
                                <li class="loadbutton">
                                    <button class="loadmore" >Load More</button>
                                </li>
                            </div>  
                        </div>
                    </div>   
                </section>
            </aside>
        </div>
        <?php require_once 'inc/footer.php'; ?>
         <script type="text/javascript">
        $(document).on('click', '.loadmore', function () {
            $(this).text('Loading...');
            var ele = $(this).parent('li');
            $.ajax({
                url: 'loadmore.php',
                type: 'POST',
                data: {
                    page: $('#result_no').val(),
                    siteUrl: '<?php echo siteUrl; ?>'
                },
                success: function (response) {
                    //          alert(response);
                    if (response != 0) {
                        $(".news_list").append(response);
                        document.getElementById("result_no").value = Number($('#result_no').val()) + 10;
                        $('.loadmore').text('Load More');
                    } else {
                        $('.loadmore').hide();
                    }
                }



            });
          });
          
          function deleteMessage(id){
//            alert(id);
            var data = {"id":id};
              swal({
              title: "Are you sure?",
              text: "You want to delete this message!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, delete it!",
              closeOnConfirm: false
            },
            function(isConfirm){
             if (isConfirm) {
                 $.ajax({
                   url: 'delete-message.php',
                   type: 'POST',
                   data: data,
                   success: function(response){
                       if(response == 1){
                          swal("Deleted!", "Your message has been deleted.", "success"); 
                          $('#main_'+id).remove();
                        }else{
                          swal("Try again", "Something went wrong:)", "error");
                        }
                   }
                 });
             } 
             
            });
          }
          
          
          function inactiveMessage(id){
//            alert(id);
            var data = {"id":id};
              swal({
              title: "Are you sure?",
              text: "You want to inactive this message!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, inactive it!",
              closeOnConfirm: false
            },
            function(isConfirm){
             if (isConfirm) {
                 $.ajax({
                   url: 'inactive-message.php',
                   type: 'POST',
                   data: data,
                   success: function(response){
                       if(response == 1){
                          swal("Inactivated!", "Message has been inactivated.", "success"); 
                          $('#inactive_'+id).hide();
                          $('#active_'+id).show();
                        }else{
                          swal("Try again", "Something went wrong:)", "error");
                        }
                   }
                 });
             } 
             
            });
          }
          
          function activeMessage(id){
//            alert(id);
            var data = {"id":id};
              swal({
              title: "Are you sure?",
              text: "You want to active this message!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, active it!",
              closeOnConfirm: false
            },
            function(isConfirm){
             if (isConfirm) {
                 $.ajax({
                   url: 'active-message.php',
                   type: 'POST',
                   data: data,
                   success: function(response){
                       if(response == 1){
                          swal("Activated!", "Message has been activated.", "success"); 
                          $('#inactive_'+id).show();
                          $('#active_'+id).hide();
                        }else{
                          swal("Try again", "Something went wrong:)", "error");
                        }
                   }
                 });
             } 
             
            });
          }
    </script>
    </body>
</html>