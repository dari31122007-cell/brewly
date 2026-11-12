<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecipeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $categories array */

$this->title = 'Рецепты';
?>

<!-- Блок категорий -->
<div class="category-filter" style="margin-bottom: 30px;">
    <h3>Категории</h3>
    <div class="chips">
        <!-- Кнопка "Все" -->
        <a href="<?= Url::to(['recipe/index']) ?>" 
           class="chip <?= !isset($_GET['RecipeSearch']['category_id']) ? 'active' : '' ?>">
            Все
        </a>
        
        <!-- Динамические кнопки категорий -->
        <?php foreach ($categories as $cat): ?>
            <a href="<?= Url::to(['recipe/index', 'RecipeSearch' => ['category_id' => $cat->id]]) ?>" 
               class="chip <?= (isset($_GET['RecipeSearch']['category_id']) && $_GET['RecipeSearch']['category_id'] == $cat->id) ? 'active' : '' ?>">
                <?= \yii\helpers\Html::encode($cat->name) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Сетка рецептов -->
<div class="recipes-grid">
    <?php foreach ($dataProvider->models as $recipe): ?>
        <article class="recipe-card">
            <!-- Ваш HTML карточки рецепта -->
            <h3><?= \yii\helpers\Html::encode($recipe->title) ?></h3>
            <span class="badge"><?= \yii\helpers\Html::encode($recipe->category->name) ?></span>
        </article>
    <?php endforeach; ?>
</div>

<?= \yii\widgets\LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>