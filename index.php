<?php
/**
 * Plugin Name: Send Password Instead of Email
 * Version:     1.0.0
 * Description: This plugin is specially created for one of my client
 * Author:      Anup Kumar
 * Author URI:  https://github.com/kumaranup594/
 * Tags: send password on new user registration, add password welcome email
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * NexGen Innovators is New Delhi, India based IT company provides quality solution to wordPress clients over the world.
 *
 */
add_filter( 'wp_new_user_notification_email', 'custom_wp_new_user_notification_email', 100000, 3 );
function custom_wp_new_user_notification_email( $wp_new_user_notification_email, $user, $blogname ) {

    if(in_array('subscriber', $user->roles)) {
        $user_id = $user->ID;
        $password = randomPassword();
        wp_set_password($password, $user_id);
        $message = 'Hey ' . $user->display_name . ', Welcome to our website' . "\r\n\r\n";
        $message .= "Please find the username password to login." . "\r\n";
        $message .= "username - " . $user->user_login . "\r\n";
        $message .= "Password - " . $password . "\r\n";
        $message .= "After this you can enjoy our website!" . "\r\n\r\n";
        $message .= "Thanks" . "\r\n";
        $message .= "Support Team | " . $blogname . "\r\n";
        $wp_new_user_notification_email['message'] = $message;
    }
    return $wp_new_user_notification_email;
}
if(!function_exists('randomPassword')) {
    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
