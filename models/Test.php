<?php
namespace app\models;

use Yii;

/**
 * This is the model class for collection "customer".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $id
 * @property mixed $name
 * @property mixed $province
 * @property mixed $city
 * @property mixed $town
 * @property mixed $address
 * @property mixed $lng
 * @property mixed $lat
 * @property mixed $create_time
 */
class Test extends \yii\mongodb\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return ['test','test'];
    }

    /**
     * @inheritdoc
     */
    public function attributes() {
        return [
            '_id',
            'name',
            'name1',
            'name2',
            'name3'
        ];
    }


}