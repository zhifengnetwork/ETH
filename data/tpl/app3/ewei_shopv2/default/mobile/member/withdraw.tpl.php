<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>



<div class='fui-page  fui-page-current'>

    <div class="fui-header">

        <div class="fui-header-left">

            <a class="back"></a>

        </div>

<<<<<<< HEAD
        <div class="title">提币</div>
=======
        <div class="title">提现</div>
>>>>>>> 96314174f1788efb832a33562668350719fec478

        <div class="fui-header-right">&nbsp;</div>

    </div>

    <div class='fui-content navbar' >

        <div class='fui-cell-group fui-cell-group-o'>

            <div id="tab" class="fui-tab fui-tab-danger">

<<<<<<< HEAD
            <a data-tab="tab1"  class="external <?php  if($_GPC['type']==0) { ?>active<?php  } ?>" href="<?php  echo mobileUrl('member/withdraw', array('type' => 0))?>" data-type='0'>ETH提币</a>

            <!-- <a data-tab="tab2" class='external <?php  if($_GPC['type']==1) { ?>active<?php  } ?>' href="<?php  echo mobileUrl('member/withdraw1', array('type' => 1))?>"  data-type='1'>静态账户</a> -->

            <!-- <a data-tab="tab3" class='external <?php  if($_GPC['type']==2) { ?>active<?php  } ?>' href="<?php  echo mobileUrl('member/withdraw2', array('type' => 2))?>"  data-type='1'>复投账户</a> -->
=======
            <a data-tab="tab1"  class="external <?php  if($_GPC['type']==0) { ?>active<?php  } ?>" href="<?php  echo mobileUrl('member/withdraw', array('type' => 0))?>" data-type='0'>ETH提现</a>

            <!-- <a data-tab="tab2" class='external <?php  if($_GPC['type']==1) { ?>active<?php  } ?>' href="<?php  echo mobileUrl('member/withdraw1', array('type' => 1))?>"  data-type='1'>静态账户</a> -->

            <a data-tab="tab3" class='external <?php  if($_GPC['type']==2) { ?>active<?php  } ?>' href="<?php  echo mobileUrl('member/withdraw2', array('type' => 2))?>"  data-type='1'>复投账户</a>
>>>>>>> 96314174f1788efb832a33562668350719fec478

            </div>

            <div class='fui-cell-title'>

<<<<<<< HEAD
                <div class='fui-cell-info' style='color:#999'>当前可提币金额: ￥<span id='current'><?php  echo number_format($credit,6)?></span> <a id='btn-all' class='text-primary external' href='#'>全部提币</a></div>
=======
                <div class='fui-cell-info' style='color:#999'>当前可提现金额: ￥<span id='current'><?php  echo number_format($credit,2)?></span> <a id='btn-all' class='text-primary external' href='#'>全部提现</a></div>
>>>>>>> 96314174f1788efb832a33562668350719fec478

            </div>




