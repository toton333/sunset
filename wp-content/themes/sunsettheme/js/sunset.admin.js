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

   $('#remove-picture').on('click',function(e){
    e.preventDefault();
    var answer = confirm("Are you sure you want to remove your Profile Picture?");
    if( answer == true ){
      $('#profile_picture_url').val('');
      $('.sunset-general-form').submit();
    }
    return;
  });


});