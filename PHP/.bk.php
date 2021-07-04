<?php
$ret2 = $db->query($sql2);
?>
<div class="w3-content" style="max-width:1200px">
    <img class="mySlides" src="<?php $p1 = $ret2->fetchArray(SQLITE3_BOTH);
                                echo "../pacimage/" . $p1['image']; ?>" style="width:100%;display:none" alt="f1">
    <img class="mySlides" src="<?php $p2 = $ret2->fetchArray(SQLITE3_BOTH);
                                echo "../pacimage/" . $p2['image']; ?>" style="width:100%" alt="f2">
    <img class="mySlides" src="<?php $p3 = $ret2->fetchArray(SQLITE3_BOTH);
                                echo "../pacimage/" . $p3['image']; ?>" style="width:100%;display:none" alt="f3">
    <img class="mySlides" src="<?php $p4 = $ret2->fetchArray(SQLITE3_BOTH);
                                echo "../pacimage/" . $p4['image']; ?>" style="width:100%;display:none" alt="f4">

    <div class="w3-row-padding w3-section">
        <div class="w3-col s3">
            <img class="demo w3-opacity w3-hover-opacity-off" src="<?php echo "../pacimage/" . $p1['image']; ?>"
                style="width:100%;cursor:pointer" onclick="currentDiv(1)">
        </div>
        <div class="w3-col s3">
            <img class="demo w3-opacity w3-hover-opacity-off" src="<?php echo "../pacimage/" . $p2['image']; ?>"
                style="width:100%;cursor:pointer" onclick="currentDiv(2)">
        </div>
        <div class="w3-col s3">
            <img class="demo w3-opacity w3-hover-opacity-off" src="<?php echo "../pacimage/" . $p3['image']; ?>"
                style="width:100%;cursor:pointer" onclick="currentDiv(3)">
        </div>
        <div class="w3-col s3">
            <img class="demo w3-opacity w3-hover-opacity-off" src="<?php echo "../pacimage/" . $p4['image']; ?>"
                style="width:100%;cursor:pointer" onclick="currentDiv(4)">
        </div>
    </div>
</div>
</div>
</div>

<script>
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
        dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
    }
    x[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " w3-opacity-off";
}
</script>