<?php
$this->layout('template::main', [
    'pageTitle' => 'Register',
    'pageDesc' => "User Auth",
]);
?>
<div class="mt-5 mb-5">
    <div id="signupOuter">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div style="width: 22rem; margin: 0 auto;">
                        <?= errorFlashMessage() ?>
                        <div class="card shadow">
                            <div class="card-body">
                                <h3 class="card-title mb-3">Register</h3>
                                <form action="/register" method="post">
                                    <?= csrf() ?>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Name</label>
                                        <input type="text" class="form-control form-control" name="name"
                                            placeholder="Full Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email address</label>
                                        <input type="email" class="form-control form-control" name="email"
                                            placeholder="name@example.com" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Username</label>
                                        <input type="text" class="form-control form-control" name="username"
                                            placeholder="Username" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Password</label>
                                        <input type="password" class="form-control form-control" name="password"
                                            placeholder="Your Password" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="" class="form-label">Repeat Password</label>
                                        <input type="password" class="form-control form-control" name="passwordR"
                                            placeholder="Repeat Your Password" required>
                                    </div>
                                    <button class="btn btn-primary" name="signUpSubmit">Create Account</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>