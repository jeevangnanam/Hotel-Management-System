/***************************/
//@Author: Adrian "yEnS" Mato Gondelle
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

//SETTING UP OUR POPUP
//0 means disabled; 1 means enabled;
var popupStatus = 0;

//loading popup with jQuery magic!
function loadPopup(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupContact").fadeIn("slow");
		popupStatus = 1;
	}
}

//disabling popup with jQuery magic!
function disablePopup(){
	//disables popup only if it is enabled
	if(popupStatus==1){
		$("#backgroundPopup").fadeOut("slow");
		$("#popupContact").fadeOut("slow");
		popupStatus = 0;
	}
}

//centering popup
function centerPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popupContact").height();
	var popupWidth = $("#popupContact").width();
	//centering
	$("#popupContact").css({
		"position": "absolute",
		"top": windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	//only need force for IE6
	
	$("#backgroundPopup").css({
		"height": windowHeight
	});
	
}


//CONTROLLING EVENTS IN jQuery
$(document).ready(function(){
	
		//CLOSING POPUP
	//Click the x event!
	$("#popupContactClose").click(function(){
		disablePopup();
	});
	//Click out event!
	$("#backgroundPopup").click(function(){
		disablePopup();
	});
	//Press Escape event!
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup();
		}
	});

});

function loadPopUp(rt){
	//LOADING POPUP
	//Click the button event!
	//$(".roomdests").click(function(){
		//centering with css
		centerPopup();
		$("#contactArea").html("");
		$.getJSON(
			"/manager/Index/popuproomdetails/"+rt,
			function(data){
				//alert(data.uroomdetails.roomtype);
				$.each(data.uroomdetails, function(i,user){
					var tblRow ="";
						
						tblRow+=user.roomtype+"<br />"
						tblRow+=user.price+"<br />"
						tblRow+=user.max_adults+"<br />"
						tblRow+=user.max_children+"<br />"
						tblRow+=user.additional_adult_charge+"<br />"
						tblRow+=user.additional_child_charge+"<br />"
						tblRow+=user.offers+"<br />"

					$('#contactArea').append(tblRow);
				});
			}
		);
		
		
		//load popup
		loadPopup();
//	});
				

}