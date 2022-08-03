<?php
$this->layout('template::main', [
    'pageTitle' => 'User Info',
    'pageDesc' => "User Info",
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
                        <div class="card shadow" style="width: 22rem; margin: 0 auto;">
                            <div class="card-body">
                                <h3 class="card-title mb-3">Update Info</h3>
                                <form action="tbd" method="post">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Name</label>
                                        <input type="text" class="form-control form-control-sm" name="username"
                                            placeholder="Username" value="<?= $user->name ?>" required>
                                    </div>
                                    <button class="btn btn-primary" name="updateSubmit">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>