<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <?php echo e(__('Reservation List')); ?>

    </h2>
     <?php $__env->endSlot(); ?>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">        
                    <h3 class="text-3xl my-2">Reservation Made</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="min-w-32">Image</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Payable<br>Amount</th>
                                    <th>Pickup Time</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><img src="<?php echo e(asset('storage/' . $reservation->perishable->imagePath)); ?>" alt="Perishable Image" width="150"></td>
                                        <td><?php echo e($reservation->reserveName ?? 'Unavailable'); ?></td>
                                        <td class="text-right"><?php echo e($reservation->reserveQuantity ?? 'Error'); ?></td>
                                        <td>RM<?php echo e(number_format($reservation->reservePrice,2) ?? 'Error'); ?></td>
                                        <td>Today, <?php echo e(\Carbon\Carbon::parse($reservation->pickupTime)->format('g:i A') ?? 'Not set'); ?></td>
                                        <td><?php echo e($reservation->status ?? 'Unknown'); ?></td>
                                        <td><a href="<?php echo e(route('reservations.show', ['reservation' => $reservation['id']])); ?>" class="btn btn-primary">Show</a>
                                        <span class="text-2xl"> | </span> 
                                            <form action="<?php echo e(route('reservations.cancel', ['reservation' => $reservation['id']])); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <button type="submit" class="btn btn-warning">Cancel</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No reservation made today</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </thead>
                        </table>
                    </div>
                    <h3 class="text-3xl my-2">Reservation History</h2>
<div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="min-w-32">Image</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Amount Paid</th>
                                    <th>Pickup Time</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><img src="<?php echo e(asset('storage/' . $reservation->perishable->imagePath)); ?>" alt="Perishable Image" width="150"></td>
                                        <td><?php echo e($reservation->reserveName ?? 'Unavailable'); ?></td>
                                        <td><?php echo e($reservation->reserveQuantity ?? 'Error'); ?></td>
                                        <td>RM<?php echo e(number_format($reservation->reservePrice,2)?? 'Error'); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($reservation->pickupTime)->toDayDateTimeString() ?? 'Not set'); ?></td>
                                        <td><?php echo e($reservation->status ?? 'Unknown'); ?></td>
                                        <td><a href="<?php echo e(route('reservations.show', ['reservation' => $reservation['id']])); ?>" class="btn btn-primary">Show</a></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No reservation ever made</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </thead>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>

    
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\User\FYP\LRPwDP\resources\views/reservations/index.blade.php ENDPATH**/ ?>