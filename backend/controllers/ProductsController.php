<?php

namespace backend\controllers;

use common\models\Categories;
use common\models\Images;
use common\models\Os;
use common\models\Os_links;
use Yii;
use common\models\Products;
use common\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Images_links;
use common\models\Product_links;
use common\models\Manufacturers_links;
use common\models\Manufacturers;
use yii\filters\AccessControl;

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
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->redirect(['update', 'id' => $id], 301);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Products();
        $prodLinks = new Product_links();
        $manLinks = new Manufacturers_links();
        $osLinks = new Os_links();

        if (($model->load(Yii::$app->request->post()) && $model->validate())
            ||
            ($prodLinks->load(Yii::$app->request->post()))
            ||
            ($osLinks->load(Yii::$app->request->post()))
        ) {
            $files = UploadedFile::getInstances($model, 'image');
            // var_dump($osLinks->load(Yii::$app->request->post()));
            // die;


            //$imageName = $model->user_id
            if (sizeof($files) > 0) {
                // var_dump(UploadedFile::getInstances($model, 'image'));
                // die;

                //$model->file
                $files = UploadedFile::getInstances($model, 'image');

                //var_dump($model->file);

                $i = 0;
                foreach ($files as $file) {
                    $name = Yii::$app->user->id . '-' . date('Y-m-d-H-i-s') . $i++;
                    $path = Yii::getAlias('@frontend/web/uploads/') . $name . '.' . $file->extension;
                    $file->saveAs($path);
                    Images::imgResize($path, 100);
                    Images::imgResize($path, 150);
                    $path = str_replace(Yii::getAlias('@frontend/web/'), '', $path);
                    $model->save();
                    $model->AddImagesLinks($path);
                }
            }


            if ($model->save()) {


                $prodLinks->load(Yii::$app->request->post());
                $prodLinks->product_id = $model->id;
                $manLinks->product_id = $model->id;
                //var_dump($prodLinks);
                //die;
                if ($prodLinks->load(Yii::$app->request->post()))
                    foreach ($prodLinks->category_id as $cat_id) {
                        $prodLinks = new Product_links();
                        $prodLinks->product_id = $model->id;
                        $prodLinks->category_id = $cat_id;
                        if ($prodLinks->validate()) {
                            $prodLinks->save();
                        }
                    }

                if ($osLinks->load(Yii::$app->request->post()))

                    foreach ($osLinks->os_id as $os_id) {
                        $osLinks = new Os_links();
                        $osLinks->product_id = $model->id;
                        $osLinks->os_id = $os_id;
                        if ($osLinks->validate()) {
                            $osLinks->save();
                        }
                    }

                if ($manLinks->load(Yii::$app->request->post()) && $manLinks->validate()) {
                    $manLinks->save();
                }
            }
            //die();
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'prodLinks' => $prodLinks,
                'cats' => Categories::find()->all(),
                'manLinks' => $manLinks,
                'mans' => Manufacturers::find()->all(),
                'osLinks' => $osLinks,
                'os' => Os::find()->all(),
                'prodLinksNew' => new Product_links()
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
        //var_dump($model);
        //  die('5555');

        if (!$model = $this->findModel($id))
            return 'Не верный id продукта !';

        // $prodLinks = Product_links::find()->where(['=', 'product_id', $id])->one();
        // $manLinks = Manufacturers_links::find()->where(['=', 'product_id', $id])->one();
        // if($manLinks==null)
        $manLinks = new Manufacturers_links();
        // if($prodLinks==null)
        $prodLinks = new Product_links();

        //if($osLinks==null)
        $osLinks = new Os_links();

        if (($model->load(Yii::$app->request->post()))

        ) {


            $files = UploadedFile::getInstances($model, 'image');
            // var_dump($osLinks->load(Yii::$app->request->post()));
            // die;


            //$imageName = $model->user_id
            if (sizeof($files) > 0) {
                // var_dump(UploadedFile::getInstances($model, 'image'));
                // die;

                //$model->file
                $files = UploadedFile::getInstances($model, 'image');

                //var_dump($model->file);

                $i = 0;
                foreach ($files as $file) {
                    $name = Yii::$app->user->id . '-' . date('Y-m-d-H-i-s') . $i++;
                    $path = Yii::getAlias('@frontend/web/uploads/') . $name . '.' . $file->extension;
                    $file->saveAs($path);
                    Images::imgResize($path, 100);
                    Images::imgResize($path, 150);
                    $path = str_replace(Yii::getAlias('@frontend/web/'), '', $path);
                    $model->save();
                    $model->AddImagesLinks($path);
                }
            }


            if ($model->save()) {


                // $prodLinks->load(Yii::$app->request->post());
                //  $prodLinks->product_id = $model->id;
                //  $manLinks->product_id = $model->id;
                //var_dump($prodLinks);

                if ($prodLinks->load(Yii::$app->request->post())) {
                    if (is_array($prodLinks->category_id))
                        foreach ($prodLinks->category_id as $cat_id) {
                            $prodLinks1 = new Product_links();
                            $prodLinks1->product_id = $model->id;
                            $prodLinks1->category_id = $cat_id;
                            if ($prodLinks1->validate()) {
                                $prodLinks1->save();
                            }
                        }
                }

                if ($osLinks->load(Yii::$app->request->post())) {
                    // var_dump($osLinks);
                    //die;
                    if (is_array($osLinks->os_id))
                        foreach ($osLinks->os_id as $os_id) {
                            $osLinks1 = new Os_links();
                            $osLinks1->product_id = $model->id;
                            $osLinks1->os_id = $os_id;
                            if ($osLinks1->validate()) {
                                $osLinks1->save();
                            }
                        }

                }
                if ($manLinks->load(Yii::$app->request->post()) && $manLinks->validate()) {
                    $manLinks->save();
                }
            }
            //die();

        }

        return $this->render('update', [
            'model' => $model,
            'prodLinks' => Product_links::find()->where(['=', 'product_id', $id])->all(),
            'cats' => Categories::find()->all(),
            'prodLinksNew' => new Product_links(),
            'manLinks' => Manufacturers_links::find()->where(['=', 'product_id', $id])->one(),
            'mans' => Manufacturers::find()->all(),
            'osLinks' => Os_links::find()->where(['=', 'product_id', $id])->one(),
            'os' => Os::find()->all()
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

    public function actionDeloslink($osId, $prodId)
    {
        $x = Os_links::find()->where(['AND', ['=', 'product_id', $prodId], ['=', 'os_id', $osId]])->one();
        if ($x)
            $x->delete();
        return $this->redirect(['update', 'id' => $prodId]);
    }

    public function actionDelprodlink($catId, $prodId)
    {
        $x = Product_links::find()->where(['AND', ['=', 'product_id', $prodId], ['=', 'category_id', $catId]])->one();
        if ($x)
            $x->delete();
        return $this->redirect(['update', 'id' => $prodId]);


    }

    public function actionDelimglink($imgId, $prodId)
    {
        Images_links::find()->where(['AND', ['=', 'product_id', $prodId], ['=', 'image_id', $imgId]])->one()->delete();
        Images::find()->where(['=', 'id', $imgId])->one()->delete();
        $prodLinks = Product_links::find()->where(['=', 'product_id', $prodId])->one();
        $manLinks = Manufacturers_links::find()->where(['=', 'product_id', $prodId])->one();;
        $model = $this->findModel($prodId);
        $osLinks = new Os_links();
        return $this->render('update', [
            'model' => $model,
            'prodLinks' => $prodLinks,
            'cats' => Categories::find()->all(),
            'manLinks' => $manLinks,
            'mans' => Manufacturers::find()->all(),
            'osLinks' => $osLinks,
            'os' => Os::find()->all()
        ]);
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
