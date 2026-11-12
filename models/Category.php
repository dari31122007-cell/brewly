<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name Название категории
 * @property string $slug URL-friendly название (espresso, milk...)
 * @property string|null $icon_svg SVG иконка категории
 * @property int|null $sort_order Порядок сортировки
 *
 * @property Recipe[] $recipes
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['icon_svg'], 'string'],
            [['sort_order'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 100],
            [['slug'], 'unique'],
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
            'slug' => 'Slug',
            'icon_svg' => 'Icon Svg',
            'sort_order' => 'Sort Order',
        ];
    }

    /**
     * Gets query for [[Recipes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['category_id' => 'id']);
    }
}
