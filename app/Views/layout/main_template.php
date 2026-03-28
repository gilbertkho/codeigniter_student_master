<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-4.0.0.module.js" integrity="sha256-WK/EJImTrql5EQIEpr2ViDEulDC+Fay9S8aH/huq0IM=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url('style.css') ?>"/>
</head>
<body>
<?= $this->include('layout/navbar') ?>
<?= $this->renderSection('content') ?>
</body>
<footer class='d-flex justify-content-center align-itmes-center p-3'>
    THIS IS FOOTER
</footer>
</html>