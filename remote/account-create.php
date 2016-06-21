<?php
// define some vars
require_once '../wp-config.php';
if ( defined( 'ABSPATH' ) )
    $abspath = ABSPATH;
else
    //$abspath = 'http://dev.marketingincolor.com/wptest';
    $abspath = '/home/mic/public_html/dev/wptest';

/*
 * define the role of the new user here
 * @see http://codex.wordpress.org/Roles_and_Capabilities
 */
$role = 'subscriber';
echo $abspath;
/*
 * fetch post data
 */
$user_email = ( isset( $_POST['email'] ) && ! empty( $_POST['email'] ) ) ?
    filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL ) : '';

// no email, no registration!
if ( empty( $user_email ) ) {
// TODO: More error handling like an email to yourself or something else
    exit();
}

// needed to prevent wordpress to load the complete environment. we need only a basic wordpress
define( 'SHORTINIT', TRUE );

// include the needed files which are excluded by SHORTINIT
require_once $abspath . '/wp-load.php';
require_once $abspath . '/wp-includes/user.php';
require_once $abspath . '/wp-includes/pluggable.php';
require_once $abspath . '/wp-includes/formatting.php';
require_once $abspath . '/wp-includes/capabilities.php';
require_once $abspath . '/wp-includes/kses.php';
require_once $abspath . '/wp-includes/meta.php';
require_once $abspath . '/wp-includes/l10n.php';

// create a random password
$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );

/*
 * setup the registration data
 * here we use the user email as login name!
 * the minimum of data is user_pass (password) and user_login (login name)
 *
 * @see http://codex.wordpress.org/Function_Reference/wp_insert_user
 */
$data = array(
        'user_pass'     => $random_password,
        'user_login'    => $user_email,
        'role'          => $role // optional but useful if you create a special role for remote registered users
);

$new_user = wp_insert_user( $data );

// optional email component
if ( ! is_wp_error( $new_user ) ) {

    $subject = "Remote registration to WPTest";
    $message = "Hi there! You have successfully registered to the site. Your login name is {$user_email} and your password is {$random_password}\nPlease change your password immediately!";
    $headers = 'From: Admin <developer@marketingincolor.com>' . "\r\n";

    // @see http://codex.wordpress.org/Function_Reference/wp_mail
    $success = wp_mail( $user_email, $subject, $message, $headers, $attachments );

    // maybe you want to be informed if the registration was successfull
    if ( true == $success ) {
        wp_mail( 'developer@marketingincolor.com', 'Remote registration', "User {$user_email} was registered on " . date ('d.m. Y H:i:s', time() ) );
    }
}
