<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        
        <!-- font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
        
        @vite(['resources/css/style.css'])

        <title>
            {{ $product->name }}
        </title>
    </head>
    <body>
        <header class="fixed top-0 px-[40px] min-w-full h-[60px] bg-[#A08963] grid grid-cols-2 z-9">
            <div class="h-[60px] flex items-center">
                <img src="{{ asset('assets/images/logo1.svg') }}" alt="logo" class="h-full">
                <h1 class="pl-2 lemon-regular text-[#E6D4A6]">
                    Bin Auf Coffee
                </h1>
            </div>
        </header>
        <main>
            <div class="min-w-full h-screen">
                <div>
                    <img src="{{ asset('assets/images/ellipse_coklat.svg') }}" alt="ellipse" class="absolute top-0 min-w-full h-[240px] -z-10">
                    <img src="{{ asset('assets/images/ellipse_putih.svg') }}" alt="ellipse" class="absolute top-0 min-w-full h-[160px] -z-10">
                </div>
            </div>
            <div class="absolute top-0 left-0 w-screen h-screen z-10 bg-gray-100/50 flex justify-center items-center">
                <div class="w-[60%] h-[75%] mt-[60px] bg-white outline-2 outline-[#A08963] rounded-[24px] flex flex-col items-center relative">
                    <button class="absolute top-[16px] right-[16px] cursor-pointer" onclick="window.location.href = '/'">
                        <img src="{{ asset('assets/images/icon-x.svg') }}" alt="" width="20">
                    </button>
                    <h1 class="lexend-bold text-3xl text-[#706D54] uppercase mt-[24px]">
                        MENU
                    </h1>
                    <div class="h-full w-full px-[60px] my-[20px] flex justify-between gap-[40px]">
                        <div class="flex justify-center items-center overflow-hidden min-w-[200px] max-w-[200px] min-h-[280px] max-h-[280px] bg-white outline-2 outline-[#D9D9D9] rounded-[12px]" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);">
                            <img src="/{{ $product->image_path }}" alt="product-image">
                        </div>
                        <div class="w-full flex flex-col gap-[12px]">
                            <div class="flex gap-[12px]">
                                <h1 class="lexend-medium text-lg text-[#A08963]">
                                    Product Categories :
                                </h1>
                                <h1 class="uppercase lexend-medium text-xl text-[#706D54]">
                                    {{ $product->category->name }}
                                </h1>
                            </div>
                            <div class="flex gap-[12px]">
                                <h1 class="lexend-medium text-lg text-[#A08963]">
                                    Name of the Product :
                                </h1>
                                <h1 class="uppercase lexend-medium text-xl text-[#706D54]">
                                    {{ $product->name }}
                                </h1>
                            </div>
                            <div class="flex gap-[12px]">
                                <h1 class="lexend-medium text-lg text-[#A08963]">
                                    Product Price :
                                </h1>
                                <h1 class="lexend-medium text-xl text-[#706D54]">
                                    Rp. {{ $product->price }}
                                </h1>
                            </div>
                            <div class="flex gap-[12px]">
                                <h1 class="lexend-medium text-lg text-[#A08963]">
                                    Rate :
                                </h1>
                                <h1 class="lexend-medium text-xl text-[#706D54]">
                                    {{ $product->review->rate ?? 0 }}
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>