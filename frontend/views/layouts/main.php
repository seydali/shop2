<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);

$this->registerJsFile('js/basket.js',  ['position' => yii\web\View::POS_END,'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('js/counter.js',  ['position' => yii\web\View::POS_END,'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('js/jquery.validate.js', ['position' => yii\web\View::POS_END,'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('js/validator.js',  ['position' => yii\web\View::POS_END,'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js',  ['position' => yii\web\View::POS_END,'depends' => [\yii\web\JqueryAsset::className()]]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Главная', 'url' => ['/site/index']],
        ['label' => 'Каталог', 'url' => ['/products']],
        ['label' => 'Акции', 'url' => ['/shares']],



        "<li><a href='/index.php?r=basket' id='basket'>Корзина</a></li>",
    ];
    if (Yii::$app->user->id==1) {
        $menuItems[] =['label' => 'Панель администратора', 'url' => ['/me'],  'items' => [
            "<li><a href='http://bk.yii2.loc?r=orders'>Управление заказами</a></li>" ,
            "<li><a href='http://bk.yii2.loc?r=users/index'>Управление пользователями</a></li>" ,
            "<li><a href='http://bk.yii2.loc?r=manufacturers/index'>Список производителей</a></li>" ,
            "<li><a href='http://bk.yii2.loc?r=categories/index'>Список категорий</a></li>" ,
            "<li><a href='http://bk.yii2.loc?r=os'>Список ОС</a></li>" ,
            "<li><a href='http://bk.yii2.loc?r=shares/index'>Список акций</a></li>"

        ]];
    }

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => 'Личный кабинет', 'url' => ['/me'],  'items' => [
            ['label' => 'Мои заказы', 'url' => ['/myorders']],
        ]];
        $menuItems[] = ['label' => 'Помощь',
            'items' => [
                ['label' => 'Поддержка', 'url' => ['/support']] ,
                ['label' => 'Обратная cвязь', 'url' => ['/feedback']] ,
                ['label' => 'Оплата и доставка', 'url' => ['/paymentdel']] ,
            ]
        ];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

