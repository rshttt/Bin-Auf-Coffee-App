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

        @vite(['resources/css/style.css','resources/js/login.js'])

        <title>
            Login
        </title>
    </head>
    <body class="h-screen w-screen">
        <header class="fixed top-0 px-[40px] min-w-full h-[60px] bg-[#A08963] grid grid-cols-1 z-9">
            <div class="h-[60px] flex items-center">
                <img src="{{ asset('assets/images/logo1.svg') }}" alt="logo" class="h-full">
                <h1 class="pl-2 lemon-regular text-[#E6D4A6]">
                    Bin Auf Coffee
                </h1>
            </div>
        </header>
        <main class="min-w-screen h-screen relative">
            <div>
                <img src="{{ asset('assets/images/ellipse_coklat.svg') }}" alt="ellipse" class="absolute top-0 min-w-full h-[240px] -z-10">
                <img src="{{ asset('assets/images/ellipse_putih.svg') }}" alt="ellipse" class="absolute top-0 min-w-full h-[160px] -z-10">
            </div>
            <div class="h-full w-full pt-[120px] flex justify-center items-center">
                <div class="outline outline-[#A08963] min-w-[440px] min-h-[360px] rounded-[20px] flex flex-col justify-start items-center p-[28px]" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);">
                    <h1 class="lexend-bold text-[#A08963] text-4xl mb-[12px]">
                        SIGN IN
                    </h1>
                    <hr class="border-[#D9D9D9] min-w-[180px] border-t-[6px] rounded-[16px]">
                    <form class="min-w-full min-h-max flex flex-col justify-start mt-[20px] px-[40px]" action="/login" method="POST">
                        @csrf
                        <label for="email" class="lexend-medium text-[#A08963] text-sm mb-[8px] ml-[4px]">Email</label>
                        <div class="flex items-center rounded-[10px] bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#706D54]/75 h-10 w-full mb-[16px]">
                            <input 
                            type="email" 
                            class="rounded-2xl block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" 
                            id="email" 
                            placeholder="name@example.com" 
                            name="email" 
                            value="{{ old('email') }}"
                            required
                            >
                        </div>
                        <label for="password" class="lexend-medium text-[#A08963] text-sm mb-[8px] ml-[4px]">Password</label>
                        <div class="flex items-center rounded-[10px] bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#706D54]/75 h-10 w-full overflow-hidden" id="password-container">
                            <input 
                            type="password" 
                            class="rounded-2xl block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400  focus:outline-none sm:text-sm/6" 
                            id="password" 
                            placeholder="Password" 
                            name="password" 
                            required
                            >
                            <button type="button" id="toggle-password" class="cursor-pointer p-3 hover:bg-gray-100/75 active:bg-gray-200/75">
                                <img src="assets/images/password-hide.svg" alt="pass" class="w-4">
                            </button>
                        </div>
                        <h1 class="lexend-regular text-[#C42D2D] text-[10px] min-h-[10px] max-h-[10px] text-center mt-[8px] mb-[24px]">
                            @error('email')
                                {{ $message }}
                                <script>
                                    $("#password-container")
                                        .removeClass("outline-gray-300 outline-1 -outline-offset-1")
                                        .addClass("outline-[#C42D2D] outline-2 -outline-offset-2")
                                </script>
                            @enderror
                        </h1>
                        <div class="text-center">
                            <button 
                            type="submit" 
                            class="lexend-semibold text-white rounded-full w-[200px] h-[40px] bg-[#706D54] cursor-pointer"
                            >Sign In as Admin</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>