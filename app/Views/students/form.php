<?php 
    $this->extend('layout/main_template');
    $this->section('content'); 
?>
    <?= $info ?>
    <div class="card p-3">
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input id="name" class="form-control" type="text" name="name" value="<?= isset($student) ? $student['name'] : '' ?>" />
            </div>
            <div class="mb-3">
                <label for="major" class="form-label">Major</label>
                <select id="major" class="form-select" name="major">
                    <option value="">Select a major</option>
                    <option value="Computer Science" <?= isset($student) && $student['major'] === 'Computer Science' ? 'selected' : '' ?>>Computer Science</option>
                    <option value="Information Systems" <?= isset($student) && $student['major'] === 'Information Systems' ? 'selected' : '' ?>>Information Systems</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= isset($student) ? $student['email'] : '' ?>" />
            </div>
            <div class="mb-3">
                <label for="enrollment_year" class="form-label">Enrollment Year</label>
                <input id="enrollment_year" class="form-control" type="number" min="1990" max="<?= date('Y') ?>" name="enrollment_year" value="<?= isset($student) ? $student['enrollment_year'] : date('Y') ?>" />
            </div>
            <div class="mb-3">
                <label for="student_id" class="form-label" >Student ID</label>
                <input id="student_id" class="form-control" type="text" name="student_id" value="<?= isset($student) ? $student['student_id'] : '' ?>" />
            </div>
        </form>
    </div>
    <?php
        if(isset($student)){
            echo $student['name'];
            echo $student['student_id'];
        }
    ?>
    <script>
        $(document).ready(function() {
            const checkStudentId = () => {
                let major = $('#major').val();
                let year = $('#enrollment_year').val();
                if(major && year) {
                    let code = major.split(' ');
                    let majorCode = '';
                    if(code.length > 1){
                        code.forEach((char) => {
                            majorCode += char.charAt(0).toUpperCase();
                        })
                    }
                    year = year.toString().charAt(0) + year.toString().slice(2,4);
                    $("#student_id").val(majorCode + year);
                }                
            }

            $("#major").change(() => {
                let year = $('#enrollment_year').val();
                if(year && year.length >= 4){
                    checkStudentId();
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