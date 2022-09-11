<?php

define('WP_ADMIN_DIR', 'admin');
defined('SITECOOKIEPATH') || define('SITECOOKIEPATH', preg_replace('|https?://[^/]+|i', '', get_option('siteurl') . '/' ) );
define( 'ADMIN_COOKIE_PATH', SITECOOKIEPATH . WP_ADMIN_DIR);

add_filter('site_url',  'wpadmin_filter', 10, 3);
function wpadmin_filter( $url, $path, $orig_scheme ) {
    $old  = array( "/(wp-admin)/");
    $admin_dir = WP_ADMIN_DIR;
    $new  = array($admin_dir);
    return preg_replace( $old, $new, $url, 1);
}
