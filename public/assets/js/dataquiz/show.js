// add question
$(".cancelModalAddQuestion").on("click", function () {
    $(".modalAdminAddQuestions")[0].reset();
    $(
        "#formModalAdminAddQuestions #question, #formModalAdminAddQuestions #option1, #formModalAdminAddQuestions #option2, #formModalAdminAddQuestions #option3, #formModalAdminAddQuestions #option4, #formModalAdminAddQuestions #score, #formModalAdminAddQuestions #correct"
    ).removeClass("is-invalid");
    $(
        "#formModalAdminAddQuestions #question, #formModalAdminAddQuestions #option1, #formModalAdminAddQuestions #option2, #formModalAdminAddQuestions #option3, #formModalAdminAddQuestions #option4, #formModalAdminAddQuestions #score, #formModalAdminAddQuestions #correct"
    ).removeClass("invalid-feedback");
    $(
        "#formModalAdminAddQuestions #question, #formModalAdminAddQuestions #option1, #formModalAdminAddQuestions #option2, #formModalAdminAddQuestions #option3, #formModalAdminAddQuestions #option4, #formModalAdminAddQuestions #score, #formModalAdminAddQuestions #correct"
    ).val("");
});

// edit question
$(".cancelModalEditQuestion").on("click", function () {
    $(".modalAdminEditQuestion")[0].reset();
    $(
        "#formModalAdminEditQuestion #editquestion, #formModalAdminEditQuestion #editOption1, #formModalAdminEditQuestion #editOption2, #formModalAdminEditQuestion #editOption3, #formModalAdminEditQuestion #editOption4, #formModalAdminEditQuestion #editScore, #formModalAdminEditQuestion #editCorrect"
    ).removeClass("is-invalid");
    $(
        "#formModalAdminEditQuestion #editquestion, #formModalAdminEditQuestion #editOption1, #formModalAdminEditQuestion #editOption2, #formModalAdminEditQuestion #editOption3, #formModalAdminEditQuestion #editOption4, #formModalAdminEditQuestion #editScore, #formModalAdminEditQuestion #editCorrect"
    ).removeClass("invalid-feedback");
});

// delete question
$(".buttonDeleteQuestion").on("click", function () {
    const data = $(this).data("delete-question");
    const action = $(this).data("action");
    $(".questionMessagesDelete").html(
        "Anda yakin ingin menghapus soal <strong>'" + data + "'</strong> ?"
    );
    $("#formDeleteQuestion").attr(
        "action",
        "/admin/data-quiz/q&a/delete/" + action
    );
    $("#deleteQuestionConfirm").modal("show");
});

// ajax edit question
$(".buttonEditQuestion").on("click", function () {
    const questionID = $(this).data("code-question");
    const question = $(this).data("edit-question");
    const score = $(this).data("edit-score");
    $.ajax({
        method: "post",
        url: "/admin/data-quiz/getanswer",
        data: {
            id: questionID,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            $("#editquestion").val(question);
            $("#codeQuestion").val(questionID);
            $("#editScore").val(score);
            for (let i = 0; i < 4; i++) {
                $(`#editOption${i + 1}`).val(data[i].answer);
            }

            $.each(data, function (index, item) {
                if (item.correct == 1) {
                    $(".dipilih" + (index + 1)).attr("selected", true);
                }
            });
            $("#formModalAdminEditQuestion").modal("show");
        },
    });
});
