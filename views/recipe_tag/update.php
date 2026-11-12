<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeTag */

$this->title = 'Update Recipe Tag: ' . $model->recipe_id;
$this->params['breadcrumbs'][] = ['label' => 'Recipe Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->recipe_id, 'url' => ['view', 'recipe_id' => $model->recipe_id, 'tag_id' => $model->tag_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recipe-tag-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
