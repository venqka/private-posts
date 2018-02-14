<?php
/*
*
* Private Posts Functions
*
*/

/***********************************************
	Create is_private() condition

	@param: post id
	@return: bool
***********************************************/

function is_private() {

	if( is_singular( 'private-post' ) or is_post_type_archive( 'private-post' ) ) {
		return true;
	} else {
		return false;
	}

}

/******************************************
	Create password form
******************************************/
function sh_password_form() {

	ob_start();
?>
	<form action="" method="post">
		<p><input type="text" name="sh-password"></p>
		<p><input type="submit" value="Submit"></p>
	</form>
<?php

	$password_form = ob_get_clean();
	echo $password_form;	
}

/******************************************
	Validate password
	@param: password
	@return: bool
******************************************/

function sh_validate_password( $password ) {

	$sh_master_password = get_option( 'master-password' );
	
	$sh_protected_cookie = 'sh-unlocked' . COOKIEHASH; 
	
	if( $password == $sh_master_password ) {
		return true;
	}

}

// function sh_ppt_remove_defalut_comment_fields( $fields ) {

// 	unset( $fields[ 'url' ] );
// 	unset( $fields[ 'email' ] );

// 	return $fields;

// }
// add_filter( 'comment_form_default_fields','sh_ppt_remove_defalut_comment_fields' );

function sh_ppt_comment_fileds( $fields ) {

	if( is_private() ) {

		$comment_field = $fields[ 'comment' ];

	    unset( $fields[ 'comment' ] );
	
	    $fields[ 'comment' ] = $comment_field;


	}    
    return $fields;
}
add_filter( 'comment_form_fields','sh_ppt_comment_fileds' );
