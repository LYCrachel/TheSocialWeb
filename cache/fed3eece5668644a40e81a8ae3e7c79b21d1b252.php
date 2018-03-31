<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Social Web</title>
    <link rel="stylesheet" href="../resources/bower/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../resources/bower/bootstrap-select/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="../resources/css/socialweb.css">
    <?php echo $__env->yieldContent('custom-css'); ?>
</head>

<body>

<script src="../resources/bower/jquery/dist/jquery.min.js"></script>
<script src="../resources/bower/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../resources/bower/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="../resources/js/socialweb.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>

<?php echo $__env->make('components/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldContent('content'); ?>
<?php echo $__env->yieldContent('custom-js'); ?>

</body>
</html>