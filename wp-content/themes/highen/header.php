<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage highen
 * @since Highen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="google-site-verification" content="AsWioKWO8lruiTMX2XbqLujfSv3NhvJH5QbRyBVFpDE" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="https://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">

<!-- <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon"> -->
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js?ver=3.7.0" type="text/javascript"></script>
<![endif]-->

   <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-211174623-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-211174623-1');
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WCRMW3Q');</script>
<!-- End Google Tag Manager -->
<?php wp_head(); ?>


</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>
<!-- //Schema Code Here -->
<script type="application/ld+json">
   {
   "@context": "http://schema.org/",
   "@type": "Organization",
   "legalName": "Highen Fintech",
   "url": "https://www.highenfintech.com",
   "contactPoint": {
   "@type": "ContactPoint",
   "telephone": "+1 3152150321",
   "contactType": "Local Business"
   },
   "logo": "https://www.highenfintech.com/wp-content/uploads/2021/10/cropped-fhlogo.png", 
   "sameAs": [
   "https://www.facebook.com/highenfintech",
   "https://www.linkedin.com/company/highenfintech",
   "https://twitter.com/HighenF",
   "https://www.instagram.com/highenfintech"
   ],
   "address": {
   "@type": "PostalAddress",
   "streetAddress": "600 Parkview Drive, 204 Apt, Santa Clara, California, USA",
   "addressLocality": "Santa Clara",
        "postalCode": "94022",
   "addressRegion": "California",
   "addressCountry": "USA"
   } 
   }, 
"aggregateRating": {
   "@type": "AggregateRating",
   "bestRating": "5",
   "ratingValue": "4.8",
   "reviewCount": "47"
   },
   "review": {
   "author": "Federico",
   "reviewRating": {
   "@type": "Rating",
   "bestRating": "5",
   "ratingValue": "5",
   }
   }
{
   "@context": "http://schema.org/", 
   "@type": "WebSite", 
   "name": "Highen Fintech",
   "alternateName": "highenfintech", 
   "url": "https://www.highenfintech.com"
        }
   }
   
{
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Corporation",
  "name": "Highen Fintech",
  "alternateName": "highenfintech",
  "url": "https://www.highenfintech.com/",
  "logo": "https://www.highenfintech.com/wp-content/uploads/2021/10/cropped-fhlogo.png",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+1 3152150321",
    "contactType": "customer service",
    "areaServed": "US",
    "availableLanguage": "en"
  },
  "sameAs": [
    "https://www.facebook.com/highenfintech",
    "https://twitter.com/HighenF",
    "https://www.instagram.com/highenfintech",
    "https://www.linkedin.com/company/highenfintech",
    "https://www.highenfintech.com"
  ]
}
</script>
<!-- //Schema Code Here -->

