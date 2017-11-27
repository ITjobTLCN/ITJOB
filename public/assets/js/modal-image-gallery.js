$(document).ready(function() {

    /* activate the carousel */
    $("#modal-carousel").carousel({
        interval: false
    });

    /* when clicking a thumbnail */
    $(".row .modal-image").click(function(e) {
        var content = $(".carousel-inner");
        var title = $(".modal-title");

        content.empty();


        var id = this.id;
        var repo = $("#img-repo .item");
        var repoCopy = repo.filter("#" + id).clone();
        var active = repoCopy.first();

        active.addClass("active");
        content.append(repoCopy);

        // show the modal
        $("#modal-gallery").modal("show");
        e.preventDefault();
    });
});