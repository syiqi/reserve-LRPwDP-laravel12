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
            <h2 class="font-semibold text-xl text-gray-800 light:text-gray-200 leading-tight">
                <?php echo e(__('Reservation Proof')); ?>

            </h2>
         <?php $__env->endSlot(); ?>
    <?php if (isset($component)) { $__componentOriginalf7b62739b7076c0563d3ad4515ad2917 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf7b62739b7076c0563d3ad4515ad2917 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.authentication-card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('authentication-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

         <?php $__env->slot('logo', null, []); ?> 
            <?php if (isset($component)) { $__componentOriginal1a590bee94ab2d9c08b342367154fca0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a590bee94ab2d9c08b342367154fca0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.authentication-card-logo','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('authentication-card-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a590bee94ab2d9c08b342367154fca0)): ?>
<?php $attributes = $__attributesOriginal1a590bee94ab2d9c08b342367154fca0; ?>
<?php unset($__attributesOriginal1a590bee94ab2d9c08b342367154fca0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a590bee94ab2d9c08b342367154fca0)): ?>
<?php $component = $__componentOriginal1a590bee94ab2d9c08b342367154fca0; ?>
<?php unset($__componentOriginal1a590bee94ab2d9c08b342367154fca0); ?>
<?php endif; ?>
         <?php $__env->endSlot(); ?>

        <a href="<?php if(Auth::user()->role==='customer'): ?><?php echo e('/reservations'); ?><?php else: ?><?php echo e('indexSeller'); ?><?php endif; ?>" ><?php if (isset($component)) { $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.secondary-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Back <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $attributes = $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $component = $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?></a>
        <div class="flex space-x-2 mt-4" x-show="!photoPreview">
            <?php if($reservation->perishable->imagePath): ?>
                <img src="<?php echo e(asset('storage/' . $reservation->perishable->imagePath)); ?>" alt="<?php echo e($reservation->perishable->name); ?>" class="rounded-md w-32 h-32 object-cover border">
            <?php else: ?>
                <div class="w-32 h-32 flex items-center justify-center border rounded-md bg-gray-100 text-gray-400">
                    No Image
                </div>
            <?php endif; ?>
            <div>
                <h3 class="text-sm font-medium text-gray-700">Name</h3>
                <p class="text-gray-900"><?php echo e($reservation->reserveName); ?></p>
            <div class="flex space-x-2">
                <div>
                <h3 class="text-sm font-medium text-gray-700">Price</h3>
                <p class="text-gray-900">RM<?php echo e(number_format(($reservation->reservePrice / $reservation->reserveQuantity),2)); ?></p>
                </div>
                <span class="mt-6">*</span>
                <div>
                <h3 class="text-sm font-medium text-gray-700">Quantity</h3>
                <p class="text-gray-900"><?php echo e($reservation->reserveQuantity); ?></p>
                </div>
                <span class="mt-5">=</span>
                <div>
                <h3 class="text-sm font-medium text-gray-700">Total Amount</h3>
                <p class="text-gray-900">RM<?php echo e(number_format($reservation->reservePrice,2)); ?></p>
                </div>
            </div>
            <div class="flex space-x-8 justify-end">
                <div class="flex space-x-2 items-center">
                <h3 class="text-sm font-medium text-gray-700">Status:</h3>
                <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded-full"><?php echo e($reservation->status); ?></span>
                 </div> 
                
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->role === 'seller' && $reservation->status!=='success'): ?>
                            <form action="<?php echo e(route('reservations.success', $reservation->id)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="btn-primary">Fully Paid</button>
                            </form>
                        <?php elseif(auth()->user()->role === 'customer' && $reservation->status==='reserved'): ?>
                        <form action="<?php echo e(route('reservations.cancel', $reservation->id)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="btn-primary">Cancel</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>

                
            </div>
                </div>
        </div>
        <div class="receipt">

            <div class="border-y-2 my-4 py-4">
                <h3 class="text-sm font-medium text-gray-700">Description</h3>
                <p class="text-gray-900"><?php echo e($reservation->perishable->description ?? 'Not available'); ?></p>
            </div>
            <div class="grid grid-cols-2 divide-x-2 divide-dashed">
            <div>
                <h3 class="text-sm font-medium text-gray-700">Reserved By</h3>
                <p class="text-gray-900"><?php echo e($reservation->user->name ?? 'Unknown'); ?></p>
            
                <h3 class="text-sm font-medium text-gray-700 mt-2">Reserved At</h3>
                <p class="text-gray-900"><?php echo e(\Carbon\Carbon::parse($reservation->created_at)->toFormattedDateString()); ?></p>
            
                <h3 class="text-sm font-medium text-gray-700 mt-2">Pickup Time</h3>
                <p class="text-gray-900"><?php echo e(\Carbon\Carbon::parse($reservation->pickupTime)->format('g:i A')); ?></p>
            
            </div>
            <div class="pl-4">
                <h3 class="text-sm font-medium text-gray-700">Sold By</h3>
                <p class="text-gray-900"><?php echo e($reservation->perishable->user->name ?? 'Unknown'); ?></p>
            <?php
                $fullAddress = $reservation->perishable->user->address .  ', '."\n" . $reservation->perishable->user->postcode . ' ' . $reservation->perishable->user->city . ', '."\n" . $reservation->perishable->user->state . ', '."\n" . $reservation->perishable->user->country;
                $mapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode(str_replace("\n", ', ', $fullAddress));
            ?>

            
                <h3 class="text-sm font-medium text-gray-700 mt-2">Address/Pickup Location</h3>
                <address class="text-gray-900">
                    <a href="<?php echo e($mapsUrl); ?>" target="_blank" class="hover:underline text-blue-600">
                        <?php echo e($fullAddress ?? 'Not Available'); ?>

                    </a>
                </address>
            </div>

        </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf7b62739b7076c0563d3ad4515ad2917)): ?>
<?php $attributes = $__attributesOriginalf7b62739b7076c0563d3ad4515ad2917; ?>
<?php unset($__attributesOriginalf7b62739b7076c0563d3ad4515ad2917); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7b62739b7076c0563d3ad4515ad2917)): ?>
<?php $component = $__componentOriginalf7b62739b7076c0563d3ad4515ad2917; ?>
<?php unset($__componentOriginalf7b62739b7076c0563d3ad4515ad2917); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\User\FYP\LRPwDP\resources\views/reservations/show.blade.php ENDPATH**/ ?>