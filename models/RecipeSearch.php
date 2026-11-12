<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recipe;

/**
 * RecipeSearch represents the model behind the search form of `app\models\Recipe`.
 */
class RecipeSearch extends Recipe
{
    // Новые свойства для фильтров
    public $category_filter; // Для выбора категории кнопками
    public $acidity_min;     // Кислотность (мин)
    public $acidity_max;     // Кислотность (макс)
    public $bitterness_min;  // Горечь (мин)
    public $bitterness_max;  // Горечь (макс)
    public $sweetness_min;   // Сладость (мин)
    public $sweetness_max;   // Сладость (макс)
    public $body_min;        // Тело (мин)
    public $body_max;        // Тело (макс)

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'category_id', 'views_count', 'status'], 'integer'],
            [['title', 'slug', 'description', 'ingredients', 'steps', 'prep_time', 'difficulty', 'tags', 'image_path', 'created_at', 'updated_at'], 'safe'],
            
            // Правила для новых фильтров
            [['category_filter'], 'safe'],
            [['acidity_min', 'acidity_max', 'bitterness_min', 'bitterness_max', 'sweetness_min', 'sweetness_max', 'body_min', 'body_max'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        // Не используем with() здесь, чтобы не мешать joinWith ниже
        $query = Recipe::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // 1. Фильтр по названию
        $query->andFilterWhere(['like', 'recipe.title', $this->title]);

        // 2. Фильтр по ID категории (старый способ, если вдруг используется)
        if ($this->category_id) {
            $query->andFilterWhere(['recipe.category_id' => $this->category_id]);
        }

        // 3. Фильтр по Slug категории (НОВЫЙ СПОСОБ - КНОПКИ)
        if (!empty($this->category_filter)) {
            // Делаем JOIN с таблицей category
            $query->joinWith('category'); 
            // Фильтруем строго по slug
            $query->andFilterWhere(['category.slug' => $this->category_filter]);
        }

        // 4. Фильтры по вкусу (только если колонки существуют)
        // Проверка на существование колонок, чтобы не ломалось, если миграция не применена
        $tableSchema = \Yii::$app->db->schema->getTableSchema('{{%recipe}}');
        $hasTasteColumns = $tableSchema && 
                           isset($tableSchema->columns['acidity']) && 
                           isset($tableSchema->columns['bitterness']);

        if ($hasTasteColumns) {
            if ($this->acidity_min !== null && $this->acidity_min !== '') {
                $query->andFilterWhere(['>=', 'recipe.acidity', $this->acidity_min]);
            }
            if ($this->acidity_max !== null && $this->acidity_max !== '') {
                $query->andFilterWhere(['<=', 'recipe.acidity', $this->acidity_max]);
            }

            if ($this->bitterness_min !== null && $this->bitterness_min !== '') {
                $query->andFilterWhere(['>=', 'recipe.bitterness', $this->bitterness_min]);
            }
            if ($this->bitterness_max !== null && $this->bitterness_max !== '') {
                $query->andFilterWhere(['<=', 'recipe.bitterness', $this->bitterness_max]);
            }

            if ($this->sweetness_min !== null && $this->sweetness_min !== '') {
                $query->andFilterWhere(['>=', 'recipe.sweetness', $this->sweetness_min]);
            }
            if ($this->sweetness_max !== null && $this->sweetness_max !== '') {
                $query->andFilterWhere(['<=', 'recipe.sweetness', $this->sweetness_max]);
            }

            if ($this->body_min !== null && $this->body_min !== '') {
                $query->andFilterWhere(['>=', 'recipe.body', $this->body_min]);
            }
            if ($this->body_max !== null && $this->body_max !== '') {
                $query->andFilterWhere(['<=', 'recipe.body', $this->body_max]);
            }
        }

        return $dataProvider;
    }
}