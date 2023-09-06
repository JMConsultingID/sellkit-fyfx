(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
jQuery(document).ready(function($) {
	$('#sellkit-ypf-add-badge-button').click(function(e) {
	    e.preventDefault();

	    var frame = wp.media({
	        title: 'Select or Upload Badge',
	        button: {
	            text: 'Use this badge'
	        },
	        multiple: false
	    });

	    frame.on('select', function() {
	        var attachment = frame.state().get('selection').first().toJSON();
	        var badgeHTML = `
	            <div class="sellkit-ypf-badge">
	                <input type="hidden" name="sellkit_ypf_badges_images_payment[]" value="${attachment.url}" />
	                <img src="${attachment.url}" style="max-width:100px; display:block;" />
	                <button type="button" class="button sellkit-ypf-remove-badge-button">Remove</button>
	            </div>
	        `;
	        $('.sellkit-ypf-badges-wrapper').append(badgeHTML);
	    });

	    frame.open();
	});

	$(document).on('click', '.sellkit-ypf-remove-badge-button', function() {
	    $(this).closest('.sellkit-ypf-badge').remove();
	});
});

})( jQuery );
