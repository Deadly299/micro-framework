<?php

namespace app\db;


class Query
{
    const INDENT = ' ';
    const OPEN_BRACKET = '(';
    const CLOSE_BRACKET = ')';
    const WHERE = ' WHERE ';
    const FROM = 'FROM';
    const SET = 'SET';
    const VALUES = 'VALUES';
    const LIMIT = 'LIMIT';
    const OFFSET = 'OFFSET';
    const OPERATOR_OR = ' AND ';
    const OPERATOR_AND = ' AND ';
    const OPERATOR_ASSIGNMENT = '=';
    const SORT_TYPE_ASC = 'asc';
    const SORT_TYPE_DESC = 'desc';

    protected $db;
    protected $sql;
    protected $tableName;
    protected $fields;
    protected $_orderBy;
    protected $_where;
    protected $_andWhere;
    protected $_orWhere;
    protected $_limit;
    protected $_offset;
    protected $conditions;
    protected $binds;
    protected $class;

    public function __construct($class)
    {
        $this->tableName = $class::tableName();
        $this->class = $class;
        $this->db = Connection::$db;
    }

    public function getTableFields()
    {
        $columns = [];
        $this->sql = 'SHOW COLUMNS ' . self::FROM . self::INDENT . $this->tableName;
        if ($query = $this->db->query($this->sql)) {
            while ($row = $query->fetchObject()) {
                $columns[] = $row->Field;
            }
            return $columns;
        }
        return null;
    }

    public function select($fields = null)
    {
        $this->setFields($fields);

        return $this;
    }

    public function _insert()
    {
        $this->buildInsertQuery();

        if ($statement = $this->db->prepare($this->sql)) {
            $statement->execute($this->conditions);
            $this->id = $this->db->lastInsertId();
            return $this;
        }
    }

    public function _delete()
    {
        $this->buildDeleteQuery();

        if ($statement = $this->db->prepare($this->sql)) {
            $statement->execute($this->conditions);
            $this->id = $this->db->lastInsertId();
            return $this;
        }
    }

    public function _update()
    {
        $this->buildUpdateQuery();

        if ($statement = $this->db->prepare($this->sql)) {
            $statement->execute($this->conditions);
            return $this;
        }
    }

    public function where($conditions = null)
    {

        if ($conditions && is_array($conditions)) {

            $where = self::WHERE . self::OPEN_BRACKET;
            foreach ($conditions as $column => $condition) {
                $this->conditions[':' . $column] = $condition;
                $where .=
                    self::OPEN_BRACKET .
                    $column .
                    self::OPERATOR_ASSIGNMENT .
                    ':' . $column . self::CLOSE_BRACKET .
                    self::INDENT;
                if (next($conditions)) {
                    $where .= self::OPERATOR_AND;
                }
            }
            $where .= self::CLOSE_BRACKET;
            $this->_where = $where;
        }

        return $this;
    }

    public function orderBy($condition = null)
    {
        $this->_orderBy = self::INDENT . 'ORDER BY' . self::INDENT . $condition;

        return $this;
    }

    public function setOrderBy($sort)
    {
        if ($sort) {
            $sortType = self::SORT_TYPE_ASC;
            if ($sort[0] === '-') {
                $sortType = self::SORT_TYPE_DESC;
                $sort = mb_substr($sort, 1);
            }
            if (in_array($sort, $this->getTableFields())) {
                $this->orderBy($sort . ' ' . $sortType);
            }
        }

        return $this;
    }

    public function limit($count)
    {
        if (!is_null($count)) {
            $this->conditions[':limit'] = $count;
            $this->_limit = self::INDENT . self::LIMIT . self::INDENT . ':limit';
        }

        return $this;
    }

    public function offset($count)
    {
        if (!is_null($count)) {
            $this->conditions[':offset'] = $count;
            $this->_offset = self::INDENT . self::OFFSET . self::INDENT . ':offset';
        }

        return $this;
    }

    public function all()
    {
        $this->buildSelectQuery();
        if ($statement = $this->db->prepare($this->sql)) {
            $statement->execute($this->conditions);

            return $this->populate($statement);
        }

        return null;
    }

    public function count()
    {
        $this->buildSelectQuery();
        if ($statement = $this->db->prepare($this->sql)) {
            $statement->execute($this->conditions);

            return $statement->rowCount();
        }

        return null;
    }

    public function execute()
    {
        $this->buildSelectQuery();
        if ($statement = $this->db->prepare($this->sql)) {
            $statement->execute($this->conditions);

            return $statement;
        }

        return null;
    }

    public function one()
    {
        $this->buildSelectQuery();
        if ($statement = $this->db->prepare($this->sql)) {
            $statement->execute($this->conditions);

            return $statement->fetchObject($this->class);
        }

        return null;
    }

    protected function setFields($fields)
    {
        if ($fields) {
            $this->fields = implode(',', $fields);
        }
    }

    protected function setFieldsAndBind($fields)
    {
        if ($fields) {
            $this->fields = null;
            foreach ($fields as $key => $field) {

                $this->fields .= $field . self::OPERATOR_ASSIGNMENT . ':' . $field;
                if ($field != end($fields)) {
                    $this->fields .= ',';
                }
            }
        }
    }

    private function buildInsertQuery()
    {
        $this->setFields($this->fields);
        $sql = $this->sql = 'INSERT INTO' . self::INDENT;
        $sql .= $this->tableName . self::INDENT;
        $sql .= self::OPEN_BRACKET . $this->fields . self::CLOSE_BRACKET . self::INDENT;
        $sql .= self::VALUES . self::OPEN_BRACKET . implode(',', $this->binds) . self::CLOSE_BRACKET;
        $this->sql = $sql;
    }

    private function buildUpdateQuery()
    {
        $this->where(['id' => $this->id]);
        $this->setFieldsAndBind($this->fields);
        $sql = $this->sql = 'UPDATE' . self::INDENT;
        $sql .= $this->tableName . self::INDENT;
        $sql .= self::SET . self::INDENT;
        $sql .= $this->fields;
        $sql .= $this->_where;
        $this->sql = $sql;
    }

    private function buildDeleteQuery()
    {
        $this->where(['id' => $this->id]);
        $this->setFieldsAndBind($this->fields);
        $sql = $this->sql = 'DELETE FROM' . self::INDENT;
        $sql .= $this->tableName . self::INDENT;
        $sql .= $this->_where;
        $this->sql = $sql;
    }

    private function buildSelectQuery()
    {
        $sql = $this->sql = 'SELECT' . self::INDENT;
        $sql .= $this->fields ? $this->fields : '*';
        $sql .= self::FROM . self::INDENT . $this->tableName;
        $sql .= $this->_where;
        $sql .= $this->_orderBy;
        $sql .= $this->_limit;
        $sql .= $this->_offset;
        $this->sql = $sql;
    }

    private function populate($statement)
    {
        $rows = null;
        while ($row = $statement->fetchObject($this->class)) {
            $rows[] = $row;
        }

        return $rows;
    }
}