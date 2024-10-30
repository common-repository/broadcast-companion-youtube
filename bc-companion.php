<?php
/**
 * Plugin Name: Broadcast Companion (YouTube)
 * Description: A companion plugin for the Broadcast theme.
 * Version: 1.0.2
 * Author: StreamWeasels
 * Author URI: https://www.streamweasels.com
 */

function bcyt_youtube_companion_menu() {

	add_menu_page(
		'Broadcast Companion (YouTube)',
		'Broadcast YouTube Integration',
		'manage_options',
		'bcyt-companion-youtube',
		'bcyt_companion_options',
		'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDIwMDEwOTA0Ly9FTiIgImh0dHA6Ly93d3cudzMub3JnL1RSLzIwMDEvUkVDLVNWRy0yMDAxMDkwNC9EVEQvc3ZnMTAuZHRkIj4NCjxzdmcgdmVyc2lvbj0iMS4wIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI3MjguMDAwMDAwcHQiIGhlaWdodD0iNTEwLjAwMDAwMHB0IiB2aWV3Qm94PSIwIDAgNzI4LjAwMDAwMCA1MTAuMDAwMDAwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJ4TWlkWU1pZCBtZWV0Ij4NCg0KPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMC4wMDAwMDAsNTEwLjAwMDAwMCkgc2NhbGUoMC4xMDAwMDAsLTAuMTAwMDAwKSIgZmlsbD0icmVkIiBzdHJva2U9Im5vbmUiPg0KPHBhdGggZD0iTTI3NzUgNTA4MCBjLTgzOSAtMTggLTE0ODkgLTU3IC0xODIxIC0xMTAgLTI0MCAtMzkgLTQwNiAtMTE3IC01NTYgLTI2MiAtMTk4IC0xOTIgLTI2OSAtMzgzIC0zMjggLTg4MyAtMTE1IC05ODAgLTc2IC0yNDM2IDgxIC0zMDIzIDc3IC0yOTAgMjg3IC01MTkgNTcyIC02MjcgNjAgLTIyIDIxNyAtNTYgMzE3IC02OSAyODkgLTM1IDU4OCAtNTUgMTIwNSAtODEgOTMxIC0zOCAyNDQ5IC0yNyAzMzQwIDI2IDQxMiAyNCA3MjggNTkgODg3IDk5IDI0MiA2MCA0NzYgMjQ4IDU4NCA0NjggNTAgMTA0IDcwIDE2NiA5OSAzMDYgMTcwIDg0MCAxNTYgMjY3NiAtMjYgMzM1NSAtODIgMzA3IC0zMDAgNTQ0IC01OTAgNjQxIC0yMTIgNzIgLTcwMSAxMTYgLTE2MzkgMTUwIC0zODYgMTQgLTE2NzAgMjAgLTIxMjUgMTB6IG0yNjIgLTE1MTMgYzU5IC0zNSAyNjMgLTE1MyA0NTMgLTI2MiAxOTAgLTEwOSA0MjQgLTI0NCA1MjAgLTMwMCA5NiAtNTYgMjcyIC0xNTcgMzkwIC0yMjUgMzY1IC0yMDkgNDAyIC0yMzIgMzkzIC0yNDAgLTQgLTUgLTEyNyAtNzcgLTI3MyAtMTYxIC0xNDYgLTgzIC0zNTkgLTIwNyAtNDc1IC0yNzQgLTExNSAtNjcgLTM2NSAtMjExIC01NTUgLTMyMCAtMTkwIC0xMDkgLTM5NCAtMjI3IC00NTMgLTI2MiAtNjAgLTM0IC0xMTMgLTYzIC0xMTggLTYzIC01IDAgLTkgNDM0IC05IDEwODUgMCA2NTEgNCAxMDg1IDkgMTA4NSA1IDAgNTggLTI5IDExOCAtNjN6Ii8+DQo8L2c+DQo8L3N2Zz4='
	);
}
add_action( 'admin_menu', 'bcyt_youtube_companion_menu' );


function bcyt_youtube_companion_js() {
	$settings = (array) get_option( 'bcyt_companion_options' );
	$field = "bcyt_channel_id";
	$value = $settings[$field];
	$field2 = "bcyt_api_key";
	$value2 = $settings[$field2];	
    wp_enqueue_script('bcyt-companion-main', plugins_url( 'bc-companion-main.js', __FILE__ ), array('jquery'), '1.0.2', false );
	wp_add_inline_script( 'bcyt-companion-main', 'jQuery(document).ready(function(){bcytYouTubeID =  "'. esc_attr($value) .'";bcytApiKey = "'. esc_attr($value2).'";});', 'before');
}
add_action( 'wp_enqueue_scripts', 'bcyt_youtube_companion_js' );


