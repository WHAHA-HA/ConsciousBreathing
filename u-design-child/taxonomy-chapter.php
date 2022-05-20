<?php
/**
 * Template Name: Chapter Page Template
*
* The archives page template displays a conprehensive archive of the current
* content of your website on a single page.
*
* @package WooFramework
* @subpackage Template
*/
global $woo_options;
get_header();
?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<div id="page-content">
	<div id="content-container" class="container_24">
		<section id="main" class="col-left">
			<?php
			$cur_chapter = get_query_var ( 'chapter' );
			// echo term_description();
			$queried_object = get_queried_object ();
			$taxonomy = $queried_object->taxonomy;
			$term_id = $queried_object->term_id;
			$chapter_title = get_field ( 'chapter_title', $taxonomy . '_' . $term_id );
			$chapter_description = get_field ( 'chapter_description', $taxonomy . '_' . $term_id );
			$chapter_image = get_field('chapter_image', $taxonomy. '_'. $term_id);
			?>
			<div id="main-content" class="grid_24">
				<div class="main-content-padding">
					<!-- video thumbnail and brief description goes here -->
					<div class="top-content">
						<div class="chapter-title">
							<!--  	<h1><?php echo $chapter_title; ?></h1> -->
						</div>
						<div class="top-padding-content">
							<div class="left-content video-thumbnail">
								<!-- <img src='<?=CHILD_DIR."/images/chapter_1_logo.jpg"?>'
									width="528" height="362" /> -->
								<img src='<?=$chapter_image?>' width="960" height="540" />
							</div>
							<!--
							<div class="right-content video-description">
							</div>
							-->
						</div>
					</div>
					<!-- video thumbnail and brief description ends here -->
					<div class="clear"></div>
					<!-- detailed description of chapter goes here -->
					<div class="middle-content chapter-detail-description">
						<section>
							<!--  <h1>Detailed Descriptions goes here...</h1> -->
							<p><?php 	echo $chapter_description; //echo term_description(); ?></p>
							<P></P>
						</section>
					</div>
					<!-- detaield description ends here -->
					<div class="clear"></div>
					<!--   videos in this chapter... -->
					<div class="bottom-content">
						<div class="related-video">
							<!-- In this chapter you can watch
								following videos... -->
							<h2 class="related_video_title">I detta kapitel ingår följande videor:</h2>
							<?php
								global $wp_query;
								$args = array_merge($wp_query->query_vars,array('orderby'=>'title', 'order'=>'asc','posts_per_page'=>100));
								query_posts($args);
							?>
							<?php if(have_posts()): ?>
							<ul class="video-thumbs">
								<?php while ( have_posts() ) : the_post();?>
										<li class="view view-first">
											<?php echo the_post_thumbnail();?>
									<div class="mask">
										<p><?php echo the_title(); ?></p>
									<?php
											//retrives video ID on vimeo
											if(get_post_meta($post->ID,"video_duration",true)==''){
												$video_info = get_field ( "video_link", $post->ID );
												$vimeo_id = substr ( $video_info, strpos ( $video_info, "video/" ) + 6, 8 );
												$videos = $vimeo->call ( 'vimeo.videos.getInfo', array (
														'video_id' => $vimeo_id
												));
												if ($videos)
													$duration = $videos->video[0]->duration;
											}else{
												$duration = get_post_meta($post->ID,"video_duration",true);
											}
											//add post_meta
											if(get_post_meta($post->ID,"video_duration")):
												update_post_meta($post->ID,"video_duration",$duration);
											else:
												add_post_meta($post->ID,"video_duration",$duration);
											endif;
											?>
										<span class="video_duration"><?=date("i:s", $duration); ?></span>
										<a href="<?=get_permalink($post->ID)?>"> <img
											src='<?=CHILD_DIR."/images/playbutton.png"?>' />
										</a>
									</div>
								</li>
								<?php endwhile; // end of the loop. ?>
							</ul>
							<?php endif; ?>
						</div>
					</div>
					<!--  videos in this chapter end -->
					<div class="clear"></div>
				</div>
			</div>
		</section>
		<!-- /#main -->
		<?php // get_sidebar(); ?>
	</div>
</div>
<!-- /#content -->
<?php get_footer(); ?>