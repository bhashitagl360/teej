
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