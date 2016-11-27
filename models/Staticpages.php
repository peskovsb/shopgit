<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "staticpages".
 *
 * @property integer $id
 * @property string $alias
 * @property string $detailtext
 * @property string $pics
 * @property string $previewtext
 * @property integer $statuspage
 * @property string $dttm
 */
class Staticpages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staticpages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'titlename', 'detailtext', 'previewtext'], 'required'],
            [['detailtext', 'previewtext', 'titlename'], 'string'],
            [['statuspage'], 'integer'],
            [['dttm'], 'safe'],
            [['alias', 'pics'], 'string', 'max' => 225],
            [['alias'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => 'Alias',
            'detailtext' => 'Detailtext',
            'pics' => 'Pics',
            'previewtext' => 'Previewtext',
            'statuspage' => 'Statuspage',
            'dttm' => 'Dttm',
        ];
    }
}
