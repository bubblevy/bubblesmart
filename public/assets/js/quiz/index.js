$(".buttonDetails").on("click", function () {
    const title = $(this).data("title-quiz");
    const description = $(this).data("description-quiz");
    const totalSoal = $(this).data("total-soal-quiz");
    $("#titleQuiz").html(title);
    $("#descriptionQuiz").html(description);
    $("#totalSoalQuiz").html(totalSoal);
});
