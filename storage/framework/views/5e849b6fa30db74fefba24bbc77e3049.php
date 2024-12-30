<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sammighty</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Favicon icon -->
        <link rel="icon"   href="https://pay.sammighty.com.ng/user/wall.png">
        <link href="<?php echo e(asset('user/css/style.css')); ?>" rel="stylesheet">
        <!-- Scripts -->


        <!-- Styles -->

    </head>
    <body class="h-100">
    <div class="login-account">
        <div class="row h-100">
            <?php if(Session::has('error')): ?>
                <script>
                    Swal.fire({
                        title: 'Ooops..',
                        text: '<?php echo e(Session::get('error')); ?>',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                    })
                </script>
            <?php endif; ?>
            <?php echo e($slot); ?>

        </div>
    </div>

        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <script src="<?php echo e(asset('user/vendor/global/global.min.js')); ?>"></script>
    <script src="<?php echo e(asset('user/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')); ?>"></script>
    <script src="<?php echo e(asset('user/js/custom.min.js')); ?>"></script>
    <script src="<?php echo e(asset('user/js/deznav-init.js')); ?>"></script>
    </body>
</html>
<?php /**PATH C:\Users\user\PhpstormProjects\paysammighty\resources\views/layouts/guest.blade.php ENDPATH**/ ?>