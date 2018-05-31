
<link rel="stylesheet" href="HCeditor/HCeditor.css">
<div id='editor_wrapper' >
        <div class='editor_buttons_block' >
            <div id='editor_buttons_wrapper'>
                <div class='editor_button' id='bold' title='Жирный' >
                    <img class='editor_button_img' src="HCeditor/HCeditorimg/bold.svg" alt="Жирный">
                </div>
                <div class='editor_button' id='italic' title='Курсивный'  >
                    <img class='editor_button_img' src="HCeditor/HCeditorimg/italic.svg" alt="Курсивный">
                </div>
                <div class='editor_button' id='link' title='Ссылка' >
                    <img class='editor_button_img' src="HCeditor/HCeditorimg/link.svg" alt="Ссылка">
                </div>
                <div class='editor_button' id='superscript' title='Степень' >
                    <img class='editor_button_img' src="HCeditor/HCeditorimg/superscript.svg" alt="Степень">
                </div>
                <div class='editor_button' id='subscript' title='Индекс' >
                    <img class='editor_button_img' src="HCeditor/HCeditorimg/subscript.svg" alt="Индекс">
                </div>
                <div class='editor_button' id='image' title='Изображение' >
                    <div id='image_after' >
                        <img class='editor_button_img' src="HCeditor/HCeditorimg/picture.svg" alt="Изображение">
                    </div>
                    <div id='image_button_list' >
                        <label for="file"><p id='image_local' >С компьютера </p></label>
                        <p id='image_internet' >Из интернета</p>
                    </div>
                </div>
                <div class='editor_button' id='list' title='Список' >
                    <div id='list_after' >
                    <img class='editor_button_img' src="HCeditor/HCeditorimg/list.svg" alt="Список">
                    </div>
                    <div id='ol_button_list' >
                        <p id ='ol'>Нумерованный</p>
                        <p id='ul'>Маркированный</p>
                    </div>
                </div>
            </div>
        </div>
            <textarea name='HCeditor' class="editor_textarea"><?=$content?></textarea>
            <p id='HCeditor_error'></p>
            <textarea name="HCeditorContent" class="HCeditorcopy"></textarea>
            <input type="file" id="file">
    </div>
    <?php
    require 'HCeditor/HCeditorjs.php';
    ?>