function edit_modall(){
	
	var popup = document.getElementById("popup");
	var popup_bar = document.getElementById("popup_bar");
	var btn_close = document.getElementById("btn_close");
	var greyBack = document.getElementById("greyBack");
	
	// greyBack
    spreadgreyBack(true);
    // reset div position
   	popup.style.width = "500px";
    popup.style.height = "300px";
	popup.style.display = "block";
	popup.style.position = 'absolute';
	popup.style.left= "40%";
	popup.style.top= "30%";
	
	var SCROLL_WIDTH = 24;
  
	  //-- let the popup make draggable & movable.
	  var offset = { x: 0, y: 0 };
	 
	  popup_bar.addEventListener('mousedown', mouseDown, false);
	  window.addEventListener('mouseup', mouseUp, false);
	 
	  function mouseUp()
	  {
		window.removeEventListener('mousemove', popupMove, true);
	  }
	 
	  function mouseDown(e){
		offset.x = e.clientX - popup.offsetLeft;
		offset.y = e.clientY - popup.offsetTop;
		window.addEventListener('mousemove', popupMove, true);
	  }
	 
	  function popupMove(e){
		popup.style.position = 'absolute';
		var top = e.clientY - offset.y;
		var left = e.clientX - offset.x;
		popup.style.top = top + 'px';
		popup.style.left = left + 'px';
	  }
	  //-- / let the popup make draggable & movable.
	 
	  window.onkeydown = function(e){
		if(e.keyCode == 27){ // if ESC key pressed
		  btn_close.click(e);
		}
	  }
	 	 
	  btn_close.onclick = function(e){
		popup.style.display = "none";
		greyBack.style.display = "none";
	  }
	 
	  window.onresize = function(e){
		spreadgreyBack();
	  }
  
	}
	
function spreadgreyBack(flg){
	var greyBack = document.getElementById("greyBack");
    greyBack.style.width = document.body.clientWidth + 100 + "px";
    greyBack.style.height = document.body.clientHeight + 100 + "px";
    if (flg != undefined && flg == true) greyBack.style.display = "block";
  }