<!-- Preloader Start -->
   <!-- <div class="se-pre-con"></div> -->
   <!-- Preloader Ends -->


   <!--------------------------------- Header============================================= -->
   <header id="home">
      <div class="container">
         <div class="row">
            <!-- Start Navigation -->
            <nav id="mainNav"
               class="navbar navbar-default navbar-fixed white bootsnav on no-full nav-box no-background desktop-menu">
               <div class="container">
                  <!-- Start Header Navigation -->
                  <div class="navbar-header ">
                     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <i class="fa fa-bars"></i>
                     </button>
                     <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php
                        $header_image = get_header_image();
                        if ( ! empty( $header_image ) ) :
                           ?>
                        <img src="<?php echo esc_url( $header_image ); ?>" class="logo" alt="Highen" />
                        <?php endif; ?>
                        <!-- <img src="<?php //echo get_template_directory_uri();?>/img/fhlogo.png" > -->
                     </a>
                  </div>
                  <!-- End Header Navigation -->
                  <div class="attr-nav" onclick="open_side()">
                     <ul>
                        <li class="side-menu"><a href="#"><i class="fa fa-bars"></i></a></li>
                     </ul>
                  </div>
                  <!-- Collect the nav links, forms, and other content for toggling -->
                  <div class="collapse navbar-collapse">
                     <!-- <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#" style="display: none;">
                        
                        <li>
                           <a class="smooth-menu btn-top" href="contact.html">Get in touch</a>
                        </li>
                     </ul> -->

                     <!-- <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#">
                        <?php 
                        $menu_button = get_field('menu_button');
                        ?>
                        <li>
                           <a class="smooth-menu btn-top" href="<?php echo $menu_button['url'];?>">Get in touch</a>
                        </li>
                     </ul> -->
                     <?php wp_nav_menu( array(
                           'theme_location'    => 'primary_menu',
                           'container'         => 'ul',
                           'menu_class'        => 'nav navbar-nav navbar-right',
                           'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                           'walker'            => new WP_Bootstrap_Navwalker() )
                       );
                     // customerid();
                       ?>


                  </div>
                  <!-- /.navbar-collapse -->
               </div>
               <!-- Start Side Menu -->
               <div class="side">
                  <a href="#" class="close-side  overlay" onclick="close_side()"><i class="fa fa-times"></i></a>
                  <div class="widget">
                     <!-- <ul class="link">
                        <li><a href="about-us.html">About us</a></li>
                        <li><a href="achievement.html">Achievement</a></li>
                        <li><a href="blog-grid.html">Blog</a></li>
                        <li><a href="case-study.html">Case Study</a></li>
                     </ul> -->
                      <?php wp_nav_menu( array(
                           'theme_location'    => 'side_menu',
                           'depth'             => 2,
                           'container'         => 'ul',
                           'menu_class'        => 'link' 
                        ) );
                       ?>
                  </div>
               </div>
               <!-- End Side Menu -->
            </nav>
            <!-- End Navigation -->
            <div class="mobile-menu">
               <nav id="mainNav"
                  class="navbar navbar-default navbar-fixed white bootsnav on no-full nav-box no-background">
                  <div class="navbar-header">
                     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <i class="fa fa-bars"></i>
                     </button>
                     <!-- <a class="navbar-brand" href="index.html">
                        <img src="<?php echo get_template_directory_uri();?>/img/fhlogo.png" class="logo" alt="Logo">
                     </a> -->
                     <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php
                        $header_image = get_header_image();
                        if ( ! empty( $header_image ) ) :
                           ?>
                        <img src="<?php echo esc_url( $header_image ); ?>" class="logo" alt="Highen" />
                        <?php endif; ?>
                        <!-- <img src="<?php //echo get_template_directory_uri();?>/img/fhlogo.png" > -->
                     </a>
                  </div>
                  <div class="navbar-collapse collapse" id="navbar-menu">
                     <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#" style="display: none;">
                        <li class="dropdown dropdown-right">
                           <a href="index.html" class="dropdown-toggle smooth-menu" data-toggle="dropdown">Fintech
                              Solutions</a>
                           <ul class="dropdown-menu animated #" style="display: none; opacity: 1;">
                              <li><a href="fintech-solutions.html">Lending</a></li>
                              <li><a href="fintech-solutions.html">Digital Wallet</a></li>
                              <li><a href="fintech-solutions.html">E-Billing & Payment</a></li>
                              <li><a href="fintech-solutions.html">Trading Platform</a></li>
                              <li><a href="fintech-solutions.html">Blockchain-Based FinTech</a></li>
                              <li><a href="fintech-solutions.html">Cryptocurrency Software</a></li>
                           </ul>
                        </li>

                        <li class="dropdown dropdown-right">
                           <a href="#" class="dropdown-toggle smooth-menu" data-toggle="dropdown">Services</a>
                           <ul class="dropdown-menu animated #" style="display: none; opacity: 1;">
                              <li><a href="services.html">Mobile app development</a></li>
                              <li><a href="services.html">Web development</a></li>
                              <li><a href="services.html">Custom software development</a></li>
                              <li><a href="services.html">MVP development</a></li>
                              <li><a href="services.html">UI/UX Design & Development</a></li>
                              <li><a href="services.html">Team Augmentation </a></li>
                           </ul>
                        </li>
                        <li>
                           <a href="about-us.html">About us</a>
                        </li>
                        <li>
                           <a href="achievement.html">Achievement</a>
                        </li>
                        <li>
                           <a href="blog-grid.html">Blog</a>
                        </li>
                        <li>
                           <a href="case-study.html">Case Study</a>
                        </li>
                        <li>
                           <a class="smooth-menu btn-top" href="contact.html">Get in touch</a>
                        </li>
                     </ul>


                     <?php wp_nav_menu( array(
                           'theme_location'    => 'primary_menu',
                           'depth'             => 2,
                           'container'         => 'ul',
                           'menu_class'        => 'nav navbar-nav navbar-right',
                           'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                           'walker'            => new WP_Bootstrap_Navwalker() )
                       );
                       ?>
                  </div>
               </nav>
            </div>
            <div class="clearfix"></div>
         </div>
      </div>
   </header>
   <!-- End Header -->