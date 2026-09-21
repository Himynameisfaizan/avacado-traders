<?php
include 'config/connect.php';

$banner_res = false;
if (isset($conn)) {
    $banner_res = mysqli_query($conn, "SELECT * FROM banners WHERE status = 0 ORDER BY display_order ASC, id DESC");
}

$categories_res = false;
if (isset($conn)) {
    $categories_res = mysqli_query($conn, "SELECT * FROM categories WHERE status = 1 ORDER BY id DESC LIMIT 3");
}

$products_res = false;
if (isset($conn)) {
    $products_res = mysqli_query($conn, "SELECT * FROM products WHERE status = 1 ORDER BY id DESC LIMIT 8");
}

// Fetch Testimonials
$test_res = false;
if (isset($conn)) {
    $test_res = mysqli_query($conn, "SELECT * FROM testimonials WHERE status = 1 ORDER BY test_id DESC LIMIT 3");
}

// Fetch About Section Data
$about_res = false;
$about_data = [];
if (isset($conn)) {
    $about_query = mysqli_query($conn, "SELECT * FROM about_sections ORDER BY section_order ASC LIMIT 1");
    if ($about_query && mysqli_num_rows($about_query) > 0) {
        $about_data = mysqli_fetch_assoc($about_query);
    }
}

$brands_array = [];
if (isset($conn)) {
    $brands_res = mysqli_query($conn, "SELECT * FROM brands ORDER BY id DESC");
    if ($brands_res && mysqli_num_rows($brands_res) > 0) {
        while ($brand = mysqli_fetch_assoc($brands_res)) {
            $brands_array[] = $brand;
        }
    }
}

// Fetch Blogs
$blogs_res = false;
if (isset($conn)) {
    $blogs_res = mysqli_query($conn, "SELECT * FROM blogs WHERE status = 1 ORDER BY blog_id DESC LIMIT 3");
}

$contact_data = [];
if (isset($conn)) {
    $contact_query = mysqli_query($conn, "SELECT * FROM contacts ORDER BY id ASC LIMIT 1");
    if ($contact_query && mysqli_num_rows($contact_query) > 0) {
        $contact_data = mysqli_fetch_assoc($contact_query);
    }
}

// SEO Data Fetch
$seo_banner_query = mysqli_query($conn, "SELECT meta_title, meta_key, meta_desc FROM banners WHERE status = 0 ORDER BY display_order ASC, id DESC LIMIT 1");
$metaTitle = "AK Avocado Traders | Premium Agricultural Produce";
$meta_description = "AK Avocado Traders is committed to delivering premium-quality avocados and fresh agricultural produce to domestic and international markets.";
$meta_keywords = "avocados, fresh produce, agricultural export, AK Avocado Traders, premium avocados";

if ($seo_banner_query && mysqli_num_rows($seo_banner_query) > 0) {
    $seo_data = mysqli_fetch_assoc($seo_banner_query);
    if (!empty($seo_data['meta_title'])) $metaTitle = $seo_data['meta_title'];
    if (!empty($seo_data['meta_desc'])) $meta_description = $seo_data['meta_desc'];
    if (!empty($seo_data['meta_key'])) $meta_keywords = $seo_data['meta_key'];
}

include("includes/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($metaTitle); ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description); ?>">
    <meta name="keywords" content="<?= htmlspecialchars($meta_keywords); ?>">
    <!-- Google Fonts for Modern Look -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="<?= isset($favicon) ? htmlspecialchars($favicon) : 'assets/images/logo/logo.png'; ?>" type="image/png">
    
    <!-- Organization Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "AK Avocado Traders",
  "url": "<?= isset($site) ? $site : 'https://akavocadotraders.com'; ?>",
  "logo": "<?= isset($site) ? $site : ''; ?>/assets/images/logo/logo.png",
  "description": "Exporting premium-quality avocados and fresh farm produce globally.",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+91-XXXXXXXXXX",
    "contactType": "customer service",
    "areaServed": "Global",
    "availableLanguage": ["en", "hi"]
  }
}
</script>
</head>
<body>
    
