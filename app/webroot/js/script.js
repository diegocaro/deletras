function toggleSearch(field,msg)
{
  if (field.value == msg )
  {
    field.style.color = 'black'; 
    field.value = ''; 
    return true; 
  }
  else if (field.value == '')
  {
    field.style.color = '#bbbbbb'; 
    field.value = msg;
    return true; 
  }
}


//Execute a function triggered by a event
function addEvent(obj, evType, fn){ 
 if (obj.addEventListener){ 
   obj.addEventListener(evType, fn, true); 
   return true; 
 } else if (obj.attachEvent){ 
   var r = obj.attachEvent("on"+evType, fn); 
   return r; 
 } else { 
   return false; 
 } 
}
//Example:
//addEvent(window, 'load', onstart);
