<?php 
include("header.php");
require_once __DIR__ . "/config/db.php";

$homePortfolio = [];
$pdo = getDBConnection();
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM projects_gallery ORDER BY display_order ASC, created_at DESC LIMIT 9");
        $homePortfolio = $stmt->fetchAll();
    } catch (Exception $e) {
        $homePortfolio = [];
    }
}
?>

<!-- Main Wrapper-->
<main class="wrapper">
    <!-- Slider Section -->
    <section class="wptb-slider style2">
        <div class="swiper-container wptb-swiper-slider-two">
            <!-- swiper slides -->
            <div class="swiper-wrapper">
                <!-- Slide Item -->
                <div class="swiper-slide">
                    <div class="wptb-slider--item">
                        <div class="wptb-slider--image"
                            style="background-image: url('assets/img/mineshot/banner-1.jpg');">
                        </div>
                        <div class="wptb-slider--inner">
                            <!-- Layer Image -->
                            <div class="wptb-item-layer wptb-item-layer-one">
                                <img src="assets/img/slider/layer-3.png" alt="img">
                            </div>
                            <div class="wptb-heading">
                                <div class="wptb-item--inner">
                                    <h1 class="wptb-item--title">Production Hub</h1>
                                    <h6 class="wptb-item--subtitle">Creative Stories, Perfectly Made</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Slide Item -->

                <!-- Slide Item -->
                <div class="swiper-slide">
                    <div class="wptb-slider--item">
                        <div class="wptb-slider--image"
                            style="background-image: url('assets/img/mineshot/photography-men.jpg');">
                        </div>
                        <div class="wptb-slider--inner">
                            <!-- Layer Image -->
                            <div class="wptb-item-layer wptb-item-layer-one">
                                <img src="assets/img/slider/layer-3.png" alt="img">
                            </div>
                            <div class="wptb-heading">
                                <div class="wptb-item--inner">
                                    <h1 class="wptb-item--title">Commercial <br>Photography</h1>
                                    <h6 class="wptb-item--subtitle">Capturing Moments Beautifully</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Slide Item -->

                <!-- Slide Item -->
                <div class="swiper-slide">
                    <div class="wptb-slider--item">
                        <div class="wptb-slider--image"
                            style="background-image: url('assets/img/mineshot/banner-4.jpg');">
                        </div>
                        <div class="wptb-slider--inner">
                            <!-- Layer Image -->
                            <div class="wptb-item-layer wptb-item-layer-one">
                                <img src="assets/img/slider/layer-3.png" alt="img">
                            </div>
                            <div class="wptb-heading">
                                <div class="wptb-item--inner">
                                    <h1 class="wptb-item--title">Commercial <br>Videography</h1>
                                    <h6 class="wptb-item--subtitle">Cinematic Visuals That Inspire</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Slide Item -->


                <!-- Slide Item -->
                <div class="swiper-slide">
                    <div class="wptb-slider--item">
                        <div class="wptb-slider--image"
                            style="background-image: url('assets/img/mineshot/editing-slider.jpg');">
                        </div>
                        <div class="wptb-slider--inner">
                            <!-- Layer Image -->
                            <div class="wptb-item-layer wptb-item-layer-one">
                                <img src="assets/img/slider/layer-3.png" alt="img">
                            </div>
                            <div class="wptb-heading">
                                <div class="wptb-item--inner">
                                    <h1 class="wptb-item--title">Editing & CG</h1>
                                    <h6 class="wptb-item--subtitle">High Quality Post Production</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Slide Item -->


                <!-- Slide Item -->
                <div class="swiper-slide">
                    <div class="wptb-slider--item">
                        <div class="wptb-slider--image"
                            style="background-image: url('assets/img/mineshot/music-slider.jpg');">
                        </div>
                        <div class="wptb-slider--inner">
                            <!-- Layer Image -->
                            <div class="wptb-item-layer wptb-item-layer-one">
                                <img src="assets/img/slider/layer-3.png" alt="img">
                            </div>
                            <div class="wptb-heading">
                                <div class="wptb-item--inner">
                                    <h1 class="wptb-item--title">Music Works</h1>
                                    <h6 class="wptb-item--subtitle">Professional Audio Production</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Slide Item -->



            </div>
        </div>

        <!-- Bottom Pane -->
        <div class="wptb-bottom-pane justify-content-center">
            <!-- pagination dots -->
            <div class="wptb-swiper-dots style2">
                <div class="swiper-pagination"></div>
            </div>

            <!-- Swiper Navigation -->
            <div class="wptb-swiper-navigation style3">
                <div class="wptb-swiper-arrow swiper-button-prev"></div>
                <div class="wptb-swiper-arrow swiper-button-next"></div>
            </div>
        </div>

    </section>

    <!-- Services -->
    <section class="wptb-services-one" id="expertise" style="scroll-margin-top: 80px; padding-bottom: 30px !important;">
        <div class="wptb-item-layer wptb-item-layer-one both-version">
            <img src="assets/img/more/texture-2.png" alt="img">
            <img src="assets/img/more/texture-2-light.png" alt="img">
        </div>
        <div class="container">
            <div class="wptb-heading mb-0">
                <div class="wptb-item--inner">
                    <h6 class="wptb-item--subtitle">What We Do Best</h6>
                    <h1 class="wptb-item--title">Our Creative Expertise</h1>
                    <p class="wptb-item--description" style="max-width: 650px; font-size: 17px; line-height: 1.7;">We create high-quality photography and videography for
                        automotive brands, consumer products, and food businesses with creative concepts and
                        professional execution.</p>
                </div>
            </div>

            <!-- 
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 ps-0 wow fadeInLeft">
                    <div class="wptb-icon-box5 mb-3">
                        <div class="wptb-item--inner">
                            <div class="wptb-item--icon">
                                <img src="assets/img/mineshot/production.png" alt="img" class="default-icon">
                                <img src="assets/img/mineshot/production-light.png" alt="img" class="hover-icon">
                            </div>
                            <div class="wptb-item--holder">
                                <h4 class="wptb-item--title mb-0">Complete Production Hub Solutions</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 ps-0 wow fadeInLeft">
                    <div class="wptb-icon-box5 mb-3">
                        <div class="wptb-item--inner">
                            <div class="wptb-item--icon">
                                <img src="assets/img/mineshot/camera.png" alt="img" class="default-icon">
                                <img src="assets/img/mineshot/camera-light.png" alt="img" class="hover-icon">
                            </div>
                            <div class="wptb-item--holder">
                                <h4 class="wptb-item--title mb-0">Professional Commercial Photography</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 ps-0 wow fadeInLeft">
                    <div class="wptb-icon-box5 mb-3">
                        <div class="wptb-item--inner">
                            <div class="wptb-item--icon">
                                <img src="assets/img/mineshot/video.png" alt="img" class="default-icon">
                                <img src="assets/img/mineshot/video-light.png" alt="img" class="hover-icon">
                            </div>
                            <div class="wptb-item--holder">
                                <h4 class="wptb-item--title mb-0">High-Impact Commercial Videography</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            -->
        </div>
    </section>

    <!-- Our Portfolio -->
    <section class="wptb-project home-portfolio-section" id="projects" style="scroll-margin-top: 80px;">
        <div class="container">
            <div class="wptb-heading">
                <div class="wptb-item--inner text-center">
                    <h6 class="wptb-item--subtitle">Our Portfolio</h6>
                    <h1 class="wptb-item--title"> A Showcase of Our Creative Work</h1>
                </div>
            </div>

            <div class="effect-gradient has-radius">
                <div class="grid gutter-10 clearfix">
                    <div class="grid-sizer"></div>
                    <div class="row">
                        <?php if (!empty($homePortfolio)): ?>
                            <?php foreach ($homePortfolio as $idx => $item): 
                                if ($idx === 3 || $idx === 6) {
                                    $colClass = 'col-md-8';
                                } elseif ($idx === 7 || $idx === 8) {
                                    $colClass = 'col-md-6';
                                } else {
                                    $colClass = 'col-md-4';
                                }
                            ?>
                                <div class="grid-item <?= $colClass ?>">
                                    <div class="wptb-item--inner">
                                        <div class="wptb-item--image">
                                            <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['title'] ?: 'Mineshot Creative Work') ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Fallback 9 images -->
                            <div class="grid-item col-md-4">
                                <div class="wptb-item--inner">
                                    <div class="wptb-item--image">
                                        <img src="assets/img/mineshot/gallery/gallery (2).jpeg" alt="img">
                                    </div>
                                </div>
                            </div>

                            <div class="grid-item col-md-4">
                                <div class="wptb-item--inner">
                                    <div class="wptb-item--image">
                                        <img src="assets/img/mineshot/gallery/gallery (3).jpeg" alt="img">
                                    </div>
                                </div>
                            </div>

                            <div class="grid-item col-md-4">
                                <div class="wptb-item--inner">
                                    <div class="wptb-item--image">
                                        <img src="assets/img/mineshot/gallery/gallery (1).jpg" alt="img">
                                    </div>
                                </div>
                            </div>

                            <div class="grid-item col-md-8">
                                <div class="wptb-item--inner">
                                    <div class="wptb-item--image">
                                        <img src="assets/img/mineshot/gallery/gallery (9).jpeg" alt="img">
                                    </div>
                                </div>
                            </div>

                            <div class="grid-item col-md-4">
                                <div class="wptb-item--inner">
                                    <div class="wptb-item--image">
                                        <img src="assets/img/mineshot/gallery/gallery (10).jpeg" alt="img">
                                    </div>
                                </div>
                            </div>

                            <div class="grid-item col-md-4">
                                <div class="wptb-item--inner">
                                    <div class="wptb-item--image">
                                        <img src="assets/img/mineshot/gallery/gallery (11).jpg" alt="img">
                                    </div>
                                </div>
                            </div>

                            <div class="grid-item col-md-8">
                                <div class="wptb-item--inner">
                                    <div class="wptb-item--image">
                                        <img src="assets/img/mineshot/gallery/gallery (12).jpeg" alt="img">
                                    </div>
                                </div>
                            </div>

                            <div class="grid-item col-md-6">
                                <div class="wptb-item--inner">
                                    <div class="wptb-item--image">
                                        <img src="assets/img/mineshot/gallery/gallery (13).jpeg" alt="img">
                                    </div>
                                </div>
                            </div>

                            <div class="grid-item col-md-6">
                                <div class="wptb-item--inner">
                                    <div class="wptb-item--image">
                                        <img src="assets/img/mineshot/gallery/gallery (30).jpg" alt="img">
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="wptb-item--button text-center mt-5">
                <a class="btn btn-two text-uppercase" href="projects.php">
                    <span class="btn-wrap">
                        <span class="text-first">See All Projects</span>
                        <span class="text-second"> <i class="bi bi-arrow-up-right"></i> <i
                                class="bi bi-arrow-up-right"></i> </span>
                    </span>
                </a>
            </div>
        </div>
    </section>

    <!-- Text Marquee -->
    <div class="wptb-marquee">
        <div class="wptb-text-marquee1 wptb-slide-to-left">
            <div class="wptb-item--container">
                <div class="wptb-item--inner">
                    <h4 class="wptb-item--text">
                        <span class="wptb-text-backdrop">Mineshot</span>
                        <span class="wptb-item-layer both-version position-relative">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                        </span>
                    </h4>
                    <h4 class="wptb-item--text">
                        <span class="wptb-text-backdrop">Production</span>
                        <span class="wptb-item-layer both-version position-relative">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                        </span>
                    </h4>
                    <h4 class="wptb-item--text">
                        <span class="wptb-text-backdrop">Hub</span>
                        <span class="wptb-item-layer both-version position-relative">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                        </span>
                    </h4>
                </div>

                <div class="wptb-item--inner">
                    <h4 class="wptb-item--text">
                        <span class="wptb-text-backdrop">Mineshot</span>
                        <span class="wptb-item-layer both-version position-relative">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                        </span>
                    </h4>
                    <h4 class="wptb-item--text">
                        <span class="wptb-text-backdrop">Production</span>
                        <span class="wptb-item-layer both-version position-relative">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                        </span>
                    </h4>
                    <h4 class="wptb-item--text">
                        <span class="wptb-text-backdrop">Hub</span>
                        <span class="wptb-item-layer both-version position-relative">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                        </span>
                    </h4>
                </div>

                <div class="wptb-item--inner">
                    <h4 class="wptb-item--text">
                        <span class="wptb-text-backdrop">Mineshot</span>
                        <span class="wptb-item-layer both-version position-relative">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                        </span>
                    </h4>
                    <h4 class="wptb-item--text">
                        <span class="wptb-text-backdrop">Production</span>
                        <span class="wptb-item-layer both-version position-relative">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                        </span>
                    </h4>
                    <h4 class="wptb-item--text">
                        <span class="wptb-text-backdrop">Hub</span>
                        <span class="wptb-item-layer both-version position-relative">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                        </span>
                    </h4>
                </div>


                <div class="wptb-item--inner">
                    <h4 class="wptb-item--text">
                        <span class="wptb-text-backdrop">Mineshot</span>
                        <span class="wptb-item-layer both-version position-relative">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                        </span>
                    </h4>
                    <h4 class="wptb-item--text">
                        <span class="wptb-text-backdrop">Production</span>
                        <span class="wptb-item-layer both-version position-relative">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                        </span>
                    </h4>
                    <h4 class="wptb-item--text">
                        <span class="wptb-text-backdrop">Hub</span>
                        <span class="wptb-item-layer both-version position-relative">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                            <img src="assets/img/mineshot/mineshot-icon.png" alt="img">
                        </span>
                    </h4>
                </div>


            </div>
        </div>
    </div>

    <!-- Agency Experience / Why Choose Mineshot -->
    <section class="wptb-agency-experience bg-image pb-xl-0" id="services"
        style="background-image: url('assets/img/background/bg-13.jpg'); scroll-margin-top: 80px;">
        <div class="container">

            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="wptb-heading">
                        <div class="wptb-item--inner">
                            <h1 class="wptb-item--title lg mb-5">Why Choose <br> Mineshot<span class="text-outline">
                                    ?</span></h1>
                            <p class="wptb-item--description">Mineshot Production Hub specializes in commercial
                                photography and videography for automotive, consumer products, and the food
                                industry. From sleek cars and rugged bikes to everyday products and delicious
                                dishes, we create visually striking content that helps brands connect with their
                                audience and stand out in the market. Our team manages the complete production
                                process, from concept development to final delivery, ensuring a smooth and
                                professional experience for every client. </p>

                            <div class="wptb-agency-experience--item">
                                <span>10+</span> Years Experience
                            </div>
                        </div>

                        <div class="wptb-image-single d-none d-xl-block wow fadeInUp">
                            <div class="wptb-item--inner">
                                <div class="wptb-item--image">
                                    <img src="assets/img/more/3.png" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 ps-lg-5 mt-5">
                    <div class="wptb-counter1 style1 mr-bottom-100 wow skewIn">
                        <div class="wptb-item--inner">
                            <div class="wptb-item--holder d-flex align-items-center">
                                <div class="wptb-item--value"><span class="odometer" data-count="300"></span><span
                                        class="suffix">+</span></div>
                                <br>
                                <div class="wptb-item--text">Projects Completed</div>
                            </div>
                        </div>
                    </div>

                    <div class="wptb-counter1 style1 mr-bottom-100 wow skewIn">
                        <div class="wptb-item--inner">
                            <div class="wptb-item--holder d-flex align-items-center">
                                <div class="wptb-item--value"><span class="odometer" data-count="210"></span><span
                                        class="suffix">+</span></div>
                                <br>
                                <div class="wptb-item--text">Happy Clients</div>
                            </div>
                        </div>
                    </div>

                    <div class="wptb-counter1 style1 wow skewIn">
                        <div class="wptb-item--inner">
                            <div class="wptb-item--holder d-flex align-items-center">
                                <div class="wptb-item--value"><span class="odometer" data-count="50"></span><span
                                        class="suffix">+</span></div>
                                <br>
                                <div class="wptb-item--text">Brand Collaborations</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Mineshot -->
    <section class="wptb-about-two bg-transparent" id="about" style="scroll-margin-top: 80px; padding-top: 80px !important; padding-bottom: 110px !important;">
        <div class="container">
            <div class="wptb-heading">
                <div class="wptb-item--inner">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <h6 class="wptb-item--subtitle">Turning Ideas Into Powerful Visuals
                            </h6>
                            <h1 class="wptb-item--title">About <div style="color:#9C7F3C">Mineshot Production Hub</div>
                            </h1>
                        </div>
                        <div class="col-lg-5 text-lg-end">
                            <div class="wptb-item--button">
                                <a href="tel:919962222257" class="btn btn-two creative text-uppercase">
                                    <span class="btn-wrap">
                                        <span class="text-first">Book Now</span>
                                        <span class="text-second"><i class="bi bi-arrow-up-right"></i></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="wptb-image-single wow fadeInUp">
                        <div class="wptb-item--inner">
                            <div class="wptb-item--image position-relative">
                                <img src="assets/img/more/7.png" alt="img">

                                <div class="wptb-item--button round-button">
                                    <a class="btn btn-two" href="tel:919962222257">
                                        <span class="btn-wrap">
                                            <span class="text-first">Call Now</span>
                                            <span class="text-second"> <i class="bi bi-arrow-up-right"></i> <i
                                                    class="bi bi-arrow-up-right"></i> </span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="wptb-item-layer wptb-item-layer-one both-version">
                            <img src="assets/img/more/light-2.png" alt="img">
                            <img src="assets/img/more/light-2-light.png" alt="img">
                        </div>
                    </div>
                </div>

                <div class="col-md-6 ps-md-5 mt-4 mt-md-0">
                    <div class="wptb-about--text ps-md-5">
                        <h3>Visuals That Leave an Impression</h3>
                        <p class="wptb-about--text-one">Capturing moments with creativity and passion.
                            Turning every vision into a powerful visual story.</p>
                        <p>At Mineshot Production hub, based in Chennai, India, we specialize in bringing stories to
                            life through powerful visuals. As a full-service production company, we handle
                            end-to-end arrangements for filming and photographing commercial, ensuring every detail
                            is captured with precision and creativity. Whether it’s for advertisements, brochures,
                            or promotional campaigns, our team delivers striking imagery that highlights the beauty
                            and performance of vehicles.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Contact -->
    <section class="wptb-contact-form style1" id="contact" style="scroll-margin-top: 80px; padding-top: 70px !important;">
        <div class="wptb-item-layer both-version">
            <img src="assets/img/more/texture-2.png" alt="">
            <img src="assets/img/more/texture-2-light.png" alt="">
        </div>
        <div class="container">
            <div class="wptb-form--wrapper">
                <div class="wptb-heading">
                    <div class="wptb-item--inner text-center">
                        <h1 class="wptb-item--title"> Get In Touch</h1>
                        <div class="wptb-item--description">Let’s discuss your ideas and create something
                            extraordinary together. Reach out to our team today.</div>
                    </div>
                </div>

                <div class="row" id="enquiry_form">
                    <div class="col-lg-8 offset-lg-2">
                        <form class="wptb-form">
                            <div class="wptb-form--inner">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 mb-4">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Name*"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 mb-4">
                                        <div class="form-group">
                                            <input type="phone" name="phone" class="form-control"
                                                placeholder="Contact Number*" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 mb-4">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="E-mail*"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 mb-4">
                                        <div class="form-group">
                                            <input type="date" name="date" class="form-control" placeholder="Date*"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 mb-4">
                                        <div class="form-group">
                                            <input type="text" name="Address" class="form-control"
                                                placeholder="Address">
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12 mb-4">
                                        <div class="form-group">
                                            <textarea name="message" class="form-control"
                                                placeholder="Describe your Need"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12">
                                        <div class="wptb-item--button text-center">
                                            <button class="btn white-opacity creative text-uppercase" type="submit">
                                                <span class="btn-wrap">
                                                    <span class="text-first">Send Mail</span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="wptb-office-address mr-top-100">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="wptb-icon-box1 wow fadeInLeft">
                            <div class="wptb-item--inner flex-start">
                                <div class="wptb-item--icon"><i class="bi bi-envelope"></i></div>
                                <div class="wptb-item--holder">
                                    <h3 class="wptb-item--title">Mail Address</h3>
                                    <p class="wptb-item--description mb-1">
                                        <a href="mailto:simbhu@mineshot.in" style="color: inherit; text-decoration: none;">simbhu@mineshot.in</a>
                                    </p>
                                    <p class="wptb-item--description mb-2">
                                        <a href="mailto:mineshotproduction@gmail.com" style="color: inherit; text-decoration: none;">mineshotproduction@gmail.com</a>
                                    </p>
                                    <a href="mailto:simbhu@mineshot.in" class="wptb-item--link">Reach Us</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 px-md-5">
                        <div class="wptb-icon-box1 wow fadeInLeft">
                            <div class="wptb-item--inner flex-start">
                                <div class="wptb-item--icon"><i class="bi bi-phone"></i></div>
                                <div class="wptb-item--holder">
                                    <h3 class="wptb-item--title">Book Us</h3>
                                    <p class="wptb-item--description">+91 99622 22257</p>
                                    <a href="tel:919962222257" class="wptb-item--link">Call Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="wptb-icon-box1 wow fadeInLeft">
                            <div class="wptb-item--inner flex-start">
                                <div class="wptb-item--icon"><i class="bi bi-geo-alt"></i></div>
                                <div class="wptb-item--holder">
                                    <h3 class="wptb-item--title">Address</h3>
                                    <p class="wptb-item--description">
                                        <a href="https://maps.google.com/?q=No.35+4th+Cross+street,+Indranagar,+Adyar,+Chennai+600020" target="_blank" style="color: inherit;">
                                            No.35 4th Cross street, Indranagar, Adyar, Chennai 600020
                                        </a>
                                    </p>
                                    <a href="https://maps.google.com/?q=No.35+4th+Cross+street,+Indranagar,+Adyar,+Chennai+600020" target="_blank" class="wptb-item--link">View on Google Maps</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Instagram Section (Hidden)
    <div class="wptb-instagram--gallery top-footer-sec">
        <div class="wptb-item--inner d-flex align-items-center justify-content-center flex-wrap flex-md-nowrap">
            <div class="wptb-item">
                <div class="wptb-item--image">
                    <img src="assets/img/mineshot/gallery/gallery (19).jpg" alt="img">
                </div>
            </div>

            <div class="wptb-item">
                <div class="wptb-item--image">
                    <img src="assets/img/mineshot/gallery/gallery (122).jpg" alt="img">
                </div>
            </div>

            <div class="wptb-item">
                <div class="wptb-item--image">
                    <img src="assets/img/mineshot/gallery/gallery (77).jpeg" alt="img">
                </div>
            </div>

            <div class="wptb-item">
                <div class="wptb-item--image">
                    <img src="assets/img/mineshot/gallery/gallery (21).jpg" alt="img">
                </div>
            </div>

            <div class="wptb-item">
                <div class="wptb-item--image">
                    <img src="assets/img/mineshot/gallery/gallery (23).jpg" alt="img">
                </div>
            </div>
        </div>
        <div class="wptb-item--button">
            <a class="btn btn-two" href="https://www.instagram.com/mineshotproductionhub?utm_source=qr&stkn=MXRqMXVzNnQ5Z2c1OA==" target="_blank">
                <span class="btn-wrap">
                    <span class="text-first">Follow Us on Instagram</span>
                    <span class="text-second"> <i class="bi bi-instagram"></i> <i class="bi bi-instagram"></i>
                    </span>
                </span>
            </a>
        </div>
    </div>
    -->
</main>


<?php include("footer.php") ?>