<?php
require_once('databaseEntity_class.php');

Class Comment extends DatabaseEntity{
    public $comment_id, $account_id, $blog_id, $contents, $comment_datetime;

    function __construct($params){
        parent::__construct("Comments");
        $this->unpack($params);
    }

    function unpack($params){
        if(isset($params['comment_id'])){
            $this->comment_id = $params['comment_id'];
        }
        if(isset($params['account_id'])){
            $this->account_id = $params['account_id'];
        }
        if(isset($params['blog_id'])){
            $this->blog_id = $params['blog_id'];
        }
        if(isset($params['contents'])){
            $this->contents = $params['contents'];
        }
        if(isset($params['comment_datetime'])){
            $this->comment_datetime = $params['comment_datetime'];
        }
    }
    function decrypt($params){
        if(isset($params['iv'])){
            $this->iv = $params['iv'];
            if(isset($params['contents'])){
                $params['contents'] = $this->decrypt($params['contents']);
            }
            $this->unpack($params);
            return true;
        }
        else{
            return false;
        }
    }

    static function loadComments($params){
        $comment_array = array();
        if(isset($params['blog_id'])){
            $order = 'DESC';
            if(isset($params['order'])){
                $order = $params['order'];
            }
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Comments WHERE blog_id=:blog_id ORDER BY comment_datetime ' . $order;
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_id', $params['blog_id'], SQLITE3_INTEGER);
            $result = $stmt->execute();
            $i = 0;
            while($row = $result->fetchArray()){
                $comment_array[$i] = new Comment(false);
                $comment_array[$i]->decrypt($row);
                $i += 1;
            }
            $db->close();
        }
        return $comment_array;
    }

    function loadComment(){
        $result = false;
        if($this->comment_id){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Comments WHERE comment_id=:comment_id';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':comment_id', $this->comment_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            if($result){
                $row = $result->fetchArray();
                $result = $this->decrypt($row);
            }
            $db->close();
        }
        return $result;
    }

    function createComment(){
        $result = false;
        if($this->account_id && $this->blog_id && $this->contents){
            $iv = $this->createIV();
            $this->iv = $iv;
            $contents = $this->encrypt($this->contents);
            $db = new SQLite3('../data/database.db');
            $sql = 'INSERT INTO Comments(account_id, blog_id, contents, comment_datetime, iv) VALUES(:account_id, :blog_id, :contents, datetime(:comment_datetime), :iv)';
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':account_id', $this->account_id, SQLITE3_INTEGER);
            $stmt->bindParam(':blog_id', $this->blog_id, SQLITE3_INTEGER);
            $stmt->bindParam(':contents', $contents, SQLITE3_TEXT);
            if(!$this->comment_datetime){
                $this->comment_datetime = date('Y-m-d H:i:s');
                echo $this->blog_datetime;
            }
            $stmt->bindParam(':comment_datetime', $this->comment_datetime, SQLITE3_TEXT);
            $stmt->bindParam(':iv', $iv, SQLITE_TEXT);

            $result = $stmt->execute();
            if($result){
                $this->comment_id = $db->lastInsertRowID();
            }
            $db->close();
        }
        return $result;
    }

    static function deleteComments($params){
        $result = false;
        if(isset($params['blog_id']) && $params['blog_id']){
            $db = new SQLite3('../data/database.db');
            $sql = 'DELETE FROM Comments WHERE blog_id=:blog_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_id', $params['blog_id'], SQLITE3_INTEGER);
            $result = $db->execute();
            $db->close();
        }
        return $result;
    }

    function deleteComment(){
        $result = false;
        if($this->comment_id){
            $db = new SQLite3('../data/database.db');
            $sql = 'DELETE FROM Comments WHERE comment_id=:comment_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':comment_id', $this->comment_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            $db->close();
        }
        return $result;
    }
}