<?php
use  yii\web\View;
use kartik\rating\StarRating;
?>
<link rel="stylesheet" href="http://bootstraptema.ru/plugins/bootstrap/v3/3-3-6/bootstrap.css" />
<link rel="stylesheet" href="http://bootstraptema.ru/plugins/font-awesome/4-4-0/font-awesome.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css"/>
<script src="http://bootstraptema.ru/plugins/jquery/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>

<script>
    <?$js =
        <<< JS
        $(document).ready(function() {
                $("#news-slider1").owlCarousel({
            items:3,
            itemsDesktop:[1199,3],
            itemsDesktopSmall:[1000,2],
            itemsMobile:[650,1],
            pagination:false,
            navigationText:false,
            autoPlay:true
        });
    })
JS;
    $this->registerJs($js);
    ?>
</script>
<style>
    .post-slide{
        margin: 0 15px;
        border-bottom: 1px solid #dadada;
        box-shadow: 0 0 5px rgba(167, 197, 167, 0.8);
        transition: all 0.4s ease-in-out 0s;
    }
    .post-slide .post-img{
        position: relative;
        overflow: hidden;
    }
    .post-slide .post-img:before{
        content: "";
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, 0);
        transition: all 0.4s linear 0s;
    }
    .post-slide:hover .post-img:before{
        background: rgba(0, 0, 0, 0.6);
    }
    .post-slide .post-img img{
        width: 150px;
        height: 150px;
    }
    .post-slide .category {
        width: 20%;
        font-size: 12px;
        color: #fff;
        line-height: 11px;
        text-align: center;
        text-transform: capitalize;
        padding: 11px 0;
        background: #9B7DF5;
        position: absolute;
        bottom: 0;
        left: -50%;
        transition: all 0.5s ease-in-out 0s;
    }
    .post-slide:hover .category{
        left: 0;
    }
    .post-slide .post-review{
        padding: 25px 20px;
        background: #fff;
        position: relative;
    }
    .post-slide .post-title{
        margin: 0;
    }
    .post-slide .post-title a{
        display: inline-block;
        font-size: 16px;
        color: #9B7DF5;
        font-weight: bold;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 25px;
        transition: all 0.30s linear 0s;
    }
    .post-slide .post-title a:hover{
        text-decoration: none;
        color: #555;
    }
    .post-slide .post-description{
        font-size: 15px;
        color: #555;
        line-height: 26px;
    }
    .post-review .post-bar{
        margin-top: 20px;
    }
    .post-bar span{
        display: inline-block;
        font-size: 14px;
    }
    .post-bar span i{
        margin-right: 5px;
        color: #999;
    }
    .post-bar span a{
        color: #999;
        text-transform: uppercase;
    }
    .post-bar span a:hover{
        text-decoration: none;
        color: #9B7DF5;
    }
    .post-bar span.comments{
        float: right;
    }
    @media only screen and (max-width: 359px) {
        .post-slide .category{ font-size: 13px; }
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="news-slider1" class="owl-carousel">
                <?php
                foreach($coll as $val) {
                    ?>


                    <div class="post-slide">
                        <div class="post-img">
                            <a href="index.php?r=products/view&id=<?=$val['id']?>"><img
                                src="<?=str_replace('uploads','uploads/min/150',$val['path'])?>"
                                alt="Bootstrap Blocks Owl Carousel 2"/></a>
                            <div class="category"><?=$val['price'].' руб.'?></div>
                        </div>
                        <div class="post-review">
                            <h3 class="post-title"><a href="index.php?r=products/view&id=<?=$val['id']?>"><?=$val['name']?></a></h3>
                            <p class="post-description">
                                <?=mb_substr($val['description'], 0, mb_strpos($val['description'], '</p>'))?>
                            </p>
                            <div class="post-bar">
                                <?= StarRating::widget([

                                    'name' => 'rating_2',
                                    'value' => $val['rating'],
                                    'disabled' => true,
                                    'pluginOptions' => [
                                        'step' => 0.1,
                                        'theme' => 'krajee-uni',
                                        'filledStar' => '&#x2605;',
                                        'emptyStar' => '&#x2606;'

                                    ]
                                ]);?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div><!-- ./col-md-12 -->
    </div><!-- ./row -->
</div>