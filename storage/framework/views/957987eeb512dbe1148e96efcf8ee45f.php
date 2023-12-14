<?php $__env->startSection('tittle', 'Virtual-Account'); ?>
<?php $__env->startSection('page', 'Virtual-Account'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
            <div class="table-responsive table-hover fs-14 card-table">
                <table id="example" class="display min-w850">
                <thead>
                    <tr>
                        <th>
                            <div class="checkbox me-0 align-self-center">
                                <div class="form-check custom-checkbox ">
                                    <input type="checkbox" class="form-check-input" id="checkAll" required="">
                                    <label class="form-check-label" for="checkAll"></label>
                                </div>
                            </div>
                        </th>
                        <th>ID </th>
                        <th>Merchant</th>
                        <th>Reference</th>
                        <th>Date</th>
                        <th>Account Name</th>
                        <th>Account Number</th>
                        <th>Bank Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="checkbox me-0 align-self-center">
                                    <div class="form-check custom-checkbox ">
                                        <input type="checkbox" class="form-check-input" id="customCheckBox2" required="">
                                        <label class="form-check-label" for="customCheckBox2"></label>
                                    </div>
                                </div>
                            </td>
                            <td><span class="text-black font-w500"><?php echo e($deposit['id']); ?></span></td>
                            <td><span class="text-black font-w500"><?php echo e($deposit['username']); ?></span></td>
                            <td><span class="text-black font-w500"><?php echo e($deposit['refid']); ?></span></td>
                            <td><span class="text-black text-nowrap"><?php echo e($deposit['created_at']); ?></span></td>
                           <td><span class="text-black fs-16 font-w600"><?php echo e($deposit['customer']); ?></span></td>
                            <td><span class="text-black fs-16 font-w600"><?php echo e($deposit['account_number']); ?></span></td>
                            <td><span class="text-black fs-16 font-w600"><?php echo e($deposit['provider']); ?></span></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function($) {
            var table = $('#example5').DataTable({
                searching: false,
                paging:true,
                select: false,
                //info: false,
                lengthChange:false

            });
            $('#example tbody').on('click', 'tr', function () {
                var data = table.row( this ).data();

            });
        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PIPER\paysammighty\resources\views/admin/allvirtual.blade.php ENDPATH**/ ?>