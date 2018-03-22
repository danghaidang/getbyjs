@include('blocks.header')
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
            for(var i in localStorage) {
                if(in_array(explodeKey, i))
                {
                    for(var v in explodeKey) {
                        var dataKey = JSON.parse(localStorage[explodeKey[v]]);
                        dataKey = dataKey.results.processed_keywords;
                        for(var j in dataKey) {
                            var valKey = dataKey[j]['keyword'].toLowerCase();
                            var isAdd = 0;
                            for(var iv in keyTag) {
							if(valKey.indexOf(keyTag[iv])>-1 && valKey.indexOf(explodeKey[v])>-1) {
									isAdd=1;
								}
							}
                            if(isAdd) getArr.push(valKey);
                           // var findPreg = new RegExp('/('+keyTag.join('|')+')/', 'g');
                        }
                    }
                }

            }
            getArr = unique(getArr);
       for(var m in getArr) $('#dataGet').val($('#dataGet').val()+getArr[m]+"\n");
    }


    function getDataKey(kwName) {

        $.get('get/' + kwName, function (data) {
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


    var explodeKey = [];
    var keyGeted = 1;
    $('#submit').on('click', function(){
            keyGeted = 1;
            $('#dataGet').val('');
            var keyTag = $('#tag').val().toLowerCase();
            var keywords = $('#keywords').val().toLowerCase().replace(/\s/g, '');
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