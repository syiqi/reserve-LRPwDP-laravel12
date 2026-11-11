<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit perishable information & pricing') }}
        </h2>
    </x-slot>
    <x-authentication-card>
        
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>
        
        <x-validation-errors class="mb-4" />
        
            @if ($perishable->imagePath)
                <form method="POST" action="{{ route('perishables.removeImage', $perishable->id) }}">
                    @csrf
                    @method('DELETE')
                    <x-secondary-button type="submit" class="text-red-600">
                        {{ __('Remove Image') }}
                    </x-secondary-button>
                </form>
            @endif
        <form method="POST" action="{{ route('perishables.update',$perishable->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div x-data="{ photoName: null, photoPreview: '{{ asset('storage/' . $perishable->imagePath) }}' }">
                <x-label for="imagePath" value="{{ __('Image') }}" />

                <!-- Image File Input -->
                <input type="file" class="hidden" name="imagePath" x-ref="photo" x-on:change="
                    photoName = $refs.photo.files[0].name;
                    const reader = new FileReader();
                    reader.onload = (e) => { photoPreview = e.target.result };
                    reader.readAsDataURL($refs.photo.files[0]);
                " />

                <!-- Current Image -->
                <div class="mt-2" x-show="!photoPreview">
                    @if ($perishable->imagePath)
                        <img src="{{ asset('storage/' . $perishable->imagePath) }}" alt="{{ $perishable->name }}" class="rounded-md w-32 h-32 object-cover border">
                    @else
                        <div class="w-32 h-32 flex items-center justify-center border rounded-md bg-gray-100 text-gray-400">
                            No Image
                        </div>
                    @endif
                </div>

                <!-- Preview of New Image -->
                <div class="mt-2" x-show="photoPreview">
                    <img :src="photoPreview" alt="Preview" class="rounded-md w-32 h-32 object-cover border">
                </div>

                <!-- Buttons -->
                <div class="mt-2 flex items-center gap-2">
                    <x-secondary-button type="button" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select New Image') }}
                    </x-secondary-button>
                </div>

                <x-input-error for="imagePath" class="mt-2" />
            </div>
            <span class="text-xs text-gray-400">
                    Maximum of 2MB - .jpg, .jpeg, .png file only
            </span>

            <div class=" flex space-x-2 mt-4">
                <div class="grow w-3/4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $perishable['name']}}" required autofocus autocomplete="name" placeholder="Fried Chicken/Fried Rice/Cake..etc"/>
                </div>
                <div class="w-1/4">
                <x-label for="measurement" value="{{ __('Measurement') }}" />
                <x-input id="measurement" class="block mt-1 w-full" type="text" name="measurement" value="{{ $perishable['measurement']}}" autofocus placeholder="1 slice/2g/box"/>
                </div>
            </div>
            <div class="mt-4 w-3/4">
                <x-label for="halal" value="{{ __('Halal Status') }}" />

                <div class="flex items-center bg-[#FFF4E6] border-0 border-b-2 border-[#FFB347] text-gray-900 
                                focus:outline-none focus:ring-2 focus:ring-[#FFB347]/40 focus:border-[#FF7A00] rounded-lg p-3.5 mt-1 gap-4">                    <label class="inline-flex items-center mr-4">
                        @if($perishable->halal ==1)
                        <input type="radio" class="form-radio text-indigo-600" name="halal" value=1 {{ old('halal') == '1' ? 'checked' : '' }} required autofocus checked>
                        @else
                        <input type="radio" class="form-radio text-indigo-600" name="halal" value=1 {{ old('halal') == '1' ? 'checked' : '' }} required autofocus>
                        @endif
                        <span class="ml-2 text-sm text-gray-700">Halal</span>
                    </label>

                    <label class="inline-flex items-center">
                        @if($perishable->halal ==0)
                        <input type="radio" class="form-radio text-indigo-600" name="halal" value=0 {{ old('halal') == '0' ? 'checked' : '' }} required autofocus checked>
                        @else
                        <input type="radio" class="form-radio text-indigo-600" name="halal" value=0 {{ old('halal') == '0' ? 'checked' : '' }} required autofocus>
                        @endif
                        <span class="ml-2 text-sm text-gray-700">Non-Halal</span>
                    </label>
                </div>
            </div>
            <span class="text-xs text-gray-400">
                        Click on the related status
                    </span>
            <div class="mt-4 bg-[#FFF4E6] border-0 border-b-2 border-[#FFB347] rounded-lg p-4">

    <x-label for="type" value="{{ __('Type') }}" />

    <div class="grid grid-cols-3 gap-4 mt-3">

        <!-- Prepared Meals -->
        <label class="radio-tile-wrapper">
            <input 
                type="radio" 
                name="type" 
                value="preparedMeals" 
                class="radio-tile-input hidden"
                {{ str_contains($perishable->type, "preparedMeals") ? 'checked' : '' }}
            >
            <div class="radio-tile">
                Prepared Meals
            </div>
        </label>

        <!-- Baked Goods -->
        <label class="radio-tile-wrapper">
            <input 
                type="radio" 
                name="type" 
                value="bakedGoods" 
                class="radio-tile-input hidden"
                {{ str_contains($perishable->type, "bakedGoods") ? 'checked' : '' }}
            >
            <div class="radio-tile">
                Baked Goods
            </div>
        </label>

        <!-- Desserts -->
        <label class="radio-tile-wrapper">
            <input 
                type="radio" 
                name="type" 
                value="desserts"
                class="radio-tile-input hidden"
                {{ str_contains($perishable->type, "desserts") ? 'checked' : '' }}
            >
            <div class="radio-tile">
                Desserts
            </div>
        </label>

        <!-- Beverages -->
        <label class="radio-tile-wrapper">
            <input 
                type="radio" 
                name="type" 
                value="beverages"
                class="radio-tile-input hidden"
                {{ str_contains($perishable->type, "beverages") ? 'checked' : '' }}
            >
            <div class="radio-tile">
                Beverages
            </div>
        </label>

        <!-- Sauces, Jams or Condiments -->
        <label class="radio-tile-wrapper">
            <input 
                type="radio" 
                name="type" 
                value="SJC"
                class="radio-tile-input hidden"
                {{ str_contains($perishable->type, "SJC") ? 'checked' : '' }}
            >
            <div class="radio-tile">
                Sauces, Jams or Condiments
            </div>
        </label>

        <!-- Frozen Foods -->
        <label class="radio-tile-wrapper">
            <input 
                type="radio" 
                name="type" 
                value="frozenFoods"
                class="radio-tile-input hidden"
                {{ str_contains($perishable->type, "frozenFoods") ? 'checked' : '' }}
            >
            <div class="radio-tile">
                Frozen Foods
            </div>
        </label>

        <!-- Canned Foods -->
        <label class="radio-tile-wrapper">
            <input 
                type="radio" 
                name="type" 
                value="cannedFoods"
                class="radio-tile-input hidden"
                {{ str_contains($perishable->type, "cannedFoods") ? 'checked' : '' }}
            >
            <div class="radio-tile">
                Canned Foods
            </div>
        </label>

        <!-- Snacks -->
        <label class="radio-tile-wrapper">
            <input 
                type="radio" 
                name="type" 
                value="snacks"
                class="radio-tile-input hidden"
                {{ str_contains($perishable->type, "snacks") ? 'checked' : '' }}
            >
            <div class="radio-tile">
                Snacks
            </div>
        </label>

        <!-- Dairy Products -->
        <label class="radio-tile-wrapper">
            <input 
                type="radio" 
                name="type" 
                value="dairyProducts"
                class="radio-tile-input hidden"
                {{ str_contains($perishable->type, "dairyProducts") ? 'checked' : '' }}
            >
            <div class="radio-tile">
                Dairy Products
            </div>
        </label>

        <!-- Meats/Seafoods -->
        <label class="radio-tile-wrapper">
            <input 
                type="radio" 
                name="type" 
                value="MS"
                class="radio-tile-input hidden"
                {{ str_contains($perishable->type, "MS") ? 'checked' : '' }}
            >
            <div class="radio-tile">
                Meats or Seafoods
            </div>
        </label>

        <!-- Dry Goods -->
        <label class="radio-tile-wrapper">
            <input 
                type="radio" 
                name="type" 
                value="dryGoods"
                class="radio-tile-input hidden"
                {{ str_contains($perishable->type, "dryGoods") ? 'checked' : '' }}
            >
            <div class="radio-tile">
                Dry Goods
            </div>
        </label>

        <!-- Spices/Seasonings -->
        <label class="radio-tile-wrapper">
            <input 
                type="radio" 
                name="type" 
                value="SS"
                class="radio-tile-input hidden"
                {{ str_contains($perishable->type, "SS") ? 'checked' : '' }}
            >
            <div class="radio-tile">
                Spices or Seasonings
            </div>
        </label>

        <!-- Herbs -->
        <label class="radio-tile-wrapper">
            <input 
                type="radio" 
                name="type" 
                value="herbs"
                class="radio-tile-input hidden"
                {{ str_contains($perishable->type, "herbs") ? 'checked' : '' }}
            >
            <div class="radio-tile">
                Herbs
            </div>
        </label>

    </div>
    
</div>
<span class="text-xs text-gray-400">
                Choose a type
            </span>

            <div class="mt-4">
                    <x-label for="description" value="{{ __('Description') }}" />
                    <textarea id="description" class="input-primary h-24 block mt-1 w-full p-3" type="text" name="description" autofocus placeholder="Ex: An oily fried chicken that has been cooked 2x on a grill with gravy as a side /Contains nuts,allergen warning, seafood..." >{{ $perishable['description']}}</textarea>
            </div>

            <x-label class="mt-8 text-xl border-t-2 border-[#FF7A00]" value="{{ __('Pricing Strategy:-') }}" />
             
            <x-label  class="mt-4" for="quantity" value="{{ __('Quantity Left') }}" />
            <div class="flex space-x-2">
                    <x-input id="quantity" class="block mt-1 w-1/3 text-right" type="number" name="quantity" value="{{ $perishable['quantity']}}" required autofocus />
                    <span class="text-xl w-1/3 p-3">Out Of</span> 
                    <x-input id="quantityOriginal" class="block mt-1 w-1/3" type="number" name="quantityOriginal" value="{{ $perishable['quantityOriginal']}}" required autofocus />
            </div>
            <span class="text-xs text-gray-400">
                    The difference determines the updated current price 
            </span>
            <x-label class="mt-4" for="priceOriginal" value="{{ __('Price Range (RM)') }}" />
            <div class="flex space-x-2">  
                <x-input id="priceOriginal" class="block mt-1 w-1/2 text-right" type="number" step="0.01" name="priceOriginal" value="{{ number_format($perishable['priceOriginal'],2)}}" required autofocus />
                <span class="text-3xl mt-2">~</span> 
                <x-input id="priceLowerBound" class="block mt-1 w-1/2" type="number" step="0.01"  name="priceLowerBound" value="{{ number_format($perishable['priceLowerBound'],2)}}" required autofocus />
            </div>
            <span class="text-xs text-gray-400">
                    Highest ~ Lowest possible price range 
            </span>
            <div class="mt-4">
                <x-label for="priceCurrent" value="{{ __('Current Price (RM)') }}" />
                <x-input id="priceCurrent" class="block mt-1 w-full text-right" type="number" step="0.01"  name="priceCurrent" value="{{ number_format($perishable['priceCurrent'],2)}}" required autofocus />
            <span class="text-xs text-gray-400">
                    Current Price is automatically updated by the hour 
            </span>
            </div>

            <div class="mt-4">
                <x-label for="expiryDate" value="{{ __('Expiry Date') }}" />
                <x-input id="expiryDate" class="block mt-1 w-full" type="datetime-local" name="expiryDate" value="{{ \Carbon\Carbon::parse($perishable['expiryDate'])->format('Y-m-d\TH:i') }}" required autofocus/>            
            <span class="text-xs text-gray-400">
                    Enter expiry date and time
                </span>
            </div>

            
            <div class="flex items-center justify-end mt-4">

                <x-button class="ms-4">
                    {{ __('Update') }}
                </x-button>
            </div>

        </form>

        <form method="POST" action="{{ route('perishables.unlist', $perishable->id) }}" onsubmit="return confirm('Are you sure you want to list/unlist this perishable?');">
            @csrf
            @method('PUT')
            <x-secondary-button type="submit" class="text-gray-600">
                {{ __('List/Unlist') }}
            </x-secondary-button>
        </form>

        <form method="POST" action="{{ route('perishables.destroy', $perishable->id) }}" onsubmit="return confirm('Are you sure you want to delete this perishable?');">
            @csrf
            @method('DELETE')
            <x-secondary-button type="submit" class="mt-2 text-red-600">
                {{ __('Delete') }}
            </x-secondary-button>
        </form>
    </x-authentication-card>
</x-app-layout>