
<div class="form-group">
    <label class="col-md-3 control-label" for="name">语言名<span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="name" name="name" value="{{empty($data) ?'' : $data->name}}" class="form-control"
               placeholder="语言名">
    </div>
</div>



<div class="form-group">
    <label class="col-md-3 control-label" for="english">语言英文<span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="english" name="english"
        value="{{empty($data) ?'' : $data->english}}" class="form-control"
               placeholder="语言英文">
    </div>
</div>

{{csrf_field()}}