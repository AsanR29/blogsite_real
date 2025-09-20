<?php
require_once('databaseEntity_class.php');

Class Account extends DatabaseEntity{
    public $account_id, $username, $password, $email, $account_type, $email_code, $bio;

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
            $this->password = $params['password'];
        }
        if(isset($params['email'])){
            $this->email = $params['email'];
        }
        if(isset($params['account_type'])){
            $this->account_type = $params['account_type'];
        }
        if(isset($params['email_code'])){
            $this->email_code= $params['email_code'];
        }
        if(isset($params['bio'])){
            $this->bio = $params['bio'];
        }
    }

    function decryptValues($params){
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
                $this->decryptValues($row);
            }
            $db->close();
        }
        else if($this->username && $this->password){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Accounts WHERE username=:username';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $this->username, SQLITE3_TEXT);
            $result = $stmt->execute();
            if($result){
                $row = $result->fetchArray();
                $result = password_verify($this->password, $row['password']);
                if($result){
                    $this->decryptValues($row);
                }
            }
            $db->close();
        }
        else if($this->username){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT account_id FROM Accounts WHERE username=:username';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $this->username, SQLITE3_TEXT);
            $result = $stmt->execute();
            if($result){
                $row = $result->fetchArray();
                $this->unpack($row);
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
            $email_code = $this->createCode();

            $db = new SQLite3('../data/database.db');
            $result = $this->checkUnique($db);
            if($result == 0){
                $sql = 'INSERT INTO Accounts(username, password, email, account_type, email_code) VALUES(:username, :password, :email, :account_type, :email_code)';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':username', $this->username, SQLITE3_TEXT);
                $stmt->bindParam('password', $password, SQLITE3_TEXT);
                $stmt->bindParam(':email', $email, SQLITE3_TEXT);
                $stmt->bindParam(':account_type', $account_type, SQLITE3_INTEGER);
                $stmt->bindParam(':email_code', $email_code, SQLITE3_TEXT);
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

    function checkUnique($db){
        $sql = 'SELECT COUNT(*) FROM Accounts WHERE username=:username OR email=:email';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $this->username, SQLITE3_TEXT);
        $email = $this->encryptUnique($this->email);
        $stmt->bindParam(':email', $email, SQLITE3_TEXT);
        $result = $stmt->execute();
        $result = $result->fetchArray();
        return $result[0];
    }

    function updateAccount($params){
        $result = false;
        if(isset($params['account_type']) && $params['account_type'] != $this->account_type){
            $db = new SQLite3('../data/database.db');
            $sql = 'UPDATE Accounts SET account_type=:account_type WHERE account_id=:account_id';
            $stmt = $db->prepare($sql);
            $account_type = $params['account_type'];
            $stmt->bindParam(':account_type', $account_type, SQLITE3_INTEGER);
            $stmt->bindParam(':account_id', $this->account_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            if($result){
                $this->account_type = $params['account_type'];
            }
            $db->close();
        }
        else if(isset($params['email']) && $params['email'] != $this->email){
            $db = new SQLite3('../data/database.db');
            $this->email = $params['email'];
            $result = $this->checkUnique($db);
            if($result){
                $email = $this->encryptUnique($this->email);
                $account_type = ($this->account_type == 2) ? 1 : $this->account_type;   //unverify email
                $email_code = $this->createCode();

                $sql = 'UPDATE Accounts SET email=:email, account_type=:account_type, email_code=:email_code WHERE account_id=:account_id';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':email', $email, SQLITE3_TEXT);
                $stmt->bindParam(':account_type', $account_type, SQLITE3_INTEGER);
                $stmt->bindParam(':email_code', $email_code, SQLITE3_TEXT);
                $stmt->bindParam(':account_id', $this->account_id, SQLITE3_INTEGER);
                $result = $stmt->execute();
                if($result){
                    $this->account_type = $account_type;
                    $this->email_code = $email_code;
                }
            }
            $db->close();
        }
        else if(isset($params['username']) && $params['username'] != $this->username){
            $db = new SQLite3('../data/database.db');
            $this->username = $params['username'];
            $result = $this->checkUnique($db);
            if($result){
                $username = $this->username;

                $sql = 'UPDATE Accounts SET username=:username WHERE account_id=:account_id';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':username', $username, SQLITE3_TEXT);
                $stmt->bindParam(':account_id', $this->account_id, SQLITE3_INTEGER);
                $result = $stmt->execute();
                if($result){
                    $this->username = $username;
                }
            }
            $db->close();
        }
        else if(isset($params['email_code'])){
            $email_code = $this->createCode();
            $db = new SQLite3('../data/database.db');
            $sql = 'UPDATE Accounts SET email_code=:email_code WHERE account_id=:account_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email_code', $email_code, SQLITE3_TEXT);
            $stmt->bindParam(':account_id', $this->account_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            if($result){
                $this->email_code = $email_code;
            }
            $db->close();
        }
        else if(isset($params['password'])){
            $this->password = $params['password'];
            $password = $this->encryptPassword($this->password);

            $db = new SQLite3('../data/database.db');
            $sql = 'UPDATE Accounts SET password=:password WHERE account_id=:account_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':password', $password, SQLITE3_TEXT);
            $stmt->bindParam(':account_id', $this->account_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            $db->close();
        }
        else if(isset($params['bio']) && $params['bio'] != $this->bio){
            $this->bio = $params['bio'];

            $db = new SQLite3('../data/database.db');
            $sql = 'UPDATE Accounts SET bio=:bio WHERE account_id=:account_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':bio', $this->bio, SQLITE3_TEXT);
            $stmt->bindParam(':account_id', $this->account_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            $db->close();
        }
        return $result;
    }

    function createCode(){
        $chars = array_merge(range('0','9'), range('a','z'), range('A','Z'));
        $email_code = "";
        for($i = 0; $i < 6; $i++){
            $email_code .= $chars[random_int(0,61)];
        }
        return $email_code;
    }

    function deleteAccount(){
        $result = false;
        if($this->account_id){
            $db = new SQLite3('../data/database.db');
            $sql = 'DELETE FROM Accounts WHERE account_id=:account_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':account_id', $this->account_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            $db->close();
            if($result){
                require_once('file_class.php');
                $params = array('account_id'=>$this->account_id);
                $result = UserFile::deleteFiles($params);
            }
        }
        return $result;
    }
}