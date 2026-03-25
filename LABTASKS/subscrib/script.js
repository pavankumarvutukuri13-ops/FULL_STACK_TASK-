
document.addEventListener("DOMContentLoaded", function () {
    document.body.style.opacity = "0";
    document.body.style.transition = "opacity 0.6s ease-in-out";
    setTimeout(() => {
        document.body.style.opacity = "1";
    }, 100);
});



document.querySelectorAll("button").forEach(button => {

    button.addEventListener("click", function (e) {

        // Get parent form
        const form = this.closest("form");

        // Check if form is valid
        if (form && !form.checkValidity()) {
            return; // Stop if invalid
        }

        // Change button text
        this.innerText = "Processing...";
        this.disabled = true;

        
        setTimeout(() => {
            this.disabled = false;
        }, 1500);

    });

});