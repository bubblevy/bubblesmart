$(".cancelModalAddQuiz, .cancelModalEditQuiz").on("click", function () {
    $(".modalAdminQuiz")[0].reset();
    $(
        "#formModalAdminQuiz #deskripsi, #formModalAdminQuiz #title, #formEditModalAdminQuiz #deskripsiEdit, #formEditModalAdminQuiz #titleEdit"
    ).removeClass("is-invalid");
    $(
        "#formModalAdminQuiz #deskripsi, #formModalAdminQuiz #title, #formEditModalAdminQuiz #deskripsiEdit, #formEditModalAdminQuiz #titleEdit"
    ).removeClass("invalid-feedback");
    $("#formModalAdminQuiz #deskripsi, #formModalAdminQuiz #title").val("");
});

// edit quiz
$(".buttonEditQuiz").on("click", function () {
    const title = $(this).data("title-quiz");
    const desc = $(this).data("desc-quiz");
    const codeQuiz = $(this).data("code-quiz");
    const statusQuiz = $(this).data("status-quiz");
    statusQuiz == "Aktif"
        ? $("#aktif").attr("selected", true)
        : $("#nonaktif").attr("selected", true);
    $("#titleEdit").val(title);
    $("#deskripsiEdit").val(desc);
    $(".codeQuiz").val(codeQuiz);
    $("#formEditModalAdminQuiz").modal("show");
});
// delete quiz
$(".buttonDeleteQuiz").on("click", function () {
    const data = $(this).data("title-quiz");
    const action = $(this).data("code-quiz");
    $(".quizMessagesDelete").html(
        "Anda yakin ingin menghapus quiz dengan judul <strong>'" +
            data +
            "'</strong> ? Semua data yang terkait akan ikut terhapus termasuk pertanyaan dan jawaban!"
    );
    $("#formDeleteQuiz").attr("action", "/admin/data-quiz/delete/" + action);
    $("#deleteQuizConfirm").modal("show");
});
