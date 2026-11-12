<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\RecipeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $categories app\models\Category[] */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;

$this->title = 'Все рецепты';
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const rangeInputs = document.querySelectorAll('.range-input');
    const categoryButtons = document.querySelectorAll('.chips button[type="submit"]');

    // Функция синхронизации значения input и output
    function syncValue(input) {
        const output = input.nextElementSibling;
        if (output && output.tagName === 'OUTPUT') {
            output.textContent = input.value;
        }
    }

    // При движении ползунка обновляем цифру
    rangeInputs.forEach(input => {
        input.addEventListener('input', function() {
            syncValue(this);
        });
        // Инициализация при загрузке (на случай, если значения пришли из URL)
        syncValue(input);
    });

    // Перед отправкой формы (клик по категории) убеждаемся, что значения актуальны
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            rangeInputs.forEach(input => {
                // Принудительно обновляем value (на всякий случай) и цифру
                syncValue(input);
            });
        });
    });
});
</script>

<div class="list-layout">
    <aside class="filters">
        <h3>🎯 Вкусовой профиль</h3>
        
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['site/recipes'],
            'options' => ['class' => 'filter-form', 'id' => 'filterForm'],
        ]); ?>

        <!-- Категория (Кнопки) -->
        <div class="filter-group">
            <label>Категория</label>
            <div class="chips">
                <!-- Кнопка "Все" -->
                <button type="submit" name="<?= $searchModel->formName() ?>[category_filter]" value="" 
                        class="chip <?= empty($searchModel->category_filter) && empty($searchModel->category_id) ? 'active' : '' ?>">
                    Все
                </button>
                
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <?php 
                        $isActive = ($searchModel->category_filter == $cat->slug);
                        ?>
                        <button type="submit" name="<?= $searchModel->formName() ?>[category_filter]" value="<?= $cat->slug ?>" 
                                class="chip <?= $isActive ? 'active' : '' ?>">
                            <?= Html::encode($cat->name) ?>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Ползунок: Кислотность -->
        <div class="filter-group">
            <label>Кислотность</label>
            <div class="slider-wrap">
                <div class="range-input-container">
                    <?= $form->field($searchModel, 'acidity_min')->textInput([
                        'type' => 'range', 
                        'min' => 1, 
                        'max' => 10, 
                        'class' => 'range-input',
                        'value' => $searchModel->acidity_min ?: 1, // Явно задаем значение
                        'oninput' => "this.nextElementSibling.value = this.value;"
                    ])->label(false) ?>
                    <output class="range-value"><?= $searchModel->acidity_min ?: 1 ?></output>
                </div>
                <div class="slider-val"><span>Низкая</span><span>Высокая</span></div>
            </div>
        </div>

        <!-- Ползунок: Горечь -->
        <div class="filter-group">
            <label>Горечь</label>
            <div class="slider-wrap">
                <div class="range-input-container">
                    <?= $form->field($searchModel, 'bitterness_min')->textInput([
                        'type' => 'range', 
                        'min' => 1, 
                        'max' => 10, 
                        'class' => 'range-input',
                        'value' => $searchModel->bitterness_min ?: 1,
                        'oninput' => "this.nextElementSibling.value = this.value;"
                    ])->label(false) ?>
                    <output class="range-value"><?= $searchModel->bitterness_min ?: 1 ?></output>
                </div>
                <div class="slider-val"><span>Мягкая</span><span>Сильная</span></div>
            </div>
        </div>

        <!-- Ползунок: Сладость -->
        <div class="filter-group">
            <label>Сладость</label>
            <div class="slider-wrap">
                <div class="range-input-container">
                    <?= $form->field($searchModel, 'sweetness_min')->textInput([
                        'type' => 'range', 
                        'min' => 1, 
                        'max' => 10, 
                        'class' => 'range-input',
                        'value' => $searchModel->sweetness_min ?: 1,
                        'oninput' => "this.nextElementSibling.value = this.value;"
                    ])->label(false) ?>
                    <output class="range-value"><?= $searchModel->sweetness_min ?: 1 ?></output>
                </div>
                <div class="slider-val"><span>Сухой</span><span>Сладкий</span></div>
            </div>
        </div>

        <!-- Ползунок: Тело -->
        <div class="filter-group">
            <label>Тело (плотность)</label>
            <div class="slider-wrap">
                <div class="range-input-container">
                    <?= $form->field($searchModel, 'body_min')->textInput([
                        'type' => 'range', 
                        'min' => 1, 
                        'max' => 10, 
                        'class' => 'range-input',
                        'value' => $searchModel->body_min ?: 1,
                        'oninput' => "this.nextElementSibling.value = this.value;"
                    ])->label(false) ?>
                    <output class="range-value"><?= $searchModel->body_min ?: 1 ?></output>
                </div>
                <div class="slider-val"><span>Лёгкое</span><span>Плотное</span></div>
            </div>
        </div>

        <div class="filter-actions" style="margin-top: 20px;">
            <?= Html::submitButton('Применить', ['class' => 'btn btn-primary', 'style' => 'width:100%']) ?>
            <a href="<?= Url::to(['site/recipes']) ?>" class="btn btn-secondary" style="width:100%; display:block; text-align:center; text-decoration:none; margin-top:10px;">Сбросить</a>
        </div>

        <?php ActiveForm::end(); ?>
    </aside>

    <div>
        <div class="section-head">
            <div>
                <h2>Все рецепты</h2>
                <p>Найдено: <?= $dataProvider->totalCount ?></p>
            </div>
        </div>

        <div class="recipes-grid">
            <?php if (!empty($dataProvider->models)): ?>
                <?php foreach ($dataProvider->models as $recipe): ?>
                    <?= $this->render('_recipeCard', ['recipe' => $recipe]) ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column: 1/-1; text-align: center; color: var(--muted); padding: 40px;">
                    Рецепты не найдены. Попробуйте изменить фильтры или <?= Html::a('добавить новый', ['site/add-recipe']) ?>.
                </p>
            <?php endif; ?>
        </div>

        <!-- Пагинация -->
        <?php if ($dataProvider->totalCount > $dataProvider->pagination->pageSize): ?>
            <div style="margin-top: 40px; display: flex; justify-content: center;">
                <?= LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                    'options' => ['class' => 'pagination'],
                ]) ?>
            </div>
        <?php endif; ?>
    </div>
</div>