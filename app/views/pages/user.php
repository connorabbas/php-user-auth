<?php
$this->layout('template::main', [
    'pageTitle' => 'User Info',
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
                        <div class="card shadow" style="width: 22rem; margin: 0 auto;">
                            <div class="card-body">
                                <h3 class="card-title mb-3">Update Info</h3>
                                <form action="/update-name" method="post">
                                    <?= csrf() ?>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Name</label>
                                        <input type="text" class="form-control form-control-sm" name="name" value="<?= $user->name ?>" required>
                                    </div>
                                    <button class="btn btn-primary" type="submit" name="updateSubmit">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>