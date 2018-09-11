function menuAssignment(){
	var lList = $("#lList");
	var llList = document.getElementById("lList");
	var rList = $("#rList");
	var items = $(".data-list li");
	for(var i = 0;i<items.length;i++){
		items[i].onclick = itemsclick;
		items[i].ondblclick = itemsdblclick;
	}
	function itemsdblclick(){
		if (this.parentNode === llList) {
			rList.append(this);
		}else{
			lList.append(this);
		}
	}
	function itemsclick(){
		var classname = this.className;
		if(classname === "selected"){
			this.className = "";
		}else{
			this.className="selected";
		}
	}
	function itemsMove(){
		var items = $(".data-list li.selected");
		for(var i = 0;i<items.length;i++){
			if(this.id === "add"){
				rList.append(items[i]);
			}else{
				lList.append(items[i]);
			}
		}
	}
	$("#add").on("click",itemsMove);
	$("#remove").on("click",itemsMove);
}