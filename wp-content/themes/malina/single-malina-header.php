<?php get_header('blank'); ?>

<?php 
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;
?>

<?php get_footer('blank'); ?>
