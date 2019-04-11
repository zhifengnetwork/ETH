<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
  .fui-content{
    background-color: #fff;
  }
  .navInfo{
    display: flex;
    background-color: #adbac2;
  }
  .navInfo > a{
    flex: 1;
    padding: 10px 0;
    text-align: center;
    color: #fff;
  }
  .navInfo_active{
    color: #d2691e !important;
    border-bottom: 2px solid #d2691e;
  }
  .selectNum{
    padding: .5rem 0 0rem 20%;
    display: flex;
    flex-wrap: wrap;
    margin: 0 .5rem;
    border-bottom: 1px solid #ccc;
    position: relative;
  }
  .selectNum > div{
    width: 20%;
  }
  .selectNum > .textBg{
    position: absolute;
    top: 1.5rem;
    left: 0;
    /* background-image: url('../static/images/juxing.png'); */
    background-image: url('../addons/ewei_shopv2/static/icon/juxing.png');
    background-size: auto 100%;
    background-repeat: no-repeat;
    color: #ccc;
    padding-left: .2rem;
  }
  .baiwei,.shiwei,.gewei{
    /* width: 10%; */
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    border: 1px solid #ccc;
    border-radius: 50%;
    margin-bottom: .5rem;
    color: #ff4500;
  }
  ul{
    margin: 0 .5rem 1rem;
  }
  .lis{
    background-color: #e5e5e5;
    display: flex;
    align-items: center;
    padding: 1rem .5rem;
    border-bottom: 1px solid #ccc;
  }
  .lis_num_box{
    width: 20%;
    display: flex;
    justify-content: center;
  }
  .lis_num_box > .lis_num{
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    border: 1px solid #ccc;
    border-radius: 50%;
    color: #ff4500;
  }
  .multBox{
    text-align: center;
    width: 20%;
    margin: 0 2.5%;
  }
  .multBox > input{
    width: 100%;
    text-align: center;
  }

  .lis_close{
    padding: 0 2%;
    margin-left: 2%;
    text-align: center;
    font-size: 1rem;
  }
  .cont_foot{
    background-color: #f7f7f7;
    padding: .5rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    left: 0;
    bottom: 2.5rem;
    width: 100%;
  }
  .foot_btn{
    padding: .1rem 1.5rem;
    background-color: #bb2639;
    color: #fff;
    border-radius: .3rem;
  }
  .yijian{
    margin: 0 .5rem;
    display: flex;
    align-items: center;
    padding: .5rem;
    border-bottom: 1px solid #ccc;
  }
  .minNum{
    width: 25%;
    margin-right: 2%;
    text-align: center;
  }
  .maxNum{
    width: 25%;
    margin-left: 2%;
    text-align: center;
  }
  .yijian_btn{
    background-color: #0a0;
    color: #fff;
    padding: 0 .7rem;
    border-radius: .2rem;
    margin: 0 4%;
  }
  .yijian_btn2{
    background-color: #bb2639;
    color: #fff;
    padding: 0 .7rem;
    border-radius: .2rem;
  }
  .disable{
    pointer-events: none;
  }
  .baohaoleft{
    width: 60%;
  }
  .baohaobeishu{
    width: 60%;
    text-align: center;
  }
  .baohaoright{
    width: 40%;
    display: flex;
  }
  .navIfo2{
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #ccc;
  }
  .navIfo2 > a{
    flex: 1;
    text-align: center;
    height: 2rem;
    line-height: 2rem;
    color: #000;

  }
  .advert {
    /* height: 25px; */
    /* line-height: 25px; */
    /* margin-top: 100px; */
    overflow: hidden;
    position: relative;
    /* background-color: aquamarine; */
  }
  .advert > .advert_con{
    position: absolute;
    width: 100%;
  }
   .advert_con{

    border: 1px solid #ccc;
    width: 6rem;



   }
  .navIfo2{
   height: 2.1rem

  }
  select {
  border:none;
  width: 100%;


  }


