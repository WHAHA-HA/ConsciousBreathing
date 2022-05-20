<?php
/**
 * Template Name: 28-day-template
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


<div id="page-content">

	<div id="content-container" class="container_24">

		<?php if ( isset( $woo_options['woo_breadcrumbs_show'] ) && $woo_options['woo_breadcrumbs_show'] == 'true' ) { ?>
		<section id="breadcrumbs">
			<?php woo_breadcrumbs(); ?>
		</section><!--/#breadcrumbs -->
		<?php } ?>

		<section id="main" class="col-left">
			<div><img src="<?php bloginfo('stylesheet_directory')?>/images/28-day-logo.jpg" /></div>

			<?php
				$message="";

				$current_user = wp_get_current_user();
			    $user_id= $current_user->ID ;
				if ($user_id!=0){//when user was logged
					$query="SELECT * FROM `tw_course` WHERE `user_id`=".$user_id." AND `finish_status`=0 AND `course_current_step`>=1";
					$result1=$wpdb->get_row($query);
					if ($result1){
						$course_current_step=$result1->course_current_step;
						$goto_step=$course_current_step+1;
						if ($course_current_step==7){
							$message="You passed all steps(step1~step7) already! You can finish this course in step-7 page. ";
						}else{
							$message="You passed by step-".$course_current_step." already! You should pass step-".$goto_step.".";
						}
					}
				}
			?>
			<div class="message" ><?php echo $message;?></div>
			<div class="step" stepNum="1">
				<div class="step-name" title="Please click the link to go to step 1">
					<a href="http://consciousbreathing.com/28-dagars-step-1">Step 1</a>
				</div>
				<div class="step-description">
					Learn more about your current breathing habits by answering the questions in the Breathing Index.
				</div>
			</div>
			<div class="step" stepNum="2">
				<div class="step-name" title="Please click the link to go to step 2">
					<a href="http://consciousbreathing.com/28-dagars-step-2">Step 2</a>
				</div>
				<div class="step-description">
					Write down three main goals related to your wellbeing.
				</div>
			</div>
			<div class="step" stepNum="3">
				<div class="step-name" title="Please click the link to go to step 3">
					<a href="http://consciousbreathing.com/28-dagars-step-3">Step 3</a>
				</div>
				<div class="step-description">
					Create a personal visualization or image that you can connect to each goal.
				</div>
			</div>
			<div class="step" stepNum="4">
				<div class="step-name" title="Please click the link to go to step 4">
					<a href="http://consciousbreathing.com/28-dagars-step-4">Step 4</a>
				</div>
				<div class="step-description">
					Complete the schedule for your day-to-day breathing habits, at the end of each week.
				</div>
			</div>
			<div class="step" stepNum="5">
				<div class="step-name" title="Please click the link to go to step 5">
					<a href="http://consciousbreathing.com/28-dagars-step-5">Step 5</a>
				</div>
				<div class="step-description">
					Complete the training schedule for 28 days – Relaxator, taped mouth at night, and physical activity
					with your mouth closed.
				</div>
			</div>
			<div class="step" stepNum="6">
				<div class="step-name" title="Please click the link to go to step 6">
					<a href="http://consciousbreathing.com/28-dagars-step-6">Step 6</a>
				</div>
				<div class="step-description">
					Answer the questions in the Breathing Index once more for evaluation.
				</div>
			</div>
			<div class="step" stepNum="7">
				<div class="step-name" title="Please click the link to go to step 7">
					<a href="http://consciousbreathing.com/28-dagars-step-7">Step 7</a>
				</div>
				<div class="step-description">
					Find out how your health and wellbeing has been affected by doing the breathing re-training.
				</div>
			</div>

			<div style="margin-top:10px;"><img src="<?php bloginfo('stylesheet_directory')?>/images/evaluation_image.jpg" /></div>
		</section><!-- /#main -->

		<?php //get_sidebar(); ?>

	</div>

</div><!-- /#content -->

<?php get_footer(); ?>