<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    <!-- scripts -->
    <?php
    //enable sessions
    session_start();
    require 'module/scripts.php';
    $siteName = "";
    if (is_array($_GET) && count($_GET) > 0) {
        if (isset($_GET["siteName"])) {
            $siteName = $_REQUEST['siteName'];
        }
    }
    ?>
</head>
<body>
<!-- header -->
<?php
require 'module/header.php';
?>
<!-- 搜索区 -->
<div id="adver">
    <img src="public/images/front/adver.jpg" alt="">
    <!-- <div class="center"></div> -->
    <div class="center copy">  <!-- 为了使input和button的大小也能自适应 -->
        <?php
        echo "<input class='search' type='text' placeholder='搜索你感兴趣的内容' maxlength=15 value='$siteName'>";
        ?>
        <button class="button">搜索</button>
    </div>

</div>

<!-- 图文区 -->
<div id="tour">
    <section class="center">
        <h2>上海最受欢迎的景点</h2>
        <p>
            上海是最繁华的都市之一，也是将中西合并做到完美的一座城市，江南传统的吴越文化和西方传入的工业文化相融形成了上海特有的海派文化，这里有历史古迹，也有参天高楼，为您带来了上海必去景点，带您领略上海的独特风景。</p>
    </section>
    <?php
    // connect to database
    if (($connection = mysqli_connect("localhost", "root", "123456")) === false)
        die("Could not connect to database");
    // select database
    if (mysqli_select_db($connection, "shanghai-top") === false)
        die("Could not select database");
    //解决数据库乱码
    $connection->query("SET NAMES utf8");

    $sql = 'select * from top_site where category_type=1 and is_deleted = "N" order by sort limit 15';
    if ($siteName != "" && $siteName != null) {
        $sql = "select * from top_site where category_type=1 and is_deleted = 'N' and site_name like '%" . $siteName . "%' order by sort limit 15";
    }
    $retval = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($retval);
    for ($i = 0; $i < $num; $i++) {
        $row = mysqli_fetch_assoc($retval);
        $img_url = $row['img_url'];
        $region_name = $row['region_name'];
        $address = $row['address'];
        $star = $row['star'];
        $site_name = $row['site_name'];
        $sort = $row['sort'];
        echo "<figure>" .
            "<img style='width:607px;height: 346px' src='$img_url' alt='tour1'>" .
            "<figcaption>" .
            "<div class='tour_title'>" .
            "<strong class='title'>&lt;$region_name&gt;</strong>$address" .
            "</div>" .
            "<div>" .
            "<em class='sat'>$star</em>" .
            "<span class='price'><strong>$site_name</strong></span>" .
            "</div>" .
            "<div class='type'>排名: $sort</div>" .
            "</figcaption>" .
            "</figure>";

    }

    ?>

</div>
<!-- 底部区域 -->
<?php
require 'module/footer.php';
?>
<script src="public/javascripts/front/scenic.js"></script>
</body>
</html>