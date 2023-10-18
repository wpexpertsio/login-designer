/**
 *
 *
 *
 *
 */

( function( $ ){
    wp.customize.bind( 'preview-ready', function(){
        wp.customize.preview.bind( 'password-protected-url-switcher', function( data ){
            if ( data.expanded ) {
                wp.customize.preview.send( 'url', password_protected_script.password_protected_page );
            }
        } );

        wp.customize.preview.bind( 'password-protected-back-to-home', function( data ){
            wp.customize.preview.send( 'url', data.home_url );
        } );
    } );

    function field_border_size() {
        return wp.customize( 'password_protected[field_border]' )();
    }
    function field_border_color() {
        return wp.customize( 'password_protected[field_border_color]' )();
    }
    function field_padding_top() {
        return wp.customize( 'password_protected[field_padding_top]' )();
    }
    function field_padding_bottom() {
        return wp.customize( 'password_protected[field_padding_bottom]' )();
    }
    function field_padding_left_right() {
        return wp.customize( 'password_protected[field_side_padding]' )();
    }

    // todo if not working remove this code.
    function field_background_color() {
        return wp.customize( 'password_protected[field_background_color]' )();
    }
    function field_box_shadow_opacity() {
        return wp.customize( 'password_protected[field_shadow_opacity]' )() * .01;
    }
    function field_box_shadow_size() {
        return wp.customize( 'password_protected[field_shadow]' )();
    }
    function field_box_shadow_inset() {
        return true === wp.customize( 'password_protected[field_shadow_inset]' )() ? 'inset' : '';
    }
    // todo if not working remove above code

    function live_font_family( control, style_element ) {
        wp.customize( control, function( value ){
            value.bind( function( to ){
                let el, style, old_stylesheet;

                if ( 'default' === to ) {
                    to = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Canterell, "Helvetica Neue", sans-serif';
                }

                control = control.replace( '[', '_' );
                control = control.replace( ']', '' );

                style = `<style class="${control}">${style_element} { font-family: ${to}; }</style>`;
                el = $( '.' + control );

                if ( el.length ) {
                    el.replaceWith( style );
                } else {
                    $( 'head' ).append( style )
                }

                if ( '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;' !== to && 'Times New Roman' !== to && 'Helvetica' !== to && 'Georgia' != to ) {
                    font_family = '?family=' + to;
                    stylesheet = $( `<link rel="stylesheet" id="password-protected-${control}" href="${password_protected_script.font_url + font_family + password_protected_script.font_subset}" type="text/css" media="all">` ).appendTo( 'head' );
                    old_stylesheet = $( '#password-protected-' + control );

                    if ( old_stylesheet.length ) {
                        old_stylesheet.replaceWith( stylesheet )
                    } else {
                        $( 'head' ).append( stylesheet )
                    }
                }
            } );
        } );
    }

    live_font_family( 'password_protected[label_font]', 'label:not([for=password_protected_rememberme])' );
    live_font_family( 'password_protected[button_font]', '#password-protected-submit-btn input' );
    live_font_family( 'password_protected[remember_font]', '#password-protected-forgetmenot label' );

    wp.customize( 'password_protected[label_font_size]', function( value ){
        value.bind( function( to ){
            let style, el;
            style = `<style class="password_protected_label_font_size"> #login form label:not([for=password_protected_rememberme]), #login .message { font-size: ${to}px }</style>`;
            el = $( '.password_protected_label_font_size' );

            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style )
            }
        } );
    } );

    wp.customize( 'password_protected[label_color]', function( value ){
        value.bind( function( to ){
            let style, el;
            style = `<style class="password_protected_label_font_color"> #login form label:not([for=password_protected_rememberme]), #login .message { color: ${to} } </style>`;
            el = $( '.password_protected_label_font_color' );

            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style );
            }
        } );
    } );

    wp.customize( 'password_protected[label_position]', function( value ){
        value.bind( function( to ){
            let style, el;
            style = `<style class="password_protected_label_position">.input { margin-top: ${to}px !important; } #login form div .passowrd-protected-event-button { top: ${to}px }</style>`;
            el = $( '.password_protected_label_position' );

            if ( el.length ) {
                el.replaceWith( style )
            } else {
                 $( 'head' ).append( style )
            }

        } );
    } );

    wp.customize( 'password_protected[password_label]', function( value ){
        value.bind( function ( to ){
            let style, el;

            $( 'label:not([for=password_protected_rememberme])').text( to )
        } );
    } );

    wp.customize( 'password_protected[field_background_color]', function( value ){
        value.bind( function( to ){
            let style, el;

            style = `<style class="password_protected_field_background_color_and_shadow">
                #password_protected_pass {
                    background-color: ${to} !important;
                    box-shadow: ${field_box_shadow_inset()} 0 0 ${field_box_shadow_size()}px rgba( 0,0,0, ${field_box_shadow_opacity()} ), inset 0 0 0 9999px ${to} !important;
                }
            </style>`;

            el = $( '.password_protected_field_background_color_and_shadow' );
            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style );
            }
        } );
    } );

    wp.customize( 'password_protected[field_border]', function( value ){
        value.bind( function( to ){
            let style, el;

            style = `<style class="password_protected_field_border">
                #password_protected_pass {
                    border: ${to}px solid !important;
                    border-color: ${field_border_color()} !important;
                }
            </style>`;

            el = $( '.password_protected_field_border' );
            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style  );
            }
        } );
    } );

    wp.customize( 'password_protected[field_border_color]', function( value ){
        value.bind( function( to ){
            let el, style;

            style = `<style class="password_protected_field_border">
                #password_protected_pass {
                    border: ${field_border_size()}px solid !important;
                    border-color: ${to} !important;
                }
            </style>`;

            el = $( '.password_protected_field_border' );

            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style );
            }
        } );
    } );

    wp.customize( 'password_protected[field_margin_bottom]', function( value ){
        value.bind( function( to ){
            let style, el;
            style = `<style class="password_protected_field_margin">
                #password_protected_pass {
                    margin-bottom: ${to}px !important;
                }
            </style>`;
            el = $( '.password_protected_field_margin' );

            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style )
            }
        } );
    } );

    wp.customize( 'password_protected[field_side_padding]', function( value ){
        value.bind( function( to ){
            let el, style;
            style = `<style class="password_protected_field_padding">
                #password_protected_pass {
                    padding-left: ${to}px !important;
                    padding-right: ${to}px !important;
                    padding-top: ${field_padding_top()}px !important;
                    padding-bottom: ${field_padding_bottom()}px !important;
                }
            </style>`;

            el = $( '.password_protected_field_padding' );
            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style )
            }
        } );
    } );

    wp.customize( 'password_protected[field_padding_top]', function( value ){
        value.bind( function( to ){
            let el, style;
            style = `<style class="password_protected_field_padding">
                #password_protected_pass {
                    padding-top: ${to}px !important;
                    padding-bottom: ${field_padding_bottom()}px !important;
                    padding-left: ${field_padding_left_right()}px !important;
                    padding-right: ${field_padding_left_right()}px !important;
                }
            </style>`;

            el = $( '.password_protected_field_padding' );
            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style )
            }
        } );
    } );

    wp.customize( 'password_protected[field_padding_bottom]', function( value ){
        value.bind( function( to ){
            let style, el;
            style = `<style class="password_protected_field_padding">
                #password_protected_pass {
                    padding-bottom: ${to}px !important;
                    padding-top: ${field_padding_top()}px !important;
                    padding-left: ${field_padding_left_right()}px !important;
                    padding-right: ${field_padding_left_right()}px !important;
                }
            </style>`;

            el = $( '.password_protected_field_padding' );
            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style );
            }
        } );
    } );

    wp.customize( 'password_protected[field_radius]', function( value ){
        value.bind( function( to ){
            let style, el;
            style = `<style class="password_protected_border_radius">
                #password_protected_pass {
                    border-radius: ${to}px !important;
                }
            </style>`;

            el = $( '.password_protected_border_radius' );

            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style );
            }
        } )
    } );

    wp.customize( 'password_protected[field_shadow]', function( value ){
        value.bind( function( to ){
            let style, el;

            style = `<style class="password_protected_field_background_color_and_shadow">
                #password_protected_pass {
                    background-color: ${field_background_color()} !important;
                    box-shadow: ${field_box_shadow_inset()} 0 0 ${to}px rgba( 0,0,0, ${field_box_shadow_opacity()} ), inset 0 0 0 9999px ${field_background_color()} !important;
                }
            </style>`;

            el = $( '.password_protected_field_background_color_and_shadow' );

            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style );
            }
        } );
    } );

    wp.customize( 'password_protected[field_shadow_opacity]', function( value ){
        value.bind( function( to ){
            let el, style;

            style = `<style class="password_protected_field_background_color_and_shadow">
                #password_protected_pass {
                    background-color: ${field_background_color()} !important;
                    box-shadow: ${field_box_shadow_inset()} 0 0 ${field_box_shadow_size()}px rgba( 0,0,0, ${to*.01} ), inset 0 0 0 9999px ${field_background_color()} !important;
                }
            </style>`;

            el = $( '.password_protected_field_background_color_and_shadow' );

            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style );
            }
        } );
    } );

    wp.customize( 'password_protected[field_shadow_inset]', function( value ){
        value.bind( function( to ){
            let el, style, inset;

            inset = true === to ? 'inset' : '';

            style = `<style class="password_protected_field_background_color_and_shadow">
                #password_protected_pass {
                    background-color: ${field_background_color()} !important;
                    box-shadow: ${inset} 0 0 ${field_box_shadow_size()}px rgba( 0,0,0, ${field_box_shadow_opacity()} ), inset 0 0 0 9999px ${field_background_color()} !important;
                }
            </style>`;

            el = $( '.password_protected_field_background_color_and_shadow' );

            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style );
            }
        } );
    } );

    wp.customize( 'password_protected[field_color]', function( value ){
        value.bind( function( to ){
            let style, el;

            style = `<style class="password_protected_field_color">
                #password_protected_pass {
                    color: ${to} !important;
                }
            </style>`;

            el = $( '.password_protected_field_color' );

            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style );
            }
        } );
    } );

    wp.customize( 'password_protected[field_font_size]', function( value ){
        value.bind( function( to ){
            let el, style;

            style = `<style class="password_protected_font_size">
                #password_protected_pass {
                    font-size: ${to}px !important;
                }
            </style>`;

            el = $( '.password_protected_font_size' );

            if ( el.length ) {
                el.replaceWith( style );
            } else {
                $( 'head' ).append( style );
            }
        } );
    } );

    function button_bg_color() {
        return wp.customize( 'password_protected[button_bg]' )();
    }
    function button_shadow() {
        return wp.customize( 'password_protected[button_shadow]' )();
    }
    function button_shadow_opacity() {
        return wp.customize( 'password_protected[button_shadow_opacity]' )();
    }
    function button_border_color(){
        return wp.customize( 'password_protected[button_border_color]' )();
    }
    function button_border(){
        return wp.customize( 'password_protected[button_border]' )();
    }
    function button_border_radius() {
        return wp.customize( 'password_protected[button_radius]' )();
    }
    function button_padding_top() {
        return wp.customize( 'password_protected[button_padding_top]' )();
    }
    function button_padding_bottom() {
        return wp.customize( 'password_protected[button_padding_bottom]' )();
    }
    function button_padding_left_right() {
        return wp.customize( 'password_protected[button_side_padding]' )();
    }

    wp.customize( 'password_protected[button_bg]', function( value ){
        value.bind( function( to ){
            let el, style;
            // todo add box shadow here
            style = `<style class="password_protected_button_bg_color_shadow">
                #password-protected-submit-btn input {
                    background-color: ${to} !important;
                    box-shadow: 0 0 ${button_shadow()}px rgba( 0,0,0, ${button_shadow_opacity()*.01} ) !important;
                }
            </style>`;

            el = $('.password_protected_button_bg_color_shadow');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        } );
    } );

    wp.customize('password_protected[button_border]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_button_border">
                    #password-protected-submit-btn input {
                        border: ${to}px solid ${button_border_color()} !important;
                        border-radius: ${button_border_radius()}px !important;
                    }
                </style>`;

            el = $('.password_protected_button_border');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[button_border_color]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_button_border">
                    #password-protected-submit-btn input {
                        border: ${button_border()}px solid ${to} !important;
                        border-radius: ${button_border_radius()}px !important;
                    }
                </style>`;

            el = $('.password_protected_button_border');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[button_side_padding]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_button_padding">
                    #password-protected-submit-btn input {
                        padding-left: ${to}px !important;
                        padding-right: ${to}px !important;
                        padding-top: ${button_padding_top()}px !important;
                        padding-bottom: ${button_padding_bottom()}px !important;
                    }
                </style>`;

            el = $('.password_protected_button_padding');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[button_padding_top]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_button_padding">
                    #password-protected-submit-btn input {
                        padding-left: ${button_padding_left_right()}px !important;
                        padding-right: ${button_padding_left_right()}px !important;
                        padding-top: ${to}px !important;
                        padding-bottom: ${button_padding_bottom()}px !important;
                    }
                </style>`;

            el = $('.password_protected_button_padding');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[button_padding_bottom]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_button_padding">
                    #password-protected-submit-btn input {
                        padding-left: ${button_padding_left_right()}px !important;
                        padding-right: ${button_padding_left_right()}px !important;
                        padding-top: ${button_padding_top()}px !important;
                        padding-bottom: ${to}px !important;
                    }
                </style>`;

            el = $('.password_protected_button_padding');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[button_radius]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_button_border">
                    #password-protected-submit-btn input {
                        border: ${button_border()}px solid ${button_border_color()} !important;
                        border-radius: ${button_border_radius()}px !important;
                    }
                </style>`;

            el = $('.password_protected_button_border');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[button_shadow]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_button_bg_color_shadow">
                #password-protected-submit-btn input {
                    background-color: ${button_bg_color()} !important;
                    box-shadow: 0 0 ${to}px rgba( 0,0,0, ${button_shadow_opacity()*.01} ) !important;
                }
                </style>`;

            el = $('.password_protected_button_bg_color_shadow');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[button_shadow_opacity]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_button_bg_color_shadow">
                #password-protected-submit-btn input {
                    background-color: ${button_bg_color()} !important;
                    box-shadow: 0 0 ${button_shadow()}px rgba( 0,0,0, ${to*.01} ) !important;
                }
                </style>`;

            el = $('.password_protected_button_bg_color_shadow');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[button_font_size]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_button_font_size">
                    #password-protected-submit-btn input {
                        font-size: ${to}px !important;
                    }
                </style>`;

            el = $('.password_protected_button_font_size');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[button_color]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_button_color">
                    #password-protected-submit-btn input {
                        color: ${to} !important;
                    }
                </style>`;

            el = $('.password_protected_button_color');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    function checkbox_border() {
        return wp.customize( 'password_protected[checkbox_border]' )();
    }
    function checkbox_border_color() {
        return wp.customize( 'password_protected[checkbox_border_color]' )();
    }
    function checkbox_border_radius() {
        return wp.customize( 'password_protected[checkbox_radius]' )();
    }

    wp.customize('password_protected[checkbox_size]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_font_size">
                    #password-protected-forgetmenot input {
                        width: ${to}px !important;
                        height: ${to}px !important;
                    }
                </style>`;

            el = $('.password_protected_font_size');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[checkbox_bg]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_checkbox_bg_color">
                    #password-protected-forgetmenot input {
                        background-color: ${to} !important;
                    }
                </style>`;

            el = $('.password_protected_checkbox_bg_color');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[checkbox_border]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_checkbox_border">
                    #password-protected-forgetmenot input {
                        border: ${to}px solid ${checkbox_border_color()} !important;
                        border-radius: ${checkbox_border_radius()}px !important;
                    }
                </style>`;

            el = $('.password_protected_checkbox_border');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[checkbox_border_color]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_checkbox_border">
                    #password-protected-forgetmenot input {
                        border: ${checkbox_border()}px solid ${to} !important;
                        border-radius: ${checkbox_border_radius()}px !important;
                    }
                </style>`;

            el = $('.password_protected_checkbox_border');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[checkbox_radius]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_checkbox_border">
                    #password-protected-forgetmenot input {
                        border: ${checkbox_border()}px solid ${checkbox_border_color()} !important;
                        border-radius: ${to}px !important;
                    }
                </style>`;

            el = $('.password_protected_checkbox_border');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[remember_font_size]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_remember_font_size">
                    #password-protected-forgetmenot label {
                        font-size: ${to}px !important;
                    }
                </style>`;

            el = $('.password_protected_remember_font_size');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[remember_position]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_remember_position">
                    #password-protected-forgetmenot {
                        margin-top: ${to}px !important;
                    }
                </style>`;

            el = $('.password_protected_remember_position');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[remember_color]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_remember_color">
                    #password-protected-forgetmenot label {
                        color: ${to} !important;
                    }
                </style>`;

            el = $('.password_protected_remember_color');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    function hasLogo() {
        let image = wp.customize( 'password_protected[logo]' )();
        return '' !== image;
    }
    function hasLogoAction( to, width, height ) {
        let style, el;

        el = $( '.password_protected_logo' );

        if ( hasLogo() ) {
            width  = width/2;
            height = height/2;

            $( '#password-protected-logo a' ).css( 'background-image', `url(${to})` );

            style = `<style class="password_protected_logo">
                #password-protected-logo a {
                    display: block !important;
                    background-size: ${width}px ${height}px !important;
                }
                #password-protected-logo {
                    width: ${width}px !important;
                    height: ${height}px !important;
                }
            </style>`;
        } else {
            style = `<style class="password_protected_logo">
                #password-protected-logo a,
                #password-protected-logo {
                    display: block;
                    width: 84px !important;
                    height: 84px !important;
                }
                
                #password-protected-logo a {
                    width: 84px !important;
                    height: 84px !important;
                    background-size: 84px !important;
                    background-image: none, url("${password_protected_script.admin_url}images/wordpress-logo.svg") !important;
                }
            </style>`;

            $( '#password-protected-logo a' ).css( 'background-image', `url("${password_protected_script.admin_url}images/wordpress-logo.svg")` );
        }

        console.log( style );
        console.dir( el );

        if ( el.length ) {
            el.replaceWith( style );
        } else {
            $( 'head' ).append( style );
        }
    }
    function logoHeight() {
        return wp.customize( 'password_protected[logo_height]' )();
    }
    function logoWidth() {
        return wp.customize( 'password_protected[logo_width]' )();
    }

    wp.customize('password_protected[logo]', function (value) {
        value.bind(function (to) {
            if ( to ) {
                var data = { action: 'get_logo_info', method: 'password_protected_form' };

                $.post( password_protected_script.ajax_url, data, function( response ){
                    hasLogoAction( response.url, response.width, response.height );
                    wp.customize.preview.send( 'pp-logo-sizes', { height: response.height, width: response.width } );
                } );
            } else {
                hasLogoAction( to, null, null );
            }
        });
    });

    wp.customize('password_protected[logo_url]', function (value) {
        value.bind(function (to) {
            $( '#password-protected-logo a' ).attr( 'href', to );
        });
    });

    wp.customize('password_protected[logo_width]', function (value) {
        value.bind(function (to) {


            let el, style;
            style = `<style class="password_protected_logo">
                    @media screen and ( min-width: 600px ) {
                        #password-protected-logo a {
                            background-size: ${to}px ${logoHeight()}px !important;
                        }
                        #password-protected-logo,
                        #password-protected-logo a {
                            width: ${to}px !important;
                            height: ${logoHeight()}px !important;
                        }
                    }
                </style>`;

            el = $('.password_protected_logo');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[logo_height]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_logo">
                    @media screen and ( min-width: 600px ) {
                        #password-protected-logo a {
                            background-size: ${logoWidth()}px ${to}px !important;
                        }
                        #password-protected-logo,
                        #password-protected-logo a {
                            width: ${logoWidth()}px !important;
                            height: ${to}px !important;
                        }
                    }
                </style>`;

            el = $('.password_protected_logo');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[logo_margin_bottom]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_logo_margin_bottom">
                    #password-protected-logo,
                    #password-protected-logo a {
                        margin-bottom: ${to}px !important;
                    }
                </style>`;

            el = $('.password_protected_logo_margin_bottom');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[disable_logo]', function (value) {
        value.bind(function (to) {
            let
                el,
                style;

            if ( to ) {
                style = `<style class="password_protected_logo_disable_logo">
                    #password-protected-logo a {
                        display: none !important;
                    }
                    #password-protected-logo,
                    #password-protected-logo a {
                        height: 0 !important;
                        width: 0 !important;
                    }
                </style>`;
            } else {
                style = `<style class="password_protected_logo_disable_logo">
                    #password-protected-logo a {
                        display: block !important;
                    }
                    #password-protected-logo {
                        height: ${logoHeight()}px;
                    }
                </style>`;
            }

            el = $('.password_protected_logo_disable_logo');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    function formSidePadding() {
        return wp.customize( 'password_protected[form_side_padding]' )();
    }
    function formVerticalPadding() {
        return wp.customize( 'password_protected[form_vertical_padding]' )();
    }
    function formBackgroundColor() {
        return wp.customize( 'password_protected[form_bg]' )();
    }
    function formShadow() {
        return wp.customize( 'password_protected[form_shadow]' )();
    }
    function formShadowOpacity() {
        return wp.customize( 'password_protected[form_shadow_opacity]' )();
    }

    wp.customize('password_protected[form_bg]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_form_background_color">
                    #password-protected-form {
                        background-color: ${to} !important;
                    }
                </style>`;

            el = $('.password_protected_form_background_color');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[form_radius]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_form_border">
                    #password-protected-form {
                        border-radius: ${to}px !important;
                    }
                </style>`;

            el = $('.password_protected_form_border');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[form_side_padding]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_form_padding">
                #password-protected-form {
                    padding-top: ${formVerticalPadding()}px !important;
                    padding-bottom: ${formVerticalPadding()}px !important;
                    padding-left: ${to}px !important;
                    padding-right: ${to}px !important;
                }
                </style>`;

            el = $('.password_protected_form_padding');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[form_vertical_padding]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_form_padding">
                #password-protected-form {
                    padding-top: ${to}px !important;
                    padding-bottom: ${to}px !important;
                    padding-left: ${formSidePadding()}px !important;
                    padding-right: ${formSidePadding()}px !important;
                }
                </style>`;

            el = $('.password_protected_form_padding');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[form_bg_transparency]', function (value) {
        value.bind(function (to) {
            let el, style;
            if ( to ) {
                style = `background-color: transparent !important;border:none !important;box-shadow:none !important;background: none !important;`;
            } else {
                style = `background-color: ${formBackgroundColor()} !important`;
            }
            style = `<style class="password_protected_form_background_color">
                    #password-protected-form {
                        ${style}
                    }
                </style>`;

            el = $('.password_protected_form_background_color');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[form_width]', function (value) {
        value.bind(function (to) {
            let el, style;

            style = `<style class="password_protected_form_bg_width">
                    #login {
                        width: ${to}px !important;
                    }
                </style>`;

            el = $('.password_protected_form_bg_width');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[form_shadow]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_form_shadow">
                    #password-protected-form {
                        box-shadow: 0 0 ${to}px rgba( 0, 0, 0, ${formShadowOpacity()*.01} ) !important;
                    }
                </style>`;

            el = $('.password_protected_form_shadow');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[form_shadow_opacity]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_form_shadow">
                    #password-protected-form {
                        box-shadow: 0 0 ${formShadow()}px rgba( 0, 0, 0, ${to*.01} ) !important;
                    }
                </style>`;

            el = $('.password_protected_form_shadow');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    function customBackground() {
        return wp.customize( 'password_protected[bg_image]' )();
    }

    wp.customize('password_protected[bg_image]', function (value) {
        value.bind(function (to) {
            $( '.login' ).css( 'background-image', 'none' );

            $( '#password-protected-background' ).addClass( 'transitioning' );

            setTimeout( function(){
                $( '#password-protected-background' ).css( 'background-image', `url(${to})` );
            }, 500 );

            setTimeout( function(){
                $( '#password-protected-background' ).removeClass( 'transitioning' );
            }, 550 );
        });
    });

    wp.customize('password_protected[bg_color]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_bg_color">
                    .login {
                        background-color: ${to} !important;
                    }
                </style>`;

            el = $('.password_protected_bg_color');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[bg_image_gallery]', function (value) {
        value.bind(function (to) {

            let url, values = [];

            if ( password_protected_script.extension_backgrounds ) {
                values = Object.values( password_protected_script.extension_backgrounds );
            }

            if ( values.includes( to ) ) {
                if ( to.indexOf( 'seasonal' ) >= 0 ) {
                    url = password_protected_script.seasonal_plugin_url;
                } else {
                    bg_collection = to.replace( /-|\s/g, "" );
                    bg_collection = bg_collection.replace( /[0-9]/g, '' );

                    url = password_protected_script.plugins_url + '/login-designer-' + bg_collection + '-backgrounds/assets/images/';
                }
            } else {
                url = password_protected_script.plugin_url;
            }

            if ( 'none' === to ) {
                $( '#password-protected-background' ).addClass( 'transitioning' );

                if ( customBackground() ) {
                    setTimeout( function(){
                        $( '#password-protected-background' ).css( 'background-image', `url("${customBackground()}")` );
                    }, 300 );

                    setTimeout( function(){
                        $( '#password-protected-background' ).removeClass( 'transitioning' );
                    }, 350 )
                } else {
                    $( '.login, #password-protected-background' ).css( 'background-image', 'none' );
                }
            } else if ( '' === to ) {
                $( '.login, #password-protected-background' ).css( 'background-image', 'none' );
            } else {
                $( '.login, #password-protected-background' ).css( 'background-image', 'none' );

                $( '#password-protected-background' ).addClass( 'transitioning' );

                setTimeout( function() {
                    $( '#password-protected-background' ).css( 'background-image', 'url( ' + url + to + '.jpg' + ')' );
                }, 300);

                setTimeout( function() {
                    $( '#password-protected-background' ).removeClass( 'transitioning' );
                }, 350 );
            }
        });
    });

    wp.customize('password_protected[bg_repeat]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_bg_repeat">
                .login, #password-protected-background {
                    background-repeat: ${to} 
                }
                </style>`;

            el = $('.password_protected_bg_repeat');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[bg_position]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_bg_position">
                    .login, #password-protected-background {
                        background-position: ${to};
                    }
                </style>`;

            el = $('.password_protected_bg_position');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[bg_attach]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_background">
                    .login, #password-protected-background {
                        background-attachment: ${to};
                    }
                </style>`;

            el = $('.password_protected_background');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize('password_protected[bg_size]', function (value) {
        value.bind(function (to) {
            let el, style;
            style = `<style class="password_protected_bg_size">
                .login, #password-protected-background {
                    background-size: ${to};
                }
                </style>`;

            el = $('.password_protected_bg_size');

            if (el.length) {
                el.replaceWith(style);
            } else {
                $('head').append(style);
            }
        });
    });

    wp.customize( 'password_protected[password_below_password_font_size]', function( value ) {
        value.bind( function( to ) {
            $( '.password-protected-text-below, .password-protected-text-above' )
                .css( 'font-size', to + 'px' );
        } );
    } );

    wp.customize( 'password_protected[password_below_password_position]', function( value ) {
        value.bind( function( to ) {
            $( '.password-protected-text-below' )
                .css( 'margin-top', to + 'px' );

            $( '.password-protected-text-above' )
                .css( 'margin-bottom', to + 'px' );
        } );
    } );

    wp.customize( 'password_protected[password_below_password_color]', function( value ) {
        value.bind( function( to ) {
            $( '.password-protected-text-below, .password-protected-text-above' )
                .css( 'color', to );
        } );
    } );

    wp.customize( 'password_protected[password_below_password_alignment]', function( value ) {
        value.bind( function( to ) {
            $( '.password-protected-text-below, .password-protected-text-above' )
                .css( 'text-align', to );
        } );
    } );

    live_font_family( 'password_protected[password_below_password_font]', '.password-protected-text-below, .password-protected-text-above' );
} )( jQuery );
