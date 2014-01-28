<div class="modal-wrapper">
<h2>新規登録</h2>
<form name="registerForm" action="login-page.php" method="post">
<p><input type="text" id="username_input" name="username" placeholder="NAME"></p>
<p><input type="password" name="password" placeholder="PASSWORD"></p>
<p><input type="password" name="repeatpassword" placeholder="REPEAT PASS"></p>
<p><input type="submit" name="register" id="register-button" value="REGISTER"></p>
</form>
<p id="input-error">入力が正しくありません。</p>
<p id="length-error">6文字以上の英数字を入力してください。</p>
<p id="feedback">In here</p>
<script>
$(function(){
	$("#feedback").load('check.php');
	$("#username_input").keyup(function(){
		$.post('check.php', { username: registerForm.username.value},
		function(result){
			$("#feedback").html(result).show();
		});
	});
});

$("#register-button").click(function(){
	var username = document.forms["registerForm"]["username"].value;
	var password = document.forms["registerForm"]["password"].value;
	var repeatpassword = document.forms["registerForm"]["repeatpassword"].value;
	if(username == null || username == "" || password == null || password == "" || password != repeatpassword){
		$("#input-error").css("display", "block");
		return false;
	}
	if(password.length < 6){
		$("#length-error").css("display", "block");
		return false;
	}
});
</script>
</div><!-- modal-wrapper end -->