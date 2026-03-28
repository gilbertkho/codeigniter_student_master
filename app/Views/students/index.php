
<?php
    $this->extend('layout/main_template');
    $this->section('content');
?>
<div class="main_content mx-auto">
    <h1> Welcome to UC Students Portal</h1>
    <?php if(session()->getFlashdata('message')) : ?>
        <div class="alert alert-success" role="alert" id="message">
            <?= session()->getFlashdata('message')?>
        </div>
    <?php endif ?>
    <input type="text" id="search" class="form-control" placeholder="Search Student...">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Student ID</th>
                <th>Major</th>
                <th>Year of Enrollment</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="default">
            <?php 
            // dd($students);
            $i = 0;
            if(count($students) > 0) :
                foreach($students as $student):
                    $i++;?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $student['name'] ?></td>
                        <td><?= $student['student_id'] ?></td>
                        <td><?= $student['major'] ?></td>
                        <td><?= $student['enrollment_year'] ?></td>
                        <td><?php if($student['is_active'] == 1): ?>
                            <p class="bg-success p-1 text-white d-inline rounded">
                                Active
                            </p>
                            <?php
                                else :
        
                            ?>
                            <p class="bg-danger p-1 text-white d-inline rounded">
                                Inactive
                            </p>
                            <?php
                                endif;
                            ?>
                        </td>
                        <td>
                            <a href="<?= base_url('students/edit?id=' . $student['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                            <button class="btn_del btn btn-sm btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" modal-data=<?= $student['id'] ?>>
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php  endforeach;
            else :?>
                <tr>
                    <td colspan='7' class="text-center">No Students Found</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tbody id="search_result" class="d-none">
        </tbody>
    </table>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure to delete this student?</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="feature">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <form action="/students/delete" method="POST">
                <?= csrf_field(); ?>
                <input type="hidden" id="selected_student" name="id" value="">
                <button type="submit" class="btn btn-primary" id="delete">Save changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>

<script>
    let btn_del = $(".btn_del");
    let selected;
    $(".btn_del").on('click', function(e) {
            let data = $(this).attr('modal-data');
            let students = <?= json_encode($students) ?>;
            // console.log(students);
            let getStudent = students.filter((student) => student.id == data);
            selected = getStudent[0].id;
            $('#selected_student').val(selected);
    });

    $("#search").on('change', function(e){
        if($(this).val() == '') {
            console.log('KOSONG');
        }
    });


    $("#search").on('keyup', function(e){
        if(e.target.value.length < 2) {
            $("#search_result").empty();
            $("#search_result").addClass('d-none');
            $("#default").removeClass('d-none');
            return;
        }
        //console.log(e.target.value);

        let data = {
            query:  e.target.value
        }
        $.ajax({
            url: '/students/search',
            data: data,
            method: 'POST',
            success: (response) => {
                $("#search_result").empty();
                $("#search_result").removeClass('d-none');
                $("#default").addClass('d-none');
                console.log(response.results);
                if(response.results.length > 0){
                    let result_element = ``;
                    let i = 0;
                    response.results.forEach((res) => {
                    i++;
                    result_element += 
                    `<tr>
                        <td>${i}</td>
                        <td>${res['name']}</td>
                        <td>${res['student_id']}</td>
                        <td>${res['major']}</td>
                        <td>${res['enrollment_year']}</td>
                        <td>
                            ${res['is_active'] == 1 ?
                                '<p class="bg-success p-1 text-white d-inline rounded"> Active</p>'
                                :
                                '<p class="bg-danger p-1 text-white d-inline rounded"> Inactive </p>'
                            }
                        </td>
                        <td>
                            <a href="<?= base_url('students/edit?id=' . $student['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                            <button class="btn_del btn btn-sm btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" modal-data=<?= $student['id'] ?>>
                                Delete
                            </button>
                        </td>
                    </tr>`
                    });
                    $("#search_result").append(result_element);
                }
            },
            error: (e) => {
                console.log(e);
            }
        })
    })
</script>
<?php 
    $this->endSection();
?>