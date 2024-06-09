var snow = new Quill("#snow", {
    theme: "snow",
});
var bubble = new Quill("#bubble", {
    theme: "bubble",
});
var quill = new Quill("#full", {
    bounds: "#full-container .editor",
    modules: {
        toolbar: [
            [{ font: [] }, { size: [] }],
            ["bold", "italic", "underline", "strike"],
            [{ color: [] }, { background: [] }],
            [{ script: "super" }, { script: "sub" }],
            [
                { list: "ordered" },
                { list: "bullet" },
                { indent: "-1" },
                { indent: "+1" },
            ],
            ["direction", { align: [] }],
            ["link", "image", "video"],
            ["clean"],
        ],
    },
    placeholder: "Tulis Komentar",
    theme: "snow",
});
var form = document.querySelector("form");
var hiddenInput = document.querySelector("#hiddenInput");

document.getElementById("form").onsubmit = function () {
    hiddenInput.value = quill.root.innerHTML;
};
