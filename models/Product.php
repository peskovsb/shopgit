<?php

namespace app\models;

use app\models\query\ProductQuery;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $content
 * @property integer $price
 * @property integer $active
 *
 * @property Category $category
 * @property ProductTag[] $productTags
 * @property Tag[] $tags
 * @property Value[] $values
 * @property Attribute[] $productAttributes
 */
class Product extends ActiveRecord
{
    public $imageFiles;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'price', 'active','mainflag'], 'integer'],
            [['name', 'price'], 'required'],
            [['content'], 'string'],
            [['tagsArray','prodpics'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'name' => 'Название',
            'content' => 'Наполнение',
            'price' => 'Цена',
            'active' => 'Активность',
            'tagsArray' => 'Тэги',
            'mainflag' => 'Показывать на главной',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTags()
    {
        return $this->hasMany(ProductTag::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('{{%product_tag}}', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Value::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttributes()
    {
        return $this->hasMany(Attribute::className(), ['id' => 'attribute_id'])->viaTable('{{%value}}', ['product_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    private $_tagsArray;

    public function getTagsArray()
    {
        if ($this->_tagsArray === null) {
            $this->_tagsArray = $this->getTags()->select('id')->column();
        }
        return $this->_tagsArray;
    }

    public function setTagsArray($value)
    {
        $this->_tagsArray = (array)$value;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->updateTags();
        parent::afterSave($insert, $changedAttributes);
    }

    private function updateTags()
    {
        $currentTagIds = $this->getTags()->select('id')->column();
        $newTagIds = $this->getTagsArray();

        foreach (array_filter(array_diff($newTagIds, $currentTagIds)) as $tagId) {
            /** @var Tag $tag */
            if ($tag = Tag::findOne($tagId)) {
                $this->link('tags', $tag);
            }
        }

        foreach (array_filter(array_diff($currentTagIds, $newTagIds)) as $tagId) {
            /** @var Tag $tag */
            if ($tag = Tag::findOne($tagId)) {
                $this->unlink('tags', $tag, true);
            }
        }
    }

    /**
     * [Получаем специальные предложения на главной]
     * @author Peskov Sergey
     * @date 19/11/2016
     * return [array]
     */
    public function getSpecialOffers(){
        $query = Product::find()->where(['active'=>1,'mainflag'=>1])->all();
        return $query;
    }

    /**
     * [Получаем ссылку на первую картинку из массива в Товаре]
     * @author Peskov Sergey
     * @date 19/11/2016
     * @return [url img]
     */
    public function getFirstImg(){
        if($this->prodpics){
            $jsonDecode = json_decode($this->prodpics);
            if(count($jsonDecode)>0){
                return $jsonDecode[0];
            }else{
                return 'empty.jpg';
            }
        }
    }
}
