<!doctype html>
<html class="no-js" lang="zxx">

<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Montana</title>
   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- <link rel="manifest" href="site.webmanifest"> -->
   <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
   <!-- Place favicon.ico in the root directory -->

   <!-- CSS here -->
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <link rel="stylesheet" href="css/owl.carousel.min.css">
   <link rel="stylesheet" href="css/magnific-popup.css">
   <link rel="stylesheet" href="css/font-awesome.min.css">
   <link rel="stylesheet" href="css/themify-icons.css">
   <link rel="stylesheet" href="css/nice-select.css">
   <link rel="stylesheet" href="css/flaticon.css">
   <link rel="stylesheet" href="css/gijgo.css">
   <link rel="stylesheet" href="css/animate.css">
   <link rel="stylesheet" href="css/slicknav.css">
   <link rel="stylesheet" href="css/style.css">
   <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>

<body>
   <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->
    <header>
        @include('home.header')
    </header>
  <!-- header-end -->

  <!-- bradcam_area_start -->
  <div class="bradcam_area breadcam_bg">
      <h3>Review</h3>
  </div>
  <!-- bradcam_area_end -->

   <!--================Blog Area =================-->
   <section class="blog_area single-post-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 posts-list">
                    <div class="single-post">
                        <div class="blog_details">
                            <h2>Room Review</h2>
                            <!-- Filter Form -->
                            <form action="{{ route('reviews.filter') }}" method="GET">
                            @CSRF
                                <div class="form-group">      
                                    <label for="roomType">Select Room Type:</label>
                                    <select name="roomType" id="roomType" class="form-control">
                                        <option value="">Select Room Type</option>
                                        @foreach($roomTypes as $roomType)
                                        <option value="{{ $roomType }}">{{ ucfirst($roomType) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="rate">Select Rate:</label>
                                    <select name="rate" id="rate" class="form-control">
                                        <option value="">Select Rate</option>
                                        @foreach($rates as $rate)
                                        <option value="{{ $rate }}">{{ $rate }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </form>  
                            @foreach($reviews as $review)
                            <div class="quote-wrapper">
                                <div class="quotes">
                                    <h2>Room Type: {{ optional($review->room)->roomType }}</h2>
                                    <h2>Rate : {{ $review->rate }} Star</h2>
                                    <h4>Comment: {{ $review->comment }} </h4>
                                    <p>Create at: {{ $review->created_at }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="blog_details">
                            <h2>Hotel Review</h2>
                            @foreach($reviewData as $reviewH)
                            <div class="quote-wrapper">
                                <div class="quotes">
                                    <h2>Rate : {{ $reviewH['rate'] }} Star</h2>
                                    <h4>Comment: {{ $reviewH['comment'] }} </h4>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   <!--================ Blog Area end =================-->

    <!-- footer -->
    @include("home.footer")
  <!-- footer_end -->


   <!-- JS here -->
   <script src="js/vendor/modernizr-3.5.0.min.js"></script>
   <script src="js/vendor/jquery-1.12.4.min.js"></script>
   <script src="js/popper.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/owl.carousel.min.js"></script>
   <script src="js/isotope.pkgd.min.js"></script>
   <script src="js/ajax-form.js"></script>
   <script src="js/waypoints.min.js"></script>
   <script src="js/jquery.counterup.min.js"></script>
   <script src="js/imagesloaded.pkgd.min.js"></script>
   <script src="js/scrollIt.js"></script>
   <script src="js/jquery.scrollUp.min.js"></script>
   <script src="js/wow.min.js"></script>
   <script src="js/nice-select.min.js"></script>
   <script src="js/jquery.slicknav.min.js"></script>
   <script src="js/jquery.magnific-popup.min.js"></script>
   <script src="js/plugins.js"></script>
   <script src="js/gijgo.min.js"></script>

   <!--contact js-->
   <script src="js/contact.js"></script>
   <script src="js/jquery.ajaxchimp.min.js"></script>
   <script src="js/jquery.form.js"></script>
   <script src="js/jquery.validate.min.js"></script>
   <script src="js/mail-script.js"></script>

   <script src="js/main.js"></script>



</body>

</html>