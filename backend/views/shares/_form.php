<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use dosamigos\datetimepicker\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Shares */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shares-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'duration')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea([])->widget(\yii\redactor\widgets\Redactor::className()) ?>
    <?= 'Срок действия' ?>
    <?= $form->field($model, 'from')->textInput(['maxlength' => true])->widget(DateTimePicker::className(), [
        'language' => 'ru',
        'size' => 'ms',
        'template' => '{input}',
        'pickButtonIcon' => 'glyphicon glyphicon-time',
        'inline' => false,
        'clientOptions' => [
            'startView' => 1,
            'minView' => 0,
            'maxView' => 7,
            'autoclose' => true,
            'linkFormat' => 'HH:ii P', // if inline = true
            // 'format' => 'HH:ii P', // if inline = false
            'todayBtn' => true
        ]
    ]); ?>
    <?= $form->field($model, 'to')->textInput(['maxlength' => true])->widget(DateTimePicker::className(), [
        'language' => 'ru',
        'size' => 'ms',
        'template' => '{input}',
        'pickButtonIcon' => 'glyphicon glyphicon-time',
        'inline' => false,
        'clientOptions' => [
            'startView' => 1,
            'minView' => 0,
            'maxView' => 7,
            'autoclose' => true,
            'linkFormat' => 'HH:ii P',
            // 'format' => 'HH:ii P',
            'todayBtn' => true
        ]
    ]); ?>
    <?= $form->field($model, 'iconim')->fileInput(['multiple' => false]) ?>

    <?php
    if (!empty($iconimg) && $iconimg != NULL) {
        ?>
        <div class="form-group">
            <img src="<?= 'http://yii2.loc/' . $iconimg->path ?>" width="500">
        </div>
        <h3>Продукты:</h3><br>
    <?
    }

    if (!empty($model->prodlist)) {
        foreach ($model->prodlist as $os) {
            $OsSearch['os'] = $os->name;
            echo '&nbsp;&nbsp;' . HTML::a($os->name, \yii\helpers\Url::to(['index', 'ProductsSearch' => $OsSearch]));
            ?>
            <?= HTML::a('<img src="http://s1.iconbird.com/ico/2013/10/464/w128h1281380984637delete13.png" height="20" width="20">',
                ['shares/delprodlink', 'act' => 'dellink', 'shareId' => $model->id, 'prodId' => $os->id]) ?>

            <?php
        }
    } ?>
    <br>
    <br>
    <?php
    Modal::begin([
        'header' => '<h2>Добавьте продукты для акции</h2>',
        'toggleButton' => ['label' => 'Добавить Продукт']
    ]); ?>

    <?php
    $items = ArrayHelper::map($prods, 'id', 'name');
    $params = [
        'prompt' => 'Выберите продукт',
        'multiple' => 'true',
        'style' => ['height' => '500px'],
    ];
    ?><br><?php
    echo $form->field($sharesLinks, 'id_product')->dropDownList($items, $params);
    ?>
</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Cоздать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php

Modal::end(); ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
