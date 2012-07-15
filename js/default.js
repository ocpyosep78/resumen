// JavaScript Document

function confirme(){

	if (!confirm("Realmente desea eliminar el registro?")) {
	
		return false;
		
	}	
	
}

function checkTodos(id,pID){
	
	$("#"+ pID+" :checkbox").attr('checked',$('#'+ id).is(':checked'));

}
