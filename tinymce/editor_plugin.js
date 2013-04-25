/**
 * @author Justin Hunt <poodllsupport@gmail.com>
 */

(function() {
    var each = tinymce.each;

    tinymce.PluginManager.requireLangPack('youtube');

    tinymce.create('tinymce.plugins.youtubePlugin', {
        init : function(ed, url) {
            var t = this;

            t.editor = ed;
            t.url = url;

            // Register commands.
            ed.addCommand('mceyoutube', function() {
                ed.windowManager.open({
                    file : url + '/youtube.htm',
                    width : 600 + parseInt(ed.getLang('youtube.delta_width', 0)),
                    height : 500 + parseInt(ed.getLang('youtube.delta_height', 0)),
                    inline : 1
                }, {
                    plugin_url : url
                });
            });

            // Register buttons.
            ed.addButton('youtube', {
                    title : 'youtube.desc',
                    image : url + '/img/icon.png',
                    cmd : 'mceyoutube'});

        },

        _parse : function(s) {
            return tinymce.util.JSON.parse('{' + s + '}');
        },

        getInfo : function() {
            return {
                longname : 'YouTube Anywhere',
                author : 'Justin Hunt <poodllsupport@gmail.com>',
                version : "1.0"
            };
        }

    });

    // Register plugin.
    tinymce.PluginManager.add('youtube', tinymce.plugins.youtubePlugin);
})();
