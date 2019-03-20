<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <?php if(cv('commission.agent')) { ?><li <?php  if($_GPC['method']=='agent') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createPluginWebUrl('commission/agent')?>">分销商管理</a></li><?php  } ?>
    <?php if(cv('commission.level')) { ?><li <?php  if($_GPC['method']=='level') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createPluginWebUrl('commission/level')?>">分销商等级</a></li><?php  } ?>
    <?php if(cv('commission.increase')) { ?><li  <?php  if($_GPC['method']=='increase') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createPluginWebUrl('commission/increase')?>">分销商增长趋势统计</a></li><?php  } ?>
</ul>

<div class="panel panel-info">
    <div class="panel-heading">查询分销商增长趋势</div>
    <div class="panel-body">

        <form action="./index.php"  class="form-horizontal" onsubmit='return checkform()'>
            <input type="hidden" name="c" value="site" />
            <input type="hidden" name="a" value="entry" />
            <input type="hidden" name="m" value="sz_yi" />
	   <input type="hidden" name="do" value="plugin" />
            <input type="hidden" name="p" value="commission" />
            <input type="hidden" name="method"  value="increase" />
            <input type="hidden" name="search" value="1" />
            <div class="form-group row">
                <div class="col-xs-12 col-sm-10 col-lg-7">
                    <div class="input-group">
                        <div class="input-group-addon">最近</div>
                        <div class="input-group-addon" style="padding: 0;margin: 0;border: none;width: 15%;">
                            <select id='days' name="days" class="form-control">
                                <option value="7" <?php  if($days==7) { ?>selected<?php  } ?>>7天</option>
                                <option value="14" <?php  if($days==14) { ?>selected<?php  } ?>>14天</option>
                                <option value="30" <?php  if($days==30) { ?>selected<?php  } ?>>30天</option>
                                <option value="" <?php  if($days=='') { ?>selected<?php  } ?>>按日期</option>
                            </select>
                        </div>
                        <div class="input-group-addon">按月份/日期</div>
                        <div class="input-group-addon" style="padding: 0;margin: 0;border: none;width: 15%;">
                            <select id='year' name="year" class="form-control">
                                <option value=''>未选年份</option>
                                <?php  if(is_array($years)) { foreach($years as $y) { ?>
                                <option value="<?php  echo $y['data'];?>" <?php  if($y['selected']) { ?>selected="selected"<?php  } ?>><?php  echo $y['data'];?>年</option><?php  } } ?>
                            </select>
                        </div>
                        <div class="input-group-addon" style="padding: 0;margin: 0;border: none;width: 15%;">
                            <select
                                    id='month' name="month" class="form-control">
                                <option value=''>未选月份</option>
                                <?php  if(is_array($months)) { foreach($months as $m) { ?>
                                <option value="<?php  echo $m['data'];?>" <?php  if($m['selected']) { ?>selected="selected"<?php  } ?>><?php  echo $m['data'];?>月</option><?php  } } ?>
                            </select>
                        </div>
                        <span class='help-block' style="padding-top: 7px; padding-left: 15px;">(不选择月份表示年统计) </span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2 col-lg-5">
                    <div class="input-group">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">趋势图示例</div>
    <div class="panel-body">
        <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>  
    </div>
</div>
<script language="javascript" src="<?php echo SZ_YI_STATIC;?>js/dist/highcharts/highcharts.js"></script>
<script type="text/javascript">
   
   function checkform(){
 
       if($('#days').val()==''){    
           if($('#year').val()==''){    
               alert('请选择年份!');
               return false;
           }
       }
       return true;
   }
 
      $('#days').change(function(){
            if($(this).val()!=''){ 
                $('#year').val('');
                $('#month').val('').attr('disabled',true);;
            }
          
        })
       $('#year').change(function(){
            if($(this).val()==''){ 
                $('#month').val('').attr('disabled',true);
            }
            else{
                $('#days').val('');
                $('#month').removeAttr('disabled');
            }
        })
        
    $(function () {
   
        
        
        $('#container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
             text: '<?php  echo $charttitle;?>',
        },
        subtitle: {
            text: ''
        },
        colors: [
'#0061a5',
'#ff0000'
],
        xAxis: {
            categories: [    <?php  if(is_array($datas)) { foreach($datas as $key => $row) { ?>
                   <?php  if($key>0) { ?>,<?php  } ?>"<?php  echo $row['date'];?>"
                   <?php  } } ?>]
        },
        yAxis: {
            title: {
                text: '人数'
            },allowDecimals:false
        },
        tooltip: {
            enabled: false,
            formatter: function() {
                return '<b>'+ this.series.name +'</b><br>'+this.x +': '+ this.y +'°C';
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [
            {
               name: '会员',
               data: [
                   <?php  if(is_array($datas)) { foreach($datas as $key => $row) { ?>
                   <?php  if($key>0) { ?>,<?php  } ?><?php  echo $row['acount'];?>
                   <?php  } } ?>
               ]
            } ]
    });
    
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_footer', TEMPLATE_INCLUDEPATH)) : (include template('web/_footer', TEMPLATE_INCLUDEPATH));?>
