<?php 
include("header.php");
require_once __DIR__ . "/config/db.php";

$dbGallery = [];
$pdo = getDBConnection();
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM projects_gallery ORDER BY display_order ASC, created_at DESC");
        $dbGallery = $stmt->fetchAll();
    } catch (Exception $e) {
        $dbGallery = [];
    }
}
?>

<!-- Main Wrapper-->
<main class="wrapper">
    <!-- Page Header -->
    <div class="wptb-page-heading breadcrumb-sec">
        <div class="wptb-item--inner" style="background-image: url('assets/img/mineshot/gallery/gallery (6).jpg');">
            <div class="wptb-item-layer wptb-item-layer-one">
                <img src="assets/img/more/circle.png" alt="img">
            </div>
            <h2 class="wptb-item--title ">Our Projects</h2>
        </div>
    </div>

    <!-- Our Services -->
    <section class="portfolio-page-section">
        <div class="container">
            <div class="wptb-project--inner">
                <div class="has-radius effect-tilt"> 

                    <div class="row">
                        <div class="grid-sizer"></div>

                        <?php if (!empty($dbGallery)): ?>
                            <?php foreach ($dbGallery as $item): ?>
                                <div class="col-lg-4">
                                    <div class="wptb-item--inner">
                                        <div class="wptb-item--image">
                                            <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['title'] ?: 'Mineshot Project') ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                        
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (2).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (3).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (1).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (9).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (10).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (12).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (30).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (31).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (13).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (6).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (1).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (4).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (3).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (4).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                        
                                                                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (2).jpg" alt="img">
                                </div>
                            </div>
                        </div>

                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (18).jpg" alt="img">
                                </div>
                            </div>
                        </div>

                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (24).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (29).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (27).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (23).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (19).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (20).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (5).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (14).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (13).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                                                                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (14).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (25).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (111).jpeg" alt="img">
                                </div>
                            </div>
                            </div>
                                                    <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (15).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (8).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (16).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (17).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (5).jpg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/gallery (77).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                        
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/new_images (3).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/new_images (4).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/new_images (5).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/new_images (6).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/new_images (7).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/new_images (9).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                                                                        <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/new_images (8).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                        
                                                <div class="col-lg-4">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/mineshot/gallery/new_images (2).jpeg" alt="img">
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include("footer.php") ?>