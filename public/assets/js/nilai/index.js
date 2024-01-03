$("#score-filter").on("change", function () {
    var selectedOption = this.value;
    if (selectedOption === "teratas") {
        window.location.href = "/nilai?filter=teratas";
    } else if (selectedOption === "terendah") {
        window.location.href = "/nilai?filter=terendah";
    }
});

$(".buttonDeleteHistory").on("click", function () {
    const dataAction = $(this).data("action");
    const data = $(this).data("delete-tanggal");
    const tanggalJam = data.split("|");
    $(".tanggalHistory").html(
        "Anda yakin ingin menghapus histori quiz tanggal <strong>" +
            tanggalJam[0] +
            "jam" +
            tanggalJam[1] +
            "</strong> ?"
    );
    $("#formDeleteNilai").attr("action", "/nilai/delete/" + dataAction);
});
