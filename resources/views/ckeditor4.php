<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>elFinder 2.0</title>

    <!-- jQuery and jQuery UI (REQUIRED) -->
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" href="<?= asset($dir.'/css/elfinder.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset($dir.'/css/theme.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset($dir.'/css/popup.css') ?>">

    <!-- elFinder JS (REQUIRED) -->
    <script src="<?= asset($dir.'/js/elfinder.min.js') ?>"></script>

    <?php if($locale){ ?>
        <!-- elFinder translation (OPTIONAL) -->
        <script src="<?= asset($dir."/js/i18n/elfinder.$locale.js") ?>"></script>
    <?php } ?>

    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        // Helper function to get parameters from the query string.
        function getUrlParam(paramName) {
            var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
            var match = window.location.search.match(reParam) ;

            return (match && match.length > 1) ? match[1] : '' ;
        }

        // Helper function to calculate elfinder element height
        function getElfinderHeight() {
            return $(window).height() - 2;
        }

        // Initialize elfinder
        $().ready(function() {
            var funcNum = getUrlParam('CKEditorFuncNum');

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
                getFileCallback : function(file) {
                    window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
                    window.close();
                },
                resizable: false,
                height: getElfinderHeight()
            }).elfinder('instance');

            // Resize elfinder element when popup window is resized
            $(window).on('resize', function() {
                $('#elfinder').height(getElfinderHeight());
            }).trigger('resize');

        });
    </script>
</head>
<body>
    <!-- Element where elFinder will be created (REQUIRED) -->
    <div id="elfinder"></div>
</body>
</html>
