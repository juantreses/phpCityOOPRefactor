<?php
require_once "lib/autoload.php";

$css = array( "style.css");

$viewService->basicHead($css);
$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Formulier File Upload</h1>
</div>

<?php $viewService->printNavBar(); ?>

<div class="container">
    <div class="row">

        <?php
        print $viewService->loadTemplate("form_file_upload");

        $images = glob( "img/*.{jpg,png,gif}", GLOB_BRACE );
        $viewService->displayImages($images);
        ?>

    </div>
</div>

</body>
</html>