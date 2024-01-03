$(".cancelModalAddUser, .cancelModalEditUser").on("click", function () {
    $(".modalAdminAddPengguna, .modalAdminEditPengguna")[0].reset();
    $(
        "#formModalAdminAddPengguna #nama_lengkap_user, #formModalAdminAddPengguna #username_user, #formModalAdminAddPengguna #profil_user, #formModalAdminAddPengguna #email_user, #formModalAdminAddPengguna #gender_user, #formModalAdminAddPengguna #password_user"
    ).removeClass("is-invalid");
    $(
        "#formModalAdminEditPengguna #edit_nama_lengkap_user, #formModalAdminEditPengguna #edit_username_user, #formModalAdminEditPengguna #edit_email_user, #formModalAdminEditPengguna #edit_profil_user, #formModalAdminEditPengguna #edit_gender_user, #formModalAdminEditPengguna #edit_password_user"
    ).removeClass("is-invalid");
    $(".form-text").removeClass("d-none");
    $(
        "#formModalAdminAddPengguna #nama_lengkap_user, #formModalAdminAddPengguna #username_user, #formModalAdminAddPengguna #email_user, #formModalAdminAddPengguna #gender_user, #formModalAdminAddPengguna #password_user"
    ).val("");
});

// edit penguna
$(".buttonEditPengguna").on("click", function () {
    const id = $(this).data("id");
    $.ajax({
        method: "post",
        url: "/admin/pengguna/getuser",
        data: {
            id: id,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            $("#codeUser").val(id);
            $("#edit_nama_lengkap_user").val(data[0].name);
            $("#edit_username_user").val(data[0].username);
            $("#edit_email_user").val(data[0].email);
            data[0].gender == "Laki-Laki"
                ? $("#gender_laki-laki").attr("selected", true)
                : $("#gender_perempuan").attr("selected", true);
            $("#formModalAdminEditPengguna").modal("show");
        },
    });
});

// delete quiz
$(".buttonDeletePengguna").on("click", function () {
    const data = $(this).data("name");
    const action = $(this).data("id");
    $(".userMessagesDelete").html(
        "Anda yakin ingin menghapus pengguna bernama <strong>'" +
            data +
            "'</strong> ? Semua data yang terkait dengan pengguna tersebut akan ikut terhapus!"
    );
    $("#formDeleteUser").attr("action", "/admin/pengguna/delete/" + action);
    $("#deleteUserConfirm").modal("show");
});

// show profile
$(".fotoProfile").on("click", function () {
    const urlImg = $(this).data("url-img");
    const name = $(this).data("name-user");

    $(".nameShowProfilImg").html(name);
    $(".urlShowProfilImg").attr("src", urlImg);

    $("#gambarModal").modal("show");
});

$("#username_user, #edit_username_user").on("input", function () {
    let username = $(this).val();
    $(this).val(
        username
            .replace(/\s/g, "")
            .replace(/[^a-zA-Z0-9]/g, "")
            .toLowerCase()
    );
});

$("#nama_lengkap_user, #edit_nama_lengkap_user").on("input", function () {
    let nama = $(this).val();
    var lettersAndSpace = /^[a-zA-Z\s]*$/; // RegEx untuk huruf dan spasi

    if (!nama.match(lettersAndSpace)) {
        let namaClear = nama.replace(/[^a-zA-Z\s]/g, "");
        $(this).val(namaClear);
    }
});

$("#password_user, #edit_password_user").on("input", function () {
    let password = $(this).val();
    $(this).val(password.trim());
});
$("#email_user, #edit_email_user").on("input", function () {
    let email = $(this).val();
    $(this).val(email.toLowerCase().trim().replace(/\s/g, ""));
});
