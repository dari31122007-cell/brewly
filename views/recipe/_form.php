<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ingredients')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'steps')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'prep_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'difficulty')->dropDownList([ 'easy' => 'Easy', 'medium' => 'Medium', 'hard' => 'Hard', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'volume')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'acidity')->textInput() ?>

    <?= $form->field($model, 'bitterness')->textInput() ?>

    <?= $form->field($model, 'sweetness')->textInput() ?>

    <?= $form->field($model, 'body')->textInput() ?>

    <?= $form->field($model, 'image_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'author_id')->textInput() ?>

    <?= $form->field($model, 'views_count')->textInput() ?>

    <?= $form->field($model, 'favorites_count')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
