<?php get_header('blank'); ?>
<div id="footer-custom">
<?php 
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;
?>
</div>
<?php get_footer('blank'); ?>
