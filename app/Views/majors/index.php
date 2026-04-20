<?php
 $this->extend('layout/main_template');
 $this->section('content');
?>
<div class="main_content flex-grow-1 p-3">
    <?php if(session()->getFlashdata('message')) : ?>
        <div class="alert alert-success" role="alert" id="message">
            <?= session()->getFlashdata('message')?>
        </div>
    <?php endif ?>
    <div class="card p-3">
        <div class="d-flex flex-wrap flex-md-nowrap mb-3" style="gap: 10px;" >
            <a href="/majors/add" class="btn btn-primary flex-shrink-0">
                <i class="fa-solid fa-plus"></i>
                Add Major
            </a>
            <input type="text" id="search" class="form-control flex-grow-1" placeholder="Search Major...">
            <form id="dataPerPageForm" action="/majors" method="get" class="d-flex align-items-center" style="gap: 5px;"> 
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
                        <th>Major</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="default">
                    <?php 
                    $i = $pager->getDetails()['currentPage'] * $data_per_page - $data_per_page;
                    if(count($majors) > 0) :
                        foreach($majors as $major):
                            $i++;?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $major['name'] ?></td>
                                <!-- <td><?php //if($major['is_active'] == 1): ?>
                                    <div class="bg-success p-1 text-white rounded text-center" style="width: 65px">
                                        Active
                                    </div>
                                    <?php //else : ?>
                                    <div class="bg-danger p-1 text-white rounded text-center" style="width: 65px">
                                        Inactive
                                    </div>
                                    <?php //endif; ?>
                                </td> -->
                                <td class="d-flex flex-wrap flex-md-nowrap" style="gap: 5px;">
                                    <button class="btn_det btn btn-sm border" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" modal-data=<?= $major['id'] ?>>
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <a href="<?= base_url('majors/edit?id=' . $major['id']) ?>" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button class="btn_del btn btn-sm btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" modal-data=<?= $major['id'] ?>>
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
            <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure to delete this major?</h1>
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
            <form action="/majors/delete" method="POST" id="delete_form">
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
    let typing;
    let data_per_page = <?= $data_per_page ?>;

    $("#data_per_page").on('change', function(){
        $('#dataPerPageForm').submit();
    });

    $('#search').on('input', function(){
        const query = $(this).val();
        console.log(query);
        clearTimeout(typing);
        let data = {
            query: query
        }
        typing = setTimeout(() => {
            $.ajax({
                url: '/majors/search',
                method: 'POST',
                data: data,
                success: (response) => {
                    console.log('SEARCH RESULT', response);
                }
            });
        }, 500);
    });
</script>
<?php $this->endSection();?>