
export default function dropZoneFullScreen() {
    /* lastTarget is set first on dragenter, then compared with during dragleave. */
    var lastTarget = null;

    window.addEventListener("dragenter", function(e)
    {
        lastTarget = e.target; // cache the last target here
        // unhide our dropzone overlay
        document.querySelector(".dropzone").style.display = "block";
        document.querySelector(".dropzone").style.opacity = 1;
    });

    window.addEventListener("dragleave", function(e)
    {
        // this is the magic part. when leaving the window,
        // e.target happens to be exactly what we want: what we cached
        // at the start, the dropzone we dragged into.
        // so..if dragleave target matches our cache, we hide the dropzone.
        // `e.target === document` is a workaround for Firefox 57
        if(e.target === lastTarget || e.target === document)
        {
            document.querySelector(".dropzone").style.display = "none";
            document.querySelector(".dropzone").style.opacity = 0;
        }
    });
}    