<!-- Modern Hero Banner Section -->
<div id="heroCarousel" class="carousel slide carousel-fade hero-slider modern-hero" data-bs-ride="carousel" data-bs-pause="false" style="background-color: #1A4329;">
    <div class="carousel-indicators premium-indicators">
        <?php
        if ($banner_res && mysqli_num_rows($banner_res) > 0):
            $i = 0;
            mysqli_data_seek($banner_res, 0);
            while ($b_row = mysqli_fetch_assoc($banner_res)):
        ?>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $i ?>" class="<?= ($i == 0) ? 'active' : '' ?>"></button>
            <?php $i++; endwhile; else: ?>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <?php endif; ?>
    </div>

    <div class="carousel-inner h-100">
        <?php
        if ($banner_res && mysqli_num_rows($banner_res) > 0):
            $j = 0;
            mysqli_data_seek($banner_res, 0);
            while ($banner = mysqli_fetch_assoc($banner_res)):
                // Image path fix for admin uploads
                $bannerImg = !empty($banner['banner_path']) ? 'admin/' . $banner['banner_path'] : 'https://images.unsplash.com/photo-1519999482648-25049ddd37b1?q=80&w=1920&auto=format&fit=crop';
        ?>
                <div class="carousel-item h-100 <?= ($j == 0) ? 'active' : '' ?>" data-bs-interval="6000">
                    <div class="slide-bg modern-overlay" style="background-image: url('<?= htmlspecialchars($bannerImg) ?>');"></div>
                    <div class="carousel-caption modern-caption">
                        <div class="container text-center">
                            <span class="hero-subtitle">Farm Fresh Delivery</span>
                            <h2 class="hero-title"><?= htmlspecialchars($banner['title']) ?></h2>
                            <p class="hero-desc mx-auto"><?= htmlspecialchars($banner['description']) ?></p>
                            <div class="hero-btns mt-4">
                                <a href="<?= !empty($banner['link_url']) ? htmlspecialchars($banner['link_url']) : 'products.php' ?>" class="btn-primary-organic">Explore Products</a>
                                <a href="contact.php" class="btn-outline-organic">Partner With Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php $j++; endwhile; else: ?>
            <!-- Fallback Banner if database is empty -->
            <div class="carousel-item h-100 active" data-bs-interval="6000">
                <div class="slide-bg modern-overlay" style="background-image: url('https://images.unsplash.com/photo-1519999482648-25049ddd37b1?q=80&w=1920&auto=format&fit=crop');"></div>
                <div class="carousel-caption modern-caption">
                    <div class="container text-center">
                        <span class="hero-subtitle">Premium Quality Export</span>
                        <h2 class="hero-title">100% Pure & Fresh <br><span class="text-avocado">Avocados</span></h2>
                        <p class="hero-desc mx-auto">Sourced directly from trusted farms, delivering natural taste and nutritional value across the globe.</p>
                        <div class="hero-btns mt-4">
                            <a href="products.php" class="btn-primary-organic">Our Produce</a>
                            <a href="contact.php" class="btn-outline-organic">Get a Quote</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Premium About Section -->
<section class="section-padding about-organic">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 position-relative">
                <div class="about-image-grid">
                    <?php $aboutImg = !empty($about_data['image_url']) ? 'admin/' . $about_data['image_url'] : 'https://images.unsplash.com/photo-1601004890684-d8cbf643f5f2?q=80&w=800&auto=format&fit=crop'; ?>
                    <img src="<?= htmlspecialchars($aboutImg); ?>" alt="AK Avocado Traders" class="main-img rounded-4 shadow-lg w-100">
                    <div class="experience-badge shadow-lg">
                        <i class="bi bi-shield-check fs-1 text-white mb-2"></i>
                        <h4 class="mb-0 text-white fw-bold">Premium</h4>
                        <p class="mb-0 text-white-50 small">Export Quality</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content ps-lg-4">
                    <span class="badge-organic mb-3">About AK Avocado Traders</span>
                    <h2 class="section-heading mb-4">
                        <?= !empty($about_data['title']) ? htmlspecialchars($about_data['title']) : 'Bringing the Finest Farm-Fresh Produce to Your Doorstep'; ?>
                    </h2>
                    <div class="text-muted-organic mb-4">
                        <?php 
                        if (!empty($about_data['content'])) {
                            echo $about_data['content']; 
                        } else {
                            echo '<p>At <strong>AK Avocado Traders</strong>, we are committed to delivering premium-quality avocados and fresh agricultural produce to customers across domestic and international markets. With a strong focus on quality, freshness, and customer satisfaction, we source our products directly from trusted farms that follow sustainable and ethical farming practices.</p>
                            <p>Every avocado is carefully selected, graded, and packed to preserve its natural taste, nutritional value, and freshness throughout the supply chain. Our dedication to timely delivery and international standards makes us your trusted partner.</p>';
                        }
                        ?>
                    </div>
                    <ul class="list-unstyled organic-list mb-5">
                        <li><i class="bi bi-check-circle-fill"></i> Sustainable & Ethical Farming</li>
                        <li><i class="bi bi-check-circle-fill"></i> Strict Quality Grading</li>
                        <li><i class="bi bi-check-circle-fill"></i> Timely Global Delivery</li>
                    </ul>
                    <a href="about.php" class="btn-primary-organic">Discover Our Story <i class="bi bi-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modern Categories Grid -->
