const newFaqButton = document.getElementById('new_faq_button');
const newFaqForm = document.getElementById('new_faq_form');

newFaqButton.addEventListener('click', () => {
    newFaqForm.classList.toggle('new_faq_hidden');
    newFaqForm.classList.toggle('new_faq_window');
});