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
</style>
<div class='page-header'><span><img src="../addons/ewei_shopv2/static/images/font_31.png">当前位置： <span class="text-primary">TRX资产</span></span></div>

 

    <div class="page-content">


        <div class="form-group">



            <div class="col-sm-12">

                <div class='input-group fixmore-input-group'>
                    <span class="input-group-addon">挂卖价格</span>
                    <input type="number" name="data[enoughmoney]"  value="<?php  echo $sale['trxprice'];?>" class="form-control trxprice" />
                </div>
                
             </div>

            <div class="col-sm-12">

                <div class='input-group fixmore-input-group'>
                    <span class="input-group-addon">手续费用</span>
                    <input type="number" name="data[enoughmoney]"  value="<?php  echo $sale['trxsxf'];?>" class="form-control trxsxf" max="100" />
                    <span style="color:red">手续费为百分比</span>
                </div>

            </div>

            <button class="quedingBtn"> 确认</button>

        </div>


    </div>

 

<script language='javascript'>
                $('.quedingBtn').click(function () {
                    let trxprice = $('.trxprice').val();
                    let trxsxf = $('.trxsxf').val();
                    if( trxprice == '' && trxsxf == ''){
                        alert('请输入挂卖价格和手续费用');
                        return
                    }
                    if(trxsxf >= 100 ){
                        alert('手续费不能大与100%');
                        return
                    }
                    $.ajax({
                        type:'post',
                        url:"<?php  echo weburl('sale/enough')?>",
                        data:{
                            trxprice: trxprice,
                            trxsxf: trxsxf
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