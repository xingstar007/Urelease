/**
 * 
 */
function del_version(id,url)
{
	confirm_ = confirm('This action will delete current order! Are you sure?');
	if(confirm_){
	$.ajax({
			type:"POST",
			url: "http://127.0.0.1/MyExercise/URelease/release/version_delete/",
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
}

function enter_version(id,name)
{
	 window.location.href = "./release/version/"+id+"/"+name;
}