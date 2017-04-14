$("tr.tron").mouseover(function(){
	$(this).find("td").css("backgroundColor", "pink");
});
$("tr.tron").mouseout(function(){
	$(this).find("td").css("backgroundColor", "#FFF");
});