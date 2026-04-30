// Global Toast Helper
function showToast(message, type = "success") {
    let bgColor = "linear-gradient(to right, #6366F1, #EC4899)"; // Default indigo/pink gradient
    if (type === "error") bgColor = "linear-gradient(to right, #FF5F6D, #FFC371)";
    if (type === "info") bgColor = "linear-gradient(to right, #2193b0, #6dd5ed)";

    Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top", 
        position: "right", 
        stopOnFocus: true, 
        style: {
            background: bgColor,
            borderRadius: "12px",
            fontWeight: "600",
            boxShadow: "0 10px 15px -3px rgba(0, 0, 0, 0.1)"
        },
        onClick: function(){} 
    }).showToast();
}

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
                        showToast("Added to wishlist! ❤️");
                    } else {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                        showToast("Removed from wishlist.", "info");
                    }
                } else {
                    showToast(data.message || 'An error occurred', "error");
                    if (data.message && data.message.includes('login')) {
                        setTimeout(() => window.location.href = 'login.php', 1000);
                    }
                }
            });
        });
    });

    // Chatbot Toggle
    const chatbotBubble = document.getElementById('chatbotBubble');
    if (chatbotBubble) {
        chatbotBubble.addEventListener('click', function() {
            showToast('Chatbot: "Hi there! How can I help you and your pet today?"', "info");
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

                    showToast(`${productData.name} added to cart! 🛒`);
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
                    showToast('Error: ' + data.message, "error");
                    this.innerHTML = originalText;
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast("Something went wrong.", "error");
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    });
});
