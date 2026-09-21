<?php
include ('config/connect.php'); 

$pageTitle = "Contact Us | AK Avocado Traders"; 

// 1. Fetch Contact Details from Database
$contactQuery = mysqli_query($conn, "SELECT * FROM contacts LIMIT 1");
$contactInfo = mysqli_fetch_assoc($contactQuery);

$siteAddress = !empty($contactInfo['address']) ? $contactInfo['address'] : 'Office No-102, 1st Floor, Nitika Tower II, Block C-1, Pocket-4, Azadpur, Delhi - 110033';
$sitePhone = !empty($contactInfo['phone']) ? $contactInfo['phone'] : '+91-8448211202';
$siteEmail = !empty($contactInfo['email']) ? $contactInfo['email'] : 'info@akavocadotraders.com';
$siteWorkingHours = !empty($contactInfo['working_hours']) ? $contactInfo['working_hours'] : 'Mon - Sat, 9:00 AM to 6:00 PM IST';

// 2. Form Submission Logic for Inquiries Table
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_inquiry'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $interest = mysqli_real_escape_string($conn, $_POST['interest']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Append company to message if provided
    if(!empty($company)) {
        $message = "Company: " . $company . "\n\nRequirements:\n" . $message;
    }

    $insertQuery = "INSERT INTO inquiries (name, email, phone, subject, message, status) VALUES ('$name', '$email', '$phone', '$interest', '$message', 0)";
    
    if(mysqli_query($conn, $insertQuery)) {
        $msg = "<div class='alert alert-success mt-3' style='background: #D4EDDA; color: #155724; border-color: #C3E6CB; border-radius: 8px;'>Thank you! Your quotation request has been sent successfully. Our team will contact you soon.</div>";
    } else {
        $msg = "<div class='alert alert-danger mt-3' style='border-radius: 8px;'>Oops! Something went wrong. Please try again or call us directly.</div>";
    }
}

include 'includes/header.php'; 
include 'includes/breadcrumb.php'; 
?>

<!-- ==============================
     1. CONTACT INFO & FORM SECTION
     ============================== -->
