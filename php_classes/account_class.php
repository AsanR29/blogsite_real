<?php
require_once('databaseEntity_class.php');

Class Account extends DatabaseEntity{
    public $account_id, $username, $password, $email, $account_type, $verified;

    function __construct($params){
        parent::__construct("Accounts");
        $this->unpack($params);
    }

    function unpack($params){
        if(isset($params['account_id'])){
            $this->account_id = $params['account_id'];
        }
        if(isset($params['username'])){
            $this->username = $params['username'];
        }
        if(isset($params['password'])){
            $this->password_get_info = $params['password'];
        }
        if(isset($params['email'])){
            $this->email = $params['email'];
        }
        if(isset($params['account_type'])){
            $this->account_type = $params['account_type'];
        }
        if(isset($params['verified'])){
            $this->verified = $params['verified'];
        }
    }

    function decrypt($params){
        if(isset($params['email'])){
            $params['email'] = $this->decryptUnique($params['email']);
        }
        $this->unpack($params);
    }
    function loadAccount(){
        $result = false;
        if($this->account_id){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Accounts WHERE account_id=:account_id';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':account_id', $this->account_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            if($result){
                $row = $result->fetchArray();
                $this->decrypt($row);
            }
            $db->close();
        }
        else if($this->username && $this->password){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Accounts WHERE username=:username AND password=:password';

            $stmt = $db->prepare($sql);
            $password = $this->encryptPassword($this->password);
            $stmt->bindParam(':username', $this->username, SQLITE3_TEXT);
            $stmt->bindParam(':password', $password, SQLITE3_TEXT);
            $result = $stmt->execute();
            if($result){
                $row = $result->fetchArray();
                $this->decrypt($row);
            }
            $db->close();
        }
        return $result;
    }

    function createAccount(){
        $result = false;
        if($this->username && $this->password && $this->email){
            $password = $this->encryptPassword($this->password);
            $email = $this->encryptUnique($this->email);
            $account_type = ($this->account_type) ? $this->account_type : 1;
            $verified = 0;

            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT COUNT(*) FROM Accounts WHERE username=:username OR email=:email';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $this->username, SQLITE3_TEXT);
            $stmt->bindParam(':email', $email, SQLITE3_TEXT);
            $result = $stmt->execute();
            if($result == 0){
                $sql = 'INSERT INTO Accounts(username, password, email, account_type, verified) VALUES(:username, :password, :email, :account_type, :verified)';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':username', $this->username, SQLITE3_TEXT);
                $stmt->bindParam('password', $password, SQLITE3_TEXT);
                $stmt->bindParam(':email', $email, SQLITE3_TEXT);
                $stmt->bindParam(':account_type', $account_type, SQLITE3_INTEGER);
                $stmt->bindParam(':verified', $verified, SQLITE3_INTEGER);
                $result = $stmt->execute();
                if($result){
                    $this->account_id = $db->lastInsertRowID();
                }
            }
            else{
                $result = false;
            }
            $db->close();
        }
        return $result;
    }
}