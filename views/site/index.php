<?php
/* @var $this yii\web\View */
/* @var $popularRecipes app\models\Recipe[] */
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Brewly — Коллекция рецептов кофе';
?>

<!-- Секция Hero -->
<section class="hero">
    <div class="container hero-grid">
      <div class="hero-text">
        <span class="tag">✨ Более 50 авторских рецептов</span>
        <h1>Искусство заваривания идеального кофе</h1>
        <p>Подбирай напитки по вкусовому профилю, сохраняй любимые рецепты и открывай новые способы приготовления.</p>
        <div class="hero-actions">
          <a href="<?= Url::to(['site/recipes']) ?>" class="btn btn-primary">Смотреть рецепты →</a>
          <a href="<?= Url::to(['site/add-recipe']) ?>" class="btn btn-secondary">Поделиться своим</a>
        </div>
      </div>
      <div class="hero-img">
        <img src="<?= Yii::getAlias('@web/images/img1.jpg') ?>" alt="Чашка ароматного кофе">
        <div class="hero-badge">
          <div class="num"><?= \app\models\Recipe::find()->count() ?>+</div>
          <div class="lbl">рецептов<br>в сообществе</div>
        </div>
      </div>
    </div>
</section>

<!-- Секция Категорий -->
<section class="section">
    <div class="container">
      <div class="section-head">
        <div><h2>Категории напитков</h2><p>Выбери то, что подходит под настроение</p></div>
      </div>
      <div class="cats">
        <!-- Эспрессо (slug: espresso) -->
        <a href="<?= Url::to(['site/recipes', 'RecipeSearch' => ['category_filter' => 'espresso']]) ?>" class="cat-card">
          <div class="cat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg></div>
          <h4>Эспрессо</h4><span>12 рецептов</span>
        </a>

        <!-- Молочные (slug: milk) -->
        <a href="<?= Url::to(['site/recipes', 'RecipeSearch' => ['category_filter' => 'milk']]) ?>" class="cat-card">
          <div class="cat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2h8v4h-8V2z"></path><path d="M8 6v14a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6"></path></svg></div>
          <h4>Молочные</h4><span>18 рецептов</span>
        </a>

        <!-- Холодные (slug: cold) -->
        <a href="<?= Url::to(['site/recipes', 'RecipeSearch' => ['category_filter' => 'cold']]) ?>" class="cat-card">
          <div class="cat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="8" width="16" height="8" rx="2"></rect></svg></div>
          <h4>Холодные</h4><span>9 рецептов</span>
        </a>

        <!-- Фильтр-кофе (slug: filter) -->
        <a href="<?= Url::to(['site/recipes', 'RecipeSearch' => ['category_filter' => 'filter']]) ?>" class="cat-card">
          <div class="cat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path></svg></div>
          <h4>Фильтр-кофе</h4><span>14 рецептов</span>
        </a>
      </div>
    </div>
</section>

<!-- Секция Популярных рецептов (ДИНАМИЧЕСКАЯ) -->
<section class="section">
    <div class="container">
      <div class="section-head">
        <div><h2>Популярные рецепты</h2><p>То, что готовят чаще всего на этой неделе</p></div>
        <a href="<?= Url::to(['site/recipes']) ?>" class="btn btn-ghost">Все рецепты →</a>
      </div>
      
      <div class="recipes-grid">
        <?php if (!empty($popularRecipes)): ?>
            <?php foreach ($popularRecipes as $recipe): ?>
                <!-- Используем тот же partial, что и в каталоге! -->
                <?= $this->render('_recipeCard', ['recipe' => $recipe]) ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="grid-column: 1/-1; text-align: center; color: var(--muted);">
                Пока нет популярных рецептов. <?= Html::a('Добавь первый!', ['site/add-recipe']) ?>
            </p>
        <?php endif; ?>
      </div>
    </div>
</section>

<!-- Секция Способов заваривания -->
<section class="section">
    <div class="container">
      <div class="section-head">
        <div><h2>Способы заваривания</h2><p>От классики до экспериментов</p></div>
      </div>
      <div class="cats">
        <!-- Все они ведут в категорию "Фильтр-кофе" (slug: filter) -->
        <a href="<?= Url::to(['site/recipes', 'RecipeSearch' => ['category_filter' => 'filter']]) ?>" class="cat-card">
          <h4>Аэропресс</h4>
          <span>Универсальный метод</span>
        </a>
        
        <a href="<?= Url::to(['site/recipes', 'RecipeSearch' => ['category_filter' => 'filter']]) ?>" class="cat-card">
          <h4>Кемекс</h4>
          <span>Чистый вкус</span>
        </a>
        
        <a href="<?= Url::to(['site/recipes', 'RecipeSearch' => ['category_filter' => 'filter']]) ?>" class="cat-card">
          <h4>V60</h4>
          <span>Яркая кислотность</span>
        </a>
        
        <a href="<?= Url::to(['site/recipes', 'RecipeSearch' => ['category_filter' => 'filter']]) ?>" class="cat-card">
          <h4>Френч-пресс</h4>
          <span>Насыщенное тело</span>
        </a>
        
        <!-- Можно добавить Турку, если она тоже в фильтре или создать отдельную категорию -->
        <a href="<?= Url::to(['site/recipes', 'RecipeSearch' => ['category_filter' => 'filter']]) ?>" class="cat-card">
          <h4>Турка</h4>
          <span>Восточная классика</span>
        </a>
      </div>
    </div>
</section>