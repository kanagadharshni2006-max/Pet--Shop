document.addEventListener("DOMContentLoaded", function() {
    // Wishlist Toggle
    const wishlistBtns = document.querySelectorAll('.wishlist-btn');
    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('active');
            
            const icon = this.querySelector('i');
            if (this.classList.contains('active')) {
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
            } else {
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');
            }
        });
    });

    // Chatbot Toggle
    const chatbotBubble = document.getElementById('chatbotBubble');
    if (chatbotBubble) {
        chatbotBubble.addEventListener('click', function() {
            alert('Chatbot UI: "Hi there! How can I help you and your pet today?"\n(This is a UI simulation)');
        });
    }

    // Payment Method Toggle in Checkout
    const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]');
    const ccForm = document.getElementById('creditCardForm');
    
    if (paymentMethods.length > 0 && ccForm) {
        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                if(this.value === 'online') {
                    ccForm.style.display = 'block';
                } else {
                    ccForm.style.display = 'none';
                }
            });
        });
    }

    // Add to Cart Simulation
    const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fa-solid fa-check"></i> Added';
            this.classList.remove('btn-primary-custom');
            this.classList.add('btn-secondary-custom');
            
            // update cart badge
            const badge = document.querySelector('.cart-badge');
            if(badge) {
                let count = parseInt(badge.innerText || '0');
                badge.innerText = count + 1;
            }

            setTimeout(() => {
                this.innerHTML = originalText;
                this.classList.remove('btn-secondary-custom');
                this.classList.add('btn-primary-custom');
            }, 2000);
        });
    });
});
