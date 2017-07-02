<?php


namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Products;

/**
 * ProductsSearch represents the model behind the search form about `common\models\Products`.
 */
class ProductsSearch extends Products
{
    public $minPrice;
    public $maxPrice;
    public $categories;
    public $onShare;
    public $selShares;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['description', 'version', 'system_requirements', 'reviews', 'created_at', 'updated_at', 'name'], 'safe'],
            [['price', 'minPrice', 'maxPrice'], 'number'],
            [['categories', 'manufacturers', 'os', 'onShare', 'selShares'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [


        ];
    }

    /**
     * @inheritdoc
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

        $query = Products::find();

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            //return $dataProvider;
            return null;
        }
        $query->distinct()
            ->innerJoinWith('categories')
            ->innerJoinWith('manufacturers')
            ->innerJoinWith('os')
            ->andFilterWhere(['or', ['like', 'products.name', $this->name], ['like', 'products.description', $this->name]])
            ->andFilterWhere(['=', 'categories.name', $this->categories])
            ->andFilterWhere(['=', 'manufacturers.name', $this->manufacturers])
            ->andFilterWhere(['=', 'os.name', $this->os])
            ->andFilterWhere(['>=', 'price', $this->minPrice])
            ->andFilterWhere(['<=', 'price', $this->maxPrice]);


        if ($this->onShare)
            $query->innerJoinWith('shares')
                ->andFilterWhere(['=', 'shares.title', $this->selShares]);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ([
                'attributes' => [
                    'price',
                    'name'
                ],

            ]),
            'pagination' => [
                'pageSize' => 25
            ],

            //['defaultOrder' => ['price' => SORT_DESC,
            //                   'created_at'=> SORT_ASC]]
        ]);
        return $dataProvider;
    }
}
