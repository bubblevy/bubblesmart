$(".likebutton").on("click", function () {
    const id = $(this).data("thread");
    const likeButton = $(this);
    $.ajax({
        method: "post",
        url: "/view/discuss/like",
        data: {
            id: id,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            if (data.message === "like success") {
                likeButton.html(
                    '<i class="bx bxs-heart text-danger mb-1 me-1"></i> ' +
                        data.count
                );
            } else if (data.message === "unlike success") {
                likeButton.html(
                    '<i class="bx bx-heart mb-1 me-1"></i> ' + data.count
                );
            }
        },
    });
});

$(".cancelModalAddTopic").on("click", function () {
    $(".modalAddTopic")[0].reset();
    $("#formModalAddTopic #content, #formModalAddTopic #title").removeClass(
        "is-invalid"
    );
    $("#formModalAddTopic #content, #formModalAddTopic #title").removeClass(
        "invalid-feedback"
    );
    $("#formModalAddTopic #content, #formModalAddTopic #title").val("");
});

$(".button-delete-topic").on("click", function () {
    const message = $(this).data("message-topic");
    let limitMessage = message.substring(0, 100);
    if (message.length > 100) {
        limitMessage += "...";
    }
    const code = $(this).data("code");
    $("#code-thread").val(code);
    $(".topicMessagesDelete").html(
        "Anda yakin ingin menghapus thread anda <strong>'" +
            limitMessage +
            "'</strong> ?"
    );
    $("#formDeleteTopic").attr("action", "/view/discuss/thread/delete");
    $("#deleteTopicConfirm").modal("show");
});
