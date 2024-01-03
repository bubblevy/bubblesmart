$(".cancelModalAddMateri, .cancelModalEditMateri").on("click", function () {
    $(".modalAdminMateri")[0].reset();
    $(
        "#formModalAdminMateri #title, #formModalAdminMateri #image, #formModalAdminMateri #audio, #formModalAdminMateri #category, #formEditModalAdminMateri #titleEdit, #formEditModalAdminMateri #imageEdit, #formEditModalAdminMateri #audioEdit, #formEditModalAdminMateri #categoryEdit"
    ).removeClass("is-invalid");
    $(
        "#formModalAdminMateri #title, #formModalAdminMateri #image, #formModalAdminMateri #audio, #formModalAdminMateri #category, #formEditModalAdminMateri #titleEdit, #formEditModalAdminMateri #imageEdit, #formEditModalAdminMateri #audioEdit, #formEditModalAdminMateri #categoryEdit"
    ).removeClass("invalid-feedback");
    $("#formModalAdminMateri #title, #formModalAdminMateri #category").val("");
});

$(".buttonEditMateri").on("click", function () {
    const code = $(this).data("code-materi");
    const title = $(this).data("title-materi");
    const category = $(this).data("category-materi");
    if (category == "huruf") {
        $("#huruf").attr("selected", true);
    } else if (category == "pasangan") {
        $("#pasangan").attr("selected", true);
    } else {
        $("#sandhangan").attr("selected", true);
    }
    $(".codeMateri").val(code);
    $("#titleEdit").val(title);
    $("#formEditModalAdminMateri").modal("show");
});

$(".buttonDeleteMateri").on("click", function () {
    const data = $(this).data("title-materi");
    const code = $(this).data("code-materi");
    $(".materiMessagesDelete").html(
        "Anda yakin ingin menghapus materi dengan nama <strong>'" +
            data +
            "'</strong> ?"
    );
    $(".codeMateri").val(code);
    $("#deleteMateriConfirm").modal("show");
});