<section class="section-padding bg-light-green">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge-organic mb-2">Explore By Category</span>
            <h2 class="section-heading">Our Fresh Offerings</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <?php
            if ($categories_res && mysqli_num_rows($categories_res) > 0):
                while ($cat = mysqli_fetch_assoc($categories_res)):
                    $catImg = !empty($cat['image']) ? 'admin/uploads/category/' . $cat['image'] : 'assets/images/default-cat.jpg';
                    $catSlug = !empty($cat['slug_url']) ? $cat['slug_url'] : $cat['cate_id'];
            ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="category-card-modern">
                            <div class="img-zoom">
                                <img src="<?= htmlspecialchars($catImg) ?>" alt="<?= htmlspecialchars($cat['categories']) ?>">
                            </div>
                            <div class="card-content">
                                <h3><?= htmlspecialchars($cat['categories']) ?></h3>
                                <p><?= htmlspecialchars(substr($cat['meta_desc'], 0, 70)) ?>...</p>
                                <a href="products.php?category=<?= urlencode($catSlug) ?>" class="btn-link-organic">View Products <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; else: ?>
                <div class="col-12 text-center text-muted">Categories are being updated.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us Section (Updated Design) -->
<section class="section-padding" style="background-color: #FFFFFF;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge-organic mb-2">Our Core Values</span>
            <h2 class="section-heading">Why Choose Us</h2>
        </div>
        <div class="row text-center g-4 justify-content-center">
            <div class="col-lg-3 col-md-6">
                <div class="value-box">
                    <div class="icon-circle"><i class="bi bi-tree"></i></div>
                    <h4>Trusted Farms</h4>
                    <p>Sourced from sustainable and ethical agricultural practices.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="value-box">
                    <div class="icon-circle"><i class="bi bi-box-seam"></i></div>
                    <h4>Careful Grading</h4>
                    <p>Hand-picked, graded, and packed to preserve nutritional value.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="value-box">
                    <div class="icon-circle"><i class="bi bi-globe2"></i></div>
                    <h4>Global Standards</h4>
                    <p>Meeting competitive pricing and international quality criteria.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="value-box">
                    <div class="icon-circle"><i class="bi bi-truck"></i></div>
                    <h4>Timely Delivery</h4>
                    <p>Reliable logistics ensuring farm freshness at your doorstep.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dynamic Products Presentation -->
<section class="section-padding bg-light-gray">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <span class="badge-organic mb-2">Premium Produce</span>
                <h2 class="section-heading mb-0">Export Quality Products</h2>
            </div>
            <a href="products.php" class="btn-outline-organic d-none d-md-inline-block">View Entire Range</a>
        </div>

        <div class="row g-4">
            <?php
            if ($products_res && mysqli_num_rows($products_res) > 0):
                while ($prod = mysqli_fetch_assoc($products_res)):
                    $proImg = !empty($prod['pro_img']) ? 'admin/assets/img/uploads/' . $prod['pro_img'] : 'assets/images/default-pro.jpg';
                    $productSlug = !empty($prod['slug_url']) ? $prod['slug_url'] : $prod['id'];
            ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="product-card-premium">
                            <div class="product-thumb">
                                <span class="badge-quality">Premium</span>
                                <a href="product-details.php?slug=<?php echo urlencode($productSlug); ?>">
                                    <img src="<?= htmlspecialchars($proImg) ?>" alt="<?= htmlspecialchars($prod['pro_name']) ?>">
                                </a>
                            </div>
                            <div class="product-info">
                                <a href="product-details.php?slug=<?php echo urlencode($productSlug); ?>"> 
                                    <h4><?= htmlspecialchars($prod['pro_name']) ?></h4>
                                </a>
                                <div class="action-flex">
                                    <a href="product-details.php?slug=<?php echo urlencode($productSlug); ?>" class="read-more">Details</a>
                                    <a href="contact.php?product=<?= urlencode($prod['pro_name']) ?>" class="btn-inquire">Inquire</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; else: ?>
                <div class="col-12 text-center text-muted">Our product catalog is updating.</div>
            <?php endif; ?>
        </div>
        <div class="text-center mt-4 d-block d-md-none">
            <a href="products.php" class="btn-outline-organic">View Entire Range</a>
        </div>
    </div>
