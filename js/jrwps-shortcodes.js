(function() {

    tinymce.PluginManager.add('jrwps_shortcodes_button', function( editor )
    {
        var shortcodeValues = [];
        var shortcodes_button = {
                  'Bloc CA':'[ca]',
                  'Bloc Carte':'[map]',
                  'Diaporama Galerie':'[galerie-slider]'
        };

        jQuery.each(shortcodes_button, function(i)
        {
            shortcodeValues.push({value:shortcodes_button[i], text: i});
        });
        editor.addButton('jrwps_shortcodes_button', {
            type: 'listbox',
            text: 'Ajouter une section',
            onselect: function(e) {
                var v = e.control._value;
                tinyMCE.activeEditor.selection.setContent(e.control._value);
                
            },
            values: shortcodeValues
        });
    });
})();