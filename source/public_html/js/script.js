function quote(text){if(document.selection){document.post.com.focus();sel=document.selection.createRange();sel.text=">>"+text+"\n";}else if(document.post.com.selectionStart||document.post.com.selectionStart=="0"){var startPos=document.post.com.selectionStart;var endPos=document.post.com.selectionEnd;document.post.com.value=document.post.com.value.substring(0,startPos)+">>"+text+"\n"+document.post.com.value.substring(endPos,document.post.com.value.length);}else{document.post.com.value+=">>"+text+"\n";}}
function replyhl(id){var tdtags=document.getElementsByTagName("td");for(i=0;i<tdtags.length;i++){if(tdtags[i].className=="replyhl")
tdtags[i].className="reply";if(tdtags[i].id==id)
tdtags[i].className="replyhl";}}
function repquote(rep){if(rep.match(/q([0-9]+)/)){rep=rep.replace(/q/,"");if(document.post.com.value==""){quote(rep);}}}
function reppop(url){day=new Date();id=day.getTime();window.open(url,id,'toolbar=0,scrollbars=0,location=0,status=1,menubar=0,resizable=1,width=512,height=128');return false;}
function init(){arr=location.href.split(/#/);if(arr[1]){if(arr[1].match(/(q)?([0-9]+)/)){rep=arr[1];re=arr[1].replace(/q/,"");replyhl(re);repquote(rep);}}}
