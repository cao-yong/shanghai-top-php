//加载更多
$("#container > div").on("click",".more",function () {
    let pageNo = parseInt($(this).attr("pageNo")) + 1;
    let categoryType = parseInt($(this).attr("categoryType"));
    $(this).remove();
    $.ajax({
        url: "module/more.php",
        type: "GET",
        dataType: "JSON",
        data: {pageNo: pageNo, categoryType: categoryType},
        success: function (result) {
            if (result.rows) {
                let html = '';
                result.rows.forEach(function (item, index) {
                    html+= '<figure class="tour">' +
                                '<img style="width:567px;height: 340px" src="'+ item.img_url+'" alt="'+item.region_name+'">' +
                                    '<figcaption>' +
                                        '<article>' +
                                            '<header>' +
                                                '<hgroup>' +
                                                '<h2>'+item.site_name+'</h2>' +
                                                '<h3>'+item.address+'</h3>' +
                                            '</hgroup>' +
                                            '</header>' +
                                            '<!-- 中间内容 -->' +
                                            '<ol class="md-hidden">' +
                                            '<li>' +
                                            '<mark>星级</mark>' +
                                            item.star +
                                            '</li>' +
                                            '<li>' +
                                            '<mark>区域</mark>' +
                                            item.region_name +
                                            '</li>' +
                                            '</ol>' +
                                            '<div class="buy">' +
                                            '<div class="price"><strong>'+item.category_name+'</strong></div>' +
                                            '<div class="reserve md-hidden"><a href="###">立即查看</a></div>' +
                                            '</div>' +
                                            '<div class="type">排名：'+item.sort+'</div>' +
                                            '<div class="disc xs-hidden"><span>推荐</span>' +
                                            '</div>' +
                                            '<footer class="md-hidden">' +
                                                '本排名最后更新时间：' +
                                                '<time>'+item.update_time+'</time>' +
                                            '</footer>' +
                                        '</article>' +
                                    '</figcaption>' +
                                '</figure>';

                });
                if(result.hasNext){
                    html += '<div class="more" categoryType="'+categoryType+'" pageNo="'+pageNo+'">加载更多...</div>';
                }else{
                    html += '<div class="no-more">没有更多啦~</div>';
                }
                //加载更多
                $("#container > div").append(html);
            }
        }
    })
});