/**
 * hr Short code button
 */

( function() {
     tinymce.create( 'tinymce.plugins.exchange', {
        init : function( ed, url ) {
             ed.addButton( 'exchange', {
                title : 'Insert Exchange',
                image : url + '/ed-icons/dollar.png',
                onclick : function() {
                	var shortcode = '[exchange]';
                	tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
                }
             });
         },
		createControl : function( n, cm ) {
		 return null;
		},
     });
	
	tinymce.PluginManager.add( 'exchange', tinymce.plugins.exchange );

 } )();