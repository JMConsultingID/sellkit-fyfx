(function( $ ) {
	'use strict';

	document.addEventListener('DOMContentLoaded', function() {
        var exportButton = document.getElementById('sellkit-ypf-export');
        if (exportButton) {
            exportButton.addEventListener('click', function() {
                window.location.href = '<?php echo admin_url('admin.php?page=sellkit-ypf&sellkit_ypf_export=true'); ?>';
            });
        }
    });

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
