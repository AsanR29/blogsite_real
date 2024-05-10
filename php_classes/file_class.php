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

    function getUrl(){
        $file_end = "";
        if($this->mime_type == "image/jpeg"){
            $file_end = ".jpeg";
        }
        else if($this->mime_type == "video/mp4"){
            $file_end = ".mp4";
        }
        return "../userfiles/" . $this->file_url . $file_end;
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

    static function createFiles($params, $file_array){
        $result_array = array();
        $i = 0;
        foreach($file_array['tmp_name'] as $tmp_name){
            $the_file = array(
                'name' => $file_array['name'][$i],
                'type' => $file_array['type'][$i],
                'tmp_name' => $tmp_name,
                'error' => $file_array['error'][$i],
                'size' => $file_array['size'][$i],
            );
            $new_file = new UserFile($params);
            $result = $new_file->attachFile($the_file);
            if($result){
                $result = $new_file->createFile();
            }
            $result_array[$i] = $result;
            $i += 1;
        }
        return $result_array;
    }

    function createFile(){
        $result = false;
        if($this->file_use == "blog_item"){
            if($this->mime_type == "image/jpeg"){
                $this->file_use = "blog_pic";
            }
            else if($this->mime_type == "video/mp4"){
                $this->file_use = "blog_vid";
            }
            else{
                return false;
            }
        }
        if($this->file_use && in_array($this->file_use, UserFile::$file_uses) && $this->account_id && $this->mime_type){
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
                $file_url = base64_encode($this->encryptUnique($this->file_id));

                $sql = 'UPDATE User_files SET file_url=:file_url WHERE file_id=:file_id';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':file_url', $file_url, SQLITE3_TEXT);
                $stmt->bindParam(':file_id', $this->file_id, SQLITE3_INTEGER);
                $result = $stmt->execute();
                if($result){
                    $this->file_url = $file_url;
                    move_uploaded_file($this->attached_file['tmp_name'], "../userfiles/" . $this->getUrl());
                }
            }
            $db->close();
        }
        return $result;
    }

    static function deleteFiles($params){
        $result = false;
        if(isset($params['blog_id']) && $params['blog_id']){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT file_url, mime_type FROM User_files WHERE blog_id=:blog_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_id', $params['blog_id'], SQLITE3_INTEGER);
            $result = $stmt->execute();
            $url_array = array();
            while($row = $result->fetchArray()){
                $url_array[] = $row;
            }
            $sql = 'DELETE FROM User_files WHERE blog_id=:blog_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_id', $params['blog_id'], SQLITE3_INTEGER);
            $result = $stmt->execute();
            $db->close();
            for($i = 0; $i < count($url_array); $i++){
                $file_end = "";
                if($url_array[$i]['mime_type'] == "image/jpeg"){
                    $file_end = ".jpeg";
                }
                else if($url_array[$i]['mime_type'] == "video/mp4"){
                    $file_end = ".mp4";
                }
                $full_path = "../userfiles/" . $url_array[$i]['file_url'] . $file_end;
                unlink($full_path);
            }
        }
        else if(isset($params['account_id']) && $params['account_id']){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT file_url, mime_type FROM User_files WHERE account_id=:account_id AND blog_id=null';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':account_id', $params['account_id'], SQLITE3_INTEGER);
            $result = $stmt->execute();
            $url_array = array();
            while($row = $result->fetchArray()){
                $url_array[] = $row;
            }
            $sql = 'DELETE FROM User_files WHERE account_id=:account_id AND blog_id=null';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':account_id', $params['account_id'], SQLITE3_INTEGER);
            $result = $stmt->execute();
            $db->close();
            for($i = 0; $i < count($url_array); $i++){
                $file_end = "";
                if($url_array[$i]['mime_type'] == "image/jpeg"){
                    $file_end = ".jpeg";
                }
                else if($url_array[$i]['mime_type'] == "video/mp4"){
                    $file_end = ".mp4";
                }
                $full_path = "../userfiles/" . $url_array[$i]['file_url'] . $file_end;
                unlink($full_path);
            }
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
            unlink("../userfiles/" . $this->getUrl());
        }
        return $result;
    }

    function attachFile($the_file){
        $this->unpackFileData($the_file);
        if($this->validFile($the_file)){
            $this->attached_file = $the_file;
            return true;
        }
        return false;
    }

    function unpackFileData($the_file){
        //setting mime_type on this class & stuff
        if(isset($the_file['name'])){
            $this->file_name = $the_file['name'];
        }
        if(isset($the_file['type'])){
            $this->mime_type = $the_file['type'];
        }
    }

    function validFile($the_file){
        if($this->file_use == "blog_vid" && $this->mime_type != "video/mp4"){
            return false;
        }
        else if($this->mime_type != "image/jpeg"){
            return false;
        }
        if($the_file['size'] > 6291456){ //(6)*(1024)*(1024)
            return false;
        }
        return true;
    }
}