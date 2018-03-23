( function( $, api ) {

	api.controlConstructor['login-designer-templates'] = api.Control.extend( {

		ready: function() {
			var control = this;

			this.container.on( 'change', 'input:radio', function() {
				control.setting.set( $( this ).val() );
			} );
		}
	} );

} )( jQuery, wp.customize );