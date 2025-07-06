import './bootstrap';
$(document).ready(() => {
    let allProducts = [];
    let allShopReviews = [];

    $("body").hide().fadeIn(10, () => {
        $("#home-button").trigger("click")
        // $("#reviews-button").trigger("click")
        // $("#newspapers-button").trigger("click")
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
    function observeElement(element) {
        observer.observe(element);
    }
    document.querySelectorAll(".fade-in-section").forEach(observeElement);
    const mutationObserver = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            if(mutation.type === 'childList') {
                mutation.addedNodes.forEach(node => {
                    if(node.nodeType === 1) { 
                        if(node.matches('.fade-in-section')) {
                            observeElement(node);
                        }
                        node.querySelectorAll('.fade-in-section').forEach(observeElement);
                    }
                });
            }
        });
    });
    mutationObserver.observe(document.body, {
        childList: true,
        subtree: true
    });

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
                const regex = new RegExp(query, 'gi')
                const highlightedName = product.name.replace(regex, `<span class="text-[#706D54] font-bold">$&</span>`)
                const suggestionHTML = `
                    <h1 
                    class="lexend-medium text-[#706D54]/50 text-xs/[36px] capitalize cursor-pointer hover:bg-[#D9D9D9]/30 pl-3 relative"
                    data-id="${product.id}"
                    >
                        
                        ${highlightedName}
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
            window.location.href = `dashboard/products/${productId}`;
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

    $(document).on("click", "#reviews-button.lexend-extrabold", () => {
        $("#reviews-list-products").trigger("click")
    })
    $(document).on("click", "#reviews-list-products.text-\\[\\#4E4C3D\\]", () => {
        $("#coffee-reviews").trigger("click")
    });

    (async () => {
        try {
            const response = await fetch("/categories", { method: "GET" });
            const data = await response.json();

            if (response.ok) {
                data.categories.forEach(category => {
                    $("#menu").append(
                        `
                        <div class="snap-center w-[248px] h-[324px] bg-[#706D54] rounded-[24px] shadow-md grid justify-items-center pt-[16px]">
                            <div class="min-w-full justify-items-center px-[16px]">
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
                    $("#productContainer").append(
                        `
                            <div class="grid grid-cols-3 justify-items-center gap-[20px] transition-all ease-out" id="${category.name}-product" style="display: none;"></div>
                        `
                    )
                    $("#productButtonContainer").append(
                        `
                            <button
                            class="lexend-semibold text-md text-white h-full w-full rounded-[14px] cursor-pointer transition-color duration-300 capitalize"
                            id="${category.name}-reviews"
                            >
                                    ${category.name}
                            </button>
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

    $(document).on("click", "button[id$='-reviews']", function() {
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

    for(let i = 0; i < 40; i++) {
        $("#gallery").append(
            `
                <div class="flex justify-center items-center overflow-hidden snap-center w-[120px] h-[120px] rounded-[36px] outline-solid outline-[#706D54]">
                    <img src="assets/images/gallery${i%5}.jpg" alt="gallery${i}">
                </div>
            `
        )
    }

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
                            star += `<div class="min-w-[20px] max-w-[20px] flex justify-center items-center"><img src="assets/images/small-star.svg" alt="" class="w-[20px] h-[20px] mr-[4px]"></div>`
                        } else {
                            star += `<div class="min-w-[20px] max-w-[20px] flex justify-center items-center"><img src="assets/images/star-outlined.svg" alt="" class="w-[16px] h-[16px] mr-[4px]"></div>`
                        }
                    }

                    $(`#${product.category.name}-product`).append(
                        `
                            <div class="w-[340px] h-[172px] rounded-[8px] outline-2 outline-[#D9D9D9] flex justify-center items-center p-[14px] gap-[14px] cursor-pointer" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);" id="product=${product.id}">
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
                                    <div class="flex items-end justify-between flex-1">
                                        <div class="flex items-center">${star}</div>
                                        <h1 class="lexend-medium text-3xl/[20px] text-[#706D54] ml-[12px]">
                                            ${rateCount}
                                        </h1>
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

    $(document).on("click", "div[id^='product=']", async function() {
        const productId = $(this).attr("id").split("product=")[1];
        window.location.href = `/dashboard/products/${productId}`;
    })

    const buttonName = ["All",5,4,3,2,1]
    for(let i = 0; i < 6; i++) {
        let buttonContent = buttonName[i]
        if(i != 0) buttonContent += `<img src="assets/images/small-star.svg" alt="star" width="20">`
        $("#filter-star").append(
            `
                <button
                class="lexend-bold text-lg rounded-[16px] outline-2 outline-[#706D54] bg-white text-[#A08963] flex justify-center items-center gap-[4px] min-w-max h-[32px] cursor-pointer hover:bg-gray-200/75"
                id="star-${buttonName[i]}"
                >
                    ${buttonContent}
                </button>
            `
        )
    }
    (async () => {
        try {
            const response = await fetch("/shop-reviews", { method: "GET" });
            const data = await response.json();
                
            if (response.ok) {
                allShopReviews = data.shop_reviews;
                $("#ratingCount").text(`Based on ${allShopReviews.length} Ratings`)
                $("#ratingAvg").text(avg(allShopReviews) ?? 0)

                const value = [0, 0, 0, 0, 0];
                allShopReviews.forEach(review => {
                    const rate = review?.rate ?? 0;
                    if(rate >= 1 && rate <= 5) {
                        value[rate-1]++;
                    }
                });

                for(let i = 4; i >= 0; i--) {
                    let star = ""
                    for(let j = 0; j <= i; j++) {
                        star += `<img src="assets/images/small-star.svg" alt="star" width="28">`
                    }

                    const width = value[i]/allShopReviews.length*100;

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
            } else {
                alert("Gagal mengambil data review toko!");
            }
        } catch (err) {
            alert("Gagal menghubungi server.");
            console.error(err);
        }
    })();
    function shopReview(review, bgColor) {
        let star = ""
        for(let j = 0; j < 5; j++) {
            if(j < (review.rate%6)) {
                star += `<div class="min-w-[20px] max-w-[20px] flex justify-center items-center"><img src="assets/images/small-star.svg" alt="" class="w-[20px] h-[20px] mr-[4px]"></div>`
            } else {
                star += `<div class="min-w-[20px] max-w-[20px] flex justify-center items-center"><img src="assets/images/star-outlined.svg" alt="" class="w-[16px] h-[16px] mr-[4px]"></div>`
            }
        }
        return `
            <div class="${bgColor} w-full h-[320px] flex justify-center pt-[32px] pb-[24px]">
                <div class="fade-in-section opacity-0 translate-y-8 transition-all duration-700 ease-out flex justify-center items-start gap-[20px]">
                    <div class="flex justify-center items-center overflow-hidden w-[80px] h-[80px] rounded-[16px] outline-1 outline-[#706D54]">
                        <img src="${review.user.image_path ?? 'assets/images/blank-profile.png'}" alt="${review.user.name}-profile">
                    </div>
                    <div class="w-[800px] h-full grid place-content-between">
                        <div class="flex flex-col gap-[4px] max-h-[214px]">
                            <h1 class="lexend-semibold text-[#706D54] text-[24px] capitalize">
                                ${review.user.name}
                            </h1>
                            <div class="flex items-center">${star}</div>
                            <h1 class="lexend-regular text-[#706D54]/75 text-[12px]">
                                ${review.date}
                            </h1>
                            <p class="lexend-regular text-[#706D54] text-[16px]">
                                ${review.review ?? "-"} 
                            </p>
                        </div>
                        <div class="flex items-center rounded-lg pl-3 outline-1 -outline-offset-1 outline-[#706D54] bg-white focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-[#706D54] w-[200px] h-[40px] z-2">
                            <input 
                            class="rounded-r-4xl block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-[#706D54] font-medium placeholder:text-[#706D54]/50 placeholder:font-normal focus:outline-none sm:text-sm/6"
                            type="text" 
                            name="reply"
                            placeholder="Reply..."
                            >
                        </div>
                    </div>
                </div>
            </div>
        `
    }
    $(document).on("click", "button[id^='star-']", function() {
        const reviewShowed = $(this).attr("id").split("star-")[1]
        let content = "";
        let order = 0;
        allShopReviews.forEach(review => {
            const bgColor = ((order%2) === 0) ? "bg-[#D9D9D980]" : "bg-white"
            if(reviewShowed === "All") {
                content += shopReview(review, bgColor)
                order++
            } else {
                if(reviewShowed == review.rate) {
                    content += shopReview(review, bgColor)
                    order++
                }
            }
        })
        $("#shop-reviews").empty().append(content)
        $("button[id^='star-']")
            .removeClass("bg-[#706D54] text-white")
            .addClass("bg-white text-[#A08963] hover:bg-gray-200/75")
        $(this)
            .removeClass("bg-white text-[#A08963] hover:bg-gray-200/75")
            .addClass("bg-[#706D54] text-white")
    })
    $(document).on("click", "#reviews-list-overall", () => {
        $("#star-All").trigger("click")
    })

    for(let i = 0; i < 3; i++) {
        $("#newspapers-facts").append(
            `
                <div class="w-[300px] h-[180px] rounded-[16px] overflow-hidden relative">
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
    ["#newspapers", "#more-info"].forEach((element, index) => {
        for(let i = 0; i < 6; i++) {
            const color = containerColor[index]
            const content = newsContent[i%3]
            $(element).append(
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
    })

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
    })
})

function avg(reviews) {
  if (!Array.isArray(reviews) || reviews.length === 0) return 0;
  const total = reviews.reduce((sum, item) => sum + (item?.rate ?? 0), 0);
  return total / reviews.length;
}