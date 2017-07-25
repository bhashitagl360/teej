
$(function(){
    var m = new Masonry($('.grid').get()[0], {
        itemSelector: ".thumbnail"
    });
});

/**********************************************
	(): Submit User Data Upload.
	Working; addmin user inputs.
	Used: using ajax on submit call.
**********************************************/

function share_teej_form() {

	var share = '';

	share += ' <form id="upload-formordercnf" method="post" enctype="multipart/form-data">';
		share += '<div class="modal-dialog modal-lg">';
		    share += '<div class="modal-content aboutpopup">';
		      	share += '<div class="modal-header">';
					share += '<img src="'+siteURL+'/images/top_image.png" alt="" />';
					share += '<button type="button" class="close" data-dismiss="modal">';
						share += '<img src="'+siteURL+'/images/cross-image.png" alt="" />';
					share += '</button>';
					share += '<h4>SHARE YOUR TEEJ TAIYYARI</h4>';
		      	share += '</div>';
		      	share += '<div class="modal-body">';
				  	share += '<div class="innrmodalbody">';
					  	share += '<div class="innrmodalcntbx" id="other_place">';
							share += '<div class="lefttextbox">';
								share += '<input type="text" placeholder="Name" name="vistior_name" id="vistior_name" />';
								share += '<input type="text" placeholder="Email" name="vistior_email" id="vistior_email" />';
							share += '</div>';
							share += '<div class="right_textbox">';
								share += '<textarea placeholder="Comments" name="visitor_msg" id="visitor_msg"></textarea>';
							share += '</div>';
							share += '<div class="right_uploadbox">';
								share += '<label>UPLOAD IMAGE/VIDEO</label>';
								share += '<div class="custom-file-upload">';
									share += '<div class="file-upload-wrapper">';
										share += '<input class="file-upload-input" id="textfileupload" type="text">';
										share += '<input type="file" class="custom-file-upload" name="upload_file" id="upload_file" style="position:absolute; left: -99999px;" />';
										share += '<button type="button" class="file-upload-button" onclick="browse();">Select a File</button>';
									share += '</div>';
								share += '</div>';
							share += '</div>';
							share += '<div class="lefttextbox">';
								share += '<input type="text" name="captcha" id="captcha" placeholder="captcha" /><img id="captcha_code" src="captcha.php" />';
							share += '</div>';
							share += '<span id="buttonApply"><input class="submitbtn" type="submit" value="Submit" id="confirm-upload" /></span>';
					  	share += '</div>';

					  	share += '<div class="successmessgae" style="display:none;" id="successMsg">';
					  		share += '<h3> Thank you for sharing your Teej Taiyyari moments with us. Happy Teej. </h3>';
					  		//share += '<p> Thank you for sharing your Teej Taiyyari moments with us. Happy Teej. </p>';
					  	share += '</div>';
				  	share += '</div>';
		      	share += '</div>';
		      	share += '<div class="modal-footer">';
					share += '<img src="'+siteURL+'/images/bottom_image.png" alt="" />';
		      	share += '</div>';
		    share += '</div>';
		share += '</div>';
	share += '</form>';

	$("#popupContent").html( share );
	$('#popupContent').modal('toggle');
}

/**********************************************
	(): Submit User Data Upload.
	Working; addmin user inputs.
	Used: using ajax on submit call.
**********************************************/

jQuery(document).ready(function($) {
    $(document).on('submit','#upload-formordercnf', function(e) {
        e.stopImmediatePropagation();
   		e.preventDefault();
        var form_data = new FormData(this); //Creates new 
 		
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: siteURL+'/upload_data.php',
            data: form_data,
            crossOrigin: true,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function() {
                $('#confirm-upload').attr('disabled', true);
                $('#confirm-upload').after('<span class="wait2"><img src="'+siteURL+'/images/ajax-loader.gif" alt="loading" class="wait" /></span>');
            },
            complete: function() {
               $('#confirm-upload').attr('disabled', false);
               $('.wait2').remove();
            },
            success: function(data) {
            	$("#upload-formordercnf .ajax-apply-msg-target").remove();
               	var dataLen = data.length;
                if( dataLen > 0) {
                    for( var l=0; l<dataLen; l++ ) {
                        if (data[l].status == 1){
                            //alert( data[l].message );
                            $('#other_place').css('display', 'none');
                            $('#successMsg').css('display', 'block');
                        } else {
                            if( data[l].id != '') {
                                //$('#'+data[l].id).css('border', '1px solid red');
                                $('#'+data[l].id).before('<div class="ajax-apply-msg-target error-container">'+data[l].message+'</div>');
                            } else {
                                $('form#upload-formordercnf div#apply-status').html('<div class="ajax-apply-msg-target error-container">'+data[l].message+'</div>');
                            }
                        }
                    }
                }
            }
        });
        return false;
    });
});

/**********************************************
	(): Browse
	Working; it trigge button to file tag,
			 and get file name and add to
			 text field for user easy.
	Used: on Upload user details submission
**********************************************/