</style>

<div class='fui-page  fui-page-current'>

    <div class="fui-header">
      <div class="fui-header-left">
        <a class="back" onclick='location.back()'></a>
      </div>
      <div class="title">3D游戏</div>
      <div class="fui-header-right">&nbsp;</div>
	  </div>

    <div class='fui-content navbar'>
      <div class="navInfo">
        <a href="javascript:;" class="navInfo_active">3D下注</a>
        <a href="<?php  echo mobileurl('member/lottery/stakejilu')?>">押注记录</a>
        <a href="<?php  echo mobileurl('member/lottery/winningrecord')?>">中奖纪录</a>
      </div>

      <div class="navIfo2">
        <a href="<?php  echo mobileurl('member/lottery/ranking')?>">中奖名单/排行</a>
        <!-- <a href="javascript:;" class="advert">

        </a> -->
        <div class="advert_con" style="height: 2rem; top: 0px;">
            &nbsp;<span style="width:2.5rem;display:inline-block;text-align: center">期号</span>&nbsp;&nbsp;<span>开奖号</span>
            <br/>

          <select name="" id="sel">
            <?php  if(is_array($sale1)) { foreach($sale1 as $appeal) { ?>
              <option value="0" disabled>
                <p class="item"> <i style="color:#bb2639"><?php  echo $appeal['time'];?></i></p>&nbsp;&nbsp;&nbsp;  <p><i style="color:#bb2639"><?php  echo $appeal['number'];?></i></p>
              </option>
            <?php  } } ?>
          </select>
          <!-- <p class="item">第 <i style="color:#bb2639"><?php  echo $sale['time'];?></i> 期</p>
          <p>开奖号为：<i style="color:#bb2639"><?php  echo $sale['numberis'];?></i></p> -->
        </div>
        <a href="<?php  echo mobileurl('member/lottery/rule')?>">游戏规则</a>
      </div>

      <div class="selectNum selectNum0">
        <div class="textBg">百位</div>
        <div class="baiweiBox"><span class="baiwei">0</span></div>
        <div class="baiweiBox"><span class="baiwei">1</span></div>
        <div class="baiweiBox"><span class="baiwei">2</span></div>
        <div class="baiweiBox"><span class="baiwei">3</span></div>
        <div class="baiweiBox"><span class="baiwei">4</span></div>
        <div class="baiweiBox"><span class="baiwei">5</span></div>
        <div class="baiweiBox"><span class="baiwei">6</span></div>
        <div class="baiweiBox"><span class="baiwei">7</span></div>
        <div class="baiweiBox"><span class="baiwei">8</span></div>
        <div class="baiweiBox"><span class="baiwei">9</span></div>
      </div>

      <div class="selectNum selectNum1">
        <div class="textBg">十位</div>
        <div class="shiweiBox"><span class="shiwei">0</span></div>
        <div class="shiweiBox"><span class="shiwei">1</span></div>
        <div class="shiweiBox"><span class="shiwei">2</span></div>
        <div class="shiweiBox"><span class="shiwei">3</span></div>
        <div class="shiweiBox"><span class="shiwei">4</span></div>
        <div class="shiweiBox"><span class="shiwei">5</span></div>
        <div class="shiweiBox"><span class="shiwei">6</span></div>
        <div class="shiweiBox"><span class="shiwei">7</span></div>
        <div class="shiweiBox"><span class="shiwei">8</span></div>
        <div class="shiweiBox"><span class="shiwei">9</span></div>
      </div>

      <div class="selectNum selectNum2">
        <div class="textBg">个位</div>
        <div class="geweiBox"><span class="gewei">0</span></div>
        <div class="geweiBox"><span class="gewei">1</span></div>
        <div class="geweiBox"><span class="gewei">2</span></div>
        <div class="geweiBox"><span class="gewei">3</span></div>
        <div class="geweiBox"><span class="gewei">4</span></div>
        <div class="geweiBox"><span class="gewei">5</span></div>
        <div class="geweiBox"><span class="gewei">6</span></div>
        <div class="geweiBox"><span class="gewei">7</span></div>
        <div class="geweiBox"><span class="gewei">8</span></div>
        <div class="geweiBox"><span class="gewei">9</span></div>
      </div>

      <div class="yijian">

        <div class="baohaoleft">
          <div class="baohaoleft_top">
            <span style="margin-right:.2rem;">一键包号:</span>
            <input type="text" class="minNum" onkeyup="this.value=this.value.replace(/[^0-9]+/,'');" maxlength="1">
            ~
            <input type="text" class="maxNum" onkeyup="this.value=this.value.replace(/[^0-9]+/,'');" maxlength="1">
          </div>
          <div class="baohaoleft_beishu">
            <span>包号倍数：</span>  <input type="text" class="baohaobeishu" value="1" onkeyup="this.value=this.value.replace(/[^0-9]+/,'');">
          </div>
        </div>

        <div class="baohaoright">
          <div class="yijian_btn">确定</div>
          <div class="yijian_btn2">取消</div>
        </div>

      </div>

      <ul class="listBox"></ul>

      <div class="cont_foot">
        <!-- <div class="cont_foot_left">金额:<span class="money">0</span>RTX</div> -->
        <div>单价:<span class="price"><?php  echo $sale['price'];?></span>/注</div>
        <div class="foot_btn">确定</div>
      </div>
    </div>
    <div class="mask0">
      <div class="mask0_box">
         <p>自由账户：<span class="TRX"></span></p>
         <p>复投账户：<span class="futou"></span></p>
         <p>下注金额：<span class="mask0_money"></span></p>
         <p>下注总数：<span class="mask0_zhushu"></span>注</p>
         <p>
           <span>支付方式：</span>
           <select name="mask0_box_select" id="mask0_box_select" aria-placeholder="请选择支付方式" style="border: 1px solid black">
              <option value="0">请选择支付方式</option>
              <option value="1">自由账户支付</option>
              <option value="2">复投余额支付</option>
            </select>
         </p>
         <div class="mask0_btn_box">
           <div class="mask0_yes_btn">确定</div>
           <div class="mask0_no_btn">取消</div>
         </div>
      </div>
    </div>

