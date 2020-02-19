<?php
require_once "lib/autoload.php";

$css = array( "style.css");
BasicHead( $css );
$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Formulier File Upload</h1>
</div>

<?php PrintNavBar(); ?>

<div class="container">
    <div class="row">

        <?php
        $views = new ViewService();
        print $views->loadTemplate("form_file_upload");

        $images = glob( "img/*.{jpg,png,gif}", GLOB_BRACE );
        $views->displayImages($images);
        ?>

    </div>
</div>

</body>
</html>