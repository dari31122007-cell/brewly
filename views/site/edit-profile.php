<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Редактирование профиля';
?>

<div class="form-page">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
        <p style="color: var(--muted); margin-bottom: 32px;">Измените свои данные или загрузите новое фото.</p>
        
        <div class="form-card">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            
            <!-- Текущий аватар -->
            <div class="field" style="text-align: center; margin-bottom: 24px;">
                <label>Ваше фото</label>
                <div style="margin-top: 10px;">
                    <?php if ($model->avatar_path): ?>
                        <img src="<?= Yii::getAlias('@web' . $model->avatar_path) ?>" 
                             alt="Avatar" 
                             style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid var(--border); margin-bottom: 10px;">
                        <br>
                        <small style="color: var(--muted);">Текущее фото</small>
                    <?php else: ?>
                        <div style="width: 120px; height: 120px; background: var(--bg); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--muted); border: 3px dashed var(--border); margin-bottom: 10px;">
                            👤
                        </div>
                        <br>
                        <small style="color: var(--muted);">Нет фото</small>
                    <?php endif; ?>
                </div>
                
                <?= $form->field($model, 'avatar_path')->fileInput(['accept' => 'image/*', 'style' => 'margin-top: 10px;'])->label('Загрузить новое фото') ?>
            </div>

            <div class="form-row">
                <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Ваше имя']) ?>
                <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'type' => 'email', 'placeholder' => 'email@example.com']) ?>
            </div>

            <!-- ПОЛЕ ПАРОЛЯ УДАЛЕНО/ЗАКОММЕНТИРОВАНО, ТАК КАК ЕГО НЕТ В БД -->
            <!-- Если нужно менять пароль, это делается на отдельной странице смены пароля -->

            <div class="form-actions" style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
                <a href="<?= Url::to(['site/profile']) ?>" class="btn btn-secondary">Отмена</a>
                <?= Html::submitButton('Сохранить изменения', ['class' => 'btn btn-primary']) ?>
            </div>
            
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>