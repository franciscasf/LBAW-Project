const openModalButton = document.querySelector('.open-modal');
const modal = document.getElementById(openModalButton.getAttribute('data-modal-id'));
const closeButton = modal.querySelector('.close');

openModalButton.addEventListener('click', () => {
    modal.classList.add('show');
    modal.style.display = 'block';
    modal.setAttribute('aria-hidden', 'false');
});

closeButton.addEventListener('click', () => {
    modal.classList.remove('show');
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');
});

window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
    }
});