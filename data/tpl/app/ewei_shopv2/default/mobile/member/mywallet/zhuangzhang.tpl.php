<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
.disabled{
  pointer-events: none;
}
</style>


<div class='fui-page  fui-page-current'>

    <div class="fui-header">

        <div class="fui-header-left">

            <a class="back"></a>

        </div>

        <div class="title">转帐</div>

        <div class="fui-header-right">&nbsp;</div>

    </div>

    <div class='fui-content navbar' >

        <div class='fui-cell-group fui-cell-group-o'>

            <div id="tab" class="fui-tab fui-tab-danger">

            <a data-tab="tab1"  class="external <?php  if($_GPC['type']==0) { ?>active<?php  } ?>" href="<?php  echo mobileUrl('member/withdraw', array('type' => 0))?>" data-type='0'>转帐</a>

            </div>

            <div class='fui-cell-title'>

                <div class='fui-cell-info' style='color:#999'>
                当前可交易金额: ￥<span id='current'><?php  echo $member['credit2'];?></span>
                <!-- <a id='btn-all' class='text-primary external' href='#'>全部提现</a> -->
                </div>

            </div>




            <div class='fui-cell'>

                <div class='fui-cell-label big' style='width:auto;'>￥</div>

                <div class='fui-cell-info'><input type='number' class='fui-input' id='money' oninput="clearNoNum(this)" style='font-size:1.2rem;'></div>

            </div>

            <div class='fui-cell'>

                <div class='fui-cell-label big' style='width:auto;'>ID</div>

                <div class='fui-cell-info'><input type='number' class='fui-input' id='id' style='padding-left:1rem' placeholder="请输入对方的ID"></div>

            </div>





            <div class='fui-cell-title'>交易手续费为 <?php  echo $ass['zhuanzhangsxf'];?>%</div>



            <div class='fui-cell-title charge-group' style="display: none;">本次转帐将扣除手续费 ￥<span class='text-danger' id='deductionmoney'>0</span>

            </div>



            <div class='fui-cell-title charge-group' style="display: none;">本次转帐实际到账金额 ￥<span class='text-danger' id='realmoney'>0</span>

            </div>

        </div>

        <a id='btn-next' class='btn btn-success block disabled '>确定转帐</a>

        <div style="margin: 5px; color: brown">
          <p style="padding-left:0.1rem;">提示:转账前请提前与对方沟通,一旦转出将无法追回,请谨慎操作!!!</p>
        </div>

    </div>


</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript">
  function clearNoNum(obj) {
    obj.value = obj.value.replace(/[\u4e00-\u9fa5]+/g, ""); //验证非汉字
    obj.value = obj.value.replace(/[^\d.]/g, ""); //清除"数字"和"."以外的字符  
    obj.value = obj.value.replace(/^\./g, ""); //验证第一个字符是数字而不是  
    obj.value = obj.value.replace(/\.{2,}/g, "."); //只保留第一个. 清除多余的  
    obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
    obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d{6}).*$/, '$1$2.$3'); //只能输入6个小数  
  }

    $("#money").bind('input propertychange',function () {
      // console.log($('#money').attr('flag'));

      let id = $('#id').val();
      let current = Number("<?php  echo $member['credit2'];?>");
      let money = Number($(this).val());
      let sxf = Number("<?php  echo $ass['zhuanzhangsxf'];?>");

      if(money > current){
        $('#btn-next').addClass('disabled');
        FoxUI.toast.show('超出可交易金额！');
        return;
      }


      // if(money > 0){
      //   $('.charge-group').fadeOut();
      //   $('#deductionmoney').html('0');
      //   $('#realmoney').html('0');
      //   $('#btn-next').addClass('disabled');
      //   FoxUI.toast.show('请输入交易金额！');
      //   return
      // }
      if(money > 0 && money < current){
        let deductionmoney = money * sxf / 100;
        let realmoney = money - deductionmoney;
        $('#deductionmoney').html(deductionmoney.toFixed(6));
        $('#realmoney').html(realmoney.toFixed(6));
        $('.charge-group').fadeIn();
      }
      if($('#money').attr('flag') == 'true'){
        $('#btn-next').removeClass('disabled');
      }


    })

    $('#id').blur(function () {
      let id = $(this).val();
      let current = Number("<?php  echo $member['credit2'];?>");
      let money = Number($('#money').val());
      $.ajax({
        type:'post',
        url:"<?php  echo mobileurl('member.mywallet.openid')?>",
        data:{id:id},
        dataType:'json',
        success:function(data){
          console.log(data);
          if(data.status == 0){
            $('#money').attr('flag','false');
            FoxUI.toast.show(data.result.message);
            return;
          }
          if(data.status == 1){
            $('#money').attr('flag','true');
            if(money > 0 && money < current){
              $('#btn-next').removeClass('disabled');
            }
          }

        },error:function(err){
          console.log(err);

        }
      })

    })

    $('#btn-next').click(function () {
      let money = $('#money').val();
      let moneysxf = $('#deductionmoney').html();
      let id = $('#id').val();
      $.ajax({
        type:'post',
        url:"<?php  echo mobileurl('member/mywallet/zhuangzhangis')?>",
        data:{money:money,moneysxf:moneysxf,id:id},
        dataType:'json',
        success:function(data){
          console.log(data);
          if(data.status == 0){
            FoxUI.toast.show(data.result.message);
          }
          if(data.status == 1){
            FoxUI.toast.show(data.result.message);
            setTimeout(() => {
              history.go(-1);
            }, 1500);
          }
        },error:function(err){
          console.log(err);

        }
      })

    })

    // $("#money").blur(function(){

    //    var money = $("#money").val();

    //    console.log(money);

    //     $("#btn-next").attr("style","");

    // });

</script>
