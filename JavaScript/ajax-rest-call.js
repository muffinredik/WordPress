$('#general-get-site-infos').live('click', function(e){
		e.preventDefault();

		$.ajax({
			url: "https://xxxxxxxxx.yy",
			dataType: 'json',
			cache: false,
			success: function(data) {
				alert(data);
			},
			error: function(xhr, status, err) {
				alert(err);
			}
		});
	});
