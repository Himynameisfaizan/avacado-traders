<?php
include 'config/connect.php';

// SEO Optimized Variables for AK Avocado Traders
$pageTitle = "About Us | AK Avocado Traders";
$meta_description = "AK Avocado Traders is a leading global exporter of premium quality avocados and fresh agricultural produce, ensuring farm-fresh delivery and sustainable practices.";
$meta_keywords = "AK Avocado Traders, avocado exporter, premium avocados, fresh produce export, Hass avocados, sustainable farming, agricultural trade";

$brands_array = [];
if (isset($conn)) {
    $brands_res = mysqli_query($conn, "SELECT * FROM brands ORDER BY id DESC");
    if ($brands_res && mysqli_num_rows($brands_res) > 0) {
        while ($brand = mysqli_fetch_assoc($brands_res)) {
            $brands_array[] = $brand;
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/breadcrumb.php'; ?>

<!-- 1. ABOUT COMPANY SECTION (SEO H1 Tag applied here) -->
<section class="inner-about section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 reveal mb-5 mb-lg-0">
                <div class="about-image-collage position-relative">
                    <!-- Fresh Avocado Harvest Image -->
                    <img src="https://images.unsplash.com/photo-1523049673857-eb18f1d7b578?q=80&w=800&auto=format&fit=crop" alt="AK Avocado Traders Export Facility" class="about-img-1 w-100 rounded-4 shadow-lg" style="object-fit: cover; height: 400px;">
                    <!-- Premium Close-up Image -->
                    <img src="https://images.unsplash.com/photo-1601004890684-d8cbf643f5f2?q=80&w=600&auto=format&fit=crop" alt="Premium Fresh Avocados" class="about-img-2 position-absolute border border-white border-5 rounded-4 shadow" style="width: 250px; bottom: -40px; right: -20px; height: 250px; object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5 reveal mt-5 mt-lg-0">
                <span class="sec-subtitle text-uppercase fw-bold badge-organic mb-3">About AK Avocado Traders</span>
                <h1 class="sec-title mb-4">Delivering Nature's Finest Avocados to the World.</h1>
                <p class="about-desc mb-3 text-muted-organic">
                    <strong>AK Avocado Traders</strong> has established itself as a premier global exporter of high-quality avocados and fresh agricultural commodities. We bridge the gap between rich, fertile farms and international markets, delivering excellence, nutrition, and natural taste in every shipment.
                </p>
                <p class="about-desc mb-4 text-muted-organic">
                    Specializing in premium export-grade produce, we ensure that our global clientele receives 100% pure, unadulterated, and sustainably sourced avocados. Our stringent quality control, hygienic grading processes, and direct-from-farm sourcing make us your most trusted partner in international fresh food trade.
                </p>
                
                <div class="d-flex align-items-center mt-4">
                    <div class="me-4 text-center">
                        <h3 class="fw-bold mb-0" style="color: #7CB342;">100%</h3>
                        <span class="small text-muted fw-bold">Organic</span>
                    </div>
                    <div class="me-4 text-center">
                        <h3 class="fw-bold mb-0" style="color: #1A4329;">Global</h3>
                        <span class="small text-muted fw-bold">Export</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. MISSION & VISION SECTION -->
<section class="mv-section section-padding bg-light-green">
    <div class="container">
        <div class="row g-4">
            <!-- Mission Card -->
            <div class="col-lg-6 reveal">
                <div class="mv-card bg-white p-5 rounded-4 shadow-sm h-100 border-accent-green">
                    <div class="icon-wrap mb-4 icon-circle-green">
                        <i class="bi bi-bullseye mv-icon"></i>
                    </div>
                    <h3 class="mv-title">Our Mission</h3>
                    <p class="about-desc mb-0">
                        To consistently deliver superior quality avocados and agricultural products to global markets while maintaining ethical and sustainable farming practices. We aim to empower local farmers and provide international consumers with fresh, nutritious, and authentic produce.
                    </p>
                </div>
            </div>
            <!-- Vision Card -->
            <div class="col-lg-6 reveal">
                <div class="mv-card bg-white p-5 rounded-4 shadow-sm h-100 border-primary-dark">
                    <div class="icon-wrap mb-4 icon-circle-dark">
                        <i class="bi bi-eye-fill mv-icon"></i>
                    </div>
                    <h3 class="mv-title">Our Vision</h3>
                    <p class="about-desc mb-0">
                        To be the world's most reliable and sustainable partner in the agricultural export industry, recognized globally for our uncompromising quality standards, timely delivery, and deep commitment to global food safety and environmental health.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. WHY CHOOSE US -->
<section class="inner-wcu section-padding">
    <div class="container">
        <div class="row text-center mb-5 reveal">
            <div class="col-12">
                <span class="sec-subtitle badge-organic mb-2">The AK Advantage</span>
                <h2 class="sec-title">Why Partner With Us?</h2>
            </div>
        </div>

        <div class="row align-items-center g-4">
            <!-- Left Side Points -->
            <div class="col-lg-4 reveal">
                <div class="wcu-list-item d-flex align-items-start mb-4 p-3 rounded-4 hover-box">
                    <div class="wcu-list-icon me-3 mt-1"><i class="bi bi-tree-fill"></i></div>
                    <div class="wcu-list-content">
                        <h4>Farm-Fresh Sourcing</h4>
                        <p class="small text-muted mb-0">We procure our avocados directly from the most fertile, sustainable, and trusted agricultural regions.</p>
                    </div>
                </div>
                <div class="wcu-list-item d-flex align-items-start mb-4 p-3 rounded-4 hover-box">
                    <div class="wcu-list-icon me-3 mt-1"><i class="bi bi-patch-check-fill"></i></div>
                    <div class="wcu-list-content">
                        <h4>Certified Quality</h4>
                        <p class="small text-muted mb-0">Strict adherence to global food safety standards, fully compliant with international export boards.</p>
                    </div>
                </div>
            </div>

            <!-- Center Image -->
            <div class="col-lg-4 text-center reveal mb-4 mb-lg-0">
                <div class="center-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1590005024862-6b67679a29fb?q=80&w=600&auto=format&fit=crop" alt="Global Export" class="shadow-lg">
                </div>
            </div>

            <!-- Right Side Points -->
            <div class="col-lg-4 reveal">
                <div class="wcu-list-item d-flex align-items-start mb-4 p-3 rounded-4 hover-box">
                    <div class="wcu-list-icon me-3 mt-1"><i class="bi bi-box-seam-fill"></i></div>
                    <div class="wcu-list-content">
                        <h4>Premium Export Packaging</h4>
                        <p class="small text-muted mb-0">Temperature-controlled, damage-proof packaging that preserves freshness and product integrity during transit.</p>
                    </div>
                </div>
                <div class="wcu-list-item d-flex align-items-start mb-4 p-3 rounded-4 hover-box">
                    <div class="wcu-list-icon me-3 mt-1"><i class="bi bi-globe2"></i></div>
                    <div class="wcu-list-content">
                        <h4>Global Logistics</h4>
                        <p class="small text-muted mb-0">A robust supply chain and cold-storage freight network ensuring safe, hassle-free, and timely delivery across borders.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. Dynamic Brands / Clients Slider Section (Same logic as provided) -->
<section class="brands-slider-section py-5 bg-light-green border-top">
    <div class="container">
        <h2 class="text-center mb-5 sec-title" style="font-size: 1.8rem;">OUR TRUSTED CLIENTS & PARTNERS</h2>
        
        <div class="brand-slider-container bg-white p-4 rounded-4 shadow-sm">
            <div class="brand-slide-track">
                <?php if(!empty($brands_array)): ?>
                    <?php 
                    for($loop = 0; $loop < 2; $loop++):
                        foreach($brands_array as $brand):
                            $brandLogo = !empty($brand['logo_path']) ? $brand['logo_path'] : '';
                    ?>
                    <div class="brand-slide">
                        <?php if(!empty($brandLogo)): ?>
                            <img src="admin/<?= htmlspecialchars($brandLogo) ?>" alt="<?= htmlspecialchars($brand['brand_name']) ?>" title="<?= htmlspecialchars($brand['brand_name']) ?>">
                        <?php else: ?>
                            <span class="fw-bold text-dark"><?= htmlspecialchars($brand['brand_name']) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php 
                        endforeach; 
                    endfor; 
                    ?>
                <?php else: ?>
                    <div class="brand-slide"><h4 class="brand-logo fw-bold text-muted">GLOBAL GAP</h4></div>
                    <div class="brand-slide"><h4 class="brand-logo fw-bold text-muted">APEDA</h4></div>
                    <div class="brand-slide"><h4 class="brand-logo fw-bold text-muted">FSSAI</h4></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- 5. HOW WE WORK (WORKING PROCESS) -->
<section class="process-section section-padding position-relative">
    <div class="container position-relative z-1">
        <div class="row text-center mb-5 reveal">
            <div class="col-12">
                <span class="sec-subtitle text-avocado">Our Supply Chain</span>
                <h2 class="sec-title text-white">The Export Process</h2>
            </div>
        </div>

        <div class="process-grid reveal">
            <!-- Step 1 -->
            <div class="process-step">
                <div class="process-icon"><i class="bi bi-basket-fill"></i></div>
                <h4>1. Ethical Sourcing</h4>
                <p>Procuring premium avocados straight from certified, sustainable farms.</p>
            </div>
            <!-- Step 2 -->
            <div class="process-step">
                <div class="process-icon"><i class="bi bi-ui-checks-grid"></i></div>
                <h4>2. Processing & Grading</h4>
                <p>Hygienic sorting, cleaning, and grading based on size and export quality.</p>
            </div>
            <!-- Step 3 -->
            <div class="process-step">
                <div class="process-icon"><i class="bi bi-shield-check"></i></div>
                <h4>3. Quality Assurance</h4>
                <p>Rigorous testing to ensure uncompromised purity and nutritional value.</p>
            </div>
            <!-- Step 4 -->
            <div class="process-step">
                <div class="process-icon"><i class="bi bi-airplane-fill"></i></div>
                <h4>4. Secure Export</h4>
                <p>Cold-chain shipping and customs clearance to international destinations.</p>
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
        }, {
            threshold: 0.15
        });

        reveals.forEach(reveal => revealOnScroll.observe(reveal));
    });
</script>

<?php include 'includes/footer.php'; ?>