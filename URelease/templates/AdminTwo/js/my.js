/**
 * 
 */
function enter_version(id)
{
//	alert(id);
	$.ajax({
		type:"POST",
		url: "release/version/",
		dataType:"html",
		data:{"project_id":id},
		success:function(data){
			$("#page-wrapper").html(data);
			return false;
		},
		error:function(XMLHttpRequest){
			alert('error');
			alert(XMLHttpRequest.readyState);
			alert(XMLHttpRequest.status);
			return false;
		}
	});	
}