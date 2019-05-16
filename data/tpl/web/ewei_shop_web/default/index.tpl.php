<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/_header', TEMPLATE_INCLUDEPATH)) : (include template('common/_header', TEMPLATE_INCLUDEPATH));?>
<div id="myCarousel" class="carousel slide">
    <!-- 轮播（Carousel）指标 -->
    <ol class="carousel-indicators">
        <?php  if(is_array($banner)) { foreach($banner as $index => $item) { ?>
        <li data-target="#myCarousel" data-slide-to="<?php  echo $index;?>" class="<?php  if($index == 0) { ?>active<?php  } ?>"></li>
        <?php  } } ?>
    </ol>
    <!-- 轮播（Carousel）项目 -->
    <div class="carousel-inner">
        <?php  if(is_array($banner)) { foreach($banner as $index => $item) { ?>
        <div class="item <?php  if($index == 0) { ?>active<?php  } ?>" <?php  if($item['url']) { ?>onclick="window.open('<?php  echo $item['url'];?>')"<?php  } ?>>
            <img src="<?php  echo pctomedia($item['thumb'])?>" width="100%" alt="<?php  echo $item['title'];?>">
        </div>
        <?php  } } ?>
    </div>
</div>
<script type="text/javascript">
    $('.carousel').carousel(5000)
