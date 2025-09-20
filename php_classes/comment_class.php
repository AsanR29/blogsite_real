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
    function decryptValues($params){
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
            $limit = 10;
            $offset = 0;
            if(isset($params['order'])){
                $order = $params['order'];
            }
            if(isset($params['page'])){
                $offset = $limit * intval($params['page']);
            }
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT Comments.*, Accounts.username FROM Comments JOIN Accounts ON Comments.account_id = Accounts.account_id WHERE blog_id=:blog_id ORDER BY comment_datetime ' . $order . ' LIMIT ' . $limit . ' OFFSET ' . $offset;
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_id', $params['blog_id'], SQLITE3_INTEGER);
            $result = $stmt->execute();
            $i = 0;
            while($row = $result->fetchArray()){
                $comment_array[$i] = new Comment(false);
                $comment_array[$i]->decryptValues($row);
                $comment_array[$i]->username = $row['username'];
                $i += 1;
            }
            $db->close();
        }
        else if(isset($params['comment_id'])){
            $order = 'DESC';
            $limit = 1;
            $offset = 0;
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT Comments.*, Accounts.username FROM Comments JOIN Accounts ON Comments.account_id = Accounts.account_id WHERE comment_id=:comment_id ORDER BY comment_datetime ' . $order . ' LIMIT ' . $limit . ' OFFSET ' . $offset;
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':comment_id', $params['comment_id'], SQLITE3_INTEGER);
            $result = $stmt->execute();
            if($row = $result->fetchArray()){
                $comment_array[0] = new Comment(false);
                $comment_array[0]->decryptValues($row);
                $comment_array[0]->username = $row['username'];
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
                $result = $this->decryptValues($row);
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
            }
            $stmt->bindParam(':comment_datetime', $this->comment_datetime, SQLITE3_TEXT);
            $stmt->bindParam(':iv', $iv, SQLITE3_TEXT);

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
            $result = $stmt->execute();
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

    function removeID(){
        $this->comment_id = false;
        $this->account_id = false;
        $this->blog_id = false;
    }
}