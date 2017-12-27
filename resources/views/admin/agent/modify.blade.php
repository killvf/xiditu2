@extends('layout.admin.layout')



@section('content')
        <!-- Validation Header -->
        <div class="content-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="header-section">
                        <h1>代理商管理</h1>
                    </div>
                </div>
                <div class="col-sm-6 hidden-xs">
                    <div class="header-section">
                        <ul class="breadcrumb breadcrumb-top">
                            <li><a href="{{route('staff.agent.lists')}}">代理商列表</a></li>
                            <li><a href="{{route('staff.agent.modify', ['id'=> $data->id])}}">修改代理商</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Validation Header -->

        <!-- Form Validation Content -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <!-- Form Validation Block -->
                <div class="block">
                    <!-- Form Validation Title -->
                    <div class="block-title">
                        <h2>修改代理商</h2>
                    </div>
                    <!-- END Form Validation Title -->

                    <!-- Form Validation Form -->
                    <form id="form-validation" action="{{route('staff.agent.modify', ['id'=>$data->id])}}" method="post" class="form-horizontal form-bordered">

                        @include('admin.agent.form')

                        <div class="form-group form-actions">
                            <div class="col-md-8 col-md-offset-3">
                                <button type="submit" class="btn btn-effect-ripple btn-primary">修改</button>
                                <button type="reset" class="btn btn-effect-ripple btn-danger">重置</button>
                            </div>
                        </div>
                    </form>
                    <!-- END Form Validation Form -->
                </div>
                <!-- END Form Validation Block -->
            </div>
        </div>
        <!-- END Form Validation Content -->


@endsection



@section('script')

    <script src="{{asset('admin/js/pages/formsValidation.js')}}"></script>
    <script>$(function(){ FormsValidation.init(); });</script>
@endsection