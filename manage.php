<?php

session_start();

$isSu = include_once "Services/Auth/isSu.php";
if (!isset($_SESSION["user"]) || !$isSu)
{
    http_response_code(403);

    die("You are not authorized");
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <?php include("Layout/head.php"); ?>
</head>
<body>

<?php include("Layout/navbar.php");?>

<div class="container">

    <main>
        <?php include("Templates/Manage/manage.php"); ?>
    </main>

    <?php include("Layout/footer.php");?>

</div>
</body>
</html>