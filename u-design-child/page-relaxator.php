<?php
/**
 * @package WordPress
 * @subpackage U-Design
 */
/**
 * Template Name: Relaxator page
 */


get_header(); ?>
<div id="content-container" class="container_24">
    <div id="main-content" class="grid_24">
	<div class="main-content-padding">
<?php       do_action('udesign_above_page_content'); ?>
	
<?php	    if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h1>The Relaxator Breathing Retrainer</h1>
		    <div class="entry"><div class="relaxatorsidor">
           <a href="http://consciousbreathingretraining.com/relaxator/"><img class="alignnone size-full wp-image-5842" style="margin-right: 1px;" alt="relaxator-benefits-130w167h" src="http://consciousbreathingretraining.com/wp-content/uploads/2013/08/relaxator-benefits-130w167h.jpg" width="130" height="167" /></a><a href="http://consciousbreathingretraining.com/relaxator/when/"><img class="alignnone size-full wp-image-5841" style="margin-right: 1px;" alt="relaxator-when-130w167h" src="http://consciousbreathingretraining.com/wp-content/uploads/2013/08/relaxator-when-130w167h.jpg" width="130" height="167" /></a><a href="http://consciousbreathingretraining.com/relaxator/how-to/"><img class="alignnone size-full wp-image-5840" style="margin-right: 2px;" alt="relaxator-how-to-130w167h" src="http://consciousbreathingretraining.com/wp-content/uploads/2013/08/relaxator-how-to-130w167h.jpg" width="130" height="167" /></a><a href="http://consciousbreathingretraining.com/relaxator/feedback/"><img class="alignnone size-full wp-image-5839" style="margin-right: 2px;" alt="relaxator-feedback-130w167h" src="http://consciousbreathingretraining.com/wp-content/uploads/2013/08/relaxator-feedback-130w167h.jpg" width="130" height="167" /></a><a href="http://consciousbreathingretraining.com/relaxator/exercises/"><img class="alignnone size-full wp-image-5845" style="margin-right: 2px;" alt="relaxator-exercises-130w167h" src="http://consciousbreathingretraining.com/wp-content/uploads/2013/08/relaxator-exercises-130w167h.jpg" width="130" height="167" /></a><a href="http://consciousbreathingretraining.com/relaxator/pricing/"><img class="alignnone size-full wp-image-5844" style="margin-right: 2px;" alt="relaxator-pricing-130w167h" src="http://consciousbreathingretraining.com/wp-content/uploads/2013/08/relaxator-pricing-130w167h.jpg" width="130" height="167" /></a><a href="http://consciousbreathingretraining.com/relaxator/reviews/"><img class="alignnone size-full wp-image-5846" alt="relaxator-reviews-130w167h" src="http://consciousbreathingretraining.com/wp-content/uploads/2013/08/relaxator-reviews-130w167h.jpg" width="130" height="168" /></a>
            </div>
<?php			the_content(__('<p class="serif">Read the rest of this entry &raquo;</p>', 'udesign'));
			wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		    </div>
		</div>
<?php		( $udesign_options['show_comments_on_pages'] == 'yes' ) ? comments_template() : ''; ?>
<?php	    endwhile; endif; ?>
	    <div class="clear"></div>
<?php	    edit_post_link(esc_html__('Edit this entry.', 'udesign'), '<p class="editLink">', '</p>'); ?>

	</div><!-- end main-content-padding -->
    </div><!-- end main-content -->
</div><!-- end content-container -->

<div class="clear"></div>

<?php

get_footer();


