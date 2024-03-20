<?php
/**
 * Template Name: Login Designer
 *
 * Template to display the WordPress login form in the Customizer.
 * This is essentially a stripped down version of wp-login.php, though not accessible from outside the Customizer.
 *
 * @package Login Designer
 */

$login_designer_template = get_option( 'login_designer', array( 'template' => 'default' ) );
$languages               = get_available_languages();

// Redirect if viewed from outside the Customizer.
if ( ! is_customize_preview() ) {

	// Pull the Login Designer page from options.
	$logindesigner_page = get_permalink( Login_Designer()->get_login_designer_page() );

	// Generate the redirect url.
	$logindesigner_url = add_query_arg(
		array(
			'autofocus[section]' => 'login_designer__section--templates',
			'return'             => admin_url( 'index.php' ),
			'url'                => rawurlencode( $logindesigner_page ),
		),
		admin_url( 'customize.php' )
	);

	wp_safe_redirect( $logindesigner_url );
}

/**
 * Output the login page header.
 *
 * @param string   $title    Optional. WordPress login Page title to display in the `<title>` element.
 *                           Default 'Log In'.
 * @param string   $message  Optional. Message to display in header. Default empty.
 * @param WP_Error $wp_error Optional. The error to pass. Default empty.
 */
function logindesigner_login_header( $title = 'Log In', $message = '', $wp_error = '' ) {
	global $error, $action;

	// Don't index any of these forms.
	add_action( 'login_head', 'wp_no_robots' );

	if ( empty( $wp_error ) ) {
		$wp_error = new WP_Error();
	}

	$login_title = get_bloginfo( 'name', 'display' );

	/* translators: Login screen title. 1: Login screen name, 2: Network or site name */
	$login_title = sprintf( __( '%1$s &lsaquo; %2$s &#8212; WordPress', 'login-designer' ), $title, $login_title );
	/**
	 * Filters the title tag content for login page.
	 *
	 * @since 4.9.0
	 *
	 * @param string $login_title The page title, with extra context added.
	 * @param string $title       The original page title.
	 */
	$login_title = apply_filters( 'login_title', $login_title, $title );
	?><!DOCTYPE html>
	<head>
	<title><?php echo esc_attr( $login_title ); ?></title>
	<?php
	wp_enqueue_style( 'login' );

	/**
	 * Enqueue scripts and styles for the login page.
	 *
	 * @since 3.1.0
	 */
	do_action( 'login_enqueue_scripts' );

	/**
	 * Fires in the login page header after scripts are enqueued.
	 *
	 * @since 2.1.0
	 */
	do_action( 'login_head' );
	?>
	</head>

	<?php
}

/**
 * Fires before a specified login form action.
 */
do_action( 'login_form_login' );

/**
 * Filters the separator used between login form navigation links.
 */
$login_link_separator = apply_filters( 'login_link_separator', ' | ' );

/**
 * Filters the login page errors.
 *
 * @since 3.6.0
 *
 * @param object $errors      WP Error object.
 * @param string $redirect_to Redirect destination URL.
 */
logindesigner_login_header( __( 'Log In' ), '', '' );

$login_header_url   = __( 'https://wordpress.org/' );
$login_header_title = __( 'Powered by WordPress' );

/**
 * Filters link URL of the header logo above login form.
 *
 * @since 2.1.0
 *
 * @param string $login_header_url Login header logo URL.
 */
$login_header_url = apply_filters( 'login_headerurl', $login_header_url );

/**
 * Filters the title attribute of the header logo above login form.
 *
 * @since 2.1.0
 *
 * @param string $login_header_title Login header logo title attribute.
 */
$login_header_title = apply_filters( 'login_headertext', $login_header_title );

unset( $login_header_url, $login_header_title );

/**
 * Filters the login page body classes.
 *
 * @since 3.5.0
 *
 * @param array  $classes An array of body classes.
 * @param string $action  The action that brought the visitor to the login page.
 */
