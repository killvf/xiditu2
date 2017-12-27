
<div class="form-group">
    <label class="col-md-3 control-label" for="agent_code">编码<span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" id="agent_code" name="agent_code" value="{{empty($data) ?'' : $data->agent_code}}" class="form-control"
               placeholder="编码">
    </div>
</div>



<div class="form-group">
    <label class="col-md-3 control-label" for="username">用户名<span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" id="username" name="username" 
        value="{{empty($data) ?'' : $data->username}}" class="form-control"
               placeholder="用户名">
    </div>
</div>




<div class="form-group">
    <label class="col-md-3 control-label" for="realname">真实姓名<span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" id="realname" name="realname" 
        value="{{empty($data) ?'' : $data->realname}}" class="form-control"
               placeholder="真实姓名">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label" for="identify_code">身份证<span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" id="identify_code" name="identify_code" 
        value="{{empty($data) ?'' : $data->identify_code}}" class="form-control"
               placeholder="身份证">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label" for="mobile">手机号<span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" id="mobile" name="mobile" 
        value="{{empty($data) ?'' : $data->mobile}}" class="form-control"
               placeholder="手机号">
    </div>
</div>



<div class="form-group">
    <label class="col-md-3 control-label" for="ali_account">支付宝账号<span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" id="ali_account" name="ali_account" 
        value="{{empty($data) ?'' : $data->ali_account}}" class="form-control"
               placeholder="支付宝账号">
    </div>
</div>


<div class="form-group">
    <label class="col-md-3 control-label" for="wechat_account">微信号<span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" id="wechat_accountv" name="wechat_account" 
        value="{{empty($data) ?'' : $data->wechat_account}}" class="form-control"
               placeholder="微信号">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label" for="status">状态<span class="text-danger">*</span></label>
    <div class="col-md-6">
        <select name="status" id="status" class="form-control">
                <option value="0" @if(!empty($data) && $data->status == 0)selected @endif>禁用</option>
                <option value="1" @if(!empty($data) && $data->status == 1)selected @endif>正常</option>
        </select>
    </div>
</div>
{{--  <div class="form-group">
    <label class="col-md-3 control-label" for="is_partner">是否合伙人<span class="text-danger">*</span></label>
    <div class="col-md-6">
        <select name="is_partner" id="is_partner" class="form-control">
                <option value="0" @if(!empty($data) && $data->is_partner == 0)selected @endif>否</option>
                <option value="1" @if(!empty($data) && $data->is_partner == 1)selected @endif>是</option>
        </select>
    </div>
</div>  --}}

<div class="form-group">
    <label class="col-md-3 control-label" for="remark">备注<span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" id="remark" name="remark" 
        value="{{empty($data) ?'' : $data->remark}}" class="form-control"
               placeholder="备注">
    </div>
</div>

{{csrf_field()}}