<?php

namespace backend\controllers;

use common\models\Orders_links;
use common\models\OrderStatuses;
use common\models\Products;
use Yii;
use common\models\Orders;
use common\models\OrdersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\filters\AccessControl;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [

                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Orders models.
     * @return mixed
     */

    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        /*
         return $this->render('view',array(
             'order'=>$orders,
         ));*/
        $orders = Orders::find()->where(['=', 'id', $id])->one();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'prodInfo' => $orders,
        ]);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'stats' => OrderStatuses::find()->all(),
            ]);
        }
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $orders = Orders::find()->where(['=', 'id', $id])->one();
        $link1 = Orders_links::find()->where(['=', 'id_order', $id])->one();
        if ($link1 == NULL) {
            $link1 = new Orders_links();
        }


        if (!empty(Yii::$app->request->post()["Orders_links"]['actionfield'])) {
            $actionfield = Yii::$app->request->post()["Orders_links"]['actionfield'];
            //var_dump(Yii::$app->request->post()["Orders_links"]['count']);
            //die();

            if ($actionfield == 'updorder') {
                //die('updorder');


                if ($model->load(Yii::$app->request->post())) {

                    if (!$model->validate()) {

                        die(var_dump($model->errors));
                    }
                    $model->save();
                    return $this->redirect(['update', 'id' => $model->id]);
                }
            } elseif ($actionfield == 'addproduct') {

                $prodId = Yii::$app->request->post()["Orders_links"]['id_product'];
                $link = Orders_links::find()->where(['AND', ['id_order' => $id], ['id_product' => $prodId]])->one();
                if ($link != NULL) {

                    $link->count = (int)$link->count + (int)Yii::$app->request->post()["Orders_links"]['count'];

                    $link->save();
                    return $this->redirect(['update', 'id' => $model->id]);
                }
                $model1 = new Orders_links();
                $model1->id_order = $id;
                $prod = Products::find()->where(['=', 'id', $prodId])->one();
                $model1->price = $prod->price;
                //$model1->count= //Yii::$app->request->post()["Orders_links"]['count'];
                if ($model1->load(Yii::$app->request->post())) {

                    if (!$model1->validate()) {

                        die(var_dump($model1->errors));
                    }

                    if ($model1->save())
                        return $this->redirect(['update', 'id' => $model->id]);
                }

            }
        }
        //  return $this->redirect(['view', 'id' => $model->id]);
        //die(var_dump($actionfield));
        return $this->render('update', [
            'model' => $model,
            'orders' => $orders,
            'link' => $link1,
            'allProd' => Products::find()->all(),
            'stats' => OrderStatuses::find()->all(),
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */

    public function actionDelete($id)
    {
        Orders_links::deleteAll(['id_order' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDellink($prodId, $orderId)
    {
        $model = $this->findModel($orderId);
        $orders = Orders::find()->where(['=', 'id', $orderId])->one();
        $link = Orders_links::find()->where(['=', 'id_order', $orderId])->one();
        if ($link == NULL) {
            $link = new Orders_links();
        }

        Orders_links::find()->where(['AND', ['id_order' => $orderId], ['id_product' => $prodId]])->one()->delete();
        //var_dump($x);

        return $this->redirect(['update', 'id' => $model->id]);

    }

    public function actionChangecount($prodId, $orderId, $sign)
    {
        $model = $this->findModel($orderId);
        $orders = Orders::find()->where(['=', 'id', $orderId])->one();
        $link = Orders_links::find()->where(['=', 'id_order', $orderId])->one();
        if ($link == NULL) {
            $link = new Orders_links();
        }

        $change = Orders_links::find()->where(['AND', ['id_order' => $orderId], ['id_product' => $prodId]])->one();
        if ($change == NULL) {
            return $this->redirect(['update', 'id' => $model->id]);
        };
        if ($sign == 'minus' && (int)$change->count > 1) {
            $change->count = (int)$change->count - 1;
            $change->save();
        } elseif ($sign == 'minus' && (int)$change->count == 1) {
            $change->delete();
        } elseif ($sign == 'plus') {
            $change->count = (int)$change->count + 1;
            $change->save();
        }
        return $this->redirect(['update', 'id' => $model->id]);
    }
}
