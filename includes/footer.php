<?php
// includes/footer.php
?>
<footer class="footer-main py-5 mt-5">
    <div class="container">
        <div class="row g-5">
            <!-- Brand & Contact -->
            <div class="col-lg-4">
                <a class="navbar-brand mb-3 d-inline-block" href="index.php">
                    <i class="fa-solid fa-paw"></i> Paws&Claws
                </a>
                <p class="text-muted pe-lg-4 mb-4">
                    Providing high-quality pet supplies and lovable companions since 2024. Your pet's comfort is our top priority.
                </p>
                <div class="contact-details">
                    <p class="mb-2 d-flex align-items-center">
                        <i class="fa-solid fa-envelope text-primary-start me-3"></i>
                        <a href="mailto:support@pawsandclaws.com" class="text-decoration-none text-muted">support@pawsandclaws.com</a>
                    </p>
                    <p class="mb-0 d-flex align-items-center">
                        <i class="fa-solid fa-location-dot text-primary-start me-3"></i>
                        <span class="text-muted">123 Pet Lane, Animal City</span>
                    </p>
                </div>
            </div>
            
            <!-- Links -->
            <div class="col-lg-2 col-6">
                <h6 class="fw-bold text-dark mb-4">Company</h6>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2"><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
                    <li class="mb-2"><a href="products.php" class="text-decoration-none text-muted">Shop</a></li>
                    <li class="mb-2"><a href="pets.php" class="text-decoration-none text-muted">Adopt</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Our Story</a></li>
                </ul>
            </div>

            <!-- Social & Community -->
            <div class="col-lg-3 col-6">
                <h6 class="fw-bold text-dark mb-4">Community</h6>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#" class="social-btn insta" title="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="social-btn telegram" title="Telegram">
                        <i class="fa-brands fa-telegram"></i>
                    </a>
                    <a href="#" class="social-btn whatsapp" title="WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
                <p class="small text-muted mt-3">Follow us for daily pet cuteness!</p>
            </div>
            
            <!-- Newsletter -->
            <div class="col-lg-3">
                <h6 class="fw-bold text-dark mb-4">Newsletter</h6>
                <p class="small text-muted mb-3">Join our community for exclusive deals.</p>
                <div class="input-group">
                    <input type="email" class="form-control border-0 bg-light" placeholder="Email Address" style="border-radius: 12px 0 0 12px;">
                    <button class="btn btn-primary-custom" type="button" style="border-radius: 0 12px 12px 0;"><i class="fa-solid fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
        
        <hr class="my-5 opacity-10">
        
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="small text-muted mb-0">&copy; <?php echo date('Y'); ?> Paws & Claws. Crafting happy tails.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" height="20" class="me-3 opacity-50" alt="PayPal">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" height="15" class="me-3 opacity-50" alt="Visa">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" height="20" class="opacity-50" alt="MasterCard">
            </div>
        </div>
    </div>
</footer>

<!-- Chatbot Bubble UI Simulation -->
<div class="chatbot-bubble" id="chatbotBubble">
    <i class="fa-solid fa-comment-dots"></i>
</div>

<!-- Toastify JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom Script -->
<script src="assets/js/main.js"></script>
</body>
</html>
