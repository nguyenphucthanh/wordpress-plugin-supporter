<?php

function loadSupporters() {
	$optionEnableFloat = get_option('supporter_enable_float', true);
	$optionCustomCSS = get_option('supporter_custom_css', '');
	if(!$optionEnableFloat) {
		return;
	}

	global $wpdb;
	$querystr = "
		SELECT $wpdb->posts.ID,
		$wpdb->posts.post_title

		FROM $wpdb->posts
		
		WHERE $wpdb->posts.post_status = 'publish' 
		AND $wpdb->posts.post_type = 'supporter'
		AND $wpdb->posts.post_date < NOW()
		ORDER BY $wpdb->posts.post_date DESC
	";

	$supporters = $wpdb->get_results($querystr, OBJECT);

	foreach ($supporters as $key => $value) {
		$query = "
		SELECT $wpdb->postmeta.meta_key, $wpdb->postmeta.meta_value

		FROM $wpdb->postmeta

		WHERE $wpdb->postmeta.post_id = " . $supporters[$key]->ID . "
		";

		$supporters[$key]->meta_info = $wpdb->get_results($query, OBJECT);
	}

	?>

	<div class="supporter-float-widget">
		<div class="supporter-float-widget-title">
			<div class="toggler">
				<span class="fa fa-chevron-up up"></span>
				<span class="fa fa-chevron-down down"></span>
			</div>
			<span class="title-icon">
				<i class="fa fa-comment"></i>
			</span>
			<span class="title"><?php _e('Supporters', 'supporter') ?></span>
		</div>
		<div class="supporter-float-widget-content">
			<?php
				foreach ($supporters as $supporter) {
					$instant = array();
					foreach ($supporter->meta_info as $meta) {
						$key = $meta->meta_key;
						$value = $meta->meta_value;
						if(!is_null($value) && strlen($value) > 0) {
							if($key == 'skype_id') {
								$instant['skype_id'] = $value;
							}
							else if($key == 'yahoo_id') {
								$instant['yahoo_id'] = $value;
							}
							else if($key == 'tel_number') {
								$instant['tel_number'] = $value;
							}
						}
					}
					?>
						<div class="supporter-item columns-<?php echo count($instant); ?>">
							<div class="supporter-item-name">
								<span class="fa fa-user"></span> <?php echo $supporter->post_title; ?>
							</div>
							<?php
								if(isset($instant['skype_id'])) {
									?>
										<a class="skype" href="skype:<?php echo $instant['skype_id']; ?>?chat">
											<span class="fa fa-skype fa-2x"></span>
										</a>
									<?php
								}
								if(isset($instant['yahoo_id'])) {
									?>
										<a class="yahoo" href="ymsgr:sendIM?<?php echo $instant['yahoo_id']; ?>">
											<span class="fa fa-yahoo fa-2x"></span>
										</a>
									<?php
								}
								if(isset($instant['tel_number'])) {
									?>
										<a class="tel" href="tel:<?php echo $instant['tel_number']; ?>">
											<span class="fa fa-phone fa-2x"></span>
										</a>
									<?php
								}
							?>
						</div>
					<?php
				}
			?>
		</div>
	</div>
	<style>

		<?php echo $optionCustomCSS; ?>
		
	</style>
	<?php

	wp_enqueue_style('awesome-font', '//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css');
}

add_action( 'wp_footer', 'loadSupporters' );


?>