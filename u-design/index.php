<?php
/**
 * @package WordPress
 * @subpackage U-Design
 */
if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header();

	// Home Page Main Content Widget Areas
	$cont_1_is_active = sidebar_exist_and_active('home-page-column-1');
	$cont_2_is_active = sidebar_exist_and_active('home-page-column-2');
	$cont_3_is_active = sidebar_exist_and_active('home-page-column-3');
	$cont_4_is_active = sidebar_exist_and_active('home-page-column-4');
	$home_page_col_1_fixed = $udesign_options['home_page_col_1_fixed'];
	$after_cont_row_1_is_active = sidebar_exist_and_active('home-page-after-content-row-1');
	$after_cont_row_2_is_active = sidebar_exist_and_active('home-page-after-content-row-2');
	$active_count = $cont_1_is_active + $cont_2_is_active + $cont_3_is_active + $cont_4_is_active;

	if ( $cont_1_is_active || $cont_2_is_active || $cont_3_is_active || $cont_4_is_active || $after_cont_row_1_is_active ) : // hide this area if no widgets are active...
?>

<div id="content-container" class="container_24">
	<div id="main-content" class="grid_24">
		<div class="main-content-padding">
<?php
                        $output = '';
			// all 4 active: 1 case
			if ( $cont_1_is_active && $cont_2_is_active && $cont_3_is_active && $cont_4_is_active ) {
			    $output .= get_dynamic_column( 'cont-box-1', 'one_fourth home-cont-box', 'home-page-column-1' );
			    $output .= get_dynamic_column( 'cont-box-2', 'one_fourth home-cont-box', 'home-page-column-2' );
			    $output .= get_dynamic_column( 'cont-box-3', 'one_fourth home-cont-box', 'home-page-column-3' );
			    $output .= get_dynamic_column( 'cont-box-4', 'one_fourth home-cont-box last_column', 'home-page-column-4' );
			}
			// 3 active: 4 cases
			if ( $cont_1_is_active && $cont_2_is_active && $cont_3_is_active && !$cont_4_is_active ) {
			    $output .= get_dynamic_column( 'cont-box-1', 'one_third home-cont-box', 'home-page-column-1' );
			    $output .= get_dynamic_column( 'cont-box-2', 'one_third home-cont-box', 'home-page-column-2' );
			    $output .= get_dynamic_column( 'cont-box-3', 'one_third home-cont-box last_column', 'home-page-column-3' );
			}
			if ( $cont_1_is_active && $cont_2_is_active && !$cont_3_is_active && $cont_4_is_active ) {
			    $output .= get_dynamic_column( 'cont-box-1', 'one_third home-cont-box', 'home-page-column-1' );
			    $output .= get_dynamic_column( 'cont-box-2', 'one_third home-cont-box', 'home-page-column-2' );
			    $output .= get_dynamic_column( 'cont-box-4', 'one_third home-cont-box last_column', 'home-page-column-4' );
			}
			if ( $cont_1_is_active && !$cont_2_is_active && $cont_3_is_active && $cont_4_is_active ) {
			    $output .= get_dynamic_column( 'cont-box-1', 'one_third home-cont-box', 'home-page-column-1' );
			    $output .= get_dynamic_column( 'cont-box-3', 'one_third home-cont-box', 'home-page-column-3' );
			    $output .= get_dynamic_column( 'cont-box-4', 'one_third home-cont-box last_column', 'home-page-column-4' );
			}
			if ( !$cont_1_is_active && $cont_2_is_active && $cont_3_is_active && $cont_4_is_active ) {
			    $output .= get_dynamic_column( 'cont-box-2', 'one_third home-cont-box', 'home-page-column-2' );
			    $output .= get_dynamic_column( 'cont-box-3', 'one_third home-cont-box', 'home-page-column-3' );
			    $output .= get_dynamic_column( 'cont-box-4', 'one_third home-cont-box last_column', 'home-page-column-4' );
			}
			// 2 active: 6 cases:
			if ( $home_page_col_1_fixed && $active_count == 2 ) { // if "Home Page Column 1" Widget Area width is set to be fixed (applies only for 2 columns active)
			    if ( $cont_1_is_active && !$cont_2_is_active && $cont_3_is_active ) {
				$output .= get_dynamic_column( 'cont-box-1', 'one_third home-cont-box', 'home-page-column-1' );
				$output .= get_dynamic_column( 'cont-box-3', 'two_third home-cont-box last_column', 'home-page-column-3' );
			    }
			    if ( $cont_1_is_active && $cont_2_is_active && !$cont_3_is_active ) {
				$output .= get_dynamic_column( 'cont-box-1', 'one_third home-cont-box', 'home-page-column-1' );
				$output .= get_dynamic_column( 'cont-box-2', 'two_third home-cont-box last_column', 'home-page-column-2' );
			    }
			    if ( $cont_1_is_active && !$cont_2_is_active && !$cont_3_is_active && $cont_4_is_active ) {
				$output .= get_dynamic_column( 'cont-box-1', 'one_third home-cont-box', 'home-page-column-1' );
				$output .= get_dynamic_column( 'cont-box-4', 'two_third home-cont-box last_column', 'home-page-column-4' );
			    }
			} else { // if "Home Page Column 1" Widget Area width is NOT set to fixed span the two colums equally
			    if ( $cont_1_is_active && $cont_2_is_active && !$cont_3_is_active && !$cont_4_is_active ) {
				$output .= get_dynamic_column( 'cont-box-1', 'one_half home-cont-box', 'home-page-column-1' );
				$output .= get_dynamic_column( 'cont-box-2', 'one_half home-cont-box last_column', 'home-page-column-2' );
			    }
			    if ( $cont_1_is_active && !$cont_2_is_active && $cont_3_is_active && !$cont_4_is_active ) {
				$output .= get_dynamic_column( 'cont-box-1', 'one_half home-cont-box', 'home-page-column-1' );
				$output .= get_dynamic_column( 'cont-box-3', 'one_half home-cont-box last_column', 'home-page-column-3' );
			    }
			    if ( $cont_1_is_active && !$cont_2_is_active && !$cont_3_is_active && $cont_4_is_active ) {
				$output .= get_dynamic_column( 'cont-box-1', 'one_half home-cont-box', 'home-page-column-1' );
				$output .= get_dynamic_column( 'cont-box-4', 'one_half home-cont-box last_column', 'home-page-column-4' );
			    }
			}
			if ( !$cont_1_is_active && $cont_2_is_active && $cont_3_is_active && !$cont_4_is_active ) {
			    $output .= get_dynamic_column( 'cont-box-2', 'one_half home-cont-box', 'home-page-column-2' );
			    $output .= get_dynamic_column( 'cont-box-3', 'one_half home-cont-box last_column', 'home-page-column-3' );
			}
			if ( !$cont_1_is_active && $cont_2_is_active && !$cont_3_is_active && $cont_4_is_active ) {
			    $output .= get_dynamic_column( 'cont-box-2', 'one_half home-cont-box', 'home-page-column-2' );
			    $output .= get_dynamic_column( 'cont-box-4', 'one_half home-cont-box last_column', 'home-page-column-4' );
			}
			if ( !$cont_1_is_active && !$cont_2_is_active && $cont_3_is_active && $cont_4_is_active ) {
			    $output .= get_dynamic_column( 'cont-box-3', 'one_half home-cont-box', 'home-page-column-3' );
			    $output .= get_dynamic_column( 'cont-box-4', 'one_half home-cont-box last_column', 'home-page-column-4' );
			}
			// 1 active: 4 cases
			if ( $cont_1_is_active && !$cont_2_is_active && !$cont_3_is_active && !$cont_4_is_active ) {
			    $output .= get_dynamic_column( 'cont-box-1', 'full_width home-cont-box', 'home-page-column-1' );
			}
			if ( !$cont_1_is_active && $cont_2_is_active && !$cont_3_is_active && !$cont_4_is_active ) {
			    $output .= get_dynamic_column( 'cont-box-2', 'full_width home-cont-box', 'home-page-column-2' );
			}
			if ( !$cont_1_is_active && !$cont_2_is_active && $cont_3_is_active && !$cont_4_is_active ) {
			    $output .= get_dynamic_column( 'cont-box-3', 'full_width home-cont-box', 'home-page-column-3' );
			}
			if ( !$cont_1_is_active && !$cont_2_is_active && !$cont_3_is_active && $cont_4_is_active ) {
			    $output .= get_dynamic_column( 'cont-box-4', 'full_width home-cont-box', 'home-page-column-4' );
			}

			// home-page-after-content-row-1 Widget Area
			if ( $after_cont_row_1_is_active ) {
                            echo '<div class="clear"></div>';
			    $output .= get_dynamic_column( 'after-cont-row-1', 'full_width home-cont-box', 'home-page-after-content-row-1' );
			    //programatically populating data
			    ob_start();
?>

			    <!-- by first limit -->
			    <!--<div class="main-content-padding"> -->
			    <div class="textwidget_myown">
			    		<?php
			    		$args = array (
			    				'hide_empty' => 0
			    		);
			    		$taxonomy = 'chapter';
			    		$terms = get_terms ( $taxonomy, $args );
			    		// print_r($terms);
					    if (! empty ( $terms ) && ! is_wp_error ( $terms )) :
					    $count = count ( $terms );
					    $i = 0;
					    foreach ( $terms as $term ) :
					    $term = sanitize_term ( $term, $taxonomy );
					    $term_link = get_term_link ( $term, $taxonomy );
					    // if error
					    if (is_wp_error ( $term_link ))
					    	continue;
					    ?>
					    					<div class="one_third <?php if($i%3==2) echo "last_column";?>" >
					    						<div class="product-box-wrapper">
					    							<a href="<?=$term_link ?>">
					    							<span class="title_descr"><?=get_field('chapter_title','chapter_'.$term->term_id)?></span>
					    							</a>
					    							<div class="product-box">
					    								<a class="product-image"
					    									href="<?=$term_link ?>"><img
					    									class="attachment-shop_catalog wp-post-image"
					    									src="<?=get_field('chapter_thumbnail','chapter_'.$term->term_id)?>"
					    									alt="product_1_1" width="207" height="124" /></a>
					    								<div class="product-details">
					    									<div class="chapter-description">
					    										<a class="product-name"
					    											href="<?=$term_link ?>"><?php echo term_description($term->term_id,$taxonomy);?></a>
					    									</div>
					    									<div class="learn-more-button">
					    										<a class="button  product_type_simple"
					    											href="<?=$term_link ?>"
					    											rel="nofollow" data-product_id="57" data-product_sku="">Läs mer</a>
					    									</div>
					    								</div>
					    							</div>
					    						</div>
					    					</div>

					    					<?php
					    						if($i % 3 == 2) echo '<span style="display:block;clear:both;height: 0px;padding-top: 20px;"></span>';
					    						$i++;
					    						endforeach;	?>
					    				<?php endif;?>
					    		</div>
					    		<!-- </div> -->
					    		<!--  end first limit -->
			<?php
				$ven_contents = '<div class="after_cont_row_1 widget_text substitute_widget_class">'.ob_get_clean().'</div>';
				$output .= get_dynamic_column_contents($ven_contents,'after-cont-row-1', 'full_width home-cont-box', 'home-page-after-content-row-1' );
			}
			?>

			<?php
			// home-page-after-content-row-2 Widget Area
			if ( $after_cont_row_2_is_active ) {
                            echo '<div class="clear"></div>';
			    $output .= get_dynamic_column( 'after-cont-row-2', 'full_width home-cont-box', 'home-page-after-content-row-2' );
			}

                        echo $output;


                    //    query_posts( array ( 'post_type' => 'product'));
?>
		      </div>
		<div class='clear'></div>
		<!-- custom video thumbnail test -->
		<!-- by rollover
				<p>I love here</p>
				<div class="bottom-content">
					<div class="related-video">
						<h2>All chapters are listed here...</h2>
					<?php
			$args = array (
					'hide_empty' => 0
			);
			$taxonomy = 'chapter';
			$terms = get_terms ( $taxonomy, $args );
			// print_r($terms);
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
																	<li class="view view-fifth"><img
								src='<?=get_field('chapter_thumbnail','chapter_'.$term->term_id)?>'
								width="260" height="144" />
								<div class="mask">
									<p><?=get_field('chapter_title','chapter_'.$term->term_id)?></p>
									<a href="<?=$term_link ?>" class="info">Read </a> <img
										src='<?=CHILD_DIR."/images/playbutton.png"?>' />
								</div></li>
																	<?php
				endforeach;
				?>
												</ul>
												<?php endif;?>
											</div>
				</div>
				-->

		<!-- end main-content-padding -->
	</div>
	<!-- end main-content -->
</div>
<!-- end content-container -->
<!--
			<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	    <div class="clear"></div>

<?php	endif; ?>

 -->
<?php	get_footer();







