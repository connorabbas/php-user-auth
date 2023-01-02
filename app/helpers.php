<?php

/**
 * Helper functions available anywhere within the application (in the current request)
 */

if (!function_exists('container')) {
    function container(string $classReference)
    {
        global $container;
        return $container->get($classReference);
    }
}

/**
 * access config values by using "." as the nesting delimiter
 */
if (!function_exists('config')) {
    function config(string $configPath)
    {
        $configKeys = explode('.', $configPath);
        $config = (new App\Data\Config($_ENV))->get();
        $finalKey = $config;

        for ($i = 0; $i < count($configKeys); $i++) {
            $finalKey = $finalKey[$configKeys[$i]];
        }

        return $finalKey;
    }
}

/**
 * Spoof the request method for an html form
 */
if (!function_exists('method_spoof')) {
    function method_spoof(string $method): string
    {
        $validMethods = ['PUT', 'PATCH', 'DELETE'];
        $method = strtoupper($method);
        $input = '';

        if (in_array($method, $validMethods)) {
            ob_start();
            ?>
            <input type="hidden" name="_method" value="<?= $method ?>">
            <?php
            $input = ob_get_clean();
        }

        return $input;
    }
}

/**
 * Set csrf token input for form
 */
if (!function_exists('csrf')) {
    function csrf()
    {
        if (!isset($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(50));
        }

        ob_start();
        ?>
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <?php
        $input = ob_get_clean();

        return $input;
    }
}

/**
 * Check csrf data from form is valid
 */
if (!function_exists('csrf_valid')) {
    function csrf_valid()
    {
        if (!isset($_SESSION['csrf']) || !isset($_REQUEST['csrf'])) {
            return false;
        }
        if ($_SESSION['csrf'] != $_REQUEST['csrf']) {
            return false;
        }

        return true;
    }
}

if (!function_exists('handle_csrf')) {
    function handle_csrf()
    {
        if (!csrf_valid()) {
            $_SESSION['flash_error_msg'] = 'Invalid request. Possible cross site request forgery detected.';
            back();
        }
    }
}

/**
 * Redirect to a different route
 */
if (!function_exists('redirect')) {
    function redirect(string $route)
    {
        header("location: " . $route);
        exit();
    }
}

/**
 * Redirect to previous page
 */
if (!function_exists('back')) {
    function back()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

if (!function_exists('success_flash_message')) {
    function success_flash_message()
    {
        $successAlert = '';
        if (isset($_SESSION['flash_success_msg']) && $_SESSION['flash_success_msg'] != '') {
            ob_start();
            ?>
            <div class="alert alert-success mb-3" role="alert">
                <?= $_SESSION['flash_success_msg'] ?>
            </div>
            <?php
            $successAlert = ob_get_clean();
            unset($_SESSION["flash_success_msg"]);
        }

        return $successAlert;
    }
}

if (!function_exists('error_flash_message')) {
    function error_flash_message()
    {
        $errorAlert = '';
        if (isset($_SESSION['flash_error_msg']) && $_SESSION['flash_error_msg'] != '') {
            ob_start();
            ?>
            <div class="alert alert-danger mb-3" role="alert">
                <?php if(is_array($_SESSION['flash_error_msg'])): ?>
                    <ul>
                        <?php foreach ($_SESSION['flash_error_msg'] as $message): ?>
                            <li><?= $message ?></li>
                        <?php endforeach ?>
                    </ul>
                <?php else: ?>
                    <?= $_SESSION['flash_error_msg'] ?>
                <?php endif ?>
            </div>
            <?php
            $errorAlert = ob_get_clean();
            unset($_SESSION["flash_error_msg"]);
        }

        return $errorAlert;
    }
}

if (!function_exists('logged_in')) {
    function logged_in()
    {
        if(isset($_SESSION['user_id'])){
            return true;
        }
        return false;
    }
}

if (!function_exists('current_user')) {
    function current_user()
    {
        if(!isset($_SESSION['user_id'])){
            return null;
        }
        return container('App\Models\User')->getById($_SESSION['user_id']);
    }
}
