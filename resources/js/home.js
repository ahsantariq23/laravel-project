
const cartCountElement = document.getElementById('cart-count');


const addToCartButtons = document.querySelectorAll('.strip-wrap button');
addToCartButtons.forEach(button => {
    button.addEventListener('click', (event) => {

        event.preventDefault();
        

        let currentCount = parseInt(cartCountElement.textContent);
        currentCount++;

        cartCountElement.textContent = currentCount;
    });
});










