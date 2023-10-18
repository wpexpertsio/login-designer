<?php
/**
 * Template Name: Password Protected
 *
 * Template to display the Password Protected login form in the Customizer.
 * This is essentially a stripped down version of wp-login.php, though not accessible from outside the Customizer.
 *
 * @package Login Designer
 */

if ( ! is_customize_preview() ) {
	$page_id   = Login_Designer_Password_Protected::get_password_protected_id();
	$permalink = get_permalink( $page_id );

	$url = add_query_arg(
		array(
			'return'           => admin_url( 'index.php' ),
			'url'              => rawurlencode( $permalink ),
			'autofocus[panel]' => 'password_protected',
		),
		admin_url( 'customize.php' )
	);
	wp_safe_redirect( $url );
}

// phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
global $wp_version, $Password_Protected, $error, $is_iphone;


?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta <?php bloginfo( 'charset' ); ?>>
	<title><?php bloginfo( 'name' ); ?></title>


    <style media="screen">
        #login_error, .login .message, #loginform { margin-bottom: 20px; }
        .password-protected-text-below { display: inline-block; text-align: center; margin-top: 30px;}
        .password-protected-text-above { text-align: center; margin-bottom: 10px;}
    </style>

	<?php
	if ( version_compare( $wp_version, '3.9-dev', '>=' ) ) {
		wp_admin_css( 'login', true );
	} else {
		wp_admin_css( 'wp-admin', true );
		wp_admin_css( 'colors-fresh', true );
	}

	if ( $is_iphone ) {
		?>
		<meta name="viewport" content="width=320; initial-scale=0.9; maximum-scale=1.0; user-scalable=0;" />
		<style media="screen">
			.login form, .login .message, #login_error { margin-left: 0px; }
			.login #nav, .login #backtoblog { margin-left: 8px; }
			.login h1 a { width: auto; }
			#login { padding: 20px 0; }
		</style>
		<?php
	}
	do_action( 'login_enqueue_scripts' );
	do_action( 'password_protected_enqueue_scripts' );
	do_action( 'password_protected_login_head' );

	?>
</head>
<?php
$body_class = 'login login-password-protected login-action-password-protected-login wp-core-ui';
$body_class = explode( ' ', $body_class );
$body_class = apply_filters( 'body_class', $body_class );
$body_class = implode( ' ', $body_class );

$password = apply_filters( 'password_protected_login_password_title', __( 'Password', 'login-designer' ) );


?>
<body class="<?php echo esc_attr( $body_class ); ?>">
	<div id="login">

		<h1 id="password-protected-logo">
			<a href="<?php echo esc_url( apply_filters( 'password_protected_login_headerurl', home_url( '/' ) ) ); ?>" title="<?php echo esc_attr( apply_filters( 'password_protected_login_headertitle', get_bloginfo( 'name' ) ) ); ?>">
				<?php bloginfo( 'name' ); ?>
			</a>
		</h1>


		<?php do_action( 'password_protected_before_login_form' ); ?>

        <div style="display: table;clear: both;"></div>

		<form method="post" id="password-protected-form">

            <?php do_action( 'password_protected_above_password_field' ); ?>

			<p>
				<label for="password_protected_pass">
					<span id="password-protected--password-label">
						<?php echo esc_attr( $password ); ?>
					</span>
					<div id="password_protected_field_customizer">
						<input type="password" name="password_protected_pwd" id="password_protected_pass" class="input" value="Password" size="20" tabindex="20" />
					</div>
				</label>
			</p>


			<p id="password-protected-forgetmenot">
				<label for="password_protected_rememberme"><input name="password_protected_rememberme" type="checkbox" id="password_protected_rememberme" value="1" tabindex="90" checked /> <?php esc_attr_e( 'Remember Me' ); ?></label>
			</p>


			<p class="submit">
				<span id="password-protected-submit-btn">
					<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e( 'Log In' ); ?>" tabindex="100" />
				</span>
			</p>

            <div style="display: table;clear: both;"></div>

            <?php do_action( 'password_protected_below_password_field' ); ?>

		</form>

	</div>
</body>

<div id="password-protected-background" style="position:absolute;top:0;left:0;bottom:0;right:0;width:100%;height:100%;z-index:-1;transition: opacity 300ms cubic-bezier( 0.694, 0, 0.335, 1 )"></div>

<?php wp_footer(); ?>
</html>
