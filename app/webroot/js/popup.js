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
function loadPopup(str){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupContact").fadeIn("slow");
		popupStatus = 1;
		$("#cap").html(str);
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
//popup for managers
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
				$.each(data.uroomdetails, function(i,user){
					var tblRow ="";
						
						tblRow+="<div class=\"detailLables\">Room Type : </div><div class=\"detailFields\">"+user.roomtype+"</div>"
						tblRow+="<div class=\"detailLables\">Price : </div><div class=\"detailFields\">"+user.price+"</div>"
						tblRow+="<div class=\"detailLables\">Size : </div><div class=\"detailFields\">"+user.size+"</div>"
						tblRow+="<div class=\"detailLables\">Info : </div><div class=\"detailFields\">"+user.info+"</div>"
						tblRow+="<div class=\"detailLables\">View : </div><div class=\"detailFields\">"+user.view+"</div>"
						tblRow+="<div class=\"detailLables\">Cooling : </div><div class=\"detailFields\">"+user.cooling+"</div>"
						tblRow+="<div class=\"detailLables\">Offers : </div><div class=\"detailFields\">"+user.offers+"</div>"

					$('#contactArea').append(tblRow);
				});
			}
		);

		//load popup
		loadPopup('Room Details');
//	});
				

}

//pop up for all
function loadPopUpnormal(h,rt){
	//LOADING POPUP
	//Click the button event!
	//$(".roomdests").click(function(){
		//centering with css
		centerPopup();
		
		$("#contactArea").html("");
		
		$.getJSON(
			"/nodes/popuproomdetails/"+h+"/"+rt,
			function(data){
				$.each(data.uroomdetails, function(i,user){
					var tblRow ="";
						
						tblRow+="<div class=\"detailLables\">Room Type : </div><div class=\"detailFields\">"+user.roomtype+"</div>"
						tblRow+="<div class=\"detailLables\">Price : </div><div class=\"detailFields\">"+user.price+"</div>"
						tblRow+="<div class=\"detailLables\">Size : </div><div class=\"detailFields\">"+user.size+"</div>"
						tblRow+="<div class=\"detailLables\">Info : </div><div class=\"detailFields\">"+user.info+"</div>"
						tblRow+="<div class=\"detailLables\">View : </div><div class=\"detailFields\">"+user.view+"</div>"
						tblRow+="<div class=\"detailLables\">Cooling : </div><div class=\"detailFields\">"+user.cooling+"</div>"
						tblRow+="<div class=\"detailLables\">Offers : </div><div class=\"detailFields\">"+user.offers+"</div>"

					$('#contactArea').append(tblRow);
				});
			}
		);		
		//load popup
		
		loadPopup("Room Details");
		//$('#capdet').html("Room Details");
}

//pop up for all
function loadRoomAvailability(h){
	//LOADING POPUP
	//Click the button event!
	//$(".roomdests").click(function(){
		//centering with css
		centerPopup();
		$("#contactArea").html("");
		//load popup
		loadPopup("Rooms Availability");
		//$('#capavl').html("Room Availability");
}