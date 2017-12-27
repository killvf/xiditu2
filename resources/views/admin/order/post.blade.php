@extends('layout.admin.layout')

@section('content')
    <!-- Page content -->
    <div id="page-content">
        <!-- Validation Header -->
        <div class="content-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="header-section">
                        <h1>发货管理</h1>
                    </div>
                </div>
                <div class="col-sm-6 hidden-xs">
                    <div class="header-section">
                        <ul class="breadcrumb breadcrumb-top">
                            <li><a href="{{route('staff.order.lists')}}">订单列表</a></li>
                            <li><a href="{{route('staff.order.post', ['id'=>$order->id])}}">发货信息</a></li>
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
                        <h2>发货信息</h2>
                    </div>
                    <!-- END Form Validation Title -->

                    <!-- Form Validation Form -->
                    <form id="form-validation" action="{{route('staff.order.post', ['id'=>$order->id])}}" method="post" class="form-horizontal form-bordered">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="order_code">订单号<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" id="order_code" name="order_code" readonly="readonly" value="{{empty($order) ?'' : $order->order_code}}" class="form-control"
                                       placeholder="订单号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="post_company">快递公司<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" id="post_company" name="post_company" value="{{empty($order) ?'' : $order->post_company}}" class="form-control"
                                       placeholder="快递公司">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="post_code">快递单号<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" id="post_code" name="post_code" value="{{empty($order) ?'' : $order->post_code}}" class="form-control"
                                       placeholder="快递单号">
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <div class="col-md-8 col-md-offset-3">
                                <button type="submit" class="btn btn-effect-ripple btn-primary">添加</button>
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
    </div>
    <!-- END Page Content -->

@endsection



@section('script')
    {{--
        <script src="js/pages/formsValidation.js"></script>
    <script>
        $(function(){
            FormsValidation.init();

        });

    </script>  --}}
@endsection