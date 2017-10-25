jQuery(document).ready(function($){

//loading and customizing wp native media uploader
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



   //removing profile picture

   $('#remove-picture').on('click',function(e){
    e.preventDefault();
    var answer = confirm("Are you sure you want to remove your Profile Picture?");
    if( answer == true ){
      $('#profile_picture_url').val('');
      $('.sunset-general-form').submit();
    }
    return;
  });


    //ace initiation
    var editor = ace.edit("customCss");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/css");

    //transferring ace editor value to textarea and submiting the form
    var updateCSS = function(){ $("#sunset_css").val( editor.getSession().getValue() ); }
    $("#save-custom-css-form").submit( updateCSS );

});



