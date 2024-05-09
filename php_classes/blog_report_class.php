<?php


Class BlogReport {
    public $blog_report_id, $blog_id, $contents, $report_date, $report_type, $explanation, $resolved_date;

    function __construct($params){
        $this->unpack($params);
    }
    function unpack($params){
        if(isset($params['blog_report_id'])){
            $this->blog_report_id = $params['blog_report_id'];
        }
        if(isset($params['blog_id'])){
            $this->blog_id = $params['blog_id'];
        }
        if(isset($params['contents'])){
            $this->contents = $params['contents'];
        }
        if(isset($params['report_date'])){
            $this->report_date = $params['report_date'];
        }
        if(isset($params['report_type'])){
            $this->report_type = $params['report_type'];
        }
        if(isset($params['explanation'])){
            $this->explanation = $params['explanation'];
        }
        if(isset($params['resolved_date'])){
            $this->resolved_date = $params['resolved_date'];
        }
    }

    static function loadBlogReports(){
        $blog_report_array = array();
        if(isset($params['blog_id'])){
            $order = 'DESC';
            if(isset($params['order'])){
                $order = $params['order'];
            }
            //AND resolved_date = null
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Blog_reports WHERE blog_id=:blog_id ORDER BY report_date ' . $order;
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_id', $params['blog_id'], SQLITE3_INTEGER);
            $result = $stmt->execute();
            $i = 0;
            while($row = $result->fetchArray()){
                $blog_report_array[$i] = new BlogReport(false);
                $blog_report_array[$i]->unpack($row);
                $i += 1;
            }
            $db->close();
        }
        return $blog_report_array;
    }

    function loadBlogReport(){
        $result = false;
        if($this->blog_report_id){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Blog_reports WHERE blog_report_id=:blog_report_id';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_report_id', $this->blog_report_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            if($result){
                $row = $result->fetchArray();
                $result = $this->unpack($row);
            }
            $db->close();
        }
        return $result;
    }

    function createBlogReport(){
        $result = false;
        if($this->blog_id && $this->contents && $this->report_type){
            $db = new SQLite3('../data/database.db');
            $sql = 'INSERT INTO Blog_reports(blog_id, contents, report_date, report_type, explanation) VALUES(:blog_id, :contents, date(:report_date), :report_type, :explanation)';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':blog_id', $this->blog_id, SQLITE3_INTEGER);
            $stmt->bindParam(':contents', $this->contents, SQLITE3_TEXT);
            $this->report_date = date('Y-m-d H:i:s');
            $stmt->bindParam(':report_date', $this->report_date, SQLITE3_TEXT);
            $stmt->bindParam(':report_type', $this->report_type, SQLITE3_TEXT);
            $stmt->bindParam(':explanation', $this->explanation, SQLITE3_TEXT);

            $result = $stmt->execute();
            if($result){
                $this->blog_report_id = $db->lastInsertRowID();
            }
            $db->close();
        }
        return $result;
    }

    function updateBlogReport($params){
        $result = false;
        if(isset($params['resolved_date']) && $params['resolved_date']){
            $resolved_date = $params['resolved_date'];
            $db = new SQLite3('../data/database.db');
            $sql = 'UPDATE Blog_reports SET resolved_date=:resolved_date WHERE blog_report_id=:blog_report_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':resolved_date', $resolved_date, SQLITE3_TEXT);
            $stmt->bindParam(':blog_report_id', $this->blog_report_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            if($result){
                $this->resolved_date = $resolved_date;
            }
            $db->close();
        }
        return $result;
    }

    function removeID(){
        $this->blog_report_id = false;
        $this->blog_id = false;
    }
}