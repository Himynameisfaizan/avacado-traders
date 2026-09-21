<?php
include('config/connect.php');

if (isset($_GET['slug']) && !empty($_GET['slug'])) {
    $product_slug = mysqli_real_escape_string($conn, $_GET['slug']);
    $productQuery = mysqli_query($conn, "SELECT * FROM products WHERE (slug_url = '$product_slug' OR id = '$product_slug') AND status = 1");
} elseif (isset($_GET['id']) && !empty($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $productQuery = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id' AND status = 1");
} else {
    $productQuery = false;
}

$product = ($productQuery) ? mysqli_fetch_assoc($productQuery) : null;

if (!$product) {
    echo "<script>window.location.href='products.php';</script>";
    exit;
}

$product_id = $product['id'];

// Fetch Global Contact Info for Call Buttons
$contactQuery = mysqli_query($conn, "SELECT phone FROM contacts LIMIT 1");
$contactInfo = mysqli_fetch_assoc($contactQuery);
$sitePhone = !empty($contactInfo['phone']) ? $contactInfo['phone'] : '+91-XXXXXXXXXX';

$pageTitle = $product['pro_name'];

include 'includes/header.php';
include 'includes/breadcrumb.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | AK Avocado Traders</title>
    <meta name="description" content="<?php echo htmlspecialchars($product['meta_desc']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($product['meta_key']); ?>">
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "<?= htmlspecialchars($product['pro_name']); ?>",
  "image": [
    "<?= $site; ?>/admin/assets/img/uploads/<?= htmlspecialchars($product['pro_img']); ?>"
  ],
  "description": "<?= htmlspecialchars(strip_tags($product['meta_desc'])); ?>",
  "brand": {
    "@type": "Brand",
    "name": "<?= htmlspecialchars($product['brand_name'] ?? 'AK Avocado Traders'); ?>"
  },
  "offers": {
    "@type": "Offer",
    "url": "<?php echo $site; ?>/product-details.php?slug=<?= htmlspecialchars($product['slug_url'] ?? $product['id']); ?>",
    "priceCurrency": "INR",
    "availability": "https://schema.org/InStock",
    "itemCondition": "https://schema.org/NewCondition"
  }
}
</script>
</head>
<body>
    
<section class="pd-section">
    <div class="container">
        <div class="row">
            <!-- Left Column: Image Gallery -->
            <div class="col-lg-5 mb-5 mb-lg-0 reveal py-5">
                <div class="pd-image-gallery">
                    <div class="pd-main-img shadow-sm">
                        <img id="mainImage" src="admin/assets/img/uploads/<?php echo $product['pro_img']; ?>" alt="<?php echo htmlspecialchars($product['pro_name']); ?>" onerror="this.src='assets/images/logo/logo.png'">
                    </div>

                    <div class="pd-thumbnails mt-3">
                        <?php
                        $galleryQuery = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id = '$product_id'");
                        while ($galleryImg = mysqli_fetch_assoc($galleryQuery)):
                        ?>
                            <div class="pd-thumb shadow-sm" onclick="changeImage(this, 'uploads/<?php echo $galleryImg['image_path']; ?>')">
                                <img src="uploads/<?php echo $galleryImg['image_path']; ?>" alt="Additional Thumb">
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <!-- Right Column: Product Info -->
            <div class="col-lg-7 ps-lg-5 reveal py-5">
                <span class="pd-category"><?php echo htmlspecialchars($product['brand_name'] ?? 'Premium Grade'); ?></span>
                <p style="font-size: 14px; color: #1A4329; font-weight: 600; margin-bottom: 20px;">
                    <i class="bi bi-shield-fill-check text-success me-1"></i> 100% Secure & Verified Supplier
                </p>
                <h2 class="pd-title"><?php echo htmlspecialchars($product['pro_name']); ?></h2>

                <div class="pd-overview">
                    <?php echo $product['short_desc']; ?>
                </div>

                <div class="pd-action-btns">
                    <a href="contact.php?product=<?php echo urlencode($product['pro_name']); ?>" class="btn-lg-quote shadow-sm">
                        Request a Quote <i class="bi bi-file-earmark-text-fill ms-2"></i>
                    </a>
                    <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $sitePhone); ?>" class="btn-lg-call">
                        <i class="bi bi-telephone-fill me-2"></i> Call for Enquiry
                    </a>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="row pd-tabs-section reveal">
            <div class="col-12">
                <ul class="nav nav-tabs custom-tabs" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab">Full Description</button>
                    </li>
                </ul>
                <div class="tab-content" id="productTabsContent">
                    <div class="tab-pane fade show active" id="desc" role="tabpanel">
                        <?php echo $product['description']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- RELATED PRODUCTS SECTION -->
