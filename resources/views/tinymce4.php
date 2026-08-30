<!DOCTYPE html>
<html lang="<?= app()->getLocale() ?>">
    <head>
        <meta charset="utf-8">
        <title>elFinder 2.0</title>

        <!-- jQuery and jQuery UI (REQUIRED) -->
        <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.14.2/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
        <script src="//code.jquery.com/ui/1.14.2/jquery-ui.min.js" integrity="sha256-mblSWfbYzaq/f+4akyMhE6XELCou4jbkgPv+JQPER2M=" crossorigin="anonymous"></script>

        <!-- elFinder CSS (REQUIRED) -->
        <link rel="stylesheet" type="text/css" href="<?= \Barryvdh\Elfinder\AssetHelper::asset($dir, 'css/elfinder.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= \Barryvdh\Elfinder\AssetHelper::asset($dir, 'css/theme.css') ?>">

        <!-- elFinder JS (REQUIRED) -->
        <script src="<?= \Barryvdh\Elfinder\AssetHelper::asset($dir, 'js/elfinder.min.js') ?>"></script>

        <?php if($locale){ ?>
            <!-- elFinder translation (OPTIONAL) -->
            <script src="<?= \Barryvdh\Elfinder\AssetHelper::asset($dir, "js/i18n/elfinder.$locale.js") ?>"></script>
        <?php } ?>
        
        <!-- elFinder initialization (REQUIRED) -->
        <script type="text/javascript">
            var FileBrowserDialogue = {
                init: function() {
                    // Here goes your code for setting your custom things onLoad.
                },
                mySubmit: function (URL) {
                    // pass selected file path to TinyMCE
                    parent.tinymce.activeEditor.windowManager.getParams().setUrl(URL);

                    // close popup window
                    parent.tinymce.activeEditor.windowManager.close();
                }
            }

            $().ready(function() {
                var elf = $('#elfinder').elfinder({
                    // set your elFinder options here
                    <?php if($locale){ ?>
                        lang: '<?= $locale ?>', // locale
                    <?php } ?>
                    customData: { 
                        _token: '<?= csrf_token() ?>'
                    },
                    url: '<?= route("elfinder.connector") ?>',  // connector URL
                    soundPath: '<?= asset($dir.'/sounds') ?>',
                    getFileCallback: function(file) { // editor callback
                        FileBrowserDialogue.mySubmit(file.url); // pass selected file path to TinyMCE
                    }
                }).elfinder('instance');
            });
        </script>
    </head>
    <body>

        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="elfinder"></div>

    </body>
</html>
