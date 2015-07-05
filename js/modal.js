function show_table(){
	var t_user = document.getElementById('table_users');
	if(t_user.style.visibility == "hidden"){
		t_user.style.visibility = "visible";
	} else {
		t_user.style.visibility = "hidden";
	}
}
function edit_modall(action, user, u_id){

	var popup = document.getElementById("popup");
	var popup_bar = document.getElementById("popup_bar");
	var btn_close = document.getElementById("btn_close");
	var greyBack = document.getElementById("greyBack");
	var user_id = document.getElementById("user_id");
	user_id.value = u_id;
	if(popup_bar.childNodes[1]){
			popup_bar.removeChild(popup_bar.childNodes[1]);
		 }
		 
	if(action == 'change'){
		var user_name = document.getElementById("user_name");
		var user_login = document.getElementById("user_login");
		var user_pass = document.getElementById("user_pass");
		
		var elt = document.getElementById("select_city");
		var user_city = elt.options[elt.selectedIndex];
		
		elt = document.getElementById("user_region");
		var user_region = elt.options[elt.selectedIndex];

		elt = document.getElementById("user_dist");
		var user_dist = elt.options[elt.selectedIndex];

		user_name.value = user['name'];
		user_login.value = user['login'];
		user_pass.value = user['pass'];
		user_city.text = user['city'];
		//user_region.text = user['region'];
		//user_dist.text = user['distinctt'];
				
		var textnode = document.createTextNode("Edit record");
		popup_bar.appendChild(textnode);
	}else if(action == 'add'){
		var user_name = document.getElementById("user_name");
		var user_login = document.getElementById("user_login");
		var user_pass = document.getElementById("user_pass");
		var elt = document.getElementById("select_city");
		var user_city = elt.options[elt.selectedIndex];
		elt = document.getElementById("user_region");
		var user_region = elt.options[elt.selectedIndex];
		elt = document.getElementById("user_dist");
		var user_dist = elt.options[elt.selectedIndex];
		user_name.value = "";
		user_login.value = "";
		user_pass.value = "";
		//user_city.text = "";
		//user_region.text = "";
		//user_dist.text = "";
		
		var textnode = document.createTextNode("Add record");
		popup_bar.appendChild(textnode);
	}
	
	
	// greyBack
    spreadgreyBack(true);
    // reset div position
   	popup.style.width = "400px";
    popup.style.height = "340px";
	popup.style.display = "block";
	popup.style.position = 'fixed';
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
		popup.style.position = 'fixed';
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
function save_editing(){
	var popup_bar = document.getElementById("popup_bar");
	var hid = document.getElementById("hidden_action");
	hid.value = popup_bar.childNodes[1].nodeValue;
}

function getLocations(location_name, type){
	
	var data = {
	  "location_name" : location_name.options[location_name.selectedIndex].innerHTML
	};

	var xmlhttp;

	if (window.XMLHttpRequest){// for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {// for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function(){
		
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
		    
			var res;
			if(type == 'city'){
				res = document.getElementById("user_region");
				res.disabled = '';
			} else if (type == 'region'){
				res = document.getElementById("user_dist");
				res.disabled = '';
			}
		 
			//remove all options to avoid duplicates
			var length = res.options.length;
			for (i = 0; i < length; i++) {
				res.options[i] = null;
			}
			//create new options
			//var opt = document.createElement('option');
			//opt.value = '';
			//res.appendChild(opt);
			var obj = JSON.parse(xmlhttp.responseText);
		 
			for(var loc in obj['res']) {
				var opt = document.createElement('option');
				opt.value = obj['res'][loc];
				opt.innerHTML = obj['res'][loc];
				res.appendChild(opt);
			}
		}
	}
	jsonData = JSON.stringify(data);
	xmlhttp.open("POST","location.php");
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send('json=' + jsonData);

	/*$.ajax({
	  type: "POST",
	  url: "location.php", 
	  data: data,
	  cache:false,
	  dataType: "json",
	  success: function(responsedata) {
		  var res;
		  if(type == 'city'){
			  res = document.getElementById("user_region");
			  res.disabled = '';
		  }else if(type == 'region'){
			  res = document.getElementById("user_dist");
			  res.disabled = '';
		  }
		
			//remove all options to avoid duplicates
			var length = res.options.length;
			for (var i = 0; i < length; i++) {
			  res.options[i] = null;
			}
			//create new options
			var opt = document.createElement('option');
			opt.value = '';
			res.appendChild(opt);
			for(var loc in responsedata['res']) {
				var opt = document.createElement('option');
				opt.value = responsedata['res'][loc];
				opt.innerHTML = responsedata['res'][loc];
				res.appendChild(opt);
			}
		}, 
	  error: function(responsedata){
		  
		  alert(responsedata);
		alert('error');
	  }
	});	*/		
}