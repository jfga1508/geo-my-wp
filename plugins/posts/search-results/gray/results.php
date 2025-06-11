<?php

/**
 * Posts locator "gray" search results template file. 
 * 
 * The information on this file will be displayed as the search results.
 * 
 * The function pass 2 args for you to use:
 * $gmw  - the form being used ( array )
 * $post - each post in the loop
 * 
 * You could but It is not recomemnded to edit this file directly as your changes will be overridden on the next update of the plugin.
 * Instead you can copy-paste this template ( the "gray" folder contains this file and the "css" folder ) 
 * into the theme's or child theme's folder of your site and apply your changes from there. 
 * 
 * The template folder will need to be placed under:
 * your-theme's-or-child-theme's-folder/geo-my-wp/posts/search-results/
 * 
 * Once the template folder is in the theme's folder you will be able to choose it when editing the posts locator form.
 * It will show in the "Search results" dropdown menu as "Custom: gray".
 */

// Jean - Modified all results
?>
<!--  Main results wrapper - wraps the paginations, map and results -->
<div class="gmw-results-wrapper gmw-results-wrapper-<?php echo $gmw['ID']; ?> gmw-pt-gray-results-wrapper">

	<?php do_action('gmw_search_results_start', $gmw, $post); ?>

	<!-- results count -->
	<div class="results-count-wrapper">
		<p><?php gmw_results_message($gmw, false); ?></p>
	</div>

	<?php do_action('gmw_search_results_before_top_pagination', $gmw, $post); ?>

	<!--  paginations -->
	<div class="pagination-per-page-wrapper top">
		<?php gmw_per_page($gmw, $gmw['total_results'], 'paged'); ?><?php gmw_pagination($gmw, 'paged', $gmw['max_pages']); ?>
	</div>

	<!-- Map -->
	<?php gmw_results_map($gmw); ?>

	<?php do_action('gmw_search_results_before_loop', $gmw, $post); ?>
	<br><br>
	<p>
		<button class="select-all" style="">Alles selecteren</button>
		<button class="unselect-all" style="">Selectie opheffen</button>
		<button class="downloadbatch" style="display: none;">Selectie downloaden</button>
		<?php
		$my_post_meta = get_post_meta($post->ID, 'gps_export', true);
		if (!empty($my_post_meta)) { ?>
			<button class="downloadgps" style="display: none;">Coordinaten downloaden</button>
		<?php
		}
		?>
	</p>
	<form id="gpsdownload" action="/maps/export_gps" method="POST" style="display: none;">

	</form>
	<?php
	/**
	 * Posts Locator "gray" search form template file. 
	 * 
	 * The information on this file will be displayed as the search forms.
	 * 
	 * The function pass 1 args for you to use:
	 * $gmw  - the form being used ( array )
	 * 
	 * You could but It is not recomemnded to edit this file directly as your changes will be overridden on the next update of the plugin.
	 * Instead you can copy-paste this template ( the "gray" folder contains this file and the "css" folder ) 
	 * into the theme's or child theme's folder of your site and apply your changes from there. 
	 * 
	 * The template folder will need to be placed under:
	 * your-theme's-or-child-theme's-folder/geo-my-wp/posts/search-forms/
	 * 
	 * Once the template folder is in the theme's folder you will be able to choose it when editing the Posts locator form.
	 * It will show in the "Search results" dropdown menu as "Custom: gray".
	 */
	?>
	<?php
	//custom locator button
	if (!function_exists('gmw_locator_button') && $gmw['search_form']['locator_icon'] != 'within_address_field') {
		function gmw_locator_button($button, $gmw, $class)
		{

			$lSubmit = (isset($gmw['search_form']['locator_submit']) && $gmw['search_form']['locator_submit'] == 1) ? 'gmw-locator-submit' : '';

			//remove this filter to prevent it from effecting other forms
			remove_filter('gmw_search_form_locator_button_img', 'gmw_locator_button', 10, 3);

			return '<div id="' . $gmw['ID'] . '" class="gmw-locator-button gmw-locate-btn ' . $class . ' ' . $lSubmit . '">' . $gmw['labels']['search_form']['get_my_location'] . '</div>';
		}
		add_filter('gmw_search_form_locator_button_img', 'gmw_locator_button', 10, 3);
	}
	?>

	<!--  Results wrapper -->
	<ul class="posts-list-wrapper">
		<?php while ($gmw_query->have_posts()) : $gmw_query->the_post(); ?>

			<li id="post-<?php the_ID(); ?>" class="single-post">

				<?php do_action('gmw_search_results_loop_item_start', $gmw, $post);



				$args = array(
					'title' => __('', 'bijlagen'),
					'orderby' => 'title',
					'order' => 'desc',
					'echo' => 1
				);

				?>
				<input type="checkbox" value="" />
				<div style="display:none;"><?php da_display_download_attachments(get_the_ID(), $args) ?></div>

				<!-- Inowex - Jean - Title -->
				<div class="top-wrapper" style="display:inline-block;">
					<h2 class="post-title" data-toggle="modal" data-target=".bs-example-modal-sm" data-lat="<?php echo $post->lat; ?>" data-long="<?php echo $post->long; ?>">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_title(); ?>
						</a>
					</h2>
					<span class="radius"><?php gmw_distance_to_location($post, $gmw); ?></span>

					<!--					<div class="address-wrapper">
				    	<span class="dashicons-before dashicons-location address-icon"></span>
				    	<span class="address"><?php gmw_location_address($post, $gmw); ?></span>
				    </div>-->
					<div id="raw-graf-li" class="d-none"><?php echo strip_tags(get_the_content()); ?></div>
				</div>

				<?php do_action('gmw_posts_loop_before_content', $gmw, $post); ?>

				<!--				<div class="post-content">
					<div class="left-col">
					
						<?php if (isset($gmw['search_results']['featured_image']['use']) && has_post_thumbnail()) { ?>
							
							<?php do_action('gmw_posts_loop_before_image', $gmw, $post); ?>
							
							<div class="post-thumbnail">
								<?php the_post_thumbnail(array($gmw['search_results']['featured_image']['width'], $gmw['search_results']['featured_image']['height'])); ?>
							</div>
						<?php } ?>
						
						<?php if (isset($gmw['search_results']['excerpt']['use'])) { ?>
						
							<?php do_action('gmw_posts_loop_before_excerpt', $gmw, $post); ?>
						
							<div class="excerpt">
								<?php gmw_excerpt($post, $gmw, $post->post_content, $gmw['search_results']['excerpt']['count']); ?>
							</div>
						<?php } ?>
						
						<?php gmw_pt_taxonomies($gmw, $post); ?>
					</div>
					
					<div class="right-col">
						<?php if (!empty($gmw['info_window']['additional_info'])) { ?>
    
					    	<?php do_action('gmw_search_results_before_contact_info', $post, $gmw); ?>
						   	
						   	<div class="contact-info">
								<h4><?php echo $gmw['labels']['info_window']['contact_info']; ?></h4>
					    		<?php gmw_additional_info($post, $gmw, $gmw['search_results']['additional_info'], $gmw['labels']['search_results']['contact_info'], 'div'); ?> 
					    	</div>
					    <?php } ?>
		   			</div>
	   			</div>-->

				<!-- Get directions -->
				<?php if (isset($gmw['search_results']['get_directions'])) { ?>

					<?php do_action('gmw_posts_loop_before_get_directions', $gmw, $post); ?>

					<div class="get-directions-link">
						<?php gmw_directions_link($post, $gmw, false); ?>
					</div>
				<?php } ?>

				<!--  Driving Distance -->
				<?php if (isset($gmw['search_results']['by_driving'])) { ?>
					<?php gmw_driving_distance($post, $gmw, false); ?>
				<?php } ?>

				<?php do_action('gmw_search_results_loop_item_end', $gmw, $post); ?>

			</li><!-- #post -->

		<?php endwhile;	 ?>

	</ul>

	<?php do_action('gmw_search_results_after_loop', $gmw, $post); ?>

	<div class="pagination-per-page-wrapper bottom">
		<!--  paginations -->
		<?php gmw_per_page($gmw, $gmw['total_results'], 'paged'); ?><?php gmw_pagination($gmw, 'paged', $gmw['max_pages']); ?>
	</div>
	<br>
	<p>
		<button class="select-all" style="">Alles selecteren</button>
		<button class="unselect-all" style="">Selectie opheffen</button>
		<button class="downloadbatch" style="display: none;">Selectie downloaden</button>
		<?php
		$my_post_meta = get_post_meta($post->ID, 'gps_export', true);
		if (!empty($my_post_meta)) { ?>
			<button class="downloadgps" style="display: none;">Coordinaten downloaden</button>
		<?php
		}
		?>
	</p>

	<?php do_action('gmw_search_results_end', $gmw, $post); ?>

</div> <!-- output wrapper -->