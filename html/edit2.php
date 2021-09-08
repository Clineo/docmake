<?php
  include 'head.php';
?>
	<script src="/js/edit.js"></script>

	<main id="index_main">
		<section id="edit_section" class="dis_f flex_c">
			<article>
				<h3>요소</h3>
				<div class="content_box">
					<ul class="element_list">
						
					</ul>
				</div>
				<button class="add_content_btn table" onclick="edit_popup_open()">테이블 추가</button>
				<button class="add_content_btn text" onclick="edit_text_content()">텍스트 추가</button>
			</article>

			<article>
				<h3>세부설정</h3>
				<div class="content_box property_box">
					<div class="table_property property_div table_type">
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
					</div>
					<div class="property_div">
						<h4>레이아웃 속성</h4>
						<dl class="table_type">
							<dt>높이</dt>
							<dd><input type="number" id="height_data"><span class="figure">px</span></dd>
						</dl>
						<dl>
							<dt>마진</dt>
							<dd>
								<dt>top</dt>
								<dd><input type="text" id="td_mr_top_data"><span class="figure">px</span></dd>
								<dt>right</dt>
								<dd><input type="text" id="td_mr_right_data"><span class="figure">px</span></dd>
								<dt>bottom</dt>
								<dd><input type="text" id="td_mr_bottom_data"><span class="figure">px</span></dd>
								<dt>left</dt>
								<dd><input type="text" id="td_mr_left_data"><span class="figure">px</span></dd>
							</dd>
						</dl>
					</div>
					<div class="sell_property property_div">
						<h4>텍스트 속성</h4>
						<dl class="table_type">
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
						<dl>
							<dt>텍스트 색</dt>
							<dd><input type="color" id="td_text-color_data"></dd>
						</dl>
					</div>
					<div class="box_property property_div">
						<h4>패딩</h4>
						<dl>
							<dt>top</dt>
							<dd><input type="number" id="td_pd_top_data"><span class="figure">px</span></dd>
							<dt>right</dt>
							<dd><input type="number" id="td_pd_right_data"><span class="figure">px</span></dd>
							<dt>bottom</dt>
							<dd><input type="number" id="td_pd_bottom_data"><span class="figure">px</span></dd>
							<dt>left</dt>
							<dd><input type="number" id="td_pd_left_data"><span class="figure">px</span></dd>
						</dl>
						<dl>
							<dt>배경색</dt>
							<dd><input type="color" id="td_background-color_data"></dd>
						</dl>
					</div>
				</div>
			</article>
			
			<article class="preview_box t_l" id="preview_box">
				<h3>미리보기</h3>
				<div class="content_box edit_mode">
					<div id="preview_content_box">
						<? 
							if ($_GET['categorie']){
								include 'categorie/categorie1_1.php';
							}
						?>
					</div>
				</div>
				<button id="cell_merge" class="edit_but" onclick="edit_cell_merge();">셀 병합</button>
				<button id="cell_sharing" class="edit_but" onclick="edit_cell_sharing();">셀 분해</button>
				<button id="savePdf_popup" class="edit_but" onclick="pdf_mode_popup_open();">pdf 저장</button>
			</article>
		</section>
	</main>

	<div id="edit_popup" class="edit_popup">
		<div class="content_box">
			<h4>표 만들기</h4>
			<dl>
				<dt>줄 개수</dt>
				<dd><input type="number" id="edit_table_col_data" class="table_edit_input" onKeypress="javascript:if(event.keyCode==13) {edit_popup_go()}"></dd>
			</dl>
			<dl>
				<dt>칸 개수</dt>
				<dd><input type="number" id="edit_table_row_data" class="table_edit_input" onKeypress="javascript:if(event.keyCode==13) {edit_popup_go()}"></dd>
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