function bodies(){
	
	  $('a.tdata').click(function(){
	 	var megaDate = document.getElementById('dateOutput').value;
	  	$.ajax({
			url : '/bodies/json/'+megaDate,
			success : function( response ) {
				//var data = document.getElementById('statsadd');
				//data.innerHTML = response;
				var res = JSON.parse ( response );
				if (res[0] == 0){
					$.ajax({
						url: '/bodies/add/'+megaDate,
						success : function( response ){
							var data = document.getElementById('statsadd');
							data.innerHTML = response;
						},
						error : function ( ) {
							alert ( 'Error' );
						}
					});
					
				}else{
					$.ajax({
						url: '/bodies/edit/'+res[1]+'/'+megaDate,
						success : function( response ){
							var data = document.getElementById('statsadd');
							data.innerHTML = response;
						},
						error : function () {
							alert( 'Error' );	
						}
					});
				}
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	  
	  });
}