function browse() {

	$('#upload_file').trigger('click');

	$('input[type="file"]').change(function(){

	  	var f = this.files[0];  
	  	var name = f.name;
	  	$("#textfileupload").val(name);

	});
}

/**********************************************
	(): Menu Popup
	Working; get popup on click 
			 for cms content
	Used: on header block for menu a tag click
**********************************************/

function menu( name ) {

	if(  name == '' ||  name  == 'undefined' ) {
		return false;
	}

	$.ajax({
        type: "Post",
        data: {'slug':  name },
        crossOrigin: true,
        url: siteURL+'/content.php',
        dataType: 'json',
        beforeSend: function() {
            $('#addUserDetails').after('<img style="absolute: relative: right: -40px; top: -10px" src="'+siteURL+'/images/ajax-loader.gif" alt="" class="attention" />');
            $('#addUserDetails').attr('disabled', true);
        },
        complete: function() {
           $('#addUserDetails').attr('disabled', false);
           $(".attention").remove();
        },
        success: function (json) {
            getPopup( 'menu', json );
        }
    });
}


/**********************************************
	(): Menu Popup
	Working; get popup on click 
			 for user content
	Used: on recent block for read more ... click
**********************************************/
function user_popup( siteUrl, id ) {

	var regex=/^[0-9]+$/;

	if( siteUrl == '' ) {
		alert(" User Popup Ajax issue: Site URL is empty!");
		return false;
	}

	if( id == '' ) {
		alert("User Popup Ajax issue: Your id is empty!");
		return false;
	}

	if (!id.match(regex)) {
        alert("User Popup Ajax issue: Must input numbers");
        return false;
    }

	$.ajax({
        type: "Post",
        data: {'id': id},
        url: siteURL+'/user_content.php',
        crossOrigin: true,
        dataType: 'json',
        success: function (json) {
            getPopup( 'user', json );
        }
    });
}

/**********************************************
	(): Custom Model Popup HTML
	Used: show case wrapped dynamic code...
**********************************************/
function getPopup( type, data ) {
	var html = '';

  	html += '<div class="modal-dialog modal-lg">';
    	html += '<div class="modal-content aboutpopup">';
      		html += '<div class="modal-header">';
				html += '<img src="'+siteURL+'/images/top_image.png" alt="" />';
				html += '<button type="button" class="close" data-dismiss="modal">';
				html += '<img src="'+siteURL+'/images/cross-image.png" alt="" /></button>';

				switch( type ) {
					case "menu":
						html += '<h4>'+ data.title +'</h4>';
					break;

					case "user":
						html += '<h4>'+ data.firstname +'</h4>';
					break;
				}
      		html += '</div>';
		    html += '<div class="modal-body">';
				html += '<div class="innrmodalbody">';

					switch( type ){
						case "menu":
							html += '<img src="'+data.image+'" alt="" class="imagepop" />';
						break;

						case "user":

							if( data.document_type == 'image' && data.image != '') {
								var imageURL = siteURL+'/upload/'+data.image;;
								html += '<img src="'+imageURL+'" alt="" class="imagepop" />';
							}

							if( data.document_type == 'video' && data.image != '') {

								var videoURL = siteURL+'/upload/'+data.image;
								html += '<p> <video controls>';
									html += '<source src="'+videoURL+'" type="video/mp4">';
									html += 'Your browser does not support the video tag.';
								html += '</video> </p>';
							}
							
						break;
					}
					
				  	html += '<div class="innrmodalcntbx">';

				  		switch( type ){
							case "menu":
								html += data.description;
							break;

							case "user":
								html += '<p>'+ data.message +'</p>';
							break;
						}
				  	html += '</div>';
			  	html += '</div>';
		    html += '</div>';
      		html += '<div class="modal-footer">';
				html += '<img src="'+siteURL+'/images/bottom_image.png" alt="" />';
      		html += '</div>';
    	html += '</div>';
  	html += '</div>';

	$("#popupContent").html( html );
	$('#popupContent').modal( 'toggle' );
}

function recent_posts() {
	
    $.ajax({
        type: "POST",
        data: {'a': 'b'},
        url: siteURL+'/recent_post.php',
        crossOrigin: true,
        dataType: 'json',
        beforeSend: function() {
            $('#recent_posts').after('<span class="wait2"><img src="'+siteURL+'/images/ajax-loader.gif" alt="loading" class="wait" /></span>');
        },
        complete: function() {
           $('.wait2').remove();
        },
        success: function (json) {
            $("#recent_posts").html( json.message );
            $("#uploadDiv").show();
        }
    });
}


$(document).on('click', '.loadmore', function (e) {
	e.stopImmediatePropagation();
   	e.preventDefault();
    $.ajax({
        url: siteURL+'/loadmore.php',
        type: 'POST',
        data: {
            page: $('#result_no').val()
        },
        crossOrigin: true,
        dataType: 'json',
        success: function (json) {
            if (json.message != '') {
            	$("#recent_posts").html( json.message );
                document.getElementById("result_no").value = Number($('#result_no').val()) + 10;
            } else {
                $('.loadmore').hide();
            }
        }
    });
});

function refreshCaptcha() {
	$("#captcha_code").attr('src','captcha.php');
}