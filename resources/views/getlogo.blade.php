@extends('app');
@section('main')
<center>
    <div class="row">
        <div class="span4">
            <div class="store-name" data-name="Domain đang get: ">
                <div id="domain-geted"></div> <b>...</b>
                <div id="domain-fail"></div>
            </div>
        </div>
        <div class="span4">
            <div class="store-name" data-name="Domain Name">
                <textarea id="domain" placeholder="Nhập danh sách domain"></textarea>
                <button id="submit" class="btn btn-primary"><i class="icon-search"></i></button>
            </div>
        </div>
    </div>
    <div class="row span10">
        <div class="store-name" data-name="Results">
                <textarea id="dataGet" style="width: 100%"></textarea>
            <input class="btn" type="button" onclick="$('#dataGet').val('')" value="Xóa">
        </div>
    </div>

</center>

<script>
    function debugErr(domain) {
        if(!$('#data-fail').length) $('#domain-fail').html('<b class="btn btn-danger">Tên miền lỗi:</b><br/><textarea id="data-fail"></textarea>')
        $('#data-fail').html($('#data-fail').val()+domain+"\n");
    }

    function whenDone() {
        $('#domain-geted').html('<b>Hoàn tất</b>');
    }
    function getData(domain) {
        $('#domain-geted').html(domain);
        domain = encodeURIComponent(domain);
        $.ajax({
            url: 'getlogo/get?domain='+domain,
            type: 'GET',
            success: function(data) {
                if(data!=0 && data) {
                    var strResult = $('#dataGet').val() + domain + '|' + data + "\n";
                    $('#dataGet').val(strResult);
                } else debugErr(domain);

                if(keyGeted<domainList.length) getData(domainList[keyGeted]);
                else whenDone();
                keyGeted++;
            },
            error: function(){
                debugErr(domain);
            }
        });

    }

    var domainList = [];
    keyGeted = 1;
    $(document).ready(function(){
        $('#submit').on('click', function(){
            keyGeted = 1;
            domainList = $('#domain').val().split(/\n|\,|\|/);
            getData(domainList[0]);

        });
    });
</script>

@endsection