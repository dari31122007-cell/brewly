<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SignupForm */

$this->title = 'Регистрация';
?>

<style>
    .auth-container {
        max-width: 420px;
        margin: 60px auto;
        background: #fff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(43, 29, 20, 0.08);
        border: 1px solid var(--border, #E5DDD0);
    }
    .auth-title {
        font-family: 'Playfair Display', serif;
        text-align: center;
        margin-bottom: 10px;
        color: var(--text, #2B1D14);
    }
    .auth-subtitle {
        text-align: center;
        color: var(--muted, #6B5D52);
        margin-bottom: 30px;
        font-size: 0.95rem;
    }
    .form-control {
        border-radius: 8px;
        border: 1px solid var(--border, #E5DDD0);
        padding: 12px;
        background: var(--bg, #F5F1EA);
    }
    .form-control:focus {
        border-color: var(--accent, #C65D3C);
        box-shadow: 0 0 0 3px rgba(198, 93, 60, 0.15);
        background: #fff;
    }
    .btn-auth {
        width: 100%;
        padding: 12px;
        font-weight: 600;
        border-radius: 8px;
        background: var(--accent, #C65D3C);
        border: none;
        color: #fff;
        transition: all 0.2s;
    }
    .btn-auth:hover {
        background: var(--accent-h, #A84A2E);
        transform: translateY(-1px);
    }
    .auth-footer {
        text-align: center;
        margin-top: 20px;
        font-size: 0.9rem;
        color: var(--muted, #6B5D52);
    }
    .auth-footer a {
        color: var(--accent, #C65D3C);
        font-weight: 600;
        text-decoration: none;
    }
    .auth-footer a:hover {
        text-decoration: underline;
    }
</style>

<div class="site-signup">
    <div class="auth-container">
        <h1 class="auth-title"><?= Html::encode($this->title) ?></h1>
        <p class="auth-subtitle">Присоединяйтесь к сообществу ценителей кофе</p>

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <?= $form->field($model, 'username')->textInput([
            'autofocus' => true, 
            'placeholder' => 'Придумайте логин',
            'class' => 'form-control'
        ])->label(false) ?>

        <?= $form->field($model, 'email')->textInput([
            'type' => 'email',
            'placeholder' => 'Ваш Email',
            'class' => 'form-control'
        ])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput([
            'placeholder' => 'Пароль (мин. 6 символов)',
            'class' => 'form-control'
        ])->label(false) ?>

        <?php if (property_exists($model, 'password_repeat') || in_array('password_repeat', array_keys($model->attributes()))): ?>
             <?= $form->field($model, 'password_repeat')->passwordInput([
                'placeholder' => 'Повторите пароль',
                'class' => 'form-control'
            ])->label(false) ?>
        <?php else: ?>
            
             <?= $form->field($model, 'password_repeat')->passwordInput([
                'placeholder' => 'Повторите пароль',
                'class' => 'form-control'
            ])->label(false) ?>
        <?php endif; ?>

        <div class="form-group" style="margin-top: 24px;">
            <?= Html::submitButton('Зарегистрироваться', [
                'class' => 'btn btn-auth', 
                'name' => 'signup-button'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="auth-footer">
            Уже есть аккаунт? <?= Html::a('Войти', ['site/login']) ?>
        </div>
    </div>
</div>