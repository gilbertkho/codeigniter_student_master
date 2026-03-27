
<?php
    $this->extend('layout/main_template');
    $this->section('content');
?>
<h1> Welcome to UC Students Portal</h1>
<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Student ID</th>
            <th>Major</th>
            <th>GPA</th>
            <th>Year of Enrollment</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        // dd($students);
        $i = 0;
        if(count($students) > 0) {
        foreach($students as $student){ $i++;?>
            <tr>
                <td><?= $i ?>
                <td><?= $student['name'] ?></td>
                <td><?= $student['student_id'] ?></td>
                <td><?= $student['major'] ?></td>
                <td><?= $student['gpa'] ?></td>
                <td><?= $student['enrollment_year'] ?></td>
                <td>
                    <a href="<?= base_url('students/edit?id=' . $student['student_id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                    <button class="btn btn-sm btn-danger">
                        delete
                    </button>
                </td>
            </tr>
        <?php } } else {?>
            <tr>
                <td colspan='5' class="text-center">No Students Found</td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php 
    $this->endSection();
?>