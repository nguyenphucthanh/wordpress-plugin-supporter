<?php
require_once( 'includes/lib/class-supporter-object.php' );
function loadSupporters() {
	$optionEnableFloat = get_option('supporter_enable_float', true);
	$optionCustomCSS = get_option('supporter_custom_css', '');
	if(!$optionEnableFloat) {
		return;
	}

	$supporters = Supporter_Object::getAll();

	if(count($supporters) == 0) {
		return;
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
					$haveTel = '';
					if(strlen($supporter->tel_number) > 0) {
						$haveTel = 'have-tel';
					}
					?>
						<div class="supporter-item columns-<?php echo $supporter->columns; ?> <?php echo $haveTel; ?>">
							<div class="supporter-item-name">
								<span class="fa fa-user"></span> <?php echo $supporter->name; ?>
							</div>
							<?php
								if(strlen($supporter->tel_number) > 0) {
									?>
										<a class="tel" href="tel:<?php echo $supporter->tel_number_formatted; ?>">
											<span class="fa fa-phone fa-2x"></span>
											<?php echo $supporter->tel_number; ?>
										</a>
									<?php
								}
								if(strlen($supporter->skype_id) > 0) {
									?>
										<a class="skype" href="skype:<?php echo $supporter->skype_id; ?>?chat">
											<span class="fa fa-skype fa-2x"></span>
										</a>
									<?php
								}
								if(strlen($supporter->yahoo_id) > 0) {
									?>
										<a class="yahoo" href="ymsgr:sendIM?<?php echo $supporter->yahoo_id; ?>">
											<span class="fa fa-yahoo fa-2x"></span>
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