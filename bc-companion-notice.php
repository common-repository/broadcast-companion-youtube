<?php
$settings = (array) get_option( 'bcyt_companion_options' );
$field = "bcyt_channel_id";
$value = esc_attr( $settings[$field] );

// check if a username is entered.
if( empty( $value ) ) {
    add_action( 'admin_notices', 'bcyt_youtube_error_notice' );
}
function bcyt_youtube_error_notice() {
    echo '<div class="notice error"><p>YouTube settings not configured! Please add your YouTube channel ID <a href="admin.php?page=bcyt-companion-youtube">here.</a></div>';
}