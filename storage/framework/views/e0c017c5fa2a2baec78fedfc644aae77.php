<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\GuestLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="col-lg-6 align-self-start">
        <div class="account-info-area" style="background-image: url(<?php echo e(asset('user/images/rainbow.gif')); ?>)">
            <div class="login-content">
                <p class="sub-title">Enter Verification Code</p>
                <h1 class="title">The Evolution of <span>Sammighty</span></h1>
                <p class="text">Instant Bank Transfer Collection</p>

            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-7 col-sm-12 mx-auto align-self-center">
        <div class="login-form">
            <div class="login-head">
                <h3 class="title">Welcome Back</h3>
                <p>Sell online, process payments whether online or not. Simply
                    complete payment on the go using your banking app or ussd.</p>
            </div>
            <?php if(session('status')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.validation-errors','data' => ['class' => 'alert alert-danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('validation-errors'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'alert alert-danger']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>

            <form method="POST" action="<?php echo e(url('2fa')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label class="mb-1 text-black">Enter Verification Code</label>
                    <input type="text" name="code" id="code" class="form-control" />
                </div>

                <div class="text-center mb-4">
                    <button type="submit" class="btn btn-primary btn-block">Verify</button>
                </div>
            </form>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\Users\user\PhpstormProjects\paysammighty\resources\views/auth/2fa.blade.php ENDPATH**/ ?>