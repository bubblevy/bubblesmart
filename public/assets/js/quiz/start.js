// confirm user submit quiz
$(".buttonSumbitQuiz").on("click", function (e) {
    e.preventDefault();
    $("#submitQuiz").modal("show");
});

$(".confirmQuiz").on("click", function () {
    localStorage.clear();
    $("#quizForm").submit();
});

// fungsi untuk menyimpan jawaban user sementara sebelum submit
document
    .querySelectorAll('input[type="radio"]')
    .forEach(function (radioButton) {
        radioButton.addEventListener("change", function () {
            // Menggunakan radioButton.name sebagai kunci unik
            const groupName = radioButton.name;
            localStorage.setItem("quiz_" + groupName, radioButton.id);
        });
    });

document
    .querySelectorAll('input[type="radio"]')
    .forEach(function (radioButton) {
        const groupName = radioButton.name;
        const selectedId = localStorage.getItem("quiz_" + groupName);

        if (selectedId) {
            radioButton.checked = radioButton.id === selectedId;
        }
    });

$(".btlQuiz").on("click", function () {
    localStorage.clear();
});
