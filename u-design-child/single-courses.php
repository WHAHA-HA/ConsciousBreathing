<?php
/**
 * Template Name: Video Course Page Template
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

		<?php if ( isset( $woo_options['woo_breadcrumbs_show'] ) && $woo_options['woo_breadcrumbs_show'] == 'true' ) { ?>

		<!--  <section id="breadcrumbs">
			<p>not showing breadcumb</p>
			<?php woo_breadcrumbs(); ?>
		</section>
		-->
		<!--/#breadcrumbs -->
		<?php } ?>

		<?php
			$current_user = wp_get_current_user();
			$user_id= $current_user->ID ;
		?>
		<section id="main" class="col-left">

			<div id="main-content" class="grid_24">
				<?php while ( have_posts() ) : the_post(); ?>

			<?php // wc_get_template_part( 'content', 'single-product' ); ?>


				<div class="main-content-padding">
					<!-- video thumbnail and brief description goes here -->
					<div class="top-content">
						<div class="chapter-title">
							<!--  	<h1><?php echo get_the_title();?></h1>-->
						</div>
						<div
							class="top-padding-content <?php if($user_id!=0){ echo 'with_video';}else{echo 'without_video';}?>">
							<!--  in case logged in we show video -->
							<!-- otherwise we show static thumbnail -->
							<div class="left-content video-thumbnail">
								<?php

								if ($user_id!=0)://when user was logged
									?>

								<!-- <iframe
									src="//player.vimeo.com/video/97759755?title=0-->
									<?php the_field("video_link");?>

								<?php else:?>
									<h2>
									Vänligen <a href="<?php echo get_permalink(woocommerce_get_page_id('myaccount'));?>">logga in</a> för att se denna video<!-- In English "To watch this video course you have to "
									Login</a></h2>In English "Login"-->
 								<?php
 									/*
 									$size = array('width'=> 960, 'height'=>235);
 									$thumb_id = get_post_thumbnail_id($post->ID);

 									echo "<img src='".wp_get_attachment_url($thumb_id)."' width='960' height='540' />";
 									*/
 									echo "<img src='".get_field('default_image')."' width='960' height='540' />";
								 	endif;

								 	//get next and prev link
								 	$next_post = get_next_post();
								 	$prev_post = get_previous_post();
								 	$vimeo=unserialize(file_get_contents("http://vimeo.com/api/v2/video/97759756"));
								 	//print_r($vimeo);
								 ?>
							</div>
							<?php if($user_id !=0): ?>
							<div class="left-content video-toolbar">
								<?php if(!empty($prev_post)):?>
								<span class="left_button">&lt;&nbsp;<a href="<?=get_permalink($prev_post->ID)?>">Föreg.</a>&nbsp;</span><!-- In English "Prev" -->
								<?php endif;?>
								<?php if(!empty($prev_post) && !empty($next_post)):?>
								<span class="separator">&nbsp; | &nbsp; </span>
								<?php endif;?>
								<?php if(!empty($next_post)):?>
								<span class="right_button">&nbsp;<a href="<?=get_permalink($next_post->ID)?>">Nästa</a>&nbsp; &gt;</span><!-- In English "Next" -->
								<?php endif; ?>
							</div>
							<?php  endif; ?>
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
							<p><?php echo the_field('description'); ?></p>
						</section>
					</div>
					<!-- detaield description ends here -->
					<div class="clear"></div>
					<!--  displaying related videos... -->
					<?php
					//for in loop, display all "content", regardless of post_type
					//retrive viedoes related to only certain chapter....
						$backup = $post; // for back up

						$custom_terms =  wp_get_post_terms($post->ID, 'chapter', array('fields'=>'all'));

					//	print_r($post);

					 ?>

					<!--  related videos -->
					<div class="bottom-content">
						<div class="related-video">
							<!-- tab panes here -->
							<div class="tabs-wrapper">
								<ul class="tabs">
									<li><a href="javascript:void(0)" class="defaulttab" id="tab-1">
											<span>Videor i detta kapitel</span> <!-- In English it is "Chapter Videos" -->
									</a></li>
									<li><a href="javascript:void(0)" id="tab-2"><span>Kommentarer</span></a></li><!-- In English it is "Comments" -->
								</ul>
								<div class="tab-content" id="tab-1-content">
									<div class="tabs-inner-padding">
										<!--  <h2>You might want to see these videos as well...</h2> -->
										<?php
																				//going to hold our tax_query params
										if($custom_terms):

											//going to hold our tax_query params
											$tax_query = array();

											//add the relation parameter (
											if(count($custom_terms) > 1)
												$tax_query['relation'] = 'OR';

											//loop through chapter and build a tax query
											foreach($custom_terms as $custom_term)
											{
												$tax_query []= array(
														'taxonomy'	=> 'chapter',
														'field'		=> 'slug',
														'terms'		=> $custom_term->slug,
												);
											}

							// put all the WP_Query args together
										$args = array (
												'post_type' => 'courses',
												'order' => 'asc',
												'orderby' => 'title',
												'posts_per_page' => -1,
												'tax_query'	=> $tax_query
															);
											$loop = new WP_Query($args);

											if($loop->have_posts()) :
										?>
											<ul class="video-thumbs">
											<?php
												while($loop->have_posts()): $loop->the_post();
													// echo the_post_thumbnail();
											?>
												<li class="view view-first">
														<?php echo the_post_thumbnail();?>
												<!-- <img src='<?=CHILD_DIR."/images/chapter_1_thumb.png"?>' width="260" height="144" /> -->
												<div class="mask">
													<p><?php echo the_title(); ?></p>
											<?php
												// retrives video ID on vimeo
											if (get_post_meta ( $post->ID, "video_duration", true ) == '') {
												$video_info = get_field ( "video_link", $post->ID );
												$vimeo_id = substr ( $video_info, strpos ( $video_info, "video/" ) + 6, 8 );
												$videos = $vimeo->call ( 'vimeo.videos.getInfo', array (
														'video_id' => $vimeo_id
												) );
												if ($videos)
													$duration = $videos->video [0]->duration;
											} else {
												$duration = get_post_meta ( $post->ID, "video_duration", true );
												// print_r($duration);
											}

											// add post_meta
											if (get_post_meta ( $post->ID, "video_duration" )) :
												update_post_meta ( $post->ID, "video_duration", $duration );
											 else :
												add_post_meta ( $post->ID, "video_duration", $duration );
											endif;

																?>
															<span class="video_duration"><?=date("i:s", $duration); ?></span>
													<a href="<?=get_permalink($post->ID)?>"> <img
														src='<?=CHILD_DIR."/images/playbutton.png"?>' />
													</a>

												</div>
											</li>
											<?php endwhile; ?>
											</ul>
											<?php
												endif; //have_posts

												$post = $backup;
												wp_reset_query(); //to use the original query again */

											endif;
											?>
									</div>
								</div>
								<div class="tab-content" id="tab-2-content">
									<div class="tabs-inner-padding">
										<!-- <h2>Popular Comments from visitors</h2>-->
										<!-- comments section go here -->
										<?php comments_template();?>
									</div>

								</div>
								<!--  tab pane ends here -->

							</div>
						</div>
						<!--  related videos end -->
						<div class="clear"></div>
					</div>
				</div>
			<?php endwhile; // end of the loop. ?>
			</div>
		</section>
		<!-- /#main -->

		<?php // get_sidebar(); ?>

	</div>

</div>
<!-- /#content -->

<?php get_footer(); ?>