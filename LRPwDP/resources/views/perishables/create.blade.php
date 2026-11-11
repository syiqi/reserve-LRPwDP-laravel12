<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Add New Perishable') }}
    </h2>
    </x-slot>
    <x-authentication-card>

        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>
        

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('perishables.store') }}" enctype="multipart/form-data">
            @csrf
            
            {{-- Image preview container --}}
            <div class="mt-4">
                <img id="imagePreview" src="#" alt="Preview" class="hidden w-40 h-40 object-cover rounded-md border" />
            </div>
            <div class="mt-4">
                <x-label for="imagePath" value="{{ __('Upload Image') }}" />
                <x-input id="imagePath" class="block mt-1 w-full p-2" type="file" name="imagePath" accept="image/*" onchange="previewImage(event)" />
            </div>
            <span class="text-xs text-gray-400">
                    Maximum of 2MB - .jpg, .jpeg, .png file only
            </span>
            <script>
            function previewImage(event) {
                const image = document.getElementById('imagePreview');
                image.src = URL.createObjectURL(event.target.files[0]);
                image.classList.remove('hidden');
            }
            </script>

            <div class=" flex space-x-2 mt-4">
                <div  class="grow w-3/4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Fried Chicken/Fried Rice/Cake..etc" />
                </div>
                <div class="w-1/4">
                    <x-label for="measurement" value="{{ __('Measurement') }}" />
                    <x-input id="measurement" class="block mt-1 w-full" type="text" name="measurement" :value="old('measurement')" autofocus placeholder="1 slice/2g/box" />
                </div>
            </div>
            <div class=" flex space-x-2 mt-4">
                <div class="mt-4 w-1/4">
                    <x-label for="quantityOriginal" value="{{ __('Quantity') }}" />
                    <x-input id="quantityOriginal" class="block mt-1 w-full" type="number" name="quantityOriginal" :value="old('quantityOriginal')" required autofocus placeholder="1/2/3..." />
                </div>
                <div class="mt-4 w-3/4">
                    <x-label for="halal" value="{{ __('Halal Status') }}" />

                    <div class="flex items-center bg-[#FFF4E6] border-0 border-b-2 border-[#FFB347] text-gray-900 
                                focus:outline-none focus:ring-2 focus:ring-[#FFB347]/40 focus:border-[#FF7A00] rounded-lg p-3.5 mt-1 gap-4">
                        <label class="inline-flex items-center mr-4">
                            <input type="radio" class="form-radio text-indigo-600" name="halal" value=1 {{ old('halal') == '1' ? 'checked' : '' }} required autofocus>
                            <span class="ml-2 text-sm text-gray-700">Halal</span>
                        </label>

                        <label class="inline-flex block items-center">
                            <input type="radio" class="form-radio text-indigo-600" name="halal" value=0 {{ old('halal') == '0' ? 'checked' : '' }} required autofocus>
                            <span class="ml-2 text-sm text-gray-700">Non-Halal</span>
                        </label>
                    </div>
                    <span class="text-xs text-gray-400">
                        Click on the related status
                    </span>
                </div>
            </div>
            <div class="mt-4 bg-[#FFF4E6] border-0 border-b-2 border-[#FFB347] rounded-lg p-4">

                <x-label for="type" value="{{ __('Type') }}" />

                <div class="grid grid-cols-3 gap-4 mt-3">

                    @php
                        $types = [
                            'preparedMeals' => 'Prepared Meals',
                            'bakedGoods' => 'Baked Goods',
                            'desserts' => 'Desserts',
                            'beverages' => 'Beverages',
                            'SJC' => 'Sauces, Jams or Condiments',
                            'frozenFoods' => 'Frozen Foods',
                            'cannedFoods' => 'Canned Foods',
                            'snacks' => 'Snacks',
                            'dairyProducts' => 'Dairy Products',
                            'MS' => 'Meats or Seafoods',
                            'dryGoods' => 'Dry Goods',
                            'SS' => 'Spices or Seasonings',
                            'herbs' => 'Herbs',
                        ];
                    @endphp

                    @foreach ($types as $value => $label)
                        <label class="cursor-pointer">
                            <input
                                type="radio"
                                name="type"
                                value="{{ $value }}"
                                class="peer hidden"
                                {{ old('type') == $value ? 'checked' : '' }}
                            >
                            <div class="flex items-center justify-center text-center
                                        p-3 border border-2 rounded-lg text-center text-sm font-medium
                                        bg-white text-gray-800 border-gray-300
                                        hover:bg-gray-100 transition
                                        peer-checked:bg-[#FFB347]
                                        peer-checked:border-[#FF7A00]
                                        h-16">
                                {{ $label }}
                            </div>
                        </label>
                    @endforeach

                </div>

            </div>

            
            <span class="text-xs text-gray-400">
                Choose a type
            </span>
            <div class="mt-4">
                <x-label for="expiryDate" value="{{ __('Expiry Date') }}" />
                <x-input id="expiryDate" class="block mt-1 w-full" type="datetime-local" name="expiryDate" required autofocus />
                <span class="text-xs text-gray-400">
                    Enter expiry date and time
                </span>
            </div>
                
            <div class="mt-4">
                <x-label for="description" value="{{ __('Description') }}" />
                <textarea id="description" type="text" name="description" autofocus class="input-primary block h-24 mt-1 w-full" placeholder="Ex: An oily fried chicken that has been cooked 2x on a grill with gravy as a side /Contains nuts,allergen warning, seafood..."></textarea>
            </div>

            

            
            <x-label class="mt-8" for="priceOriginal" value="{{ __('Pricing Range (RM)') }}" />
            <div class="flex space-x-2">
                <x-input id="priceOriginal" class="block mt-1 w-1/2" type="number" step="0.01" name="priceOriginal" :value="old('priceOriginal')" required autofocus placeholder="51.00" />
                <span class="text-3xl mt-2">~</span> 
                <x-input id="priceLowerBound" class="block mt-1 w-1/2" type="number" step="0.01" name="priceLowerBound" :value="old('priceLowerBound')" required autofocus placeholder="21.50"/>
            </div>
            <span class="text-xs text-gray-400">
                    Highest ~ Lowest Possible Price Range 
            </span>
            
            <div class="flex items-center justify-end mt-4">

                <x-button class="ms-4">
                    {{ __('List') }}
                </x-button>
            </div>
            
        </form>
    </x-authentication-card>
</x-app-layout>