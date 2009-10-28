var ie=document.all
var dom=document.getElementById

if (hsis_slideimages.length>1)
hsis_i=2
else
hsis_i=0

function hsis_move1(whichlayer){
tlayer=eval(whichlayer)
if (tlayer.left>0&&tlayer.left<=5){
tlayer.left=0
setTimeout("hsis_move1(tlayer)",hsis_pausebetweenimages)
setTimeout("hsis_move2(document.hsis_main.document.second)",hsis_pausebetweenimages)
return
}
if (tlayer.left>=tlayer.document.width*-1){
tlayer.left-=5
setTimeout("hsis_move1(tlayer)",50)
}
else{
tlayer.left=parseInt(hsis_scrollerwidth)+5
tlayer.document.write(hsis_slideimages[hsis_i])
tlayer.document.close()
if (hsis_i==hsis_slideimages.length-1)
hsis_i=0
else
hsis_i++
}
}

function hsis_move2(whichlayer){
tlayer2=eval(whichlayer)
if (tlayer2.left>0&&tlayer2.left<=5){
tlayer2.left=0
setTimeout("hsis_move2(tlayer2)",hsis_pausebetweenimages)
setTimeout("hsis_move1(document.hsis_main.document.first)",hsis_pausebetweenimages)
return
}
if (tlayer2.left>=tlayer2.document.width*-1){
tlayer2.left-=5
setTimeout("hsis_move2(tlayer2)",50)
}
else{
tlayer2.left=parseInt(hsis_scrollerwidth)+5
tlayer2.document.write(hsis_slideimages[hsis_i])
tlayer2.document.close()
if (hsis_i==hsis_slideimages.length-1)
hsis_i=0
else
hsis_i++
}
}

function hsis_move3(whichdiv){
tdiv=eval(whichdiv)
if (parseInt(tdiv.style.left)>0&&parseInt(tdiv.style.left)<=5){
tdiv.style.left=0+"px"
setTimeout("hsis_move3(tdiv)",hsis_pausebetweenimages)
setTimeout("hsis_move4(scrollerdiv2)",hsis_pausebetweenimages)
return
}
if (parseInt(tdiv.style.left)>=tdiv.offsetWidth*-1){
tdiv.style.left=parseInt(tdiv.style.left)-5+"px"
setTimeout("hsis_move3(tdiv)",50)
}
else{
tdiv.style.left=hsis_scrollerwidth
tdiv.innerHTML=hsis_slideimages[hsis_i]
if (hsis_i==hsis_slideimages.length-1)
hsis_i=0
else
hsis_i++
}
}

function hsis_move4(whichdiv){
tdiv2=eval(whichdiv)
if (parseInt(tdiv2.style.left)>0&&parseInt(tdiv2.style.left)<=5){
tdiv2.style.left=0+"px"
setTimeout("hsis_move4(tdiv2)",hsis_pausebetweenimages)
setTimeout("hsis_move3(scrollerdiv1)",hsis_pausebetweenimages)
return
}
if (parseInt(tdiv2.style.left)>=tdiv2.offsetWidth*-1){
tdiv2.style.left=parseInt(tdiv2.style.left)-5+"px"
setTimeout("hsis_move4(scrollerdiv2)",50)
}
else{
tdiv2.style.left=hsis_scrollerwidth
tdiv2.innerHTML=hsis_slideimages[hsis_i]
if (hsis_i==hsis_slideimages.length-1)
hsis_i=0
else
hsis_i++
}
}

function hsis_startscroll(){
if (ie||dom){
scrollerdiv1=ie? hsis_first2 : document.getElementById("hsis_first2")
scrollerdiv2=ie? hsis_second2 : document.getElementById("hsis_second2")
hsis_move3(scrollerdiv1)
scrollerdiv2.style.left=hsis_scrollerwidth
}
else if (document.layers){
document.hsis_main.visibility='show'
hsis_move1(document.hsis_main.document.first)
document.hsis_main.document.second.left=parseInt(hsis_scrollerwidth)+5
document.hsis_main.document.second.visibility='show'
}
}

window.onload=hsis_startscroll