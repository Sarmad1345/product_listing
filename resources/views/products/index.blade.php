@extends('layouts.app')

@section('content')
    <div class="mx-auto min-h-screen max-w-[1120px] px-8 py-16">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-5 rounded-sm border border-green-200 bg-green-50 px-4 py-3 text-[11px] text-green-700">
                {{ session('success') }}
            </div>
        @endif


        {{-- Top Controls --}}
        <form method="GET" action="{{ route('products.index') }}">
        <div class="mb-8 flex items-center justify-between gap-6">

            {{-- Search --}}
            <div class="relative w-[390px]">

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search"
                    class="h-9 w-full rounded-sm border border-gray-200 bg-white px-3 pr-10 text-[11px] text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-gray-400">

                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-4 w-4 text-gray-700">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.197 5.197a7.5 7.5 0 0 0 10.606 10.606Z" />
                    </svg>
                </button>

            </div>


            {{-- Right Controls --}}
            <div class="flex items-center gap-3">

                <span class="text-[11px] font-medium text-gray-900">
                    Sort by
                </span>


                {{-- Sort --}}
                <select name="sort" onchange="this.form.submit()"
                    class="h-9 w-[148px] rounded-sm border border-gray-200 bg-white px-3 text-[11px] text-gray-700 outline-none focus:border-gray-400">

                    <option value="latest"         @selected(request('sort') == 'latest')>Latest</option>
                    <option value="price_low_high" @selected(request('sort') == 'price_low_high')>Price: Low to High</option>
                    <option value="price_high_low" @selected(request('sort') == 'price_high_low')>Price: High to Low</option>
                    <option value="a_z"            @selected(request('sort') == 'a_z')>A - Z</option>
                    <option value="z_a"            @selected(request('sort') == 'z_a')>Z - A</option>

                </select>


                {{-- Sell Item Button --}}
                <button type="button" onclick="openSellModal()"
                    class="flex h-9 items-center gap-2 rounded-sm bg-lime-300 px-4 text-[11px] font-medium text-gray-900 transition hover:bg-lime-400">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>

                    Sell item

                </button>

            </div>

        </div>
        </form>


        {{-- Products Grid --}}
        <div class="grid grid-cols-4 gap-x-5 gap-y-10">

            @forelse($products as $product)
                <x-product-card :product="$product" />

            @empty

                <div class="col-span-4 py-20 text-center">

                    <p class="text-sm text-gray-500">
                        No products found.
                    </p>

                </div>
            @endforelse

        </div>




    </div>


    {{-- ========================================================= --}}
    {{-- SELL ITEM MODAL --}}
    {{-- ========================================================= --}}

    <div id="sellItemModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/30 px-4">

        <div class="relative w-full max-w-[395px] rounded-sm bg-white px-6 py-6 shadow-xl">

            {{-- Close Button --}}
            <button type="button" onclick="closeSellModal()"
                class="absolute right-3 top-3 text-gray-500 transition hover:text-gray-900" aria-label="Close">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>

            </button>


            {{-- Modal Heading --}}
            <h2 class="mb-5 text-[16px] font-semibold text-gray-900">
                Sell an item
            </h2>


            {{-- Form --}}
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">

                @csrf


                {{-- Upload Photos --}}
                <div class="mb-3">

                    <label class="mb-1 block text-[8px] text-gray-700">
                        Upload photos
                    </label>


                    <div class="flex h-[92px] items-center justify-center border border-gray-200">

                        <label for="productImage"
                            class="cursor-pointer rounded-sm border border-lime-300 px-3 py-1.5 text-[8px] text-gray-700 transition hover:bg-lime-50">
                            Upload photo
                        </label>


                        <input id="productImage" type="file" name="image" accept="image/jpeg,image/png,image/webp"
                            class="hidden" required>

                    </div>


                    {{-- Selected Image Name --}}
                    <p id="imageName" class="mt-1 hidden text-[8px] text-gray-500"></p>


                    {{-- Image Error --}}
                    @error('image')
                        <p class="mt-1 text-[8px] text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Title --}}
                <div class="mb-3">

                    <label for="title" class="mb-1 block text-[8px] text-gray-700">
                        Title
                    </label>


                    <input id="title" type="text" name="title" value="{{ old('title') }}"
                        class="h-6 w-full rounded-sm border border-gray-200 px-2 text-[9px] outline-none focus:border-gray-400"
                        required>


                    @error('title')
                        <p class="mt-1 text-[8px] text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Description --}}
                <div class="mb-3">

                    <label for="description" class="mb-1 block text-[8px] text-gray-700">
                        Describe your item
                    </label>


                    <textarea id="description" name="description" rows="4"
                        class="w-full resize-none rounded-sm border border-gray-200 px-2 py-2 text-[9px] outline-none focus:border-gray-400"
                        required>{{ old('description') }}</textarea>


                    @error('description')
                        <p class="mt-1 text-[8px] text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Category --}}
                <div class="mb-3">

                    <label for="category" class="mb-1 block text-[8px] text-gray-700">
                        Category
                    </label>


                    <select id="category" name="category"
                        class="h-6 w-full rounded-sm border border-gray-200 bg-white px-2 text-[9px] text-gray-500 outline-none focus:border-gray-400"
                        required>

                        <option value="">
                            Select
                        </option>

                        <option value="Clothing" @selected(old('category') === 'Clothing')>
                            Clothing
                        </option>

                        <option value="Shoes" @selected(old('category') === 'Shoes')>
                            Shoes
                        </option>

                        <option value="Accessories" @selected(old('category') === 'Accessories')>
                            Accessories
                        </option>

                        <option value="Bags" @selected(old('category') === 'Bags')>
                            Bags
                        </option>

                        <option value="Other" @selected(old('category') === 'Other')>
                            Other
                        </option>

                    </select>


                    @error('category')
                        <p class="mt-1 text-[8px] text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Price --}}
                <div class="mb-4">

                    <label for="price" class="mb-1 block text-[8px] text-gray-700">
                        Item price
                    </label>


                    <div class="relative">

                        <span class="absolute left-2 top-1/2 -translate-y-1/2 text-[9px] text-gray-700">
                            £
                        </span>


                        <input id="price" type="number" name="price" value="{{ old('price') }}" step="0.01"
                            min="0" placeholder="00.00"
                            class="h-6 w-full rounded-sm border border-gray-200 px-6 text-right text-[9px] outline-none focus:border-gray-400"
                            required>

                    </div>


                    @error('price')
                        <p class="mt-1 text-[8px] text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Seller Name --}}
                <div class="mb-4">

                    <label for="seller_name" class="mb-1 block text-[8px] text-gray-700">
                        Your name
                    </label>

                    <input id="seller_name" type="text" name="seller_name" value="{{ old('seller_name') }}"
                        placeholder="e.g. John Smith"
                        class="h-6 w-full rounded-sm border border-gray-200 px-2 text-[9px] outline-none focus:border-gray-400"
                        required>

                    @error('seller_name')
                        <p class="mt-1 text-[8px] text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Submit --}}
                <button type="submit"
                    class="h-6 w-full rounded-sm bg-lime-300 text-[8px] font-medium text-gray-900 transition hover:bg-lime-400 hover:bg-lime-400">
                    Upload item
                </button>

            </form>

        </div>

    </div>


    <script>
        /**
         * Open Sell Item Modal
         */
        function openSellModal() {

            const modal = document.getElementById('sellItemModal');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.body.classList.add('overflow-hidden');
        }


        /**
         * Close Sell Item Modal
         */
        function closeSellModal() {

            const modal = document.getElementById('sellItemModal');

            modal.classList.add('hidden');
            modal.classList.remove('flex');

            document.body.classList.remove('overflow-hidden');
        }


        /**
         * Close modal when clicking outside
         */
        document
            .getElementById('sellItemModal')
            .addEventListener('click', function(event) {

                if (event.target === this) {
                    closeSellModal();
                }

            });


        /**
         * Close modal with Escape key
         */
        document.addEventListener('keydown', function(event) {

            if (event.key === 'Escape') {
                closeSellModal();
            }

        });


        /**
         * Show selected image name
         */
        document
            .getElementById('productImage')
            .addEventListener('change', function() {

                const imageName = document.getElementById('imageName');

                if (this.files.length > 0) {

                    imageName.textContent = this.files[0].name;

                    imageName.classList.remove('hidden');

                } else {

                    imageName.textContent = '';

                    imageName.classList.add('hidden');

                }

            });


        /**
         * Automatically open modal
         * when Laravel validation fails
         */
        @if ($errors->any())
            openSellModal();
        @endif
    </script>
@endsection
