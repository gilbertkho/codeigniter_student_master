<?php
    $this->extend('layout/main_template');
    $this->section('content');
?>
<div class="card">
    <h1>Admin Profile</h1>
    <p>Name: <?= session()->get('name') ?></p>
</div>
<?php
    $this->endSection();
?>