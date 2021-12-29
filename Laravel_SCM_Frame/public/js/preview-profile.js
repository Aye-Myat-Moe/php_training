$(document).on("change", "#profile", function() {
    $("#img-preview").css({
      display: "none"
    });
    const files = !!this.files ? this.files : [];
    if (!files.length || !window.FileReader) return;
    if (/^image/.test(files[0].type)) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const image = new Image();
            image.src = event.target.result;
            image.onload = function() {
                const height = this.height;
                const width = this.width;
                const scale = width / height;
                const previewWidth = 200;
                const previewHeight = previewWidth / scale;
                $("#img-preview").css({
                    width: previewWidth + "px",
                    height: previewHeight + "px",
                    "background-image": "url(" + event.target.result + ")",
                    "background-repeat": "no-repeat",
                    "background-size":
                        previewWidth + "px " + previewHeight + "px",
                    border: "1px solid rgb(206, 212, 218)",
                    borderRadius: "3px",
                    display: "block",
                });
            };
        };
        reader.readAsDataURL(files[0]);
    }
});