</script>
<?php  if($casus) { ?>
<div class="lynn-case-index">
    <div class="lynn-article-top">
        <i></i>
        <h3>案例展示</h3>
        <p><?php  echo $basicset['casesubtitle'];?></p>
    </div>
    <div class="lynn-case-info">
        <div class="slider multiple-items">
            <?php  if(is_array($casus)) { foreach($casus as $index => $item) { ?>
            <div class="slider-img">
                <img src="<?php  echo pctomedia($item['thumb'])?>" alt="<?php  echo $item['title'];?>">
                <span class="rcode">
                    <img src="<?php  echo pctomedia($item['qr'])?>" width="142" height="142" alt="<?php  echo $item['title'];?>">
                    <p>扫面二维码关注店铺</p>
                </span>
            </div>
            <?php  } } ?>
        </div>
        <div style="clear:both;"></div>
    </div>
</div>
<?php  } ?>
<?php  if($companyArticle) { ?>
<div class="lynn-news">
    <div class="lynn-article-top">
        <i></i>
        <h3>新闻动态</h3>
        <p><?php  echo $basicset['newsubtitle'];?></p>
    </div>
    <div class="lynn-news-index">
        <ul class="lynn-news-index-ul">
            <?php  if(is_array($companyArticle)) { foreach($companyArticle as $index => $item) { ?>
            <li onclick="javascript:window.open('<?php  echo webUrl(array('news/detail','id'=>$item['id']))?>')">
                <div class="lynn-news-index-li-left">
                    <span><?php  echo date('M',$item['createtime'])?></span><strong><?php  echo date('d',$item['createtime'])?></strong>
                </div>
                <div class="lynn-news-index-li-right">
                    <div class="lynn-news-index-li-right-top">
                        <i>+</i>
                        <h3><?php  echo $item['title'];?></h3>
                        <p><span><?php  echo $item['name'];?></span></p>
                    </div>
                    <div class="lynn-news-index-li-right-bot">
                        <?php  echo mb_substr(strip_tags(htmlspecialchars_decode($item['content'])),0,30,'utf-8')?>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </li>
            <?php  } } ?>
        </ul>
        <div style="clear:both;"></div>
    </div>
</div>
<?php  } ?>
<?php  if($article) { ?>
<div class="lynn-article-index">
    <div class="lynn-article-top">
        <i></i>
        <h3>最新文章</h3>
        <p><?php  echo $basicset['articlesubtitle'];?></p>
    </div>
    <div class="lynn-article-bot">
        <ul class="lynn-article-bot-ul">
            <?php  if(is_array($article)) { foreach($article as $index => $item) { ?>
            <li onclick="javascript:window.open('<?php  echo webUrl(array('article/detail','id'=>$item['id']))?>')">
                <h3><?php  echo $item['title'];?></h3>
                <span><?php  echo $item['name'];?></span>|<span><?php  echo date('Y-m-d',$item['createtime'])?></span>
                <p>
                    <?php  echo mb_substr(strip_tags(htmlspecialchars_decode($item['content'])),0,60,'utf-8')?>
                </p>
                <a href="<?php  echo webUrl(array('article/detail','id'=>$item['id']))?>" style="display: none;">more>></a>
            </li>
            <?php  } } ?>
        </ul>
        <div style="clear:both;"></div>
    </div>
</div>
<?php  } ?>
<?php  if($link) { ?>
<div class="lynn-link-index">
    <div class="lynn-article-top">
        <i></i>
        <h3>友情链接</h3>
        <p><?php  echo $basicset['linksubtitle'];?></p>
    </div>
    <div class="lynn-flink-info">
        <div class="lynn-flink-info-top">
            <a href="javascript:void(0);" id="flink-prev"><</a>
            <a href="javascript:void(0);" id="flink-next">></a>
        </div>
        <div class="lynn-flink-info-bot">
            <?php  if(is_array($link)) { foreach($link as $index => $item) { ?>
            <a href="<?php  echo $item['url'];?>" target="_blank"><img src="<?php  echo pctomedia($item['thumb'])?>" alt="<?php  echo $item['title'];?>"></a>
            <?php  } } ?>
        </div>
        <div style="clear:both;"></div>
    </div>
    <div style="clear:both;"></div>
</div>
<?php  } ?>
<div class="lynn-contact-index">
    <div class="lynn-article-top">
        <i></i>
        <h3>联系我们</h3>
        <p><?php  echo $basicset['contactsubtitle'];?></p>
    </div>
    <div class="lynn-contact-bottom">
        <form id="guestbookform">
            <div class="lynn-contact-form-top">
                <input type="text" name="nickname" placeholder="姓名" class="lynn-input-name" value=""><input name="mobile" type="text" class="lynn-input-tel" placeholder="电话" value=""><input name="email" class="lynn-input-email" type="text" placeholder="邮箱" value="">
            </div>
            <div class="lynn-contact-form-bottom">
                <textarea name="content" id="" cols="30" rows="10" class="lynn-textarea" placeholder="留言内容"></textarea>
                <span style="color:red;font-size: 12px;display: inline-block;" id="content-span"></span>
            </div>
            <input type="button" id="subguestbook" class="lynn-btn-submit" value="提交留言">
        </form>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        /*案例展示*/
        $('.multiple-items').slick({
            dots: true,
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 4
        });
        $(".slider-img").on("mouseenter",function(){
            $(this).find(".rcode").show()
        }).on("mouseleave",function(){
            $(this).find(".rcode").hide()
        })
        /*新闻动态*/
        $(".lynn-news-index-ul li").mouseenter(function(){
            $(this).addClass("active")
        }).mouseleave(function(){
            $(this).removeClass("active")
        })
        /*友情链接*/
        var flinkcount = $(".lynn-flink-info-bot a").length;
        if(flinkcount>=14){
            $("#flink-prev").on("click",function(){
                $(".lynn-flink-info-bot a:lt(2)").insertAfter(".lynn-flink-info-bot a:last")
            })
            $("#flink-next").on("click",function(){
                flinkcount = flinkcount -3;
                $(".lynn-flink-info-bot a:gt("+flinkcount+")").insertBefore(".lynn-flink-info-bot a:first")
            })
        }
        /*联系我们*/
        $("#subguestbook").on("click",function(e){
            e.preventDefault();
            $.post('<?php  echo webUrl(array("home/ajaxguestbook"))?>',$("#guestbookform").serialize(),
                    function(data){
                        console.log(data);
                        if(data.status == 'success')
                        {
                            $(this).attr('placeholder',data.message)
                            $("#content-span").html(data.message);
                        }else
                        {
                            $("[name='"+data.type+"']").attr('placeholder',data.message).css("background-color","#f6d064")
                        }
                    }, "json");
        })
    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/_footer', TEMPLATE_INCLUDEPATH)) : (include template('common/_footer', TEMPLATE_INCLUDEPATH));?>
</body>
</html>