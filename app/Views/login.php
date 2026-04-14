<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UC Admin Dashboard - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-4.0.0.module.js" integrity="sha256-WK/EJImTrql5EQIEpr2ViDEulDC+Fay9S8aH/huq0IM=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('style.css') ?>"/>
    <style>
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <form action="/login" method="POST">
        <div class="login-container">
            <h3>Admin Login</h3>
            <?php if(session()->getFlashdata('message')) : ?>
                <div class="alert alert-info" role="alert" id="message">
                    <?= session()->getFlashdata('message')?>
                </div>
            <?php endif ?>
            <div>
                <input type='text' name='email' placeholder='Email' class="form-control <?= $validation && $validation->hasError('email') ? 'is-invalid' : '' ?>">
                <?php if($validation && $validation->hasError('email')) : ?>
                    <div class='invalid-feedback'>
                        <?= $validation->getError('email') ?>
                    </div>
                <?php endif ?>
            </div>
            <div>
                <input type='password' name='password' placeholder='Password' class="form-control <?=  $validation && $validation->hasError('password') ? 'is-invalid' : '' ?>">
                <?php if($validation && $validation->hasError('password')) : ?>
                    <div class='invalid-feedback'>
                        <?= $validation->getError('password') ?>
                    </div>
                <?php endif ?>
            </div>
            <button type='submit' class="btn btn-success">Login</button>
            <small>Don't have an account?<a href="/register"> Register here</a> </small>
        </div>
    </form>
</body>
</html>