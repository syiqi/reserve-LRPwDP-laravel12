<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.png')); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESERVE</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <style>
        /* Animated Gradient Background */
        @keyframes gradient-x {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-gradient-x {
            background-size: 200% 200%;
            animation: gradient-x 6s ease infinite;
        }

        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        /* Button Pulse */
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.95; transform: scale(1.03); }
        }
        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="antialiased text-gray-900">

    <!-- HERO SECTION -->
    <div class="relative py-12 md:py-12 overflow-hidden bg-gradient-to-br from-[#fff2f2] via-[#ffe4cc] to-[#fff2f2] animate-gradient-x">

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 text-center">
            
            <!-- Animated Gradient Title -->
            <div class="flex-col items-center justify-center text-center px-4">
                <!-- Logo -->
                <div class="mb-8">
                    <img src="<?php echo e(asset('favicon.png')); ?>" alt="<?php echo e(config('app.name', 'Laravel')); ?>" class="h-32 w-auto mx-auto">
                </div>

                <!-- Gradient Glow Heading -->
                 <h1 class="relative text-5xl sm:text-6xl md:text-7xl font-extrabold bg-gradient-to-r from-[#F53003] via-[#FF7A00] to-[#FFD54F] bg-clip-text text-transparent">
                <!-- Glow effect behind -->
                <span class="absolute inset-0 blur-3xl opacity-30 bg-gradient-to-r from-[#F53003] via-[#FF7A00] to-[#FFD54F]"></span>
                
                <!-- Main visible text -->
                <span class="relative text-transparent bg-clip-text bg-gradient-to-r from-[#F53003] via-[#FF7A00] to-[#FFD54F]">
                    RESERVE
                </span>
                </h1>

            </div>

            <!-- Subtitle -->
            <p class="mt-10 text-lg sm:text-xl md:text-2xl text-[#706f6c] font-medium max-w-3xl mx-auto">
                A leftover perishables platform that empowers sustainability through a better
                <span class="text-[#F53003] font-semibold">Dynamic Pricing</span> 
                system for expiring and leftover perishables.
            </p>

            <!-- CTA Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="<?php echo e(route('register')); ?>" 
                class="w-full sm:w-auto px-8 py-3 bg-[#F53003] text-white text-lg font-semibold rounded-full shadow-md hover:scale-105 hover:shadow-lg hover:bg-[#d42600] transition-all duration-300 animate-pulse-slow">
                    Get Started
                </a>
                <a href="<?php echo e(route('login')); ?>" 
                class="w-full sm:w-auto px-8 py-3 border border-[#F53003] text-[#F53003] text-lg font-semibold rounded-full hover:bg-[#F53003] hover:text-white transition-all duration-300">
                    Log In
                </a>
            </div>

            <!-- Floating Illustration -->
            <img src="<?php echo e(asset('images/fruits-basket.png')); ?>" 
                alt="Fresh produce" 
                class="mx-auto mt-12 sm:w-48 md:w-56 lg:w-64 animate-float" />
                
        </div>
    </div>

    <!-- IMPACT METRICS SECTION -->
    <div class="bg-white py-12 md:py-16">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <div class="flex flex-wrap justify-center gap-8 md:gap-16 text-[#F53003] font-semibold">
                <div class="w-28 sm:w-36">
                    <span class="text-3xl sm:text-4xl block"><?php echo e($countReservation); ?></span>
                    <p class="text-[#706f6c] text-sm sm:text-base">Perishables Saved</p>
                </div>
                <div class="w-28 sm:w-36">
                    <span class="text-3xl sm:text-4xl block"><?php echo e($countCustomer); ?></span>
                    <p class="text-[#706f6c] text-sm sm:text-base">Users Interested</p>
                </div>
                <div class="w-28 sm:w-36">
                    <span class="text-3xl sm:text-4xl block"><?php echo e($countSeller); ?></span>
                    <p class="text-[#706f6c] text-sm sm:text-base">Sellers Joined</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<?php /**PATH C:\Users\User\FYP\LRPwDP\resources\views/welcome.blade.php ENDPATH**/ ?>