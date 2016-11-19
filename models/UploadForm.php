<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use app\models\ResizeImg;

class UploadForm extends Model
{
    /**
     * @inheritdoc
     */
    public $prodpics;

    public static function tableName()
    {
        return '{{%product}}';
    }

    public function rules()
    {
        return [
            [['prodpics'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    /*public function upload()
    {
        if ($this->validate()) {
            foreach ($this->prodpics as $key => $file) {
                $nameFile = date('d-m-y') . '_' . $this->rus2translit($file->baseName) . '.' . $file->extension;
                $file->saveAs('uploads/original/' . $nameFile);

                $im = new ResizeImg(\Yii::getAlias("@app/web").'/uploads/original/'.$nameFile);

                $centreX = round($im->getWidth() / 2);
                $centreY = round($im->getHeight() / 2);

                if($centreX>$centreY){
                    $x1 = $centreX - $centreY;
                    $y1 = $centreY - $centreY;

                    $x2 = $centreX + $centreY;
                    $y2 = $centreY + $centreY;
                }else{
                    $x1 = $centreX - $centreX;
                    $y1 = $centreY - $centreX;

                    $x2 = $centreX + $centreX;
                    $y2 = $centreY + $centreX;
                }

                $im->crop($x1, $y1, $x2, $y2)->resample(250,250);
                $im->save(\Yii::getAlias("@app/web").'/uploads/thumb/'.$nameFile);

                $filesJson[] = $nameFile;
            }
            return $filesJson;
        } else {
            return false;
        }
    }*/

    public function upload()
    {

                //$nameFile = 'unosha.jpg';
                //$nameFile = 'butterf.png';
                $nameFile = 'piggy.png';
                //$nameFile = 'family_of_giraffes.jpg';
                //$file->saveAs('uploads/original/' . $nameFile);

                $im = new ResizeImg(\Yii::getAlias("@app/web").'/uploads/original/'.$nameFile);
                $croped = $im->compression(357,515);
                $croped->save(\Yii::getAlias("@app/web").'/uploads/thumb/new_'.$nameFile);

                $filesJson[] = $nameFile;

    }

    public function rus2translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        $str = strtr($string, $converter);
        $str = trim(strtolower($str));
        $str = preg_replace('/[-]/', '_', $str);
        $str = preg_replace('/[\s]+/', '_', $str);
        return $str;
    }

    /**
     * [Назначение ключей после удаления]
     * расстановка ключей после удаления
     * для корректного json_decode и добавления в базу
     * @author Peskov Sergey
     * @date 21/10/2016
     * return [array]
     */
    static public function my_sort($array){
        $array_sorted = [];
        foreach($array as $value){
            $array_sorted[] = $value;
        }
        return $array_sorted;
    }
}