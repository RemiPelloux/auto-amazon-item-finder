$('#update_button').click(function(){
	$("#update_window").html("Working, please wait...");

	$.ajax({
		url:"ajax/import.php", 
		success:function(result){
			$("#update_window").html(result);
		}
	});
});

$('#save_button').click(function(){
	$btn = $(this);
	raw = $("#item_list").val().split(', ');
	
    $btn.button('loading');
	
	$.ajax({  
		type: "POST",
		url: "ajax/save.php",
		data: {
			l : JSON.stringify(raw)
		},
		success:function(result){
			$btn.button('reset');
		}
	});
});

$('#save_setting').click(function(){
	$btn = $(this);
	k = $("#setting").val();
	v = $("#new_value").val();
	
    $btn.button('loading');
	
	$.ajax({  
		type: "POST",
		url: "ajax/save_setting.php",
		data: {
			key : k,
			value : v
		},
		success:function(result){
			$btn.button('reset');
		}
	});
});

$('#setting').change(function(){
	k = $("#setting").val();
	
	$.ajax({  
		type: "POST",
		url: "ajax/get_setting.php",
		data: {
			key : k
		},
		success:function(result){
			$('#new_value').val(result);
		}
	});
});