<!DOCTYPE html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>INTERNTIC</title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('welcome_page/assets/img/favicon.png')}}" />
  <!-- Place favicon.ico in the root directory -->

  <!-- ======== CSS here ======== -->
  <link rel="stylesheet" href="{{asset('welcome_page/assets/css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('welcome_page/assets/css/lineicons.css')}}" />
  <link rel="stylesheet" href="{{asset('welcome_page/assets/css/animate.css')}}" />
  <link rel="stylesheet" href="{{asset('welcome_page/assets/css/main.css')}}" />
</head>

<body>
  <!-- ======== preloader start ======== -->
  <div class="preloader">
    <div class="loader">
      <div class="spinner">
        <div class="spinner-container">
          <div class="spinner-rotator">
            <div class="spinner-left">
              <div class="spinner-circle"></div>
            </div>
            <div class="spinner-right">
              <div class="spinner-circle"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- preloader end -->

  <!-- ======== header start ======== -->
  <header class="header">
    <div class="navbar-area">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <nav class="navbar navbar-expand-lg">
              <a class="navbar-brand" href="index.html">
                <img src="{{asset('welcome_page/assets/img/logo/logo.svg')}}" alt="Logo" />
              </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                <ul id="nav" class="navbar-nav ms-auto">
                  <li class="nav-item">
                    <a class="page-scroll active" href="#home">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="page-scroll" href="#features">Features</a>
                  </li>
                  <li class="nav-item">
                    <a class="page-scroll" href="#about">About</a>
                  </li>

                  <li class="nav-item">
                    <a class="page-scroll" href="#why">Built with</a>
                  </li>
                  <li class="nav-item">
                    <a class="page-scroll" href="#pricing">Users</a>
                  </li>
                </ul>
              </div>
              <!-- navbar collapse -->
            </nav>
            <!-- navbar -->
          </div>
        </div>
        <!-- row -->
      </div>
      <!-- container -->
    </div>
    <!-- navbar area -->
  </header>
  <!-- ======== header end ======== -->

  <!-- ======== hero-section start ======== -->
  <section id="home" class="hero-section">
    <div class="container">
      <div class="row align-items-center position-relative">
        <div class="col-lg-6">
          <div class="hero-content">
            <h1 class="wow fadeInUp" data-wow-delay=".4s">
              INTERNTIC
            </h1>
            <p class="wow fadeInUp" data-wow-delay=".6s">
              Please, purchase full version to get all sections, features and
              permission to remove footer credit.
            </p>
            <a href="#pricing" class="main-btn border-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Login Now</a>
            <a href="#features" class="scroll-bottom">
              <i class="lni lni-arrow-down"></i></a>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="hero-img wow fadeInUp" data-wow-delay=".5s">
            <img src="{{asset('welcome_page/assets/img/hero/hero-img.png')}}" alt="" />
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ======== hero-section end ======== -->

  <!-- ======== feature-section start ======== -->
  <section id="features" class="feature-section pt-120">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-8 col-sm-10">
          <div class="single-feature">
            <div class="icon">
              <i class="lni lni-bootstrap"></i>
            </div>
            <div class="content">
              <h3>Bootstrap 5</h3>
              <p>
                Bootstrap 5 empowers web projects with responsive grids, CSS components, and JavaScript plugins. It
                enables stunning interfaces that adapt to any device, ensuring a seamless user experience.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-8 col-sm-10">
          <div class="single-feature">
            <div class="icon">
              <i class="lni lni-layout"></i>
            </div>
            <div class="content">
              <h3>Clean Design</h3>
              <p>
                Clean Design seamlessly blends simplicity and elegance, creating visually captivating projects that
                embody balance, order, and sophistication.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-8 col-sm-10">
          <div class="single-feature">
            <div class="icon">
              <i class="lni lni-coffee-cup"></i>
            </div>
            <div class="content">
              <h3>Easy to Use</h3>
              <p>

                Project Made Easy to Use revolutionizes project management with its intuitive interface and
                user-friendly features, empowering teams to collaborate seamlessly, plan effortlessly, and execute with
                maximum efficiency.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ======== feature-section end ======== -->
  <!-- ======== about2-section start ======== -->
  <section id="about" class="about-section pt-150">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-6 col-lg-6">
          <div class="about-content">
            <div class="section-title mb-30">
              <h2 class="mb-25 wow fadeInUp" data-wow-delay=".2s">
                Easy to Use with Tons of Awesome Features
              </h2>
              <p class="wow fadeInUp" data-wow-delay=".4s">
                Project Made Easy: A user-friendly platform with abundant features for seamless project management.
              </p>
            </div>
            <ul>
              <li>Quick Access</li>
              <li>Easily to Manage</li>
              <li>Many Features</li>
            </ul>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6 order-first order-lg-last">
          <div class="about-img-2">
            <img src="{{asset('welcome_page/assets/img/about/about-2.png')}}" alt="" class="w-100" />
            <img src="{{asset('welcome_page/assets/img/about/about-right-shape.svg')}}" alt="" class="shape shape-1" />
            <img src="{{asset('welcome_page/assets/img/about/right-dots.svg')}}" alt="" class="shape shape-2" />
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ======== about2-section end ======== -->

  <!-- ======== feature-section start ======== -->
  <section id="why" class="feature-extended-section pt-100">
    <div class="feature-extended-wrapper">
      <div class="container">
        <div class="row justify-content-center">
          <div class=" col-xl-7 col-lg-8 col-md-9">
            <div class="section-title text-center mb-60">
              <h2 class="mb-25 wow fadeInUp" data-wow-delay=".2s">
                Why Choose INTERNTIC
              </h2>
              <p class="wow fadeInUp" data-wow-delay=".4s">
                Choose our project for unmatched quality, innovation, and customer satisfaction. With a dedicated team
                and advanced technology, we deliver excellence that surpasses expectations. Trust in our track record,
                efficiency, and future-proof solutions to propel your business forward
              </p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6">
            <div class="single-feature-extended">
              <div class="icon">
                <i class="lni lni-display"></i>
              </div>
              <div class="content">
                <h3>Laravel Framework</h3>
                <p>
                  Laravel, a PHP framework, powers an impressive project, seamlessly blending functionality,
                  scalability, and user experience. With its elegant syntax, robust features, and efficient
                  architecture, the Laravel-based project delivers exceptional performance and a sleek design.
                </p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="single-feature-extended">
              <div class="icon">
                <i class="lni lni-grid-alt"></i>
              </div>
              <div class="content">
                <h3>Ready to Use</h3>
                <p>
                  Ready to use projects offer pre-built and customizable solutions, saving time and effort for
                  individuals and businesses. Their flexibility and versatility make them an efficient choice for quick
                  and effective implementation.
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="single-feature-extended">
              <div class="icon">
                <i class="lni lni-javascript"></i>
              </div>
              <div class="content">
                <h3>Vue JS</h3>
                <p>
                  Vue JS empowers developers to create dynamic web applications with ease. Its intuitive syntax and
                  component-based architecture enable the development of seamless user interfaces. With exceptional
                  performance and a smooth user experience, Vue JS brings ideas to life quickly and efficiently
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="single-feature-extended">
              <div class="icon">
                <i class="lni lni-layers"></i>
              </div>
              <div class="content">
                <h3>Multiple Users </h3>
                <p>
                  We collaborated with multiple users on a project, combining expertise and resources to achieve
                  exceptional results.
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="single-feature-extended">
              <div class="icon">
                <i class="lni lni-leaf"></i>
              </div>
              <div class="content">
                <h3>Awesome Design</h3>
                <p>
                  The Awesome Design project is a striking fusion of creativity and functionality, boasting a seamless
                  user experience and captivating aesthetics.
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="single-feature-extended">
              <div class="icon">
                <i class="lni lni-rocket"></i>
              </div>
              <div class="content">
                <h3>Highly Optimized</h3>
                <p>
                  a groundbreaking project that maximizes efficiency and performance through meticulous planning,
                  innovative problem-solving, and streamlined design
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ======== feature-section end ======== -->


  <section id="pricing" class="pricing-section pt-60 pb-120">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xxl-5 col-xl-6 col-lg-8 col-md-9">
          <div class="section-title text-center mb-35">
            <h2 class="mb-25 wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
              Choose a User
            </h2>
            <p class="wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
              Choose a User to Login With
            </p>
          </div>
        </div>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-month" role="tabpanel" aria-labelledby="pills-month-tab">
          <div class="row justify-content-center">
            <div class="col-xl-3 col-lg-6 col-md-8 col-sm-10">
              <div class="single-pricing">
                <div class="pricing-header">
                  <h3 class="price">Student Account</h3>
                </div>
                <div class="content">
                  <p>Discover and manage internships effortlessly! Our website streamlines the process of requesting
                    internships and helps you navigate your internship experience as a student. Join us today to unlock
                    exciting opportunities and gain valuable real-world experience.</p>
                </div>
                <div class="pricing-btn">
                  <a href="{{url('login/student')}}" class="main-btn btn-hover border-btn">Login</a>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-8 col-sm-10">
              <div class="single-pricing">
                <div class="pricing-header">
                  <h3 class="price">Departments Head Account</h3>
                </div>
                <div class="content">
                  <p>Effortlessly manage internships as a department head with our website! Streamline the process of overseeing internships within your department. Our platform provides you with powerful tools to handle applications, coordinate with interns, and track their progress. Join us now to efficiently manage internships and cultivate a thriving learning environment within your department.</p>
                </div>
                <div class="pricing-btn">
                  <a href="{{url('login/department_head')}}" class="main-btn btn-hover border-btn">Login</a>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-8 col-sm-10">
              <div class="single-pricing">
                <div class="pricing-header">
                  <h3 class="price">Internship Head Account</h3>
                </div>
                <div class="content">
                  <p>Simplify internship management with our website! As an internship manager,
                    our platform empowers you to efficiently oversee and coordinate
                    internship programs. Seamlessly handle applications, streamline communication with interns, and track their progress all in one place. Join us now to optimize your internship management process and ensure a successful experience for both interns and your organization.</p>
                </div>
                <div class="pricing-btn">
                  <a href="{{url('login/internship_responsible')}}" class="main-btn btn-hover border-btn">Login</a>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-8 col-sm-10">
              <div class="single-pricing">
                <div class="pricing-header">
                  <h3 class="price">Super Admin Account</h3>
                </div>
                <div class="content">
                  <p>Welcome to the Super Admin Dashboard! It's a centralized hub that gives administrators complete control and oversight. You can manage users, monitor system performance, and make data-driven decisions. Stay informed, resolve issues quickly,
                     and optimize efficiency with our user-friendly interface</p>
                </div>
                <div class="pricing-btn">
                  <a href="{{url('login/super_admin')}}" class="main-btn btn-hover border-btn">Login</a>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======== footer start ======== -->
  <footer class="footer">
    <div class="container">
      <div class="widget-wrapper">
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="footer-widget">
              <div class="logo mb-30">
                <a href="index.html">
                  <img src="{{asset('welcome_page/assets/img/logo/logo.svg')}}" alt="" />
                </a>
              </div>
              <p class="desc mb-30 text-white">
                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                dinonumy eirmod tempor invidunt.
              </p>
              <ul class="socials">
                <li>
                  <a href="jvascript:void(0)">
                    <i class="lni lni-facebook-filled"></i>
                  </a>
                </li>
                <li>
                  <a href="jvascript:void(0)">
                    <i class="lni lni-twitter-filled"></i>
                  </a>
                </li>
                <li>
                  <a href="jvascript:void(0)">
                    <i class="lni lni-instagram-filled"></i>
                  </a>
                </li>
                <li>
                  <a href="jvascript:void(0)">
                    <i class="lni lni-linkedin-original"></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>



          <div class="col-md-6 col-sm-12">
            <div class="footer-widget">
              <h3>Links</h3>
              <ul class="links">
                <li class="nav-item">
                  <a class="page-scroll active" href="#home">Home</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="#about">About</a>
                </li>

                <li class="nav-item">
                  <a class="page-scroll" href="#why">Built with</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="#pricing">Users</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- ======== footer end ======== -->

  <!-- ======== scroll-top ======== -->
  <a href="#" class="scroll-top btn-hover">
    <i class="lni lni-chevron-up"></i>
  </a>

  <!-- ======== JS here ======== -->
  <script src="{{asset('welcome_page/assets/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('welcome_page/assets/js/wow.min.js')}}"></script>
  <script src="{{asset('welcome_page/assets/js/main.js')}}"></script>
</body>

</html>