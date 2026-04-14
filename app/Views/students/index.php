
<?php
    $this->extend('layout/main_template');
    $this->section('content');
?>
<div class="main_content flex-grow-1 p-3">
    <h1>Hi, <?= ucfirst(session()->get('name')) ?> Welcome to UC Students Master</h1>
    <?php if(session()->getFlashdata('message')) : ?>
        <div class="alert alert-success" role="alert" id="message">
            <?= session()->getFlashdata('message')?>
        </div>
    <?php endif ?>
    <div class="card p-3">
        <div class="d-flex flex-wrap flex-md-nowrap mb-3" style="gap: 10px;" >
            <a href="/students/add" class="btn btn-primary flex-shrink-0">
                <i class="fa-solid fa-plus"></i>
                Add Student
            </a>
            <input type="text" id="search" class="form-control flex-grow-1" placeholder="Search Student...">
            <form id="dataPerPageForm" action="/students" method="get" class="d-flex align-items-center" style="gap: 5px;"> 
                <label for="data_per_page">
                    Row
                </label>
                <select name="data_per_page" id="data_per_page" class="form-select" value="">
                    <option value="5" <?= (isset($data_per_page) && $data_per_page == 5 ? 'selected' : '')?>>5</option>
                    <option value="10" <?= (isset($data_per_page) && $data_per_page == 10 ? 'selected' : '')?>>10</option>
                    <option value="20" <?= (isset($data_per_page) && $data_per_page == 20 ? 'selected' : '')?>>20</option>
                </select>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
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
                    $i = $pager->getDetails()['currentPage'] * $data_per_page - $data_per_page;
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
                                    <div class="bg-success p-1 text-white rounded text-center" style="width: 65px">
                                        Active
                                    </div>
                                    <?php else : ?>
                                    <div class="bg-danger p-1 text-white rounded text-center" style="width: 65px">
                                        Inactive
                                    </div>
                                    <?php endif; ?>
                                </td>
                                <td class="d-flex flex-wrap flex-md-nowrap" style="gap: 5px;">
                                    <button class="btn_det btn btn-sm border" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" modal-data=<?= $student['id'] ?>>
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <a href="<?= base_url('students/edit?id=' . $student['id']) ?>" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button class="btn_del btn btn-sm btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" modal-data=<?= $student['id'] ?>>
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                    <?php  
                        endforeach;
                    else : ?>
                        <tr>
                            <td colspan='7' class="text-center">No Students Found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tbody id="search_result" class="d-none">
                </tbody>
            </table>
        </div>
        <div id="default_pager" class="card-footer text-center <?= $pager->getDetails()['pageCount'] > 1 ? '' : 'd-none' ?>">
            <?= $pager->links() ?>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure to delete this student?</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="feature">
            <div class="row">
                <div class="col-4">Name</div>
                <div class="col-8" id="selected_name"></div>
            </div>
            <div class="row">
                <div class="col-4">Student Id</div>
                <div class="col-8" id="selected_student_id"></div>
            </div>
            <div class="row">
                <div class="col-4">Email</div>
                <div class="col-8" id="selected_email"></div>
            </div>
            <div class="row">
                <div class="col-4">Major</div>
                <div class="col-8" id="selected_major"></div>
            </div>
            <div class="row">
                <div class="col-4">Year of Enrollment</div>
                <div class="col-8" id="selected_yoe"></div>
            </div>
            <div class="row">
                <div class="col-4">Status</div>
                <div class="col-8" id="selected_status"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <form action="/students/delete" method="POST" id="delete_form">
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

    $("#data_per_page").on('change', function(e) {
        $("#dataPerPageForm").submit();
    });

    let selected;
    let search_result = [];
    let typingTimer;
    const waitTime = 500;

    const setModalData = (id) => {
        let students = <?= json_encode($students) ?>;
        let getStudent = students.filter((student) => student.id == id);
        selected = getStudent[0];
        $('#selected_student').val(selected['id']);
        $("#selected_name").text(`: ${selected['name']}`);
        $("#selected_student_id").text(`: ${selected['student_id']}`);
        $("#selected_email").text(`: ${selected['email']}`);
        $("#selected_major").text(`: ${selected['major']}`);
        $("#selected_yoe").text(`: ${selected['enrollment_year']}`);
        $("#selected_status").text(selected['is_active'] == 1 ? ': ACTIVE' : ': INACTIVE');
    }

    $(".btn_del").on('click', function(e) {
        let id = $(this).attr('modal-data');
        setModalData(id);
        $("#exampleModalLabel").text('Delete Confirmation');
        $("#delete_form").show();
    });

    $(".btn_det").on('click', function(e) {
        let id = $(this).attr('modal-data');
        setModalData(id);
        $("#exampleModalLabel").text('Student Detail');
        $("#delete_form").hide();
    });

    $("#search").on('change', function(e){
        if($(this).val() == '') {
            $("#search_result").empty();
            $("#search_result").addClass('d-none');
            $("#default, #default_pager").removeClass('d-none');
        }
    });


    $("#search").on('keyup', function(e){
        clearTimeout(typingTimer);
        if(e.target.value.length < 2) {
            $("#search_result").empty();
            $("#search_result").addClass('d-none');
            $("#default, #default_pager").removeClass('d-none');
            return;
        }
        //console.log(e.target.value);

        let data = {
            query:  e.target.value
        }

        typingTimer = setTimeout(() => {
            $.ajax({
                url: '/students/search',
                data: data,
                method: 'POST',
                success: (response) => {
                    $("#search_result").empty();
                    $("#search_result").removeClass('d-none');
                    $("#default, #default_pager").addClass('d-none');
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
                            <td class="d-flex flex-wrap flex-md-nowrap" style="gap: 5px;">
                                <button class="btn_det btn btn-sm border" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" modal-data=${res['id']}>
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <a href="<?= base_url('students/edit?id=' . $student['id']) ?>" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <button class="btn_del btn btn-sm btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" modal-data=${res['id']}>
                                    <i class="fa-solid fa-trash"></i>
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
        },waitTime);

    })
</script>
<?php 
    $this->endSection();
?>