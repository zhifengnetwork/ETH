<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header_base', TEMPLATE_INCLUDEPATH)) : (include template('_header_base', TEMPLATE_INCLUDEPATH));?>



<?php  $system=m('system')->init()?>

<?php  $sysmenus = m('system')->getMenu(true)?>

<div class="wb-nav  erji" >
    
    <!-- 二级导航 -->

    <?php  if(!$no_left && !empty($sysmenus['submenu']['items'])) { ?>

        <div class="wb-subnav">

          <div style="padding: 0px 0px 100px 0px">

              <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_tabs', TEMPLATE_INCLUDEPATH)) : (include template('_tabs', TEMPLATE_INCLUDEPATH));?>

              <!-- <div class="wb-subnav-fold icow"></div> -->

          </div>

        </div>

    <?php  } ?>

</div>





    <!-- 一级导航 -->

    <div class=" wb-header <?php  if(!empty($system['foldnav'])) { ?>fold<?php  } ?>" style="position: fixed;">
        <a href="<?php  echo webUrl()?>">
            <div class="logo <?php  if(!empty($system['foldnav'])) { ?>small<?php  } ?>" data-toggle="tooltip" data-placement="bottom" title="返回首页">

                <?php  if(!empty($copyright) && !empty($copyright['logo'])) { ?>
                    
                        <img class='logo-img' src="<?php  echo tomedia($copyright['logo'])?>" onerror="this.src='../addons/ewei_shopv2/static/images/webv3logo.png'"/>
                        <h4>海生信息</h4>
                <?php  } else { ?>
                    <img class='logo-img' src='../addons/ewei_shopv2/static/images/webv3logo.png'/>
                    <h4>海生信息</h4>
                    
                <?php  } ?>

            </div>
        </a>
        

        <ul>

            <?php  if(is_array($sysmenus['menu'])) { foreach($sysmenus['menu'] as $sysmenu) { ?>
                <?php  if($system['right_menu']['system']) { ?>
                <!-- 普通头部 -->
                    <li class="shouye <?php  if($sysmenu['active']) { ?>active<?php  } ?>">

                        <a href="<?php echo empty($sysmenu['index'])? webUrl($sysmenu['route']): webUrl($sysmenu['route']. '.'. $sysmenu['index'])?>">

                            <?php  if($sysmenu['route']=='plugins') { ?>
                            <!--  <svg class="iconplug" aria-hidden="true">

                                <use xlink:href="#icow-yingyong3"></use>
                            </svg> -->
                            <!-- 字体图标 -->
                            <span class=""></span>
                            <?php  } else { ?>
                                <?php  if(!empty($sysmenu['icon'])) { ?>
                                   <!-- 字体图标 -->
                                    <span class=""></span>
                                    <!-- <i class="icow icow-<?php  echo $sysmenu['icon'];?>"></i> -->
                                <?php  } ?>
                            <?php  } ?>

                            <p class="wb-nav-title"><?php  echo $sysmenu['text'];?></p>
                        </a>
                        <p class="wb-nav-tip"><?php  echo $sysmenu['text'];?></p>
                    </li>
                    <?php  } else { ?>
                     <!-- 系统管理页面头部 -->
                     <?php  if($sysmenu['text']!="授权") { ?>
                         <li class="shezhi <?php  if($sysmenu['active']) { ?>active<?php  } ?>"> 
                            <a href="<?php echo empty($sysmenu['index'])? webUrl($sysmenu['route']): webUrl($sysmenu['route']. '.'. $sysmenu['index'])?>">
                            
                                <?php  if($sysmenu['route']=='plugins') { ?>
                                
                                <span class=""></span>
                                <?php  } else { ?>
                                    <?php  if(!empty($sysmenu['icon'])) { ?>
                                        <!-- 字体图标 -->
                                        <span class=""></span>
                                    <?php  } ?>
                                <?php  } ?>

                                <p class="wb-nav-title"><?php  echo $sysmenu['text'];?></p>
                            </a>
                            <p class="wb-nav-tip"><?php  echo $sysmenu['text'];?></p>
                        <?php  } ?>
                    </li>

                <?php  } ?>
               


            <?php  } } ?>
           
 
           
        </ul> 
         <!-- <div class="log-out" data-href="<?php  echo $system['right_menu']['logout'];?> " data-toggle="tooltip" data-placement="bottom" title="退出"> -->
          <div class="log-out" data-href="./index.php?c=user&a=logout&" data-toggle="tooltip" data-placement="bottom" title="退出">
                <a href="javascript:;">
                    <i class=" icow icow-exit" style="font-size: 30px; color: white;line-height: 85px;" id="tuichu"><!-- <i class="icow icow-exit"></i> --></i>
                </a>
        </div>
    </div>

    <!-- 提示 -->
    <style>
        .tishikuang{
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(204,204,204,.3);
            z-index: 500;
            display: none;
        }
        .tishikuang .tishi{
            width: 300px;
            height: 130px;
            border-radius: 10px;
            background-color: #fff;
            border: 1px solid #666;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            padding: 10px;
        }
        .tishikuang .tishi h3{
            font-size: 22px;
            font-weight: 300;
            margin-bottom: 10px;
        }
        .tishikuang .tishi .sifou {
            width: 130px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            position: absolute;
            bottom: 10px;
            right: 10px;
            display: flex;
            justify-content: space-between;
        }
        .tishikuang .tishi .sifou a{
            width: 47%;
            text-decoration: none;
            background-color: #37d1ab;
            color: #fff;
            border-radius: 3px;
        }
        .tishikuang .tishi .sifou a:hover{
            border: 1px solid #37d1ab;
            color: #37d1ab;
            background-color: #fff;
        }
    </style>
    <div class="tishikuang">
        <div class="tishi">
            <h3>提示</h3>
            <p>当前已登录，确认退出？</p>
            <div class="sifou">
                <a href="./index.php?c=user&a=logout&" id="queding">确 定</a>
                <a href="js:;" id="quxiao">取 消</a>
            </div>
        </div>
    </div> 



   

    <div class="wb-container <?php  if(!empty($system['foldpanel'])) { ?>right-panel<?php  } ?>">
