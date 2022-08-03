<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page Title -->
    <title>PHP Mini Framework - <?= $pageTitle ?></title>

    <!-- SEO Tags -->
    <meta name="robots" content="max-snippet:-1,max-image-preview:standard,max-video-preview:-1" />
    <meta name="description" content="<?= $pageDesc ?>" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?= URL ?>" />
    <meta property="og:site_name" content="PHP Mini Framework" />
    <meta property="og:title" content="PHP Mini Framework - <?= $pageTitle ?>" />
    <meta property="og:description" content="<?= $pageDesc ?>" />
    <meta property="og:image" content="/images/php-logo.png" />
    <meta property="og:image:width" content="1280" />
    <meta property="og:image:height" content="670" />

    <!-- Resources -->
    <link href="/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">PHP User Auth</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <?= $this->section('content') ?>

    <!-- Script Resources -->
    <script src="/js/bootstrap/bootstrap.bundle.min.js"></script>

</body>

</html>