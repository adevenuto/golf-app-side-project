document.addEventListener("DOMContentLoaded", function() { 
    const navDropdown = document.getElementById('navDropdown');
    const navDropdownTrigger = document.getElementById('navDropdownTrigger');
    document.body.addEventListener('click', function(event) {
        const dropDownOpen = navDropdown.classList.contains('block');
        if (event.target.id !== 'navDropdownTrigger') {
            if (dropDownOpen) {
                navDropdownTrigger.dispatchEvent(new Event("click"));
            }
        }
    })
});