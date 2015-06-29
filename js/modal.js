function edit_modall(action, user){
	var popup = document.getElementById("popup");
	var popup_bar = document.getElementById("popup_bar");
	var btn_close = document.getElementById("btn_close");
	var greyBack = document.getElementById("greyBack");
	if(popup_bar.childNodes[1]){
			popup_bar.removeChild(popup_bar.childNodes[1]);
		 }
		 
	if(action == 'change'){
		var user_name = document.getElementById("user_name");
		var user_login = document.getElementById("user_login");
		var user_pass = document.getElementById("user_pass");
		var user_city = document.getElementById("user_city");
		var user_region = document.getElementById("user_region");
		var user_dist = document.getElementById("user_dist");
		user_name.value = user['name'];
		user_login.value = user['login'];
		user_pass.value = user['pass'];
		user_city.value = user['city'];
		user_region.value = user['region'];
		user_dist.value = user['distinctt'];
		
		var textnode = document.createTextNode("Edit record");
		popup_bar.appendChild(textnode);
	}else if(action == 'add'){
		var textnode = document.createTextNode("Add record");
		popup_bar.appendChild(textnode);
	}
	
	
	// greyBack
    spreadgreyBack(true);
    // reset div position
   	popup.style.width = "500px";
    popup.style.height = "350px";
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
  
 function cancel_editing(){
	var popup = document.getElementById("popup");
	var greyBack = document.getElementById("greyBack");
	popup.style.display = "none";
	greyBack.style.display = "none"; 
}

 $("document").ready(function(){
	  $(".submit_save").submit(function(){
		var popup_bar = document.getElementById("popup_bar");
		var data = {
		  "action": popup_bar.childNodes[1].nodeValue
		};
		data = $(this).serialize() + "&" + $.param(data);
		alert(data);
		$.ajax({
		  type: "POST",
		  url: "test.php", 
		  data: data,
		  cache:false,
		  dataType: "json",
		  success: function(data) {
		  alert("success");
			}, 
		  error: function(data){
			alert('error');
		  }
		});
		return false;
	  });
	});
 