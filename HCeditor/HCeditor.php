<div id='editor_wrapper'>
        <div class='editor_buttons_block' >
            <div id='editor_buttons_wrapper'>
                <div class='editor_button bold' title='Жирный' >
                    <img class='editor_button_img' src="HCeditor/HCeditorimg/bold.svg" alt="Жирный" />
                </div>
                <div class='editor_button italic' title='Курсивный'  >
                    <img class='editor_button_img' src="HCeditor/HCeditorimg/italic.svg" alt="Курсивный" />
                </div>
                <div class='editor_button link' title='Ссылка' >
                    <img class='editor_button_img' src="HCeditor/HCeditorimg/link.svg" alt="Ссылка" />
                </div>
                <div class='editor_button superscript' title='Степень' >
                    <img class='editor_button_img' src="HCeditor/HCeditorimg/superscript.svg" alt="Степень" />
                </div>
                <div class='editor_button subscript' title='Индекс' >
                    <img class='editor_button_img' src="HCeditor/HCeditorimg/subscript.svg" alt="Индекс" />
                </div>
                <!--***********-->
                <div class='editor_button image' title='Изображение' >
                    <div id='image_after' >
                        <img class='editor_button_img' src="HCeditor/HCeditorimg/picture.svg" alt="Изображение" />
                    </div>
                    <div class='image_button_list' >
                        <label for="uploadFile"><p class='image_local' >С компьютера </p></label>
                        <p class='image_internet' >Из интернета</p>
                    </div>
                </div>
                <!--***********-->
                <div class='editor_button list' title='Список' >
                    <div class='list_after' >
                        <img class='editor_button_img' src="HCeditor/HCeditorimg/list.svg" alt="Список" />
                    </div>
                    <div class='ol_button_list' >
                        <p class ='ol'>Нумерованный</p>
                        <p class='ul'>Маркированный</p>
                    </div>
                </div>
            </div>
        </div>
            <textarea name='HCeditor' class="editor_textarea"><?=$content?></textarea>
            <p id='HCeditor_error'></p>
            <textarea name="HCeditorContent" class="HCeditorcopy"></textarea>
            <input type="file"  class='file' id="uploadFile" />
 </div>