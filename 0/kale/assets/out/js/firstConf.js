$(document).ready(function(){
	$('select[name=dbConf]').change(function(){
		if($('select[name=dbConf] option:selected').val()==2){
			$('#conf-db').fadeIn();
		}else{
			$('#conf-db').fadeOut();
		}
	});
	$('select[name=mailConf]').change(function(){
		if($('select[name=mailConf] option:selected').val()==2){
			$('#conf-mail').fadeIn();
		}else{
			$('#conf-mail').fadeOut();
		}
	});
	$('select[name=extConf]').change(function(){
		if($('select[name=extConf] option:selected').val()==2){
			$('#conf-ext').fadeIn();
		}else{
			$('#conf-ext').fadeOut();
		}
	});
	//$('#addList').click(function(){
	//	var currentID = $('#dbList').attr('data-id');
	//	var currentID = parseInt(currentID)+1;
	//	$('#dbList').attr('data-id', currentID);
	//	$('#dbList').append('<div class="dbList dbList'+currentID+'"><h5>Base de données n°'+currentID+'</h5><div class="form-group"><input type="text" name="dbUrl[]" required="required"><label class="control-label" for="input">Adresse du serveur</label><i class="bar"></i></div><div class="form-group"><input type="text" name="dbUser[]" required="required"><label class="control-label" for="input">Nom d\'utilisateur</label><i class="bar"></i></div><div class="form-group"><input type="text" name="dbPassword[]" required="required"><label class="control-label" for="input">Mot de passe</label><i class="bar"></i></div></div>');
	//});
});