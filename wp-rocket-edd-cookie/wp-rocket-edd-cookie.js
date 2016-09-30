jQuery(document).ready(function ($) {

	// @todo Remove custom cookie when cart is cleared.

	// Add custom cookie
	$('body').on('click.wpRocketEDDCookie', '.edd-add-to-cart', function (e) {

		e.preventDefault();

		var $this          = $(this);
		var form           = $this.parents('form').last();
		var download       = $this.data('download-id');
		var variable_price = $this.data('variable-price');
		var price_mode     = $this.data('price-mode');
		var item_price_ids = [];
		var free_items     = true;

		if( variable_price == 'yes' ) {

			if ( form.find('.edd_price_option_' + download).is('input:hidden') ) {
				item_price_ids[0] = $('.edd_price_option_' + download, form).val();
				if ( form.find('.edd-submit').data('price') && form.find('.edd-submit').data('price') > 0 ) {
					free_items = false;
				}

				// WP Rocket custom cookie
				document.cookie = 'wp_rocket_edd=' + item_price_ids[0] +  '; expires=0; path=/';
			} else {
				if( ! form.find('.edd_price_option_' + download + ':checked', form).length ) {
					return;
				}

				form.find('.edd_price_option_' + download + ':checked', form).each(function( index ) {
					item_price_ids[ index ] = $(this).val();

					// WP Rocket custom cookie
					document.cookie = 'wp_rocket_edd=' + item_price_ids[ index ] +  '; expires=0; path=/';
				});
			}

		} else {
			item_price_ids[0] = download;
			if ( $this.data('price') && $this.data('price') > 0 ) {
				free_items = false;
			}

			// WP Rocket custom cookie
			document.cookie = 'wp_rocket_edd=' + item_price_ids[0] +  '; expires=0; path=/';
		}

		return false;
	});
});