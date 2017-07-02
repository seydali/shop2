<?php
namespace frontend\controllers;
use  common\models\Feedback;
use common\models\Orders;
use common\models\Orders_links;
use common\models\User;
use frontend\models\Products;
use yii\web\Session;
use yii;
use common\models\LoginForm;
use yii\helpers\Url;
class FeedbackController extends \yii\web\Controller
{
    public function actionIndex()
    {


        /* Создаем экземпляр класса */
        $model = new Feedback();
        /* получаем данные из формы и запускаем функцию отправки contact, если все хорошо, выводим сообщение об удачной отправке сообщения на почту */
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['emailto'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
            /* иначе выводим форму обратной связи */
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }
    }
