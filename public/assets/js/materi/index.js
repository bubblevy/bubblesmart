$(".box").on("click", function () {
    let text = $(this).data("source-audio");
    let audio = document.getElementById(text);
    if (audio) {
        if (audio.paused) {
            stopAllAudio();
            audio.play();
            $(".box").removeClass("bg-primary text-white");
            $(".box").find("h2").css({
                filter: "invert(0%)",
            });
            $(this).find("h2").css({
                filter: "invert(100%)",
            });
            $(this).addClass("bg-primary text-white");
        } else {
            audio.pause();
            audio.currentTime = 0;
            $(this).removeClass("bg-primary text-white");
            $(this).find("h2").css({
                filter: "invert(0%)",
            });
        }

        audio.addEventListener("ended", function () {
            $(".box").removeClass("bg-primary text-white");
            $(".box").find("h2").css({
                filter: "invert(0%)",
            });
        });
    }
});

function stopAllAudio() {
    var allAudio = document.querySelectorAll("audio");
    allAudio.forEach(function (a) {
        a.pause();
    });
}
