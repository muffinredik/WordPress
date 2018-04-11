(function() {
    tinymce.PluginManager.add('medani_mce_button', function(editor, url) {
        editor.addButton('medani_mce_button', {
            icon: false,
            text: "Newsmodul",
            onclick: function() {
                editor.insertContent('[newsmodul]');
            }
        });
    });
})();