</div>

<style>
  .mask0{
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,.5);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1;
    display: none;
  }
  .mask0_box > p{
    margin-bottom: .5rem;
  }
  .mask0 > .mask0_box{
    background-color: #fff;
    width: 80%;
    margin: 30% auto;
    border-radius: .5rem;
    padding: 1rem .5rem 0;
    box-sizing: border-box;
  }
  #mask0_box_select{
    padding: 5px 10px;
  }
  .mask0_btn_box{
    display: flex;
    border-top: 1px solid #ccc;
    font-size: .8rem;
    margin-top: 3rem;
  }
  .mask0_yes_btn{
      flex: 1;
      text-align: center;
      border-right: 1px solid #ccc;
      padding: .5rem 0;
  }
  .mask0_no_btn{
      flex: 1;
      text-align: center;
      padding: .5rem 0;
  }

</style>

<script type="text/javascript">
  window.num0 = '';
  window.num1 = '';
  window.num2 = '';
  //  文字滚动
  $(document).ready(function () {
      // i 用来记录当前显示的位置
      let i = 0;
      showTime();
      function showTime() {
          timer = setInterval(function () {
              // 如果当前显示最后一个，
              // 就在移动函数调用之前变为显示第一个，
              // 记录变为0，再去调用函数
              if(i == $('.item').length - 1){
                  $('.advert_con').css('top','0');
                  i = 0;
              }
              // 每过两秒调用一次移动函数
              show();
              // 记录也要+1
              i++;
          }, 2000)
      }
      // 移动盒子的函数
      function show() {
          let height = $('.advert').height();
          $('.advert_con').animate({
              'top': height * (i + 1) * -1
          }, 300)
      }
  })

  // 确定下注1
  $('.foot_btn').click(function () {

    if($('.price').html() == 0 && $('.listBox').text() != ''){
      alert('当前彩票单价为0,不可加注');
      return;
    }

    if($('.listBox').text() == ''){
      alert('请先下注！');
      return
    }

    let beishu = 0;
    $('.beishu').each(function () {
      beishu += Number($(this).val())
    })
    let moneyAll = beishu * $('.price').html();
    let mask0_zhushu = moneyAll/$('.price').html();
    $('.mask0_money').html(Number(moneyAll).toFixed(6));
    $('.mask0_zhushu').html(Number(mask0_zhushu).toFixed(0));

    $.ajax({
      type:'post',
      url:"<?php  echo mobileurl('member/lottery/bets') ?>",
      data:{'type':'1'},
      dataType:'json',
      success:function(data){
        // console.log(data);
        $('.TRX').html(data.result.list.credit2);
        $('.futou').html(data.result.list.credit4);

        $('.mask0').fadeIn(300);

      }
    })

  })

  // 确定下注2
  $('.mask0_yes_btn').click(function () {
    // console.log($('#mask0_box_select').val());
    // console.log($('.TRX').html() + 'TRX金额');
    // console.log($('.futou').html() + '复投余额');
    // console.log($('.mask0_money').html() + '总金额');



    if($('#mask0_box_select').val() == 0){
      alert('请选择支付方式！')
      return;
    }

    // if($('#mask0_box_select').val() == 1 && Number($('.TRX').html()) < Number($('.mask0_money').html())){
    //   alert('TRX币余额不足，请重新选择支付方式')
    //   return;
    // }

    // if($('#mask0_box_select').val() == 2 && Number($('.futou').html()) < Number($('.mask0_money').html())){
    //   alert('复投账户余额不足，请重新选择支付方式')
    //   return;
    // }


    let data = {
      payment: $('#mask0_box_select').val(),  //支付方式
      money: $('.mask0_money').html(),  //代下注金额
      type:'2',
      list:[]    //下注的列表和倍数的数组
    }
 
    $('.lis').each(function () {
      let num = '';
      $(this).children('.lis_num_box').each(function () {
        num = num + $(this).children('.lis_num').html();
      })

      let beishu = $(this).children('.multBox').children('.beishu').val()
      // console.log(num +'----'+ beishu);

      let arr = [];
      arr.push(num);
      arr.push(beishu);
      // console.log(arr);
      data.list.push(arr);
      
    })
    console.log(data.list);
    exit;
    $.ajax({
      type:'post',
      url:"<?php  echo mobileurl('member/lottery/bets') ?>",
      data:data,
      dataType:'json',
      success:function(data){
       
        if(data.status == -1){
          console.log(data);
          alert(data.result.message);
        }else if(data.status == 1){
          console.log(data);
          alert('下注成功！');
          // window.open("http://www.jb51.net");
          window.location.href="<?php  echo mobileurl('member/lottery/stakejilu')?>";
        }


      },error:function(err){
        console.log(err);

      }
    })
  })

  // 取消下注
  $('.mask0_no_btn').click(function () {
    $('.mask0').fadeOut(300);
  })

  // 百位按钮
  $('.baiwei').click(function () {
    if($(this).parents('.selectNum').hasClass('noClick')){
      alert('点击包号后不可再手动选择号码');
      return false;
    }

    if($(this).css('color') == 'rgb(255, 69, 0)'){
      $('.baiwei').css({background:'#fff',color:'#ff4500'});
      $('.baiwei').parents('.selectNum0').removeClass('active');

      $(this).parents('.selectNum0').addClass('active');
      $(this).addClass('activeNum');
      $(this).css({background:'#ccc',color:'#fff'});
      num0 = $(this).html();

      if($('.selectNum1').hasClass('active') && $('.selectNum2').hasClass('active')){
        // console.log(num0 + num1 + num2);
        let str = `<li class="lis">
                    <div class="lis_num_box"><span class="lis_num">`+ num0 +`</span></div>
                    <div class="lis_num_box"><span class="lis_num">`+ num1 +`</span></div>
                    <div class="lis_num_box"><span class="lis_num">`+ num2 +`</span></div>
                    <div class="multBox">
                      <span>倍数</span>
                      <input type="number" value="1" class="beishu">
                    </div>
                    <div class="lis_close icon icon-deletefill"></div>
                  </li> `;
        $('.listBox').append(str);
        $('.baiwei').css({background:'#fff',color:'#ff4500'});
        $('.baiwei').removeClass('activeNum');
        $('.shiwei').css({background:'#fff',color:'#ff4500'});
        $('.shiwei').removeClass('activeNum');
        $('.gewei').css({background:'#fff',color:'#ff4500'});
        $('.gewei').removeClass('activeNum');
        $('.selectNum').removeClass('active');

      }


    }else if($(this).css('color') == 'rgb(255, 255, 255)'){
      $(this).css({background:'#fff',color:'#ff4500'});
      $(this).parents('.selectNum0').removeClass('active');
      num0 = '';

    }
  })

  // 十位按钮
  $('.shiwei').click(function () {
    if($(this).parents('.selectNum').hasClass('noClick')){
      alert('点击包号后不可再手动选择号码');
      return false;
    }

    if($(this).css('color') == 'rgb(255, 69, 0)'){
      $('.shiwei').css({background:'#fff',color:'#ff4500'});
      $('.shiwei').parents('.selectNum1').removeClass('active');

      $(this).parents('.selectNum1').addClass('active');
      $(this).addClass('activeNum');
      $(this).css({background:'#ccc',color:'#fff'});
      num1 = $(this).html();

      if($('.selectNum0').hasClass('active') && $('.selectNum2').hasClass('active')){
        // console.log(num0 + num1 + num2);
        let str = `<li class="lis">
                    <input type="hidden" value="`+ num0+num1+num2 +`" class="haoma">
                    <div class="lis_num_box"><span class="lis_num">`+ num0 +`</span></div>
                    <div class="lis_num_box"><span class="lis_num">`+ num1 +`</span></div>
                    <div class="lis_num_box"><span class="lis_num">`+ num2 +`</span></div>
                    <div class="multBox">
                      <span>倍数</span>
                      <input type="number" value="1" class="beishu">
                    </div>
                    <div class="lis_close icon icon-deletefill"></div>
                  </li> `;
        $('.listBox').append(str);

        $('.baiwei').css({background:'#fff',color:'#ff4500'});
        $('.baiwei').removeClass('activeNum');
        $('.shiwei').css({background:'#fff',color:'#ff4500'});
        $('.shiwei').removeClass('activeNum');
        $('.gewei').css({background:'#fff',color:'#ff4500'});
        $('.gewei').removeClass('activeNum');
        $('.selectNum').removeClass('active');
      }

    }else if($(this).css('color') == 'rgb(255, 255, 255)'){
      $(this).css({background:'#fff',color:'#ff4500'});
      $(this).parents('.selectNum1').removeClass('active');
      num1 = '';
    }
  })

  // 个位按钮
  $('.gewei').click(function () {
    if($(this).parents('.selectNum').hasClass('noClick')){
      alert('点击包号后不可再手动选择号码');
      return false;
    }

    if($(this).css('color') == 'rgb(255, 69, 0)'){
      $('.gewei').css({background:'#fff',color:'#ff4500'});
      $('.gewei').parents('.selectNum2').removeClass('active');

      $(this).parents('.selectNum2').addClass('active');
      $(this).addClass('activeNum');
      $(this).css({background:'#ccc',color:'#fff'});
      num2 = $(this).html();

      if($('.selectNum0').hasClass('active') && $('.selectNum1').hasClass('active')){
        // console.log(num0 + num1 + num2);
        let str = `<li class="lis">
                    <div class="lis_num_box"><span class="lis_num">`+ num0 +`</span></div>
                    <div class="lis_num_box"><span class="lis_num">`+ num1 +`</span></div>
                    <div class="lis_num_box"><span class="lis_num">`+ num2 +`</span></div>
                    <div class="multBox">
                      <span>倍数</span>
                      <input type="number" value="1" class="beishu">
                    </div>
                    <div class="lis_close icon icon-deletefill"></div>
                  </li> `;
        $('.listBox').append(str);

        $('.baiwei').css({background:'#fff',color:'#ff4500'});
        $('.baiwei').removeClass('activeNum');
        $('.shiwei').css({background:'#fff',color:'#ff4500'});
        $('.shiwei').removeClass('activeNum');
        $('.gewei').css({background:'#fff',color:'#ff4500'});
        $('.gewei').removeClass('activeNum');
        $('.selectNum').removeClass('active');

      }

    }else if($(this).css('color') == 'rgb(255, 255, 255)'){
      $(this).css({background:'#fff',color:'#ff4500'});
      $(this).parents('.selectNum2').removeClass('active');
      num2 = '';
    }
  })

  // 删除按钮
  $('.listBox').on('click','.lis_close',function (e) {
    e.stopPropagation();
    $(this).parents('.lis').remove();

  })

  // 一键包号
  $('.yijian_btn').click(function () {

    let minNum = $('.minNum').val();
    let maxNum = $('.maxNum').val();
    let beishu = $('.baohaobeishu').val();
    if( minNum == '' || maxNum == ''){
      alert('请输入包号区间');
      return false;
    }
    if(minNum >= maxNum){
      alert('请输入从小到大的0-9区间');
      return false;
    }
    if(beishu == '' || beishu <= 0){
      alert('请输入包号倍数');
      return false;
    }

    $('.listBox').children('.lis').remove();
    $(this).css('background','#ccc');
    $(this).addClass('disable');
    $('.selectNum').addClass('noClick');

    $.ajax({
      type:'post',
      url:"<?php  echo mobileurl('member/lottery/numberis')?>",
      data:{ minNum:minNum, maxNum:maxNum },
      dataType:'json',
      success:function(data){
        console.log(data);
        let list = data.result.list;
        for(let i = 0; i < list.length; i++){
          let num0 = list[i].substr(0,1);
          let num1 = list[i].substr(1,1);
          let num2 = list[i].substr(2,1);
          let str = `<li class="lis">
                      <input type="hidden" value="`+ num0+num1+num2 +`" class="haoma">
                      <div class="lis_num_box"><span class="lis_num">`+ num0 +`</span></div>
                      <div class="lis_num_box"><span class="lis_num">`+ num1 +`</span></div>
                      <div class="lis_num_box"><span class="lis_num">`+ num2 +`</span></div>
                      <div class="multBox">
                        <span>倍数</span>
                        <input type="number" value="`+ beishu +`" class="beishu">
                      </div>
                      <div class="lis_close icon icon-deletefill"></div>
                    </li> `;
          $('.listBox').append(str);

        }

      },error:function(err){
        console.log(err);

      }
    })

  })

  // 取消包号
  $('.yijian_btn2').click(function () {
    $('.listBox').children('.lis').remove();
    $('.yijian_btn').css('background','#0a0');
    $('.yijian_btn').removeClass('disable');
    $('.minNum').val('');
    $('.maxNum').val('');
    $('.selectNum').removeClass('noClick');
  })
  document.getElementById("sel")[0].selected=true

</script>

<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
