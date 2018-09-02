// 写入cookies
function setCookie(name,value)
{
    var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString() + "; path=/";
    console.log("添加cookie成功");
}

function setCookieWithTime(name,value,time)
{
    var strsec = getsec(time);
    var exp = new Date();
    exp.setTime(exp.getTime() + strsec*1);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}

// 读取cookies
function getCookie(name)
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}

// 删除cookies
function deleteCookie(name)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null)
        document.cookie= name + "="+cval+";expires="+exp.toGMTString()+ "; path=/";
}




//添加cookie
function addCookie(objName,objValue,objHours){
    var str = objName + "=" + escape(objValue);
    //为0时不设定过期时间，浏览器关闭时cookie自动消失
    if(objHours > 0)
    {
        var date = new Date();
        var ms = objHours*3600*1000;
        date.setTime(date.getTime() + ms);
        str += "; expires=" + date.toGMTString();
    }
    str += "; path=/";//红色标记必须加上(之前漏写就出现了问题)
    document.cookie = str;
    // alert("添加cookie成功");
}

