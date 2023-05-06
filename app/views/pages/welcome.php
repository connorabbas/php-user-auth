<?php
$this->layout('template::main', [
    'pageTitle' => 'Welcome',
    'pageDesc' => "User Auth",
]);
?>
<div class="d-flex align-items-center justify-content-center" style="height: 90vh">
    <div class="text-center">
        <!-- Flash messages -->
        <?= success_flash_message() ?>
        <?= error_flash_message() ?>
        <h3 class="mb-3">PHP User Auth Application</h3>
        <p class="mb-3 text-muted">Built With <a href="https://github.com/connorabbas/basic-framework#php-basic-framework" target="_blank">Basic PHP Framework</a></p>
    </div>
</div>