/**
 * FAQs Short code button
 */

( function() {
     tinymce.create( 'tinymce.plugins.faq', {
        init : function( ed, url ) {
             ed.addButton( 'faq', {
                title : 'Insert FAQs',
                image : url + '/ed-icons/faq.png',
                onclick : function() {
						var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'FAQs Options', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sc-faq-form' );
                 }
             });
         },
         createControl : function( n, cm ) {
             return null;
         },
     });
	tinymce.PluginManager.add( 'faq', tinymce.plugins.faq );
	jQuery( function() {
		var form = jQuery( '<div id="sc-faq-form"><table id="sc-faq-table" class="form-table">\
							<tr>\
							<th><label for="sc-faq-num">Number of faq</label></th>\
							<td><input type="text" name="sc-faq-num" id="sc-faq-num" value="-1" /><small> (-1 to show all.)</small></td>\
							</tr>\
							</table>\
							<p class="submit">\
							<input type="button" id="sc-faq-submit" class="button-primary" value="Insert FAQs" name="submit" />\
							</p>\
							</div>' );
		var table = form.find( 'table' );
		form.appendTo( 'body' ).hide();
		form.find( '#sc-faq-submit' ).click( function() {
			var numberposts = table.find( '#sc-faq-num' ).val(),
			shortcode = '[faq numberposts="' + numberposts + ']';

			tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
			tb_remove();
		} );
	} );
 } )();