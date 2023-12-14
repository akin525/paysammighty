<?php $__env->startSection('tittle', 'Daily Report'); ?>
<?php $__env->startSection('page', 'Daily Report'); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="general-label">

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <form class="form-horizontal" method="POST" action="<?php echo e(route('report_daily')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <h4 class="mt-0 header-title">Search</h4>

                                <div class="input-group mt-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar-check"></i> </span>
                                    </div>
                                    <input style="margin-right: 20px" name="date" type="date"
                                           value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>"
                                           placeholder="Search for day"
                                           class="form-control <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> text-success">
                                </div>

                                <div class="input-group mt-2" style="align-content: center">
                                    <button class="btn btn-success btn-large" type="submit"
                                            style="align-self: center; align-content: center"><i
                                            class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 header-title">Daily Report
                    for <?php echo e(\Carbon\Carbon::parse($date)->format('d F, Y')); ?></h4>
                <p class="text-muted mb-4 font-13"></p>
                <div class="table-responsive">

                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Count</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Deposit</td>
                            <td>₦<?php echo e(number_format(intval($deposit_amount *1),2)); ?></td>
                            <td><?php echo e(number_format(intval($deposit *1))); ?></td>
                        </tr>
                        <tr>
                            <td>Data</td>
                            <td>₦<?php echo e(number_format(intval($data_amount *1),2)); ?></td>
                            <td><?php echo e(number_format(intval($data *1))); ?></td>
                        </tr>
                        <tr>
                            <td>Airtime</td>
                            <td>₦<?php echo e(number_format(intval($airtime_amount *1),2)); ?></td>
                            <td><?php echo e(number_format(intval($airtime *1))); ?></td>
                        </tr>
                        <tr>
                            <td>TV</td>
                            <td>₦<?php echo e(number_format(intval($tv_amount *1),2)); ?></td>
                            <td><?php echo e(number_format(intval($tv *1))); ?></td>
                        </tr>
                        <tr>
                            <td>Electricity</td>
                            <td> ₦<?php echo e(number_format(intval($electricity_amount *1),2)); ?></td>
                            <td> <?php echo e(number_format(intval($electricity *1))); ?></td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <!-- end col -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PIPER\paysammighty\resources\views/admin/report_daily.blade.php ENDPATH**/ ?>