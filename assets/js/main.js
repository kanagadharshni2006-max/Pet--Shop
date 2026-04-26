document.addEventListener("DOMContentLoaded", function() {
    // Wishlist Toggle Logic
    const wishlistBtns = document.querySelectorAll('.wishlist-btn');
    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const item_id = this.getAttribute('data-id');
            const item_type = this.getAttribute('data-type') || 'product';
            if (!item_id) return;

            fetch('toggle_wishlist.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ item_id: item_id, item_type: item_type })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'added' || data.status === 'removed') {
                    this.classList.toggle('active');
                    const icon = this.querySelector('i');
                    if (data.status === 'added') {
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid');
                        console.log("Added to wishlist");
                    } else {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                        console.log("Removed from wishlist");
                    }
                } else {
                    alert(data.message || 'An error occurred');
                    if (data.message && data.message.includes('login')) {
                        window.location.href = 'login.php';
                    }
                }
            });
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
    
    if (paymentMethods.length > 0) {
        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                const ccForm = document.getElementById('creditCardForm');
                const upiForm = document.getElementById('upiForm');
                if(ccForm) ccForm.style.display = (this.value === 'online') ? 'block' : 'none';
                if(upiForm) upiForm.style.display = (this.value === 'upi') ? 'block' : 'none';
            });
        });
    }

    // Add to Cart & Buy Now Logic
    const addToCartBtns = document.querySelectorAll('.add-to-cart-btn, .buy-now-btn');
    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const isBuyNow = this.classList.contains('buy-now-btn');
            const productData = {
                product_id: this.getAttribute('data-id'),
                name: this.getAttribute('data-name'),
                price: this.getAttribute('data-price'),
                image: this.getAttribute('data-image'),
                category: this.getAttribute('data-category'),
                type: this.getAttribute('data-type') || 'product'
            };

            const originalText = this.innerHTML;
            this.innerHTML = isBuyNow ? '<i class="fa-solid fa-spinner fa-spin"></i> Processing...' : '<i class="fa-solid fa-spinner fa-spin"></i> Adding...';
            this.disabled = true;

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(productData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    if (isBuyNow) {
                        window.location.href = 'checkout.php';
                        return;
                    }

                    this.innerHTML = '<i class="fa-solid fa-check"></i> Added';
                    this.classList.remove('btn-primary-custom');
                    this.classList.add('btn-secondary-custom');
                    
                    // update cart badge
                    const badge = document.querySelector('.cart-badge');
                    if(badge) {
                        badge.innerText = data.cart_count;
                    }

                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('btn-secondary-custom');
                        this.classList.add('btn-primary-custom');
                        this.disabled = false;
                    }, 2000);
                } else {
                    alert('Error: ' + data.message);
                    this.innerHTML = originalText;
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    });
});

