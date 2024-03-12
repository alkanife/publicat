<!doctype html>
<html lang="<?= PUBLICAT_LANG ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Serif:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="<?= $this->catLogo('cat.svg') ?>" type="image/x-icon">

    <?php
    if (!empty($this->css)) {
        foreach ($this->css as $stylesheet) {
            echo '<link rel="stylesheet" href="' . $this->css($stylesheet) . '">';
        }
    }
    ?>

    <title><?= $this->pageTitle ?></title>
</head>
<body>
<?php if ($this->isPage()): ?>
    <div id="notifications"></div>
    <div id="overlay"></div>

    <?php

    $this->renderViewNow('commons/Navigation.php');

    if (!$this->isUserConnected()) {
        $this->renderViewNow('commons/RegisterModal.php');
        $this->renderViewNow('commons/LoginModal.php');
    }

    ?>
<?php endif; ?>