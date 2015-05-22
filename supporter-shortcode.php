<?php
/*shortcode*/
function shortcodeBootstrapGrid( $atts ) {
	$a = shortcode_atts( array(
        'columns' => 2
    ), $atts );

	$supporters = Supporter_Object::getAll();

	if(count($supporters) == 0) {
		return;
	}

	$span = 12 / $a['columns'];

	?>
		<ul class="row list-unstyled supporter-grid">
			<?php
				$index = 0;
				foreach ($supporters as $spt) {
					?>
						<li class="col-md-<?php echo $span; ?> col-sm-<?php echo $span; ?>">
							<h5>
								<?php echo $spt->name ?>
							</h5>
							<ul class="list-inline">
								<?php if(strlen($spt->tel_number) > 0) { ?>
									<li>
										<a href="tel:<?php echo $spt->tel_number_formatter; ?>">
											<i class="fa fa-phone"></i> <?php echo $spt->tel_number; ?>
										</a>
									</li>
								<?php } ?>

								<?php if(strlen($spt->skype_id) > 0) { ?>
									<li>
										<a href="skype:<?php echo $spt->skype_id; ?>?chat">
											<i class="fa fa-skype"></i> <?php echo $spt->skype_id; ?>
										</a>
									</li>
								<?php } ?>

								<?php if(strlen($spt->yahoo_id) > 0) { ?>
									<li>
										<a href="ymsgr:sendIM?<?php echo $spt->yahoo_id; ?>">
											<i class="fa fa-yahoo"></i> <?php echo $spt->yahoo_id; ?>
										</a>
									</li>
								<?php } ?>
							</ul>
						</li>

						<?php

							$index += 1;
							if($index % $a['columns'] == 0) {
								?>
									<li class="clearfix"></li>
								<?php
							}
						?>
					<?php
				}
			?>
		</ul>
	<?php

    wp_enqueue_style('awesome-font', '//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css');
}

add_shortcode( 'supporter-bootstrap-grid', 'shortcodeBootstrapGrid' );

?>