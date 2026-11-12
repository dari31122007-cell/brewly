<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\Pagination;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Recipe;
use app\models\RecipeSearch;
use app\models\Category;
use app\models\SignupForm;
use app\models\User;
use app\models\Favorite;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'add-recipe', 'edit-profile', 'delete-recipe', 'toggle-favorite', 'favorites', 'edit-recipe'],
                'rules' => [
                    [
                        'actions' => ['logout', 'add-recipe', 'edit-profile', 'delete-recipe', 'toggle-favorite', 'favorites', 'edit-recipe'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete-recipe' => ['post'],
                    'toggle-favorite' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $popularRecipes = Recipe::find()
            ->where(['status' => 1])
            ->orderBy(['views_count' => SORT_DESC])
            ->limit(6)
            ->with(['category'])
            ->all();

        return $this->render('index', [
            'popularRecipes' => $popularRecipes,
        ]);
    }

    public function actionRecipe($id)
    {
        $model = Recipe::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Рецепт не найден.');
        }
        
        $model->views_count = ($model->views_count ?? 0) + 1;
        $model->save(false);

        return $this->render('recipe', [
            'model' => $model,
        ]);
    }

    public function actionRecipes()
    {
        $searchModel = new RecipeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $categories = Category::find()->orderBy('sort_order ASC')->all();

        return $this->render('recipes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => $categories,
        ]);
    }

    public function actionAddRecipe()
    {
        $model = new Recipe();
        $model->author_id = Yii::$app->user->id;
        $model->status = 1;

        if ($model->load(Yii::$app->request->post())) {
            
            if (empty($model->slug)) {
                $model->slug = mb_strtolower(preg_replace('/[^a-zA-Z0-9а-яА-Я\s]/u', '', $model->title), 'UTF-8');
                $model->slug = str_replace(' ', '-', $model->slug) . '-' . time();
            }

            $image = UploadedFile::getInstance($model, 'image_path');
            if ($image) {
                $dir = Yii::getAlias('@webroot/images/recipes/');
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                $fileName = uniqid() . '.' . $image->extension;
                $image->saveAs($dir . $fileName);
                $model->image_path = '/images/recipes/' . $fileName;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Рецепт успешно добавлен!');
                return $this->redirect(['recipe', 'id' => $model->id]);
            } else {
                echo '<h2 style="color:red;">Ошибка:</h2><pre>';
                print_r($model->errors);
                echo '</pre><a href="' . \yii\helpers\Url::to(['site/add-recipe']) . '">Назад</a>';
                exit;
            }
        }

        return $this->render('add-recipe', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Регистрация прошла успешно! Добро пожаловать в сообщество.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Страница профиля пользователя
     */
    public function actionProfile($id = null)
    {
        $userId = $id ?? Yii::$app->user->id;
        
        if (!$userId) {
            return $this->redirect(['site/login']);
        }

        $user = User::findOne($userId);
        if (!$user) {
            throw new \yii\web\NotFoundHttpException('Пользователь не найден.');
        }

        $query = Recipe::find()
            ->where(['author_id' => $user->id, 'status' => 1])
            ->orderBy(['created_at' => SORT_DESC])
            ->with(['category']);

        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 6,
        ]);

        $recipes = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('profile', [
            'user' => $user,
            'recipes' => $recipes,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Страница "Мои избранные"
     */
    public function actionFavorites()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $userId = Yii::$app->user->id;
        
        $query = Recipe::find()
            ->joinWith('favorites')
            ->where(['favorite.user_id' => $userId])
            ->orderBy(['favorite.added_at' => SORT_DESC]);

        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 6,
        ]);

        $recipes = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('favorites', [
            'recipes' => $recipes,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Добавить или удалить из избранного
     */
    public function actionToggleFavorite($id)
    {
        if (Yii::$app->user->isGuest) {
            if (Yii::$app->request->isAjax) {
                return $this->asJson(['success' => false, 'message' => 'Нужно войти']);
            }
            return $this->redirect(['site/login']);
        }

        $recipe = Recipe::findOne($id);
        if (!$recipe) {
            if (Yii::$app->request->isAjax) {
                return $this->asJson(['success' => false, 'message' => 'Рецепт не найден']);
            }
            throw new \yii\web\NotFoundHttpException('Рецепт не найден');
        }

        $userId = Yii::$app->user->id;
        $favorite = Favorite::findOne(['user_id' => $userId, 'recipe_id' => $id]);
        $message = '';

        if ($favorite) {
            $favorite->delete();
            $message = 'Удалено из избранного.';
        } else {
            $fav = new Favorite();
            $fav->user_id = $userId;
            $fav->recipe_id = $id;
            if ($fav->save()) {
                $message = 'Добавлено в избранное! ❤️';
            } else {
                $message = 'Ошибка при сохранении.';
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->asJson([
                'success' => true, 
                'action' => $favorite ? 'removed' : 'added',
                'message' => $message
            ]);
        } else {
            Yii::$app->session->setFlash('success', $message);
            return $this->redirect(Yii::$app->request->referrer ?: ['site/recipes']);
        }
    }

    /**
     * Редактирование профиля (ЕДИНСТВЕННЫЙ ЭКЗЕМПЛЯР)
     */
    public function actionEditProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $user = User::findOne(Yii::$app->user->id);
        if (!$user) {
            throw new \yii\web\NotFoundHttpException('Пользователь не найден.');
        }

        $avatarFile = UploadedFile::getInstance($user, 'avatar_path');
        
        if ($user->load(Yii::$app->request->post())) {
            if ($avatarFile) {
                $dir = Yii::getAlias('@webroot/images/avatars/');
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                
                $fileName = uniqid() . '.' . $avatarFile->extension;
                $avatarFile->saveAs($dir . $fileName);
                
                if ($user->avatar_path && file_exists(Yii::getAlias('@webroot' . $user->avatar_path))) {
                    unlink(Yii::getAlias('@webroot' . $user->avatar_path));
                }
                
                $user->avatar_path = '/images/avatars/' . $fileName;
            }

            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Профиль успешно обновлен!');
                return $this->redirect(['site/profile']);
            }
        }

        return $this->render('edit-profile', ['model' => $user]);
    }

    /**
     * Удаление рецепта
     */
    public function actionDeleteRecipe($id)
    {
        if (Yii::$app->user->isGuest) {
            throw new \yii\web\ForbiddenHttpException('Доступ запрещен.');
        }

        $model = Recipe::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Рецепт не найден.');
        }

        if ($model->author_id != Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException('Вы можете удалять только свои рецепты.');
        }

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Рецепт удален.');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка при удалении.');
        }

        return $this->redirect(['site/profile']);
    }

    /**
     * Редактирование рецепта
     */
    public function actionEditRecipe($id)
    {
        if (Yii::$app->user->isGuest) {
            throw new \yii\web\ForbiddenHttpException('Доступ запрещен.');
        }

        $model = Recipe::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Рецепт не найден.');
        }

        if ($model->author_id != Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException('Вы можете редактировать только свои рецепты.');
        }

        if ($model->load(Yii::$app->request->post())) {
            $imageFile = UploadedFile::getInstance($model, 'image_path');
            if ($imageFile) {
                if ($model->image_path && file_exists(Yii::getAlias('@webroot' . $model->image_path))) {
                    unlink(Yii::getAlias('@webroot' . $model->image_path));
                }
                
                $dir = Yii::getAlias('@webroot/images/recipes/');
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                
                $fileName = uniqid() . '.' . $imageFile->extension;
                $imageFile->saveAs($dir . $fileName);
                $model->image_path = '/images/recipes/' . $fileName;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Рецепт успешно обновлен!');
                return $this->redirect(['recipe', 'id' => $model->id]);
            }
        }

        return $this->render('edit-recipe', [
            'model' => $model,
        ]);
    }
}