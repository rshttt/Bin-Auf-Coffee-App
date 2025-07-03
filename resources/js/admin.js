// import './bootstrap';
$(document).ready(() => {
    let allProducts = [];

    $("body").hide().fadeIn(300, () => {
        $("#home-button").trigger("click")
        // $("#reviews-button").trigger("click")
        // $("#newspapers-button").trigger("click")
        // $("#customers-button").trigger("click")
    })

    const observer = new IntersectionObserver(params => {
        params.forEach(element => {
            if(element.isIntersecting) {
                element.target.classList.add('opacity-100', 'translate-y-0')
                element.target.classList.remove('opacity-0', 'translate-y-8')
            } else {
                element.target.classList.add('opacity-0', 'translate-y-8')
                element.target.classList.remove('opacity-100', 'translate-y-0')
            }
        })
    }, {
        threshold: 0.1
    }) 
    document.querySelectorAll(".fade-in-section").forEach(elements => {
        observer.observe(elements)
    })

    $("button[id$='-button']").click(function() {
        const buttonName = $(this).attr("id").split("-button")[0]
        if(buttonName === "reviews") $("#search-form").val("")
        if(buttonName === "newspapers") {
            $("#show-news").hide()
            $("#opening").show()
        }
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth'
        })
        $(".lexend-extrabold > hr")
            .css("visibility", "hidden")
            .removeClass("transition duration-500")
        $(".lexend-extrabold")
            .removeClass("lexend-extrabold")
            .addClass("lexend-regular")
        $(this)
            .children("hr")
            .css("visibility", "visible")
            .removeClass("opacity-25 border-y-[1.5px] w-[50%]")
            .addClass("border-y-[2px] transition duration-500")
        $(this)
            .removeClass("lexend-regular")
            .addClass("lexend-extrabold")
        $("button[id^='reviews-list-']")
            .removeClass("bg-[#CFCFCF] text-[#4E4C3D]")
            .addClass("hover:bg-[#CFCFCF]/75 hover:text-[#4E4C3D]/50 text-[#A08963]")
        $("div[id$='-content']").hide()
        $(`#${buttonName}-content`).show()
    }).hover(
        function() {
            if(!$(this).hasClass("lexend-extrabold")) {
                $(this)
                    .children("hr")
                    .css("visibility", "visible")
                    .removeClass("border-y-[2px]")
                    .addClass("opacity-25 border-y-[1.5px] w-[50%]")
            }
        },
        function() {
            if(!$(this).hasClass("lexend-extrabold")) {
                $(this)
                    .children("hr")
                    .css("visibility", "hidden")
                    .addClass("border-y-[2px]")
                    .removeClass("opacity-25 border-y-[1.5px] w-[50%]")
            }
        }
    )

    $("#toggle").hover(
        () => {
            $("#reviews-list").stop(true, false).slideDown();
        },
        () => {
            $("#reviews-list").stop(true, false).slideUp();
        }
    )

    $("#search-form").on('input', function() {
        const query = $(this).val().toLowerCase().trim();
        const suggestionBox = $("#suggestion");
        
        suggestionBox.empty();

        if(query.length === 0) {
            suggestionBox.slideUp(200);
            return;
        }

        const filteredProducts = allProducts.filter(product =>
            product.name.toLowerCase().includes(query)
        );

        if(filteredProducts.length > 0) {
            filteredProducts.forEach(product => {
                const suggestionHTML = `
                    <h1 
                        class="lexend-medium text-[#706D54] text-xs/[36px] capitalize cursor-pointer hover:bg-[#D9D9D9]/30 pl-3"
                        data-id="${product.id}"
                    >
                        ${product.name}
                    </h1>
                    <hr class="min-w-full border-b-[1.5px] rounded-xl border-black/12">
                `;
                suggestionBox.append(suggestionHTML);
            });
            suggestionBox.children('hr:last-child').remove();
        } else {
            const noResultHTML = `<h1 class="lexend-medium text-[#706D54]/45 text-xs/[36px] pl-3">Produk tidak ditemukan</h1>`;
            suggestionBox.append(noResultHTML);
        }

        suggestionBox.slideDown(200);
    });

    $("#search-form").focus(() => {
        if ($("#search-form").val().trim().length > 0) {
            $("#suggestion").slideDown(300);
        }
    });

    $("#search-form").blur(() => {
        setTimeout(() => {
            $("#suggestion").slideUp();
        }, 150);
    });

    $("#suggestion").on('click', 'h1', function() {
        const selectedText = $(this).text().trim();
        const productId = $(this).data('id');
        
        $("#search-form").val(selectedText);

        if(productId) {
            window.location.href = `/products/${productId}/edit`;
        }
    });

    $("button[id^='reviews-list-']").click(function() {
        const buttonName = $(this).attr("id").split("reviews-list-")[1]
        if(buttonName === "products") $("#search-form").val("")
        $(".lexend-extrabold > hr")
            .css("visibility", "hidden")
            .removeClass("transition duration-500")
        $(".lexend-extrabold")
            .removeClass("lexend-extrabold")
            .addClass("lexend-regular")
        $("#reviews-button > hr")
            .css("visibility", "visible")
            .removeClass("opacity-25 border-y-[1.5px] w-[50%]")
            .addClass("border-y-[2px] transition duration-500")
        $("#reviews-button")
            .removeClass("lexend-regular")
            .addClass("lexend-extrabold")
        $("button[id^='reviews-list-']")
            .removeClass("bg-[#CFCFCF] text-[#4E4C3D]")
            .addClass("hover:bg-[#CFCFCF]/75 hover:text-[#4E4C3D]/50 text-[#A08963]")
        $(this)
            .removeClass("hover:bg-[#CFCFCF]/75 hover:text-[#4E4C3D]/50 text-[#A08963]")
            .addClass("bg-[#CFCFCF] text-[#4E4C3D]")
        $("div[id$='-content']").hide()
        $("#reviews-content").show()
        $("#reviews-content > div").hide()
        $(`#${buttonName}`).show()
    })

    $(document).on("click", "#reviews-button.lexend-extrabold", function() {
        $("#reviews-list-products").trigger("click")
        // $("#reviews-list-overall").trigger("click")
    })
    $(document).on("click", "#reviews-list-products.text-\\[\\#4E4C3D\\]", function() {
        $("#coffee-reviews").trigger("click")
    })

    $("button[id$='-reviews']").click(function() {
        const buttonName = $(this).attr("id").split("-reviews")[0]
        $("button[id$='-reviews'].bg-\\[\\#C9B194\\]").removeClass("bg-[#C9B194]")
        $(this)
            .removeClass("bg-[#C9B194]/25")
            .addClass("bg-[#C9B194]")
        $(`div[id$='-product']:not([id='${buttonName}-product'])`).hide()
        $(`#${buttonName}-product`).fadeIn(300)
    }).hover(
        function() {
            if(!$(this).hasClass("bg-[#C9B194]")) {
                $(this).addClass("bg-[#C9B194]/25")
            }
        }, 
        function() {
            if(!$(this).hasClass("bg-[#C9B194]")) {
                $(this).removeClass("bg-[#C9B194]/25")
            }
        }
    );

    (async () => {
        try {
            const response = await fetch("/categories", { method: "GET" });
            const data = await response.json();

            if (response.ok) {
                data.categories.forEach(category => {
                    $("#menu").append(
                        `
                        <div class="snap-center w-[248px] h-[324px] bg-[#706D54] rounded-[24px] shadow-md grid justify-items-center pt-[16px] cursor-pointer hover:opacity-90 hover:outline-black hover:outline-2 active:outline-4 active:opacity-75 px-[16px]" id="category=${category.id}">
                            <div class="min-w-full justify-items-center">
                                <div class="rounded-[16px] mb-[16px] h-[140px] max-h-[140px] bg-white min-w-full overflow-hidden flex justify-center items-center">
                                    <img src="${category.image_path}" alt="${category.name}" class="w-full h-full object-fill">
                                </div>
                                <h1 class="lexend-bold text-xl text-white text-center mb-[4px] capitalize">
                                    ${category.name}
                                </h1>
                                <p class="lexend-regular text-sm text-white text-center">
                                    ${category.description}
                                </p>
                            </div>
                        </div>
                        `
                    )
                })
                $("#menu").append(
                    `
                        <div class="snap-center w-[248px] h-[324px] bg-[#706D54] rounded-[24px] shadow-md flex justify-center items-center cursor-pointer hover:opacity-90 hover:outline-black hover:outline-2 active:outline-4 active:opacity-75" id="createCategory">
                            <img src="assets/images/icon-plus.svg" alt="plus" class="h-[60px]">
                        </div>
                    `
                )
                
            } else {
                alert("Gagal mengambil data kategori!");
            }
        } catch (err) {
            alert("Gagal menghubungi server.");
            console.error(err);
        }
    })();
    $(document).on("click", "div[id^='category=']", async function() {
        const categoryId = $(this).attr("id").split("category=")[1];
        window.location.href = `/categories/${categoryId}/edit`;
    })
    $(document).on("click", "#createCategory", async function() {
        window.location.href = `/categories/create`;
    })

    for(let i = 0; i < 40; i++) {
        $("#gallery").append(
            `
                <div class="flex justify-center items-center overflow-hidden snap-center w-[120px] h-[120px] rounded-[36px] outline-solid outline-[#706D54] cursor-pointer hover:outline-3 hover:outline-black active:outline-4">
                    <img src="assets/images/gallery${i%5}.jpg" alt="gallery${i}">
                </div>
            `
        )
    }
    $("#gallery").append(
        `
            <div class="flex justify-center items-center  bg-[#706D54] snap-center w-[120px] h-[120px] rounded-[36px] outline-solid outline-[#706D54] cursor-pointer hover:outline-3 hover:outline-black hover:opacity-90 active:outline-4 active:opacity-75">
                <img src="assets/images/icon-plus.svg" alt="plus" class"h-[20px]>
            </div>
        `
    );

    (async() => {
        try {
            const response = await fetch("/products", { method: "GET" });
            const data = await response.json();

            if (response.ok) {
                allProducts = data.products; 
                allProducts.forEach(product => {
                    let star = ""
                    const rateCount = avg(product.reviews) ?? 0;
                    
                    for(let j = 0; j < 5; j++) {
                        if(j < (rateCount%6)) {
                            star += `<img src="assets/images/small-star.svg" alt="" class="w-[20px] h-[20px] mr-[4px]">`
                        } else {
                            star += `<img src="assets/images/star-outlined.png" alt="" class="w-[16px] h-[16px] mr-[4px]" >`
                        }
                    }

                    $(`#${product.category.name}-product`).append(
                        `
                            <div class="w-[340px] h-[172px] rounded-[8px] outline-2 outline-[#D9D9D9] flex justify-center items-center p-[14px] gap-[14px]" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);">
                                <div class="w-full h-full rounded-[14px] flex justify-center items-center overflow-hidden" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);">
                                    <img src="${product.image_path}" alt="${product.name}_image">
                                </div>
                                <div class="min-w-[180px] h-full flex flex-col pb-[4px]">
                                    <h1 class="lexend-medium capitalize text-xs text-[#A08963]/60">
                                        ${product.category.name}
                                    </h1>
                                    <h1 class="lexend-bold capitalize text-2xl text-[#706D54] mb-[8px] truncate max-w-full">
                                        ${product.name}
                                    </h1>
                                    <h1 class="lexend-medium capitalize text-xs/[12px] text-[#706D54]">
                                        number of reviewers:
                                    </h1>
                                    <div class="flex items-center">
                                        <h1 class="lexend-bold capitalize text-[40px]/[42px] text-[#A08963] mr-[8px]">
                                            ${product.stock}
                                        </h1>
                                        <h1 class="lexend-medium text-sm text-[#A08963]">
                                            items
                                        </h1>
                                    </div>
                                    <div class="flex items-end justify-start">
                                        <button class="lexend-medium text-[#A08963] text-sm hover:outline-1 hover:outline-[#A08963] bg-[#D9D9D9] flex justify-center items-center min-h-[32px] min-w-[100px] cursor-pointer"  id="product=${product.id}">
                                            <img src="/assets/images/icon-edit.svg" alt="" width="20">
                                            Edit Menu
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `
                    )
                })
            } else {
                alert("Gagal mengambil data kategori!");
            }
        } catch (err) {
            alert("Gagal menghubungi server.");
            console.error(err);
        }
    })();
    $(document).on("click", "button[id^='product=']", async function() {
        const productId = $(this).attr("id").split("product=")[1];
        window.location.href = `/products/${productId}/edit`;
    })

    const value = [1000,2000,3000,4000,5000]
    for(let i = (value.length-1); i >= 0; i--) {
        let star = ""
        for(let j = 0; j <= i; j++) {
            star += `<img src="assets/images/small-star.svg" alt="star" width="28">`
        }
        const width = value[i]/value.reduce((sum, current) => sum + current, 0)*100

        $("table > tbody").append(
            `
                <tr>
                    <td>
                        <div class="flex justify-end items-center">
                            ${star}
                        </div>
                    </td>
                    <td>
                        <div class="flex justify-end items-center">
                            <div class="min-w-[300px] h-[20px] outline-2 outline-[#E6D4A6] bg-white rounded-[12px] overflow-hidden">
                                <div class="min-h-full w-[${width}%] bg-[#E6D4A6] rounded-r-[12px]"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="flex justify-center items-center">
                            <h1 class="lexend-semibold text-[#A08963] text-xl">
                                ${value[i]}
                            </h1>
                        </div>
                    </td>
                </tr>
            `
        )
    }

    const buttonName = ["All",5,4,3,2,1]
    for(let i = 0; i < buttonName.length; i++) {
        let buttonContent = buttonName[i]
        if(i != 0) buttonContent += `<img src="assets/images/small-star.svg" alt="star" width="20">`
        $("#filter-star").append(
            `
                <button
                class="lexend-bold text-lg rounded-[16px] outline-2 outline-[#706D54] bg-white text-[#A08963] flex justify-center items-center gap-[4px] min-w-max h-[32px] cursor-pointer hover:bg-gray-200/75 active:bg-[#706D54]/25 active:text-[#A08963] focus:bg-[#706D54] focus:text-white"
                id="star-${buttonName[i]}"
                >
                    ${buttonContent}
                </button>
            `
        )
    }

    for(let i = 0; i < 3; i++) {
        $("#newspapers-facts").append(
            `
                <div class="w-[300px] h-[180px] rounded-[16px] overflow-hidden relative cursor-pointer hover:outline-3 hover:outline-black hover:opacity-90 active:outline-4 active:opacity-75">
                    <img src="assets/images/facts-${i}.png" alt="facts-${i}" class="absolute top-1/2 left-1/2 translate-[-50%]">
                </div>
            `
        )
    }

    const newsContent = [
        ["assets/images/news-0.png", "Fakta Menarik Tentang Kopi!"],
        ["assets/images/news-1.png", "Cerita Mingguan Pelanggan"],
        ["assets/images/news-2.png", "Rekomendasi Playlist ala Bin Auf Coffee"]
    ]
    const containerColor = [
        ["[#E6D4A6]", "[#D9D9D9]/50"],
        ["[#706D54]", "[#C9B194]/50"]
    ];
    for(let i = 0; i < 6; i++) {
        const color = containerColor[1]
        const content = newsContent[i%3]
        $("#more-info").append(
            `
                <div class="h-[380px] w-[420px] relative">
                    <div class="bg-${color[0]} w-[220px] h-[280px] rounded-[12px] absolute top-[20px] left-[160px] -z-1 rotate-12"></div>
                    <div class="bg-${color[1]} w-[220px] h-[280px] rounded-[12px] absolute top-[80px] left-0 -z-1 -rotate-6"></div>
                    <div class="mt-[40px] ml-[80px] bg-white w-[220px] h-[280px] rounded-[12px] outline-2 outline-[#CFCFCF] grid grid-cols-1 content-between p-[14px]">
                        <div class="min-w-full">
                            <img src="${content[0]}" alt="news" class="w-full h-[180px]">
                        </div>
                        <h1 class="lexend-bold text-[#706D54] text-base pl-[4px] pr-[10px]">
                            ${content[1]}
                        </h1>
                        <h2 class="news-${i} lexend-bold text-[#706D54]/50 text-[10px] pl-[4px] pr-[10px] cursor-pointer">
                            Informasi selengkapnya...
                        </h2>
                    </div>
                </div>
            `
        )
    }
    for(let i = 0; i < 6; i++) {
        const color = containerColor[0]
        const content = newsContent[i%3]
        $("#newspapers").append(
            `
                <div class="h-[380px] w-[420px] relative">
                    <div class="bg-${color[0]} w-[220px] h-[280px] rounded-[12px] absolute top-[20px] left-[160px] -z-1 rotate-12"></div>
                    <div class="bg-${color[1]} w-[220px] h-[280px] rounded-[12px] absolute top-[80px] left-0 -z-1 -rotate-6"></div>
                    <div class="mt-[40px] ml-[80px] bg-white w-[220px] h-[280px] rounded-[12px] outline-2 outline-[#CFCFCF] grid grid-cols-1 content-between p-[14px] cursor-pointer hover:bg-gray-100 hover:outline-black active:outline-4 active:bg-gray-200">
                        <div class="min-w-full">
                            <img src="${content[0]}" alt="news" class="w-full h-[180px]">
                        </div>
                        <h1 class="lexend-bold text-[#706D54] text-base pl-[4px] pr-[10px]">
                            ${content[1]}
                        </h1>
                        <h2 class="news-${i} lexend-bold text-[#706D54]/50 text-[10px] pl-[4px] pr-[10px] cursor-pointer">
                            Informasi selengkapnya...
                        </h2>
                    </div>
                </div>
            `
        )
    }
    $("#newspapers").append(
        `
            <div class="h-[380px] w-[420px] relative">
                <div class="bg-[#E6D4A6] w-[220px] h-[280px] rounded-[12px] absolute top-[20px] left-[160px] -z-1 rotate-12"></div>
                <div class="bg-[#D9D9D9]/50 w-[220px] h-[280px] rounded-[12px] absolute top-[80px] left-0 -z-1 -rotate-6"></div>
                <div class="mt-[40px] ml-[80px] bg-white w-[220px] h-[280px] rounded-[12px] outline-2 outline-[#CFCFCF] flex justify-center items-center cursor-pointer hover:outline-2 hover:outline-[#706D54] hover:bg-gray-100 active:bg-gray-200 active:outline-4">
                    <img src="assets/images/icon-plus.svg" alt="plus" class="bg-black rounded-full">
                </div>
            </div>
        `
    )
    $(document).on("click", "h2[class^='news-']", function() {
        const newsId = $(this)
            .attr("class")
            .split(" ")
            .find(cls => cls.startsWith("news-"))
            .split("news-")[1]
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth'
        })
        $("#opening").hide()
        if($(this).closest("#more-info").length > 0) $("#show-news").fadeOut(200)
        $("#title").text(newsContent[newsId%3][1])
        $("#show-news").fadeIn(300)
    });

    (async () => {
        try {
            const response = await fetch("/invoices", { method: "GET" });
            const data = await response.json();

            if (response.ok) {
                data.invoice.forEach(invoice => {
                    let receivedStatus = { circle: "bg-[#D9D9D9]", button: "invisible" };
                    let paidStatus = { circle: "bg-[#D9D9D9]", button: "invisible" };
                    let servedStatus = { circle: "bg-[#D9D9D9]", button: "invisible" };
                    let deliveredStatus = { circle: "bg-[#D9D9D9]", button: "invisible" };
                    let doneStatus = { circle: "bg-[#D9D9D9]", button: "invisible" };
                    let progressBarWidth = "0px";

                    if (invoice.status === 'received') {
                        receivedStatus = { circle: "bg-[#C9B194]", button: "" };
                        progressBarWidth = `${600 / 4 * 0}px`;
                    } else if (invoice.status === 'paid') {
                        receivedStatus = { circle: "bg-[#C9B194]", button: "" };
                        paidStatus = { circle: "bg-[#C9B194]", button: "" };
                        progressBarWidth = `${600 / 4 * 1}px`;
                    } else if (invoice.status === 'served') {
                        receivedStatus = { circle: "bg-[#C9B194]", button: "" };
                        paidStatus = { circle: "bg-[#C9B194]", button: "" };
                        servedStatus = { circle: "bg-[#C9B194]", button: "" };
                        progressBarWidth = `${600 / 4 * 2}px`;
                    } else if (invoice.status === 'delivered') {
                        receivedStatus = { circle: "bg-[#C9B194]", button: "" };
                        paidStatus = { circle: "bg-[#C9B194]", button: "" };
                        servedStatus = { circle: "bg-[#C9B194]", button: "" };
                        deliveredStatus = { circle: "bg-[#C9B194]", button: "" };
                        progressBarWidth = `${600 / 4 * 3}px`;
                    } else if (invoice.status === 'done') {
                        receivedStatus = { circle: "bg-[#C9B194]", button: "" };
                        paidStatus = { circle: "bg-[#C9B194]", button: "" };
                        servedStatus = { circle: "bg-[#C9B194]", button: "" };
                        deliveredStatus = { circle: "bg-[#C9B194]", button: "" };
                        doneStatus = { circle: "bg-[#C9B194]", button: "" };
                        progressBarWidth = "100%";
                    }
                
                    $("#order-list").append(
                        `
                        <div class="outline-3 outline-[#878787]/35 rounded-[16px] min-w-full min-h-[180px] cursor-pointer bg-white hover:outline-[#706D54] active:bg-gray-100 p-[32px] flex justify-between items-center" id="invoice=${invoice.code}">
                            <h1 class="lexend-bold text-[#A08963] text-xl uppercase self-start">
                                invoice #${invoice.code}
                            </h1>
                            <div class="relative flex justify-center min-w-[688px]">
                                <div class="relative flex justify-between items-center rounded-full w-[600px] h-[8px] bg-[#D9D9D9]">

                                    <div class="absolute rounded-full h-full bg-[#C9B194]" style="width: ${progressBarWidth};"></div>

                                    <div class="rounded-full h-[20px] w-[20px] ${receivedStatus.circle}" id="received-${invoice.code}"></div>
                                    <div class="rounded-full h-[20px] w-[20px] ${paidStatus.circle}" id="paid-${invoice.code}"></div>
                                    <div class="rounded-full h-[20px] w-[20px] ${servedStatus.circle}" id="served-${invoice.code}"></div>
                                    <div class="rounded-full h-[20px] w-[20px] ${deliveredStatus.circle}" id="delivered-${invoice.code}"></div>
                                    <div class="rounded-full h-[20px] w-[20px] ${doneStatus.circle}" id="done-${invoice.code}"></div>
                                </div>
                                <div class="absolute top-[40px] min-w-full flex justify-between items-center">
                                    <button class="lexend-bold text-white bg-[#C9B194] min-w-[100px] max-w-[100px] py-[4px] rounded-full ${receivedStatus.button}">Received</button>
                                    <button class="lexend-bold text-white bg-[#C9B194] min-w-[100px] max-w-[100px] py-[4px] rounded-full ${paidStatus.button}">Paid</button>
                                    <button class="lexend-bold text-white bg-[#C9B194] min-w-[100px] max-w-[100px] py-[4px] rounded-full ${servedStatus.button}">Served</button>
                                    <button class="lexend-bold text-white bg-[#C9B194] min-w-[100px] max-w-[100px] py-[4px] rounded-full ${deliveredStatus.button}">Delivered</button>
                                    <button class="lexend-bold text-white bg-[#C9B194] min-w-[100px] max-w-[100px] py-[4px] rounded-full ${doneStatus.button}">Done</button>
                                </div>
                            </div>
                        </div>
                        `
                    );
                });
            } else {
                alert("Gagal mengambil data invoice!");
            }
        } catch (err) {
            alert("Gagal menghubungi server.");
            console.error(err);
        }
    })();
    $(document).on("click", "div[id^='invoice=']", async function() {
        const invoiceCode = $(this).attr("id").split("invoice=")[1];
        window.location.href = `/invoices/${invoiceCode}/view`;
    })
})

function avg(reviews) {
  if (!Array.isArray(reviews) || reviews.length === 0) return 0;
  const total = reviews.reduce((sum, item) => sum + (item?.rate ?? 0), 0);
  return total / reviews.length;
}