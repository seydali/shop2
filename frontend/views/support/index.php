<?php
use yii\bootstrap\Modal;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<?php
echo '<h4>1. Как искать товар?</h4>';
Modal::begin([
    'header' => '<h4>1. Как искать товар?</h4>',
    'toggleButton' => [
        'label' => 'Ответ',
        'tag' => 'button',
        'class' => 'btn btn-danger'
    ],
]);
?>
    Для поиска товара введите название искомого товара
    в поле "Поиск" на странице <a href="/index.php?r=products">каталога</a>
<?php
Modal::end();
echo '<h4>2. Как я могу проверить статус заказа?</h4>';
Modal::begin([
    'header' => '<h4>1. Как искать товар?</h4>',
    'toggleButton' => [
        'label' => 'Ответ',
        'tag' => 'button',
        'class' => 'btn btn-danger'
    ],
]);
?>
    Полная информация о заказе находится по ссылке <a href="/index.php?r=myorders">Мои заказы</a>
    Для доступа необходимо авторизоваться на сайте.
<?php
Modal::end();