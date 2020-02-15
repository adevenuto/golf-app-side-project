
document.addEventListener("DOMContentLoaded", function() { 
    let currentModal;
    document.body.addEventListener('click', function(event) {
        let modalTrigger = event.target.dataset.target;
        if (modalTrigger) {
            currentModal = modalTrigger.replace('#','');
            event.preventDefault();
            toggleModal();
        };
        let modalClose = event.target.classList.contains('modal-close');
        if (modalClose) {
            event.preventDefault();
            toggleModal();
        };
    });
    document.onkeydown = function(evt) {
        evt = evt || window.event;
        let isEscape = false;
        if ("key" in evt) {
            isEscape = (evt.key === "Escape" || evt.key === "Esc");
        } else {
            isEscape = (evt.keyCode === 27);
        }
        if (isEscape && document.body.classList.contains('modal-active')) {
            toggleModal();
        }
    };
    function toggleModal() {
        const body = document.querySelector('body');
        const modal = document.getElementById(currentModal);
        modal.classList.toggle('opacity-0');
        modal.classList.toggle('pointer-events-none');
        body.classList.toggle('modal-active');
    }
    // TOGGLE MODAL GLOBALLY
    /////////////////////////
    var _toggleModal = function(modalId) {
        currentModal = modalId;
        const body = document.querySelector('body');
        const modal = document.getElementById(modalId);
        modal.classList.toggle('opacity-0');
        modal.classList.toggle('pointer-events-none');
        body.classList.toggle('modal-active');
    }
    window._toggleModal = _toggleModal;
});
