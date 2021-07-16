jQuery(document).ready( function(){
	
	var __ = wp.i18n.__
	var domain = 'numazu-no-takara-100sen';
	
	function media_upload( button_class ) {
	    var _custom_media = true,
	        _orig_send_attachment = wp.media.editor.send.attachment;
	    jQuery('body').on('click', button_class, function(e) {
	        var button_id ='#'+jQuery(this).attr( 'id' );
	        var button_id_s = jQuery(this).attr( 'id' );
	        var self = jQuery(button_id);
	        var send_attachment_bkp = wp.media.editor.send.attachment;
	        var button = jQuery(button_id);
	        _custom_media = true;
	        
// 	        console.log(button_id_s);
	        				
	        wp.media.editor.send.attachment = function(props, attachment ){
	            if ( _custom_media ) {
	                jQuery( '.' + button_id_s + '_media_url' ).val(attachment.url);
	                jQuery( '.' + button_id_s + '_media_image' ).attr( 'src', attachment.url).css( 'display','block' );
	                jQuery( '.' + button_id_s + '_media_image' ).parent().removeClass( 'noimage' );
	                jQuery( '.' + button_id_s + '_delete' ).css( 'display','block' );
	                jQuery( '.' + button_id_s + '_delete_message' ).css( 'display','none' );
	            } else {
	                return _orig_send_attachment.apply( button_id, [props, attachment] );
	            }
	        }
	        wp.media.editor.open(button);
	        return false;
	    });
	}
	media_upload( '.kn_custom_media_upload' );
	
	function media_delete( button_class, alert_message ) {
	    jQuery('body').on('click', button_class, function(e) {
		    var button_id_s = jQuery(this).attr( 'id' );
	        var button_id_s = button_id_s.replace('_delete', '');
	        if( jQuery( '.' + button_id_s + '_media_url' ).val() != '' ) {
				if (!confirm(alert_message)) {
					return false;
				} else {
	                jQuery( '.' + button_id_s + '_media_url' ).val('');
	                jQuery( '.' + button_id_s + '_media_image' ).attr( 'src', '').css( 'display','none' );
	                jQuery( '.' + button_id_s + '_media_image' ).parent().addClass( 'noimage' );
	                jQuery( '.' + button_id_s + '_delete' ).css( 'display','none' );
	                jQuery( '.' + button_id_s + '_delete_message' ).css( 'display','block' );
		            return false;
				}
			}
	    });
	}
	media_delete( '.kn_custom_media_delete', __( 'Do you want to delete the image?', domain ) );
});