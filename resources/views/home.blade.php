@include('blocks.header')
<div id="process" class="row store-name" data-name="Keyword đang get:"></div>
    <div class="row">
        <div class="span4">
            <div class="store-name" data-name="Store Name">
                <input id="keywords" type="text" value="Udemy" />
                <button id="submit" class="btn btn-primary"><i class="icon-search"></i></button>
            </div>
        </div>
        <div class="span8">
            <div class="store-name" data-name="Title Keywords">
                <input id="tag" type="text" value="coupon,$" />
            </div>
        </div>
    </div>
    <div class="row span10">
        <div class="store-name" data-name="Results">
            <textarea id="dataGet">

            </textarea>
        </div>
    </div>

</div>


<script>

</script><script>
    function getStore(name) {
        if(typeof localStorage[name]=='undefined') return '';
        return JSON.parse(localStorage[name]);
    }
    function setStore(name, val) {
        localStorage[name] = val;
    }
    function in_array(arr, vl) {
        for(var i in arr) if(arr[i]==vl) return 1;
        return 0;
    }
    function unique(a) {
        for(var i=0; i<a.length; ++i) {
            for(var j=i+1; j<a.length; ++j) {
                if(a[i] === a[j])
                    a.splice(j--, 1);
            }
        }

        return a;
    };
    function getWhenDone() {
        var getArr = [];
        var keyTag = $('#tag').val().toLowerCase().split(',');
        var keyTagLen = keyTag.length;
            for(var i in localStorage) {
                if(in_array(explodeKey, i))
                {
                    for(var v in explodeKey) {
                        var dataKeys = JSON.parse(localStorage[explodeKey[v]]);
                        if(typeof dataKeys.message!='undefined') {alert('Lỗi máy gốc. get lại!');return;}
                        var dataKey = dataKeys.results.processed_keywords;
                        var dataUnProcess = dataKeys.results.unprocessed_keywords;
                        //search in key processed
                        for(var j in dataKey) {
                            var valKey = dataKey[j]['keyword'].toLowerCase();
                            var searchVolume = dataKey[j]['volume'];
                            var cpcKey = dataKey[j]['cpc'];
                            var competitionKey = dataKey[j]['competition'];
                            var isAdd = 0;
                            //if(valKey.indexOf(explodeKey[v])>-1)
                            if(keyTagLen==0) isAdd=1;
                            else for(var iv in keyTag) {
                                if(valKey.indexOf(keyTag[iv])>-1) {
                                        isAdd=1;
                                    }
                            }
                            if(isAdd) getArr.push([valKey,searchVolume,cpcKey,competitionKey].join('||'));
                           // var findPreg = new RegExp('/('+keyTag.join('|')+')/', 'g');
                        }
                        //search in key unprocess
                        for(var j in dataUnProcess) {
                            var valKey = dataUnProcess[j];
                            var isAdd = 0;
                            //if(valKey.indexOf(explodeKey[v])>-1)
                            if(keyTagLen==0) isAdd=1;
                            else for(var iv in keyTag) {
                                if(valKey.indexOf(keyTag[iv])>-1) {
                                    isAdd=1;
                                }
                            }
                            if(isAdd) getArr.push([valKey,'','',''].join('||'));
                        }

                    }
                }

            }
            getArr = unique(getArr).sort();
       for(var m in getArr) $('#dataGet').val($('#dataGet').val()+getArr[m]+"\n");

        $('#process').html('<b>Hoàn tất</b>!!!');
    }


    function getDataKey(kwName) {
    $('#process').html(kwName+' <b>Loading...</b>');
        $.get('get/' + encodeURIComponent(kwName), function (data) {
            setStore(kwName, JSON.stringify(data));

            //queue get data
            // console.log(keyGeted,explodeKey.length)

                if(keyGeted<explodeKey.length)
                    getDataKey(explodeKey[keyGeted]);
                else
                    getWhenDone();
                keyGeted++;
            //handle after getdone
        });
    };

    function removeSpace(str) {
        return str.trim().replace(/(\s*),(\s*)/, ',');
    }

    var explodeKey = [];
    var keyGeted = 1;
    $('#submit').on('click', function(){
            keyGeted = 1;
            $('#dataGet').val('');
            var keyTag = removeSpace($('#tag').val().toLowerCase()).split(',');
            var keywords = removeSpace($('#keywords').val().toLowerCase()).replace(/\s/g, '-');
            explodeKey = keywords.split(',');

            var addKeys = '';
            for(var k in explodeKey) {
                for(var t in keyTag) {
                    var checkKey = keyTag[t].replace(/[^A-Za-z0-9]/g,'');
                if(checkKey) addKeys += ',' + explodeKey[k] + '-' + checkKey;
                }
            }
            keywords += addKeys;//.replace(/,+$/,'');
            explodeKey = keywords.split(',');
            var kw = explodeKey[0];
                   getDataKey(kw);

    });

    window.onbeforeunload = function(){
        localStorage.clear();
    }
</script>

</body>
</html>