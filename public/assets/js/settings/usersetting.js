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
// settings
// Tambahkan event ketika pengguna memilih file
$("#upload").on("change", function () {
    var file = $(this)[0].files[0]; // Ambil file yang dipilih

    // Periksa apakah file adalah gambar
    if (file && file.type.startsWith("image")) {
        var reader = new FileReader(); // Membuat objek FileReader

        // Saat file berhasil dibaca
        reader.onload = function (e) {
            $("#uploadedPhotoProfil")[0].src = e.target.result; // Set src gambar pratinjau
            $("#uploadedPhotoProfil").css("display", "block"); // Tampilkan gambar pratinjau
        };

        // Baca file sebagai URL data (base64)
        reader.readAsDataURL(file);
    } else {
        Toast.fire({
            icon: "warning",
            title: "Yang diupload harus image!",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            toast: true,
            position: "top-end",
        });
    }
});

$(".buttonEditEmailUser").on("click", function () {
    $("#formModalUsersEditEmail").modal("show");
});

$(".btnCancelVeify").on("click", function () {
    $("#passwordVerify").removeClass("is-invalid");
    $("#passwordVerify").val("");
    $("#passwordVerify").removeClass("invalid-feedback");
});

$(".fotoProfile").on("click", function () {
    const urlImg = $(this).data("url-img");
    $(".urlShowProfilImg").attr("src", urlImg);
    $("#gambarModal").modal("show");
});
