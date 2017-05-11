/**
 * Customizer Live Previewer.
 */
( function ( wp, $ ) {
    "use strict";

    // // Bail if the customizer isn't initialized
    if ( ! wp || ! wp.customize ) {
        return;
    }

    var api = wp.customize, OldPreview;

    // Custom Customizer Preview class (attached to the Customize API).
    api.LoginlyCustomizerPreview = {

        init: function () {
        	// Store a reference to "this"
            var self = this;

            // When the previewer is active, the "active" event has been triggered (on load).
            this.preview.bind( 'active', function() {
                
                // Store references to the body and document elements.
                var $body = $( 'body'), $document = $( document ); 

                // Variables for live events.
                var $hfeed_products = $( '.site-title' );
               
                // Products: Open Style Editor
                $hfeed_products.append( '<button class="loginly-event-button customizer-editlayout-button customizer-open-widgetarea" data-customizer-event="loginly__open-styles-section">Edit</button>' );

                // Listen for events on the new previewer buttons.
                $document.on( 'touch click', '.loginly-event-button', function( e ) {
                    var $this = $( this );
                    // Send the event that we've specified on the HTML5 data attribute ('data-customizer-event') to the Customizer.
                    self.preview.send( $this.attr( 'data-customizer-event' ) );
                } );

            } );
        }
    };

    /**
     * Capture the instance of the Preview since it is private (this has changed in WordPress 4.0).
     *
     * @see https://github.com/WordPress/WordPress/blob/5cab03ab29e6172a8473eb601203c9d3d8802f17/wp-admin/js/customize-controls.js#L1013
     */
    OldPreview = api.Preview;
    api.Preview = OldPreview.extend( {
        initialize: function( params, options ) {
            // Store a reference to the Preview.
            api.LoginlyCustomizerPreview.preview = this;
            // Call the old Preview's initialize function.
            OldPreview.prototype.initialize.call( this, params, options );
        }
    } );

    $( function () {
        // Initialize our Preview.
        api.LoginlyCustomizerPreview.init();
    } );
} )( window.wp, jQuery );