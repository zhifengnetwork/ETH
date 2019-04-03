<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    .input-group-addon{
        position: relative;
        top:-7px;
        border-color:transparent;
    }
    .input-group-btn{
        top:-14px;
    }
    .input-group .form-control{
        width: 100%
    }
    .fixmore-input-group{
        margin-bottom: 10px;
    }
    .quedingBtn{
        width: 100px;
        padding: 5px 0;
        border-radius: 4px;
        color: #fff;
        background-color: #37d1ab;
    }
    .quedingBtn2{
        width: 100px;
        padding: 5px 0;
        border-radius: 4px;
        color: #fff;
        background-color: #bb2639;
        margin-left: 2rem;
    }
    .shezhi > a{
        color: #bb2639;
        padding-left: 2rem;
        font-size: 1rem;
    }
    .shezhi > a:hover{
        color: #37d1ab;
    }

</style>
<div class='page-header'><span><img src="../addons/ewei_shopv2/static/images/font_31.png">当前位置： <span class="text-primary">福彩3D</span></span></div>



    <div class="page-content">

        <div class="form-group shezhi">
            <a href="javascript:;">3D福彩设置</a>
            <a href="<?php  echo weburl('sale/contract')?>">游戏规则</a>
        </div>

        <div class="form-group">



            <div class="col-sm-12">


                <div class='input-group fixmore-input-group'>
                    <span class="input-group-addon">本期开奖号</span>
                    <input type="text" name="data[number]"  value="<?php  echo $sale['number'];?>" class="form-control number" onkeyup="this.value=this.value.replace(/[^0-9]+/,'');" maxlength="3" />
                </div>

                <div class='input-group fixmore-input-group'>
                    <span class="input-group-addon">单注价格</span>
                    <input type="number" name="data[price]"  value="<?php  echo $sale['price'];?>" class="form-control price" />
                </div>

                <div class='input-group fixmore-input-group'>
                    <span class="input-group-addon">本期已投资总额</span>
                    <input type="number" disabled="disabled" name="data[sum]"  value="<?php  echo $sale['sum'];?>" class="form-control " />
                </div>

                <div class='input-group fixmore-input-group'>
                    <span class="input-group-addon">中奖人平分投资额度</span>
                    <input type="number" name="data[winner]"  value="<?php  echo $sale['winner'];?>" class="form-control winner" />
                </div>

                <?php 
                    for($i=1;$i<=10;$i++){
                ?>
                     <div class='input-group fixmore-input-group'>
                        <span class="input-group-addon">投资第<?php  echo $i;?>名获得额度</span>
                        <input type="investment<?php  echo $i;?>" name="data[winner]"  value="<?php  echo $investment['investment'.$i];?>" class="form-control investment<?php  echo $i;?>" />
                    </div>

                <?php 
                    }
                ?>

             </div>
             <button class="quedingBtn"> 确认</button>

           <!--  <div class="col-sm-12">

                <div class='input-group fixmore-input-group'>
                    <span class="input-group-addon">手续费用</span>
                    <input type="number" name="data[enoughmoney]"  value="<?php  echo $sale['trxsxf'];?>" class="form-control trxsxf" max="100" />
                    <span style="color:red">手续费为百分比</span>
                </div>

            </div> -->

            <button class="quedingBtn2"> 开奖</button>
            <span style="color:red">福彩3D开奖</span>
        </div>


    </div>



<script language='javascript'>
                $('.quedingBtn').click(function () {
                    let number = $('.number').val();
                    let price = $('.price').val();
                    let winner = $('.winner').val();
                    // console.log(number.length);

                    if( number == '' || number.length == 3){

                    }else{
                        alert('开奖号只可为空或者三位数字');
                        return
                    }

                    $.ajax({
                        type:'post',
                        url:"<?php  echo weburl('sale/lottery')?>",
                        data:{
                            number: number,
                            price:price,
                            winner:winner,
                            investment1:$('.investment1').val(),
                            investment2:$('.investment2').val(),
                            investment3:$('.investment3').val(),
                            investment4:$('.investment4').val(),
                            investment5:$('.investment5').val(),
                            investment6:$('.investment6').val(),
                            investment7:$('.investment7').val(),
                            investment8:$('.investment8').val(),
                            investment9:$('.investment9').val(),
                            investment10:$('.investment10').val(),
                        },
                        dataType:'json',
                        success:function(data){
                            console.log(data);
                            if(data.status == -1){
                                alert(data.result.message);
                                $('.number').val('');
                                return
                            }
                            if(data.status == 1){
                                alert(data.result.message);
                                location.reload()
                            }

                        },error:function(err){
                            console.log(err);

                        }
                    })
                })

                $('.quedingBtn2').click(function () {
                    let number = $('.number').val();
                    let price = $('.price').val();
                    let sum = $('.sum').val();
                    if(number == 0 || number == ''){
                        alert('请输入本期开奖号');
                        return
                    }
                    if(price == 0 || price == ''){
                        alert('请输入单注价格');
                        return
                    }
                    if(sum == 0 || sum == ''){
                        alert('押注总金额为0时不能开奖');
                        return
                    }


                    $.ajax({
                        type:'post',
                        url:"<?php  echo weburl('sale/lotteryis')?>",
                        data:{
                           type:'1',
                            number: number
                        },
                        dataType:'json',
                        success:function(data){
                            console.log(data);
                            if(data.status == 1){
                                alert(data.result.message);
                                location.reload()
                            }

                        },error:function(err){
                            console.log(err);

                        }
                    })
                })



                $(function () {

                    $(":checkbox[name='data[enoughfree]']").click(function () {

                        if ($(this).prop('checked')) {

                            $("#enoughfree").show();

                        }

                        else {

                            $("#enoughfree").hide();

                        }

                    })





                })





	function addConsumeItem(){

		var html= '<div class="input-group recharge-item fixmore-input-group"  style="margin-top:5px">';

           html+='<span class="input-group-addon">单笔订单满</span>';

		 html+='<input type="text" class="form-control" name="enough[]"  />';

							html+='<span class="input-group-addon">元 立减</span>';

							html+='<input type="text" class="form-control"  name="give[]"  />';

							html+='<span class="input-group-addon">元</span>';

							html+='<div class="input-group-btn"><button class="btn btn-danger" onclick="removeRechargeItem(this)"><i class="fa fa-remove"></i></button></div>';

						html+='</div>';

						$('.recharge-items').append(html);

	}

	function removeConsumeItem(obj){

		$(obj).closest('.recharge-item').remove();

	}

	</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>



<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->
