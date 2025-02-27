<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/root.css">
</head>
<body>
    <header>
        <nav class="navbar" role="navigation" aria-label="main navigation">
            <div class="navbar__left">
                <button id="theme-toggle" class="theme-toggle__button" aria-pressed="false">
                    <span id="theme-icon">Light Mode</span>
                </button>
            </div>
            <div class="navbar__right">
                <a class="navbar__container" href={{link}}>
                    <button class="navbar__button">
                        <span class="navbar_button--paddingEven">{{link}}</span>
                    </button>
                </a>
            </div>
        </nav>
    </header>
    <?php
        include 'web.php';
    ?>
    <script src="../../javascript/logoAnimation.js" defer></script>
    <script>const link = '/login';</script>
<!--    <script src="javascript/templating.js"></script>-->
<!-- TODO: Fix templating breaking requests for logging in -->
</body>
</html>

<?php
?>