<?php
/*
Plugin Name: Better Login Form for WooCommerce
Version: 1.0.0
Description: Better login and register forms for WooCommerce stores
Author: Luiz Bills
Author URI: https://luizpb.com

Text Domain: woo-better-login-form
Domain Path: /languages

License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

add_action( 'plugins_loaded', 'wooblf_check_init' );
function wooblf_check_init () {
	load_plugin_textdomain( 'woo-better-login-form', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	if ( ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', 'wooblf_admin_notice_dependencies' );
	}
	else {
		add_action( 'woocommerce_login_form_end', 'wooblf_add_register_button' );
		add_action( 'woocommerce_register_form_end', 'wooblf_add_login_button' );
		add_action( 'wp_enqueue_scripts', 'wooblf_enqueue_scripts' );
		add_filter( 'body_class', 'wooblf_body_class' );
		add_filter( 'option_woocommerce_enable_myaccount_registration', 'wooblf_enable_myaccount_registration' );
	}
}

function wooblf_admin_notice_dependencies () {
	$class = 'notice notice-error';
	$message = __( 'The plugin Better Login Form for WooCommerce requires WooCommerce installed and activated.', 'woo-better-login-form' );

	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}

function wooblf_enqueue_scripts () {
	if ( is_user_logged_in() ) return;
	if ( ! is_account_page() ) return;

	wp_enqueue_script(
		'woo-better-login-form',
		plugins_url( 'assets/js/forms.js', __FILE__ ),
		false,
		false,
		true
	);

	wp_enqueue_style(
		'woo-better-login-form',
		plugins_url( 'assets/css/forms.css', __FILE__ ),
	);
}

function wooblf_add_register_button () {
	$text = __( "Don't have an account?", 'woo-better-login-form' );
	$link = __( 'Register now', 'woo-better-login-form' );
	?>
	<p id="signup-link"><?= $text ?> <a href="#register"><?= $link ?></a></p>
	<?php
}

function wooblf_add_login_button () {
	$text = __( "Already have an account?", 'woo-better-login-form' );
	$link = __( 'Sign in', 'woo-better-login-form' );
	?>
	<p id="signin-link"><?= $text ?> <a href="#login"><?= $link ?></a></p>
	<?php
}

function wooblf_body_class ( $classes ) {
	$classes[] = 'no-js';
	return $classes;
}

function wooblf_enable_myaccount_registration ( $value ) {
	return 'yes';
}

