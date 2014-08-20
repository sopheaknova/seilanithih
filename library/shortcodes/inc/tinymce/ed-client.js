/**
 * Client Short code button
 */

( function() {
     tinymce.create( 'tinymce.plugins.client', {
        init : function( ed, url ) {
             ed.addButton( 'client', {
                title : 'Insert client',
                image : url + '/ed-icons/biography.png',
                onclick : function() {
						var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Client Options', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sc-client-form' );
                 }
             });
         },
         createControl : function( n, cm ) {
             return null;
         },
     });
	tinymce.PluginManager.add( 'client', tinymce.plugins.client );
	jQuery( function() {
		var form = jQuery( '<div id="sc-client-form"><table id="sc-client-table" class="form-table">\
							<tr>\
							<th><label for="sc-client-style">client box style</label></th>\
							<td><select name="style" id="sc-client-style">\
							<option value="light">Light</option>\
							<option value="dark">Dark</option>\
							</select><br />\
							<small>Select a style for client.</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-client-num">Number of client</label></th>\
							<td><input type="text" name="sc-client-num" id="sc-client-num" value="10" /><small> (-1 to show all.)</small></td>\
							</tr>\
							</table>\
							<p class="submit">\
							<input type="button" id="sc-client-submit" class="button-primary" value="Insert Clients" name="submit" />\
							</p>\
							</div>' );
		var table = form.find( 'table' );
		form.appendTo( 'body' ).hide();
		form.find( '#sc-client-submit' ).click( function() {
			var value = table.find( '#sc-client-style' ).val(),
			numberposts = table.find( '#sc-client-num' ).val(),
			shortcode = '[client style="' + value + '"';
			shortcode += ' numberposts="' + numberposts + '"';
			shortcode += ']';

			tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
			tb_remove();
		} );
	} );
 } )();