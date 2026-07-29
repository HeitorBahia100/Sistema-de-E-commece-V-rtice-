document.addEventListener('DOMContentLoaded', function () {
    const addButtons = document.querySelectorAll('[data-add-to-cart]');
    addButtons.forEach((button) => {
        button.addEventListener('click', function () {
            const productId = this.dataset.addToCart;
            window.location.href = `?add=${productId}`;
        });
    });
});
