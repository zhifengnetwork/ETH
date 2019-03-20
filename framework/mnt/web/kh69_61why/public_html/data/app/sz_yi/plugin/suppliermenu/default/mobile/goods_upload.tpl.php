<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<title>发布宝贝</title>
 <script type="text/javascript" src="<?php echo MODULE_URL.'plugin/suppliermenu/res/dropload.min.js?'.time();?>"></script>
 <script type="text/javascript" src="<?php echo MODULE_URL.'plugin/suppliermenu/res/baidu.js?'.time();?>"></script> 
<script type="text/javascript" src="<?php echo MODULE_URL.'plugin/suppliermenu/res/jquery.form.js?'.time();?>"></script>
<script src="../addons/sz_yi/static/js/dist/ajaxfileupload.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo MODULE_URL.'plugin/suppliermenu/res/s.js?'.time();?>"></script>
<script type="text/javascript">
  System.config({
    map:{
      systemJsText:'<?php  echo MODULE_URL.'plugin/suppliermenu/res/txt.js';?>',
      systemJsCss:'<?php  echo MODULE_URL.'plugin/suppliermenu/res/css.js';?>',
      systemJsJson:'<?php  echo MODULE_URL.'plugin/suppliermenu/res/json.js';?>'
    },
    baseURL: '<?php  echo MODULE_URL.'plugin/suppliermenu/res/';?>',
  });

System['import']('<?php  echo MODULE_URL.'plugin/suppliermenu/res/css/goods_upload.css!systemJsCss';?>').then(function (a){});
 
System['import']('<?php  echo MODULE_URL.'plugin/suppliermenu/res/tpl/tpl-pcate-box.html!systemJsText';?>').then(function (a){$("body").append(a)});
System['import']('<?php  echo MODULE_URL.'plugin/suppliermenu/res/tpl/tpl-ccate-box.html!systemJsText';?>').then(function (a){$("body").append(a)});
System['import']('<?php  echo MODULE_URL.'plugin/suppliermenu/res/tpl/tpl-img-box.html!systemJsText';?>').then(function (a){$("body").append(a)});

 

</script>

 
 
  
<script type="text/html" id="tpl-big-body">
<div id="big_body" >
<form method="post" enctype="multipart/form-data"  id="showDataForm">
     <div id="header">
           <table>
               <tr>
                <th style="width:10%;  " align="center"  valign="center" onclick="window.history.go(-1)" ><</th> 
                   <th style="width:80%; " align="center" valign="center" >发布宝贝</th>
               <th style="width:10%; background: url(<?php  echo MODULE_URL.'plugin/suppliermenu/res/2.png'?>) no-repeat left; background-size:20px 20px; " align="center" valign="center" > </th> 
               </tr>
           </table>
      </div>
      <ul id="upload_img" class="box">
  
             <li>
               <div id="select-box"  >
                       <div style="font-size:30px;">+</div>
                       <div style="font-size:10px;">添加图片</div>
                       <input type="file" id="file"  name="files[]"   onchange="handleFiles(this)"   multiple="true"  />
               </div>
             </li>
      </ul>
      <div id="data-box"  class="box" >
           <input type="text" name="title" value="<%if status%><%goods.title%><%/if%>" placeholder="输入商品标题">
           <ul id="price-box">
               <li>
                 <div>现在</div>
                 <div><input type="text" name="marketprice" value="<%if status%><%goods.marketprice%><%/if%>" placeholder="0.00" /></div>
               </li>
               <li style="border-left:1px solid #000;border-right:1px solid #000;">
                 <div >原价</div>
                 <div><input type="text" name="productprice"  value="<%if status%><%goods.productprice%><%/if%>" placeholder="0.00" /></div>
               </li>
               <li>
                 <div>成本</div>
                 <div><input type="text" name="costprice"  value="<%if status%><%goods.costprice%><%/if%>" placeholder="0.00" /></div>
               </li>
           </ul>
      </div>
      <div id="line-box" class="box">
         <ul >
           <li onclick=" pcate(); ">
             <span  >分类</span>
             <span>></span>
           </li>
           <li>
             <span>运费</span>
             <span>></span>
           </li>
           <li>
             <span>库存</span>
             <span>></span>
           </li>
         </ul>
      </div>
      <div id="content-box" class="box">
         <div onclick="
         $('#big_body').hide();  
         System['import']('<?php  echo MODULE_URL.'plugin/suppliermenu/res/tpl/tpl-cotent.html!systemJsText';?>').then(function (a){
             
          $('body').append(  baidu.template(a)  ); 
            $('#content').html( $('input[name=\''+'content'+'\']').val() );
          });
            
          ">
            <span  >宝贝描述</span>
            <span>></span>
         </div>
      </div>

      <div id="footer">
         <span onclick='a(0);'>放入仓库</span>
         <span onclick='a(1);'>立即上架</span>
      </div>

      <input type="hidden" name="content" value="<%if status%><%goods.content%><%/if%>"/>
      <input type="hidden" name="pcate" value="<%if status%><%goods.pcate%><%/if%>"/>
      <input type="hidden" name="ccate" value="<%if status%><%goods.ccate%><%/if%>"/>
      <!--<input type="hidden" name="tcate" value=""/>-->
      <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
</form>
</div>
</script>

 


<script type="text/html" id="tpl-loading">
    <div id="loading" style="position: absolute; top:0px; left:0px; width:100%;padding-top:200px; text-align: center; height:100%; ">
         <img   src="<?php echo MODULE_URL.'plugin/suppliermenu/res/loading.gif?'.time();?>"/>
    </div>