<!-- 
            <div class='fui-cell-title'>提现金额

                <?php  if(floatval($set['withdrawmoney'])>0) { ?>

                <small>提现额度为: <span class='text-danger'><?php  echo number_format($set['withdrawmoney'],2)?>倍数</span></small>

                <?php  } ?>

            </div> -->

            <div class='fui-cell'>

                <div class='fui-cell-label big' style='width:auto;'>￥</div>

                <div class='fui-cell-info'><input type='number' class='fui-input' id='money' style='font-size:1.2rem;'></div>

            </div>



            <!-- <div class="fui-cell">

                <div class="fui-cell-label" style="width: 120px;"><span class="re-g">提现方式</span></div>

                <div class="fui-cell-info">



                    <select id="applytype">

                        <?php  if(is_array($type_array)) { foreach($type_array as $key => $value) { ?>

                        <option value="<?php  echo $key;?>" <?php  if(!empty($value['checked'])) { ?>selected<?php  } ?>><?php  echo $value['title'];?></option>

                        <?php  } } ?>

                    </select>

                </div>

                <div class="fui-cell-remark"></div>

            </div> -->



            <!-- <?php  if(!empty($type_array['2']) || !empty($type_array['3'])) { ?>

            <div class="fui-cell ab-group" <?php  if(empty($type_array[2]['checked']) || empty($type_array[3]['checked']) ) { ?>style="display: none;"<?php  } ?>>

                <div class="fui-cell-label" style="width: 120px;">姓名</div>

                <div class="fui-cell-info"><input type="text" id="realname" name="realname" class='fui-input' value="<?php  echo $last_data['realname'];?>" max="25"/></div>

            </div>

            <?php  } ?> -->



            <!-- <?php  if(!empty($type_array['2'])) { ?>

            <div class="fui-cell alipay-group" <?php  if(empty($type_array[2]['checked'])) { ?>style="display: none;"<?php  } ?>>

                <div class="fui-cell-label" style="width: 120px;">支付宝帐号</div>

                <div class="fui-cell-info"><input type="text" id="alipay" name="alipay" class='fui-input' value="<?php  echo $last_data['alipay'];?>" max="25"/></div>

                </div>



                    <div class="fui-cell alipay-group" <?php  if(empty($type_array[2]['checked'])) { ?>style="display: none;"<?php  } ?>>

                    <div class="fui-cell-label" style="width: 120px;">确认帐号</div>

                    <div class="fui-cell-info"><input type="text" id="alipay1" name="alipay1" class='fui-input' value="<?php  echo $last_data['alipay'];?>" max="25"/></div>

                </div>

            <?php  } ?> -->



            <!-- <?php  if(!empty($type_array['3'])) { ?>

                <div class="fui-cell bank-group" <?php  if(empty($type_array[3]['checked'])) { ?>style="display: none;"<?php  } ?>>

                    <div class="fui-cell-label" style="width: 120px;"><span class="re-g">选择银行</span></div>

                    <div class="fui-cell-info">



                        <select id="bankname">

                            <?php  if(is_array($banklist)) { foreach($banklist as $key => $value) { ?>

                            <option value="<?php  echo $bankname;?>" <?php  if(!empty($last_data) && $last_data['bankname'] == $value['bankname']) { ?>selected<?php  } ?>><?php  echo $value['bankname'];?></option>

                            <?php  } } ?>

                        </select>

                    </div>

                    <div class="fui-cell-remark"></div>

                </div>



                <div class="fui-cell bank-group" <?php  if(empty($type_array[3]['checked'])) { ?>style="display: none;"<?php  } ?>>

                <div class="fui-cell-label" style="width: 120px;">银行卡号</div>

                <div class="fui-cell-info"><input type="text" id="bankcard" name="bankcard" class='fui-input' value="<?php  echo $last_data['bankcard'];?>" max="25"/></div>

                </div>



                <div class="fui-cell bank-group" <?php  if(empty($type_array[3]['checked'])) { ?>style="display: none;"<?php  } ?>>

                    <div class="fui-cell-label" style="width: 120px;">确认卡号</div>

                    <div class="fui-cell-info"><input type="text" id="bankcard1" name="bankcard1`" class='fui-input' value="<?php  echo $last_data['bankcard'];?>" max="25"/></div>

                </div>

            <?php  } ?> -->


            <!-- <p style="font-size: .7rem;color: red;padding-left: 2rem;">*提现的金额只能是<?php  echo $set['withdrawmoney'];?>的倍数</p> -->


            <?php  if(!empty($withdrawcharge)) { ?>

<<<<<<< HEAD
            <div class='fui-cell-title'>提币手续费为 <?php  echo $withdrawcharge;?>%</div>
=======
            <div class='fui-cell-title'>提现手续费为 <?php  echo $withdrawcharge;?>%</div>
>>>>>>> 96314174f1788efb832a33562668350719fec478

            <?php  } ?>



            <!-- <?php  if(!empty($withdrawend)) { ?>

            <div class='fui-cell-title'>手续费金额在￥<?php  echo $withdrawbegin;?>到￥<?php  echo $withdrawend;?>间免收</div>

            <?php  } ?> -->



<<<<<<< HEAD
            <div class='fui-cell-title charge-group' style="display: none;">本次提币将扣除手续费 ￥<span class='text-danger' id='deductionmoney'></span>
=======
            <div class='fui-cell-title charge-group' style="display: none;">本次提现将扣除手续费 ￥<span class='text-danger' id='deductionmoney'></span>
>>>>>>> 96314174f1788efb832a33562668350719fec478

            </div>



<<<<<<< HEAD
            <div class='fui-cell-title charge-group' style="display: none;">本次提币实际到账金额 ￥<span class='text-danger' id='realmoney'></span>
=======
            <div class='fui-cell-title charge-group' style="display: none;">本次提现实际到账金额 ￥<span class='text-danger' id='realmoney'></span>
>>>>>>> 96314174f1788efb832a33562668350719fec478

            </div>

        </div>



<<<<<<< HEAD
        <a id='btn-next' style="" class='btn btn-success block disabled '>提币</a>
=======
        <a id='btn-next' style="" class='btn btn-success block disabled '>提现</a>
>>>>>>> 96314174f1788efb832a33562668350719fec478



    </div>

    <script>

        $("#money").blur(function(){

        //    var beisu = "<?php  echo $set['withdrawmoney'];?>";
           var beisu = 1E-5;
           var money = $("#money").val();
           if(money>=beisu){
            //    FoxUI.toast.show('提现的金额必须为'+beisu+'的倍数!');
                $("#btn-next").attr("style","");
            }else{  
                $("#btn-next").attr("style","pointer-events:none");
           }

           // alert(money);return false;

        });

    </script>

    <script language='javascript'>

        require(['biz/member/withdraw'], function (modal) {

            modal.init({

                withdrawcharge:<?php  echo floatval($withdrawcharge)?>,

                withdrawbegin:<?php  echo floatval($withdrawbegin)?>,

                withdrawend:<?php  echo floatval($withdrawend)?>,

                min:<?php  echo floatval($set['withdrawmoney'])?>,

                max:<?php  echo floatval($credit)?>,

            });

        });

    </script>

</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->