<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>



<div class="page-header"><img src="../addons/ewei_shopv2/static/images/font_31.png">当前位置：<span class="text-primary">举报记录 </span> </div>



<div class="page-content">

        <form action="./index.php" method="get" class="form-horizontal" role="form">

                <input type="hidden" name="c" value="site">

                <input type="hidden" name="a" value="entry">

                <input type="hidden" name="m" value="ewei_shopv2">

                <input type="hidden" name="do" value="web">

                <input type="hidden" name="r" value="article.report">

                <div class="page-toolbar  m-b-sm m-t-sm">

                        <div class="col-sm-6 pull-right">

                        <div class="input-group">

                                <div class="input-group-select">

                                    <select  name="cid" class='form-control ' style="width:120px;">

                                        <?php  if(is_array($categorys)) { foreach($categorys as $ccid => $cname) { ?>

                                        <option value="<?php  echo $ccid;?>" <?php  if($_GPC['cid']==$ccid) { ?>selected="selected"<?php  } ?>><?php  echo $cname;?></option>

                                        <?php  } } ?>

                                    </select>

                                </div>

                                <input type="text" class=" form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入文章标题/举报内容关键字进行检索"> <span class="input-group-btn">

                                <button class="btn btn-primary" type="submit"> 搜索</button> </span>

                        </div>

                    </div>

                </div>

  </form>

<?php  if(count($datas)>0) { ?>

        <table class="table table-hover table-responsive">

            <thead>

                <tr>

                    <th style="width:60px; text-align: center;">ID</th>

                    <th>粉丝</th>

                    <th>文章</th>

                    <th>违规分类</th>

                    <th >举报描述</th>

                </tr>

            </thead>

            <tbody>

             

                    <?php  if(is_array($datas)) { foreach($datas as $data) { ?>

                        <tr>

                            <td style="text-align: center;"><?php  echo $data['id'];?></td>

                            <td>

                            	<a href="<?php  echo webUrl('member/list/detail', array('id'=>$data['mid']))?>" target="_blank"><?php  echo $data['nickname'];?></a>

                            </td>

                            <td>

                            	<a href="<?php  echo webUrl('article/edit', array('aid'=>$data['aid']))?>" target="_blank"><?php  echo $data['article_title'];?></a>

                            </td>

                            <td><?php  echo $data['cate'];?></td>

                            <td data-toggle='popover' data-content='<div style="max-width:300px;word-break:break-all"><?php  echo $data['cons'];?></div>' data-html="true" data-placement='bottom' data-trigger='hover'><?php  echo $data['cons'];?></td>

                        </tr>

                 <?php  } } ?>

            </tbody>

            <tfoot>

                <tr>

                    <td colspan="5" class="text-right"> <?php  echo $pager;?></td>

                </tr>

            </tfoot>

        </table>

<?php  } else { ?>

<div class='panel panel-default'>

	<div class='panel-body' style='text-align: center;padding:30px;'>

		 没有任何举报记录!

	</div>

</div>

<?php  } ?>

</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->