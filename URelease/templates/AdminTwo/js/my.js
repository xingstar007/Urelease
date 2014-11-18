/**
 * 
 */
function del_version(id)
{
	$.ajax({
			type:"POST",
			url:"release/version_delete/",
			dataType:"json",
			data:{"del_version_id":id},
			success:function(data){
				alert('Success');
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

function enter_version(id,name)
{
	 window.location.href = "./release/version/"+id+"/"+name;
}