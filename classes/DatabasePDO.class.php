<?php

//use Exception;
//use PDO;

/**
 * @property PDOStatement $stmt PDO Statement
 */
class DatabasePDO
{
    const GET_ALL = "GET_ALL";
    const GET_ROW = "GET_ROW";
    const GET_ONE = "GET_ONE";

    protected
            $hostname = "",
            $username = "",
            $password = "",
            $database = "",
            $charset = "utf8",
            $dsn      = "",
            $port     = 3306,
            $db       = null,
            $stmt     = null,
            $dbConfig = array();

    /**
     *
     * @param type $hostname
     * @param type $username
     * @param type $password
     * @param type $database
     * @param type $port
     */
    public function __construct($hostname = null, $username = null, $password = null, $database = null, $port = null, $charset = null){
        $this->dbConfig["hostname"] = ($hostname !== null) ? $hostname : $this->hostname;
        $this->dbConfig["username"] = ($username !== null) ? $username : $this->username;
        $this->dbConfig["password"] = ($password !== null) ? $password : $this->password;
        $this->dbConfig["database"] = ($database !== null) ? $database : $this->database;
        $this->dbConfig["port"]     = ($port !== null) 	   ? $port 	   : $this->port;
        $this->dbConfig["charset"]  = ($charset !== null)  ? $charset  : $this->charset;
    }

    /**
     * Sets connection settings
     * @param array $config
     */
    public function setConnectionParams(array $config){
        $this->dbConfig = $config;
    }

    /**
     * Makes a connection to the database (Should not be called manually).
     * @return \Mysql
     * @throws Exception
     */
    public function connect(){
        if($this->db !== null) {
            return;
        }
        //echo "connecting...";
        try{
            $this->db = new PDO("mysql:dbname={$this->dbConfig["database"]};charset={$this->dbConfig["charset"]};"
                    . "host={$this->dbConfig["hostname"]};"
                    . "port={$this->dbConfig["port"]}", $this->dbConfig["username"], $this->dbConfig["password"]
            , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            return $this;
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * Attempts to create connection to database to see a connection can be made
     * @return boolean
     */
    public function canConnect(){
        try{
            $this->connect();
        }catch(PDOException $ex){
            return false;
        }
        return true;
    }

    /**
     * Attempts to create connection to database to see a connection can not be made
     * @return boolean
     */
    public function canNotConnect(){
        try{
            $this->connect();
        }catch(Exception $ex){
            return true;
        }
        return false;
    }

    /**
     * Executes a database query
     * @param string $query
     * @param array $params
     * @return boolean
     * @throws \Modules\Exception
     */
    public function query($query, array $params = array())
	{
        try
		{
            $this->connect();
            $this->queryString = $query;
            $this->stmt        = $this->db->prepare($query);
            $this->bind($query, $params);
            $this->stmt->execute();
            return true;
        }
		catch(Exception$e)
		{
            throw $e;
        }
    }

    /**
     * Get all results from a database query
     * @param string $query
     * @param array $params
     * @param boolean $qstr
     * @return mixed
     * Returns an array or false on error
     */
    public function getAll($query, array $params = array())
	{
        $error = ! $this->query($query, $params);
		return $error ? false : $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get one row from a database query
     * @param string $query
     * @param array $params
     * @param boolean $qstr
     * @return array
     */
    public function getRow($query, array $params = array())
	{
		$error = ! $this->query($query, $params);
		return $error ? false : $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get one column from a database query
     * @param string $query
     * @param array $params
     * @param boolean $qstr
     * @return mixed
     */
    public function getOne($query, array $params = array()){
		$error = ! $this->query($query, $params);
		return $error ? false : $this->stmt->fetchColumn(0);
    }

    /**
     * Gets the next row in the data set
     * @param int $style
     * @return mixed
     */
    public function getNext($style = PDO::FETCH_ASSOC){
        return $this->stmt->fetch($style);
    }

    /**
     * Gets the next dataset in a multi dataset query
     * @param int $style
     * @return mixed
     */
    public function getNextSet($style = DBO::GET_ALL){
        $this->stmt->nextRowset();
        switch($style){
            case DBO::GET_ALL:
                return $this->stmt->fetchAll();
            case DBO::GET_ROW:
                return $this->stmt->fetch();
            case DBO::GET_ONE:
                return $this->stmt->fetchColumn(0);
            default:
                return $this->stmt->fetchAll();
        }
    }

    /**
     * Gets the number of rows found from the previous query
     * @alias getAffectedRows()
     * @return int
     */
    public function rowCount(){
        return $this->stmt->rowCount();
    }

    /**
     * Gets the number of columns found from the previous query
     * @return int
     */
    public function columnCount(){
        return $this->stmt->columnCount();
    }

    /**
     * Gets the number of rows found when using SQL_CALC_FOUND_ROWS
     * @return type
     */
    public function foundRows(){
        return (int)$this->getOne("select found_rows()");
    }

    /**
     * Creates a named lock
     * @param string $name
     * @return bool
     */
    public function getLock($name){
        return (bool)$this->getOne("SELECT GET_LOCK(?, 0)", array((string)$name));
    }

    /**
     * Releases a named lock
     * @param string $name
     * @return bool
     */
    public function releaseLock($name){
        return (bool)$this->getOne("SELECT RELEASE_LOCK(?)", array((string)$name));
    }

    /**
     * Gets the name of a column in a resultset
     * @param int $column The column number using a zero offset
     * @return string
     */
    public function fieldName($column){
        $meta = $this->stmt->getColumnMeta($column);
        return $meta["name"];
    }

    /**
     * Get the last auto increment insert id
     * @return integer
     */
    public function getInsertID(){
        return $this->db->lastInsertId();
    }

    /**
     * Get the number of rows affected by the last query
     * @return integer
     */
    public function getAffectedRows(){
        return $this->stmt->rowCount();
    }

    /**
     * Start a database transaction
     * @return boolean
     */
    public function beginTransaction(){
        $this->connect();
        return $this->db->beginTransaction();
    }

    /**
     * Commit a database transaction
     * @return boolean
     */
    public function commitTransaction(){
        $this->connect();
        return $this->db->commit();
    }

    /**
     * Roll back a database transaction
     * @return boolean
     */
    public function rollBackTransaction(){
        $this->connect();
        return $this->db->rollBack();
    }

    /**
     * Makes parameters MySQL safe
     * @param type $params
     */
    protected function bind($query, array $params) {
        if(strpos($query, "?")){
            array_unshift($params, null);
            unset($params[0]);
        }
        foreach($params as $key => $val){
            switch(gettype($val)){
                case "boolean":
                    $type = PDO::PARAM_BOOL;
                    break;
                case "integer":
                    $type = PDO::PARAM_INT;
                    break;
                case "string":
                    $type = PDO::PARAM_STR;
                    break;
                case "null":
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
            $this->stmt->bindValue($key, $val, $type);
        }
    }	
	
	public function __sleep()
	{
		return array();
	}
}
