
    //courtesy of BoogieJack.com
    function killCopy(e){
        return false
    }
function reEnable(){
    return true
}
document.onselectstart=new Function ("return false");
if (window.sidebar){
    document.onmousedown=killCopy;
    document.onclick=reEnable
}
/**
 * Created by IGE OLUWASEGUN on 11/11/2017.
 */
