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
                        <?= success_flash_message() ?>
                        <?= error_flash_message() ?>
                        <!-- Form -->
                        <div class="card shadow-sm mb-4" style="width: 22rem; margin: 0 auto;">
                            <div class="card-body">
                                <h3 class="card-title mb-3">Account Info</h3>
                                <form action="/account" method="POST">
                                    <?= csrf() ?>
                                    <?= method_spoof('PATCH') ?>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Name</label>
                                        <input type="text" class="form-control form-control-sm" name="name" value="<?= $user->name ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email</label>
                                        <p class="text-muted"><?= $user->email ?></p>
                                    </div>
                                    <button class="btn btn-primary" type="submit" name="updateSubmit">Update</button>
                                </form>
                            </div>
                        </div>
                        <button class="btn btn-outline-danger" type="button" name="deleteAccountBtn">Delete Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="/account" method="POST" name="deleteAccountForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete your account? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <?= csrf() ?>
                    <?= method_spoof('DELETE') ?>
                    <input type="hidden" name="delete" value="true">
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->push('scripts') ?>
<script>
    $(document).ready(function() {
        $('button[name="deleteAccountBtn"]').click(function() {
            $('#deleteModal').modal('show');
        });
    });
</script>
<?php $this->end() ?>