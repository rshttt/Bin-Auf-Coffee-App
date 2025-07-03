$(document).ready(() => {
    $("#toggle-password").click(function() {
        const newType = ($("#password").attr("type") === "password") ? "text" : "password"
        const newIcon = ($(this).children("img").attr("src") === "assets/images/password-hide.svg") ? "assets/images/password-show.svg" : "assets/images/password-hide.svg"
        $("#password").attr("type", newType)
        $(this).children("img").attr("src", newIcon)
    })
})