<section class="related-products" style="padding: 60px 0 100px 0; background-color: #F8FAF8; border-top: 1px solid #EAEAEA;">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <h2 style="font-size: 2.2rem; font-weight: 800; color: #1A4329;">Explore Related Products</h2>
            <div style="width: 60px; height: 4px; background: #7CB342; margin: 15px auto; border-radius: 2px;"></div>
        </div>

        <div class="row g-4 reveal">
            <?php
            $relatedQuery = mysqli_query($conn, "SELECT * FROM products WHERE status = 1 AND id != '$product_id' ORDER BY RAND() LIMIT 4");
            while ($related = mysqli_fetch_assoc($relatedQuery)):
                $shortDesc = !empty($related['short_desc']) ? $related['short_desc'] : (!empty($related['meta_desc']) && $related['meta_desc'] != $related['pro_name'] ? $related['meta_desc'] : 'Premium quality export product sourced directly from sustainable farms.');
            ?>
                <div class="col-lg-3 col-md-6">
                    <div class="product-card h-100 d-flex flex-column shadow-sm border rounded-4 overflow-hidden" style="background: #ffffff; transition: all 0.3s ease;">
                        <a href="product-details.php?slug=<?php echo $related['slug_url']; ?>" style="text-decoration:none;">
                            <div style="height: 220px; overflow: hidden; background: #F8FAF8; padding: 15px;">
                                <img src="admin/assets/img/uploads/<?php echo $related['pro_img']; ?>" style="width: 100%; height: 100%; object-fit: contain; transition: transform 0.5s ease;" alt="<?php echo htmlspecialchars($related['pro_name']); ?>" onerror="this.src='assets/images/logo/logo.png'" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                            </div>
                        </a>

                        <div style="padding: 20px; display: flex; flex-direction: column; flex-grow: 1;">
                            <h3 style="font-size: 1.15rem; font-weight: 800; margin-bottom: 10px;">
                                <a href="product-details.php?slug=<?php echo $related['slug_url']; ?>" style="color: #1A4329; text-decoration: none;">
                                    <?php echo htmlspecialchars($related['pro_name']); ?>
                                </a>
                            </h3>

                            <p class="text-muted mb-4" style="font-size: 0.9rem; line-height: 1.6; display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 3.2em;">
                                <?php echo htmlspecialchars(strip_tags($shortDesc)); ?>
                            </p>

                            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #EAEAEA; padding-top: 15px; margin-top: auto;">
                                <a href="product-details.php?slug=<?php echo $related['slug_url']; ?>" style="color: #1A4329; text-decoration: none; font-weight: 700; font-size: 13px; transition: color 0.3s;" onmouseover="this.style.color='#7CB342'" onmouseout="this.style.color='#1A4329'">
                                    View Details <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                                <a href="contact.php?product=<?php echo urlencode($related['pro_name']); ?>" class="btn-quote-full" style="background-color: #1A4329; color: white; padding: 8px 15px; border-radius: 6px; font-weight: 600; font-size: 12px; text-decoration: none; transition: 0.3s;">
                                    Request Quote
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<section class="inquiry-modern py-0">
</section>

<?php 
include ('includes/inquiry_form.php');
include 'includes/footer.php'; ?>

<script>
    function changeImage(element, imageSrc) {
        document.getElementById('mainImage').src = imageSrc;
        let thumbs = document.querySelectorAll('.pd-thumb');
        thumbs.forEach(thumb => thumb.classList.remove('active'));
        element.classList.add('active');
    }

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