function bcyt_companion_admin_init() {
     
  	register_setting( 'bcyt_companion_settings_fields', 'bcyt_companion_options', 'bcyt_companion_validate_and_sanitize' );
	
	add_settings_section( 'bcyt_youtube_fields', __( 'YouTube Companion Settings', 'bcyt-companion' ), 'bcyt_companion_section_callback', 'bcyt_companion_settings_sections' );  

	add_settings_field( 'bcyt_api_key', __( 'YouTube API Key', 'bcyt-companion' ), 'bcyt_companion_api_key_callback', 'bcyt_companion_settings_sections', 'bcyt_youtube_fields' );
	
	add_settings_field( 'bcyt_channel_username', __( 'YouTube Channel Username', 'bcyt-companion' ), 'bcyt_companion_channel_username_callback', 'bcyt_companion_settings_sections', 'bcyt_youtube_fields' );
	  
	add_settings_field( 'bcyt_channel_id', __( 'YouTube Channel ID', 'bcyt-companion' ), 'bcyt_companion_channel_id_callback', 'bcyt_companion_settings_sections', 'bcyt_youtube_fields' );

}

add_action( 'admin_init', 'bcyt_companion_admin_init' );

function bcyt_companion_options() { ?>
    <div class="wrap">
    <h2><?php _e('Broadcast Options', 'bcyt-companion'); ?></h2>

    <form action="options.php" method="POST">
		<?php  
			settings_fields('bcyt_companion_settings_fields');
			do_settings_sections('bcyt_companion_settings_sections');
		?>
        <input name="Submit" type="submit" value="Save Changes" />
    </form>

    </div>
<?php }

// Section
function bcyt_companion_section_callback() {
	_e( 'This plugin requires an active YouTube API key to work. <a href="https://support.streamweasels.com/article/26-how-to-setup-a-youtube-api-key" target="_blank">Click here</a> to learn more about YouTube API keys.', 'bcyt-companion' );
}

// Fields
function bcyt_companion_api_key_callback() {
	
	$settings = (array) get_option( 'bcyt_companion_options' );
	$field = "bcyt_api_key";
	$value = $settings[$field];

	echo "<input type='text' name='bcyt_companion_options[$field]' value='".esc_attr($value)."' />";
	echo "<p>Your YouTube API key, follow along with our guide <a href='https://support.streamweasels.com/article/26-how-to-setup-a-youtube-api-key' target='_blank'>here</a> if you're unsure where to get this.</p>";
}

function bcyt_companion_channel_username_callback() {
	
	$settings = (array) get_option( 'bcyt_companion_options' );
	$field = "bcyt_channel_username";
	$value = $settings[$field];

	echo "<input type='text' name='bcyt_companion_options[$field]' value='".esc_attr($value)."' />";
	echo "<p>Your YouTube Username, this is displayed in the main header area of your Broadcast theme.</p>";

}

function bcyt_companion_channel_id_callback() {
	
	$settings = (array) get_option( 'bcyt_companion_options' );
	$field = "bcyt_channel_id";
	$value = $settings[$field];

	echo "<input type='text' name='bcyt_companion_options[$field]' value='".esc_attr($value)."' />";
	echo "<p>Easily convert your YouTube username to a Channel ID <a href='https://commentpicker.com/youtube-channel-id.php' target='_blank'>here</a>.</p>";
}

// Validation
function bcyt_companion_validate_and_sanitize( $input ) {
	$settings = (array) get_option( 'bcyt_companion_options' );

	if ( isset( $input['bcyt_api_key'] ) ) {
		$output['bcyt_api_key'] = sanitize_text_field( $input['bcyt_api_key'] );
	}  else {
		add_settings_error( 'bcyt_companion_options', 'invalid-bcyt_api_key', 'You have entered an invalid value into "youtube Username".' );
	}	
	
	if ( isset( $input['bcyt_channel_username'] ) ) {
		$output['bcyt_channel_username'] = sanitize_text_field( $input['bcyt_channel_username'] );
	}  else {
		add_settings_error( 'bcyt_companion_options', 'invalid-bcyt_channel_username', 'You have entered an invalid value into "youtube Username".' );
	}

	if ( isset( $input['bcyt_channel_id'] ) ) {
		$output['bcyt_channel_id'] = sanitize_text_field( $input['bcyt_channel_id'] );
	}  else {
		add_settings_error( 'bcyt_companion_options', 'invalid-bcyt_channel_id', 'You have entered an invalid value into "youtube Channel ID".' );
	}
	
	return $output;
}

require_once(plugin_dir_path( __FILE__ ) . '/bc-companion-notice.php');