(function( $ ) {
    document.addEventListener('DOMContentLoaded', function() {
        var cssEditor = document.querySelector('textarea[name="sellkit_fyfx_custom_css"]');
        if (cssEditor) {
            wp.codeEditor.initialize(cssEditor, {type: 'text/css'});
        }
    });
})( jQuery );
