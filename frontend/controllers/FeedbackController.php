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


       
        $model = new Feedback();
        
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['emailto'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
            
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }
    }
