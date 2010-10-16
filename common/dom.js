// Cross Browser DOM
// copyright Stephen Chapman, 4th Jan 2005
// you may copy this code but please keep the copyright notice as well
var aDOM = 0, ieDOM = 0, nsDOM = 0; var stdDOM = document.getElementById;
if (stdDOM) aDOM = 1; else {ieDOM = document.all; if (ieDOM) aDOM = 1; else {
var nsDOM = ((navigator.appName.indexOf('Netscape') != -1)
&& (parseInt(navigator.appVersion) ==4)); if (nsDOM) aDOM = 1;}}

function xDOM(objectId, wS) {
if (stdDOM) return wS ? document.getElementById(objectId).style:
document.getElementById(objectId);
if (ieDOM) return wS ? document.all[objectId].style: document.all[objectId];
if (nsDOM) return document.layers[objectId];
}                  

// Object Functions
// copyright Stephen Chapman, 4th Jan 2005
//  you may copy these functions but please keep the copyright notice as well
function objWidth(objectID) {var obj = xDOM(objectID,0); if(obj.offsetWidth) return  obj.offsetWidth; if (obj.clip) return obj.clip.width; return 0;}        

function objHeight(objectID) {var obj = xDOM(objectID,0); if(obj.offsetHeight) return  obj.offsetHeight; if (obj.clip) return obj.clip.height; return 0;}    

function objLeft(objectID) {var obj = xDOM(objectID,0);var objs = xDOM(objectID,1); if(objs.left) return objs.left; if (objs.pixelLeft) return objs.pixelLeft; if (obj.offsetLeft) return obj.offsetLeft; return 0;} 

function objTop(objectID) {var obj = xDOM(objectID,0);var objs = xDOM(objectID,1); if(objs.top) return objs.top; if (objs.pixelTop) return objs.pixelTop; if (obj.offsetTop) return obj.offsetTop; return 0;} 

function objRight(objectID) {return objLeft(objectID)+objWidth(objectID);} 

function objBottom(objectID) {return objTop(objectID)+objHeight(objectID);} 

function objLayer(objectID) {var objs = xDOM(objectID,1); if(objs.zIndex) return objs.zIndex; return 0;} 

function objVisible(objectID) {var objs = xDOM(objectID,1); if(objs.visibility == 'hide' || objs.visibility == 'hidden') return 'hidden'; return 'visible';}



// Browser Window Size and Position
// copyright Stephen Chapman, 3rd Jan 2005, 8th Dec 2005
// you may copy these functions but please keep the copyright notice as well
function pageWidth() {return window.innerWidth != null? window.innerWidth : document.documentElement && document.documentElement.clientWidth ?       document.documentElement.clientWidth : document.body != null ? document.body.clientWidth : null;} 

function pageHeight() {return  window.innerHeight != null? window.innerHeight : document.documentElement && document.documentElement.clientHeight ?  document.documentElement.clientHeight : document.body != null? document.body.clientHeight : null;} 

function posLeft() {return typeof window.pageXOffset != 'undefined' ? window.pageXOffset :document.documentElement && document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ? document.body.scrollLeft : 0;} 

function posTop() {return typeof window.pageYOffset != 'undefined' ?  window.pageYOffset : document.documentElement && document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ? document.body.scrollTop : 0;} 

function posRight() {return posLeft()+pageWidth();} 

function posBottom() {return posTop()+pageHeight();}
               
			   
			   
// More Object Functions
// copyright Stephen Chapman, 18th Jan 2005
// you may copy these functions but please keep the copyright notice as well
function setObjVis(objectID,vis) {var objs = xDOM(objectID,1); objs.visibility = vis;} 

function toggleObjVis(objectID) {var objs = xDOM(objectID,1); var vis = objs.visibility;  objs.visibility = (vis == "visible" || vis == "show") ? 'hidden' : 'visible';} 

function moveObjTo(objectID,x,y) {var objs = xDOM(objectID,1); objs.left = x; objs.top = y;}

function moveObjBy(objectID,x,y) {var obj = xDOM(objectID,0);var objs = xDOM(objectID,1); if (obj.offsetLeft != null) {var l = obj.offsetLeft; var t = obj.offsetTop; objs.left = l+x; objs.top = t+y;} else if (objs.pixelLeft != null) {objs.pixelLeft += x; objs.pixelTop += y;} else obj.moveBy(x,y);}

function moveObjLayer(objectID,z) {var objs = xDOM(objectID,1); objs.zIndex = z;}
