<?php defined('IN_IA') or exit('Access Denied');?> <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

 <div class="page-header">

     当前位置：<span class="text-primary">分销等级</span>

</div>

 <div class="page-content">

     <div class="page-toolbar">

         <span class=''>



		 <?php if(cv('commission.level.add')) { ?>

                            <a class='btn btn-primary btn-sm' data-toggle='ajaxModal' href="<?php  echo webUrl('commission/level/add')?>"><i class="fa fa-plus"></i> 添加新等级</a>

		 <?php  } ?>



	</span>

     </div>

   <div class='alert alert-primary'>

    提示: 没有设置等级的分销商将按默认设置计算提成。商品指定的佣金金额的优先级仍是最高的，也就是说只要商品指定了佣金金额就按商品的佣金金额来计算，不受等级影响

</div>

            <table class="table table-responsive table-hover">

                <thead>

                    <tr>

                        <th style='width:160px;'>等级名称</th>

                        <th>一级分销比例</th>

                        <th>二级分销比例</th>

                        <th>三级分销比例</th>

                        <th>权重</th>

                        <th>升级条件</th>

                        <th style="width: 65px;">操作</th>

                    </tr>

                </thead>

                <tbody>

                    <?php  if(is_array($list)) { foreach($list as $row) { ?>

                    <tr <?php  if($row['id']=='default') { ?>style='background:#f2f2f2'<?php  } ?>>

                        <td><?php  echo $row['levelname'];?></td>

                        <td><?php  echo $row['commission1'];?>%</td>

                        <td><?php  echo $row['commission2'];?>%</td>

                        <td><?php  echo $row['commission3'];?>%</td>

                        <td><?php  echo $row['type'];?></td>

                        <td><?php  if($row['start'] && $row['end'] ) { ?>TEH在<?php  echo $row['start'];?> - <?php  echo $row['end'];?>投资区间内<?php  } else { ?>不自动升级<?php  } ?></td>

                        

                        <td>

							<?php if(cv('commission.level.edit')) { ?>

                            <a class='btn btn-default btn-sm btn-op btn-operation' data-toggle='ajaxModal'  href="<?php  echo webUrl('commission/level/edit', array('id' => $row['id']))?>">

                                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if(cv('commission.level.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?>">

                                    <?php if(cv('commission.level.edit')) { ?>

                                    <i class='icow icow-bianji2'></i>

                                    <?php  } else { ?>

                                    <i class='icow icow-chakan-copy'></i>

                                    <?php  } ?>

                               </span>

                            </a>

                            <?php  } ?> 

                            <?php  if($row['id']!='default') { ?>

							 <?php if(cv('commission.level.delete')) { ?>

								<!--<a class='btn btn-default btn-sm btn-op btn-operation' data-toggle='ajaxRemove'  href="<?php  echo webUrl('commission/level/delete', array('id' => $row['id']))?>" data-confirm="确认删除此等级吗？">-->

                                    <!--<span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">-->

                                    <!--<i class='icow icow-shanchu1'></i>-->

                               <!--</span>-->

                                <!--</a>-->

                        </td>

						<?php  } ?>

						<?php  } ?>



                    </tr>

                    <?php  } } ?>

                

                </tbody>

            </table>

 </div>

 <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>





<!--青岛易联互动网络科技有限公司-->