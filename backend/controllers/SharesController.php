<?php

namespace backend\controllers;

use common\models\Products;
use common\models\SharesLinks;
use Yii;
use common\models\Shares;
use common\models\SharesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Images;

/**
 * SharesController implements the CRUD actions for Shares model.
 */
class SharesController extends Controller
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
     * Lists all Shares models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SharesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        Shares::clearOlderRows();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Shares model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Shares model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shares the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shares::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Shares model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Shares();
        $sharesLinks = new SharesLinks();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $files = UploadedFile::getInstance($model, 'iconim');
            if (sizeof($files) > 0) {
                $i = 0;

                $name = Yii::$app->user->id . '-' . date('Y-m-d-H-i-s') . $i++;
                $path = Yii::getAlias('@frontend/web/uploads/icons/') . $name . '.' . $files->extension;
                $files->saveAs($path);
                Images::iconResize($path, 40);
                //Images::imgResize($path, 150);
                $path = str_replace(Yii::getAlias('@frontend/web/'), '', $path);
                $img = $model->AddImage($path);
                $model->icon = (string)$img;
            }
            // die(var_dump($model));
            // $model->save();

            if ($sharesLinks->load(Yii::$app->request->post()))

                if (is_array($sharesLinks->id_product))
                    foreach ($sharesLinks->id_product as $prod_id) {
                        $sharesLinks = new SharesLinks();
                        $sharesLinks->id_share = $model->id;
                        $sharesLinks->id_product = $prod_id;

                        if ($sharesLinks->validate()) {
                            $sharesLinks->save();
                        }
                    }

            if ($model->save()) {
                $allLinks = SharesLinks::find()->where(['=', 'id_share', $model->id])->all();
                foreach ($allLinks as $link) {
                    if (!empty($model->discount) && $model->discount != null) {
                        $prod = Products::find()->where(['=', 'id', $link->id_product])->one();
                        if ($prod != null) {
                            if ($prod->oldprice == NULL) {
                                $prod->oldprice = $prod->price;
                            }

                            $prod->price = $prod->oldprice * (1 - ($model->discount * 0.01));
                            $prod->save();
                        }
                    }
                }

            }

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'sharesLinks' => new SharesLinks(),

                'prods' => Products::find()->all(),

            ]);
        }
    }

    /**
     * Updates an existing Shares model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $sharesLinks = new SharesLinks();
        $icon = Images::find()->where(['=', 'id', $model->icon])->one();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $files = UploadedFile::getInstance($model, 'iconim');
            if (sizeof($files) > 0) {
                $i = 0;

                $name = Yii::$app->user->id . '-' . date('Y-m-d-H-i-s') . $i++;
                $path = Yii::getAlias('@frontend/web/uploads/icons/') . $name . '.' . $files->extension;
                $files->saveAs($path);
                Images::iconResize($path, 40);
                //Images::imgResize($path, 150);
                $path = str_replace(Yii::getAlias('@frontend/web/'), '', $path);
                $img = $model->AddImage($path);
                $model->icon = (string)$img;
            }
            // die(var_dump($model));

            // $model->save();
            if ($model->save()) {


                if ($sharesLinks->load(Yii::$app->request->post()))

                    if (is_array($sharesLinks->id_product))
                        foreach ($sharesLinks->id_product as $prod_id) {
                            $sharesLinks = new SharesLinks();
                            $sharesLinks->id_share = $model->id;
                            $sharesLinks->id_product = $prod_id;

                            if ($sharesLinks->validate()) {
                                $sharesLinks->save();
                            }
                        }

                if ($model->save()) {
                    $allLinks = SharesLinks::find()->where(['=', 'id_share', $model->id])->all();
                    foreach ($allLinks as $link) {
                        if (!empty($model->discount) && $model->discount != null) {
                            $prod = Products::find()->where(['=', 'id', $link->id_product])->one();
                            if ($prod != null) {
                                if ($prod->oldprice == NULL) {
                                    $prod->oldprice = $prod->price;
                                }

                                $prod->price = $prod->oldprice * (1 - ($model->discount * 0.01));
                                $prod->save();
                            }
                        }
                    }

                }
            }

            return $this->redirect(['update', 'id' => $model->id]);
        } else {

            return $this->render('update', [
                'model' => $model,
                'sharesLinks' => new SharesLinks(),

                'prods' => Products::find()->all(),
                'iconimg' => $icon
            ]);

        }
    }

    public function actionCron()
    {
        Shares::clearOlderRows();
    }

    public function actionDelprodlink($shareId, $prodId)
    {
        $x = SharesLinks::find()->where(['AND', ['=', 'id_product', $prodId], ['=', 'id_share', $shareId]])->one();
        if ($x)
            $x->delete();
        return $this->redirect(['update', 'id' => $shareId]);
    }

    /**
     * Deletes an existing Shares model.
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
