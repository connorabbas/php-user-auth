<?php
$this->layout('template::main', [
    'pageTitle' => 'Account Info',
    'pageDesc' => "User Auth",
]);
?>
<div class="mt-5 mb-5">
    <div id="logInOuter">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div style="width: 22rem; margin: 0 auto;">
                        <!-- Flash messages -->
                        <?= successFlashMessage() ?>
                        <?= errorFlashMessage() ?>

                        <!-- Form -->
                        <div class="card shadow-sm mb-4" style="width: 22rem; margin: 0 auto;">
                            <div class="card-body">
                                <h3 class="card-title mb-3">Account Info</h3>
                                <form action="/update-name" method="post">
                                    <?= csrf() ?>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Name</label>
                                        <input type="text" class="form-control form-control-sm" name="name" value="<?= $user->name ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email</label>
                                        <p class="text-muted"><?= $user->email ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Username</label>
                                        <p class="text-muted"><?= $user->username ?></p>
                                    </div>
                                    <button class="btn btn-primary" type="submit" name="updateSubmit">Update</button>
                                </form>
                                <form action="delete-account" method="post">
                                    <input type="hidden" name="delete" value="true">
                                </form>
                                <!-- TODO Delete account modal -->
                            </div>
                        </div>
                        <button class="btn btn-outline-danger" type="button" name="deleteAccountBtn">Delete Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>