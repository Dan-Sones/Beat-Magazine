const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')

const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
const handleShowTracklist = () => {
    localStorage.setItem("activeTab", "tracklist");
    document.getElementById("tracklist").style.display = "block";
    document.getElementById("user-reviews-container").style.display = "none";

    document.getElementById("tracklistButton").classList.remove("btn-secondary");
    document.getElementById("tracklistButton").classList.add("btn-primary");
    document.getElementById("tracklistButton").setAttribute("aria-pressed", "true");

    document.getElementById("reviewButton").classList.remove("btn-primary");
    document.getElementById("reviewButton").classList.add("btn-secondary");
    document.getElementById("reviewButton").setAttribute("aria-pressed", "false");
}

const handleShowReviews = () => {
    localStorage.setItem("activeTab", "reviews");
    document.getElementById("tracklist").style.display = "none";
    document.getElementById("user-reviews-container").style.display = "block";

    document.getElementById("tracklistButton").classList.remove("btn-primary");
    document.getElementById("tracklistButton").classList.add("btn-secondary");
    document.getElementById("tracklistButton").setAttribute("aria-pressed", "false");

    document.getElementById("reviewButton").classList.remove("btn-secondary");
    document.getElementById("reviewButton").classList.add("btn-primary");
    document.getElementById("reviewButton").setAttribute("aria-pressed", "true");
}

document.addEventListener("DOMContentLoaded", function () {
    localStorage.getItem("activeTab") === "reviews" ? handleShowReviews() : handleShowTracklist();
});

document.getElementById("tracklistButton").addEventListener("click", handleShowTracklist);
document.getElementById("reviewButton").addEventListener("click", handleShowReviews);