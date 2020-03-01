<?php
require_once "lib/autoload.php";

$css = array( "style.css");
$viewService->basicHead($css, "Mijn Historiek");

$userservice = $container->getUserService();
$user = $userservice->loadUserWithLoginData($_SESSION['usr_id']);
$viewService->renderLoginHistory($user);
?>
</table>
        </div>
    </div>
    </body>
</html>