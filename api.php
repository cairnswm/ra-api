<?php

include "dbutils.php";
include "utils.php";

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, content-range, Content-Type');
    header('Access-Control-Expose-Headers: *');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}

header("Access-Control-Allow-Origin: *");		
header('Access-Control-Max-Age: 120');    // cache for 1 day
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS');
header("Access-Control-Allow-Headers: token, content-range, X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
//header('Access-Control-Allow-Credentials: true');
header('Access-Control-Expose-Headers: *');

$method = $_SERVER['REQUEST_METHOD'];
$start = 0;
$max = 50;

$input = getParameters($method);
if (isset($_SERVER['PATH_INFO'])) {
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
} else {
    $request = [];
}

// var_dump($input);
// echo "<hr></hr>";
// var_dump($request);

if ($method == "GET") {
    //echo "GET";
    $fields = "*";
    $orderby = "";
    $sql = "SELECT ".$fields." from ".$request[0];
    $countsql = "SELECT count(1) as count from ".$request[0];
    $params = array(); $cparams = array(); $sss = ""; $csss = "";
    $where = "";
    if (count($request) > 1 && is_numeric($request[1])) {
        $where .= "WHERE id = ?"; 
        $params = array_merge($params,array($request[1]));
        $cparams = array_merge($cparams,array($request[1]));
        $sss .= "i";
        $csss .= "i";
    } else {
        $sort = json_decode(getParam("sort","[]"));
        $range = json_decode(getParam("range","[]"));
        $filter = json_decode(getParam("filter","{}"));
        if (count($sort) > 0) {
            $orderby .= "order by ".$sort[0];
            if (isset($sort[1])) { 
                $orderby .= " " .$sort[1];
            }
        }
        if (count($range) == 2 ) {
            $start = $range[0];
            $max = $range[1] - $range[0];
        }
        foreach($filter as $key => $value) {
            if (strlen($where) > 0) { $where .= " and "; }
            if (is_array($value)) {
                $where .= $key . ' in ( ';
                $c = count($value);
                foreach ($value as $key => $val) {
                    // echo $key." => ".$val. " || ";
                    if ($key != 0 && $key != $c) { $where .= ","; }
                    $where .= "?";
                    array_push($params, $val);
                    $sss .= "s";
                    array_push($cparams, $val);
                    $csss .= "s";
                }
                $where .= ")";
            } else {
                $where .= $key . ' = ? ';
                array_push($params, $value);
                $sss .= "s"; 
                array_push($cparams, $value);
                $csss .= "s"; 
            }
        }
        if (strlen($where) > 0) { $where = "Where ".$where; }
    }
    $limit = " limit ?, ?"; $sss .= "ii";
    $params = array_merge($params, array($start, $max));
    

    $rowresult = PrepareExecSQL($sql." ".$where." ".$orderby." ".$limit,$sss,$params);
    // echo "=========================PARAMS==";
    // var_dump($cparams);
    // echo "=========================SQL==";
    // echo $countsql." ".$where;//." ".$orderby." ".$limit;
    // echo "=========================SSS==";
    // echo $csss;
    $countresult = PrepareExecSQL($countsql." ".$where,$csss,$cparams);
    //var_dump($countresult);
    
    if (count($request) > 1 && is_numeric($request[1]) && count($rowresult) == 1) {
        $out = $rowresult[0];
    } else {
        $c = $countresult[0]["count"];
        $out = $rowresult;
        header("content-range: users 0-9/$c");
        header("Content-Range: users 0-9/$c");
        
        header("X-Content-Range: users 0-9/$c");
        
        header("total-count: users 0-9/$c");
        header("X-Total-Count: users 0-9/$c");
    }
}

if ($method == "DELETE") {
    //echo "DELETE";
    $sql = "DELETE from ".$request[0];
    $params = array(); $sss = "";
    $where = "";
    if (count($request) > 1 && is_numeric($request[1])) {
        $where .= "WHERE id = ?"; 
        $params = array_merge($params,array($request[1]));
        $sss .= "i";
    } else {
        $filter = json_decode(getParam("filter","{}"));
        var_dump($filter);
        foreach($filter as $key => $value) {
            if (strlen($where) > 0) { $where .= " and "; }
            if (is_array($value)) {
                $where .= $key . ' in ( ';
                $c = count($value);
                foreach ($value as $key => $val) {
                    // echo $key." => ".$val. " || ";
                    if ($key != 0 && $key != $c) { $where .= ","; }
                    $where .= "?";
                    array_push($params, $val);
                    $sss .= "s";
                }
                $where .= ")";
            } else {
                $where .= $key . ' = ? ';
                array_push($params, $value);
                $sss .= "s"; 
            }
        }
        if (strlen($where) > 0) { $where = "Where ".$where; }
    }
    
    // echo "===========================";
    // var_dump($params);
    // echo "===========================";
    // echo $sql." ".$where;
    // echo "===========================";
    // echo $sss;
    $rowresult = PrepareExecSQL($sql." ".$where,$sss,$params);
    
    $out = array();
}

if ($method == "PUT") {
    //echo "DELETE";
    $sql = "Update ".$request[0];
    $params = array(); $sss = "";
    $where = "";
    $set = "set ";
    $postdata = retrieveJsonPostData();
    foreach($postdata as $key => $val) {
        $set .= $key."=?,";        
        array_push($params, $val);
        $sss .= "s";
    }
    $set = rtrim($set,", ");
    if (count($request) > 1 && is_numeric($request[1])) {
        $where .= "WHERE id = ?"; 
        $params = array_merge($params,array($request[1]));
        $sss .= "i";
    } else {
        $filter = json_decode(getParam("filter","{}"));
        var_dump($filter);
        foreach($filter as $key => $value) {
            if (strlen($where) > 0) { $where .= " and "; }
            if (is_array($value)) {
                $where .= $key . ' in ( ';
                $c = count($value);
                foreach ($value as $key => $val) {
                    // echo $key." => ".$val. " || ";
                    if ($key != 0 && $key != $c) { $where .= ","; }
                    $where .= "?";
                    array_push($params, $val);
                    $sss .= "s";
                }
                $where .= ")";
            } else {
                $where .= $key . ' = ? ';
                array_push($params, $value);
                $sss .= "s"; 
            }
        }
        if (strlen($where) > 0) { $where = "Where ".$where; }
    }
    
    // echo "===========================";
    // var_dump($params);
    // echo "===========================";
    // echo $sql." ".$set." ".$where;
    // echo "===========================";
    // echo $sss;
    $rowresult = PrepareExecSQL($sql." ".$set." ".$where,$sss,$params);
    
    $out = array();
}

if ($method == "POST") {
    //echo "DELETE";
    $sql = "Insert into ".$request[0];
    $params = array(); $sss = "";
    $set = "set ";
    $postdata = retrieveJsonPostData();
    foreach($postdata as $key => $val) {
        $set .= $key."=?,";        
        array_push($params, $val);
        $sss .= "s";
    }
    $set = rtrim($set,", ");
    
    // echo "===========================";
    // var_dump($params);
    // echo "===========================";
    // echo $sql." ".$set;
    // echo "===========================";
    // echo $sss;
    $rowresult = PrepareExecSQL($sql." ".$set,$sss,$params);
    
    $out = array();
}

http_response_code(200);

echo json_encode($out);
?>
