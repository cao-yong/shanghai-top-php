<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    <?php
    //enable sessions
    session_start();
    require 'module/scripts.php';
    $categoryType = $_REQUEST['categoryType'];
    $site_type = '';
    ?>
</head>
<body>
<!-- header -->
<?php
require 'module/header.php';
if ($categoryType == 2) {
    $site_type = "商圈";
    echo "<div id='headline'>" .
        "<img src='public/images/front/businessCircle.jpg' alt=''>" .
        "<hgroup>" .
        "<h2>上海$site_type</h2>" .
        "<h3><span class='xs-hidden'>每一座城市都有一个最繁华、最吸引人的商圈，那里人流聚集，热闹非凡，集美食、玩耍、购物、娱乐于一体。</span>上海是最繁华的都市之一，这里是上海最有人气的商圈排名。</h3>" .
        "</hgroup>" .
        "</div>";
} elseif ($categoryType == 3) {
    $site_type = "小吃街";
    echo "<div id='headline'>" .
        "<img src='public/images/front/snackStreet.jpg' alt=''>" .
        "<hgroup>" .
        "<h2>上海$site_type</h2>" .
        "<h3><span class='xs-hidden'>上海在很多的眼中一直以来都是国际化、小资、时尚的代表，这里融汇了</span>世界各地的名牌、美食、小吃，当然也就造就了上海丰富的小吃街，这里是上海最有人气的小吃街排名。</h3>" .
        "</hgroup>" .
        "</div>";
} elseif ($categoryType == 4) {
    $site_type = "酒店";
    echo "<div id='headline'>" .
        "<img src='public/images/front/hotel.jpg' alt=''>" .
        "<hgroup>" .
        "<h2>上海$site_type</h2>" .
        "<h3><span class='xs-hidden'>作为大都市，上海有着各种级别档次的酒店和旅馆。</span>上海酒店和旅馆分布广泛，几乎涵盖了所有商圈、景点，甚至住宅区。这里是上海最有人气的酒店排名。</h3>" .
        "</hgroup>" .
        "</div>";
} elseif ($categoryType == 5) {
    $site_type = "夜店";
    echo "<div id='headline'>" .
        "<img src='public/images/front/nightClub.jpg' alt=''>" .
        "<hgroup>" .
        "<h2>上海$site_type</h2>" .
        "<h3><span class='xs-hidden'>上海被誉为娱乐之都，来到这里的人，有这样的疑惑，晚上去哪里玩？特别是来了朋友，</span>想找个有特色的休闲场所，还费劲，上海有大大小小的酒吧，这里是上海最有人气的夜店排名。</h3>" .
        "</hgroup>" .
        "</div>";
}

?>
<!-- 侧栏 -->
<div id="container">
    <aside class="sidebar">
        <div class="sidebox recommend">
            <?php
            echo "<h2>$site_type" . "推荐</h2>"
            ?>
            <div class="tag">
                <ul>
                    <?php
                    // connect to database
                    if (($connection = mysqli_connect("localhost", "root", "123456")) === false)
                        die("Could not connect to database");
                    // select database
                    if (mysqli_select_db($connection, "shanghai-top") === false)
                        die("Could not select database");
                    //解决数据库乱码
                    $connection->query("SET NAMES utf8");
                    $sql = "select site_name from top_site m where is_deleted=\"N\" and category_type = $categoryType order by m.sort limit 21";
                    $retval = mysqli_query($connection, $sql);
                    for ($i = 0; $i < 21; $i++) {
                        $row = mysqli_fetch_assoc($retval);
                        $site_name = $row['site_name'];
                        if (mb_strlen($site_name) > 10) {
                            $site_name = mb_substr($site_name, 0, 10, 'utf-8');
                        }
                        echo "<li><a href='javascript:void(0)'>$site_name</a></li>";
                    }
                    ?>

                </ul>
            </div>
        </div>
        <div class="sidebox hot">
            <?php
            echo "<h2>热门" . "$site_type</h2>"
            ?>
            <div class="figure">
                <?php
                $sql = "select img_url,region_name,site_name from top_site m where is_deleted=\"N\" and category_type = $categoryType order by m.sort limit 8";
                $retval = mysqli_query($connection, $sql);
                for ($i = 0; $i < 8; $i++) {
                    $row = mysqli_fetch_assoc($retval);
                    $img_url = $row['img_url'];
                    $region_name = $row['region_name'];
                    $site_name = $row['site_name'];
                    echo "<figure>" .
                        "<img style='width:150px;height: 120px' src='$img_url' alt='$region_name'>" .
                        "<figcaption>$site_name</figcaption>" .
                        "</figure>";
                }
                ?>
            </div>
        </div>

        <div class="sidebox treasure">
            <h2>百宝箱</h2>
            <div class="box">
                <a href="https://tianqi.qq.com/" target="view_window" class="trea1">天气预报</a>
                <a href="https://kyfw.12306.cn/otn/leftTicket/init" target="view_window" class="trea2">火车票查询</a>
                <a href="http://flights.ctrip.com/" target="view_window" class="trea3">航空查询</a>
                <a href="http://service.shmetro.com/yxxlt/index.htm" target="view_window" class="trea4">地铁线路查询</a>
            </div>
        </div>
    </aside>

    <div class="list information">
        <?php
        echo "<h2>$site_type" . "资讯</h2>";
        $sql = "select * from top_site m where is_deleted=\"N\" and category_type = $categoryType order by m.sort limit 4";
        $retval = mysqli_query($connection, $sql);
        for ($i = 0; $i < 4; $i++) {
            $row = mysqli_fetch_assoc($retval);
            $img_url = $row['img_url'];
            $region_name = $row['region_name'];
            $site_name = $row['site_name'];
            $address = $row['address'];
            $star = $row['star'];
            $category_name = $row['category_name'];
            $sort = $row['sort'];
            $update_time = $row['update_time'];
            echo "<figure class='tour'>" .
                "<img style='width:567px;height: 340px' src='$img_url' alt='$region_name'>" .
                "<figcaption>" .
                "<article>" .
                "<header>" .
                "<hgroup>" .
                "<h2>$site_name</h2>" .
                "<h3>$address</h3>" .
                "</hgroup>" .
                "</header>" .
                "<ol class='md-hidden'>" .
                "<li>" .
                "<mark>星级</mark>" .
                "$star" .
                "</li>" .
                "<li>" .
                "<mark>区域</mark>" .
                "$region_name" .
                "</li>" .
                "</ol>" .
                "<div class='buy'>" .
                "<div class='price'><strong>$category_name</strong></div>" .
                "<div class='reserve md-hidden'><a href='javascript:void(0)'>立即查看</a></div>" .
                "</div>" .
                "<div class='type'>排名：$sort</div>" .
                "<div class='disc xs-hidden'><span>推荐</span>" .
                "</div>" .
                "<footer class='md-hidden'>" .
                "本排名最后更新时间：" .
                "<time>$update_time</time>" .
                "</footer>" .
                "</article>" .
                "</figcaption>" .
                "</figure>";
        }
        echo "<div class='more' categoryType='$categoryType'' pageNo='1'>加载更多...</div>"
        ?>
    </div>
</div>

<!-- 底部区域 -->
<?php
require 'module/footer.php';
?>
<script src="public/javascripts/front/loadingMore.js"></script>
</body>
</html>