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
        $uploadService = new UploadService();
        $uploadService->LoadUploadPage();

//        print LoadTemplate("form_file_upload");
//
//        $images = glob( "img/*.{jpg,png,gif}", GLOB_BRACE );
//        $i =0;
//        foreach( $images as $img )
//        {
//
//            $replaceData[$i]['img']= "'".$img."'" ;
//            $i++;
//        }
//        print ReplaceContent($replaceData,LoadTemplate("file_upload_img"));
        ?>

    </div>
</div>

</body>
</html>