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
            <?php echo e(__('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">

                    <h1 class="text-2xl font-semibold text-gray-900">
                        Seller Dashboard
                    </h1>

                    <p class="mt-2 text-gray-600">
                        Overview of your inventory, revenue, and expiring perishables.
                    </p>

                    <!-- Stats Grid -->
                    <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">

                        <!-- Total Products -->
                        <a href="<?php echo e(route('perishables.index')); ?>"><div class="p-6 bg-blue-50 border border-blue-200 rounded-lg">
                            <h2 class="text-sm text-blue-600 font-medium">Total Perishable</h2>
                            <p class="mt-2 text-3xl font-bold text-blue-900"><?php echo e($totalPerishable ?? 0); ?></p>
                        </div></a>

                        <a href="<?php echo e(route('perishables.index')); ?>"><div class="p-6 bg-blue-50 border border-blue-200 rounded-lg">
                            <h2 class="text-sm text-blue-600 font-medium">Active Perishable</h2>
                            <p class="mt-2 text-3xl font-bold text-blue-900"><?php echo e($activePerishable ?? 0); ?></p>
                        </div></a>

                        <!-- Sold Today -->
                        <a href="<?php echo e(route('reservations.indexSeller')); ?>"><div class="p-6 bg-green-50 border border-green-200 rounded-lg">
                            <h2 class="text-sm text-green-600 font-medium">Sold Today</h2>
                            <p class="mt-2 text-3xl font-bold text-green-900"><?php echo e($soldToday ?? 0); ?></p>
                        </div></a>

                        <a href="<?php echo e(route('reservations.indexSeller')); ?>"><div class="p-6 bg-green-50 border border-green-200 rounded-lg">
                            <h2 class="text-sm text-green-600 font-medium">Total Sold</h2>
                            <p class="mt-2 text-3xl font-bold text-green-900"><?php echo e($totalSold ?? 0); ?></p>
                        </div></a>

                        <!-- Revenue -->
                        <a href="<?php echo e(route('reservations.indexSeller')); ?>"><div class="p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <h2 class="text-sm text-yellow-600 font-medium">Revenue Today</h2>
                            <p class="mt-2 text-3xl font-bold text-yellow-900">RM<?php echo e(number_format($revenueToday, 2) ?? 0.00); ?></p>
                        </div></a>
                        <!-- Revenue -->
                        <a href="<?php echo e(route('reservations.indexSeller')); ?>"><div class="p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <h2 class="text-sm text-yellow-600 font-medium">Total Revenue</h2>
                            <p class="mt-2 text-3xl font-bold text-yellow-900">RM<?php echo e(number_format($totalRevenue, 2) ?? 0.00); ?></p>
                        </div></a>
                    </div>

                    <div class="mt-10">
                        <button 
                            onclick="document.getElementById('perishables').classList.toggle('hidden')"
                            class="w-full flex justify-between items-center bg-gray-100 p-4 rounded-lg border text-xl font-semibold text-gray-800">
                            Expiring Perishables
                            <span>▼</span>
                        </button>
                        <div id="perishables" class="mt-2 bg-white border rounded-lg divide-y hidden">
                            <?php $__empty_1 = true; $__currentLoopData = $expiringList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expiring): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="p-4 flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-900"><?php echo e($expiring->name); ?> (<?php echo e($expiring->measurement); ?>)</p>
                                    <p class="text-sm text-gray-500">Expires in <?php echo e(\Carbon\Carbon::parse($expiring->expiryDate)->diffForHumans()); ?></p>
                                </div>
                                <span class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full">Urgent</span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <p class="m-6">Not Available</p>
                        <?php endif; ?>
                        </div>
                        
                        
                    </div>

                    
                    <div class="mt-10">
                        <button 
                            onclick="document.getElementById('perishablesR').classList.toggle('hidden')"
                            class="w-full flex justify-between items-center bg-gray-100 p-4 rounded-lg border text-xl font-semibold text-gray-800">
                            Reserved Perishables
                            <span>▼</span>
                        </button>

                        <div id="perishablesR" class="mt-2 bg-white border rounded-lg divide-y hidden">
                            <?php $__empty_1 = true; $__currentLoopData = $reservedList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reserved): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="p-4 flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-900"><?php echo e($reserved->perishable->name); ?> (<?php echo e($reserved->perishable->measurement); ?>)</p>
                                    <p class="text-sm text-gray-500">Reserved on <?php echo e(\Carbon\Carbon::parse($reserved->created_at)->toDayDateTimeString()); ?></p>
                                </div>
                                <span class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full">Pickup Time: <?php echo e(\Carbon\Carbon::parse($reserved->pickupTime)->format('g:i A')); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="m-6">Not Available</p>
                        <?php endif; ?>
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
<?php endif; ?>
<?php /**PATH C:\Users\User\FYP\LRPwDP\resources\views/dashboard.blade.php ENDPATH**/ ?>