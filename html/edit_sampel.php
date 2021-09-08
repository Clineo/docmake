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
			

		#savePdf_popup {position: absolute; right: 0px; bottom: -49px; padding: 10px 20px; border: 1px solid #666; background-color: #fff;}
		
		.pdf_control {display: flex; position: absolute; left: calc(50% - 600px); bottom: 40px; min-width: 1200px; align-items: center; justify-content: flex-end;}
		.pdf_control button{padding:10px 20px; margin-left:5px;}
	</style>

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