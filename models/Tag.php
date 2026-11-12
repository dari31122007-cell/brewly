<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $name Название тега (шоколад, ягоды...)
 * @property string|null $color Цвет бейджа в HEX
 *
 * @property RecipeTag[] $recipeTags
 * @property Recipe[] $recipes
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['color'], 'string', 'max' => 7],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'color' => 'Color',
        ];
    }

    /**
     * Gets query for [[RecipeTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeTags()
    {
        return $this->hasMany(RecipeTag::className(), ['tag_id' => 'id']);
    }

    /**
     * Gets query for [[Recipes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])->viaTable('recipe_tag', ['tag_id' => 'id']);
    }
}