$classes   = array( 'login-action-login', 'wp-core-ui' );
$classes[] = ' locale-' . sanitize_html_class( strtolower( str_replace( '_', '-', get_locale() ) ) );
$classes   = apply_filters( 'login_body_class', $classes, 'login' );
?>

	<body class="login <?php echo esc_attr( implode( ' ', $classes ) ); ?>">

	<div style="display: none !important; visibility: hidden;" id="login-designer-template"><?php echo esc_attr( $login_designer_template['template'] ); ?></div>

		<?php
		/**
		 * Fires in the login page header after the body tag is opened.
		 *
		 * @since 4.6.0
		 */
		do_action( 'login_header' );
		?>

		<div id="login-designer--background-hint" data-hint="<?php echo esc_attr__( 'Click here to upload a background image, choose from the gallery and set a background color.', 'login-designer' ); ?>" data-hintPosition="middle-right" data-position="bottom-right-aligned"></div>

		<div id="login-designer--templates-hint" data-hint="<?php echo esc_attr__( 'Click here to select a display template for your login page.', 'login-designer' ); ?>" data-hintPosition="middle-right" data-position="bottom"></div>

		<div id="login">

			<h1 id="login-designer-logo-h1" data-hint="<?php echo esc_attr__( 'Click on the logo below to upload your own and set the image\'s height and width.', 'login-designer' ); ?>" data-hintPosition="top-middle" data-position="right">
				<a id="login-designer-logo" class="customize-unpreviewable" href="#" title="" tabindex="-1"><?php bloginfo( 'name' ); ?></a>
                <span id="login-designer--ripple-effect-logo" class="login-designer--username-svg-hover-display"></span>
			</h1>

			<?php
			$options    = new Login_Designer_Customizer_Output();
			$option     = $options->option_wrapper( 'username_label' );
			$visibility = ( '' !== $option ) ? null : 'no-label';
			?>

			<form name="loginform" id="loginform" class="<?php echo esc_attr( $visibility ); ?>"  action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
				<p>
					<label id="login-designer--username-label" for="user_login">
						<span id="login-designer--username-label-text">
							<span class="login-designer--ripple-effect-username-label"></span>
							<span id="login-designer-username-hover" class="login-designer--username-svg-hover-display"></span>
							<?php echo esc_html__( 'Username or Email Address', 'login-designer' ); ?>
						</span>
						<div id="login-designer--username">
							<span class="login-designer--ripple-effect-username-field"></span>
							<span id="login-designer-username-field-hover" class="login-designer--username-svg-hover-display"></span>
							<input readonly autocomplete="off" type="text" name="log" id="user_login" class="input" value="email@address.com" size="20" />
						</div>
					</label>
				</p>

				<p>
					<label id="login-designer--password-label" for="user_pass">
						<span id="login-designer--password-label-text">
							<span class="login-designer--ripple-effect-username-label"></span>
							<span id="login-designer-password-hover" class="login-designer--username-svg-hover-display"></span>
							<?php echo esc_html__( 'Password', 'login-designer' ); ?>
						</span>
				<div id="login-designer--password">
					<span class="login-designer--ripple-effect-username-field"></span>
					<span id="login-designer-password-field-hover" class="login-designer--username-svg-hover-display"></span>
					<input readonly autocomplete="off" type="password" name="pwd" id="user_pass" class="input" value="password" size="20" />
					<?php if ( version_compare( $GLOBALS['wp_version'], '5.2', '>' ) ) { ?>
						<button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php echo esc_attr__( 'Show Password', 'login-designer' ); ?>">
							<span class="dashicons dashicons-visibility" aria-hidden="true"></span>
						</button>
					<?php } ?>
				</div>
				</label>
				</p>

				<?php do_action( 'login_form' ); ?>

				<div class="login-designer--form-footer">
					<p class="forgetmenot">
						<label for="rememberme">
							<span class="login-designer--ripple-effect-remember-field"></span>
							<span id="login-designer-remember-hover" class="login-designer--username-svg-hover-display"></span>
							<input name="rememberme" type="checkbox" id="rememberme" value="forever" checked />
							<?php esc_html_e( 'Remember Me' ); ?>
							<span id="login-designer-remember-label-hover" class="login-designer--username-svg-hover-display"></span>
						</label>
					</p>

					<p class="submit">
						<span id="login-designer--button">
							<span class="login-designer--ripple-effect-submit-field"></span>
							<span id="login-designer-submit-hover" class="login-designer--username-svg-hover-display"></span>
							<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php echo esc_html__( 'Log In', 'login-designer' ); ?>" />
						</span>
					</p>
				</div>
			</form>

			<div id="login-designer--below-form" data-hint="<?php echo esc_attr__( 'Click on the elements below the form to modify each one.', 'login-designer' ); ?>" data-hintPosition="middle-right" data-position="bottom-right-aligned">
				<div class="login-designer--ripple-effect-form-bellow-field"></div>
				<span id="login-designer-bellow-form-field-hover" class="login-designer--username-svg-hover-display"></span>

				<p id="nav">
					<?php
					if ( get_option( 'users_can_register' ) ) :
						$registration_url = sprintf( '<a href="%s">%s</a>', esc_url( wp_registration_url() ), __( 'Register', 'login-designer' ) );
						/** This filter is documented in wp-includes/general-template.php */
						echo esc_url( apply_filters( 'register', $registration_url ) );
						echo esc_html( $login_link_separator );
					endif;
					?>
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'login-designer' ); ?></a>

				</p>

				<p id="backtoblog">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php
						/* translators: %s: site title */
						printf( _x( '&larr; Back to %s', 'site', 'login-designer' ), esc_html( get_bloginfo( 'title', 'display' ) ) );
						?>
					</a>
				</p>

			</div>

			<?php
			if ( apply_filters( 'login_display_language_dropdown', true ) ) {
				$languages = get_available_languages();
				if ( ! empty( $languages ) ) {
					?>
					<div data-logindesigner-template="template" class="language-switcher login-designer--translation-switcher" id="template-language-translator" style="display: <?php echo isset( $login_designer_template['template'] ) && 'default' !== $login_designer_template['template'] ? 'block' : 'none'; ?>;position: relative">
						<form id="language-switcher" action="" method="get">
							<label for="language-switcher-locales">
								<span class="dashicons dashicons-translation" aria-hidden="true"></span>
								<span class="screen-reader-text"><?php esc_attr_e( 'Language' ); ?></span>
							</label>
							<select name="wp_lang" id="language-switcher-locales">
								<option value="en_US" data-installed="1" lang="en">English (United States)</option>
							</select>
							<input type="submit" class="button" value="<?php esc_attr_e( 'Change' ); ?>">
						</form>
					</div>
					<?php
				}
			}
			?>
		</div>

<?php
if ( apply_filters( 'login_display_language_dropdown', true ) ) {
	if ( ! empty( $languages ) ) {
		?>
			<div data-logindesigner-template="default" class="language-switcher login-designer--translation-switcher" id="default-language-translator" style="display: <?php echo isset( $login_designer_template['template'] ) && 'default' === $login_designer_template['template'] ? 'block' : 'none'; ?>;position: relative;">
				<form id="language-switcher" action="" method="get">
					<label for="language-switcher-locales">
						<span class="dashicons dashicons-translation" aria-hidden="true"></span>
						<span class="screen-reader-text"><?php esc_attr_e( 'Language' ); ?></span>
					</label>
						<select name="wp_lang" id="language-switcher-locales">
							<option value="en_US" data-installed="1" lang="en">English (United States)</option>
						</select>
					<input type="submit" class="button" value="<?php esc_attr_e( 'Change' ); ?>">
				</form>
			</div>
			<?php
	}
}
?>

		<?php do_action( 'login_footer' ); ?>

		<div class="clear"></div>
		<div id="login-designer-background"></div>

	</body>

</html>

<?php
wp_footer();
