<?php
/**
 * Items in this file are deliberately loaded in the global scope and should NOT
 * be encapsulated in a class.
 * 
 * This file is meant to override WordPress's pluggable functions. ONLY functions
 * that are explicitly overriding WordPress pluggable functions should be placed
 * here. 
 * 
 * If there is a need for any additional global functions, please place them in
 * the _global.php file.
 * 
 * @package WordPress
 * @subpackage Nouveau
 * @since Nouveau 1.0
 */


if ( !function_exists('wp_password_change_notification') ) {
function wp_password_change_notification(&$user) {
    if ( ! get_option('password_notify',true) ){
        return;
    }
    if ( $user->user_email != get_option('admin_email') ) {
        $message = sprintf(__('Password Lost and Changed for user: %s','nvLangScope'), $user->user_login) . "\r\n";
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        wp_mail(get_option('admin_email'), sprintf(__('[%s] Password Lost/Changed','nvLangScope'), $blogname), $message);
    }
}}


if ( !function_exists('wp_new_user_notification') ) {
function wp_new_user_notification($user_id, $plaintext_pass = '') {
    $user = new WP_User($user_id);

    $user_login = stripslashes($user->user_login);
    $user_email = stripslashes($user->user_email);

    // The blogname option is escaped with esc_html on the way into the database in sanitize_option
    // we want to reverse this for the plain text arena of emails.
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

    if ( ! get_option('register_notify',true) ){
        return;
    } else {
        $message  = sprintf(__('New user registration on your site %s:','nvLangScope'), $blogname) . "\r\n\r\n";
        $message .= sprintf(__('Username: %s','nvLangScope'), $user_login) . "\r\n\r\n";
        $message .= sprintf(__('E-mail: %s','nvLangScope'), $user_email) . "\r\n";

        @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration','nvLangScope'), $blogname), $message);
    }

    if ( empty($plaintext_pass) )
            return;

    $message  = sprintf(__('Username: %s','nvLangScope'), $user_login) . "\r\n";
    $message .= sprintf(__('Password: %s','nvLangScope'), $plaintext_pass) . "\r\n";
    $message .= wp_login_url() . "\r\n";

    wp_mail($user_email, sprintf(__('[%s] Your username and password','nvLangScope'), $blogname), $message);
}}