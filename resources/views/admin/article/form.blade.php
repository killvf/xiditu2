
<div class="form-group">
    <label class="col-md-2 control-label" for="title">文章名<span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="title" name="title" value="{{empty($data) ?'' : $data->title}}" class="form-control"
               placeholder="文章名">
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label" for="language">语言<span class="text-danger">*</span></label>
    <div class="col-md-9">
        <select name="language" id="language" class="form-control">
            @foreach($languages as $english => $language)
                <option value="{{$english}}"
                        @if(!empty($data) && $data->english == $english) selected @endif>
                    {{$language}}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label" for="descr">描述<span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="descr" name="descr"
        value="{{empty($data) ?'' : $data->descr}}" class="form-control"
               placeholder="描述">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label" for="picture">图片<span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="file" id="picture" name="picture"
               value="{{empty($data) ?'' : $data->picture}}" class="form-control"
               placeholder="图片">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label" for="content">内容<span class="text-danger">*</span></label>

    <div class="col-md-9">
        <div id="content">{!!empty($data->content) ? '':  $data->content!!}</div>
        <input type="hidden" id="content-v" name="content" value="">
    </div>
</div>

{{csrf_field()}}

<script src="{{asset('admin/js/wangEditor.min.js')}}"></script>
<script>

    var baseUrl = '{{url("/")}}';

    $(function() {

        var E = window.wangEditor;
        var editor = new E('#content');

        editor.customConfig.uploadImgServer = '{{route('upload')}}';
        editor.customConfig.uploadFileName = 'file';
        editor.customConfig.uploadImgHeaders = {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        };
        editor.create();

        $('button[type="submit"]').on('click', function() {
            event.preventDefault();
            event.stopPropagation();
            $('#content-v').val(editor.txt.html());
            $('#form-validation').submit();
        });

//        $('#pic_upload').on('change', function() {
//            var value = $(this).val();
//            if($.trim(value) != '') {
//                ajaxFileUpload();
//            }
//        });
    });



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
