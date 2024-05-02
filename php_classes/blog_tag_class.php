<?php

Class BlogTag {
    public $blog_tag_id, $blog_id, $tag_id, $tag_type, $tag_name;

    function __construct($params){
        $this->unpack($params);
    }

    function unpack($params){
        if(isset($params['blog_tag_id'])){
            $this->blog_tag_id = $params['blog_tag_id'];
        }
        if(isset($params['blog_id'])){
            $this->blog_id = $params['blog_id'];
        }
        if(isset($params['tag_id'])){
            $this->tag_id = $params['tag_id'];
        }
        if(isset($params['tag_type'])){
            $this->tag_type = $params['tag_type'];
        }
    }

    static function loadBlogTags($params){
        $blog_tag_array = array();
        if(isset($params['blog_id'])){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Blog_tags INNER JOIN Tags ON Blog_tags.tag_id = Tags.tag_id WHERE blog_id=:blog_id';
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_id', $params['blog_id'], SQLITE3_INTEGER);
            $result = $stmt->execute();
            $i = 0;
            while($row = $result->fetchArray()){
                $blog_tag_array[$i] = new BlogTag(false);
                $blog_tag_array[$i]->unpack($row);
                $i += 1;
            }
            $db->close();
        }
        return $blog_tag_array;
    }

    function createBlogTag(){
        $result = false;
        if($this->blog_id && $this->tag_name && $this->tag_type){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT tag_id FROM Tags WHERE tag_name=:tag_name';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':tag_name', $this->tag_name, SQLITE3_TEXT);
            $result = $stmt->execute();
            if(!$result){
                $sql = 'INSERT INTO Tags(tag_name) VALUES(:tag_name)';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':tag_name', $this->tag_name, SQLITE3_TEXT);
                $result = $stmt->execute();
                if($result){
                    $this->tag_id = $db->lastInsertRowID();
                }
            }
            else{
                $row = $result->fetchArray();
                $this->tag_id = $row['tag_id'];
            }
            if($result){
                $sql = 'INSERT INTO Blog_tags(blog_id, tag_id, tag_type) VALUES(:blog_id, :tag_id, :tag_type)';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':blog_id', $this->blog_id, SQLITE3_INTEGER);
                $stmt->bindParam(':tag_id', $this->tag_id, SQLITE3_INTEGER);
                $stmt->bindParam(':tag_type', $this->tag_type, SQLITE3_TEXT);
                $result = $stmt->execute();
                if($result){
                    $this->blog_tag_id = $db->lastInsertRowID();
                }
            }
        }
        return $result;
    }

    static function deleteBlogTags($params){
        $result = false;
        if(isset($params['blog_id']) && $params['blog_id']){
            $db = new SQLite3('../data/database.db');
            $sql = 'DELETE FROM Blog_tags WHERE blog_id=:blog_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_id', $params['blog_id'], SQLITE3_INTEGER);
            $result = $db->execute();
            $db->close();
        }
        return $result;
    }
}