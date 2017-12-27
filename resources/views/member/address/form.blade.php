
<ul class="address">
    <li>
        <span>收货人：</span>
        <input type="text" name="name" value="{{empty($data) ? '': $data->name}}" class="add-input" />
    </li>
    <li>
        <span>联系电话：</span>
        <input type="text" name="mobile" value="{{empty($data) ? '': $data->mobile}}" class="add-input" />
    </li>
    <li id="distpicker">
        <span>所在区域：</span>
        <select name="province" class="xg_select01">

        </select>
        <select name="city" class="xg_select01">

        </select>
        <select name="district" class="xg_select01">

        </select>
    </li>
    <li>
        <span>详细地址：</span>
        <input type="text" class="add-select" name="detail" value="{{empty($data) ? '': $data->detail}}" >
    </li>
    <li>
        <span>默认地址：</span>
        <span><input type="checkbox" name="default" value="1" class="mgc" @if(!isset($data) || $data->default == 1)checked @endif />&nbsp; 设为默认地址</span>
    </li>
</ul>
<input type="hidden" name="from" value="{{empty($_GET['from']) ? '' : $_GET['from']}}">
<?php
    $member = (new \App\Models\AgentUser())->find(session('member')->id);
?>
<input type="hidden" name="agent_user_id" value="{{$member->id}}">
<input type="submit" class="login-btn" value="确认提交">
{{csrf_field()}}