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

		<?php if ( isset( $woo_options['woo_breadcrumbs_show'] ) && $woo_options['woo_breadcrumbs_show'] == 'true' ) { ?>
		<section id="breadcrumbs">
			<?php// woo_breadcrumbs(); ?>
		</section>
		<!--/#breadcrumbs -->
		<?php } ?>

		<section id="main" class="col-left">

			<div id="main-content" class="grid_24">
				<div class="main-content-padding">
					<!-- video thumbnail and brief description goes here -->
					<div class="top-content">
						<div class="chapter-title">
							<h1>Chapter 1 Introduction to Conscious Breathing</h1>
						</div>
						<div class="top-padding-content">
							<div class="left-content video-thumbnail">
								<img src='<?=CHILD_DIR."/images/chapter_1_logo.jpg"?>'
									width="528" height="362" />
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
							<h1>Detailed Descriptions goes here...</h1>
							<p>In this chaper we are going to lead you into the world of
								conscious breathing</p>
						</section>
					</div>
					<!-- detaield description ends here -->
					<div class="clear"></div>
					<!--  related videos -->
					<div class="bottom-content">
						<div class="related-video">
							<h2>In this chapter you can watch following videos...</h2>
							<ul class="video-thumbs">
								<li class="view view-first"><img
									src='<?=CHILD_DIR."/images/chapter_1_thumb.png"?>' width="260"
									height="144" />
									<div class="mask">
										<p>chatper 1-1 vieo...</p>
										<a href="http://localhost/anderson/?product=chapter-2-1-2"> <img
											src='<?=CHILD_DIR."/images/playbutton.png"?>' />
										</a>

									</div></li>
								<li class="view view-first"><img
									src='<?=CHILD_DIR."/images/chapter_1_thumb.png"?>' width="260"
									height="144" />
									<div class="mask">
										<p>chatper 1-2 vieo...</p>
										<a href="http://localhost/anderson/?product=chapter-2-1-2"> <img
											src='<?=CHILD_DIR."/images/playbutton.png"?>' />
										</a>
									</div></li>
								<li class="view view-first"><img
									src='<?=CHILD_DIR."/images/chapter_1_thumb.png"?>' width="260"
									height="144" />
									<div class="mask">
										<p>chatper 1-3 vieo...</p>
										<a href="http://localhost/anderson/?product=chapter-2-1-2"> <img
											src='<?=CHILD_DIR."/images/playbutton.png"?>' />
										</a>
									</div></li>
								<li class="view view-first"><img
									src='<?=CHILD_DIR."/images/chapter_1_thumb.png"?>' width="260"
									height="144" />
									<div class="mask">
										<p>chatper 1-4 vieo...</p>
										<a href="http://localhost/anderson/?product=chapter-2-1-2"> <img
											src='<?=CHILD_DIR."/images/playbutton.png"?>' />
										</a>
									</div></li>
								<li class="view view-first"><img
									src='<?=CHILD_DIR."/images/chapter_1_thumb.png"?>' width="260"
									height="144" />
									<div class="mask">
										<p>chatper 1-5 vieo...</p>
										<a href="http://localhost/anderson/?product=chapter-2-1-2"> <img
											src='<?=CHILD_DIR."/images/playbutton.png"?>' />
										</a>
									</div></li>
								<li class="view view-first"><img
									src='<?=CHILD_DIR."/images/chapter_1_thumb.png"?>' width="260"
									height="144" />
									<div class="mask">
										<p>chatper 1-6 vieo...</p>
										<a href="http://localhost/anderson/?product=chapter-2-1-2"> <img
											src='<?=CHILD_DIR."/images/playbutton.png"?>' />
										</a>
									</div></li>
							</ul>
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