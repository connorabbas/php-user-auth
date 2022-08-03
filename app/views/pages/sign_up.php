<?php
$this->layout('template::main', [
    'pageTitle' => 'Login',
    'pageDesc' => "User Login",
]);
?>
<div class="d-flex align-items-center justify-content-center" style="height: 90vh">
    <div id="signupOuter">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card shadow" style="width: 22rem; margin: 0 auto;">
                        <div class="card-body">
                            <h3 class="card-title mb-3">Sign-Up</h3>
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="" class="form-label">Name</label>
                                    <input type="text" class="form-control form-control-sm" name="name"
                                        placeholder="Full Name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Email address</label>
                                    <input type="email" class="form-control form-control-sm" name="email"
                                        placeholder="name@example.com" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Username</label>
                                    <input type="text" class="form-control form-control-sm" name="username"
                                        placeholder="Username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Password</label>
                                    <input type="password" class="form-control form-control-sm" name="password"
                                        placeholder="Your Password" required>
                                    <!-- <i class="bi bi-eye-slash" id="togglePassword"></i> -->
                                </div>
                                <div class="mb-4">
                                    <label for="" class="form-label">Repeat Password</label>
                                    <input type="password" class="form-control form-control-sm" name="passwordR"
                                        placeholder="Repeat Your Password" required>
                                </div>
                                <button class="btn btn-primary" name="signUpSubmit">Create Account</button>
                            </form>
                            <div id="yourcontainer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>