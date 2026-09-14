@props(['product'])

<div class="group">

    <div class="relative aspect-[1.05/1] overflow-hidden rounded-sm bg-gray-100">

        <img src="{{ $product->image ? Storage::url($product->image) : 'https://placehold.co/400x400?text=No+Image' }}"
            alt="{{ $product->title }}"
            class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.02]">

        <button type="button"
            class="absolute right-3 bottom-3 flex h-7 w-7 items-center justify-center rounded-sm bg-white transition hover:bg-gray-50"
            aria-label="Add to wishlist">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 8.25c0 5.25-9 10.5-9 10.5S3 13.5 3 8.25A4.5 4.5 0 0112 6a4.5 4.5 0 019 2.25z" />
            </svg>
        </button>
    </div>

    <div class="mt-2">
        <h3 class="text-[11px] leading-4 text-gray-700">
            {{ $product->title }}
        </h3>

        <p class="mt-0.5 text-[12px] font-medium text-gray-900">
            £{{ number_format($product->price, 2) }}
        </p>

        <div class="mt-1.5 flex items-center gap-2">
            <div class="h-4 w-4 overflow-hidden rounded-full bg-gray-200">
                <img src="{{ $product->seller_avatar ? Storage::url($product->seller_avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($product->seller_name) . '&size=40&background=d9f99d&color=374151' }}"
                    alt="{{ $product->seller_name }}" class="h-full w-full object-cover">
            </div>

            <span class="text-[10px] text-gray-700">
                {{ $product->seller_name }}
            </span>

        </div>

    </div>



</div>
