<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */

$this->title = Html::encode($model->title);
?>

<section class="section">
    <div class="container" style="max-width: 900px;">
        
        <!-- Навигация -->
        <div style="margin-bottom: 24px; font-size: 0.9rem; color: var(--muted, #666);">
            <a href="<?= Url::to(['site/index']) ?>" style="text-decoration: none; color: inherit;">Главная</a> / 
            <a href="<?= Url::to(['site/recipes']) ?>" style="text-decoration: none; color: inherit;">Рецепты</a> / 
            <span><?= Html::encode($model->title) ?></span>
        </div>

        <!-- Заголовок -->
        <h1 style="font-size: 2.5rem; margin-bottom: 16px;"><?= Html::encode($model->title) ?></h1>
        
        <div style="display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 32px; color: var(--muted, #666); font-size: 0.95rem;">
            <?php if ($model->category): ?>
                <span class="tag-pill" style="background: var(--accent, #C65D3C); color: white;"><?= Html::encode($model->category->name) ?></span>
            <?php endif; ?>
            <span>⏱️ <?= Html::encode($model->prep_time ?: 'Н/Д') ?></span>
            <span> <?= Html::encode($model->difficulty ?: 'Средне') ?></span>
            <span>👁️ <?= $model->views_count ?? 0 ?> просмотров</span>
        </div>

        <!-- Картинка -->
        <?php if ($model->image_path): ?>
            <div style="width: 100%; height: 400px; border-radius: 16px; overflow: hidden; margin-bottom: 40px; background: #f0f0f0;">
                <img src="<?= Yii::getAlias('@web' . $model->image_path) ?>" 
                     alt="<?= Html::encode($model->title) ?>" 
                     style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
            
            <!-- Левая колонка: Описание и Шаги -->
            <div>
                <div style="background: var(--bg, #fff); padding: 32px; border-radius: 16px; border: 1px solid var(--border, #eee); margin-bottom: 32px;">
                    <h2 style="margin-top: 0;">Описание</h2>
                    <p style="line-height: 1.8; white-space: pre-line;"><?= Html::encode($model->description) ?></p>
                </div>

                <div style="background: var(--bg, #fff); padding: 32px; border-radius: 16px; border: 1px solid var(--border, #eee);">
                    <h2 style="margin-top: 0;">Шаги приготовления</h2>
                    <div style="line-height: 1.8; white-space: pre-line;"><?= Html::encode($model->steps) ?></div>
                </div>
            </div>

            <!-- Правая колонка: Ингредиенты и Автор -->
            <div>
                <div style="background: var(--bg, #fff); padding: 32px; border-radius: 16px; border: 1px solid var(--border, #eee); margin-bottom: 32px;">
                    <h2 style="margin-top: 0;">Ингредиенты</h2>
                    <ul style="list-style: none; padding: 0; margin: 0; line-height: 2;">
                        <?php 
                        $ingredients = explode("\n", $model->ingredients);
                        foreach ($ingredients as $ing): 
                            if (trim($ing)):
                        ?>
                            <li style="border-bottom: 1px dashed #eee; padding-bottom: 8px;"><?= Html::encode(trim($ing)) ?></li>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </ul>
                </div>

                <?php if ($model->author): ?>
                <div style="background: var(--bg, #fff); padding: 24px; border-radius: 16px; border: 1px solid var(--border, #eee); text-align: center;">
                    <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--accent, #C65D3C); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin: 0 auto 16px;">
                        <?= strtoupper(substr($model->author->username, 0, 1)) ?>
                    </div>
                    <h4 style="margin: 0 0 8px 0;"><?= Html::encode($model->author->username) ?></h4>
                    <p style="color: var(--muted, #666); font-size: 0.9rem; margin: 0;">Автор рецепта</p>
                    
                    <?php if (Yii::$app->user->id == $model->author->id): ?>
                        <a href="<?= Url::to(['site/profile']) ?>" class="btn btn-secondary" style="margin-top: 16px; display: inline-block; width: 100%;">Мой профиль</a>
                    <?php else: ?>
                        <a href="<?= Url::to(['site/profile', 'id' => $model->author->id]) ?>" class="btn btn-secondary" style="margin-top: 16px; display: inline-block; width: 100%;">Посмотреть профиль</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>