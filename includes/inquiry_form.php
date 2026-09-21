<!-- Elegant Contact Section with Dynamic Map -->
<section class="inquiry-modern py-4">
    <div class="container-fluid px-8">
        <div class="row g-0">
            <!-- Left Side: Map iframe from DB -->
            <div class="col-lg-6 map-panel">
                <?php 
                // Getting map iframe link from database (contacts table)
                if(!empty($contact_data['map'])): ?>
                    <iframe src="<?= htmlspecialchars($contact_data['map']) ?>" width="100%" height="100%" style="border:0; min-height: 550px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center bg-light h-100" style="min-height: 550px;">
                        <span class="text-muted">Map will be updated shortly</span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Right Side: Form -->
            <div class="col-lg-6 bg-light-green p-5 d-flex align-items-center">
                <div class="form-wrapper w-100" style="max-width: 600px; margin: 0 auto;">
                    <span class="badge-organic mb-3">Get In Touch</span>
                    <h3 class="fw-bold text-dark mb-4 section-heading fs-2">Request a Quote</h3>
                    <p class="text-muted mb-4">Fill out the form below and our team will get back to you within 24 hours.</p>
                    <form action="inquiry-process.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control input-organic" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="phone" class="form-control input-organic" placeholder="Phone Number" required>
                            </div>
                            <div class="col-12">
                                <input type="email" name="email" class="form-control input-organic" placeholder="Email Address" required>
                            </div>
                            <div class="col-12">
                                <textarea name="message" class="form-control input-organic" rows="4" placeholder="Your Requirements" required></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn-primary-organic w-100 py-3 fs-5">Send Message <i class="bi bi-send ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
