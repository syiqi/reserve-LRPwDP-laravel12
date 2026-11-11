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
            <?php echo e(__('Marketplace')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
            
            <form method="GET" action="<?php echo e(route('home')); ?>" class="mb-6 flex flex-wrap items-center gap-4 bg-white p-4 rounded shadow">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                       placeholder="Search. . ." 
                       class="w-full sm:w-1/3 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">

                <select name="type" class="border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">All Categories</option>
                    <option value="preparedMeals" <?php echo e(request('type') == 'preparedMeals' ? 'selected' : ''); ?>>Prepared Meals</option>
                    <option value="bakedGoods" <?php echo e(request('type') == 'bakedGoods' ? 'selected' : ''); ?>>Baked Goods</option>
                    <option value="desserts" <?php echo e(request('type') == 'desserts' ? 'selected' : ''); ?>>Desserts</option>
                    <option value="beverages" <?php echo e(request('type') == 'beverages' ? 'selected' : ''); ?>>Beverages</option>
                    <option value="SJC" <?php echo e(request('type') == 'SJC' ? 'selected' : ''); ?>>Sauces, Jams or Condiments</option>
                    <option value="frozenFoods" <?php echo e(request('type') == 'frozenFoods' ? 'selected' : ''); ?>>Frozen Foods</option>
                    <option value="cannedFoods" <?php echo e(request('type') == 'cannedFoods' ? 'selected' : ''); ?>>Canned Foods</option>
                    <option value="snacks" <?php echo e(request('type') == 'snacks' ? 'selected' : ''); ?>>Snacks</option>
                    <option value="dairyProducts" <?php echo e(request('type') == 'dairyProducts' ? 'selected' : ''); ?>>Dairy Products</option>
                    <option value="MS" <?php echo e(request('type') == 'MS' ? 'selected' : ''); ?>>Meats or Seafoods</option>
                    <option value="dryGoods" <?php echo e(request('type') == 'dryGoods' ? 'selected' : ''); ?>>Dry Goods</option>
                    <option value="SS" <?php echo e(request('type') == 'SS' ? 'selected' : ''); ?>>Spices or Seasonings</option>
                    <option value="herbs" <?php echo e(request('type') == 'herbs' ? 'selected' : ''); ?>>Herbs</option>
                </select>

                <span class="text-2xl">(</span>
                <input type="number" name="min_price" value="<?php echo e(request('min_price')); ?>" placeholder="Min Price" class="w-24 border-gray-300 rounded-md shadow-sm">
                <span class="text-2xl">~</span>
                <input type="number" name="max_price" value="<?php echo e(request('max_price')); ?>" placeholder="Max Price" class="w-24 border-gray-300 rounded-md shadow-sm">
                <span class="text-2xl">)</span>
                <div class="flex flex-grid gap-4">
                    
                    <label class="flex items-center gap-2">
                    <input type="checkbox" name="halal" value="1" <?php echo e(request('halal') ? 'checked' : ''); ?> class="rounded text-gray-600 focus:ring-green-500">
                    <span>Halal</span>
                    </label>


                    <label class="flex items-center gap-2">
                    <input type="checkbox" name="low" value="1" <?php echo e(request('low') ? 'checked' : ''); ?> class="rounded text-gray-600 focus:ring-green-500">
                    <span>Running Low</span>
                    </label>

                    <label class="flex items-center gap-2">
                    <input type="checkbox" name="near_expiry" value="1" <?php echo e(request('near_expiry') ? 'checked' : ''); ?> class="rounded text-gray-600 focus:ring-green-500">
                    <span>Near Expiry</span>
                    </label>
                    
                <div class="p-4">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    Filter
                </button>
                <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    <a href="<?php echo e(route('home')); ?>" 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Reset
                    </a>
                </button>
                </div>
                </div>
            </form>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $perishables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perishable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('reservations.createPerishableReservation', $perishable->id)); ?>" 
                       class="block bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                        <img  src="<?php echo e(asset('storage/' . ($perishable->imagePath ?? ''))); ?>" 
                             alt="<?php echo e($perishable->name); ?>" 
                             class="w-full h-48 object-cover">
                        <div class="p-4">
                            <div class="flex flex-grid justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-800"><?php echo e($perishable->name ?? ''); ?> (<?php echo e($perishable->measurement ?? ''); ?>)</h3>
                            <?php if($perishable->halal===1): ?><span class="mx-2 px-3 py-1 text-sm bg-green-100 text-green-700 rounded-full font-bold">HALAL✅ </span> <?php else: ?> <span class="mx-2 px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full font-bold">NON-HALAL </span> <?php endif; ?> 
                            </div>
                            <p class="text-sm text-gray-600"><?php echo e(Str::limit($perishable->description ?? '', 60)); ?></p>
                            <div class="mt-2 flex justify-between items-center">
                                <div>
                                <span class="text-xs text-gray-500"><s>RM<?php echo e(number_format($perishable->priceOriginal, 2)); ?></s></span><br>
                                <span class="text-green-600 font-bold">RM<?php echo e(number_format($perishable->priceCurrent, 2)); ?></span><br>
                                <span class="text-xs text-gray-500 ">📍<?php echo e($perishable->user->city ?? ''); ?>, <?php echo e($perishable->user->state ?? ''); ?></span>
                                </div>
                                <div>
                                <span class="text-xs text-gray-500">Expires: <?php echo e(\Carbon\Carbon::parse($perishable->expiryDate)->format('d/m/Y')); ?>

                                <br> (<?php echo e(\Carbon\Carbon::parse($perishable->expiryDate)->diffForHumans()); ?>)</span>
                                <br> <span class="text-m text-gray-500 font-bold"><?php echo e($perishable->quantity); ?> left</span>
                                </div>
                            </div>
                            <button class="mt-3 w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded text-sm">
                                Reserve
                            </button>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500">No perishables found.</p>
                <?php endif; ?>
            </div>

            
            <div class="mt-6">
                <?php echo e($perishables->withQueryString()->links()); ?>

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
<?php endif; ?><?php /**PATH C:\Users\User\FYP\LRPwDP\resources\views/home.blade.php ENDPATH**/ ?>