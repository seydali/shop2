<?php

namespace frontend\controllers;

use common\models\Categories;
use common\models\Manufacturers;
use common\models\Os;
use common\models\Rating;
use Yii;
use common\models\Products;
use common\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Shares;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //die(var_dump($dataProvider));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allCatNames' => Categories::find()->all(),
            'allManNames' => Manufacturers::find()->all(),
            'allOsNames' => Os::find()->all(),
            'allShares' => Shares::find()->all()
        ]);
    }

    public function actionSetrating($rating, $prod)
    {
        $ratDb = Rating::find()->where(['AND', ['=', 'id_user', (int)Yii::$app->user->id], ['=', 'id_product', (int)$prod]])->one();
        if ($ratDb == NULL) {
            $ratDb = new Rating();
            $ratDb->id_user = (int)Yii::$app->user->id;
            $ratDb->id_product = (int)$prod;
            $ratDb->rating = $rating;
        } else {
            $ratDb->rating = $rating;
        }
        $ratDb->save();

    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $rating = Rating::find()->where(['AND', ['=', 'id_product', $id], ['=', 'id_user', Yii::$app->user->id]])->one();
        if ($rating == NULL) {
            $rating = new Rating();
        }
        //var_dump($rating->id_user);
        //die;

        return $this->render('view', [
            'model' => $this->findModel($id),
            'rating' => $rating,

        ]);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Products();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

}
