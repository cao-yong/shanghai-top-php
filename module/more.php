<?php
/**
 * Created by PhpStorm.
 * User: 50332
 * Date: 2018/11/14
 * Time: 15:30
 */
header("Content-type:text/html;charset=utf-8");//字符编码设置
//验证验证码是否正确
session_start();
//接受前台传递过来的参数
$categoryType = $_REQUEST['categoryType'];
$pageNo = $_REQUEST['pageNo'];
$start = ($pageNo - 1) * 4;

header('Content-Type:application/json');//这个类型声明非常关键

// connect to database
if (($connection = mysqli_connect("localhost", "root", "123456")) === false)
    die("Could not connect to database");
// select database
if (mysqli_select_db($connection, "shanghai-top") === false)
    die("Could not select database");
//解决数据库乱码
$connection->query("SET NAMES utf8");
//查询数据信息
$sql = "select * from top_site m where is_deleted=\"N\" and category_type = $categoryType order by m.sort limit $start, 4";
//查询总数
$countSql = "select count(1) from top_site m where is_deleted=\"N\" and category_type = $categoryType";
//查询结果
$result = mysqli_query($connection, $sql);
//查询总条数
$countQuery = mysqli_query($connection, $countSql);
//总条数结果
list($countResult) = mysqli_fetch_row($countQuery);
//结果
if (!$result) {
    printf("Error: %s\n", mysqli_error($connection));
    exit();
}
$jarr = array();
while ($rows = mysqli_fetch_array($result, MYSQL_ASSOC)) {
    //不能在循环语句中，由于每次删除 row数组长度都减小
    $count = count($rows);
    for ($i = 0; $i < $count; $i++) {
        //删除冗余数据
        unset($rows[$i]);
    }
    array_push($jarr, $rows);
}
//计算总页数
$totalPageCount = ceil($countResult / 6);
//计算是否有下一页
$hasNext = $pageNo < $totalPageCount;
//将数组进行json编码
$page = array('hasNext' => $hasNext, 'rows' => $jarr);
echo $str = json_encode($page);
