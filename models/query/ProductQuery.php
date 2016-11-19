<?php

namespace app\models\query;
use app\models\Category;
use app\models\ProductTag;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Product]].
 *
 * @see \app\models\Product
 */
class ProductQuery extends ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['active' => true]);
    }

    /**
     * @param integer $id
     * @return self
     */
    public function forCategory($id)
    {
        $ids = [$id];
        $childrenIds = [$id];
        while ($childrenIds = Category::find()->select('id')->andWhere(['parent_id' => $childrenIds])->column()) {
            $ids = array_merge($ids, $childrenIds);
        }
        /**
         * Выводит себя и также вложенные идентификаторы
         * В метод andWhere передается массив получается пример так
         * WHERE IN (1,2,3)
         */
        //self::show(array_unique($ids));
        return $this->andWhere(['category_id' => array_unique($ids)]);
    }

    /**
     * @param integer $id
     * @return self
     */
    public function forTag($id)
    {
        return $this->joinWith(['productTags'], false)->andWhere([ProductTag::tableName() . '.tag_id' => $id]);
    }

    /**
     * @inheritdoc
     * @return \app\models\Product[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Product|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    static function show($array){
        echo '<pre style="margin:80px;">'; print_r($array); echo '</pre>';
    }
}
