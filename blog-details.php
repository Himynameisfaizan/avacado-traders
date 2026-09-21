<?php
include('config/connect.php');

$slug = isset($_GET['slug']) ? mysqli_real_escape_string($conn, $_GET['slug']) : '';
$blogQuery = mysqli_query($conn, "SELECT * FROM blogs WHERE slug = '$slug' AND status = 1");
$blog = mysqli_fetch_assoc($blogQuery);

if (!$blog) {
    echo "<script>window.location.href='blog.php';</script>";
    exit;
}

$pageTitle = $blog['title'];
$publishDate = date('F d, Y', strtotime($blog['created_at']));
$authorName = !empty($blog['author']) ? $blog['author'] : 'Admin Team';
$mainImage = !empty($blog['image']) ? 'admin/assets/img/uploads/blogs/' . $blog['image'] : 'https://images.unsplash.com/photo-1523049673857-eb18f1d7b578?q=80&w=1200';
$currentURL = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

include 'includes/header.php';
include 'includes/breadcrumb.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($blog['meta_title'] ?? $blog['title']); ?> | AK Avocado Traders</title>
    <meta name="description" content="<?= htmlspecialchars(strip_tags($blog['meta_desc'] ?? $blog['description'])); ?>">
    <meta name="keywords" content="<?= htmlspecialchars($blog['meta_key'] ?? ''); ?>">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "<?= htmlspecialchars($blog['title']); ?>",
  "image": "<?= $site; ?>/admin/assets/img/uploads/blogs/<?= htmlspecialchars($blog['image']); ?>",
  "author": {
    "@type": "Person",
    "name": "<?= htmlspecialchars($authorName); ?>"
  },
  "publisher": {
    "@type": "Organization",
    "name": "AK Avocado Traders",
    "logo": {
      "@type": "ImageObject",
      "url": "<?= $site; ?>/assets/images/logo/logo.png"
    }
  },
  "datePublished": "<?= htmlspecialchars($blog['created_at']); ?>",
  "description": "<?= htmlspecialchars(strip_tags(substr($blog['description'], 0, 150))); ?>"
}
</script>
</head>
<body>
    
<section class="single-blog-section">
    <div class="container">
        <div class="row">

            <!-- Main Content Area -->
            <div class="col-lg-8 pe-lg-5">
                <div class="blog-details-content">
                    <img src="<?php echo $mainImage; ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" onerror="this.src='https://images.unsplash.com/photo-1523049673857-eb18f1d7b578?q=80&w=1200'">

                    <div class="blog-meta-top">
                        <span><i class="bi bi-calendar-event"></i> <?php echo $publishDate; ?></span>
                        <span><i class="bi bi-person-circle"></i> By <?php echo $authorName; ?></span>
                        <span><i class="bi bi-folder-fill"></i> Industry News</span>
                    </div>

                    <h1><?php echo $blog['title']; ?></h1>

                    <div class="blog-description py-4">
                        <?php echo $blog['description']; ?>
                    </div>

                    <!-- Share Options -->
                    <div class="share-box">
                        <span>Share this insight:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($currentURL); ?>" target="_blank" class="share-btn bg-fb"><i class="bi bi-facebook"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($currentURL); ?>&text=<?php echo urlencode($blog['title']); ?>" target="_blank" class="share-btn bg-tw"><i class="bi bi-twitter-x"></i></a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($currentURL); ?>" target="_blank" class="share-btn bg-in"><i class="bi bi-linkedin"></i></a>
                        <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($blog['title'] . " " . $currentURL); ?>" target="_blank" class="share-btn bg-wa"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>

            <!-- Sidebar Area -->
            <div class="col-lg-4 mt-5 mt-lg-0">
                <div class="blog-sidebar">

                    <!-- Search Widget -->
                    <div class="sidebar-widget">
                        <h4 class="sidebar-title">Search</h4>
                        <form class="sidebar-search" action="blog.php" method="GET">
                            <input type="text" name="search" placeholder="Search insights...">
                            <button type="submit"><i class="bi bi-search"></i></button>
                        </form>
                    </div>

                    <!-- Categories Widget (Dynamic fallback to realistic options) -->
                    <div class="sidebar-widget">
                        <h4 class="sidebar-title">Categories</h4>
                        <ul class="sidebar-cats">
                            <li><a href="blog.php">Avocado Farming <span>(12)</span></a></li>
                            <li><a href="blog.php">Export Trends <span>(08)</span></a></li>
                            <li><a href="blog.php">Health Benefits <span>(15)</span></a></li>
                            <li><a href="blog.php">Sustainable Agriculture <span>(05)</span></a></li>
                            <li><a href="blog.php">Company News <span>(03)</span></a></li>
                        </ul>
                    </div>

                    <!-- Recent Posts Widget -->
                    <div class="sidebar-widget">
                        <h4 class="sidebar-title">Recent Posts</h4>
                        <?php
                        $recentQuery = mysqli_query($conn, "SELECT * FROM blogs WHERE status = 1 AND blog_id != '{$blog['blog_id']}' ORDER BY created_at DESC LIMIT 3");
                        if (mysqli_num_rows($recentQuery) > 0) {
                            while ($recentBlog = mysqli_fetch_assoc($recentQuery)):
                                $r_date = date('M d, Y', strtotime($recentBlog['created_at']));
                                $r_img = !empty($recentBlog['image']) ? 'admin/assets/img/uploads/blogs/' . $recentBlog['image'] : 'https://images.unsplash.com/photo-1601004890684-d8cbf643f5f2?q=80&w=200';
                        ?>
                                <div class="recent-post-item">
                                    <img src="<?php echo $r_img; ?>" alt="<?php echo htmlspecialchars($recentBlog['title']); ?>" onerror="this.src='https://images.unsplash.com/photo-1601004890684-d8cbf643f5f2?q=80&w=200'">
                                    <div class="recent-post-info">
                                        <h4><a href="blog-details.php?slug=<?php echo $recentBlog['slug']; ?>"><?php echo htmlspecialchars($recentBlog['title']); ?></a></h4>
                                        <span><?php echo $r_date; ?></span>
                                    </div>
                                </div>
                        <?php
                            endwhile;
                        } else {
                            echo "<p style='color: #666; font-size: 13px;'>No recent posts available.</p>";
                        }
                        ?>
                    </div>

                    <!-- CTA Widget -->
                    <div class="sidebar-widget text-center" style="background: linear-gradient(135deg, #1A4329 0%, #0E1F14 100%); color: white;">
                        <i class="bi bi-box-seam-fill" style="font-size: 45px; color: #7CB342; margin-bottom: 15px;"></i>
                        <h4 style="font-weight: 800; margin-bottom: 15px; color: white;">Looking for Premium Avocados?</h4>
                        <p style="font-size: 0.95rem; opacity: 0.9; margin-bottom: 25px; line-height: 1.6;">Get a free quotation for your international export requirements today.</p>
                        <a href="contact.php" class="btn-quote-full" style="background: #7CB342; color: white; padding: 12px 25px; border-radius: 30px; text-decoration: none; font-weight: 700; display: inline-block; transition: 0.3s;" onmouseover="this.style.background='#ffffff'; this.style.color='#1A4329';" onmouseout="this.style.background='#7CB342'; this.style.color='white';">Request Quote</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Elegant Contact Section (Optional, paste same as home if needed) -->

<?php 
include ('includes/inquiry_form.php');
include 'includes/footer.php'; ?>