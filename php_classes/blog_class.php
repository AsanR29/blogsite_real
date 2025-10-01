<?php
require_once('databaseEntity_class.php');

Class BlogPost extends DatabaseEntity{
    public $blog_id, $account_id, $roster_id, $blog_datetime, $visibility, $title, $contents, $blog_url;
    public $blog_files = array();

    function __construct($params){
        parent::__construct("Blog_posts");
        $this->unpack($params);
    }

    function unpack($params){
        if(isset($params['blog_id'])){
            $this->blog_id = $params['blog_id'];
        }
        if(isset($params['roster_id'])){
            $this->roster_id = $params['roster_id'];
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

    static function loadBlogs($params){
        $blog_array = array();
        $order = 'DESC';
        $limit = 10;
        $offset = 0;
        if(isset($params['order'])){
            $order = $params['order'];
        }
        if(isset($params['page'])){
            $offset = $limit * intval($params['page']);
        }
        if(isset($params['account_id'])){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Blog_posts WHERE visibility=2 AND account_id=:account_id ';
            $sql .= 'ORDER BY blog_datetime ' . $order . ' LIMIT ' . $limit . ' OFFSET ' . $offset;

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':account_id', $params['account_id'], SQLITE3_INTEGER);
            $result = $stmt->execute();
            $i = 0;
            while($row = $result->fetchArray()){
                $blog_array[$i] = new BlogPost(false);
                $blog_array[$i]->decryptValues($row);
                $i += 1;
            }
            $db->close();
        }
        else if(isset($params['title'])){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Blog_posts WHERE visibility=2 AND instr(lower(title), lower(:title)) ';
            if(isset($params['blog_tag'])){
                for($i = 0; $i < count($params['blog_tag']); $i++){
                    $sql .= 'AND EXISTS (SELECT Blog_tags.blog_tag_id FROM Blog_tags WHERE Blog_tags.blog_id=Blog_posts.blog_id AND Blog_tags.tag_id = :tag_id_' . $i . ') ';
                }
            }
            $sql .= 'ORDER BY blog_datetime ' . $order . ' LIMIT ' . $limit . ' OFFSET ' . $offset;
            $stmt = $db->prepare($sql);
            $title = $params['title'];
            $result = $stmt->bindValue(':title', $title, SQLITE3_TEXT);
            if(isset($params['blog_tag'])){
                for($i = 0; $i < count($params['blog_tag']); $i++){
                    $tag_id_num = ':tag_id_' . $i;
                    $tag_id = $params['blog_tag'][$i];
                    $stmt->bindValue($tag_id_num, $tag_id, SQLITE3_INTEGER);
                }
            }
            $result = $stmt->execute();
            $i = 0;
            while($row = $result->fetchArray()){
                $blog_array[$i] = new BlogPost(false);
                $blog_array[$i]->decryptValues($row);
                $i += 1;
            }
            $db->close();
        }
        else{
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Blog_posts WHERE visibility=2 ';
            if(isset($params['blog_tag'])){
                for($i = 0; $i < count($params['blog_tag']); $i++){
                    $sql .= 'AND EXISTS (SELECT blog_tag_id FROM Blog_tags WHERE Blog_tags.blog_id=Blog_posts.blog_id AND tag_id = :tag_id_' . $i . ') ';
                }
            }
            $sql .= 'ORDER BY blog_datetime ' . $order . ' LIMIT ' . $limit . ' OFFSET ' . $offset;

            $stmt = $db->prepare($sql);
            if(isset($params['blog_tag'])){
                for($i = 0; $i < count($params['blog_tag']); $i++){
                    $tag_id_num = ':tag_id_' . $i;
                    $tag_id = $params['blog_tag'][$i];
                    $stmt->bindValue($tag_id_num, $tag_id, SQLITE3_INTEGER);
                }
            }
            $result = $stmt->execute();
            $i = 0;
            while($row = $result->fetchArray()){
                $blog_array[$i] = new BlogPost(false);
                $blog_array[$i]->decryptValues($row);
                $i += 1;
            }
            $db->close();
        }
        return $blog_array;
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
                $result = $this->decryptValues($row);
            }
            $db->close();
        }
        else if($this->blog_url){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Blog_posts WHERE blog_url=:blog_url';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_url', $this->blog_url, SQLITE3_TEXT);
            $result = $stmt->execute();
            if($result){
                $row = $result->fetchArray();
                $result = $this->decryptValues($row);
            }
            $db->close();
        }
        return $result;
    }

    function createBlog(){
        $result = false;
        if($this->account_id && $this->visibility && $this->title){
            $iv = $this->createIV();
            $this->iv = $iv;
            $contents = $this->encrypt($this->contents);
            $db = new SQLite3('../data/database.db');
            $sql = 'INSERT INTO Blog_posts(account_id, blog_datetime, visibility, title, contents, iv) VALUES(:account_id, datetime(:blog_datetime), :visibility, :title, :contents, :iv)';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':account_id', $this->account_id, SQLITE3_INTEGER);
            if(!$this->blog_datetime){
                $this->blog_datetime = date('Y-m-d H:i:s');
            }
            $stmt->bindParam(':blog_datetime', $this->blog_datetime, SQLITE3_TEXT);
            $stmt->bindParam(':visibility', $this->visibility, SQLITE3_INTEGER);
            $stmt->bindParam(':title', $this->title, SQLITE3_TEXT);
            $stmt->bindParam(':contents', $contents, SQLITE3_TEXT);
            $stmt->bindParam(':iv', $iv, SQLITE3_TEXT);
            
            $result = $stmt->execute();
            if($result){
                $this->blog_id = $db->lastInsertRowID();
                $blog_url = base64_encode($this->encryptUnique($this->blog_id));

                // make a FileRoster
                $sql = 'INSERT INTO FileRoster DEFAULT VALUES';
                $result = $db->query($sql);
                if($result){
                    $this->roster_id = $db->lastInsertRowID();
                }

                $sql = 'UPDATE Blog_posts SET blog_url=:blog_url,roster_id=:roster_id WHERE blog_id=:blog_id';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':blog_url', $blog_url, SQLITE3_TEXT);
                $stmt->bindParam(':blog_id', $this->blog_id, SQLITE3_INTEGER);
                $stmt->bindParam(':roster_id', $this->roster_id, SQLITE3_INTEGER);
                $result = $stmt->execute();
                $this->blog_url = $blog_url;
            }
            $db->close();
        }
        return $result;
    }

    function updateBlog($params){
        $result = false;
        if(isset($params['contents']) && $params['contents']){
            $this->unpack($params);
            $contents = $this->encrypt($this->contents);
            $db = new SQLite3('../data/database.db');
            $sql = 'UPDATE Blog_posts SET visibility=:visibility, title=:title, contents=:contents WHERE blog_id=:blog_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':visibility', $this->visibility, SQLITE3_INTEGER);
            $stmt->bindParam(':title', $this->title, SQLITE3_TEXT);
            $stmt->bindParam(':contents', $contents, SQLITE3_TEXT);
            $stmt->bindParam(':blog_id', $this->blog_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            $db->close();
        }
        else if(isset($params['visibility']) && $params['visibility'] != $this->visibility){
            $this->visibility = $params['visibility'];
            $db = new SQLite3('../data/database.db');
            $sql = 'UPDATE Blog_posts SET visibility=:visibility WHERE blog_id=:blog_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':visibility', $this->visibility, SQLITE3_INTEGER);
            $stmt->bindParam(':blog_id', $this->blog_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            $db->close();
        }
        return $result;
    }

    function deleteblog(){
        $result = false;
        if($this->blog_id){
            $db = new SQLite3('../data/database.db');
            $sql = 'DELETE FROM Blog_posts WHERE blog_id=:blog_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_id', $this->blog_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            $db->close();
            if($result){
                require_once('file_class.php');
                $params = array('blog_id'=>$this->blog_id,'roster_id'=>$this->roster_id);
                $result_1 = UserFile::deleteFiles($params);
                require_once('blog_tag_class.php');
                $result_2 = BlogTag::deleteBlogTags($params);
                require_once('comment_class.php');
                $result_3 = Comment::deleteComments($params);
                if(!($result_1 && $result_2 && $result_3)){
                    $result = false;
                }
            }
        }
        return $result;
    }
}