<div class="modal fade bs-example-modal-lg" id="alert-box">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" id="model-content"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="alert_box.close()">确定</button>
            </div>
        </div>
    </div>
</div>


<script>

    var alert_box = {
        'alert': function(msg) {
            $('#model-content').html(msg);
            $('#alert-box').show();
        },
        'close' : function () {
            $('#alert-box').hide();
        }
    }


</script>