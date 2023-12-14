<?php $__env->startSection('tittle', 'Query Collection'); ?>
<?php $__env->startSection('page', 'Query Collection'); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">

            <form class="form-horizontal" method="POST" action="<?php echo e(route('admin/date')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group mt-2">
                            <div class="input-group-prepend">
                                <h3 class="text-success">From: </h3>

                            </div>
                            <input style="margin-right: 20px" type="date" name="from"  class="form-control <?php $__errorArgs = ['from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">



                            <div class="input-group-prepend">
                                <h3 class="text-success">To: </h3>

                            </div>
                            <input type="date" name="to"  class="form-control <?php $__errorArgs = ['to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        </div>

                        <div class="input-group mt-2" style="align-content: center">
                            <button class="btn btn-primary btn-large" type="submit" style="align-self: center; align-content: center"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </form>

            <h6 class="text-success">Data Between Selected Dates</h6>
            <?php if($result ?? ''): ?>
                <div>
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
                        <thead>
                            <th> Username </th>
                            <th> Transaction Id </th>
                            <th> Date</th>
                            <th>Amount</th>
                        </thead>
                            <tbody>
                            <?php $__currentLoopData = $deposit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($row->username); ?></td>
                                    <td><?php echo e($row->refid); ?></td>
                                    <td><?php echo e($row->date); ?></td>
                                    <td><?php echo e($row->amount); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <br>
                            <center>
                                <button type="button" class="align-content-center btn btn-outline-success text-center">Total =₦<?php echo e(number_format(intval($sumdate *1),2)); ?></button>
                            </center>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PIPER\paysammighty\resources\views/admin/depodate.blade.php ENDPATH**/ ?>