<!DOCTYPE html>
<html lang="en">

<head>
    <title>indiXplore, let's travel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/3bd38c0192.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="../android-chrome-512x512.png" />
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>
    <!-- Navigation Bar -->
    <div>
        <div class="w3-bar w3-xxlarge nav">
            <a href="account.php" class="w3-bar-item w3-button w3-mobile w3-padding-16 join"><img
                    src="../android-chrome-192x192.png" alt="Home Logo" width="62"></a>
            <a href="../PHP/logout.php" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">Logout</a>
            <a href="../PHP/settings.php"
                class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">Account</a>
            <a href="#" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">Welcome
                <?php echo $_COOKIE["name"]; ?> </a>
        </div>
    </div>
    <!--Tabs-->
    <header class="w3-display-container w3-content w3-hide-small" style="max-width:1920px">
        <img class="w3-image" src="../taj3.jpg" alt="Taj" width="1920" height="900">
        <div class="w3-display-topmiddle">
            <h1>indiXplore</h1>
        </div>
        <div class="w3-display-bottommiddle w3-padding-150" style="width:50%">
            <div class="w3-bar tab-bar">
                <button class="w3-bar-item w3-button tablink package-txtcolor" onclick="openLink(event, 'Package');"><i
                        class="fas fa-map-marked w3-margin-right"></i>Packages</button>
                <!--<button class="w3-bar-item w3-button tablink package-txtcolor" onclick="openLink(event, 'Hotel');"><i
                        class="fa fa-bed w3-margin-right"></i>Hotels</button>-->
                <button class="w3-bar-item w3-button tablink package-txtcolor" onclick="openLink(event, 'Business');">
                    <i class="fas fa-business-time w3-margin-right"></i>Business</button>
            </div>

            <div id="Package" class="w3-container w3-padding-16 myLink package-tab">
                <h3 class="txt">Explore India through <span class="logo">indiXplore</span></h3>
                <p>Search through our curated selection of travel packages!</p>
                <div class="w3-row-padding" style="margin:0 -16px;">
                    <div class="w3-half">
                        <form action="search.php" method="POST">
                            <input class="w3-input w3-border" type="text" name="dest"
                                placeholder="Tell us your dream destinations">
                    </div>
                </div>
                <p><input type="submit" class="w3-button btn-color txt" value="Search for packages" name="search" /></p>
                </form>
            </div>

            <!-- <div id="Hotel" class="w3-container w3-padding-16 myLink package-tab">
                <h3 class="txt">Find the best hotels</h3>
                <p>Book a hotel with us and get the best fares and promotions. We know hotels - we know comfort.</p>
                <div class="w3-row-padding" style="margin:0 -16px;">
                    <div class="w3-half">
                        <form action="#">
                            <input class="w3-input w3-border" type="text" placeholder="Let's find somewhere to stay">
                    </div>
                </div>
                <p><button class="w3-button btn-color txt">Search for Hotels</button></p>
                </form>
            </div>-->
            <div id="Business" class="w3-container w3-padding-16 myLink package-tab">
                <h3 class="txt">List your business with us!</h3>
                <p>As the top provider of travel packages. we assure you that we will help your business grow!</p>
                <p style="line-height: 2.7;">Start by visiting our business site.</p>
                <p><a href="business.html"><button class="w3-button btn-color txt">Visit our business site</button></a>
                </p>
            </div>
        </div>
    </header>
    <!--Slideshow-->
    <div class="w3-container slideshow txt">
        <h2 class="w3-center txt">Most Popular Destinations Right Now</h2>
        <h6 class="w3-center txt">Check out these destinations, which our customers like visitng the most.</h6>
    </div>

    <div class="w3-content w3-display-container" style="max-width:1800px">
        <div style="width: 1800px; height: 500px; overflow: hidden">
            <img class="mySlides" alt="slide1" src="../manali2.jpg" style="width: 100%;" ;>
            <img class="mySlides" alt="slide2" src="../manali3.jpg" style="width:100%">
            <img class="mySlides" alt="slide3" src="../maha2.jpg" style="width:100%">
        </div>
        <div class="w3-center w3-container w3-section w3-large w3-text-white w3-display-bottommiddle"
            style="width:100%">
            <div class="w3-left w3-hover-text-red" onclick="plusDivs(-1)">&#10094;</div>
            <div class="w3-right w3-hover-text-red" onclick="plusDivs(1)">&#10095;</div>
            <span class="w3-badge demo w3-border w3-transparent w3-hover-red" onclick="currentDiv(1)"></span>
            <span class="w3-badge demo w3-border w3-transparent w3-hover-red" onclick="currentDiv(2)"></span>
            <span class="w3-badge demo w3-border w3-transparent w3-hover-red" onclick="currentDiv(3)"></span>
        </div>
    </div>
    <!--Promotions-->
    <div class="w3-content" style="max-width:1825px;">
        <!-- Good offers -->
        <div class="w3-container w3-margin-top w3-center" style="padding-top: 30px;">
            <h2 class="txt">Good Offers Right Now</h2>
            <h6 class="txt">Up to <strong>50%</strong> discount.</h6>
        </div>
        <div class="w3-row-padding w3-text-white w3-large">
            <div class="w3-half w3-margin-botton">
                <div class="w3-display-container hover01">
                    <a href="#">
                        <figure><img src="../goa.jpg" alt="Goa" style="width:100%"></figure>
                    </a>
                    <span class="w3-display-bottomleft w3-padding txt" style="font-size: x-large;">Goa</span>
                </div>
            </div>
            <div class="w3-half">
                <div class="w3-row-padding" style="margin:0 -16px">
                    <div class="w3-half w3-margin-bottom">
                        <div class="w3-display-container hover01">
                            <a href="#">
                                <figure><img src="../lagoon.png" alt="New York" style="width:100%"></figure>
                            </a>
                            <span class="w3-display-bottomleft w3-padding">Kerala</span>
                        </div>
                    </div>
                    <div class="w3-half w3-margin-bottom">
                        <div class="w3-display-container hover01">
                            <a href="#">
                                <figure><img src="../kashmir.png" alt="San Francisco" style="width:100%"></figure>
                            </a>
                            <span class="w3-display-bottomleft w3-padding">Jammu & Kashmir</span>
                        </div>
                    </div>
                </div>
                <div class="w3-row-padding" style="margin:0 -16px">
                    <div class="w3-half w3-margin-bottom">
                        <div class="w3-display-container hover01">
                            <a href="#">
                                <figure><img src="../kedarnath.png" alt="Pisa" style="width:100%"></figure>
                            </a>
                            <span class="w3-display-bottomleft w3-padding">Uttarakhand</span>
                        </div>
                    </div>
                    <div class="w3-half w3-margin-bottom">
                        <div class="w3-display-container hover01">
                            <a href="#">
                                <figure><img src="../hampi.png" alt="Paris" style="width:100%"></figure>
                            </a>
                            <span class="w3-display-bottomleft w3-padding">Karnataka</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Newsletter -->
        <div class="w3-container">
            <div class="w3-panel w3-padding-16 w3-black w3-card opacity-min w3-hover-opacity-off">
                <h2 class="txt">Get the best offers first!</h2>
                <p class="txt">Join our newsletter. Get notified of exciting deals.</p>
                <input class="w3-input w3-border txt" type="text" placeholder="Your Email address">
                <button type="button" class="w3-button w3-margin-top btn-color txt">Subscribe</button>
            </div>
        </div>
        <!-- Contact -->
        <div class="w3-container txt">
            <h2 class="txt">Get in touch with us! </h2>
            <p>Let us book your next trip!</p>
            <i class="fa fa-map-marker" style="width:30px"></i> Burdwan 713101, WB, India<br>
            <i class="fa fa-phone" style="width:30px"></i> Phone: +91 8759582904<br>
            <i class="fa fa-envelope" style="width:30px"> </i> Email: indiXplore@yahoo.com<br>
            <form action="/action_page.php" target="_blank">
                <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Name" required name="Name">
                </p>
                <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Email" required
                        name="Email"></p>
                <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Message" required
                        name="Message"></p>
                <p><button class="w3-button w3-padding-large txt btn-color" type="submit">SEND A
                        MESSAGE</button></p>

            </form>
        </div>

        <!-- End page content -->
    </div>

    <!-- Footer -->
    <footer class="w3-container w3-center w3-opacity nav">
        <h5>Find Us On</h5>
        <div class="w3-xlarge w3-padding-large">
            <i class="fa fa-facebook-official w3-hover-opacity"></i>
            <i class="fa fa-instagram w3-hover-opacity"></i>
            <i class="fa fa-snapchat w3-hover-opacity"></i>
            <i class="fa fa-pinterest-p w3-hover-opacity"></i>
            <i class="fa fa-twitter w3-hover-opacity"></i>
            <i class="fa fa-linkedin w3-hover-opacity"></i>
        </div>
    </footer>
    <script>
    // Tabs
    function openLink(evt, linkName) {
        var i, x, tablinks;
        x = document.getElementsByClassName("myLink");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < x.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" package-color", "");
        }
        document.getElementById(linkName).style.display = "block";
        evt.currentTarget.className += " package-color";
    }

    // Click on the first tablink on load
    document.getElementsByClassName("tablink")[0].click();
    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
        showDivs(slideIndex += n);
    }

    function currentDiv(n) {
        showDivs(slideIndex = n);
    }

    function showDivs(n) {
        var i;
        var x = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("demo");
        if (n > x.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = x.length
        }
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" w3-white", "");
        }
        x[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " w3-white";
    }
    </script>
</body>

</html>