
jQuery(function($) {
	(function() {
		var ed_btn_img_url = '/../../../images/';
		// prepare box for input content


		tinymce.create('tinymce.plugins.Wpi_post_editor', {
			init : function(ed, url) {
				// Contact
				ed.addButton('contact', {
					title : 'Contact Form',
					cmd : 'contact',
					image : url + ed_btn_img_url + 'contact.png'
				});

				ed.addCommand('contact', function() {
					var target_email = prompt('Input your target email (optional)');
					$ret = '[contact/]';
					if (target_email) {
						$ret = '[contact target_email = "'+target_email+'"/]';
					}
					ed.execCommand('mceInsertContent', 0, $ret);
				});
				
			},
		});
		// Register plugin
		tinymce.PluginManager.add( 'wpi_post_editor', tinymce.plugins.Wpi_post_editor );
	})();
});