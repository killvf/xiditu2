@extends('layout.admin.layout')
@section('content')

    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>管理</h1>
                </div>
            </div>
            <div class="col-sm-6 hidden-xs">
                <div class="header-section">
                    <ul class="breadcrumb breadcrumb-top">
                        <li>语言管理</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <!-- Table Styles Block -->
    <div class="block">
        <!-- Table Styles Title -->
        <div class="block-title clearfix">
            <!-- Changing classes functionality initialized in js/pages/tablesGeneral.js -->
            <div class="block-options pull-right">
                <a href="{{route('staff.language.add')}}" class="btn btn-effect-ripple btn-primary">添加</a>
            </div>
            <h2><span>语言列表</span></h2>
        </div>
        <!-- Table Styles Content -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-vcenter">
                <thead>
                <tr>
                    <th class="hidden-sm hidden-xs">id</th>
                    <th class="hidden-sm ">语言</th>
                    <th class="hidden-sm ">语言英文</th>
                    <th style="width: 120px;" class="text-center"><i class="fa fa-flash"></i></th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $language)
                    <tr>
                        <td class="hidden-sm hidden-xs">
                            <a href="javascript:void(0)" class="label label-warning">{{$language->id}}</a></td>
                        <td class="hidden-sm">{{$language->name}}</td>
                        <td class="hidden-sm hidden-xs">{{$language->english}}</td>
                        <td class="text-center">
                            <a href="{{route('staff.language.modify', ['id'=>$language->id])}}" data-toggle="tooltip" title="修改"
                               class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                            <a href="javascript:;" data-toggle="tooltip" onclick='removeItem("{{$language->id}}")'
                               title="删除"
                               class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$data->links()}}
        </div>
        <!-- END Table Styles Content -->
    </div>
    <!-- END Table Styles Block -->

@endsection

@section('script')
    <script>


    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
    });

    //删除指定记录
    function removeItem(id) {
        var target = event.currentTarget;
        if(window.confirm('你确定要删除这条记录吗')) {
            $.ajax({
                url: "{{route('staff.language.delete')}}",
                type: 'POST',
                data: {id: id},
                success: function(data) {
                    if(data.status) {
                        $(target).parents('tr').remove();
                    }
                }, 
                error: function(e) {
                    console.log(e)
                }
            });
        }
    }

    </script>

@endsection