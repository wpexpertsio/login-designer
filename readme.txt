=== Custom Login Page Customizer - Login Designer ===
Author URI: @@pkg.author_uri
Plugin URI: @@pkg.plugin_uri
Contributors: richtabor, logindesigner, thatplugincompany, themebeans
Donate link: @@pkg.plugin_uri
Tags: @@pkg.tags
Requires at least: @@pkg.requires
Tested up to: @@pkg.tested_up_to
Requires PHP: 5.2.4
Stable tag: @@pkg.version
License: @@pkg.license
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Login Designer is the easiest way to style a custom login page for your WordPress login, register and forgot password forms, right from the live-action WordPress Customizer.

== Description ==

You shouldn’t have to hire a developer to customize your website's login page. That’s why I built [Login Designer](https://logindesigner.com?utm_medium=login-designer-lite&utm_source=readme&utm_campaign=readme&utm_content=login-designer), the best login customizer plugin for WordPress.

While Login Designer is not the first WordPress plugin designed for styling custom login pages, it offers an unrivaled live-editing experience unlike any other.

**Login Designer’s login customizing and templating experience is the best in class — _by a long shot_**.

= A short video =
[vimeo https://vimeo.com/243191812]

= An unparalleled custom login styling experience =

Zero refreshes. Contextually displayed options and plugin settings. Custom event triggers. Context-aware previews. Powerful custom controls. Live editing... the list goes on.

[Login Designer](https://logindesigner.com?utm_medium=login-designer-lite&utm_source=readme&utm_campaign=readme&utm_content=login-designer-is-a-beast) is a UX beast.

It’s familiar, yet completely revolutionary. Click on _any element_ from your login page to fine tune it. That element’s settings are contextually displayed, while other’s hide. This way, you'll spend less time navigating the Customizer’s sections and panels, and more time actually fine-tuning your website's login page. #winning

= Get started today =

Intrigued? _I bet you are._ Once you try Login Designer, every other Customizer experience will feel lackluster. Guaranteed.

Installation is free, fun, quick, and easy.

= Built with developers in mind =

Extensible, adaptable, and open source — Login Designer is created with developers in mind. There are opportunities for developers at all levels to contribute. [Click here to contribute](https://github.com/thatplugincompany/login-designer).

= Get started today =

This plugin is created and maintaned by [Rich Tabor](https://richtabor.com?utm_medium=login-designer-lite&utm_source=readme&utm_campaign=readme&utm_content=rich-tabor).

== Screenshots ==

1. Templates: Change your look in seconds

2. Editing: Add backgrounds, change colors — customize anything

3. Templates: Easily swap templates any time

4. Templates: Start with a template, then customize

== Installation ==

1. Upload the `login-designer` folder to your `/wp-content/plugins/` directory or alternatively upload the login-designer.zip file via the plugin page of WordPress by clicking 'Add New' and selecting the zip from your local computer.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Start customizing from the WordPress Customizer > Login Designer panel.

== Frequently Asked Questions ==

= How do I start customizing? =

You may easily navigate to the Login Designer editor via the **WordPress Dashboard > Apperance > Login Designer** link. Alternatively, you may view the editor by opening the **Login Designer** section within the Customizer.

= Is Login Designer free? =

Yes! Login Designer's core features are and always will be free.

= What themes work with Login Designer? =

Any properly developed WordPress theme will work with Login Designer. If you're looking for exceptional themes, check out my theme catalogue at [ThemeBeans](https://logindesigner.com?utm_medium=login-designer-lite&utm_source=readme&utm_campaign=readme&utm_content=themebeans).

= Is Login Designer translatable? =

Yes! Login Design is deployed with full translation and localization support via the 'login-designer' text-domain.

= Where can I ask for help? =

Please reach out via the official [plugin support forum](https://wordpress.org/support/plugin/login-designer).

== Changelog ==

= 1.1.5, February XX, 2017 =
* New:   Added new options for fine-tuning the "Log In" button display (padding-top and padding-bottom)
* New:   Added a new position setting for aligning the Login Designer logo to the left or right
* Fix:   Fixed an issue where the accreditation link obscursed content on smaller viewports
* Fix:   Modified button radius values now properly return
* Tweak: Added a Login Designer action to the Customizer admin bar item
* Tweak: Added a migration sequence for the depreciated button height setting
* Tweak: Adjusted the button's customizer event overlay to display properly regardless of the button size
* Tweak: Touched up the background image uploader control UI
* Tweak: The settings icon is now hidden when the settings are viewed

= 1.1.4, February 06, 2017 =
* Fix:   Fixed an issue where the Login Designer mark did not properly hide within the Customizer
* Tweak: Username and password labels now stay hidden when text labels are removed
* Tweak: Adjusted field margin bottom to work properly

= 1.1.3, February 05, 2017 =
* Fix:   Rewrote the Login Designer Customizer view to resolve known plugin compatibility issues
* Fix:   Resolved an issue where the form bottom positioning "jumped" when triggered in the Customizer
* Fix:   Added proper translatable text for the plugin's guided intro
* Tweak: Improved the style of the form bottom edit trigger
* Tweak: Added better style prefixing with Customizer UI elements to improve theme incompatibilities
* Tweak: Removed unnecessary styles/scripts and cleaned up the /assets/ folder
* Tweak: Sprite display within the Customizer
* Tweak: Improved asset delivery and minification

= 1.1.2, January 26, 2017 =
* Fix:   Resolved the sprite display issue within the Customizer

= 1.1.1, January 23, 2017 =
* Fix:   Custom positioning on the "remember me" checkbox now works properly
* Tweak: Added minor Customizer UI tweaks
* Tweak: Added appropriate prefixes to combat theme incompatibilities
* Tweak: Added a proper is_customize_preview check for the Login Designer badge

= 1.1.0, January 22, 2017 =
* Fix:   Resolved an issue where the Login Designer badge was not displaying properly

= 1.0.9, January 22, 2017 =
* New:   Added an optional "Powered by Login Designer" badge to display on login pages
* New:   Added options to customize the colors of the new "Powered by" badge
* Tweak: Removed the Login Designer template from the Page Attributes dropdown
* Tweak: Added additional checks for the login_designer_page value

= 1.0.8, January 09, 2017 =
* New:   Added an introduction tour for first-time users
* New:   Editing the Login Designer page now pulls up the Customizer view
* New:   Viewing the Login Designer page, when logged in, now also pulls up the Customizer view
* Fix:   Login Designer now plays nicely on multisite installations
* Tweak: Improved template creation process during installation
* Tweak: View the Login Designer page now redirects to the Login Designer Customizer page
* Tweak: Added a new admin warning for when a user attempts to delete the Login Designer page

= 1.0.7, December 21, 2017 =
* Fix:   Resolved an issue where the Login Designer template page would not resolve properly for some folks
* Fix:   The Login Designer template page now removes itself if the plugin is uninstalled
* Tweak: Minor mobile responsive improvements for Template 01
* Tweak: Minor PHPCS improvements

= 1.0.6, December 16, 2017 =
* Tweak: Adjusted checkbox input checked styling

= 1.0.5, December 15, 2017 =
* New:   Logo width and height sizing feature with auto-sizing fallback
* New:   Transparent form background toggle
* Fix:   Resolved an issue with templates that use transparent backgrounds
* Fix:   Adding spacing between the logo and the form now works properly
* Tweak: Improved the UX across the board, making the app much faster overall
* Tweak: Updated the background styler icon
* Tweak: Improved login form rendering on mobile devices
* Tweak: Custom logos now stick around when you change templates
* Tweak: Conducted minor PHPCS code fixes
* Tweak: Minor template markup touchups

= 1.0.4, December 8, 2017 =
* Tweak: Removed getimagesize dependancy for the custom logo sizing

= 1.0.3, November 17, 2017 =
* Tweak: Improved webkit shadow styling

= 1.0.2, November 17, 2017 =
* Fix:   Resolved issue where inline sprites would cause Template 02 to display oddly in the Customizer
* Tweak: Added support to carry over template styles on the lost password form
* Tweak: Improved template rendering
* Tweak: Removed package version info from plugin files
* Tweak: Updated readme

= 1.0.1, November 16, 2017 =
* Tweak: Removed activation redirection

= 1.0.0, November 16, 2017 =
* Initial release on WordPress.org. Enjoy!
