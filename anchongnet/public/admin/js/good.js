/**
 * Created by lengxue on 2016/4/24.
 */
$(function(){
    $(".view").click(function(){
        $("#myModalLabel").text($(this).attr("data-name"));
        var id=$(this).attr("data-id");
        $.get("/good/"+id,function(data,status){
            $("#goodname").text(data.goods_name);
            $("#market").text(data.market_price);
            $("#cost").text(data.goods_price);
            $("#vip").text(data.vip_price);
            $("#desc").text(data.goods_desc);
            $("#keywords").text(data.keyword);
            $("#goodpic").attr("src",data.goods_img);
            $("#added").text(data.goods_create_time);
            $("#goodsnumbering").text(data.goods_numbering);
        });
        var cid=$(this).attr("data-cid");
        $.get("/goodcatetype/"+cid,function(data,status){
            $("#cat").text(data.cat_name);
        });
        $.get("/getStock",{gid:id},function(data,status){
            $("#stock").empty();
            var dl;
            for(var i=0;i<data.length;i++){
                dl="<dl class='dl-horizontal'> <dt>"+data[i].region+"</dt> <dd>"+data[i].region_num+"</dd> </dl>";
                $("#stock").append(dl);
            }
        });
        var gid=$(this).attr("data-gid");
        $.get("/commodity/"+gid,function(data,status){
            $("#good").text(data.title);
        });
    });

    /*
    * 页面初始化时候将分类加载进来
    * */
    //加载一级分类
    var opt;
    var one0=0;
    $.get("/getlevel",{pid:one0},function(data,status){
        for(var i=0;i<data.length;i++){
            opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
            $("#mainselect").append(opt);
        }
    });

    $(".edit").click(function(){
        $("#backselect").empty();
        $("#midselect").empty();
        var cid=$(this).attr("data-cid");
        var id=$(this).attr("data-id");
        var gid=$(this).attr("data-gid");
        var sid=$("#sid").val();
        var opt;
        var firstPid;
        var secondPid;
        $("#updateform").attr("action","/good/"+id);
        $("#gid").val(id);
        $.get("/getsiblingslevel",{cid:cid},function(data,status){
            for(var i=0;i<data.length;i++){
                opt="<option  value="+data[i].cid+">"+data[i].cat_name+"</option>";
                $("#backselect").append(opt);
            }
            $("#backselect option[value="+cid+"]").attr("selected",true);
            firstPid=data[0].cat_id;
            secondPid=data[0].parent_id;
            $("#mainselect option[value="+firstPid+"]").attr("selected",true);

            $.get("/getlevel",{pid:firstPid},function(data,status){
                for(var j=0;j<data.length;j++){
                    opt="<option  value="+data[j].cat_id+">"+data[j].cat_name+"</option>";
                    $("#midselect").append(opt);
                }
                $("#midselect option[value="+secondPid+"]").attr("selected",true);
            });
        });

        $("#name").empty();
        $.get("/getsibilingscommodity",{pid:cid,sid:sid},function(data,status){
            if(data.length==0){
                $("#name").append(nullopt);
            }else{
                for(var i=0;i<data.length;i++){
                    opt="<option  value="+data[i].goods_id+">"+data[i].title+"</option>";
                    $("#name").append(opt);
                }
                $("#name option[value="+gid+"]").attr("selected",true);
            }
        })

        $.get("/good/"+id+"/edit",function(data,status){
            $("#spetag").val(data.goods_name);
            $("#marketprice").val(data.market_price);
            $("#costprice").val(data.goods_price);
            $("#viprice").val(data.vip_price);
            $("#description").val(data.goods_desc);
            $("#keyword").val(data.keyword);
            if(data.goods_create_time=="0000-00-00 00:00:00"){
                $("#notonsale").attr("checked",true);
            }else{
                $("#onsale").attr("checked",true);
            }
            $("#numbering").val(data.goods_numbering);
        });

        $.get("/getStock",{gid:id},function(data,status) {
            $("#stocktr").empty();
            var line;
            for(var k=0;k<data.length;k++){
                line='<tr class="line"> <td> <input type="text" class="region form-control" value="'+data[k].region+'" /> </td> <td> <input type="number" min="0" class="regionum form-control" value="'+data[k].region_num+'" /> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="savestock btn-sm btn-link" data-id="'+data[k].stock_id+'" title="保存"> <span class="glyphicon glyphicon-save"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除" data-id="'+data[k].stock_id+'"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
                $("#stocktr").append(line);
            }
        });

        $.get("/getgoodthumb",{gid:id},function(data,status) {
            $(".notem").remove();
            var gallery;
            for(var i=0;i<data.length;i++){
                switch(parseInt(data[i].img_type)){
                    case 1:
                        gallery='<li class="notem"> <div class="gallery text-center"> <img src="'+data[i].thumb_url+'" class="img"> </div> <input type="file" name="pic[]" class="pic" data-id="'+data[i].tid+'" data-type="'+data[i].img_type+'"> </li>';
                        $("#addforgood").before(gallery);
                        break;
                    case 2:
                        gallery='<li class="notem"> <div class="gallery text-center"> <img src="'+data[i].thumb_url+'" class="img"> </div> <input type="file" name="detailpic[]" class="pic" data-id="'+data[i].tid+'" data-type="'+data[i].img_type+'"> </li>';
                        $("#addfordetail").before(gallery);
                        break;
                    case 3:
                        gallery='<li class="notem"> <div class="gallery text-center"> <img src="'+data[i].thumb_url+'" class="img"> </div> <input type="file" name="parampic[]" class="pic" data-id="'+data[i].tid+'" data-type="'+data[i].img_type+'"> </li>';
                        $("#addforparam").before(gallery);
                        break;
                    case 4:
                        gallery='<li class="notem"> <div class="gallery text-center"> <img src="'+data[i].thumb_url+'" class="img"> </div> <input type="file" name="datapic[]" class="pic" data-id="'+data[i].tid+'" data-type="'+data[i].img_type+'"> </li>';
                        $("#addfordata").before(gallery);
                        break;
                    default:
                }
            }
            for(var i=0;i<$(".gallerys").length;i++){
                $(".gallerys").eq(i).find(".notem").eq(0).addClass("first");
            }
            for(var j=0;j<($(".notem").length);j++){
                if($(".notem").eq(j).hasClass("first")){
                }else{
                    $(".notem").eq(j).prepend('<button type="button" class="delpic btn btn-xs btn-danger" title="删除">x</button>');
                }
            }
        });
    });

    $("body").on("click",'.addcuspro',function(){
        var len=$(".line").length;
        var line='<tr class="line"> <td> <input type="text" class="region form-control" /> </td> <td> <input type="number" min="0" class="regionum form-control" /> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="savestock btn-sm btn-link" title="保存"> <span class="glyphicon glyphicon-save"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
        $("#stocktr").append(line);
    });

    $("body").on("click",'.savestock',function(){
        var region=$(this).parentsUntil("#stocktr").find(".region").val();
        var regionum=$(this).parentsUntil("#stocktr").find(".regionum").val();
        if(region==""){
            alert("库存区域不能为空！");
            $(this).parentsUntil("#stocktr").find(".region").focus();
        }else if(regionum==""){
            alert("库存数量不能为空！");
            $(this).parentsUntil("#stocktr").find(".regionum").focus();
        }else{
            var id=$(this).attr("data-id");
            var gid=$("#gid").val();
            $("#save").attr("id","");
            $(this).attr("id","save");
            $("#del").attr("id","");
            $(this).siblings(".delcuspro").attr("id","del");
            if(id==undefined){
                $.ajax({
                    url: "/stock",
                    type:'POST',
                    data:{gid:gid,region:region,regionum:regionum},
                    success:function( response ){
                        alert(response.message);
                        $("#save").attr("data-id",response.id);
                        $("#del").attr("data-id",response.id);
                    }
                });
            }else{
                $.ajax({
                    url: "/stock/"+id,
                    type:'PUT',
                    data:{gid:gid,region:region,regionum:regionum},
                    success:function( response ){
                        alert(response.message);
                    }
                });
            }
        }
    });

    $("body").on("click",'.delcuspro',function(){
        var gid=$("#gid").val();
        var id=$(this).attr("data-id");
        if(confirm("你确定要删除该条库存信息吗？")){
            $(this).parents(".line").addClass("waitfordel");
            $.get("/getStock",{gid:gid},function(data,status){
                if(data.length==1){
                    alert("不能删除最后一条库存信息！");
                    $(".waitfordel").removeClass("waitfordel");
                }else{
                    $.ajax({
                        url: "/stock/"+id,
                        type:'DELETE',
                        success:function(result){
                            alert(result);
                            $.get('/getotal',{gid:gid},function(data,status){

                            });
                        }
                    });
                    $(".waitfordel").remove();
                }
            });
        }
    });

    var nullopt="<option value=''>无数据，请重选上级分类</option>";
    $("body").on("change",'#mainselect',function(){
        var val=$(this).val();
        $("#midselect").empty();
        $("#backselect").empty();
        $.get("/getlevel",{pid:parseInt(val)},function(data,status){
            if(data.length==0){
                $("#midselect").append(nullopt);
            }else{
                for(var i=0;i<data.length;i++){
                    opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
                    $("#midselect").append(opt);
                }
            }
        });
    });

    $("body").on("change",'#midselect',function(){
        var val=$(this).val();
        $("#backselect").empty();
        $.get("/getlevel3",{pid:parseInt(val)},function(data,status){
            if(data.length==0){
                $("#backselect").append(nullopt);
            }else{
                for(var i=0;i<data.length;i++){
                    opt="<option  value="+data[i].cid+">"+data[i].cat_name+"</option>";
                    $("#backselect").append(opt);
                }
            }
        })
    });

    $("body").on("change",'#backselect',function(){
        var val=$(this).val();
        $("#name").empty();
        var sid=$("#sid").val();
        $.get("/getsibilingscommodity",{pid:parseInt(val),sid:sid},function(data,status){
            if(data.length==0){
                $("#name").append(nullopt);
            }else{
                for(var i=0;i<data.length;i++){
                    opt="<option  value="+data[i].goods_id+">"+data[i].title+"</option>";
                    $("#name").append(opt);
                }
            }
        })
    });

    $("body").on("click",'.gallery',function(){
        $(this).siblings(".pic").click();
    });

    $("body").on("change",'.pic',function(){
        var id=$(this).attr("data-id");
        var imgtype=$(this).attr("data-type");
        $("#imgtype").val(imgtype);
        if(id==undefined){
            $("#method").empty();
            var objUrl = getObjectURL(this.files[0]) ;
            var filename=$(this).val();
            $(".isAdd").removeClass("isAdd");
            $(this).addClass("isAdd");
            if (objUrl) {
                $(".isEdit").removeClass("isEdit");
                $(this).siblings(".gallery").find(".img").addClass("isEdit");

                if($(this).parents("li").hasClass("first")){
                }else{
                    $(this).siblings(".gallery").before('<button type="button" class="delpic btn btn-xs btn-danger" title="删除">x</button>');
                }
                $("#formToUpdate").ajaxSubmit({
                    type: 'post',
                    url: '/thumb',
                    success: function (data) {
                        alert(data.message);
                        if(data.isSuccess==true){
                            $(".isEdit").attr("src", objUrl);
                            $(".isAdd").attr("data-id",data.id);
                        }
                    },
                });
            }
        }else{
            var method='<input type="hidden" name="_method" value="PUT">';
            $("#method").append(method);
            if(confirm('你确定要替换这张图片吗？')){
                var objUrl = getObjectURL(this.files[0]) ;
                var filename=$(this).val();
                if (objUrl) {
                    $(".isEdit").removeClass("isEdit");
                    $(this).siblings(".gallery").find(".img").addClass("isEdit");
                    $("#formToUpdate").ajaxSubmit({
                        type:'post',
                        url:'/thumb/'+id,
                        success:function(data){
                            alert(data.message);
                            if(data.isSuccess==true){
                                $(".isEdit").attr("src",objUrl);
                            }
                        },
                    });
                }
            }
        }
    });

    $("body").on("click",'.delpic',function(){
        if(confirm('确定要删除该张图片吗？')){
            var id=$(this).siblings('.pic').attr("data-id");
            $.ajax({
                url: '/thumb/'+id,
                type:'DELETE',
                success:function(result){
                    alert(result);
                }
            });
            $(this).parent().remove();
        }
    });

    //建立一個可存取到該file的url
    function getObjectURL(file) {
        var url = null ;
        if (window.createObjectURL!=undefined) { // basic
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }

    $(".addpic").click(function(){
        if($(this).hasClass("goodpic")){
            var len=$(this).parentsUntil(".gal").find("li").length;
            if(len<6){
                $(this).before($(this).siblings(".template").clone().attr("class",""));
            }else{
                alert("最多只能添加五张图片！");
            }
        }else{
            $(this).before($(this).siblings(".template").clone().attr("class",""));
        }
    });
});