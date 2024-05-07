<?php


Class CommentReport {
    public $comment_report_id, $comment_id, $contents, $report_date, $report_type, $explanation, $resolved_date;

    function __construct($params){
        $this->unpack($params);
    }
    function unpack($params){
        if(isset($params['comment_report_id'])){
            $this->comment_report_id = $params['comment_report_id'];
        }
        if(isset($params['comment_id'])){
            $this->comment_id = $params['comment_id'];
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

    static function loadCommentReports(){
        $comment_report_array = array();
        if(isset($params['comment_id'])){
            $order = 'DESC';
            if(isset($params['order'])){
                $order = $params['order'];
            }
            //AND resolved_date = null
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Comment_reports WHERE comment_id=:comment_id ORDER BY report_date ' . $order;
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':comment_id', $params['comment_id'], SQLITE3_INTEGER);
            $result = $stmt->execute();
            $i = 0;
            while($row = $result->fetchArray()){
                $comment_report_array[$i] = new CommentReport(false);
                $comment_report_array[$i]->unpack($row);
                $i += 1;
            }
            $db->close();
        }
        return $comment_report_array;
    }

    function loadCommentReport(){
        $result = false;
        if($this->comment_report_id){
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM Comment_reports WHERE comment_report_id=:comment_report_id';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':comment_report_id', $this->comment_report_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            if($result){
                $row = $result->fetchArray();
                $result = $this->unpack($row);
            }
            $db->close();
        }
        return $result;
    }

    function createCommentReport(){
        $result = false;
        if($this->comment_id && $this->contents && $this->report_type){
            $db = new SQLite3('../data/database.db');
            $sql = 'INSERT INTO Comment_reports(comment_id, contents, report_date, report_type, explanation) VALUES(:comment_id, :contents, date(:report_date), :report_type, :explanation)';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':comment_id', $this->comment_id, SQLITE3_INTEGER);
            $stmt->bindParam(':contents', $this->contents, SQLITE3_TEXT);
            $this->report_date = date('Y-m-d H:i:s');
            $stmt->bindParam(':report_date', $this->report_date, SQLITE3_TEXT);
            $stmt->bindParam(':report_type', $this->report_type, SQLITE3_TEXT);
            $stmt->bindParam(':explanation', $this->explanation, SQLITE3_TEXT);

            $result = $stmt->execute();
            if($result){
                $this->comment_report_id = $db->lastInsertRowID();
            }
            $db->close();
        }
        return $result;
    }

    function updateCommentReport($params){
        $result = false;
        if(isset($params['resolved_date']) && $params['resolved_date']){
            $resolved_date = $params['resolved_date'];
            $db = new SQLite3('../data/database.db');
            $sql = 'UPDATE Comment_reports SET resolved_date=:resolved_date WHERE comment_report_id=:comment_report_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':resolved_date', $resolved_date, SQLITE3_TEXT);
            $stmt->bindParam(':comment_report_id', $this->comment_report_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            if($result){
                $this->resolved_date = $resolved_date;
            }
            $db->close();
        }
        return $result;
    }
}