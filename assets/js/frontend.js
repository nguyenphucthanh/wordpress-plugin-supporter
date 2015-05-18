jQuery( document ).ready( function ( e ) {
	var popup = jQuery('.supporter-float-widget');

	popup
	.off('click.toggle')
	.on('click.toggle', '.supporter-float-widget-title', function() {
		popup.toggleClass('active');
	});
});