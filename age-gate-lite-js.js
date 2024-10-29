(function( $ ) {
    $(function() {
      jQuery(document).ready(function($){
        var mediaUploader;
        $('#upload_agl_logo_button').click(function(e) {
          e.preventDefault();
            if (mediaUploader) {
            mediaUploader.open();
            return;
          }
          mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
            text: 'Choose Image'
          }, multiple: false });
          mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#agl_logo_img').val(attachment.url);
            $('#image-preview').attr('src', attachment.url);
            $('.image-preview-wrapper').show();
          });
          mediaUploader.open();
        });
        $('#remove_agl_logo_button').click(function() {
            $('#agl_logo_img').val('');
            $('.image-preview-wrapper').hide();
            return false;
        });
        $( '.agl-color-picker' ).wpColorPicker();
      });         
    });
})( jQuery );