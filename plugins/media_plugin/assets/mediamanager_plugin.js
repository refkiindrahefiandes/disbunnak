// TinyMCE image manager plugin
(function($) {
    tinymce.create('tinymce.plugins.mediamanager', {
        init: function(editor, url) {
            editor.addButton('mediamanager', {
                text: 'Insert Media',
                icon: 'image',
                onclick: function() {
                    $('#modal-media').remove();
                    var Url = "http://localhost/pesonablog/admin/media/file_manager/";
                    ajaxRequest(Url);
                }
            });
        }
    });
    tinymce.PluginManager.add('mediamanager', tinymce.plugins.mediamanager);
})($);