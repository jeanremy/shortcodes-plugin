(function() {
    tinymce.PluginManager.add('jrwps_column_button', function( editor, url ) {
        editor.addButton( 'jrwps_column_button', {
            title: 'Colonnes',
            text: 'Colonnes', 
            icon: false, 
            onclick: function() {
                console.log()
                editor.windowManager.open( {

                    title: 'Insérer deux colonnes',
                    width: 700,
                    height: 600,
                    body: [
                    {
                        type: 'label',
                        name: 'label',
                        text: 'Tapez ou collez le texte brut en sautant des lignes, vous pourrez le mettre en forme par la suite'
                    },
                    {
                        type: 'textbox',
                        name: 'column1',
                        label: 'Colonne 1',
                        multiline: true,
                        minWidth: 300,
                        minHeight: 100

                    },
                    {
                        type: 'textbox',
                        name: 'column2',
                        label: 'Colonne 2',
                        multiline: true,
                        minWidth: 300,
                        minHeight: 100

                    }],
                    onsubmit: function( e ) {
                        var lines1 = e.data.column1.split("\n"),
                            lines2 = e.data.column2.split("\n"),
                            column1 = "",
                            column2 = "";


                        for (var i = 0, j = lines1.length; i < j; i++) {
                            column1 += '<p>'+lines1[i]+'</p>';
                        };
                        for (var i = 0, j = lines2.length; i < j; i++) {
                            column2 += '<p>'+lines2[i]+'</p>';
                        };
                        editor.insertContent( '<!-- Debut des colonnes --><div><div class="row"><div class="col-sm-6">' + column1 + '</div><div class="col-sm-6">' + column2 + '</div></div></div><!-- Fin des colonnes -->');
                    }
                });
            }

        });
    });
})();