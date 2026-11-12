<?php
/* @var $this yii\web\View */
/* @var $model app\models\Recipe */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Добавить рецепт';
?>

<h1>Поделиться рецептом</h1>
<p style="color:var(--muted);margin-bottom:32px">Расскажи сообществу, как ты варишь свой идеальный кофе</p>

<!-- ВАЖНО: action ведет на маршрут site/add-recipe, enctype нужен для картинок -->
<form class="form-card" action="<?= Url::to(['site/add-recipe']) ?>" method="post" enctype="multipart/form-data">
    
    <!-- 1. ПРАВИЛЬНЫЙ СПОСОБ добавить CSRF токен в обычную HTML форму -->
    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

    <div class="field">
      <label for="title">Название рецепта *</label>
      <input type="text" id="title" name="Recipe[title]" required placeholder="Например: Мой авторский раф" value="<?= Html::encode($model->title ?? '') ?>">
    </div>

    <div class="form-row">
      <div class="field">
        <label for="category_id">Категория *</label>
        <select id="category_id" name="Recipe[category_id]" required>
          <option value="">Выберите...</option>
          <option value="1" <?= ($model->category_id ?? '') == 1 ? 'selected' : '' ?>>Эспрессо</option>
          <option value="2" <?= ($model->category_id ?? '') == 2 ? 'selected' : '' ?>>Молочные</option>
          <option value="3" <?= ($model->category_id ?? '') == 3 ? 'selected' : '' ?>>Холодные</option>
          <option value="4" <?= ($model->category_id ?? '') == 4 ? 'selected' : '' ?>>Фильтр</option>
        </select>
      </div>
      <div class="field">
        <label for="prep_time">Время приготовления</label>
        <input type="text" id="prep_time" name="Recipe[prep_time]" placeholder="5 мин" value="<?= Html::encode($model->prep_time ?? '') ?>">
      </div>
    </div>

    <div class="field">
      <label for="description">Описание *</label>
      <textarea id="description" name="Recipe[description]" required placeholder="Коротко о вкусе и особенностях..."><?= Html::encode($model->description ?? '') ?></textarea>
    </div>

    <div class="field">
      <label for="image_path">Изображение</label>
      <input type="file" id="image_path" name="Recipe[image_path]" accept="image/*">
    </div>

    <div class="field">
      <label for="ingredients">Ингредиенты (каждый с новой строки)</label>
      <textarea id="ingredients" name="Recipe[ingredients]" required placeholder="Кофе в зёрнах — 18 г&#10;Вода — 250 мл"><?= Html::encode($model->ingredients ?? '') ?></textarea>
    </div>

    <div class="field">
      <label for="steps">Шаги приготовления *</label>
      <textarea id="steps" name="Recipe[steps]" required placeholder="1. Смолоть зёрна...&#10;2. Прогреть воду..."><?= Html::encode($model->steps ?? '') ?></textarea>
    </div>

    <!-- Поле 'tags' убрано, так как в модели это связь (relation), а не текстовая колонка. 
         Это предотвратит ошибку при сохранении формы. -->

    <h3 style="margin:24px 0 16px">Вкусовой профиль</h3>
    <div class="form-row">
      <div class="field">
          <label for="acidity">Кислотность</label>
          <input type="range" id="acidity" name="Recipe[acidity]" min="0" max="10" value="<?= $model->acidity ?? 5 ?>">
      </div>
      <div class="field">
          <label for="bitterness">Горечь</label>
          <input type="range" id="bitterness" name="Recipe[bitterness]" min="0" max="10" value="<?= $model->bitterness ?? 5 ?>">
      </div>
      <div class="field">
          <label for="sweetness">Сладость</label>
          <input type="range" id="sweetness" name="Recipe[sweetness]" min="0" max="10" value="<?= $model->sweetness ?? 5 ?>">
      </div>
      <div class="field">
          <label for="body">Тело</label>
          <input type="range" id="body" name="Recipe[body]" min="0" max="10" value="<?= $model->body ?? 5 ?>">
      </div>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Опубликовать</button>
      <button type="reset" class="btn btn-secondary">Очистить</button>
    </div>
</form>