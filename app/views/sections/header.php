<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-fixed-top" style="z-index: 10000;">
    <div class="container">
        <a class="navbar-brand" href="/">PHP User Auth</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto flex-nowrap">
                <?php if (!loggedIn()): ?>
                    <li class="nav-item me-4">
                        <a class="nav-link" href="/register">Register</a>
                    </li>
                    <li class="nav-item me-4">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                <?php else: ?>
                    <span class="navbar-text text-light me-4">
                        Welcome, <?= $_SESSION['user_name'] ?>
                    </span>
                    <li class="nav-item">
                        <form action="/logout" method="post">
                            <?= csrf() ?>
                            <button type="submit" class="btn nav-link">Logout</button>
                        </form>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>