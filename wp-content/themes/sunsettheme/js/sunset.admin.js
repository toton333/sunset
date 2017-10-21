jQuery(document).ready(function($){

  var mediauploader;

   $('#upload_button').on('click', function(e){
   	e.preventDefault();

   	if(mediauploader){

   		mediauploader.open();
   		return;

   	}

   	mediauploader = wp.media.frames.file_frame = wp.media({

       title : 'Choose a profile picture',
       button : { 
                   text : 'Choose picture'

       },
       multiple : false

   	});

    mediauploader.on('select', function(){

    attachment = mediauploader.state().get('selection').first().toJSON();
    $('#profile_picture_url').val(attachment.url);
    $('#profile-picture-preview').css('background-image','url(' + attachment.url + ')');
     

    });

    mediauploader.open();

   });

});