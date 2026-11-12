<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recipe".
 */
class Recipe extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'recipe';
    }

    public function rules()
    {
        return [
            // УБРАЛИ 'slug' из обязательных, так как генерируем его автоматически
            [['title', 'description', 'ingredients', 'steps', 'category_id'], 'required'],
            
            [['description', 'ingredients', 'steps', 'difficulty', 'prep_time', 'slug', 'image_path', 'volume'], 'string'],
            
            // 'safe' позволяет модели принимать данные с ползунков из формы без ошибок валидации
            [['acidity', 'bitterness', 'sweetness', 'body', 'category_id', 'author_id', 'views_count', 'favorites_count', 'status'], 'integer', 'min' => 0],
            [['acidity', 'bitterness', 'sweetness', 'body'], 'safe'],
            
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'slug', 'image_path'], 'string', 'max' => 255],
            [['prep_time'], 'string', 'max' => 50],
            [['volume'], 'string', 'max' => 20],
            [['slug'], 'unique'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'slug' => 'URL-адрес',
            'description' => 'Описание',
            'ingredients' => 'Ингредиенты',
            'steps' => 'Шаги',
            'prep_time' => 'Время приготовления',
            'difficulty' => 'Сложность',
            'volume' => 'Объем',
            'acidity' => 'Кислотность',
            'bitterness' => 'Горечь',
            'sweetness' => 'Сладость',
            'body' => 'Плотность',
            'image_path' => 'Изображение',
            'category_id' => 'Категория',
            'author_id' => 'Автор',
            'views_count' => 'Просмотры',
            'favorites_count' => 'В избранном',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getFavorites()
    {
        return $this->hasMany(Favorite::className(), ['recipe_id' => 'id']);
    }

    public function getRecipeTags()
    {
        return $this->hasMany(RecipeTag::className(), ['recipe_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('recipe_tag', ['recipe_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('favorite', ['recipe_id' => 'id']);
    }
}