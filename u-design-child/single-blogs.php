<?php
/**
 * @package WordPress
 * @subpackage U-Design
 */
if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $udesign_options;

// construct an array of portfolio categories
$portfolio_categories_array = explode( ',', $udesign_options['portfolio_categories'] );

if ( $portfolio_categories_array != "" && post_is_in_category_or_descendants( $portfolio_categories_array ) ) :
    // Test if this Post is assigned to the Portfolio category or any descendant and switch the single's template accordingly
    include 'single-Portfolio.php';
else : // Continue with normal Loop (Blog category)

    get_header();

    $content_position = ( $udesign_options['blog_sidebar'] == 'left' ) ? 'grid_16 push_8' : 'grid_16';
    if ( $udesign_options['remove_single_sidebar'] == 'yes' ) $content_position = 'grid_24';
    if(get_bloginfo('language')=='sv-SE')
    	$lang_cat='se';
    else
    	$lang_cat = "en";
    if($lang_cat=="en")
    	$category_slug = get_category_by_slug('blogposts');
    else
    	$category_slug = get_category_by_slug('blogginlagg');

?>
    <div id="content-container" class="container_24">
	<div id="main-content" class="<?php echo $content_position; ?>">
	    <div class="main-content-padding">
<?php           udesign_main_content_top( is_front_page() ); ?>
<?php		if (have_posts()) :
		    while (have_posts()) : the_post(); ?>
			<?php observePostViews(get_the_ID());?>

			<div class="testimonial_panel">
				<?php if($lang_cat=='se'):?>
				<a href="<?php echo site_url($category_slug->slug);?>"><span
					class="all_posts alignleft">ALLA BLOGGINLÄGG</span></a><!-- English text "ALL TESTIMONIALS" --><span
					class="alignright"><?php next_post_link('%link', '<div class="next-button">NÄSTA</div>', TRUE, $category_slug->taxonomy); ?></span><!-- English text "NEXT" --><span
					class="alignright"><?php previous_post_link('%link', '<div class="prev-button">FÖREG.</div>', TRUE,$category_slug->taxonomy); ?></span><!-- English text "PREVIOUS" -->
				<?php else:?>
				<a href="<?php echo site_url($category_slug->slug);?>"><span
					class="all_posts alignleft">All Blogposts</span></a><!-- English text "ALL TESTIMONIALS" --><span
					class="alignright"><?php next_post_link('%link', '<div class="next-button">NEXT</div>', TRUE, $category_slug->taxonomy); ?></span><!-- English text "NEXT" --><span
					class="alignright"><?php previous_post_link('%link', '<div class="prev-button">PREVIOUS</div>', TRUE,$category_slug->taxonomy); ?></span><!-- English text "PREVIOUS" -->
				<?php endif; ?>
			</div>
			<div class="post-meta-info" style="padding-top:30px; padding-left:20px;"><?php echo "Published on "; the_date(); echo "   Views:"; echo fetchPostViews(get_the_ID()); ?></div>
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
<?php                       udesign_single_post_entry_before(); ?>
                            <div class="entry">
                            <h1 class="single-title green"><?php the_title();?></h1>
<?php                          // udesign_single_post_entry_top(); ?>

<?php                           // Post Image
                                if( $udesign_options['display_post_image_in_single_post'] == 'yes' ) display_post_image_fn( $post->ID, false );
				the_content(__('<p class="serif">Read the rest of this entry &raquo;</p>', 'udesign'));
				wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

<?php                           udesign_single_post_entry_bottom(); ?>
			    </div>
<?php                       udesign_single_post_entry_after(); ?>
			</div>
<?php			comments_template();
		    endwhile; else: ?>
			<p><?php esc_html_e("Sorry, no posts matched your criteria.", 'udesign'); ?></p>
<?php		endif; ?>
<?php           udesign_main_content_bottom(); ?>
	    </div><!-- end main-content-padding -->
	</div><!-- end main-content -->
<?php
	if( ( !$udesign_options['remove_single_sidebar'] == 'yes' ) && sidebar_exist('BlogSidebar') ) { get_sidebar('BlogSidebar'); }
?>
    </div><!-- end content-container -->
<?php
endif; // end normal Loop ?>

<div class="clear"></div>

<?php

get_footer();


