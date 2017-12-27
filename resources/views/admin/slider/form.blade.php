
<div class="form-group">
    <label class="col-md-2 control-label" for="title">幻灯片名<span class="text-danger">*</span></label>
    <div class="col-md-10">
        <input type="text" id="title" name="title" value="{{empty($data) ?'' : $data->title}}" class="form-control"
               placeholder="幻灯片名">
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label" for="language">语言<span class="text-danger">*</span></label>
    <div class="col-md-10">
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
    <label class="col-md-2 control-label" for="position">排序<span class="text-danger">*</span></label>
    <div class="col-md-10">
        <input type="text" id="position" name="position"
        value="{{empty($data) ?'' : $data->position}}" class="form-control"
               placeholder="排序">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label" for="picture">图片<span class="text-danger">*</span></label>
    <div class="col-md-10">
        <input type="file" id="picture" name="picture"
               value="{{empty($data) ?'' : $data->picture}}" class="form-control"
               placeholder="图片">
    </div>
</div>

{{csrf_field()}}

<script>

    var baseUrl = '{{url("/")}}';

    $(function() {

    });

</script>
