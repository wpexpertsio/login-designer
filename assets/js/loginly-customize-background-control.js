( function( api ) {

	/**
	 * Class extends the UploadControl
	 */
	api.controlConstructor['background-image'] = api.UploadControl.extend( {

		ready: function() {

			// Re-use ready function from parent class to set up the image uploader
			var image_url = this;
			image_url.setting = this.settings.image_url;
			api.UploadControl.prototype.ready.apply( image_url, arguments );

			// Set up the new controls
			var control = this;

			control.container.addClass( 'customize-control-image' );

			control.container.on( 'click keydown', '.remove-button',
				function() {
					jQuery( '.background-image-fields' ).hide();
				}
			);

			control.container.on( 'change', '.background-image-repeat select',
				function() {
					control.settings['repeat'].set( jQuery( this ).val() );
				}
			);

			control.container.on( 'change', '.background-image-size select',
				function() {
					control.settings['size'].set( jQuery( this ).val() );
				}
			);

			control.container.on( 'change', '.background-image-attach select',
				function() {
					control.settings['attach'].set( jQuery( this ).val() );
				}
			);

			control.container.on( 'change', '.background-image-position select',
				function() {
					control.settings['position'].set( jQuery( this ).val() );
				}
			);

		},

		/**
		 * Callback handler for when an attachment is selected in the media modal.
		 * Gets the selected image information, and sets it within the control.
		 */
		select: function() {

			var attachment = this.frame.state().get( 'selection' ).first().toJSON();
			this.params.attachment = attachment;
			this.settings['image_url'].set( attachment.url );
			this.settings['image_id'].set( attachment.id );

		},

	} );

} )( wp.customize );