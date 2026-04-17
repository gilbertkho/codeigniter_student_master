<?php
    $this->extend('layout/main_template');
    $this->section('content');
?>
<div class="main_content flex-grow-1 p-3">
    <h3>Admin Profile</h3>  
    <div class="card">
        <div class="card-body">
            <?php if(session()->getFlashdata('message')) : ?>
            <div class="alert alert-success" role="alert" id="message">
                <?= session()->getFlashdata('message')?>
            </div>
            <?php endif ?>
            <form id="student_form" action="/admin/edit" method="POST" >
                <?= csrf_field(); ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input id="name" class="form-control <?= $validation && $validation->hasError('name')? 'is-invalid' : '' ?>" type="text" name="name" 
                        value="<?= isset($admin) ? $admin['name'] : old('name') ?>" 
                    />
                    <?php if($validation && $validation->hasError('name')) :?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('name') ?>
                        </div>
                    <?php endIf; ?>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control <?= $validation && $validation->hasError('email')? 'is-invalid' : '' ?>"" name="email" id="email" value="<?= isset($admin) ? $admin['email'] : old('email') ?>" />
                    <?php if($validation && $validation->hasError('email')) :?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('email') ?>
                        </div>
                    <?php endIf; ?>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control <?= $validation && $validation->hasError('password')? 'is-invalid' : '' ?>"" name="password" id="password" value="<?= isset($admin) ? $admin['password'] : old('password') ?>" />
                    <?php if($validation && $validation->hasError('password')) :?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('password') ?>
                        </div>
                    <?php endIf; ?>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control <?= $validation && $validation->hasError('confirm_password')? 'is-invalid' : '' ?>"" name="confirm_password" id="confirm_password" value="" />
                    <?php if($validation && $validation->hasError('confirm_password')) :?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('confirm_password') ?>
                        </div>
                    <?php endIf; ?>
                </div>
                <input type='hidden' name='id' value='<?= isset($admin) ? $admin['id'] : ''?>'>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" id="btn_submit">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>      
</div>
<?php
    $this->endSection();
?>