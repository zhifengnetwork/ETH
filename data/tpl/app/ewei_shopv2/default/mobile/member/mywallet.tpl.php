<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>


  .tabar{
    display: flex;
    justify-content: space-between;
    background-color: #33394C;
    margin-top: 5px;
    margin-bottom: .5rem;

  }
  .tabar > a{
    flex: 1;
    text-align: center;
    color: #667492;
    padding: 10px 0;
    border-right: 1px solid #999999;
  }
  .tabar > .tabarActive{
    color: white;
    /* border-bottom: 3px solid #04a5e7; */
    background: #2F4577;

  }

  .futou{
    width: 90%;
    margin: 0 auto;
    background-color: #fff;
    border-radius: .2rem .2rem 0 0;
    height: 70px;
    border: 1px solid #ccc;
    overflow: hidden;
  }

  .futou_top{
    height: 70px;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 1rem;
    font-size: .9rem;
    background: #485065


  }

  .futou_bottom{
    display: flex;
    padding:  0 1rem;
    justify-content: space-between;
    align-items: center;
    height: 50px;
    border-top: 1px dashed #ccc;
    background: #485065


  }
  .futou_bottom > a{
    color: white;
    height: 30px;
    line-height: 30px;
    width: 80px;
    text-align: center;
    font-size: .6rem;
    background: #4472C4;
    border-radius: .2rem
  }

  .qianbao{
    width: 90%;
    margin: 1rem auto 0;
    background-color: #fff;
    border-radius: .2rem .2rem 0 0;
    height: 70px;
    border: 1px solid #ccc;
    overflow: hidden;
    background: #485065
  }
  .qianbao_top{
    height: 70px;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 1rem;
    font-size: .9rem;

  }
  .qianbao_bottom{
    display: flex;
    padding:  0 .2rem;
    justify-content: space-between;
    align-items: center;
    height: 50px;
    border-top: 1px dashed #ccc;


  }
  .qianbao_bottom > a{

    height: 30px;
    line-height: 30px;
    text-align: center;
    padding: 0 10px;
    font-size: .6rem;
    background: #4472C4;
    color: white;
    border-radius: .2rem

  }




</style>

<div class='fui-page  fui-page-current' style="background:#080E2C">

    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">钱包余额</div>
        <div class="fui-header-right">&nbsp;</div>
    </div>

    <div class='fui-content navbar' >
      <div class="tabar">
        <a href="javascript:;" class="tabarActive">钱包</a>
        <?php  if($member['type']==2) { ?>
        <a href="javascript:;" onclick="location.href='<?php  echo mobileurl('member/investmentjilu',array('type'=>4))?>'">提币记录</a>
        <?php  } else { ?>
        <?php  if($member['suoding']==1) { ?>
        <a href="javascript:;" onclick="location.href='<?php  echo mobileurl('member/investmentjilu/log',array('type'=>6))?>'">总记录</a>
        <?php  } else { ?>
         <a href="javascript:;" onclick="location.href='<?php  echo mobileurl('member/investmentjilu/log',array('type'=>6))?>'">总记录</a>
        <a href="javascript:;" onclick="location.href='<?php  echo mobileurl('member/investmentjilu',array('type'=>4))?>'">提币记录</a>
        <a href="javascript:;" onclick="location.href='<?php  echo mobileurl('member/investmentjilu',array('type'=>3))?>'">转币记录</a>
        <a href="javascript:;" onclick="location.href='<?php  echo mobileurl('member/investmentjilu/c2clog')?>&type=5'">C2C记录</a>
        <?php  } ?>
        <?php  } ?>
      </div>


      <!-- 复投账户 -->
      <?php  if($member['type']==2) { ?>
       <?php  } else { ?>
      <div class="futou" data-type="guan">
        <a href="javascript:;" class="futou_top">
          <span>复投账户</span>
          <span><?php  echo $member['credit4'];?></span>
        </a>
        <div class="futou_bottom">
        <?php  if($member['suoding']==1) { ?>
          <a class="yijianfutou0" href="<?php  echo mobileurl('member/mywallet/futou',array('type'=>4))?>">一键复投</a>
          <?php  } else { ?>
          <a class="yijianfutou0" href="<?php  echo mobileurl('member/mywallet/futou',array('type'=>4))?>">一键复投</a>
          <a class="qipaiyule" href="<?php  echo mobileUrl('member/qipai')?>">棋牌娱乐</a>
          <?php  } ?>
        </div>
      </div>
      <?php  } ?>

      <!-- 自由钱包 -->
      <div class="qianbao" data-type="guan">
        <a href="javascript:;" class="qianbao_top">
          <span>自由钱包</span>
          <span><?php  echo $member['credit2'];?></span>
        </a>
        <div class="qianbao_bottom">
        <?php  if($member['type']==2) { ?>
        <a class="" href="<?php  echo mobileUrl('member/withdraw')?>">提币</a>
        <?php  } else { ?>
          <?php  if($member['suoding']==1) { ?>
          <a class="yijianfutou0" href="<?php  echo mobileurl('member/mywallet/futou',array('type'=>2))?>">一键复投</a>
          <a class="" href="<?php  echo mobileUrl('member/withdraw')?>">提币</a>
          <?php  } else { ?>
          <a class="yijianfutou0" href="<?php  echo mobileurl('member/mywallet/futou',array('type'=>2))?>">一键复投</a>
          <a class="" href="<?php  echo mobileUrl('member/withdraw')?>">提币</a>
          <a class="qipaiyule" href="<?php  echo mobileUrl('member/guamai')?>">C2C</a>
          <a class="qipaiyule" href="<?php  echo mobileUrl('member/qipai')?>">棋牌娱乐</a>
          <a class="" href="<?php  echo mobileurl('member/mywallet/zhuangzhang')?>">互转</a>
          <?php  } ?>
        <?php  } ?>
        </div>
      </div>

    </div>

</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript">


  // 点击自由钱包伸缩盒子
  $('.qianbao').click(function () {
    let type = $(this).data('type');
    if(type == 'guan'){
      $('.qianbao').data('type','kai');
      $('.qianbao').animate({
        'height':'120px'
      },300)
    } else if(type == 'kai'){
      $('.qianbao').data('type','guan');
      $('.qianbao').animate({
        'height':'70px'
      },300)
    }
  })

  // 点击自由钱包的底部不缩小
  $('.qianbao_bottom').click(function (e) {
    e.stopPropagation();
  })

  // 点击复投账户的一键复投
  $('.yijianfutou0').click(function () {
    if("<?php  echo $member['type'];?>" == 2){
			alert('该账号已锁户！');
			return false;
		}
    console.log('点击了复投账户的一键复投');
    // return false;

  })

  // 点击复投账户的棋牌娱乐
  $('.qipaiyule').click(function () {
    if("<?php  echo $member['type'];?>" == 2){
			alert('该账号已锁户！');
			return false;
		}
    console.log('点击了棋牌娱乐');

  })

  // 点击复投账户伸缩盒子
  $('.futou').click(function () {
    let type = $(this).data('type');
    if(type == 'guan'){
      $('.futou').data('type','kai');
      $('.futou').animate({
        'height':'120px'
      },300)
    } else if(type == 'kai'){
      $('.futou').data('type','guan');
      $('.futou').animate({
        'height':'70px'
      },300)
    }
  })

</script>


