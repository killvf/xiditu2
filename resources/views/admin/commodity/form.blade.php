
<div class="form-group">
    <label class="col-md-2 control-label" for="name">商品名<span class="text-danger">*</span></label>
    <div class="col-md-10">
        <input type="text" id="name" name="name" value="{{empty($data) ?'' : $data->name}}" class="form-control"
               placeholder="商品名">
    </div>
</div>


<div class="form-group">
    <label class="col-md-2 control-label" for="title">商品信息<span class="text-danger">*</span></label>
    <div class="col-md-10">
        <input type="text" id="title" name="title" value="{{empty($data) ?'' : $data->title}}" class="form-control"
               placeholder="商品信息">
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label" for="unit_price">单价<span class="text-danger">*</span></label>
    <div class="col-md-10">
        <input type="text" id="unit_price" name="unit_price" value="{{empty($data) ?'' : $data->unit_price / 100}}" class="form-control"
               placeholder="单价">
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label" for="brand">品牌<span class="text-danger">*</span></label>
    <div class="col-md-10">
        <input type="text" id="brand" name="brand" value="{{empty($data) ?'' : $data->brand}}" class="form-control"
               placeholder="品牌">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label" for="weight">净含量<span class="text-danger">*</span></label>
    <div class="col-md-10">
        <input type="text" id="weight" name="weight" value="{{empty($data) ?'' : $data->weight}}" class="form-control"
               placeholder="净含量">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label" for="onsale_time">上市时间<span class="text-danger">*</span></label>
    <div class="col-md-10">

        <input type="text" id="onsale_time" name="onsale_time" readonly="readonly"  value="{{empty($data) ?'' : $data->onsale_time}}" class="form-control input-datepicker"
             data-date-format="yyyy-mm-dd"  placeholder="上市时间">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label" for="can_auction">是否可拍<span class="text-danger">*</span></label>
    <div class="col-md-10">
        <select name="can_auction" id="can_auction" class="form-control">
                <option value="1" @if(!empty($data) && $data->can_auction == \App\Models\AgentCommodity::AUCTION_TRUE) selected @endif>是</option>
                <option value="0"  @if(!empty($data) && $data->can_auction == \App\Models\AgentCommodity::AUCTION_FALSE) selected @endif>否</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label" for="status">商品状态<span class="text-danger">*</span></label>
    <div class="col-md-10">
        <select name="status" id="status" class="form-control">
                <option value="1" @if(!empty($data) && $data->status == \App\Models\AgentCommodity::STATUS_DEFAULT) selected @endif>上架</option>
                <option value="0" @if(!empty($data) && $data->status == \App\Models\AgentCommodity::STATUS_FORBIDEN) selected @endif>下架</option>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label" for="description">商品详情<span class="text-danger">*</span></label>
    
    <div class="col-md-10">
        <textarea id="textarea-ckeditor" name="description" class="ckeditor">{!!empty($data->description) ? '':  $data->description!!}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label" for="pic_upload">商品图片<span class="text-danger">*</span></label>
    <div class="col-md-10">
        <div class="img-container">
            <p>双击删除图片</p>
            <img src="{{url($data->picture)}}"  style="width:100px;height:100px;border:1px solid #ccc;" ondblclick="deletePic('{{$picture->url}}')"/>
        </div>
        <input type='file' name="file" id='pic_upload'/>
        <input type='hidden' name="pics" value='' id='pic_val'>
    </div>
</div>
{{--  商品详情的富文本编辑器  --}}
{{csrf_field()}}
<script src="{{asset('admin/js/plugins/ckeditor/ckeditor.js')}}"></script>
{{--  <script src="{{asset('admin/js/ajaxfileupload.js')}}"></script>  --}}
<script>

    var baseUrl = '{{url("/")}}';

    $(function() {
        $('#pic_upload').on('change', function() {
            var value = $(this).val();
            if($.trim(value) != '') {
                ajaxFileUpload();
            }
        });
        

      

       
    });

   
    <?php $pictures = json_encode($pictures); ?>

    var picArr = {!!$pictures!!};
 
    //删除图片数组中的某个值
    function removePic(name) {
        var index = picArr.indexOf(name);
        if(index !== -1) {
            picArr.splice(index, 1);
        }
    }

    function ajaxFileUpload() {
        var formData = new FormData($('#form-validation')[0]);
        $.ajax({  
          url: '{{route("upload")}}' ,  
          type: 'POST',  
          data: formData,  
          async: false,  
          cache: false,  
          dataType: 'json',
          contentType: false,  
          processData: false,  
          success: function (data) {  
              if(data.status) {
                  var imgStr = '<img src="'+ baseUrl +'/'+ data.name +'"  style="width:100px;height:100px;border:1px solid #ccc;" ondblclick="deletePic(\''+data.name+'\')"/>';
                  $('.img-container').append(imgStr);
                  picArr.push(data.name);
                  $('#pic_val').val(picArr.join(','));
              }
              //不管成功没得都把file清空
              $('input[type="file"]').val('');
          },  
          error: function (returndata) {  
              alert(returndata);  
          }  
     });  
    }

    function deletePic(name) {
        var target = event.currentTarget;
       $.ajax({  
          url: '{{route("delpic")}}',  
          type: 'GET',  
          data: {'name': name},  
          dataType: 'json',
          success: function (data) {  
             $(target).remove();
             removePic(name);
             $('#pic_val').val(picArr.join(','));
          },  
          error: function (returndata) {  
              alert(returndata);  
          }  
     });  
    }

</script>
