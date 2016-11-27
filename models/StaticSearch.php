<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Staticpages;

/**
 * StaticSearch represents the model behind the search form about `app\models\Staticpages`.
 */
class StaticSearch extends Staticpages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'statuspage'], 'integer'],
            [['alias', 'detailtext', 'pics', 'previewtext', 'dttm'], 'safe'],
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
        $query = Staticpages::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'statuspage' => $this->statuspage,
            'dttm' => $this->dttm,
        ]);

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'detailtext', $this->detailtext])
            ->andFilterWhere(['like', 'pics', $this->pics])
            ->andFilterWhere(['like', 'previewtext', $this->previewtext]);

        return $dataProvider;
    }
}
