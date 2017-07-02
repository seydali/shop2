<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model common\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php
    //Pjax::begin(['enablePushState' => false]);
    $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->widget(\yii\redactor\widgets\Redactor::className()) ?>


    <?    echo "<hr>";
    foreach($model->images as $image)
    {
        //Yii::$app->config['site']['frontUrl']
        echo Html::a(Html::img(str_replace('uploads', 'http://yii2.loc/uploads/min/100',$image->path)),  'http://yii2.loc/'.$image->path, ['rel' => 'fancybox']);
        echo HTML::a('<img src="http://s1.iconbird.com/ico/2013/10/464/w128h1281380984637delete13.png" height="20" width="20">',
            ['products/delimglink',  'prodId'=>$model->id, 'imgId' => $image->id]);
    }?>
    <?=$form->field($model, 'image[]')->fileInput(['multiple' => true]) ?>
    <?= $form->field($model, 'system_requirements')->textarea(['rows' => 6])->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'reviews')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>
    <?= $form->field($model, 'oldprice')->textInput() ?>
    <?php $items1 = ArrayHelper::map($cats,'id','name');
    $params = [
        'prompt' => 'Выберите категорию',
        'multiple' => 'true',
        'style' => ['height'=>'500px'],
    ];

    ?>

    <?php
    foreach($model->categories as $cat)
    {
        $CatSearch['os']=$cat->name;
        echo '&nbsp;&nbsp;'.HTML::a($cat->name, \yii\helpers\Url::to(['index','ProductsSearch'=>$CatSearch]));
        ?>
        <?= HTML::a('<img src="http://s1.iconbird.com/ico/2013/10/464/w128h1281380984637delete13.png" height="20" width="20">',
        ['products/delprodlink', 'act'=>'dellink',  'prodId'=>$model->id, 'catId' => $cat->id]) ?>
        <?php
    }


    ?>
    <br>  <br>
    <?php

    Modal::begin([
        'header' => '<h2>Выберите Категорию</h2>',
        'toggleButton' => ['label' => 'Добавить Категорию'],
    ]);?>
    <div class="form-group">
        <?=$form->field($prodLinksNew, 'category_id')->dropDownList($items1,$params)

        ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Рeдактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php

    Modal::end();
    ?>


    <?php

    ?>
    <?php $items = ArrayHelper::map($os, 'id', 'name');
    $params1 = [
        'prompt' => 'Выберите ОС',
        'multiple' => 'true',
        'style' => ['height' => '300px'],
    ]; ?>
    <br>
    <strong>Поддерживаемые ОС:</strong><br>

    <?
    foreach ($model->oslist as $os) {
        $OsSearch['os'] = $os->name;
        echo '&nbsp;&nbsp;' . HTML::a($os->name, \yii\helpers\Url::to(['index', 'ProductsSearch' => $OsSearch]));
        ?>
        <?= HTML::a('<img src="http://s1.iconbird.com/ico/2013/10/464/w128h1281380984637delete13.png" height="20" width="20">',
            ['products/deloslink', 'act' => 'dellink', 'prodId' => $model->id, 'osId' => $os->id]) ?>

        <?php
    }?>
    <br>
    <br>
    <?php
    Modal::begin([
        'header' => '<h2>Выберите ОС</h2>',
        'toggleButton' => ['label' => 'Добавить ОС']
    ]);?>

    <?php
    echo $form->field($osLinks, 'os_id')->dropDownList($items, $params);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Cоздать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php

    Modal::end();


    $items1 = ArrayHelper::map($mans,'id','name');
    $params1 = [
        'prompt' => 'Выберите производителя',

    ];?>
    <?= $form->field($manLinks, 'manufacturer_id')->dropDownList($items1,$params1)->label('Производители')?>








    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); /// END MAIN
    //Pjax::end();

    /*

            $items = ArrayHelper::map($cats,'id','name');
            $params = [
                'prompt' => 'Выберите категорию',
                'multiple' => 'true',
                'style' => ['height'=>'500px'],
            ];?>
            <br>
            <strong>Категории:</strong><br>

            <?

            foreach($model->categories as $os)
            {
                $OsSearch['os']=$os->name;
                echo '&nbsp;&nbsp;'.HTML::a($os->name, \yii\helpers\Url::to(['index','ProductsSearch'=>$OsSearch]));
                ?>
                <?= HTML::a('<img src="http://s1.iconbird.com/ico/2013/10/464/w128h1281380984637delete13.png" height="20" width="20">',
                ['products/delprodlink', 'act'=>'dellink',  'prodId'=>$model->id, 'catId' => $os->id]) ?>
                <?php
            }
            Pjax::end();

            Modal::begin([
                'header' => '<h2>Выберите Категорию</h2>',
                'toggleButton' => ['label' => 'Добавить Категорию'],
            ]);

            $osform = ActiveForm::begin([
                'options' => ['enctype'=>'multipart/form-data']
            ]);
          //  echo $osform->field($prodLinks, 'category_id')->dropDownList($items,$params)?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
            <?php
            ActiveForm::end();
            Modal::end();



        }*/
    ?>


    <?
    if(!empty($model->images))
        echo newerton\fancybox\FancyBox::widget([
            'target' => 'a[rel=fancybox]',
            'helpers' => true,
            'mouse' => true,
            'config' => [
                'maxWidth' => '90%',
                'maxHeight' => '90%',
                'playSpeed' => 7000,
                'padding' => 0,
                'fitToView' => false,
                'width' => '70%',
                'height' => '70%',
                'autoSize' => false,
                'closeClick' => false,
                'openEffect' => 'elastic',
                'closeEffect' => 'elastic',
                'prevEffect' => 'elastic',
                'nextEffect' => 'elastic',
                'closeBtn' => false,
                'openOpacity' => true,
                'helpers' => [
                    'title' => ['type' => 'float'],
                    'buttons' => [],
                    'thumbs' => ['width' => 68, 'height' => 50],
                    'overlay' => [
                        'css' => [
                            'background' => 'rgba(0, 0, 0, 0.8)'
                        ]
                    ]
                ],
            ]
        ]);
    ?>




</div>
