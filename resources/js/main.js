// $(function() {
//     $('body').on('click', function(e) {
//         let target = $(e.target);
//         let menuBtn = $('.navbar-toggler');
//         let menuOpen = menuBtn.hasClass('menu-open');
//         let clickInNav = target.closest('.navbar').length;
//         if (!clickInNav && menuOpen) {
//             menuBtn.click();
//         }
//     })

//     $(document).on('keypress paste', '.num-only', function(e) {
//         event = e || window.event;
//         let charCode = event.which || event.keyCode;
//         var inp = String.fromCharCode(charCode);
//         var isNum = /^[0-9]*$/.test(inp);
//         if (!isNum) e.preventDefault();
//     });

//     // $('body').on('click', '.step-desc .card', function() {
//     //     console.log('hello')
//     //     $(this).toggleClass('activeHolegroup');
//     // })
// })
document.addEventListener("DOMContentLoaded", function(event) { 
    let openmodal = document.querySelectorAll(`[data-modal="true"]`);
    let targetModalId;
    for (let i = 0; i < openmodal.length; i++) {
        openmodal[i].addEventListener('click', function(event){
            let targetModal = event.target.dataset.target;
            let modalId = targetModal.replace('#','');
            targetModalId = modalId;
            event.preventDefault();
            toggleModal();
            
        })
    }
    
    const overlay = document.querySelector('.modal-overlay')
    overlay.addEventListener('click', toggleModal);
    
    let closemodal = document.querySelectorAll('.modal-close');
    for (let i = 0; i < closemodal.length; i++) {
      closemodal[i].addEventListener('click', toggleModal);
    }
    
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
    
    function toggleModal () {
      const body = document.querySelector('body');
      const modal = document.getElementById(targetModalId);
      modal.classList.toggle('opacity-0');
      modal.classList.toggle('pointer-events-none');
      body.classList.toggle('modal-active');
    }
});
  
    
    
     
  
