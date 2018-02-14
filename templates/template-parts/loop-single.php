<?php
/*
*
* Private post single loop
*
*/
?>
<main id="main" class="site-main" role="main">
<?php

	while ( have_posts() ) : the_post();

		$sh_ppt_id = get_the_ID(); 
		$sh_ppt_title = get_the_title();
		$sh_url = get_the_permalink();
	
	?>			
		<div class="private-post">		
			<div class="sh-ppt-head">
				<div class="sh-ppt-title">
					<a href="<?php echo $sh_url; ?>"><h2><?php echo $sh_ppt_title; ?></h2></a>
				</div>
				<div class="sh-ppt-date">	
					<?php echo get_the_date(); ?>
				</div>
			</div>
			<div class="sh-clear"></div>

			<div class="sh-ppt-content">
				<?php echo the_content(); ?>
			</div>
	
		</div>

<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
?>
</main><!-- .site-main -->

</div><!-- .content-area -->
<div class="sh-right-sidebar">
<?php
	
	$sh_ppt_id = get_the_ID(); 
	$sh_ppt_attachments = get_posts( array(
		'post_type' => 'attachment',
		'posts_per_page' => -1,
		'post_parent' => $sh_ppt_id,
		'exclude'     => get_post_thumbnail_id()
	) );

	if( !empty( $sh_ppt_attachments ) ) {
?>
		<h3><?php _e( 'Attachments'. 'sh' ); ?></h3>	
		<ul>
<?php			
			foreach ( $sh_ppt_attachments as $ppt_attachment ) {
			
				$ppt_attachment_id = $ppt_attachment->ID;
				$ppt_title = $ppt_attachment->post_title;
				$ppt_file = wp_get_attachment_url( $ppt_attachment_id );
				echo '<li><a href="' . $ppt_file . '">' . $ppt_title . '</a></li>';
		
		}
?>
		</ul>
<?php
	}
?>		
</div>
<div class="sh-clear"></div>