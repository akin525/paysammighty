<?php $__env->startSection('tittle', $user->username); ?>
<?php $__env->startSection('page', $user->username); ?>
<?php $__env->startSection('content'); ?>
    <style>
        .subscribe {
            position: relative;
            padding: 20px;
            background-color: #FFF;
            border-radius: 4px;
            color: #333;
            box-shadow: 0px 0px 60px 5px rgba(0, 0, 0, 0.4);
        }

        .subscribe:after {
            position: absolute;
            content: "";
            right: -10px;
            bottom: 18px;
            width: 0;
            height: 0;
            border-left: 0px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 10px solid #208b37;
        }

        .subscribe p {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 4px;
            line-height: 28px;
        }



        .subscribe .submit-btn {
            position: absolute;
            border-radius: 30px;
            border-bottom-right-radius: 0;
            border-top-right-radius: 0;
            background-color: #208b37;
            color: #FFF;
            padding: 12px 25px;
            display: inline-block;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 5px;
            right: -10px;
            bottom: -20px;
            cursor: pointer;
            transition: all .25s ease;
            box-shadow: -5px 6px 20px 0px rgba(26, 26, 26, 0.4);
        }

        .subscribe .submit-btn:hover {
            background-color: #208b37;
            box-shadow: -5px 6px 20px 0px rgba(88, 88, 88, 0.569);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="row">
        <div class="col-lg-12">
            <div class="profile card card-body px-3 pt-3 pb-0">
                <div class="profile-head">
                    <div class="photo-content">
                        <div class="cover-photo rounded"></div>
                    </div>
                    <div class="profile-info">
                        <div class="profile-photo">
                            <img src="<?php echo e(asset('user/images/avatar/1.png')); ?>" class="img-fluid rounded-circle" alt="">
                        </div>
                        <div class="profile-details">
                            <div class="profile-name px-3 pt-2">
                                <h4 class="text-primary mb-0"><?php echo e($user->business_name); ?></h4>
                                <p><?php echo e($user->name); ?></p>
                            </div>
                            <div class="profile-email px-2 pt-2">
                                <h4 class="text-muted mb-0"><?php echo e($user->email); ?></h4>
                                <p>Email</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-interest">
                                <h5 class="text-primary d-inline">Account Details</h5>
                                <div class="basic-list-group">
                                    <div class="list-group"><a href="javascript:void(0);" class="list-group-item list-group-item-action active">Account
                                            Number </a><a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                            <?php echo e($bus->account_number); ?></a>
                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action disabled">
                                            Account Name
                                        </a> <a href="javascript:void(0);" class="list-group-item list-group-item-action"><?php echo e($bus->account_name); ?></a>
                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action active">
                                            Bank
                                        </a>
                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action"><?php echo e($bus->bank); ?></a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col-xl-8">
            <div class="card h-auto">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a href="#my-posts" data-bs-toggle="tab" class="nav-link active show"><i class="fa fa-user-alt"></i> Profile</a>
                                </li>
                                <li class="nav-item"><a href="#about-me" data-bs-toggle="tab" class="nav-link"><i class="fa fa-user-check"></i> Business Profile</a>
                                </li>
                                <li class="nav-item"><a href="#bank" data-bs-toggle="tab" class="nav-link"><i class="fa fa-money-bill"></i>Wallet</a>
                                </li>
                                <li class="nav-item"><a href="#bvn" data-bs-toggle="tab" class="nav-link"><i class="fa fa-money-check"></i>All Deposit</a>
                                </li>
                                <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab" class="nav-link"><i class="fa fa-key"></i>All Purchase</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="my-posts" class="tab-pane fade active show">
                                    <div class="my-post-content pt-3">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <h4 class="text-primary">profile Updating</h4>
                                                <form id="dataForm">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" placeholder="Email" name="email" class="form-control" value="<?php echo e($user->email); ?>">
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" name="name" value="<?php echo e($user->name); ?>" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Business Name</label>
                                                        <input type="text" value="<?php echo e($user->business_name); ?>" name="business" class="form-control" readonly/>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Account-Prefix</label>
                                                        <input type="text" value="<?php echo e($user->account_prefix); ?>" name="prefix" class="form-control" required/>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" value="<?php echo e($user->username); ?>" class="form-control" readonly/>
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">Update Now</button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div id="about-me" class="tab-pane fade">
                                    <div class="my-post-content pt-3">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <h4 class="text-primary">Business Profile</h4>
                                                <form id="business">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Business Email</label>
                                                            <input type="email" placeholder="Email" name="email" class="form-control" value="<?php echo e($bus->email); ?>">
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Business Phone</label>
                                                            <input type="text" name="phone" value="<?php echo e($bus->phone); ?>" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Email Chargeback</label>
                                                        <input type="text" value="<?php echo e($bus->cemail); ?>" name="cemail" class="form-control" />
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">Update Business</button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div id="profile-settings" class="tab-pane fade">
                                    <div class="card card-body">
                                        <b><h4 class="text-center">Coming Soon</h4> </b>
                                    </div>

                                </div>
                                <div id="bank" class="tab-pane fade">
                                    <div class="card card-body">

                                        <div class="card-bx stacked">
                                            <img src="<?php echo e(asset('user/images/card/card.png')); ?>" alt="" class="mw-100">
                                            <div class="card-info text-white">
                                                <p class="mb-1">Wallet Balance</p>
                                                <h2 class="fs-36 text-white mb-sm-4 mb-3">₦<?php echo e(number_format(intval($user->wallet *1),2)); ?></h2>
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#fundw">Fund Merchant</button>
                                                <hr>
                                                <p class="mb-1">Wallet Bonus</p>
                                                <h2 class="fs-36 text-white mb-sm-4 mb-3">₦<?php echo e(number_format(intval($user->bonus *1),2)); ?></h2>
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#fundc">Credit Bonus</button>

                                                <a href="#"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                        </div>
                                        </div>
                                        <div class="">
                                            <div class="card bgl-primary card-body overflow-hidden p-0 d-flex rounded">
                                                <div class="p-0 text-center mt-3">
                                                    <span class="text-black">Total Deposit</span>
                                                    <h3 class="text-black fs-20 mb-0 font-w600">₦<?php echo e(number_format(intval($sumtt *1),2)); ?></h3>
                                                    <br>
                                                    <hr>
                                                    <span class="text-black">Total Purchase</span>
                                                    <h3 class="text-black fs-20 mb-0 font-w600">₦<?php echo e(number_format(intval($sumbo *1),2)); ?></h3>
                                                    <hr>
                                                    <button type="button" class="btn btn-danger">Charge Merchant</button>

                                                    

                                                </div>
                                                
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="replyModal">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Post Reply</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <textarea class="form-control" rows="4">Message</textarea>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Reply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
        <div class="modal fade" id="fundw" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Fund <?php echo e($user->username); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="dataForm1">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div>
                                    <br>
                                    <br>
                                    <div id="AirtimePanel">
                                        <div class="subscribe">
                                            <div id="div_id_network" >
                                                <label for="network" class=" requiredField">
                                                    Enter Amount<span class="asteriskField">*</span>
                                                </label>
                                                <div class="">
                                                    <input type="hidden" name="refid" value="<?php echo rand(100000000000, 9999999999999); ?>">
                                                    <input type="hidden" id="username" name="username"  value="<?php echo e($user->username); ?>" class="text-success form-control" required>
                                                    <input type="number" id="amount" name="amount"  class="text-success form-control" required>
                                                </div>
                                            </div>
                                            <br/>

                                            <button type="submit" class="submit-btn">FUND<span class="load loading"></span></button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="fundc" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Fund <?php echo e($user->username); ?> Bonus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="bonusForm" >
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div>
                                    <br>
                                    <br>
                                    <div id="AirtimePanel">
                                        <div class="subscribe">
                                            <div id="div_id_network" >
                                                <label for="network" class=" requiredField">
                                                    Enter Amount<span class="asteriskField">*</span>
                                                </label>
                                                <div class="">
                                                    <input type="hidden" id="username1" name="username"  value="<?php echo e($user->username); ?>" class="text-success form-control" required>
                                                    <input type="number" id="amount1" name="amount"  class="text-success form-control" required>
                                                </div>
                                            </div>
                                            <br/>

                                            <button type="submit" class="submit-btn">FUND BONUS<span class="load loading"></span></button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <script>
        $(document).ready(function() {
            $('#dataForm1').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally
                // Get the form data
                var formData = $(this).serialize();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to fund ' + document.getElementById("username").value + ' ₦' + document.getElementById("amount").value + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // The user clicked "Yes", proceed with the action
                        // Add your jQuery code here
                        // For example, perform an AJAX request or update the page content

                        Swal.fire({
                            title: 'Processing',
                            text: 'Please wait...',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });

                        $('#loadingSpinner').show();
                        $.ajax({
                            url: "<?php echo e(route('admin/cr')); ?>",
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                // Handle the success response here
                                $('#loadingSpinner').hide();

                                console.log(response);
                                // Update the page or perform any other actions based on the response

                                if (response.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message
                                    }).then(() => {
                                        location.reload(); // Reload the page
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Pending',
                                        text: response.message
                                    });
                                    // Handle any other response status
                                }

                            },
                            error: function(xhr) {
                                $('#loadingSpinner').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'fail',
                                    text: xhr.responseText
                                });
                                // Handle any errors
                                console.log(xhr.responseText);

                            }
                        });


                    }
                });


                // Send the AJAX request
            });
        });

    </script>
    <script>
        $(document).ready(function() {
            $('#refundForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally
                // Get the form data
                var formData = $(this).serialize();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to re-fund ' + document.getElementById("username1").value + ' ₦' + document.getElementById("amount1").value + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // The user clicked "Yes", proceed with the action
                        // Add your jQuery code here
                        // For example, perform an AJAX request or update the page content
                        Swal.fire({
                            title: 'Processing',
                            text: 'Please wait...',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });

                        $('#loadingSpinner').show();
                        $.ajax({
                            url: "<?php echo e(route('admin/ref')); ?>",
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                // Handle the success response here
                                $('#loadingSpinner').hide();

                                console.log(response);
                                // Update the page or perform any other actions based on the response

                                if (response.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message
                                    }).then(() => {
                                        location.reload(); // Reload the page
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Pending',
                                        text: response.message
                                    });
                                    // Handle any other response status
                                }

                            },
                            error: function(xhr) {
                                $('#loadingSpinner').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'fail',
                                    text: xhr.responseText
                                });
                                // Handle any errors
                                console.log(xhr.responseText);

                            }
                        });


                    }
                });


                // Send the AJAX request
            });
        });

    </script>
    <script>
        $(document).ready(function() {
            $('#bonusForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally
                // Get the form data
                var formData = $(this).serialize();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to add bonus to ' + document.getElementById("username1").value + ' ₦' + document.getElementById("amount1").value + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // The user clicked "Yes", proceed with the action
                        // Add your jQuery code here
                        // For example, perform an AJAX request or update the page content

                        Swal.fire({
                            title: 'Processing',
                            text: 'Please wait...',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });

                        $('#loadingSpinner').show();
                        $.ajax({
                            url: "<?php echo e(route('admin/bonus')); ?>",
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                // Handle the success response here
                                $('#loadingSpinner').hide();

                                console.log(response);
                                // Update the page or perform any other actions based on the response

                                if (response.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message
                                    }).then(() => {
                                        location.reload(); // Reload the page
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Pending',
                                        text: response.message
                                    });
                                    // Handle any other response status
                                }

                            },
                            error: function(xhr) {
                                $('#loadingSpinner').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'fail',
                                    text: xhr.responseText
                                });
                                // Handle any errors
                                console.log(xhr.responseText);

                            }
                        });


                    }
                });


                // Send the AJAX request
            });
        });

    </script>
    <script>
        $(document).ready(function() {
            $('#chargeForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally
                // Get the form data
                var formData = $(this).serialize();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to Charge ' + document.getElementById("username3").value + ' ₦' + document.getElementById("amount3").value + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Processing',
                            text: 'Please wait...',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });
                        // The user clicked "Yes", proceed with the action
                        // Add your jQuery code here
                        // For example, perform an AJAX request or update the page content
                        $('#loadingSpinner').show();
                        $.ajax({
                            url: "<?php echo e(route('admin/ch')); ?>",
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                // Handle the success response here
                                $('#loadingSpinner').hide();

                                console.log(response);
                                // Update the page or perform any other actions based on the response

                                if (response.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message
                                    }).then(() => {
                                        location.reload(); // Reload the page
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Pending',
                                        text: response.message
                                    });
                                    // Handle any other response status
                                }

                            },
                            error: function(xhr) {
                                $('#loadingSpinner').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'fail',
                                    text: xhr.responseText
                                });
                                // Handle any errors
                                console.log(xhr.responseText);

                            }
                        });


                    }
                });


                // Send the AJAX request
            });
        });

    </script>



<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PIPER\paysammighty\resources\views/admin/profile.blade.php ENDPATH**/ ?>