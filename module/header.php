<header id="header">
    <div class="center">
        <h1 class="logo">Shanghai TOP10</h1>
        <nav class="link">
            <h2 class="none">website navigate</h2>
            <ul>
                <li><a href="index.php">景点</a></li>
                <li><a href="topSites.php?categoryType=2">商圈<span class="xs-hidden"></span></a></li>
                <li><a href="topSites.php?categoryType=3">小吃街<span class="xs-hidden"></span></a></li>
                <li><a href="topSites.php?categoryType=4">酒店<span class="xs-hidden"></span></a></li>
                <li><a href="topSites.php?categoryType=5"><span>夜店</span></a></li>
            </ul>
        </nav>
    </div>
</header>

<script>
    $(function () {
        let params = window.location.search;
        if (params.indexOf("categoryType=") !== -1) {
            let index = parseInt(params.split("categoryType=")[1]);
            $("#header > div > nav > ul > li:nth-child(" + index + ")").addClass("active");
        } else {
            $("#header > div > nav > ul > li:nth-child(1)").addClass("active");
        }
    });
</script>