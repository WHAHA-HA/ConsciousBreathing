<?php
/**
 * @package WordPress
 * @subpackage U-Design
 */
/**
 * Template Name: Page Template 7
 */

get_header();

$content_position = ( $udesign_options['pages_sidebar_7'] == 'left' ) ? 'grid_20 push_4' : 'grid_20';
?>

<div id="content-container" class="container_24">
    <div id="main-content" class="<?php echo $content_position; ?>">
	<div class="main-content-padding">
<?php       do_action('udesign_above_page_content'); ?>

<?php	    if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		    <div class="entry">
<?php			the_content(__('<p class="serif">Read the rest of this page &raquo;</p>', 'udesign'));
			wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		    </div>
		</div>
<?php		( $udesign_options['show_comments_on_pages'] == 'yes' ) ? comments_template() : '';
	    endwhile; endif; ?>
	    <div class="clear"></div>
<?php	    edit_post_link(esc_html__('Edit this entry.', 'udesign'), '<p class="editLink">', '</p>'); ?>
	</div><!-- end main-content-padding -->
    </div><!-- end main-content -->

<?php if( sidebar_exist('PagesSidebar7') ) { get_sidebar('PagesSidebar7'); } ?>

</div><!-- end content-container -->

<div class="clear"></div>

<?php

get_footer();



