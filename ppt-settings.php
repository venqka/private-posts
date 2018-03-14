<?php
/*
*
* Private Posts Settings
*
*/

/*****************************************************
	Create admin page
*****************************************************/	

function pp_settings_page() {
	add_submenu_page(
		'edit.php?post_type=private-post',
		__( 'Private Posts Settings', 'pp' ), 	//title
		__( 'Private Posts Settings', 'pp' ), 	//menu title
		'manage_options', 						//capabilities
		'ppt-settings',				 			//menu slug
		'ppt_settings' 							//function
	);
}
add_action( 'admin_menu', 'pp_settings_page' );

function pp_init() {

	add_settings_section( 
		'ppt_section',		 						//ID
		__( 'Private posts settings', 'pp' ),		//Title
		'ppt_section_callback', 					//Callback
		'ppt'								 		//Page
	);

	/*****************************************************
		Master password settings
	*****************************************************/	

	add_settings_field( 
		'archive_title',								//ID
		__( 'Enter Archive Title', 'pp' ),				//title
		'archive_title',								//callback
		'ppt',											//page
		'ppt_section'									//section
	);


	register_setting( 
		'sh-ppt',										//option group
		'archive-title',								//option name
		'archive_title_sanitization'					//sanitize callback
	);

	/*****************************************************
		Archive page title
	*****************************************************/	

	add_settings_field( 
		'master_password',								//ID
		__( 'Enter Master Password', 'pp' ),			//title
		'master_password',								//callback
		'ppt',											//page
		'ppt_section'									//section
	);


	register_setting( 
		'sh-ppt',											//option group
		'master-password',								//option name
		'master_password_sanitization'					//sanitize callback
	);
	
}
add_action( 'admin_init', 'pp_init' );

function ppt_section_callback() {
?>
	<p><?php _e( 'Enter the master password. It will unlock every private post', 'pp' ); ?></p>
<?php
}

function master_password() {

	$ppt_pass = get_option( 'master-password' );
?>
	<div>
		<input type="text" name="master-password" value="<?php if( !empty( $ppt_pass ) ) { echo $ppt_pass; } ?>">
	</div>
<?php
}

function master_password_sanitization( $option ) {
	return $option;
}

function archive_title() {

	$ppt_archive_title = get_option( 'archive-title' );
?>
	<div>
		<input type="text" name="archive-title" value="<?php if( !empty( $ppt_archive_title ) ) { echo $ppt_archive_title; } ?>">
	</div>
<?php
}

function archive_title_sanitization( $option ) {
	
	$option = sanitize_text_field( $option );
	return $option;

}

/******************************************************************
	Output the settings page
******************************************************************/

function ppt_settings() {
		
?>
	<form method="post" action="options.php">
<?php

		//section
		do_settings_sections( 'ppt' );

		//fields
		settings_fields( 'sh-ppt' );	
 			
?>
		<input class="button button-primary" name="Submit" type="submit" value="<?php esc_attr_e( 'Save Settings', 'pp' ); ?>" />
	</form>

<?php 	
}
