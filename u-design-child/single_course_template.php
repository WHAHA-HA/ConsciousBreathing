<?php
/**
 * Template Name: Chapter Page Template xxx
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
		<section id="breadcrumbs">
			<?php// woo_breadcrumbs(); ?>
		</section>
		<!--/#breadcrumbs -->
		<?php } ?>
		<p>gottcha</p>
		<section id="main" class="col-left">

			<div id="main-content" class="grid_24">
				<div class="main-content-padding">
					<!-- video thumbnail and brief description goes here -->
					<div class="top-content">
						<div class="chapter-title">

						</div>
						<div class="top-padding-content">
							<div class="left-content video-thumbnail">

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
					<!-- detaield description ends here -->
					<div class="clear"></div>
					<!--  related videos -->
					<!--  all videos for chapters are listed here... -->
					<div class="bottom-content">
						<div class="related-video">
							<h2>All chapters are listed here...</h2>
												<?php
												$args = array (
														'hide_empty' =>0
												);
												$taxonomy = 'chapter';
												$terms = get_terms ( $taxonomy, $args );
												//print_r($terms);
												if (! empty ( $terms ) && ! is_wp_error ( $terms )) :
													$count = count ( $terms );
													$i = 0;

													?>
												<ul class="video-thumbs">
												<?php
													foreach ( $terms as $term ) :
														$term = sanitize_term ( $term, $taxonomy );
														$term_link = get_term_link ( $term, $taxonomy );
														// if error
														if (is_wp_error ( $term_link ))
															continue;
														?>
												<li class="view view-first"><img
												src='<?=get_field('chapter_thumbnail','chapter_'.$term->term_id)?>' width="260"
												height="144" />
												<div class="mask">
													<p><?=get_field('chapter_title','chapter_'.$term->term_id)?></p>
													<a href="<?=$term_link ?>"> <img
														src='<?=CHILD_DIR."/images/playbutton.png"?>' />
													</a>
												</div></li>
												<?php
													endforeach;
													?>
							</ul>
							<?php endif;?>
						</div>
					</div>
					<!--  related videos end -->
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