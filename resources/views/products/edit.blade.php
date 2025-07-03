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

        <style>
            input[type=number]::-webkit-outer-spin-button,
            input[type=number]::-webkit-inner-spin-button {
              -webkit-appearance: none;
              margin: 0;
            }

            input[type=number] {
              -moz-appearance: textfield;
            }
        </style>

        <script>
            $(document).ready(() => {
                $("body").hide().fadeIn(300)
                
                $("button[id='increase']").click(() => {
                    const newVal = parseInt($("input[name='stock']").val()) + 1
                    $("input[name='stock']").val(newVal)
                })
                $("button[id='decrease']").click(() => {
                    const newVal = parseInt($("input[name='stock']").val()) - 1
                    if(newVal >= 0)
                        $("input[name='stock']").val(newVal)
                })
                $("#remove-image-btn").click(() => {
                    $("#image-preview").attr("src", "");
                    $("#image-input").val(null); 
                    $("#image-preview").hide(); 
                    $("#remove-image-flag").val("1");
                });
            
                $("#edit-image-btn").click(() => {
                    $("#image-input").click();
                });
            
                $("#image-input").on('change', function(event) {
                    const file = event.target.files[0];
                
                    if (file) {
                        const reader = new FileReader();
                    
                        reader.onload = function(e) {
                            $("#image-preview").attr("src", e.target.result);

                            $("#image-preview").show(); 

                            $("#remove-image-flag").val("0");
                        }
                    
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>
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
                <div class="w-[80%] h-[500px] mx-[120px] bg-white outline-2 outline-[#A08963] rounded-[24px] flex flex-col items-center relative">
                    <button class="absolute top-[16px] right-[16px] cursor-pointer" onclick="window.location.href = '/admin'">
                        <img src="{{ asset('assets/images/icon-x.svg') }}" alt="" width="20">
                    </button>
                    <h1 class="lexend-bold text-3xl text-[#706D54] uppercase mt-[24px]">
                        EDIT PRODUCT
                    </h1>
                    <div class="h-full w-full px-[60px] my-[20px] flex justify-between gap-[40px]">
                        <form action="/products/{{ $product->id }}" method="POST" class="absolute top-[20px] left-[20px]" onsubmit="return confirm('Apakah anda yakin?')">
                            @csrf
                            @method('DELETE')
                            <button class="lexend-medium outline-1 outline-red-600 text-red-600 rounded-lg px-10 cursor-pointer hover:bg-red-600 hover:text-white active:bg-red-600/80 h-[40px] max-w-[80px] flex justify-center items-center" type="submit">
                                Delete
                            </button>
                        </form>
                        <div class="grid justify-between">
                            <div class="flex justify-center items-center overflow-hidden min-w-[200px] max-w-[200px] min-h-[260px] max-h-[260px] bg-white outline-2 outline-[#D9D9D9] rounded-[12px] mb-[16px]" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);">
                                <img src="/{{ $product->image_path ?? '' }}" alt="product-image" id="image-preview" class="w-full h-full object-cover">
                            </div>
                            <button
                            class="lexend-medium text-white bg-[#C9B194] border-b-3 border-gray-400/75 rounded-lg h-[40px] flex justify-center items-center cursor-pointer"
                            id="edit-image-btn"
                            >
                                <img src="{{ asset('assets/images/icon-edit-image.svg') }}" alt="" width="28">
                                Edit Image
                            </button>
                            <button
                            class="lexend-medium text-[#706D54] bg-[#EFE2D2] border-b-3 border-gray-400/75 rounded-lg h-[40px] flex justify-center items-center cursor-pointer"
                            id="remove-image-btn"
                            >
                                <img src="{{ asset('assets/images/icon-remove.svg') }}" alt="" width="28">
                                Remove Image
                            </button>
                        </div>
                        <form id="edit-product-form" class="w-full flex flex-col gap-[8px]" action="/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="file" id="image-input" name="image_path" accept="image/png, image/jpeg, image/svg" hidden>
                            <input type="hidden" name="remove_image" id="remove-image-flag" value="0">
                            <div class="grid">
                                <h1 class="lexend-medium text-md text-[#A08963]">
                                    Product Categories
                                </h1>
                                <div class="flex items-center rounded-[8px] pl-3 outline-1 -outline-offset-1 outline-gray-300 bg-white focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#706D54] w-full h-[40px] z-2 relative">
                                    <input 
                                    class="rounded-r-4xl block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-[#706D54] font-medium focus:outline-none sm:text-sm/6 capitalize"
                                    type="text" 
                                    name="category"
                                    value="{{ $product->category->name }}"
                                    >
                                </div>
                            </div>
                            <div class="grid">
                                <h1 class="lexend-medium text-md text-[#A08963]">
                                    Name of the Product
                                </h1>
                                <div class="flex items-center rounded-[8px] pl-3 outline-1 -outline-offset-1 outline-gray-300 bg-white focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#706D54] w-full h-[40px] z-2 relative">
                                    <input 
                                    class="rounded-r-4xl block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-[#706D54] font-medium focus:outline-none sm:text-sm/6 capitalize"
                                    type="text" 
                                    name="name"
                                    value="{{ $product->name }}"
                                    >
                                </div>
                            </div>
                            <div class="grid">
                                <h1 class="lexend-medium text-md text-[#A08963]">
                                    Description of the Product
                                </h1>
                                <div class="flex items-start rounded-[8px] pl-3 outline-1 -outline-offset-1 outline-gray-300 bg-white focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#706D54] w-full h-[80px] z-2 relative">
                                    <textarea 
                                    class="block min-w-0 grow py-1.5 pr-3 pl-1 h-full text-base text-[#706D54] font-medium focus:outline-none sm:text-sm/6 capitalize"
                                    name="description" 
                                    id="description-form"
                                    >{{ trim($product->description) }}</textarea>
                                </div>
                            </div>
                            <div class="grid">
                                <h1 class="lexend-medium text-md text-[#A08963]">
                                    Product Price
                                </h1>
                                <div class="flex items-center rounded-[8px] pl-3 outline-1 -outline-offset-1 outline-gray-300 bg-white focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#706D54] w-full h-[40px] z-2 relative">
                                    <input 
                                    class="rounded-r-4xl block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-[#706D54] font-medium focus:outline-none sm:text-sm/6 capitalize"
                                    type="number"
                                    min="0" 
                                    name="price"
                                    value="{{ $product->price }}"
                                    >
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <div class="grid justify-items-start gap-[4px]">
                                    <h1 class="lexend-medium text-md text-[#A08963]">
                                        Product Stack Quantity
                                    </h1>
                                    <div class="flex justify-center items-center gap-[20px]">
                                        <button type="button" class="lexend-semibold text-[#706D54] text-xl min-h-[32px] rounded-[8px] min-w-[60px] bg-[#D9D9D9] cursor-pointer" id="increase">
                                            +
                                        </button>
                                        <input type="number" name="stock" value="{{ $product->stock }}" min="0" class=" lexend-semibold text-xl text-[#706D54] max-w-[40px] text-center">
                                        <button type="button" class="lexend-semibold text-[#706D54] text-xl min-h-[32px] rounded-[8px] min-w-[60px] bg-[#D9D9D9] cursor-pointer" id="decrease">
                                            -
                                        </button>
                                    </div>
                                </div>
                                <button
                                type="submit"
                                class="lexend-medium bg-[#706D54] outline-1 outline-[#A08963] text-white rounded-lg px-10 cursor-pointer hover:bg-[#706D54]/80 active:bg-[#706D54] h-[40px] self-end"
                                >
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>