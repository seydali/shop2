<?php
namespace common\widgets;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use common\models\Products;

class CollFiltration extends Widget
{


    public function init()
    {
        parent::init();

    }


    public function run()
    {
        if(Yii::$app->user->id) {
            $coll = Products::CollFiltration();
            return $this->render('collfiltration', [
                'coll' => $coll
            ]);
        }
        else return '';
    }

}