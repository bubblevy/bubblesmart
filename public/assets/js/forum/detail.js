document.querySelectorAll(".toggle-reply-form").forEach((button) => {
    button.addEventListener("click", () => {
        const targetSelector = button.getAttribute("data-target");
        const replyForm = document.querySelector(targetSelector);

        document.querySelectorAll(".comment-reply").forEach((form) => {
            if (form !== replyForm) {
                form.classList.add("d-none");
            }
        });
        replyForm.classList.toggle("d-none");
    });
});

$(".batal-reply-button").on("click", function () {
    const id = $(this).data("cancel-comment");
    $(".comment-reply-" + id).addClass("d-none", true);
});

$(".button-delete-comment").on("click", function () {
    const message = $(this).data("message-comment");
    let limitMessage = message.substring(0, 100);
    if (message.length > 100) {
        limitMessage += "...";
    }
    const idComment = $(this).data("id-comment");
    $(".commentMessagesDelete").html(
        "Anda yakin ingin menghapus komentar anda <strong>'" +
            limitMessage +
            "'</strong> ?"
    );
    $("#formDeleteComment").attr(
        "action",
        "/view/discuss/comment/delete/" + idComment
    );
    $("#deleteCommentConfirm").modal("show");
});

$(".komentar").on("input", function () {
    let value = $(this).val().trim();
    let $parentForm = $(this).closest("form");

    if (value === "") {
        $parentForm.find(".divBtn").css("cursor", "not-allowed");
        $parentForm.find(".btn-comment").addClass("disabled");
    } else {
        $parentForm.find(".divBtn").css("cursor", "pointer");
        $parentForm.find(".btn-comment").removeClass("disabled");
    }
});
