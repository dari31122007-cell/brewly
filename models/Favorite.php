<?php
namespace app\models;
use Yii;

class Favorite extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'favorite';
    }

    public function rules()
    {
        return [
            [['user_id', 'recipe_id'], 'required'],
            [['user_id', 'recipe_id'], 'integer'],
            [['user_id', 'recipe_id'], 'unique', 'targetAttribute' => ['user_id', 'recipe_id']],
        ];
    }

    public function getRecipe()
    {
        return $this->hasOne(Recipe::className(), ['id' => 'recipe_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}