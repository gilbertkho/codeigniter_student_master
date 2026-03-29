<?php 
    $this->extend('layout/main_template');
    $this->section('content'); 
?>
    <div class="main_content flex-grow-1 p-3">
        <h3>Student <?= ucfirst($info) ?> Form</h3>  
        <div class="card">
            <div class="card-header p-3 fw-bold">
                <a href="/students" class="text-decoration-none">Students List</a> / <?= ucfirst($info) ?> Student
            </div>
            <div class="card-body">

                <form id="student_form" action="/students/<?= $info == 'add'? 'add' : 'edit' ?>" method="POST" >
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" class="form-control <?= $validation && $validation->hasError('name')? 'is-invalid' : '' ?>" type="text" name="name" 
                            value="<?= isset($student) ? $student['name'] : old('name') ?>" 
                        />
                        <?php if($validation && $validation->hasError('name')) :?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('name') ?>
                            </div>
                        <?php endIf; ?>
                    </div>
                    <div class="mb-3">
                        <label for="major_id" class="form-label">Major</label>
                        <select id="major_id" class="form-select <?= $validation && $validation->hasError('major_id')? 'is-invalid' : '' ?>" name="major_id">
                            <option value="">Select a major</option>
                            <?php
                                foreach($majors as $major):
                            ?>
                                <option 
                                    value="<?= $major['id'] ?>" 
                                    <?= (isset($student) && $student['major_id'] ==  $major['id']) || old('major_id') == $major['id'] ?'selected' : '' ?>
                                >
                                    <?= $major['name'] ?>
                                </option>
                            <?php    
                                endforeach;
                            ?>
                        </select>
                        <?php if($validation && $validation->hasError('major_id')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('major_id') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control <?= $validation && $validation->hasError('email')? 'is-invalid' : '' ?>"" name="email" id="email" value="<?= isset($student) ? $student['email'] : old('email') ?>" />
                        <?php if($validation && $validation->hasError('email')) :?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('email') ?>
                            </div>
                        <?php endIf; ?>
                    </div>
                    <div class="mb-3">
                        <label for="enrollment_year" class="form-label">Enrollment Year</label>
                        <input id="enrollment_year" class="form-control <?= $validation && $validation->hasError('enrollment_year')? 'is-invalid' : '' ?>"" type="number" min="1990" max="<?= date('Y') ?>" name="enrollment_year" 
                            value="<?= isset($student) ? $student['enrollment_year'] : (old('enrollment_year') ? old('enrollment_year') : date('Y')) ?>" 
                        />
                        <?php if($validation && $validation->hasError('enrollment_year')) :?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('enrollment_year') ?>
                            </div>
                        <?php endIf; ?>
                    </div>
                    <div class="mb-3">
                        <label for="student_id" class="form-label" >Student ID</label>
                        <input id="student_id" class="form-control <?= $validation && $validation->hasError('student_id')? 'is-invalid' : '' ?>"" type="text" name="student_id" readonly value="<?= isset($student) ? $student['student_id'] : old('student_id') ?>" />
                        <?php if($validation && $validation->hasError('student_id')) :?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('student_id') ?>
                            </div>
                        <?php endIf; ?>
                    </div>
                    <div class="mb-3">
                        <label for="is_active">Active</label>
                        <input type='checkbox' id="is_active" class="" name="is_active" <?= isset($student) && $student['is_active'] == 1 ? 'checked' : ''; ?>>
                    </div>
                    <input type='hidden' name='id' value='<?= isset($student) ? $student['id'] : ''?>'>
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
    <script>
        // $("#btn_submit").click(function() {
            
        // });

        $(document).ready(function() {
            const checkStudentId = () => {
                let major = $('#major_id').val();
                let year = $('#enrollment_year').val();
                if(major && year) {
                    year = year.toString().charAt(0) + year.toString().slice(2,4);
                    let fixCode = year + major.toString().padStart(2,'0');
                    $.ajax({
                        url: '/students/counter',
                        type: 'POST',
                        data: {
                            "code" : fixCode
                        },
                        dataType: 'json',
                        success: (response) => {
                            $("#student_id").val(`${fixCode}${response.counter}`);
                        },
                        error: (e) => {
                            console.log(e);
                        }
                    });
                }                
            }

            $("#major_id").change(() => {
                let year = $('#enrollment_year').val();
                if(year && year.length >= 4){
                    checkStudentId();
                    console.log('tes');
                }
            });

            $("#enrollment_year").on('input',(e) => {
                if(e.target.value.length >= 4){
                    checkStudentId();
                }
                if(e.target.value.length > 4){
                    e.target.value =  e.target.value.slice(0,4);
                }
            })

        });
    </script>
<?php 
    $this->endSection(); 
?>