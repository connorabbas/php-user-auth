<?php
$this->layout(
    'template::main',
    [
        'pageTitle' => 'Login',
        'pageDesc' => "User Auth",
    ]
);
?>
<div class="mt-5 mb-5">
    <div id="logInOuter">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div style="width: 22rem; margin: 0 auto;">
                        <?= error_flash_message() ?>
                        <div class="card shadow-sm" style="width: 22rem; margin: 0 auto;">
                            <div class="card-body">
                                <h3 class="card-title mb-3">Login</h3>
                                <form action="/login" method="post">
                                    <?= csrf() ?>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email</label>
                                        <input type="email" class="form-control form-control" name="email"
                                            placeholder="Email" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="" class="form-label">Password</label>
                                        <input type="password" class="form-control form-control" name="password"
                                            placeholder="Your Password" required>
                                    </div>
                                    <button class="btn btn-primary" name="loginSubmit">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>