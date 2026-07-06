$(function(){
// IPad/IPhone
 var viewportmeta = document.querySelector && document.querySelector('meta[name="viewport"]'),
 ua = navigator.userAgent,

 gestureStart = function () {viewportmeta.content = "width=device-width, minimum-scale=0.25, maximum-scale=1.6";},

 scaleFix = function () {
  if (viewportmeta && /iPhone|iPad/.test(ua) && !/Opera Mini/.test(ua)) {
   viewportmeta.content = "width=device-width, minimum-scale=1.0, maximum-scale=1.0";
   document.addEventListener("gesturestart", gestureStart, false);
  }
 };

 /* scaleFix() no longer called: it clamped maximum-scale on iOS to
    work around an orientation-change zoom bug fixed in iOS 6+. */
 // Menu Android
 if(window.orientation!=undefined){
  var regM = /ipod|ipad|iphone/gi,
   result = ua.match(regM)
  if(!result) {
   $('.sf-menu li').each(function(){
    if($(">ul", this)[0]){
     $(">a", this).toggle(
      function(){
       return false;
      },
      function(){
       window.location.href = $(this).attr("href");
      }
     );
    } 
   })
  }
 }
});
/* Legacy duplicate-viewport injection removed: the layout's own
   <meta name="viewport"> is authoritative, and user-scalable=0
   breaks pinch-zoom accessibility on Android. */