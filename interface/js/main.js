$(function() {
	
	var serverURL = "http://localhost/cashflow/";
	var serviceURL = "?content=service&";
	var apiKey = "s4p1";
	var apiURL = "apiKey="+apiKey;
	var postURL = serverURL+serviceURL+apiURL+"&mode=";

	function showMessage(title,content){
		$('#myModal').modal('show');
		$('.modal-title').text(title);
		$('.modal-body').text(content);
	}	

	$( "form" ).on( "submit", function( event ) {
		event.preventDefault();
		var url = postURL + $( this ).attr('action');
		var data = $(this).serialize();
		var method = $(this).attr('method');
		var onComplete = function(res){
							if(res == 'ok'){
								msg = 'Data tersimpan';
							}else{
								msg = 'Data gagal tersimpan ('+res+')';
							}
							showMessage('Info',msg);
							$("form").trigger("reset");
							$('.select').selectpicker('render');
						}

		if(method == 'post'){				
			$.post(
				url, 
				data,
				onComplete
			);
		}else{
			$.get(
				url, 
				data,
				onComplete
			);
		}	

	});


	$.ajax({
	    url: postURL+'listcat&type=-', 
	    type:'GET',
	    datatype:'json',
	    success:function(data) { 
	        data = $.parseJSON(data)
	        var options;
	        for (var i = 0; i < data['length']; i++) {
	            $("#outcategory").append($('<option>').val(data[i]['idcat']).text(data[i]['category']));
	        }
	        $('#outcategory').selectpicker('refresh');
	    }
	});

	$.ajax({
	    url: postURL+'listcat&type='+encodeURIComponent('+'), 
	    type:'GET',
	    datatype:'json',
	    success:function(data) { 
	        data = $.parseJSON(data)
	        var options;
	        for (var i = 0; i < data['length']; i++) {
	            $("#incategory").append($('<option>').val(data[i]['idcat']).text(data[i]['category']));
	        }
	        $('#incategory').selectpicker('refresh');
	    }
	});

	$.ajax({
	    url: postURL+'listcat&type=sv', 
	    type:'GET',
	    datatype:'json',
	    success:function(data) { 
	        data = $.parseJSON(data)
	        var options;
	        for (var i = 0; i < data['length']; i++) {
	            $("#svcategory").append($('<option>').val(data[i]['idcat']).text(data[i]['category']));
	        }
	        $('#svcategory').selectpicker('refresh');
	    }
	});

	$.ajax({
	    url: postURL+'listcat&type=u', 
	    type:'GET',
	    datatype:'json',
	    success:function(data) { 
	        data = $.parseJSON(data)
	        var options;
	        for (var i = 0; i < data['length']; i++) {
	            $("#ucategory").append($('<option>').val(data[i]['idcat']).text(data[i]['category']));
	        }
	        $('#ucategory').selectpicker('refresh');
	    }
	});

	$.ajax({
	    url: postURL+'listcat&type=p', 
	    type:'GET',
	    datatype:'json',
	    success:function(data) { 
	        data = $.parseJSON(data)
	        var options;
	        for (var i = 0; i < data['length']; i++) {
	            $("#pcategory").append($('<option>').val(data[i]['idcat']).text(data[i]['category']));
	        }
	        $('#pcategory').selectpicker('refresh');
	    }
	});

	$.ajax({
	    url: postURL+'listcat', 
	    type:'GET',
	    datatype:'json',
	    success:function(data) { 
	        data = $.parseJSON(data)
	        var tagGroup;
	        var prevType = '';
	        for (var i = 0; i < data['length']; i++) {
	        	if(prevType != data[i]['type']){
	        		tagGroup = $('<optgroup label="'+data[i]['type']+'">');
	        	}
	        	tagGroup.append($('<option>').val(data[i]['idcat']).text(data[i]['category']));
	        	$("#lcategory").append(tagGroup);
	        	prevType = data[i]['type'];
	            //$("#lcategory").append($('<option>').val(data[i]['idcat']).text(data[i]['category']));
	        }
	        $('#lcategory').selectpicker('refresh');
	    }
	});

	$.ajax({
	    url: postURL+'listlsp', 
	    type:'GET',
	    datatype:'json',
	    success:function(data) { 
	        data = $.parseJSON(data)
	        var options;
	        for (var i = 0; i < data['length']; i++) {
	            $("#lsp").append($('<option>').val(data[i]['idlsp']).text(data[i]['bank']+" - "+data[i]['norekening']));
	        }
	        $('#lsp').selectpicker('refresh');
	    }
	});
	
	
});

