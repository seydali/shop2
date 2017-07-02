<?php
namespace frontend\controllers;
use common\models\Orders;
use common\models\Orders_links;
use common\models\User;
use frontend\models\Products;
use yii\web\Session;
use yii;
use common\models\LoginForm;
use yii\helpers\Url;
class SupportController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index', [

        ]);
    }
}