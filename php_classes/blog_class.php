<?php
require_once('databaseEntity_class.php');

Class BlogPost extends DatabaseEntity{
    public $blog_id, $account_id, $blog_datetime, $visibility, $title, $contents, $blog_url;
    public $blog_files = array();

    function __construct($params){
        parent::__construct("Blog_posts");
        $this->unpack($params);
    }

    function unpack($params){
        if(isset($params['blog_id'])){
            $this->blog_id = $params['blog_id'];
        }
        if(isset($params['account_id'])){
            $this->account_id = $params['account_id'];
        }
        if(isset($params['blog_datetime'])){
            $this->blog_datetime = $params['blog_datetime'];
        }
        if(isset($params['visibility'])){
            $this->visibility = $params['visibility'];
        }
        if(isset($params['title'])){
            $this->title = $params['title'];
        }
        if(isset($params['contents'])){
            $this->contents = $params['contents'];
        }
        if(isset($params['blog_url'])){
            $this->blog_url = $params['blog_url'];
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

    function loadBlog(){
        $result = false;
        if($this->blog_id){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Blog_posts WHERE blog_id=:blog_id';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_id', $this->blog_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            if($result){
                $row = $result->fetchArray();
                $result = $this->decrypt($row);
            }
            $db->close();
        }
        return $result;
    }

    function createBlog(){
        $result = false;
        if($this->account_id && $this->visibility && $this->title){
            $iv = $this->createIV();
            $contents = $this->encrypt($this->contents);
            $db = new SQLite3('../data/database.db');
            $sql = 'INSERT INTO Blog_posts(account_id, blog_datetime, visibility, title, contents, iv) VALUES(:account_id, datetime(:blog_datetime), :visibility, :title, :contents, :iv)';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':account_id', $this->account_id, SQLITE_INTEGER);
            if(!$this->blog_datetime){
                $this->blog_datetime = date('Y-m-d H:i:s');
                echo $this->blog_datetime;
            }
            $stmt->bindParam(':blog_datetime', $this->blog_datetime, SQLITE_TEXT);
            $stmt->bindParam(':visibility', $this->visibility, SQLITE_INTEGER);
            $stmt->bindParam(':title', $this->title, SQLITE_TEXT);
            $stmt->bindParam(':contents', $contents, SQLITE_TEXT);
            $stmt->bindParam(':iv', $iv, SQLITE_TEXT);
            
            $result = $stmt->execute();
            if($result){
                $this->blog_id = $db->lastInsertRowID();
                $blog_url = $this->encryptUnique($this->blog_id);

                $sql = 'UPDATE Blog_posts SET blog_url=:blog_url WHERE blog_id=:blog_id';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':blog_url', $blog_url, SQLITE_TEXT);
                $stmt->bindParam(':blog_id', $this->blog_id, SQLITE_INTEGER);
                $result = $stmt->execute();
            }
            $db->close();
        }
        return $result;
    }
}