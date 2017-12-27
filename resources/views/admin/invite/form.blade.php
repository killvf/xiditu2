
<div class="form-group">
    <label class="col-md-2 control-label" for="name">岗位名<span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="name" name="name" value="{{empty($data) ?'' : $data->name}}" class="form-control"
               placeholder="岗位名">
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
    <label class="col-md-2 control-label" for="address">工作地点<span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="address" name="address"
        value="{{empty($data) ?'' : $data->address}}" class="form-control"
               placeholder="工作地点">
    </div>
</div>


<div class="form-group">
    <label class="col-md-2 control-label" for="amount">招聘人数<span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="amount" name="amount"
               value="{{empty($data) ?'' : $data->amount}}" class="form-control"
               placeholder="招聘人数">
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label" for="grade">学历<span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="grade" name="grade"
               value="{{empty($data) ?'' : $data->grade}}" class="form-control"
               placeholder="学历">
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label" for="year">工作年限<span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="year" name="year"
               value="{{empty($data) ?'' : $data->year}}" class="form-control"
               placeholder="工作年限">
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label" for="content">招聘详情<span class="text-danger">*</span></label>

    <div class="col-md-9">
        <div id="textarea" name="content" class="ckeditor">{!!empty($data->content) ? '':  $data->content!!}</div>
        <input type="hidden" id="content" name="content" value="">
    </div>
</div>

{{csrf_field()}}
{{--<script src="{{asset('admin/js/plugins/ckeditor/ckeditor.js')}}"></script>--}}
@section('script')
<script src="{{asset('admin/js/wangEditor.min.js')}}"></script>
    <script type="text/javascript">

        $(function() {
            var E = window.wangEditor;
            var editor = new E('#textarea');
            editor.create();

            $('button[type="submit"]').on('click', function() {
                event.preventDefault();
                event.stopPropagation();
                $('#content').val(editor.txt.html());
                $('#form-validation').submit();
            });
        });
    </script>
    @endsection