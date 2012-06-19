<?php

session_start();
include 'site/extra/securimage.php';

$img = new securimage();

$img->show(); // alternate use:  $img->show('/path/to/background.jpg');

?>
