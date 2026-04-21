<?php 
    $this->extend('layout/main_template');
    $this->section('content'); 
?>
    <div class="main_content flex-grow-1 p-3">
        <h3>Major <?= ucfirst($info) ?> Form</h3>  
        <div class="card">
            <div class="card-header p-3 fw-bold">
                <a href="/majors" class="text-decoration-none">Majors List</a> / <?= ucfirst($info) ?> Major
            </div>
            <div class="card-body">
                <form id="major_form" action="/majors/<?= $info == 'add'? 'add' : 'edit' ?>" method="POST" >
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" class="form-control <?= $validation && $validation->hasError('name')? 'is-invalid' : '' ?>" type="text" name="name" 
                            value="<?= isset($major) ? $major['name'] : old('name') ?>" 
                        />
                        <?php if($validation && $validation->hasError('name')) :?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('name') ?>
                            </div>
                        <?php endIf; ?>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="is_active">Active</label>
                        <input type='checkbox' id="is_active" class="" name="is_active" <?php //isset($major) && $major['is_active'] == 1 ? 'checked' : ''; ?>>
                    </div> -->
                    <input type='hidden' name='id' value='<?= isset($major) ? $major['id'] : '' ?>'>
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