</section>

<!-- Dynamic Brands / Client Logo Slider Section -->
<section class="brands-section section-padding bg-light-green">
    <div class="container text-center">
        <span class="badge-organic mb-2">Our Network</span>
        <h2 class="section-heading mb-3">Trusted Global Partners</h2>
        <p class="text-muted-organic mx-auto mb-5" style="max-width: 650px;">We collaborate with top-tier wholesalers, retailers, and food businesses worldwide to ensure our premium produce reaches every market efficiently.</p>
        
        <div class="brand-slider-container bg-white p-4 rounded-4 shadow-sm">
            <div class="brand-slide-track">
                <?php if(!empty($brands_array)): ?>
                    <?php 
                    // Loop multiple times to create continuous infinite scroll effect
                    for($loop = 0; $loop < 3; $loop++):
                        foreach($brands_array as $brand):
                            $brandLogo = !empty($brand['logo_path']) ? 'admin/'.$brand['logo_path'] : '';
                    ?>
                    <div class="brand-slide">
                        <?php if(!empty($brandLogo)): ?>
                            <img src="<?= htmlspecialchars($brandLogo) ?>" alt="<?= htmlspecialchars($brand['brand_name']) ?>" title="<?= htmlspecialchars($brand['brand_name']) ?>">
                        <?php else: ?>
                            <span class="fw-bold text-dark"><?= htmlspecialchars($brand['brand_name']) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php 
                        endforeach; 
                    endfor; 
                    ?>
                <?php else: ?>
                    <div class="col-12 text-muted">No partners added yet.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Dynamic Blog Section -->
<section class="section-padding" style="background-color: #FFFFFF;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <span class="badge-organic mb-2">Latest Insights</span>
                <h2 class="section-heading mb-0">News & Articles</h2>
            </div>
            <a href="blog.php" class="btn-outline-organic text-dark border-dark d-none d-md-inline-block hover-green">View All Blogs</a>
        </div>

        <div class="row g-4">
            <?php
            if ($blogs_res && mysqli_num_rows($blogs_res) > 0):
                while ($blog = mysqli_fetch_assoc($blogs_res)):
                    // Check logic based on how images are stored in db.
                    $blogImg = !empty($blog['image']) ? 'admin/assets/img/uploads/blogs/' . $blog['image'] : 'https://images.unsplash.com/photo-1490818387583-1b057d5f836c?q=80&w=600&auto=format&fit=crop';
            ?>
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card-modern shadow-sm">
                        <div class="blog-img-wrapper">
                            <a href="blog-details.php?slug=<?= urlencode($blog['slug']) ?>">
                                <img src="<?= htmlspecialchars($blogImg) ?>" alt="<?= htmlspecialchars($blog['title']) ?>">
                            </a>
                            <div class="blog-date">
                                <span class="d-block fw-bold fs-5"><?= date('d', strtotime($blog['created_at'])) ?></span>
                                <span class="small"><?= date('M Y', strtotime($blog['created_at'])) ?></span>
                            </div>
                        </div>
                        <div class="blog-content p-4">
                            <span class="text-avocado fw-bold small text-uppercase mb-2 d-block"><i class="bi bi-person-circle"></i> <?= htmlspecialchars($blog['author']) ?></span>
                            <a href="blog-details.php?slug=<?= urlencode($blog['slug']) ?>" class="text-decoration-none">
                                <h4 class="blog-title text-dark fw-bold mb-3"><?= htmlspecialchars(substr($blog['title'], 0, 50)) ?>...</h4>
                            </a>
                            <p class="text-muted small mb-4"><?= strip_tags(substr($blog['description'], 0, 100)) ?>...</p>
                            <a href="blog-details.php?slug=<?= urlencode($blog['slug']) ?>" class="read-more-link fw-bold">Read Article <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php endwhile; else: ?>
                <div class="col-12 text-center text-muted">No blogs published yet.</div>
            <?php endif; ?>
        </div>
    </div>
</section>


<?php
include ('includes/inquiry_form.php');
include('includes/footer.php'); ?>