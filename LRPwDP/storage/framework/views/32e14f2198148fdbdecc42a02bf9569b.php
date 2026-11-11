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
        <?php echo e(__('Listed Perishable')); ?>

    </h2>
     <?php $__env->endSlot(); ?>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <a href="<?php echo e(route('perishables.create')); ?>" class="btn btn-primary">Add New</a>
                    
                    <h3 class="text-3xl my-2">Active List</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="min-w-32">Image</th>
                                    <th>Name</th>
                                    <th class="text-right">Quantity<br>Left</th>
                                    <th class="text-right">Current ~<br>Lowest Price</th>
                                    <th>Listed Date/<br> Last Updated</th>
                                    <th>Expiry Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $listed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perishable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><img src="<?php echo e(asset('storage/' . $perishable->imagePath)); ?>" alt="Image" class="h-20 w-20 object-cover rounded"></td>
                                        <td><?php echo e($perishable->name ?? 'Unavailable'); ?> (<?php echo e($perishable->measurement ?? 'N/A'); ?>)</td>
                                        <td class="text-right"><?php echo e($perishable->quantity ?? 'Error'); ?> out of <?php echo e($perishable->quantityOriginal ?? 'Error'); ?></td>
                                        <td><s class="mx-2 text-xs px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full">RM<?php echo e(number_format($perishable->priceOriginal,2) ?? 'Error'); ?></s><br><span class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-full">RM<?php echo e(number_format($perishable->priceCurrent,2) ?? 'Error'); ?></span> ~ <span class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full">RM<?php echo e(number_format($perishable->priceLowerBound,2) ?? '0'); ?></span></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($perishable->created_at)->toDayDateTimeString() ?? 'Not Stated'); ?><br>(<?php echo e(\Carbon\Carbon::parse($perishable->updated_at)->diffForHumans() ?? 'Unknown'); ?>)</td>
                                        <td><?php echo e(\Carbon\Carbon::parse($perishable->expiryDate)->toDayDateTimeString() ?? 'Not Stated'); ?><br>(<?php echo e(\Carbon\Carbon::parse($perishable->expiryDate)->diffForHumans() ?? 'Unknown'); ?>)</td>
                                        <td>
                                            <a href="<?php echo e(route('perishables.show', ['perishable' => $perishable['id']])); ?>" class="btn btn-primary">Edit</a>
                                            <span class="text-2xl"> | </span>
                                            <form action="<?php echo e(route('perishables.unlist', ['perishable' => $perishable['id']])); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to unlist this perishable?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <button type="submit" class="btn btn-warning"><u>Unlist</u></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="px-4 py-2 text-center text-gray-500">No perishables found.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </thead>
                        </table>
                    </div>

                    <h3 class="text-3xl my-2">Historical List</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="min-w-32">Image</th>
                                    <th>Name</th>
                                    <th class="text-right">Quantity<br>Unsold</th>
                                    <th class="text-right">Last Set<br>Price</th>
                                    <th>Listed Date/<br> Last Updated</th>
                                    <th>Expiry Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $unlisted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perishable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><img src="<?php echo e(asset('storage/' . $perishable->imagePath)); ?>" alt="Image" class="h-20 w-20 object-cover rounded"></td>
                                        <td><?php echo e($perishable->name ?? 'Unavailable'); ?> (<?php echo e($perishable->measurement ?? 'N/A'); ?>)</td>
                                        <td class="text-right"><?php echo e($perishable->quantity ?? 'Error'); ?> out of <?php echo e($perishable->quantityOriginal ?? 'Error'); ?></td>
                                        <td><s class="mx-2 text-xs px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full">RM<?php echo e(number_format($perishable->priceOriginal,2) ?? 'Error'); ?></s><br><span class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full">RM<?php echo e(number_format($perishable->priceCurrent,2) ?? 'Error'); ?></span></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($perishable->created_at)->toDayDateTimeString() ?? 'Not Stated'); ?><br>(<?php echo e(\Carbon\Carbon::parse($perishable->updated_at)->diffForHumans() ?? 'Unknown'); ?>)</td>
                                        <td><?php echo e(\Carbon\Carbon::parse($perishable->expiryDate)->toDayDateTimeString() ?? 'Not Stated'); ?><br>(<?php echo e(\Carbon\Carbon::parse($perishable->expiryDate)->diffForHumans() ?? 'Unknown'); ?>)</td>
                                        <td>
                                            <a href="<?php echo e(route('perishables.show', ['perishable' => $perishable['id']])); ?>" class="btn btn-primary">Edit</a><span class="text-2xl"> | </span>
                                            <form action="<?php echo e(route('perishables.unlist', ['perishable' => $perishable['id']])); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to list this perishable?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <button type="submit" class="btn btn-warning"><u>List</u></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="px-4 py-2 text-center text-gray-500">No unlisted perishables found.</td>
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
<?php endif; ?><?php /**PATH C:\Users\User\FYP\LRPwDP\resources\views/perishables/index.blade.php ENDPATH**/ ?>