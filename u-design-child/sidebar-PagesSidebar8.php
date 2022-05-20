<?php
/**
 * @package WordPress
 * @subpackage U-Design
 */
?>

<?php
	global $udesign_options;
	$sidebar_position = ( $udesign_options['pages_sidebar_8'] == 'left' ) ? 'grid_3 pull_21 sidebar-box' : 'grid_3';
?>
	<div id="sidebar" class="<?php echo $sidebar_position; ?>">
	    <div id="sidebarSubnav">

<?php		    // Widgetized sidebar
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('PagesSidebar8') ) : ?>

			<div class="custom-formatting">
			    <h3><?php esc_html_e('About This Sidebar', 'udesign'); ?></h3>
			    <ul>
				<?php _e("To edit this sidebar, go to admin backend's <strong><em>Appearance -> Widgets</em></strong> and place widgets into the <strong><em>Pages Sidebar 8</em></strong> Widget Area", 'udesign'); ?>
			    </ul>
			</div>

<?php		    endif; ?>
	    </div>
	    <!-- end sidebarSubnav -->
	</div>
	<!-- end sidebar -->


