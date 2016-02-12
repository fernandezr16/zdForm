// jQuery Form validation incase html5 validation not supported

$(document).ready(function(){

		$("#zForm .input-js").hover(function() {
			$(this).addClass("active");
		}, function() {
			$(this).removeClass("active");
		});
		$("#zForm input").focus(function() {
			$(this).parent().addClass("active");
		});
		$("#zForm input").blur(function() {
			$("#zForm .input-js").removeClass("active");
		});

		$("#zForm .select-js").hover(function() {
			$(this).addClass("active");
		}, function() {
			$(this).removeClass("active");
		});
		$("#zForm select").focus(function() {
			$(this).parent().addClass("active");
		});
		$("#zForm select").blur(function() {
			$("#zForm .select-js").removeClass("active");
		});

		$("#zForm .message-js").hover(function() {
			$(this).addClass("active");
		}, function() {
			$(this).removeClass("active");
		});

		$("#zForm textarea").focus(function() {
			$(this).parent().addClass("active");
		});
		$("#zForm textarea").blur(function() {
			$("#zForm .message-js").removeClass("active");
		});

		$("#zForm").validate();
	});