</script>



<script type="text/javascript">
    require(['tpl', 'core'], function(tpl, core) {
       core.pjson('suppliermenu/goods', {id:'<?php echo empty($_GPC['id'])?0:$_GPC['id'];?>',op:'post','ac':'get' }, function(json) {
              
             $('body').append(tpl('tpl-big-body',json.result));
             

             if(json.result.status){
                $("#select-box").parent().before( baidu.template('tpl-img-box',{data:{img:json.result.goods.thumb}}  ));

                for(var x in json.result.goods.thumb_url ){
                     $("#select-box").parent().before( baidu.template('tpl-img-box',{data:{img:json.result.goods.thumb_url[x]}}  ));
                }



             }


       }, true,true);
    });
</script>


<script type="text/javascript">
    function  handleFiles(q)
    {
      var files =  q.files;
      if(files.length)
      {
          console.log(files.length);
          for(var x =0 ;x<files.length;x++ ){
             var file = files[x];
             if(!/image\/\w+/.test(file.type)){
                  alert("文件必须为图片！"+file.type);
                  return ;
             }
          }


          $.ajaxFileUpload({  
              url:'<?php  echo $this->createPluginMobileUrl('suppliermenu/goods',array( 'op'=>'upload')) ;?>',  
              secureuri:false,  
              fileElementId:$(q).attr('id'),        //file的id  
              dataType:"text",                  //返回数据类型为文本  
              success:function(data,status){  

                  var obj = JSON.parse(data);
                  for(var x in obj.result.url){

                    $("#select-box").parent().before( baidu.template('tpl-img-box',{data:{img:obj.result.url[x]}}  ));
                 
                  }   

              }  
          }) ;
 

           

      }
    }
</script>




<script type="text/javascript">




function pcate(){
    $('#big_body').hide();
    require(['tpl', 'core'], function(tpl, core) {
       core.pjson('suppliermenu/cate', {type:0}, function(json) {
             $('body').append(tpl('tpl-pcate-box',json.result));
       }, true);
    });
}


function ccate(a){
    $('#big_body').hide();
    $("input[name='pcate']").val($(a).attr('id'));

    require(['tpl', 'core'], function(tpl, core) {
       core.pjson('suppliermenu/cate', {type:$(a).attr('id')}, function(json) {
             if(json.result.status){
                  $('body').append(tpl('tpl-ccate-box',json.result));
             }else{
                  core.tip.show('没有下级分类');
             }
       }, true);
    });

}


function tcate(a){
    $('#big_body').hide();
    $("input[name='ccate']").val($(a).attr('id'));

}

function dataURLtoBlob(dataurl) {
    var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
    while(n--){
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new Blob([u8arr], {type:mime});
}
 

 function a(status){
 
      require(['tpl', 'core'], function(tpl, core) { 
        $('#big_body').append(tpl('tpl-loading')); 

        var data = {};
        if($("input[name='title']").val()==''){
          $("#loading").remove();
          core.tip.show('商品标题不能为空');
          return;
        }

        data['title'] = {data:[$("input[name='title']").val()]};
 
        if($("input[name='marketprice']").val()==''){
          $("#loading").remove();
          core.tip.show('市场价不能为空');
          return;
        }
        data['marketprice'] = {data:[$("input[name='marketprice']").val()]};

        if($("input[name='productprice']").val()==''){
          $("#loading").remove();
          core.tip.show('原价不能为空');
          return;
        }

        data['productprice'] = {data:[$("input[name='productprice']").val()]};

        if($("input[name='costprice']").val()==''){

          $("#loading").remove();
          core.tip.show('成本价不能为空');
          return;
        }

        data['costprice'] = {data:[$("input[name='costprice']").val()]};
        var files = new Array();
        $("input[name='file[]']").each(function(){
            files.push($(this).val());
        });

        data['post[]'] = {data:files };

 
        if($("input[name='pcate']").val()==''){
             $("#loading").remove();
             core.tip.show('分类不能为空');
             return;
        }

        data['pcate'] = {data:[$("input[name='pcate']").val()]};

        if($("input[name='ccate']").val()==''){
             $("#loading").remove();
             core.tip.show('分类不能为空');

             return;
        }

        data['ccate'] = {data:[$("input[name='ccate']").val()]};

        data['content'] = {data:[$("input[name='content']").val()]};

        data['status'] = {data:[status]};


        System['import']('<?php  echo MODULE_URL.'plugin/suppliermenu/res/js/FormData.js';?>').then(function (a){
            var fd =  a.append( data);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php  echo $this->createPluginMobileUrl('suppliermenu/goods',array( 'op'=>'post','ac'=>'sub','id'=>$id)) ;?>', true);
            xhr.send(fd);
            xhr.onreadystatechange=function(){
              if (xhr.readyState==4 && xhr.status==200)
              { 
                   var obj = JSON.parse(xhr.responseText);
                   if(!obj)  {core.tip.show('提交失败');return;}
                   if(!obj.result.status) {core.tip.show(obj.result.msg); return;}
                   alert('成功');
                   window.location.href = '<?php  echo  $this->createPluginMobileUrl('suppliermenu/goods');?>';

              }
            };
            $("#loading").remove();

        });


     });




 }







</script>







<?php  if(0) { ?>


<?php  $show_footer=true?>
<?php  $footer_current='member'?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