<section class="contact-page-section">
    <div class="container">
        <div class="row align-items-center">
            
            <!-- Left Side: Dynamic Contact Information -->
            <div class="col-lg-5 reveal">
                <div class="contact-info-wrapper">
                    <span class="badge-organic">Get In Touch</span>
                    <h2 class="sec-title">Let's Discuss Your Export Needs.</h2>
                    <p class="contact-desc">Have questions about our premium avocados, bulk pricing, packaging, or international shipping? Our dedicated team is ready to assist you. Reach out to us today!</p>
                    
                    <!-- Location Card -->
                    <div class="info-card">
                        <div class="info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div class="info-content">
                            <h4>Head Office & Processing Unit</h4>
                            <p><?php echo $siteAddress; ?></p>
                        </div>
                    </div>

                    <!-- Phone Card -->
                    <div class="info-card">
                        <div class="info-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div class="info-content">
                            <h4>Phone Inquiry</h4>
                            <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $sitePhone); ?>"><?php echo $sitePhone; ?></a>
                            <p style="font-size: 12px; margin-top: 5px;">(Available <?php echo $siteWorkingHours; ?>)</p>
                        </div>
                    </div>

                    <!-- Email Card -->
                    <div class="info-card">
                        <div class="info-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div class="info-content">
                            <h4>Email Address</h4>
                            <a href="mailto:<?php echo $siteEmail; ?>"><?php echo $siteEmail; ?></a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Side: Contact Form -->
            <div class="col-lg-7 reveal">
                <div class="contact-form-box">
                    <h3>Request a Free Quotation</h3>
                    <p>Fill out the form below and our export manager will get back to you within 24 hours.</p>
                    
                    <?php echo $msg; ?>
                    
                    <form action="contact.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control" name="company" placeholder="Company Name">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="tel" class="form-control" name="phone" placeholder="Phone / WhatsApp No." required>
                            </div>
                        </div>

                        <div class="form-group">
                            <select class="form-select" name="interest" required>
                                <?php $selectedProduct = isset($_GET['product']) ? $_GET['product'] : ''; ?>
                                <option value="" disabled <?php echo ($selectedProduct=='')?'selected':''; ?>>Select Product of Interest</option>
                                <option value="General Inquiry">General Business Inquiry</option>
                                <option value="Premium Hass Avocados" <?php echo ($selectedProduct=='Premium Hass Avocados')?'selected':''; ?>>Premium Hass Avocados</option>
                                <option value="Organic Fuerte Avocados" <?php echo ($selectedProduct=='Organic Fuerte Avocados')?'selected':''; ?>>Organic Fuerte Avocados</option>
                                
                                <?php 
                                $dropdownQuery = mysqli_query($conn, "SELECT pro_name FROM products WHERE status = 1");
                                if ($dropdownQuery && mysqli_num_rows($dropdownQuery) > 0) {
                                    while($dropdownItem = mysqli_fetch_assoc($dropdownQuery)):
                                        $isSelected = ($selectedProduct == $dropdownItem['pro_name']) ? 'selected' : '';
                                ?>
                                <option value="<?php echo $dropdownItem['pro_name']; ?>" <?php echo $isSelected; ?>>
                                    <?php echo $dropdownItem['pro_name']; ?>
                                </option>
                                <?php 
                                    endwhile; 
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <textarea class="form-control" name="message" placeholder="Tell us about your requirement (Quantity, Destination Port, Packaging preference)..." required></textarea>
                        </div>

                        <button type="submit" name="submit_inquiry" class="btn-submit">Send Message <i class="bi bi-send-fill ms-2"></i></button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ==============================
     2. GOOGLE MAP SECTION
     ============================== -->
<section class="map-section reveal">
    <div class="container">
        <div class="map-container">
            <?php 
                $mapUrl = !empty($contactInfo['map']) ? $contactInfo['map'] : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62237.761759075904!2d77.62710646054165!3d12.852310520678248!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae6c9b3e97af09%3A0xe98cd46864ad9b2f!2sBengaluru%2C%20Karnataka%20560100!5e0!3m2!1sen!2sin!4v1789808240335!5m2!1sen!2sin';
            ?>
            <iframe src="<?php echo $mapUrl; ?>" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

<!-- ==============================
     3. SUPPORT / FAQ SECTION
     ============================== -->
<section class="faq-section">
    <div class="container">
        <div class="row justify-content-center text-center mb-5 reveal">
            <div class="col-lg-8">
                <span class="badge-organic mb-2">Customer Support</span>
                <h2 class="sec-title">Common Queries</h2>
            </div>
        </div>

        <div class="row justify-content-center reveal">
            <div class="col-lg-9">
                <div class="accordion faq-accordion" id="contactFaqAccordion">
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                How quickly do you respond to quotation requests?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#contactFaqAccordion">
                            <div class="accordion-body">
                                Our international sales team operates round the clock. You can expect a detailed response with pricing, availability, and shipping estimates within 12 to 24 hours of submitting your inquiry.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                Can I request a free sample before placing a bulk order?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#contactFaqAccordion">
                            <div class="accordion-body">
                                Yes, we encourage our B2B buyers to check our quality. We provide free product samples; however, the international courier/freight charges must be borne by the buyer.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                Do you arrange logistics and international shipping?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#contactFaqAccordion">
                            <div class="accordion-body">
                                Absolutely. We offer FOB (Free On Board) as well as CIF (Cost, Insurance, and Freight) terms. Our logistics team handles all customs clearance, cold-chain transport, and ensures secure delivery to your destination port.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const reveals = document.querySelectorAll(".reveal");
        const revealOnScroll = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("active");
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        reveals.forEach(reveal => revealOnScroll.observe(reveal));
    });
</script>

<?php include 'includes/footer.php'; ?>