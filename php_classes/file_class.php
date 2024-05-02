<?php
require_once('databaseEntity_class.php');

Class UserFile extends DatabaseEntity{
    public $file_id, $file_use, $account_id, $blog_id, $file_name, $mime_type, $file_url;
    static public $file_uses = array("pfp", "banner", "blog_pic", "blog_vid");
    static public $blog_only = array("blog_pic", "blog_vid");

    function __construct($params){
        parent::__construct("User_files");
        $this->unpack($params);
    }

    function unpack($params){
        if(isset($params['file_id'])){
            $this->file_id = $params['file_id'];
        }
        if(isset($params['file_use'])){
            $this->file_use = $params['file_use'];
        }
        if(isset($params['account_id'])){
            $this->account_id = $params['account_id'];
        }
        if(isset($params['blog_id'])){
            $this->blog_id = $params['blog_id'];
        }
        if(isset($params['file_name'])){
            $this->file_name = $params['file_name'];
        }
        if(isset($params['mime_type'])){
            $this->mime_type = $params['mime_type'];
        }
        if(isset($params['file_url'])){
            $this->file_url = $params['file_url'];
        }
    }

    static function loadFiles($params){
        $file_array = array();
        if(isset($params['blog_id'])){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM User_files WHERE blog_id=:blog_id';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_id', $params['blog_id'], SQLITE3_INTEGER);
            $result = $stmt->execute();
            while($row = $result->fetchArray()){
                $file_array[] = new UserFile($row);
            }
            $db->close();
        }
        return $file_array;
    }

    function loadFile(){
        $result = false;
        if($this->account_id && $this->file_use){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM User_files WHERE account_id=:account_id AND file_use=:file_use';
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':account_id', $this->account_id, SQLITE3_INTEGER);
            $stmt->bindParam(':file_use', $this->file_use, SQLITE3_TEXT);
            $result = $stmt->execute();
            if($result){
                $row = $result->fetchArray();
                $result = $this->unpack($row);
            }
            $db->close();
        }
        return $result;
    }

    function createFile(){
        $result = false;
        if($this->file_use && isset(UserFile::$file_uses[$this->file_use]) && $this->account_id && ($this->blog_id || isset(UserFile::$blog_only[$this->file_use])) && $this->file_type && $this->mime_type){
            $db = new SQLite3('../data/database.db');
            $sql = 'INSERT INTO User_files(file_use, account_id, blog_id, file_name, mime_type) VALUES(:file_use, :account_id, :blog_id, :file_name, :mime_type)';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':file_use', $this->file_use, SQLITE3_TEXT);
            $stmt->bindParam(':account_id', $this->account_id, SQLITE3_INTEGER);
            $stmt->bindParam(':blog_id', $this->blog_id, SQLITE3_INTEGER);
            $stmt->bindParam(':file_name', $this->file_name, SQLITE3_TEXT);
            $stmt->bindParam(':mime_type', $this->mime_type, SQLITE3_TEXT);
            
            $result = $stmt->execute();
            if($result){
                $this->file_id = $db->lastInsertRowID();
                $file_url = $this->encryptUnique($this->file_id);

                $sql = 'UPDATE User_files SET file_url=:file_url WHERE file_id=:file_id';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':file_url', $file_url, SQLITE3_TEXT);
                $stmt->bindParam(':file_id', $this->file_id, SQLITE3_INTEGER);
                $result = $stmt->execute();
            }
            $db->close();
        }
        return $result;
    }

    static function deleteFiles($params){
        $result = false;
        if(isset($params['blog_id']) && $params['blog_id']){
            $db = new SQLite3('../data/database.db');
            $sql = 'DELETE FROM User_files WHERE blog_id=:blog_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_id', $params['blog_id'], SQLITE3_INTEGER);
            $result = $db->execute();
            $db->close();
        }
        else if(isset($params['account_id']) && $params['account_id']){
            $db = new SQLite3('../data/database.db');
            $sql = 'DELETE FROM User_files WHERE account_id=:account_id AND blog_id=null';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':account_id', $params['account_id'], SQLITE3_INTEGER);
            $result = $db->execute();
            $db->close();
        }
        return $result;
    }

    function deleteFile(){
        $result = false;
        if($this->file_id){
            $db = new SQLite3('../data/database.db');
            $sql = 'DELETE FROM User_files WHERE file_id=:file_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':file_id', $this->file_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            $db->close();
        }
        return $result;
    }
}