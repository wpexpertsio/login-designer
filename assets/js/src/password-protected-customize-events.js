/**
 *
 */

( function( exports, $ ){
    "use strict";
    var api = wp.customize, passwordProtectedOldPreview;
    var all_controls = {
        'logo': [
            'password_protected[logo]',
            'password_protected[logo_title]',
            'password_protected[logo_width]',
            'password_protected[logo_height]',
            'password_protected[logo_margin_bottom]',
            'password_protected[logo_url]',
            'password_protected[disable_logo]',
        ],
        'password_label': [
            'password_protected[password_label]',
            'password_protected[label_font]',
            'password_protected[label_font_size]',
            'password_protected[label_position]',
            'password_protected[label_color]',
        ],
        'password_field': [
            'password_protected[field_background_color]',
            'password_protected[field_border]',
            'password_protected[field_border_color]',
            'password_protected[field_margin_bottom]',
            'password_protected[field_side_padding]',
            'password_protected[field_padding_top]',
            'password_protected[field_padding_bottom]',
            'password_protected[field_radius]',
            'password_protected[field_shadow]',
            'password_protected[field_shadow_opacity]',
            'password_protected[field_shadow_inset]',
            'password_protected[field_font]',
            'password_protected[field_font_size]',
            'password_protected[field_color]',
        ],
        'button_styles': [
            'password_protected[button_bg]',
            'password_protected[button_border]',
            'password_protected[button_border_color]',
            'password_protected[button_side_padding]',
            'password_protected[button_padding_top]',
            'password_protected[button_padding_bottom]',
            'password_protected[button_radius]',
            'password_protected[button_shadow]',
            'password_protected[button_shadow_opacity]',
            'password_protected[button_text_title]',
            'password_protected[button_font]',
            'password_protected[button_font_size]',
            'password_protected[button_color]',
        ],
        'remember_cb': [
            'password_protected[remember_font]',
            'password_protected[remember_font_size]',
            'password_protected[remember_position]',
            'password_protected[remember_color]',
        ],
        'remember_me': [
            'password_protected[checkbox_size]',
            'password_protected[checkbox_bg]',
            'password_protected[checkbox_border]',
            'password_protected[checkbox_border_color]',
            'password_protected[checkbox_radius]',
        ],
        'form_background': [
            'password_protected[form_bg]',
            'password_protected[form_radius]',
            'password_protected[form_shadow]',
            'password_protected[form_shadow_opacity]',
            'password_protected[form_side_padding]',
            'password_protected[form_bg_transparency]',
            'password_protected[form_vertical_padding]',
            'password_protected[form_width]',
        ],
        'custom_text_for_password_field': [
            'password_protected[password_below_password_font]',
            'password_protected[password_below_password_font_size]',
            'password_protected[password_below_password_position]',
            'password_protected[password_below_password_color]',
        ],
    };

    function active_control( section ) {
        all_controls.logo.forEach( function( item, index, array ){
            control_visibility( all_controls.logo, 'deactivate' );
        } );

        all_controls.password_label.forEach( function( item, index, array ){
            control_visibility( all_controls.password_label, 'deactivate' );
        } );

        all_controls.password_field.forEach( function( item, index, array){
            control_visibility( all_controls.password_field, 'deactivate' );
        } );

        all_controls.form_background.forEach( function( item, index, array ){
            control_visibility( all_controls.form_background, 'deactivate' );
        } );

        all_controls.custom_text_for_password_field.forEach( function( item, index, array ) {
            control_visibility( all_controls.custom_text_for_password_field, 'deactivate' );
        } );
    }

    function customizer_image_option_display( parent_setting, affected_control ) {
        wp.customize( parent_setting, function( setting ) {
            wp.customize.control( affected_control, function( control ) {
                var visibility = function() {
                    if ( setting.get() && 'none' !== setting.get() && '0' !== setting.get() ) {
                        control.activate( { duration: 0 } );
                        control.container.slideDown( 0 );
                    } else {
                        control.container.slideUp( 0 );
                        control.deactivate( { duration: 0 } );
                    }
                };

                visibility();
                setting.bind( visibility );
            });
        });
    }

    function customizer_checkbox_option_display( parent_setting, affected_control, value ) {
        wp.customize( parent_setting, function( setting ){
            wp.customize.control( affected_control, function( control ){
                var visibility = function(){
                    if ( value === setting.get() ) {
                        control.container.slideDown( 0 );
                    } else {
                        control.container.slideUp( 0 );
                    }
                };

                visibility();
                setting.bind( visibility );
            } );
        } );
    }

    function control_visibility( controls, action ) {
        controls.forEach( function( item, index, array ){
            if ( 'activate' === action ) {
                if ( 'password_protected[logo_margin_bottom]' === item ) {
                    customizer_checkbox_option_display( 'password_protected[disable_logo]', 'password_protected[logo_margin_bottom]', false );

                    wp.customize( 'password_protected[disable_logo]', function( setting ){
                        wp.customize.control( item, function( control ){
                            var visibility = function(){
                                if ( true === setting.get() ) {
                                    control.container.slideUp( 0 );
                                } else {
                                    wp.customize.control( item ).activate( { duration: 0 } );
                                }
                            };

                            visibility();
                            setting.bind( visibility );
                        } );
                    } );
                } else if ( 'password_protected[logo_height]' === item ) {
                    customizer_image_option_display( 'password_protected[logo]', 'password_protected[logo_height]' );

                    wp.customize( 'password_protected[disable_logo]', function( setting ){
                        wp.customize.control( item, function( control ){
                            var visibility = function(){
                                if ( true === setting.get() ) {
                                    wp.customize.control.deactivate( { duration: 0 } );
                                } else {
                                    if ( wp.customize.control( 'password_protected[logo]' ).setting.get() ) {
                                        wp.customize.control( item ).activate( { duration: 0 } );
                                    }
                                }
                            };

                            visibility();
                            setting.bind( visibility )
                        } )
                    } );

                    wp.customize( 'password_protected[logo]', function( setting ){
                        wp.customize.control( item, function( control ){
                            var visibility = function(){
                                if ( setting.get() ) {
                                    wp.customize.control( item ).activate( { duration: 0 } );
                                } else {
                                    wp.customize.control( item ).deactivate( { duration: 0 } );
                                }
                            };

                            visibility();
                            setting.bind( visibility );
                        } );
                    } );
                } else if ( 'password_protected[logo_width]' ) {
                    customizer_image_option_display( 'password_protected[logo]', 'password_protected[logo_width]' );

                    wp.customize( 'password_protected[disable_logo]', function( setting ){
                        wp.customize.control( item, function( control ){
                            var visibility = function(){
                                if ( true === setting.get() ) {
                                    wp.customize.control( item ).deactivate( { duration: 0  } );
                                } else {
                                    if ( wp.customize.control( 'password_protected[logo]' ).setting.get() ) {
                                        wp.customize.control( item ).activate( { duration: 0 } );
                                    }
                                }
                            };

                            visibility();
                            setting.bind( visibility );
                        } );
                    } );

                    wp.customize( 'password_protected[logo]', function( setting ){
                        wp.customize.control( item, function( control ){
                            if ( setting.get() ) {
                                wp.customize.control( item ).activate( { duration: 0 } );
                            } else {
                                wp.customize.control( item ).deactivate( { duration: 0 } );
                            }
                        } );
                    } );
                } else if ( item === 'password_protected[logo]' ) {
                    customizer_checkbox_option_display( 'password_protected[disable_logo]', 'password_protected[logo]', false );

                    wp.customize( 'password_protected[disable_logo]', function( setting ) {
                        wp.customize.control( item, function( control ) {
                            var visibility = function() {

                                if ( setting.get() ) {
                                    // If not, let's quickly hide it.
                                    control.container.slideUp( 0 );
                                } else {
                                    // If there's no custom background image, let's show the gallery.
                                    wp.customize.control( item ).activate( { duration: 0 } );
                                }
                            };

                            visibility();
                            setting.bind( visibility );
                        });
                    });
                } else if ( 'password_protected[logo_title]' ) {
                    customizer_checkbox_option_display( 'password_protected[disable_logo]', 'password_protected[logo_title]', false );

                    wp.customize( 'password_protected[disable_logo]', function( setting ) {
                        wp.customize.control( item, function( control ) {
                            var visibility = function() {

                                if ( setting.get() ) {
                                    // If not, let's quickly hide it.
                                    control.container.slideUp( 0 );
                                } else {
                                    // If there's no custom background image, let's show the gallery.
                                    wp.customize.control( item ).activate( { duration: 0 } );
                                }
                            };

                            visibility();
                            setting.bind( visibility );
                        });
                    });
                } else if ( item === 'password_protected[logo_url]' ) {

                    customizer_checkbox_option_display( 'password_protected[disable_logo]', 'password_protected[logo_url]', false );

                    wp.customize( 'password_protected[disable_logo]', function( setting ) {
                        wp.customize.control( item, function( control ) {
                            var visibility = function() {

                                if ( setting.get() ) {
                                    // If not, let's quickly hide it.
                                    control.container.slideUp( 0 );
                                } else {
                                    // If there's no custom background image, let's show the gallery.
                                    wp.customize.control( item ).activate( { duration: 0 } );
                                }
                            };

                            visibility();
                            setting.bind( visibility );
                        });
                    });

                } else if ( 'password_protected[password_label]' === item ) {

                } else if ( 'password_protected[password_bellow_password_field]' === item ) {
                    debugger;
                } else if ( 'password_protected[password_above_password_field]' === item ) {
                    debugger;
                }
            }
        } );
    }

    api.PasswordProtectedCustomizerPreview = {
        init() {
            var
                self = this,
                active_state,
                logo_event = 'password-protected-edit-logo',
                password_label = 'password-protected-edit-label',
                password_field = 'password-protected-edit-field',
                submit_btn = 'password-protected-edit-button',
                remember_cb = 'password-protected-edit-rememberme-checkbox',
                rememberme = 'password-protected-edit-rememberme-label',
                form_bg = 'password-protected-edit-form-background',
                text_above_password_field = 'password-protected-edit-text-above',
                text_below_password_field = 'password-protected-edit-text-below';

            function bind_control_visibility_event( event, active_controls, focus_control ){
                api.PasswordProtectedCustomizerPreview.preview.bind( event, function(){
                    active_control( active_controls );
                    wp.customize.control( focus_control ).focus();
                } );
            }

            function bind_logo_control_visibility_event( event, active_controls, focus_controls ){
                api.PasswordProtectedCustomizerPreview.preview.bind( event, function(){
                    active_control( active_controls );
                    wp.customize.control( focus_controls ).focus();

                    if ( wp.customize.control( 'password_protected[disable_logo]' ).setting.get() ) {
                        wp.customize.control( 'password_protected[logo_width]' ).deactivate( { duration: 0 } );
                        wp.customize.control( 'password_protected[logo_height]' ).deactivate( { duration: 0 } );
                    }
                } );
            }

            bind_logo_control_visibility_event( logo_event, all_controls.logo, 'password_protected[logo]' );
            bind_control_visibility_event( password_label, all_controls.password_label, 'password_protected[password_label]' );
            bind_control_visibility_event( password_field, all_controls.password_label, 'password_protected[field_background_color]' );
            bind_control_visibility_event( submit_btn, all_controls.button_styles, 'password_protected[button_bg]' );
            bind_control_visibility_event( rememberme,   all_controls.remember_me, 'password_protected[remember_font]' );
            bind_control_visibility_event( remember_cb, all_controls.remember_cb, 'password_protected[checkbox_size]' );
            bind_control_visibility_event( form_bg, all_controls.form_background, 'password_protected[form_bg]' );
            bind_control_visibility_event( text_above_password_field, all_controls.custom_text_for_password_field, 'password_protected[password_below_password_font]' );
            bind_control_visibility_event( text_below_password_field, all_controls.custom_text_for_password_field, 'password_protected[password_below_password_font]' );
        }
    };

    passwordProtectedOldPreview = api.Previewer;
    api.Previewer = passwordProtectedOldPreview.extend( {
        initialize( params, options ){
            api.PasswordProtectedCustomizerPreview.preview = this;
            passwordProtectedOldPreview.prototype.initialize.call( this, params, options );
        }
    } );

    $( function(){
        api.PasswordProtectedCustomizerPreview.init();
    } );
} )( wp, jQuery );