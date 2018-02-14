<?php
/**
*
* Private Posts Single Template
*
 */

$sh_protected_cookie = 'sh-unlocked' . COOKIEHASH; 

if( $_POST ) {
	$user_password = $_POST[ 'sh-password' ]; 
			
	if( sh_validate_password( $user_password ) && !isset( $_COOKIE[ $sh_protected_cookie ] ) ) {
		setcookie( $sh_protected_cookie );				
	}		
}

get_header(); ?>

<main id="archive-private">

<?php
	
	if( isset( $_COOKIE[ $sh_protected_cookie ] ) ) {
		
		include( 'template-parts/loop-archive.php' );

	} else {
		 
		if( !$_POST ) {
			sh_password_form();
		} else {
			include( 'template-parts/loop-archive.php' );
		}	
	}
?>		

	</main><!-- .site-main -->

<?php get_footer();