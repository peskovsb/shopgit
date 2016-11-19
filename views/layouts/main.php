<?php

/* @var $this \yii\web\View */
/* @var $content string */

?>
<?php $this->beginContent('@app/views/layouts/layout.php'); ?>

    <div class="arriv">
        <div class="container">
            <div class="arriv-top">
                <div class="col-md-6 arriv-left">
                    <img src="images/1.jpg" class="img-responsive" alt="">
                    <div class="arriv-info">
                        <h3>NEW ARRIVALS</h3>
                        <p>REVIVE YOUR WARDROBE WITH CHIC KNITS</p>
                        <div class="crt-btn">
                            <a href="details.html">TAKE A LOOK</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 arriv-right">
                    <img src="images/2.jpg" class="img-responsive" alt="">
                    <div class="arriv-info">
                        <h3>TUXEDO</h3>
                        <p>REVIVE YOUR WARDROBE WITH CHIC KNITS</p>
                        <div class="crt-btn">
                            <a href="details.html">SHOP NOW</a>
                        </div>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
            <div class="arriv-bottm">
                <div class="col-md-8 arriv-left1">
                    <img src="images/3.jpg" class="img-responsive" alt="">
                    <div class="arriv-info1">
                        <h3>SWEATER</h3>
                        <p>REVIVE YOUR WARDROBE WITH CHIC KNITS</p>
                        <div class="crt-btn">
                            <a href="details.html">SHOP NOW</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 arriv-right1">
                    <img src="images/4.jpg" class="img-responsive" alt="">
                    <div class="arriv-info2">
                        <a href="details.html"><h3>Trekking Shoes<i class="ars"></i></h3></a>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
            <div class="arriv-las">
                <div class="col-md-4 arriv-left2">
                    <img src="images/5.jpg" class="img-responsive" alt="">
                    <div class="arriv-info2">
                        <a href="details.html"><h3>Casual Glasses<i class="ars"></i></h3></a>
                    </div>
                </div>
                <div class="col-md-4 arriv-middle">
                    <img src="images/6.jpg" class="img-responsive" alt="">
                    <div class="arriv-info3">
                        <h3>FRESH LOOK T-SHIRT</h3>
                        <div class="crt-btn">
                            <a href="details.html">SHOP NOW</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 arriv-right2">
                    <img src="images/7.jpg" class="img-responsive" alt="">
                    <div class="arriv-info2">
                        <a href="details.html"><h3>Elegant Watches<i class="ars"></i></h3></a>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
    <?= $content ?>

<?php $this->endContent() ?>
