/**
 * Created by lengxue on 2016/4/26.
 */
$(function(){
    var opt;
    var one0=0;
    var defaultopt="<option value=''>请选择</option>";
    var nullopt="<option value=''>无数据，请重选上级分类</option>";
    $.get("/getlevel",{pid:one0},function(data,status){
        for(var i=0;i<data.length;i++){
            opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
            $(".mainselect").append(opt);
        }
    });

    $("body").on("change",".mainselect",function(){
        var val=$(this).val();
        $(".waitforopt").removeClass("waitforopt");
        $(this).parent().siblings("div").find(".midselect").empty().addClass("waitforopt");
        $(this).parent().siblings("div").find(".midselect").append(defaultopt);
        if(val==""){
        }else{
            $.get("/getlevel",{pid:parseInt(val)},function(data,status){
                if(data.length==0){
                    $(".waitforopt").find(".midselect").empty();
                    $(".waitforopt").append(nullopt);
                }else{
                    for(var i=0;i<data.length;i++){
                        opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
                        $(".waitforopt").append(opt);
                    }
                }
            });
        }
    });

    /*----添加分类----*/
    $("body").on("click",".add button",function(){
        var tem=$(".catemplate").clone().removeClass("hidden").removeClass("catemplate");
        $("#catarea").append(tem);
    });

    /*----删除分类----*/
    $("body").on("click",".minus button",function(){
        var len=$(".mainselect").length;
        if(len<3){
            alert("不能删除仅有的分类信息！");
        }else{
            $(this).parents(".form-group").remove();
        }
    });

    $("body").on("click",'.addcuspro',function(){
        var len=$(".line").length;
        var line='<tr class="line"> <td> <input type="text" name="attrname[]" class="form-control" required /> </td> <td> <textarea name="attrvalue[]" class="form-control" required rows="5"></textarea> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
        $("#stock").append(line);
    });

    $("body").on("click",'.delcuspro',function(){
        var len=$(".line").length;
        if(len>1){
            $(this).parents(".line").remove();
        }
    });
});

/*商品图片添加*/
$('#detail').diyUpload({
    url:'/img',
    formData:{
        gid:$("#gid").val(),
        imgtype:1
    },
    success:function( data ) {
        console.info( data.message );
        var len=$("#img").find("li").length;
        var lis='<li> <input type="hidden" name="pic['+len+'][url]" value="'+data.url+'"> <input type="hidden" name="pic['+len+'][imgtype]" value="1"> </li>';
        $("#img").append(lis);
    },
    error:function( err ) {
        console.info( err );
    },
});