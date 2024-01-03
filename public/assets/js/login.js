const Toast = Swal.mixin({
    iconColor: "white",
    customClass: {
        popup: "colored-toast",
    },
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});
const flashMessage = $(".flash-message").data("flash-message");
const flashMessageRegister = $(".flash-message-register").data("flash-message");

function setMessage(message, status) {
    Toast.fire({
        icon: status,
        title: message,
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        toast: true,
        width: "auto",
        position: "top-end",
    });
}
if (flashMessage) {
    setMessage(flashMessage, "error");
}
if (flashMessageRegister) {
    setMessage(flashMessageRegister, "success");
}
$("#username").on("input", function () {
    let username = $(this).val();
    $(this).val(
        username
            .replace(/\s/g, "")
            .replace(/[^a-zA-Z0-9]/g, "")
            .toLowerCase()
    );
});
$("#password").on("input", function () {
    let password = $(this).val();
    $(this).val(password.trim());
});

$("#username, #password").on("keydown", function () {
    if ($("#username").val() == "") {
        if (event.which === 13) {
            event.preventDefault();
        }
    } else {
        if ($("#password").val() == "") {
            if (event.which === 13) {
                event.preventDefault();
            }
        }
    }
});
$("#username, #password").on("keyup", function () {
    if ($("#username").val() !== "") {
        if ($("#password").val() !== "") {
            $(".tombolLogin").removeClass("disabled");
            $(".divBtn").removeAttr("style");
        } else {
            $(".tombolLogin").addClass("disabled", true);
            $(".divBtn").attr("style", "cursor: not-allowed;");
        }
    } else {
        $(".tombolLogin").addClass("disabled", true);
        $(".divBtn").attr("style", "cursor: not-allowed;");
    }
});
