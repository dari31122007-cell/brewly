<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm; // ИСПРАВЛЕНО: bootstrap4 вместо bootstrap5

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Вход в аккаунт';
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

<div class="site-login">
    <div class="auth-container">
        <h1 class="auth-title"><?= Html::encode($this->title) ?></h1>
        <p class="auth-subtitle">Добро пожаловать обратно в Brewly!</p>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'control-label', 'style' => 'font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;'],
            ],
        ]); ?>

        <?= $form->field($model, 'username')->textInput([
            'autofocus' => true, 
            'placeholder' => 'Имя пользователя или Email',
            'class' => 'form-control'
        ])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput([
            'placeholder' => 'Пароль',
            'class' => 'form-control'
        ])->label(false) ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div style='display:flex; align-items:center; gap:8px;'>{input} {label}</div>\n{error}",
            'labelOptions' => ['style' => 'font-weight: normal; cursor: pointer;']
        ])->label('Запомнить меня') ?>

        <div class="form-group" style="margin-top: 24px;">
            <?= Html::submitButton('Войти', [
                'class' => 'btn btn-auth', 
                'name' => 'login-button'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="auth-footer">
            Нет аккаунта? <?= Html::a('Зарегистрироваться', ['site/signup']) ?>
        </div>
    </div>
</div>