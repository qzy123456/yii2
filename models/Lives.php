<?php
/**
 * Created by PhpStorm.
 * User: artist
 * Date: 2019-10-17
 * Time: 12:07
 */
namespace app\models;
use yii\base\Model;
use yii\redis\ActiveRecord;
class Lives extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return ['test','lives'];
    }

    /**
     * @inheritdoc
     */
    public function attributes() {
        return [
            '_id',
            'id',
            'room_id',
            'uid'
        ];
    }




}