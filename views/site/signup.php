<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SignupForm */

$this->title = 'Регистрация';
?>

<div class="site-signup" style="max-width: 500px; margin: 40px auto; padding: 32px; background: #fff; border-radius: 16px; border: 1px solid #eee;">
    <h1><?= Html::encode($this->title) ?></h1>
    <p style="color: #666; margin-bottom: 24px;">Присоединяйтесь к сообществу ценителей кофе</p>

    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Придумайте логин']) ?>
        <?= $form->field($model, 'email')->textInput(['placeholder' => 'your@email.com']) ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Минимум 6 символов']) ?>
        <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => 'Повторите пароль']) ?>

        <div class="form-group" style="margin-top: 24px;">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button', 'style' => 'width: 100%; padding: 12px;']) ?>
        </div>

        <p style="text-align: center; margin-top: 16px; font-size: 0.9rem; color: #666;">
            Уже есть аккаунт? <?= Html::a('Войти', ['site/login'], ['style' => 'color: #C65D3C; text-decoration: none; font-weight: 600;']) ?>
        </p>

    <?php ActiveForm::end(); ?>
</div>