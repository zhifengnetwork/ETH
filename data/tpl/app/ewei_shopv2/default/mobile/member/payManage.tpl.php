<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
  .qbadress {
    display: flex;
    -webkit-display: flex;
    margin: 0 0 0px 0;
    padding: 10px 3% 0 3%;
    background: white;
  }

  .qbadress .fui-content-title {
    flex: 1;
  }

  .qbadress .fui-content-box {
    flex: 3;
  }

  .fui-content-title:nth-of-type(1) {
    line-height: 39px;
    text-align: right;
  }

  .fui-content-title:nth-of-type(2) {
    line-height: 39px;
  }

  .fui-content-box input {
    height: 39px;
    width: 100%;
    display: block;
    padding: 0px;
    margin: 0px;
    border: 0px;
    float: left;
    font-size: 0.7rem;
    border-bottom: 1px solid #ccc;
    padding-left: 3%;
  }

  .pic {
    padding-left: 3%;
  }

  .pic img {
    width: 8rem;
    height: 8rem;
  }

  #imgFile0 {
    position: absolute;
    width: 8rem;
    height: 8rem;
    -webkit-tap-highlight-color: transparent;
    filter: alpha(Opacity=0);
    opacity: 0;
  }

  .btn-sub {
    width: 90%;
    position: relative;
    /*bottom:10%;*/
    left: 5%;
  }

  .fui-cell-group {
    margin-top: 0;
  }
</style>

<div class='fui-page  fui-page-current'>

  <div class="fui-header">
    <div class="fui-header-left">
      <a class="back"></a>
    </div>
    <div class="title">钱包地址</div>
    <div class="fui-header-right">&nbsp;</div>
  </div>

  <div class="fui-content">

    <!-- 钱包地址 -->
    <div class="qbadress">
      <div class="fui-content-title">
        钱包地址:
      </div>
      <div class="fui-content-box">
        <input type="text" name="qbadress" value="<?php  echo $member['walletaddress'];?>" class="form-control ad" id="ad">
      </div>
    </div>

    <!-- 钱包二维码 -->
    <div class="qbadress">
      <div class="fui-content-title">

        钱包二维码:
      </div>
      <div class="fui-content-box">
        <div class="pic qb">
          <div class="plus" style="position:relative">
            <i class="fa fa-plus" style="position:absolute;"></i>
            <input type="file" name='imgFile0' id='imgFile0' />
          </div>
          <div class="images">
            <img src="<?php  echo $member['walletcode'];?>" />

          </div>
          <input type="hidden" value="<?php  echo $member['walletcode'];?>" id="avatar" />
        </div>
      </div>
    </div>

    <div class="qbadress">
      <button class="btn btn-default btn-sub">确定</button>
    </div>

  </div>

</div>

<script>
  require(['core'], function (core) {

    var qbimg = $('.qb .images img');

    if ("<?php  echo $member['walletcode'];?>" == '') {
      qbimg.prop('src', '../addons/ewei_shopv2/static/images/upload.png')
    }

    // 钱包二维码上传
    $('#imgFile0').change(function () {
      // core.loading('正在上传');

      var comment = $(this).closest('.comment_main');
      var ogid = comment.data('ogid');
      var filesx = document.getElementById('imgFile0').files[0];
      console.log(filesx);

      $.ajaxFileUpload({
        url: core.getUrl('util/uploader'),
        data: { file: "imgFile0" },
        secureuri: false,
        fileElementId: 'imgFile0',
        dataType: 'json',
        success: function (res, status) {
          var src2 = $('.qb .images img').prop('src');
          console.log(res.url);
          if (res.url == undefined) {
            return false;
          }
          // core.removeLoading();
          //var obj = $(tpl('tpl_img', res));
          var obj = document.createElement('img');
          obj.src = res.url;
          obj.style.width = '8rem';
          obj.style.height = '8rem';

          $('.qb .images').html(' ');
          $('.qb .images').append(obj);
          $('.qb #avatar').val(res.url);

        }, error: function (data, status, e) {
          // core.removeLoading();
          core.tip.show('上传失败!');
        }
      });
    });

    $('.btn-sub').click(function () {
      var adress = $('#ad').val();

      if ($('#ad').isEmpty()) {
        core.tip.show('请填写钱包地址！');
        return false;
      }
      if ($('#avatar').isEmpty()) {
        core.tip.show('请上传钱包二维码！');
        return false;
      }

      $.ajax({
        url: "<?php  echo mobileUrl('member/wallet/submit')?>",
        type: 'post',
        data: {adress: adress,url:$('#avatar').val()},
        dataType: 'json',
        success: function (data) {
          console.log(data);
          
          if (data.status == 1) {
            core.tip.show('上传成功');
            setTimeout(function () {
              window.location.href = "<?php  echo mobileUrl('member/wallet')?>";
            }, 1000)
          }
        }, error: function (e) {
          console.log(e)
        }
      })



    })


  })

</script>


<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>