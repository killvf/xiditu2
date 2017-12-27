
<div class="form-group">
    <label class="col-md-3 control-label" for="title">导航名<span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="title" name="title" value="{{empty($data) ?'' : $data->title}}" class="form-control"
               placeholder="导航名">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label" for="language">语言<span class="text-danger">*</span></label>
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
    <label class="col-md-3 control-label" for="link">导航链接<span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="link" name="link"
        value="{{empty($data) ?'' : $data->link}}" class="form-control"
               placeholder="导航链接">
    </div>
</div>


<div class="form-group">
    <label class="col-md-3 control-label" for="position">排序<span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="position" name="position"
               value="{{empty($data) ?'' : $data->position}}" class="form-control"
               placeholder="排序">
    </div>
</div>

{{csrf_field()}}