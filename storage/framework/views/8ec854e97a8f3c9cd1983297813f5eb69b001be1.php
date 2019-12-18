<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Strut Architekten - Administration</title>
<link href="<?php echo e(mix('assets/admin/css/app.css')); ?>" type="text/css" rel="stylesheet" />
<meta name="csrf-token" value="<?php echo e(csrf_token()); ?>" />
</head>
<body>
<div id="app">
    <app-component></app-component>
</div>
<script src="<?php echo e(mix('assets/admin/js/app.js')); ?>" type="text/javascript"></script>
</body>
</html><?php /**PATH /home/archit10/www/strut.ch/resources/views/admin/app.blade.php ENDPATH**/ ?>