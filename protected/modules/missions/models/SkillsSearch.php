<?php

namespace app\modules\missions\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\missions\models\Skills;

/**
 * SkillsSearch represents the model behind the search form about `app\modules\missions\models\Skills`.
 */
class SkillsSearch extends Skills
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activity_id'], 'integer'],
            [['title', 'develop', 'description', 'created_at', 'updated_at'], 'safe'],
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
        $query = Skills::find();

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
            'activity_id' => $this->activity_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'develop', $this->develop])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}