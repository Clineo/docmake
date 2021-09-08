<?php
  include 'head.php';
?>
	<style>
		#edit_section {justify-content: space-between; font-size:0.8em;}
		#edit_section article{position:relative; width:calc(20% - 10px);}
		#edit_section article.preview_box{width:calc(60% - 10px);}
		#edit_section article h3 {height:50px; line-height:50px; text-align:center;}
		#edit_section article .content_box {height:calc(100vh - 281px); border:1px solid #bbb; padding:20px; 
		background-color:#fff; overflow-y:auto; overflow-x: hidden;}
		#edit_section article#preview_box .content_box {padding:0;}
		#edit_section article#preview_box .content_box.pdf_mode {position: fixed; width: 1200px; left: calc(50% - 600px); top: 50px; height: calc(100vh - 150px); z-index: 10;}

		#preview_content_box {padding:20px;}

		.edit_popup {position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; }
		.edit_popup .content_box {padding:20px; background-color:#fff; width: 300px;}
		
		#edit_popup h4 {margin-bottom:20px;}
		#edit_popup dl {display:flex; font-size:0.8em; margin-bottom:10px;}
		#edit_popup dl dt {line-height:44px;}
		#edit_popup ul li {width:calc(100% / 2);}
		#edit_popup button {width: 100%; padding: 10px; font-size: 0.8em;}
		#edit_popup button:hover {background-color:#666; color:#fff;}
		#edit_popup input {padding: 10px; width: 120px; margin-left: 10px;}

		.add_content_btn {position:absolute; bottom:20px; left:20px; width:calc(100% - 40px); background-color:#eee; padding:10px;}
		.add_content_btn:hover {background-color:#000; color:#fff;}
		
		.element_list {width:100%; text-align:left;}
		.element_list li {line-height:22px; margin-bottom:15px;}
		.element_list li.list_select {color:red;}
		.element_list li button{float:right; display:inline-block; width:22px; line-height:22px; text-align:center; background:url('/images/cancel.png') no-repeat center; background-size:100%; color:#fff; border:0; padding:0; font-size:0;}

		.preview_box .edit_mode td.select_target {background-color:#E7F0FD; border:2px solid #1A73E8;}
		.preview_box .edit_mode td.select_area {background-color:#E7F0FD;}

		.preview_box {-ms-user-select: none; -moz-user-select: -moz-none; -webkit-user-select: none; -khtml-user-select: none; user-select:none;}

		.table_property {padding-bottom:10px; border-bottom:1px solid #ddd; margin-bottom:10px;}
		.property_box h4 {margin-bottom:15px;}
		.property_box dt {font-weight:400; margin-bottom:5px;}
		.property_box dd {position:relative; margin-bottom:10px;}
		.property_box input{width: 100%; padding: 5px; font-size: 0.85em;}
		.property_box .figure {position: absolute; right: 10px; top: 4px; font-size: 0.9em;color: #999;}

		.align_data_list {border:1px solid #ddd; border-right:0;}
		.align_data_list li {width:calc(100% / 3); border-right:1px solid #ddd;}
		.align_data_list label {display:block; width:100%; line-height:35px; margin-bottom:0;}
		.align_data_list label:before{display:none !important;}
		.align_data_list input:checked + label {color:#fff; background-color:#666;}
		
		.property_div {display:none;}		

		#savePdf_popup {position: absolute; right: 0px; bottom: -49px; padding: 10px 20px; border: 1px solid #666; background-color: #fff;}
		
		.pdf_control {display: flex; position: absolute; left: calc(50% - 600px); bottom: 40px; min-width: 1200px; align-items: center; justify-content: flex-end;}
		.pdf_control button{padding:10px 20px; margin-left:5px;}
	</style>
	<script>
		var col_length = 0;
		var mouse_state = 'up';

		$(function(){
			/* 세부설정 변경 이벤트 */
			$('#col_data_box').on("change", "input", function() {
				$('.type_table.select colgroup col:nth-child('+$(this).attr('data')+')').attr('width', $(this).val() + '%');
			})
			$('.align_data_list').on("change", "input", function() {
				$('.select_target').css('text-align', $(this).val());
			})
			$('.property_box').on("change", "#height_data", function() {
				$('.select_target').parent('tr').css('height', $(this).val()+'px');
			})
			$('.property_box').on("change", "#text_data", function() {
				$('.select_target').html($(this).val());
			})
			$('.property_box').on("change", "#font-size_data", function() {
				$('.select_target').css('font-size', $(this).val()+'px');
			})

			$('.preview_box').on("mouseenter", "td", function() {
				if (mouse_state == 'down')
				{
					edit_td_select_event(this, 'hover');
				}
			});
			$('.preview_box').on("mousedown", "td", function() {
				if ($(this).hasClass('select_target'))
				{
					/*
						$(this).removeClass('select_target');
						$('.type_table').removeClass('select');
						$('.property_div').css('display','none');
						$('.element_list li').removeClass('list_select');
						$('.preview_box td').removeClass('select_area');
					*/
				}else{
					$('.preview_box td').removeClass('select_target');
					$('.preview_box td').removeClass('select_area');
					edit_td_select_event(this, 'down');
				}
			});
			
			/* 팝업 검은 여백 클릭 */
			$(document).click(function(e){			
			  if ($(e.target).attr('id') == 'edit_popup')
			  {
				edit_popup_close();
			  }
			  if ($(e.target).attr('id') == 'pdf_mode_popup')
			  {
				pdf_mode_popup_close();
			  }
			 
		   });

		   $(document).mousedown(function(){
				mouse_state = 'down';
		   });

		   $(document).mouseup(function(){
				mouse_state = "up";
		   })

		   $('#savePdf').click(function() { // pdf저장 button id
				
				html2canvas($('#preview_content_box')[0]).then(function(canvas) { //저장 영역 div id
				
				// 캔버스를 이미지로 변환
				var imgData = canvas.toDataURL('image/png');
					 
				var imgWidth = 190; // 이미지 가로 길이(mm) / A4 기준 210mm
				var pageHeight = imgWidth * 1.414;  // 출력 페이지 세로 길이 계산 A4 기준
				var imgHeight = canvas.height * imgWidth / canvas.width;
				var heightLeft = imgHeight;
				var margin = 10; // 출력 페이지 여백설정
				var doc = new jsPDF('p', 'mm');
				var position = 0;
				   
				// 첫 페이지 출력
				doc.addImage(imgData, 'PNG', margin, position, imgWidth, imgHeight);
				heightLeft -= pageHeight;
					 
				// 한 페이지 이상일 경우 루프 돌면서 출력
				while (heightLeft >= 20) {
					position = heightLeft - imgHeight;
					doc.addPage();
					doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
					heightLeft -= pageHeight;
				}
			 
				// 파일 저장
				doc.save('file-name.pdf');
					
				});
			});	
		})

		/* 요소 추가 팝업 open */
		function edit_popup_open(){
			$('#edit_popup').css('display','flex');
			$('#edit_table_col_data').val('');
			$('#edit_table_row_data').val('');
		}
		
		/* 요소 추가 팝업 close*/
		function edit_popup_close(){
			$('#edit_popup').hide();
		}
		
		/* 인쇄 모드 open */
		function pdf_mode_popup_open(){
			$('#pdf_mode_popup').show();
			$('#preview_box .content_box').removeClass('edit_mode');
			$('#preview_box .content_box').addClass('pdf_mode');
		}
		
		/* 인쇄 모드 close */
		function pdf_mode_popup_close(){
			$('#pdf_mode_popup').hide();
			$('#preview_box .content_box').removeClass('pdf_mode');
			$('#preview_box .content_box').addClass('edit_mode');
		}
		
		/* 요소 추가 팝업 변수 */
		var element_list = 0;

		var edit_table_col_data = 0;
		var edit_table_col_width_data = 0;
		var edit_table_row_data = 0;
		var edit_table_html_data = '';
		
		/* 테이블 추가 */
		function edit_popup_go(){
			edit_popup_close();

			edit_table_col_data = $('#edit_table_col_data').val();
			edit_table_row_data = $('#edit_table_row_data').val();
			edit_table_col_width_data = 100/edit_table_col_data;
			element_list = ($('.element_list li').length + 1);
			
			edit_table_html_data = '';
			edit_table_html_data += '<div class="box'+element_list+' box_div" data="'+element_list+'">';
			edit_table_html_data += '<table class="type_table">';
			edit_table_html_data += '<colgroup>';
			for (var i = 0; i < edit_table_col_data; i++)
			{
				edit_table_html_data += '<col width="'+Math.floor(edit_table_col_width_data)+'%"></col>';
			}
			edit_table_html_data += '</colgroup>';

			for (var i = 0; i < edit_table_row_data; i++)
			{
				edit_table_html_data += '<tr data="'+i+'">';
				for (var e = 0; e < edit_table_col_data; e++)
				{
					edit_table_html_data += '<td data="'+i+'"></td>';
				}
				edit_table_html_data += '</tr>';
			}			
			edit_table_html_data += '</table><br /></div>';

			$('#preview_content_box').append(edit_table_html_data);
			$('.element_list').append('<li data="list'+element_list+'">테이블'+element_list+' <button onclick="element_list_remove('+element_list+')">close</button></li>');
		}
		
		/* 테이블 삭제 */
		function element_list_remove(list_number){
			element_list = $('.element_list li').length;

			$('.element_list li[data=list'+list_number+']').remove();
			$('#preview_box .box'+list_number+'').remove();
			
			$('#preview_box .content_box div.box_div').attr('class','box_div');
			for (var i = 1; i < (element_list + 1) ; i++)
			{
				$('.element_list li:nth-child('+i+')').attr('data', 'list'+i);
				$('.element_list li:nth-child('+i+')').html('테이블'+i+' <button onclick="element_list_remove('+i+')">close</button>');
				
				$('#preview_box .content_box div.box_div:nth-child('+i+')').addClass('box'+i);
				$('#preview_box .content_box div.box_div:nth-child('+i+')').attr('data', i);
			}

			$('.preview_box').removeClass('select_target');
			$('.type_table').removeClass('select');
			if ($('.select_target').hasClass('select_target') == false)
			{
				$('.property_div').css('display','none')
			}
		}
		
		/* td 마우스 오버 이벤트 */
		function edit_td_select_event(target_data, click_type){
			col_length = $(target_data).closest('table.type_table').children('colgroup').children('col').length;

			if (click_type == 'down')
			{
				$(target_data).addClass('select_target');
			}
			if (click_type == 'hover')
			{
				$(target_data).addClass('select_area');					
			}

			$('.type_table').removeClass('select');	
			$(target_data).closest('table.type_table').addClass('select');	

			$('.element_list li').removeClass('list_select');
			$('.element_list li:nth-child('+$(target_data).closest('.box_div').attr('data')+')').addClass('list_select');
			


			$('.property_div').css('display','block');

			$('#height_data').val(Number($(target_data).parent('tr').css('height').replace(/px/,"")));
			$('#font-size_data').val(Number($(target_data).css('font-size').replace(/px/,"")));
			$('#text_data').val($(target_data).html());
			$('.align_data_list input[value="'+$(target_data).css('text-align')+'"]').prop('checked', true);
			
			$('#col_data_box').html('');
			for (var i = 1; i < (col_length + 1); i++)
			{
				var col_weight_data = Number($(target_data).closest('table.type_table').children('colgroup').children('col:nth-child('+i+')').attr('width').replace(/%/,""));
				$('#col_data_box').append('<dt>행'+i+' 넓이</dt>');
				$('#col_data_box').append('<dd><input type="number" id="co'+i+'_data" data="'+i+'" value="'+col_weight_data+'"><span class="figure">%</span></dd>');
			}
		}
	</script>

	<main id="index_main">
		<section id="edit_section" class="dis_f flex_c">
			<article>
				<h3>요소</h3>
				<div class="content_box">
					<ul class="element_list">
						<li data="list1">테이블1 <button onclick="element_list_remove(1)">close</button></li>
					</ul>
				</div>
				<button class="add_content_btn" onclick="edit_popup_open()">+ 요소 추가</button>
			</article>

			<article>
				<h3>세부설정</h3>
				<div class="content_box property_box">
					<div class="table_property property_div">
						<h4>테이블 속성</h4>
						<dl id="col_data_box">
							<dt>행1 넓이</dt>
							<dd><input type="number" id="co1_data" data="1"><span class="figure">%</span></dd>
							<dt>행2 넓이</dt>
							<dd><input type="number" id="co2_data" data="2"><span class="figure">%</span></dd>
							<dt>행3 넓이</dt>
							<dd><input type="number" id="co3_data" data="3"><span class="figure">%</span></dd>
							<dt>행4 넓이</dt>
							<dd><input type="number" id="co4_data" data="4"><span class="figure">%</span></dd>
						</dl>

						<dl>
							<dt>열 높이</dt>
							<dd><input type="number" id="height_data"><span class="figure">px</span></dd>
						</dl>
					</div>
					<div class="sell_property property_div">
						<h4>텍스트 속성</h4>
						<dl>
							<dt>텍스트</dt>
							<dd><input type="text" id="text_data"></dd>
						</dl>
						<dl>
							<dt>텍스트 사이즈</dt>
							<dd><input type="number" id="font-size_data"><span class="figure">px</span></dd>
						</dl>
						<dl>
							<dt>텍스트 정렬</dt>
							<dd>
								<ul class="align_data_list dis_f t_c">
									<li><input type="radio" name="font-align_data" value="left" id="font-align_data_left"><label for="font-align_data_left">왼쪽</label></li>
									<li><input type="radio" name="font-align_data" value="center" id="font-align_data_center"><label for="font-align_data_center">중간</label></li>
									<li><input type="radio" name="font-align_data" value="right" id="font-align_data_right"><label for="font-align_data_right">오른쪽</label></li>
								</ul>
							</dd>
						</dl>
					</div>
				</div>
			</article>

			<article class="preview_box t_l" id="preview_box">
				<h3>미리보기</h3>
				<div class="content_box edit_mode">
					<div id="preview_content_box">
						<div class="box1 box_div" data="1">
							<table class="type_table" data="test">
								<colgroup>
									<col width="25%"></col>
									<col width="25%"></col>
									<col width="25%"></col>
									<col width="25%"></col>
								</colgroup>
								<tr>
									<td colspan="4" style="text-align:center;">디자인기획서</td>
								</tr>
								<tr>
									<td style="text-align:center;">별명</td>
									<td></td>
									<td style="text-align:center;">요청일</td>
									<td></td>
								</tr>
								<tr>
									<td style="text-align:center;">설명</td>
									<td></td>
									<td style="text-align:center;">마감일</td>
									<td></td>
								</tr>
								<tr>
									<td style="text-align:center;">브랜드 컨셉</td>
									<td colspan="3"></td>
								</tr>
								<tr>
									<td style="text-align:center;">주 소비층</td>
									<td colspan="3"></td>
								</tr>
								<tr>
									<td style="text-align:center;">기획 의도</td>
									<td colspan="3"></td>
								</tr>
								<tr>
									<td style="text-align:center;">기획 내용</td>
									<td colspan="3"></td>
								</tr>
							</table>
							<!--<p class="child">test</p>-->
							<br />
						</div>
					</div>
				</div>
				<button id="savePdf_popup" onclick="pdf_mode_popup_open();">pdf 저장</button>
			</article>
		</section>
	</main>

	<div id="edit_popup" class="edit_popup">
		<div class="content_box">
			<h4>표 만들기</h4>
			<dl>
				<dt>줄 개수</dt>
				<dd><input type="number" id="edit_table_col_data"></dd>
			</dl>
			<dl>
				<dt>칸 개수</dt>
				<dd><input type="number" id="edit_table_row_data"></dd>
			</dl>
			<ul class="dis_f">
				<li><button onclick="edit_popup_go();">확인</button></li>
				<li><button onclick="edit_popup_close();">취소</button></li>
			</ul>
		</div>
	</div>

	<div id="pdf_mode_popup" class="edit_popup">
		<ul class="pdf_control">
			<li><button id="savePdf">저장</button></li>
			<li><button onclick="pdf_mode_popup_close()">닫기</button></li>
		</ul>
	</div>

<?php
  include 'tail.php';
?>