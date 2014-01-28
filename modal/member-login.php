<div class="modal-wrapper">
<h2>ログイン</h2>
<form name="loginForm" action="login-page.php" method="post">
<p><input type="text" id="username_name" name="username" placeholder="NAME"></p>
<p><input type="password" name="password" placeholder="PASSWORD"></p>
<p><input type="submit" name="login" id="login-button" value="LOG IN"></p>
</form>
<p id="input-error">入力が正しくありません。</p>
<p id="feedback"></p>
<script>
$(function(){
	$("#login-button").click(function(){
		var username = document.forms["loginForm"]["username"].value;
		var password = document.forms["loginForm"]["password"].value;
		if(username == null || username == "" || password == null || password == ""){
			$("#input-error").css("display", "block");
			return false;
		}
	});

});

</script>
</div><!-- register-wrapper end -->