<script type="text/javascript">
    $(function(){
        // 添加字体图标
        var arr = ['icon-font-shangdian','icon-font-che','icon-font-vip','icon-font-dingdan','icon-font-laba','icon-font-caiwu','icon-font-shuju','icon-font-gongneng','icon-font-shezhi'];
        var arr1 = ['icon-font-gongneng','icow icow-banquan','icon-shuju1','icon-wangzhan','icon-shouquan']
        // 顶部分栏遍历添加图标
        $('.wb-header ul .shouye span').each(function(i){
            $(this).addClass(arr[i]);
        });
        $('.wb-header ul .shezhi span').each(function(i){
            $(this).addClass(arr1[i]);
        });
        // alert(1);
        var xianshi = $('.input-group-select #xianshi');
        var yincang = $('.input-group-select #yincang');
        var opXianshi = $('.input-group-select select').find("option[value='1']");
        var opYincang = $('.input-group-select select').find("option[value='0']");
        var opAll = $('.input-group-select select').find("option[value='']");

        opAll.prop("selected",true);
        $('.status input').unbind().click(function(){
            $('.input-group-select select').find("option").prop("selected",false);

            if(xianshi.prop('checked')){
                
                opXianshi.prop("selected",true);
                // console.log('显示',$('.input-group-select select').find("option:selected").text());
            }else if(yincang.prop('checked')){
                
                opYincang.prop("selected",true);
                // console.log('隐藏',$('.input-group-select select').find("option:selected").text());

            }else{
                opAll.prop("selected",true);
            }
        });

        // $(".menu-header").click(function(){
        //     console.log('header');
        //     $(this).next('ul').fadeIn();
        // })
        
    })

    $('.log-out').on('click',() => {
        console.log('123');
        $('.tishikuang').css('display','block')
    })
    $('#quxiao').on('click',() => {
        $('.tishikuang').css('display','none')
    })
</script>