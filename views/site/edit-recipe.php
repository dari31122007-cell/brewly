<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Category;
use yii\helpers\ArrayHelper;

$this->title = 'Редактировать рецепт: ' . $model->title;
$categories = Category::find()->orderBy('sort_order ASC')->all();

// ПОДГОТОВКА ТЕГОВ ДЛЯ ОТОБРАЖЕНИЯ
$tagsString = '';
if (!empty($model->tags) && is_array($model->tags)) {
    $tagsNames = [];
    foreach ($model->tags as $tag) {
        if (is_object($tag) && isset($tag->name)) {
            $tagsNames[] = $tag->name;
        } else {
            $tagsNames[] = (string)$tag;
        }
    }
    $tagsString = implode(', ', $tagsNames);
} elseif (is_string($model->tags)) {
    // На случай, если в базе уже строка
    $tagsString = $model->tags;
}
?>

<div class="container" style="max-width: 800px; margin: 40px auto;">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'category_id')->dropDownList(
            ArrayHelper::map($categories, 'id', 'name'),
            ['prompt' => 'Выберите категорию']
        ) ?>
        
        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        
        <?= $form->field($model, 'ingredients')->textarea(['rows' => 6, 'placeholder' => 'Каждый ингредиент с новой строки']) ?>
        
        <?= $form->field($model, 'steps')->textarea(['rows' => 6, 'placeholder' => 'Опишите шаги приготовления']) ?>
        
        <?= $form->field($model, 'prep_time')->textInput(['maxlength' => true, 'placeholder' => 'Например: 15 мин']) ?>
        
        <?= $form->field($model, 'difficulty')->textInput(['maxlength' => true, 'placeholder' => 'Например: Легко']) ?>
        
        <!-- ИСПРАВЛЕННОЕ ПОЛЕ ТЕГОВ: используем value вместо привязки к read-only свойству -->
        <?= $form->field($model, 'tags')->textInput([
            'maxlength' => true, 
            'placeholder' => 'через запятую: шоколад, орехи',
            'value' => $tagsString // Явно задаем значение из переменной
        ]) ?>
        
        <div class="form-group">
            <label>Текущее изображение:</label><br>
            <?php if ($model->image_path): ?>
                <img src="<?= Yii::getAlias('@web' . $model->image_path) ?>" style="max-width: 200px; border-radius: 8px; margin-bottom: 10px; display: block;">
            <?php endif; ?>
            <?= $form->field($model, 'image_path')->fileInput(['accept' => 'image/*']) ?>
            <small style="color: #666;">Загрузите новое фото, чтобы заменить текущее. Если оставить пустым, старое фото останется.</small>
        </div>

        <div class="form-group" style="margin-top: 24px;">
            <?= Html::submitButton('Сохранить изменения', ['class' => 'btn btn-primary']) ?>
            <a href="<?= \yii\helpers\Url::to(['recipe', 'id' => $model->id]) ?>" class="btn btn-secondary" style="margin-left: 10px; text-decoration: none; display: inline-block; padding: 8px 16px; border-radius: 4px; background: #eee; color: #333;">Отмена</a>
        </div>
        
    <?php ActiveForm::end(); ?>
</div>