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

$("#copyButton").on("click", function () {
    $('[data-bs-toggle="tooltip"]').tooltip("hide");
    var input = $("#textResult").val();
    if (input.trim() != "") {
        navigator.clipboard
            .writeText(input)
            .then(() => {
                Toast.fire({
                    icon: "success",
                    title: "Teks aksara berhasil dicopy!",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    toast: true,
                    position: "top-end",
                });
            })
            .catch((err) => {
                console.error("Gagal menyalin teks: ", err);
            });
    }
});

$("#textBiasa").on("input", function () {
    $(".copyBtn").removeClass("d-none");
    if ($(this).val().trim() == "") {
        $(".copyBtn").addClass("d-none", true);
    }
    $("#textResult").val(LatinKeAksara($(this).val()));
});
