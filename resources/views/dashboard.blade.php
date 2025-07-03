<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        
        <!-- font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
        
        @vite(['resources/css/style.css', 'resources/js/dashboard.js'])

        <title>
            Bin Auf Coffee
        </title>
    </head>
    <body class="h-full w-full">
        <header class="fixed top-0 px-[40px] min-w-full h-[60px] bg-[#A08963] grid grid-cols-2 z-9">
            <div class="h-[60px] flex items-center">
                <img src="{{ asset('assets/images/logo1.svg') }}" alt="logo" class="h-full">
                <h1 class="pl-2 lemon-regular text-[#E6D4A6]">
                    Bin Auf Coffee
                </h1>
            </div>
            <div class="pt-[8px] pr-[20px] flex justify-end gap-x-[10px] text-white">
                <button
                class="lexend-regular h-[50px] w-[128px] cursor-pointer focus:outline-none"
                id="home-button"
                >
                    Home
                    <hr class="mt-[8px] border-y-[2px] border-[#D9D9D9] rounded-xl m-auto" style="visibility: hidden;">
                </button>
                <button
                class="lexend-regular h-[50px] w-[128px] cursor-pointer focus:outline-none"
                id="newspapers-button"
                >
                    Newspapers
                    <hr class="mt-[8px] border-y-[2px] border-[#D9D9D9] rounded-xl m-auto" style="visibility: hidden;">
                </button>
                <div class="grid min-h-max min-w-max" id="toggle">
                    <button
                    class="lexend-regular h-[50px] w-[128px] cursor-pointer focus:outline-none relative"
                    id="reviews-button"
                    >
                        Reviews
                        <hr class="mt-[8px] border-y-[2px] border-[#D9D9D9] rounded-xl m-auto" style="visibility: hidden;">
                    </button>
                    <div
                    class="mt-0.5 bg-[#C9B194] w-[128px] grid grid-cols-1 justify-center gap-[8px] p-[8px] shadow-sm shadow-[#A08963]"
                    id="reviews-list"
                    style="display: none;"
                    >
                        <button
                        class="lexend-regular hover:bg-[#CFCFCF]/75 hover:text-[#4E4C3D]/50 text-[#A08963] text-sm cursor-pointer min-h-[28px] w-full rounded-[6px]"
                        id="reviews-list-products"
                        >
                            Our Products
                        </button>
                        <button
                        class="lexend-regular hover:bg-[#CFCFCF]/75 hover:text-[#4E4C3D]/50 text-[#A08963] text-sm cursor-pointer min-h-[28px] w-full rounded-[6px]"
                        id="reviews-list-overall"
                        >
                            Overall
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <main>
            <div
            id="home-content"
            style="display: none;"
            >
                <div
                class="min-w-full h-screen relative grid"
                id="pages-1"
                >
                    <div>
                        <img src="{{ asset('assets/images/ellipse_coklat.svg') }}" alt="ellipse" class="absolute top-0 min-w-full h-[240px] -z-10">
                        <img src="{{ asset('assets/images/ellipse_putih.svg') }}" alt="ellipse" class="absolute top-0 min-w-full h-[160px] -z-10">
                    </div>
                    <div class="justify-self-center flex gap-x-[60px] mt-[120px] fade-in-section opacity-0 translate-y-8 transition-all duration-700 ease-out">
                        <div class="w-[320px] h-[300px] rounded-[24px] flex justify-center" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);"
                        >
                            <img src="{{ asset('assets/images/logo2.svg') }}" alt="logo" class="min-h-full max-h-full">
                        </div>
                        <div class="w-[520px]">
                            <h1 class="mt-1 lemon-regular text-[#706D54] text-end text-[40px]">
                                Bin Auf Coffee
                            </h1>
                            <p class="mt-5 lexend-regular text-[#706D54] text-end text-xl">
                                Rasa dan suasana menyatu di Bin Auf Coffee. <br>
                                Setiap tegukan punya cerita. Dengan racikan terbaik dan suasana nyaman, kami hadirkan pengalaman ngopi yang berkesan. Temukan rasa, temukan ketenangan - <i>hanya di Bin Auf Coffee</i>.
                            </p>
                        </div>
                    </div>
                </div>
                <div
                class="w-full h-screen bg-[#D9D9D980]"
                id="pages-2"
                >
                    <div class="grid justify-self-center fade-in-section opacity-0 translate-y-8 transition-all duration-700 ease-out">
                        <h1 class="lexend-bold text-center text-[40px] text-[#A08963] mt-[28px] mb-[20px]">
                            OUR MENU
                        </h1>
                        <div class="w-full py-[20px] overflow-x-auto snap-x snap-mandatory no-scrollbar">
                            <div class="flex gap-[50px] w-max mx-[50px]" id="menu"></div>
                        </div>
                    </div>
                </div>
                <div
                class="w-full h-screen flex justify-center items-center"
                id="pages-3"
                >
                    <div class="w-full grid grid-cols-2 fade-in-section opacity-0 translate-y-8 transition-all duration-700 ease-out">
                        <div class="ml-[160px] mt-[20px] mr-[120px]">
                            <h1 class="lexend-bold text-start text-[40px] text-[#A08963] mb-[10px]">
                                ADDRESS
                            </h1>
                            <p class="lexend-regular text-start text-xl text-[#706D54] mb-[40px]">
                                Jl. Domas No. 53, RT. 003/RW. 008, Salatiga, Kec. Sidorejo, Kota Salatiga, Jawa Tengah 50711.
                            </p>
                            <p class="lexend-regular text-start text-xl text-[#706D54]">
                                ini tambahin apa gitu ya biar agak berisi
                            </p>
                        </div>
                        <div>
                            <a href="https://maps.app.goo.gl/E4uTXjZkNLC5qNnF8" target="_blank" rel="noopener noreferrer" class="flex justify-center items-center transition duration-300 overflow-hidden ease-in-out w-[500px] h-[440px] hover:scale-104 outline-3 outline-[#D9D9D980] rounded-xl shadow-lg">
                                <img src="{{ asset('assets/images/map.svg') }}" alt="map" class="min-w-[600px] min-h-[560px]">
                            </a>
                        </div>
                    </div>
                </div>
                <div
                class="w-full min-h-screen max-h-max bg-[#D9D9D980] pb-[40px]"
                id="pages-4"
                >
                    <div class="grid justify-self-center fade-in-section opacity-0 translate-y-8 transition-all duration-700 ease-out">
                        <h1 class="lexend-bold text-center text-[40px]/[40px] text-[#A08963] mt-[28px]">
                            GALLERY
                        </h1>
                        <h1 class="lemon-regular text-center text-[48px] text-[#706D54] mb-[40px]">
                            Bin Auf Coffee
                        </h1>
                        <div class="w-full py-[4px] overflow-x-auto snap-x snap-mandatory no-scrollbar">
                            <div class="grid grid-flow-col grid-rows-2 gap-[20px] w-max mx-[100px]" id="gallery"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div
            id="newspapers-content"
            style="display: none;"
            >
                <div class="min-h-max w-full">
                    <div>
                        <img src="{{ asset('assets/images/ellipse_coklat.svg') }}" alt="ellipse" class="absolute top-0 w-full h-[240px] -z-10">
                        <img src="{{ asset('assets/images/ellipse_putih.svg') }}" alt="ellipse" class="absolute top-0 w-full h-[160px] -z-10">
                    </div>
                    <div class="fade-in-section opacity-0 translate-y-8 transition-all duration-700 ease-out grid justify-items-center pt-[140px] pb-[100px]" id="opening">
                        <h1 class="lexend-bold text-[#A08963] text-[42px] mb-[12px]">
                            NEWSPAPERS
                        </h1>
                        <h1 class="lexend-bold text-[#706D54] text-xl w-[600px] text-center mb-[40px]">
                            Coffee's hot, stories are hotter. Dive into what's brewing behind the bar and beyond!
                        </h1>
                        <div class="w-full py-[4px] overflow-x-auto snap-x snap-mandatory no-scrollbar">
                            <div class="flex gap-[60px] w-max mx-[140px] min-h-max" id="newspapers"></div>
                        </div>
                    </div>
                    <div id="show-news" style="display: none;">
                        <div class="fade-in-section opacity-0 translate-y-8 transition-all duration-700 ease-out grid justify-items-center pt-[140px] pb-[60px]">
                            <h1 class="lexend-bold text-[#706D54]/50 text-xl/[8px]">
                                NEWSPAPER
                            </h1>
                            <h1 class="lexend-bold text-[#A08963] text-[42px] mt-[10px] mb-[20px]" id="title"></h1>
                            <hr class="border-[#706D54] border-t-[4px] w-[240px] mb-[40px]">
                            <div class="grid grid-cols-3 justify-items-center gap-[40px] mb-[40px]" id="newspapers-facts"></div>
                            <div class="flex flex-col gap-[20px] mx-[140px] lexend-medium text-[#706D54] text-xl text-justify" id="content">
                                <p>
                                    Kopi adalah minuman paling populer di dunia setelah air putih. Lebih dari dua miliar cangkir kopi dikonsumsi setiap hari di seluruh dunia. Minuman ini berasal dari biji kopi yang pertama kali ditemukan di Ethiopia, dan sejak itu menyebar ke seluruh dunia sebagai bagian penting dari budaya dan gaya hidup.
                                </p>
                                <p>
                                    Kandungan kafein dalam kopi diketahui dapat meningkatkan konsentrasi, kewaspadaan, dan suasana hati. Bahkan, dalam dosis yang tepat, kopi dapat membantu meningkatkan performa fisik dan mental. Namun, konsumsi berlebihan juga dapat menyebabkan gangguan tidur atau jantung berdebar, sehingga penting untuk mengonsumsinya secara seimbang.
                                </p>
                                <p>
                                    Menariknya, kopi memiliki lebih dari 800 senyawa aroma berbeda, lebih banyak dibandingkan anggur. Ini membuat setiap jenis kopi memiliki rasa dan karakteristik yang unik, tergantung pada tempat tumbuh, proses pemanggangan, dan metode penyeduhan. Tak heran jika dunia kopi memiliki banyak pecinta dan para ahli rasa yang mendalami seni mencicipinya.
                                </p>
                            </div>
                        </div>
                        <div class="fade-in-section opacity-0 translate-y-8 transition-all duration-700 ease-out flex flex-col items-center bg-[#D9D9D9]/50 min-w-full min-h-screen pt-[40px] pb-[100px]">
                            <h1 class="lexend-bold text-4xl text-[#A08963] mb-[20px]">
                                MORE INFO
                            </h1>
                            <hr class="border-[#706D54] border-t-[4px] w-[240px] mb-[40px]">
                            <div class="w-full py-[4px] overflow-x-auto snap-x snap-mandatory no-scrollbar">
                                <div class="flex gap-[60px] w-max mx-[140px] min-h-max" id="more-info"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
            id="reviews-content"
            style="display: none;"
            >
                <div id="products">
                    <div class="min-h-max w-full mb-[140px]">
                        <div>
                            <img src="{{ asset('assets/images/ellipse_coklat.svg') }}" alt="ellipse" class="absolute top-0 w-full h-[240px] -z-10">
                            <img src="{{ asset('assets/images/ellipse_putih.svg') }}" alt="ellipse" class="absolute top-0 w-full h-[160px] -z-10">
                        </div>
                        <div class="fade-in-section opacity-0 translate-y-8 transition-all duration-700 ease-out grid justify-items-center mt-[140px]">
                            <h1 class="lexend-bold text-[#A08963] text-4xl mb-[32px]">
                                OUR MENU REVIEWS
                            </h1>
                            <div class="relative min-h-max min-w-max">
                                <div class="flex items-center rounded-4xl pl-3 outline-1 -outline-offset-1 outline-gray-300 bg-[#D9D9D9] focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#706D54] w-[600px] h-[40px] z-2 relative">
                                    <img src="{{ asset('assets/images/search.svg') }}" alt="search" class="h-[16px] w-[20px] mr-2">
                                    <input 
                                    class="rounded-r-4xl block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-[#706D54] font-medium placeholder:text-[#706D54]/50 placeholder:font-normal focus:outline-none sm:text-sm/6"
                                    type="text" 
                                    name="search" 
                                    id="search-form"
                                    placeholder="Search"
                                    >
                                </div>
                                <div
                                class="absolute top-[20px] left-0 w-full bg-white pt-[28px] pb-[8px] px-[24px] z-1 grid grid-cols-1"
                                id="suggestion"
                                style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25); display: none;"
                                >
                                    <h1 class="lexend-medium text-[#706D54] text-xs/[36px] capitalize cursor-pointer hover:bg-[#D9D9D9]/30 pl-3">
                                        Text1
                                    </h1>
                                    <hr class="min-w-full border-b-[1.5px] rounded-xl border-black/12">
                                    <h1 class="lexend-medium text-[#706D54]/45 text-xs/[36px] capitalize cursor-pointer hover:bg-[#D9D9D9]/30 pl-3">
                                        Text2
                                    </h1>
                                    <hr class="min-w-full border-b-[1.5px] rounded-xl border-black/12">
                                    <h1 class="lexend-medium text-[#706D54]/45 text-xs/[36px] capitalize cursor-pointer hover:bg-[#D9D9D9]/30 pl-3">
                                        Text3
                                    </h1>
                                </div>
                            </div>
                            <div class="mt-[26px] mb-[26px] bg-[#706D54] grid grid-cols-5 gap-[10px] h-[46px] w-[1000px] justify-items-center rounded-[16px] p-1">
                                <button
                                class="lexend-semibold text-md text-white h-full w-full rounded-[14px] cursor-pointer transition-color duration-300"
                                id="coffee-reviews"
                                >
                                    Coffee
                                </button>
                                <button
                                class="lexend-semibold text-md text-white h-full w-full rounded-[14px] cursor-pointer transition-color duration-300"
                                id="non-coffee-reviews"
                                >
                                    Non Coffee
                                </button>
                                <button
                                class="lexend-semibold text-md text-white h-full w-full rounded-[14px] cursor-pointer transition-color duration-300"
                                id="cake-reviews"
                                >
                                    Cake
                                </button>
                                <button
                                class="lexend-semibold text-md text-white h-full w-full rounded-[14px] cursor-pointer transition-color duration-300"
                                id="snack-reviews"
                                >
                                    Snack
                                </button>
                                <button
                                class="lexend-semibold text-md text-white h-full w-full rounded-[14px] cursor-pointer transition-color duration-300"
                                id="meal-reviews"
                                >
                                    Meal
                                </button>
                            </div>
                            <div class="">
                                <div class="grid grid-cols-3 justify-items-center gap-[20px] transition-all ease-out" id="coffee-product" style="display: none;"></div>
                                <div class="grid grid-cols-3 justify-items-center gap-[20px] transition-all ease-out" id="non-coffee-product" style="display: none;"></div>
                                <div class="grid grid-cols-3 justify-items-center gap-[20px] transition-all ease-out" id="cake-product" style="display: none;"></div>
                                <div class="grid grid-cols-3 justify-items-center gap-[20px] transition-all ease-out" id="snack-product" style="display: none;"></div>
                                <div class="grid grid-cols-3 justify-items-center gap-[20px] transition-all ease-out" id="meal-product" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="overall">
                    <div class="min-h-max w-full mb-[100px]">
                        <div>
                            <img src="{{ asset('assets/images/ellipse_coklat.svg') }}" alt="ellipse" class="absolute top-0 w-full h-[240px] -z-10">
                            <img src="{{ asset('assets/images/ellipse_putih.svg') }}" alt="ellipse" class="absolute top-0 w-full h-[160px] -z-10">
                        </div>
                        <div class="fade-in-section opacity-0 translate-y-8 transition-all duration-700 ease-out grid justify-items-center mt-[140px]">
                            <h1 class="lexend-bold text-[#A08963] text-4xl mb-[60px]">
                                CUSTOMER REVIEWS
                            </h1>
                            <div class="flex justify-center min-w-max px-[120px] gap-[20px] mb-[40px]">
                                <div class="min-w-[300px] min-h-[300px] rounded-[24px] bg-white flex flex-col justify-center items-center p-[20px]" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);">
                                    <div class="relative mb-[20px]">
                                        <img src="{{ asset('assets/images/big-star.svg') }}" alt="star" width="200">
                                        <h1 class="lexend-bold text-[#706D54] text-5xl absolute top-1/2 left-1/2 translate-[-50%]">
                                            4.7
                                        </h1>
                                    </div>
                                    <h1 class="lexend-semibold text-[#A08963] text-xl">
                                        Average Rating
                                    </h1>
                                    <h1 class="lexend-regular text-[#A08963]/75 text-xs">
                                        Based on 7273 ratings
                                    </h1>
                                </div>
                                <table class="min-w-max border-separate border-spacing-x-[40px]">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="grid grid-cols-6 px-[140px] w-full gap-[20px]" id="filter-star"></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div
            class="min-w-full min-h-[140px] bg-[#706D54] flex flex-col justify-center items-center"
            >
                <p
                class="lexend-bold text-[#DBDBDB] opacity-60 text-xl tracking-[.1em]"
                >get up close and personal</p>
                <p
                class="lexend-bold text-white text-[40px] tracking-[.1em]"
                >CONTACT US</p>
                <hr class="mt-[8px] border-y-[4px] border-[#DBDBDB] w-[150px]">
            </div>
            <div
            class="relative min-w-full min-h-[260px] bg-[#F0ECE6] grid grid-cols-2 gap-[200px]"
            >
                <div class="flex items-center justify-end">
                    <div>
                        <a href="https://www.instagram.com/binauf_coffee" target="_blank" rel="noopener noreferrer" class="lexend-bold text-center text-[#A08963] text-xl grid justify-items-center">
                            <img src="{{ asset('assets/images/ig.svg') }}" alt="instagram" class="h-[120px]">
                            <p class="lexend-semibold text-center text-[#CFCFCF] text-xl">
                                INSTAGRAM
                            </p>
                            @binauf_coffee
                        </a>
                    </div>
                </div>
                <div class="absolute left-1/2 top-1/2 translate-[-50%] bg-[#A08963] h-[160px] w-[4px]"></div>
                <div class="flex items-center justify-start">
                    <div>
                        <a href="https://wa.me/+6285800016076" target="_blank" rel="noopener noreferrer" class="lexend-bold text-center text-[#A08963] text-xl grid justify-items-center">
                            <img src="{{ asset('assets/images/wa.svg') }}" alt="whatsapp" class="h-[120px]">
                            <p class="lexend-semibold text-center text-[#CFCFCF] text-xl">
                                WHATSAPP
                            </p>
                            +62 858 0001 6076
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>