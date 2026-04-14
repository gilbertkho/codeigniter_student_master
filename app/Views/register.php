<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UC Dashboard - Register</title>
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
    <form action="/register" method="POST">
        <div class="login-container">
            <h3>Admin Registration</h3>
            <div class="form-group">
                <label for="name">Name</label> 
                <input type="text" name="name" placeholder="Name" 
                value="<?= old('name') ? old('name') : '' ?>"
                class="form-control <?= isset($validation) && $validation->hasError('name') ? 'is-invalid' : '' ?>" id="name">
                <?php if(isset($validation) && $validation->getError('name')) : ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('name') ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="email">Email</label> 
                <input type="text" name="email" placeholder="Email" 
                value="<?= old('email') ? old('email') : '' ?>"
                class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>" id="email">
                <?php if(isset($validation) && $validation->getError('email')) : ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('email') ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password">Password</label> 
                <input type="password" name="password" placeholder="Password" 
                class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" id="password">
                <?php if(isset($validation) && $validation->getError('password')) : ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('password') ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label> 
                <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control <?= isset($validation) && $validation->hasError('confirm_password') ? 'is-invalid' : '' ?>" id="confirm_password">
                <?php if(isset($validation) && $validation->getError('confirm_password')) : ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('confirm_password') ?>
                </div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-success">Register</button>
            <small>Already have an account?<a href="/login">Login here</a><small>
        </div>
    </form>
</body>
</html>