<?php
/*
Plugin Name: Better Login Form for WooCommerce
Version: 1.0.0
Description: Better login and register forms for WooCommerce stores
Author: Luiz Bills
Author URI: https://luizpb.com
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: woo-better-login-form
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'plugins_loaded', 'wooblf_plugin_init' );
function wooblf_plugin_init () {
	load_plugin_textdomain( 'woo-better-login-form', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	if ( ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', 'wooblf_admin_notice_dependencies' );
	}
	else {
		add_action( 'woocommerce_login_form_end', 'wooblf_add_register_button' );
		add_action( 'woocommerce_register_form_end', 'wooblf_add_login_button' );
		add_action( 'wp_enqueue_scripts', 'wooblf_enqueue_scripts' );
		add_filter( 'body_class', 'wooblf_body_class' );
		add_filter( 'option_woocommerce_enable_myaccount_registration', 'wooblf_return_yes_string' );
	}
}

function wooblf_admin_notice_dependencies () {
	$class = 'notice notice-error';
	list( $plugin_name ) = \get_file_data( __FILE__, [ 'Plugin Name' ] );
	$woocommerce_link = esc_url( \admin_url( 'plugin-install.php?tab=plugin-information&plugin=woocommerce' ) );
	$message = esc_html__( '%s requires %s installed and activated.', 'woo-better-login-form' );
	$message = sprintf( $message, '<strong>' . esc_html( $plugin_name ) . '</strong>', "<a target=\"_blank\" href=\"$woocommerce_link\">WooCommerce</a>" );
	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
}

function wooblf_enqueue_scripts () {
	if ( is_user_logged_in() || ! is_account_page() ) return;

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
	$text = esc_html__( "Don't have an account?", 'woo-better-login-form' );
	$label = esc_html__( 'Register now', 'woo-better-login-form' );
	$url = esc_url( wooblf_get_register_url() );
	?>
	<p id="register-link"><span><?= $text ?></span> <a href="<?= $url ?>"><?= $label ?></a></p>
	<?php
}

function wooblf_add_login_button () {
	$text = esc_html__( "Already have an account?", 'woo-better-login-form' );
	$label = esc_html__( 'Sign in', 'woo-better-login-form' );
	$url = esc_url( wooblf_get_login_url() );
	?>
	<p id="login-link"><span><?= $text ?></span> <a href="<?= $url ?>"><?= $label ?></a></p>
	<?php
}

function wooblf_get_login_url () {
	$url = '#login';
	return $url; 
}

function wooblf_get_register_url () {
	$url = '#register';
	return $url; 
}

function wooblf_body_class ( $classes ) {
	$classes[] = 'no-js'; // to detect javascript
	return $classes;
}

function wooblf_return_yes_string () {
	return 'yes';
}
