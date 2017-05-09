(function ($) {
    "use strict";

    $(document).ready(function ($) {
    	
        $('.layout-switcher').on('click', function (e) {

            e.preventDefault();

            $('.layout-switcher__wrapper').toggleClass( 'open' );

            if ($(this).text() === 'Install New Template') {
                 $(this).text('Close');
            }
            else {
                $(this).text('Install New Template');
            }

        });

    });

})(jQuery);