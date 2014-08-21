function action(){
$('#submit').click(function(){
	
  var login    = $('#login').val();
  var password = $('#password').val();
  
  $.ajax({
    type: 'POST',
    url: '/simens_derniereversion/public/admin/login/connexionservice' ,
    data: {'login':login, 'password':password},
    success: function(data) {    
    	     var result = jQuery.parseJSON(data);  

      	    if(result){
          	     if(result == 1){
                    alert("vous n etes dans aucun service");
              	 }else{
    	               vart='/simens_derniereversion/public/consultation/consultation/recherche/service/'+result;
                       $(location).attr("href",vart);
              	 }
      	     }else{
          	     alert("Login ou mot de pass incorrect");
          	     }
    },
    error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
    dataType: "html"
  });
});
}