<?php

use classes\DOCUMENT;

require_once $_SERVER['DOCUMENT_ROOT'].'/module/init.php';

$html = file_get_contents(__DIR__."/panel/main.html");

$document = new DOCUMENT($html);
print_r($document->render());
exit;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel='icon' type='image/png' href='<?php echo $head['icon']["@32"] ?>'>
    <link rel='icon' sizes='192x192' href='<?php echo $head['icon']["@192"] ?>'>
    <link rel='apple-touch-icon' href='<?php echo $head['icon']["@125"] ?>'>
    <meta name='msapplication-square310x310logo' content='<?php echo $head['icon']["@310"] ?>'>

    <!-- Primary Meta Tags -->
    <title><?php echo $head['title'] ?></title>
    <meta name="title" content="<?php echo $head['title'] ?>">
    <meta name="description" content="<?php echo $head['description'] ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $head['url'] ?>">
    <meta property="og:title" content="<?php echo $head['title'] ?>">
    <meta property="og:description" content="<?php echo $head['description'] ?>">
    <meta property="og:image" content="<?php echo $head['image'] ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo $head['url'] ?>">
    <meta property="twitter:title" content="<?php echo $head['title'] ?>">
    <meta property="twitter:description" content="<?php echo $head['description'] ?>">
    <meta property="twitter:image" content="<?php echo $head['image'] ?>">

</head>

<body>

</body>

</html>