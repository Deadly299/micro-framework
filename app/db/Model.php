<?php

namespace app\db;

class Model extends Query
{
    public $isNewRecord = false;

    public function __construct($isNewRecord = false)
    {
        if ($this->isNewRecord = $isNewRecord) {
            $this->setDefaultAttributes();
        }
        $this->tableName = self::className();
        $this->db = Connection::$db;

        return true;
    }

    public static function className()
    {
        return static::tableName();
    }

    public static function tableName()
    {
        return get_called_class();
    }

    public function attributeLabels()
    {
        return [];
    }

    public function setDefaultAttributes()
    {
        foreach ($this->find()->getTableFields() as $column) {
            $this->$column = null;
        }
    }

    public function load($data = null)
    {
        if (isset($data[self::className()])) {
            foreach ($data[self::className()] as $field => $value) {
                $this->$field = strip_tags($value);
                $this->conditions[':' . $field] = strip_tags($value);
                $this->fields[] = $field;
                $this->binds[] = ':' . $field;
            }

            if (!$this->isNewRecord) {
                $this->conditions[':' . 'id'] = $this->id;
            }
            return true;
        }
        return false;
    }

    public function create()
    {
        if ($model = $this->_insert()) {
            $this->afterInsert($model);
        }

        return $model;
    }

    public function update()
    {
        if ($model = $this->_update()) {
            $this->afterUpdate($model);
        }

        return $model;
    }

    public function delete()
    {
        if ($model = $this->_delete()) {
            $this->afterDelete($model);
        }

        return $model;
    }

    public static function find()
    {
        return new Query(self::tableName());
    }

    public function afterInsert()
    {

    }

    public function afterUpdate()
    {

    }

    public function afterDelete()
    {

    }

}