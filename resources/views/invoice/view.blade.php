<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
            {{ strtoupper($invoice->code) }}
        </title>

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

                let receivedStatus = { circle: "bg-[#D9D9D9]", button: "bg-[#706D54] text-white hover:bg-[#706D54]/80 hover:outline-2 hover:-outline-offset-2 hover:outline-[#706D54] active:bg-[#706D54]/70 cursor-pointer" };
                let paidStatus = { circle: "bg-[#D9D9D9]", button: "bg-[#706D54] text-white" };
                let servedStatus = { circle: "bg-[#D9D9D9]", button: "bg-[#706D54] text-white" };
                let deliveredStatus = { circle: "bg-[#D9D9D9]", button: "bg-[#706D54] text-white" };
                let doneStatus = { circle: "bg-[#D9D9D9]", button: "bg-[#706D54] text-white" };
                let progressBarWidth = "0px";

                const invoiceStatus = '{{ $invoice->status }}';

                if (invoiceStatus === 'received') {
                    receivedStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    progressBarWidth = `${600 / 4 * 0}px`;
                } else if (invoiceStatus === 'paid') {
                    receivedStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    paidStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    progressBarWidth = `${600 / 4 * 1}px`;
                } else if (invoiceStatus === 'served') {
                    receivedStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    paidStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    servedStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    progressBarWidth = `${600 / 4 * 2}px`;
                } else if (invoiceStatus === 'delivered') {
                    receivedStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    paidStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    servedStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    deliveredStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    progressBarWidth = `${600 / 4 * 3}px`;
                } else if (invoiceStatus === 'done') {
                    receivedStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    paidStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    servedStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    deliveredStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    doneStatus = { circle: "bg-[#706D54]", button: "outline-2 outline-[#706D54] bg-[#E4E4E4] text-[#706D54]" };
                    progressBarWidth = "100%";
                }

                $("#row").append(
                    `
                        <div class="relative flex justify-between items-center rounded-full w-[600px] h-[8px] bg-[#D9D9D9] mt-[40px]">
                            <div class="absolute rounded-full h-full bg-[#706D54]" style="width: ${progressBarWidth};"></div>
                            <div class="rounded-full h-[20px] w-[20px] ${receivedStatus.circle}"></div>
                            <div class="rounded-full h-[20px] w-[20px] ${paidStatus.circle}"></div>
                            <div class="rounded-full h-[20px] w-[20px] ${servedStatus.circle}"></div>
                            <div class="rounded-full h-[20px] w-[20px] ${deliveredStatus.circle}"></div>
                            <div class="rounded-full h-[20px] w-[20px] ${doneStatus.circle}"></div>
                        </div>
                        <div class="absolute top-[80px] min-w-full flex justify-between items-center">
                            <button class="lexend-bold min-w-[100px] max-w-[100px] py-[4px] rounded-full ${receivedStatus.button}" id="received-btn">Received</button>
                            <button class="lexend-bold min-w-[100px] max-w-[100px] py-[4px] rounded-full ${paidStatus.button}">Paid</button>
                            <button class="lexend-bold min-w-[100px] max-w-[100px] py-[4px] rounded-full ${servedStatus.button}">Served</button>
                            <button class="lexend-bold min-w-[100px] max-w-[100px] py-[4px] rounded-full ${deliveredStatus.button}">Delivered</button>
                            <button class="lexend-bold min-w-[100px] max-w-[100px] py-[4px] rounded-full ${doneStatus.button}">Done</button>
                        </div>
                    `
                );

                $(document).on("click", "#received-btn.cursor-pointer", async () => {
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        const response = await fetch("/invoices/{{ $invoice->code }}", {
                            method: "PUT",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken
                            }
                        });
                        const data = await response.json();

                        if (response.ok) {
                            window.location.replace(data.redirect);
                        } else {
                            alert("Gagal mengambil data invoice!");
                        }
                    } catch (err) {
                        alert("Gagal menghubungi server.");
                        console.error(err);
                    }
                })
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
                <div class="w-[80%] h-[500px] bg-white outline-2 outline-[#A08963] rounded-[24px] flex flex-col items-center relative">
                    <button class="absolute top-[16px] right-[16px] cursor-pointer" onclick="window.location.href = '/admin'">
                        <img src="{{ asset('assets/images/icon-x.svg') }}" alt="" width="20">
                    </button>
                    <h1 class="lexend-bold text-3xl text-[#706D54] capitalize mt-[24px]">
                        Order Details
                    </h1>
                    <div class="w-full py-[24px] overflow-x-auto snap-x snap-mandatory no-scrollbar">
                        <div class="flex gap-[20px] w-max mx-[50px]">
                            @foreach ($invoice->products as $products)
                                <div class="bg-white outline-1 outline-[#706D54] rounded-[12px] min-w-[320px] max-w-[320px] overflow-hidden min-h-[120px] flex justify-between items-center gap-[8px] p-[8px]">
                                    <div class="min-w-[100px] max-w-[100px] min-h-full max-h-full overflow-hidden flex justify-center items-center rounded-[8px]">
                                        <img src="{{ asset($products->image_path ?? '')}}" alt="{{ $products->name }}">
                                    </div>
                                    <div class="flex-1 flex flex-col justify-between overflow-hidden">
                                        <h1 class="lexend-bold text-[#A08963] capitalize text-2xl whitespace-nowrap truncate">
                                            {{ $products->name }}
                                        </h1>
                                        <div class="flex gap-[8px] items-center">
                                            <h1 class="lexend-bold text-[#706D54] text-2xl">
                                                {{ $products->pivot->quantity }}
                                            </h1>
                                            <h1 class="lexend-medium text-[#706D54] text-sm">
                                                items
                                            </h1>
                                        </div>
                                        <h1 class="lexend-medium text-[#A08963] text-md">
                                            Total :
                                        </h1>
                                        <h1 class="lexend-medium text-[#706D54] text-sm">
                                            Rp {{ number_format($products->pivot->cost, 0, ',', '.') }}
                                        </h1>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="min-w-full grid gap-[8px] px-[50px]">
                        <div class="flex gap-[8px]">
                            <h1 class="lexend-medium text-[#A08963] text-lg">
                                Additional Notes :
                            </h1>
                            <h1 class="lexend-medium text-[#A08963]/80 text-lg">
                                Jangan terlalu pahit ya kak, makasih sebelumnya
                            </h1>
                        </div>
                        <div class="flex gap-[8px]">
                            <h1 class="lexend-medium text-[#A08963] text-lg">
                                Delivery Option :
                            </h1>
                            <h1 class="lexend-medium text-[#A08963]/80 text-lg">
                                Take Away
                            </h1>
                        </div>
                        <div class="flex gap-[8px]">
                            <h1 class="lexend-medium text-[#A08963] text-lg">
                                Paymend Method :
                            </h1>
                            <h1 class="lexend-medium text-[#A08963]/80 text-lg">
                                Cash
                            </h1>
                        </div>
                    </div>
                    <div class="min-w-[688px] max-w-[688px] flex flex-1 justify-center relative" id="row"></div>
                </div>
            </div>
        </main>
    </body>
</html>