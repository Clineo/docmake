<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<script src="http://code.jquery.com/jquery-3.1.1.js"></script>
	<link rel="stylesheet" type="text/css" href="/css/set.css">
	<link rel="stylesheet" type="text/css" href="/css/common.css">
	<link rel="stylesheet" type="text/css" href="/css/def.css">
	<style>
		#popup{	display:none; position:fixed; width:100%; height:100%; background-color:rgba(0,0,0,0.4); left:0; top:0;}

		#popup .pop_cover{width:70%; height:70%; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); background-color:salmon;}
	</style>
	<script>
		$(function(){
			$(".edit_open").click(function(){
				$("#popup").show();
			});			

			$(".edit_close").click(function(){
				$("#popup").hide();			
			});			

		});
	</script>
</head>
<body>
	<div id="wrap">
		<div class="Main">
			<div class="object">
				<div class="obj_title">
					<p class="obj_text">요소</p>
				</div>
				<div class="obj_cont">
					<div class="obj_list">
						
					</div>
					<div class="obj_plus edit_open">

					</div>
				</div>
			</div>
			<div class="verticalline"></div>
			<div class="detail">
				<div class="det_title">
					<p class="det_text">상세</p>
				</div>
				<div class="det_cont">
					
				</div>
			</div>
			<div class="verticalline"></div>
			<div class="preview">
				<div class="pre_title">
					<p class="pre_text">Preview</p>
				</div>
				<div class="pre_cont">
				</div>
				<div class="pre_page">
					<div class="pre_page_button"></div>
					<p class="now_page"></p>
					<div class="next_page_button"></div>
				</div>
			</div>
		</div>
	</div>

	<div id="popup">

		<div class="pop_cover">

			<button id="close" class="edit_close">닫기</button>
			<p>팝업내요오오오</p>
		</div>

	</div>
</body>
</html>