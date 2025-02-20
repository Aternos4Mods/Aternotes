
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/root.css">
    <script src="javascript/logoAnimation.js"></script>
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
                <a class="navbar__container" href="/login">
                    <button class="navbar__button">
                        <span class="navbar_button--paddingEven">Log in</span>
                    </button>
                </a>
            </div>
        </nav>
    </header>
    <?php
        $url = $_SERVER['REQUEST_URI'] ?? 'home';
        switch ($url) {
            case '/':
                include 'views/home.php';
                break;
            case '/login':
                include 'views/login.php';
                break;
            default:
                include 'views/404.php';
                break;
        }
    ?>
</body>
</html>