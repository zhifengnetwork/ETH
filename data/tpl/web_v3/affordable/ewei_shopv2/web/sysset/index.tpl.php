<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>



<div class="page-header"><img src="../addons/ewei_shopv2/static/images/font_31.png">当前位置：<span class="text-primary">商城设置</span></div>



    <div class="page-content">

        <form action="" method="post" class="form-horizontal form-validate" enctype="multipart/form-data" >

            <div class="form-group">

                <label class="col-lg control-label">商城名称</label>

                <div class="col-sm-9 col-xs-12">

                    <?php if(cv('sysset.shop.edit')) { ?>

                    <input type="text" name="data[name]" class="form-control" value="<?php  echo $data['name'];?>" />

                    <?php  } else { ?>

                    <input type="hidden" name="data[name]" value="<?php  echo $data['name'];?>"/>

                    <div class='form-control-static'><?php  echo $data['name'];?></div>

                    <?php  } ?>



                </div>

            </div>

            <div class="form-group">

                <label class="col-lg control-label">商城LOGO</label>

                <div class="col-sm-9 col-xs-12">

                    <?php if(cv('sysset.shop.edit')) { ?>

                    <?php  echo tpl_form_field_image2('data[logo]', $data['logo'])?>

                    <span class='help-block'>正方型图片</span>

                    <?php  } else { ?>

                    <input type="hidden" name="data[logo]" value="<?php  echo $data['logo'];?>"/>

                    <?php  if(!empty($data['logo'])) { ?>

                    <a href='<?php  echo tomedia($data['logo'])?>' target='_blank'>

                    <img src="<?php  echo tomedia($data['logo'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />

                    </a>

                    <?php  } ?>

                    <?php  } ?>

                </div>

            </div>

            <div class="form-group">

                <label class="col-lg control-label">商城简介</label>

                <div class="col-sm-9 col-xs-12">

                    <?php if(cv('sysset.shop.edit')) { ?>

                    <textarea name="data[description]" class="form-control richtext"rows="5"><?php  echo $data['description'];?></textarea>

                    <?php  } else { ?>

                    <textarea name="data[description]" class="form-control richtext" rows="5" style="display:none"><?php  echo $data['description'];?></textarea>

                    <div class='form-control-static'><?php  echo $data['description'];?></div>

                    <?php  } ?>

                </div>

            </div>



            <div class="form-group">

                <label class="col-lg control-label">店招</label>

                <div class="col-sm-9 col-xs-12">

                    <?php if(cv('sysset.shop.edit')) { ?>

                    <?php  echo tpl_form_field_image2('data[img]', $data['img'])?>

                    <span class='help-block'>商城首页店招，建议尺寸640*450</span>

                    <?php  } else { ?>

                    <input type="hidden" name="data[img]" value="<?php  echo $data['img'];?>"/>

                    <?php  if(!empty($data['img'])) { ?>

                    <a href='<?php  echo tomedia($data['img'])?>' target='_blank'>

                    <img src="<?php  echo tomedia($data['img'])?>" style='width:200px;border:1px solid #ccc;padding:1px' />

                    </a>

                    <?php  } ?>

                    <?php  } ?>

                </div>

            </div>

            <div class="form-group">

                <label class="col-lg control-label">商城海报</label>

                <div class="col-sm-9 col-xs-12">

                    <?php if(cv('sysset.shop.edit')) { ?>

                    <?php  echo tpl_form_field_image2('data[signimg]', $data['signimg'])?>

                    <span class='help-block'>推广海报，建议尺寸640*640</span>

                    <?php  } else { ?>

                    <input type="hidden" name="data[signimg]" value="<?php  echo $data['signimg'];?>"/>

                    <?php  if(!empty($data['signimg'])) { ?>

                    <a href='<?php  echo tomedia($data['signimg'])?>' target='_blank'>

                    <img src="<?php  echo tomedia($data['signimg'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />

                    </a>

                    <?php  } ?>

                    <?php  } ?>



                </div>

            </div>

            <!-- <div class="form-group">

                <label class="col-lg control-label">获取未关注者信息</label>

                <div class="col-sm-9 col-xs-12">

                    <?php if(cv('sysset.shop.edit')) { ?>

                    <label class="radio-inline">

                        <input type="radio" name="data[getinfo]" value="1" <?php  if(empty($data['getinfo']) || $data['getinfo']==1) { ?>checked=""<?php  } ?>> 开启

                    </label>

                    <label class="radio-inline">

                        <input type="radio" name="data[getinfo]" value="2" <?php  if($data['getinfo']==2) { ?>checked=""<?php  } ?>> 关闭

                    </label>

                    <?php  } else { ?>

                    <input type="hidden" name="data[name]" value="<?php  echo $data['name'];?>"/>

                    <div class='form-control-static'><?php  if($data['getinfo']==0) { ?>关闭<?php  } else { ?>开启<?php  } ?></div>

                    <?php  } ?>

                    <div class="help-block"> 如果开启此选项,则是会弹出绿色微信授权框</div>

                </div>

            </div>
 -->


           <!--  <div class="form-group">

                <label class="col-lg control-label">售罄图标</label>

                <div class="col-sm-9 col-xs-12">

                    <?php if(cv('sysset.shop.edit')) { ?>

                    <?php  echo tpl_form_field_image2('data[saleout]', $data['saleout'])?>

                    <span class='help-block'>商品售罄图标，建议尺寸80*80，空则不显示</span>

                    <?php  } else { ?>

                    <input type="hidden" name="data[saleout]" value="<?php  echo $data['saleout'];?>"/>

                    <?php  if(!empty($data['saleout'])) { ?>

                    <a href='<?php  echo tomedia($data['saleout'])?>' target='_blank'>

                    <img src="<?php  echo tomedia($data['saleout'])?>" style='width:200px;border:1px solid #ccc;padding:1px' />

                    </a>

                    <?php  } ?>

                    <?php  } ?>

                </div>

            </div>
 -->


            <div class="form-group">

                <label class="col-lg control-label">加载图标</label>

                <div class="col-sm-9 col-xs-12">

                    <?php if(cv('sysset.shop.edit')) { ?>

                    <?php  echo tpl_form_field_image2('data[loading]', $data['loading'])?>

                    <span class='help-block'>商品列表图片加载图标，建议尺寸100*100(根据实际需求调整)，空则不显示</span>

                    <?php  } else { ?>

                    <input type="hidden" name="data[loading]" value="<?php  echo $data['loading'];?>"/>

                    <?php  if(!empty($data['loading'])) { ?>

                    <a href=""<?php  echo tomedia($data['loading'])?>" target='_blank'>

                    <img src="<?php  echo tomedia($data['loading'])?>" style='width:200px;border:1px solid #ccc;padding:1px' />

                    </a>

                    <?php  } ?>

                    <?php  } ?>

                </div>

            </div>



            <div class="form-group">

                <label class="col-lg control-label">全局统计代码</label>

                <div class="col-sm-9 col-xs-12">

                    <?php if(cv('sysset.shop.edit')) { ?>

                    <textarea name="data[diycode]" class="form-control richtext"  rows="5"><?php  echo $data['diycode'];?></textarea>

                    <?php  } else { ?>

                    <textarea name="data[diycode]" class="form-control richtext" style="display:none"  rows="5"><?php  echo $data['diycode'];?></textarea>

                    <div class='form-control-static'><?php  echo $data['diycode'];?></div>

                    <?php  } ?>

                </div>

            </div>



            <!-- <div class="form-group">

                <label class="col-lg control-label">开启导航条</label>

                <div class="col-sm-9 col-xs-12">

                    <?php if(cv('sysset.shop.edit')) { ?>

                    <label class="radio-inline"><input type="radio" name="data[funbar]" value="1" <?php  if(!empty($data['funbar'])) { ?>checked=""<?php  } ?>> 开启</label>

                    <label class="radio-inline"><input type="radio" name="data[funbar]" value="0" <?php  if(empty($data['funbar'])) { ?>checked=""<?php  } ?>> 关闭</label>

                    <?php  } else { ?>

                    <input type="hidden" name="data[name]" value="<?php  echo $data['name'];?>"/>

                    <div class='form-control-static'><?php  if(empty($data['funbar'])) { ?>关闭<?php  } else { ?>开启<?php  } ?></div>

                    <?php  } ?>

                    <div class="help-block"> 如果开启此选项，导航内容请到导航条中编辑</div>

                </div>

            </div> -->



          <!--   <div class="form-group">

                <label class="col-lg control-label">商品列表库存预警</label>

                <div class="col-sm-9 col-xs-12">

                    <input class="form-control" name="data[goodstotal]" value="<?php  echo intval($data['goodstotal'])?>"/>

                    <span class="help-block">当后台商品列表中商品库存小于此值时特殊标记(值为零时不提示)</span>

                </div>

            </div> -->

            <div class="form-group">

                <label class="col-lg control-label">收款地址</label>

                <div class="col-sm-9 col-xs-12">

                    <input class="form-control" name="data[add]" value="<?php  echo $data['add']?>"/>

                    <span class="help-block">请输入会员投资时的收款地址</span>

                </div>

            </div>

             <div class="form-group">

                <label class="col-lg control-label">注册送币</label>

                <div class="col-sm-9 col-xs-12">

                    <input class="form-control" name="data[give]" value="<?php  echo $data['give']?>"/>

                    <span class="help-block">请输入注册送币多少</span>

                </div>

            </div>

              <div class="form-group">

                <label class="col-lg control-label">转账手续费</label>

                <div class="col-sm-9 col-xs-12">

                    <input class="form-control" name="data[zhuanzhangsxf]" value="<?php  echo $data['zhuanzhangsxf']?>"/>

                    <span class="help-block">请输入转账手续费是多少</span>

                </div>

            </div>

            <div class="form-group">

                <label class="col-lg control-label">C2C挂卖限制</label>

                <div class="col-sm-9 col-xs-12">

                    <input class="form-control" name="data[guamaiis]" value="<?php  echo $data['guamaiis']?>"/>

                    <span class="help-block">当日最多在线未交易的订单数</span>

                </div>

            </div>

            <div class="form-group">

                <label class="col-lg control-label">ETH币封顶</label>

                <div class="col-sm-9 col-xs-12">

                    <input class="form-control" name="data[bibi]" value="<?php  echo $data['bibi']?>"/>

                    <span class="help-block">用户最多佣有币</span>

                </div>

            </div>


            <div class="tabs-container">

                <div class="tab-content ">

                    <!-- 微信端开始-->

                    <div class="tab-pane  active" id="tab_wechat">

                        <div class="panel panel-default">

                            <div class="panel-body">

                                <div class="col-sm-9 col-xs-12">

                                    <h4 class="set_title">二维码</h4>

                                    <span>

                            <p class="text text-danger">请上传您的二维码  </p>

                        </span>

                                </div>

                                <div class="col-lg pull-right" style="padding-top:10px;text-align: right" >

                                    <input type="checkbox" class="js-switch" name="data[wx]" value="1" <?php  if($ass['wx']==1) { ?>checked<?php  } ?> />

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-lg control-label">二维码</label>

                                <div class="col-sm-9 col-xs-12">

                                    <?php if(cv('sysset.payset1.edit')) { ?>

                                    <?php  echo tpl_form_field_image2('data[weixinfile]', $data['weixinfile'])?>

                                    <span class='help-block'>正方型图片</span>

                                    <?php  } else { ?>

                                    <input type="hidden" name="data[weixinfile]" value="<?php  echo $data['weixinfile'];?>"/>

                                    <?php  if(!empty($data['weixinfile'])) { ?>

                                    <a href='<?php  echo tomedia($data['weixinfile'])?>' target='_blank'>

                                    <img src="<?php  echo tomedia($data['weixinfile'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />

                                    </a>

                                    <?php  } ?>

                                    <?php  } ?>

                                </div>

                            </div>
                        </div>

                    </div>





                    <div class="panel panel-default" style="">

                        <div class="panel-body">

                            <div class="col-sm-9 col-xs-12">

                                <h4 class="set_title">QQ客服二维码</h4>

                                <span>开启后，请上传您的客服qq二维码.</span>

                            </div>

                            <div class="col-lg pull-right" style="padding-top:10px;text-align: right" >

                                <input type="checkbox" class="js-switch"  name="data[kefu]"  value="1" <?php  if($ass['kefu']==1) { ?>checked<?php  } ?> />

                            </div>
                            <div class="form-group">

                                <label class="col-lg control-label">QQ客服二维码</label>

                                <div class="col-sm-9 col-xs-12">

                                    <?php if(cv('sysset.payset1.edit')) { ?>

                                    <?php  echo tpl_form_field_image2('data[kefufile]', $data['kefufile'])?>

                                    <span class='help-block'>正方型图片</span>

                                    <?php  } else { ?>

                                    <input type="hidden" name="data[kefufile]" value="<?php  echo $data['kefufile'];?>"/>

                                    <?php  if(!empty($data['kefufile'])) { ?>

                                    <a href='<?php  echo tomedia($data['kefufile'])?>' target='_blank'>

                                    <img src="<?php  echo tomedia($data['kefufile'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />

                                    </a>

                                    <?php  } ?>

                                    <?php  } ?>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="panel panel-default" style="">

                        <div class="panel-body">

                            <div class="col-sm-9 col-xs-12">

                                <h4 class="set_title">微信客服二维码</h4>

                                <span>开启后，请上传您的客服微信二维码</span>

                            </div>

                            <div class="col-lg pull-right" style="padding-top:10px;text-align: right" >

                                <input type="checkbox" class="js-switch" name="data[wxkf]" value="1" <?php  if($ass['wxkf']==1) { ?>checked<?php  } ?> />

                            </div>

                            <div class="form-group">

                                <label class="col-lg control-label">微信客服二维码</label>

                                <div class="col-sm-9 col-xs-12">

                                    <?php if(cv('sysset.payset1.edit')) { ?>

                                    <?php  echo tpl_form_field_image2('data[wxkffile]', $data['wxkffile'])?>

                                    <span class='help-block'>正方型图片</span>

                                    <?php  } else { ?>

                                    <input type="hidden" name="data[wxkffile]" value="<?php  echo $data['wxkffile'];?>"/>

                                    <?php  if(!empty($data['yhkfile'])) { ?>

                                    <a href='<?php  echo tomedia($data['wxkffile'])?>' target='_blank'>

                                    <img src="<?php  echo tomedia($data['wxkffile'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />

                                    </a>

                                    <?php  } ?>

                                    <?php  } ?>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>




                <div class="form-group">

                <label class="col-lg control-label"></label>

                <div class="col-sm-9 col-xs-12">

                    <?php if(cv('sysset.shop.edit')) { ?>

                    <input type="submit" value="提交" class="btn btn-primary"  />

                    <?php  } ?>

                </div>

            </div>

        </form>

    </div>

 

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
