$(document).ready(function() {
    // .toggle-button
    $(".toggle-button").click(function() {
        $("nav").toggleClass("close");
        $(this).toggleClass('clicked');

        
    });
    // toggle-button end




});
        
        const activePage = window.location.pathname;
        const navLinks = document.querySelectorAll('nav a');

        Array.from(navLinks).forEach((link) => {
        if (link.href.includes(activePage)) {
            link.classList.add('active');
        }
        });
