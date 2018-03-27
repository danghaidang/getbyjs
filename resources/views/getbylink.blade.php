@extends('app')
@section('main')
<div class="row">
    <div class="span4 store-name" data-name="inter Links">
        <textarea id="list-link" style="width:95%;overflow:hidden" rows="20"></textarea>
    </div>
    <div class="span3 store-name" data-name="Button">
        <input id="convert" type="button" class="btn btn-default" value="Convert"><br/>
        <input id="getlink" type="button" class="btn btn-default" value="get Link">
    </div>
    <div id="links-data" class="span4 store-name" data-name="Links data">

    </div>
</div>
<!--link data-->
    <div class="row">
        <div class="span12 store-name" data-name="data geted">
        <textarea id="data-geted" style="width:95%;overflow:hidden" rows="20"></textarea>
        </div>
    </div>


<script>
    function convertLink() {
        var linksget = $('#list-link').val().split("\n");
        //console.log(linksget.length);
        for(var lk in linksget) {
            var alk = document.createElement('a');
            alk.href = linksget[lk];
            alk.innerHTML = "Link "+lk+"<br/>";
            $('#links-data').append(alk);
        }
    }
    function debugUrl() {
        var link = $('#links-data a').first();
        console.log('Error: ' +link.html() + ': ' + link.attr('href'));
    }

    function insertData(data) {
        $('#data-geted').val($('#data-geted').val()+data+"\n");
    }
    function getdata(url) {
            // $.get('getlinks/get?url='+url, function(data) {
            //     insertData(data);
            //     $('#links-data').find('a:first-child').remove();
            //     if($('#links-data').find('a').length>0) getdataByLinks();
            //     else alert('Get all Done!');
            // });
        $.ajax({
            url: 'getlinks/get?url='+url,
            type: 'GET',
            success: function(data){
                if(data!=0) insertData(data);
                else debugUrl();
                $('#links-data').find('a:first-child').remove();
                if($('#links-data').find('a').length>0) getdataByLinks();
                else alert('Get all Done!');
            },
            error: function(data) {
                debugUrl();
                getdataByLinks(); //or whatever
            }
        });
    }

    function getdataByLinks() {
        var linkFirst = $('#links-data a').first();
        var url = encodeURIComponent(linkFirst.attr('href'));
        getdata(url);
    }

    $(document).ready(function(){
        $('#convert').on('click',convertLink);
        $('#getlink').on('click', getdataByLinks);
    });

	window.onbeforeunload = function(){return 'Có chắc chắn thoát?';}
</script>





@endsection