Vue.component('v-header',{
        template: `
        <div class='v-header'>
                <div class='v-header-content'>
                        <div class="v-header-logo-burger">
                                <img height='40px' class='v-header-logo' src="../images/Logo2.0white.svg">
                        </div>
                        <div class="v-header-user-info">
                                <div @click="changer('messages')" class='v-header-user-icon'>
                                        <i class="fas fa-envelope"></i>
                                        <span class='badge'>112</span>
                                </div>
                                <div class='v-header-user-icon'>
                                <i class="fas fa-bell"></i>
                                <span class='badge'>112</span>
                                </div>
                                <span>`+userName+` `+userSurname+`</span>
                                <div class='v-header-user-image-wrapper'>
                                <img src='../usersfiles/`+userLogin+`/profil.jpg'/>
                                </div>
                        </div>
                </div>
        </div>      
        `,
        methods:{
                changer(tab){
                        window.history.pushState("", "", '?p='+tab+'&pagination=1');
                        this.$emit('changer',tab);
                }
        }
});
Vue.component('v-sidebar',{
        template: `
        <div class="v-sidebar">
        <div class="v-sidebar-element-wrapper">
                <i class="fas fa-browser"></i>
                <div class="v-sidebar-element-list-wrapper">
                        <a href='../' class="v-sidebar-element-header">
                                <i class="fas fa-browser"></i>
                                <p>Переход к сайту</p>
                        </a>
                        <div class='v-sidebar-element-list'>
                                <div @click="changer('dashboard')">Dashboard</div>
                        </div>
                </div>
        </div>
        <div class="v-sidebar-element-wrapper">
                <i class="fas fa-list"></i>
                <div class="v-sidebar-element-list-wrapper">
                        <div @click="changer('questions')" class="v-sidebar-element-header">
                                <i class="fas fa-list"></i>
                                <p>Вопросы</p>
                        </div>
                </div>
        </div>
        <div class="v-sidebar-element-wrapper">
                <i class="far fa-pencil-alt"></i>
                <div class="v-sidebar-element-list-wrapper">
                        <div @click="changer('blog')" class="v-sidebar-element-header">
                                <i class="far fa-pencil-alt"></i>
                                <p>Блог</p>
                        </div>
                        <div @click="changer('addBlog')" class='v-sidebar-element-list'>
                                <div href='#'>Новая статья</div>
                        </div>
                </div>
        </div>
        <div class="v-sidebar-element-wrapper">
                <i class="fas fa-user"></i>
                <div class="v-sidebar-element-list-wrapper">
                        <div @click="changer('users')" class="v-sidebar-element-header">
                                <i class="fas fa-user" style="width: 23px;"></i>
                                <p>Пользователи</p>
                        </div>
                </div>
        </div>
        <div class="v-sidebar-element-wrapper">
                <i class="fas fa-tags" style="width: 45px;"></i>
                <div class="v-sidebar-element-list-wrapper">
                        <div @click="changer('tags')" class="v-sidebar-element-header">
                                <i class="fas fa-tags" ></i>
                                <p>Теги</p>
                        </div>
                        <div class='v-sidebar-element-list'>
                                <div @click="changer('addTag')">Новый тег</div>
                        </div>
                </div>
        </div>
        <div class="v-sidebar-element-wrapper">
                <i class="fas fa-book"></i>
                <div @click="changer('gdz')" class="v-sidebar-element-list-wrapper">
                        <div class="v-sidebar-element-header">
                                <i class="fas fa-book"></i>
                                <p>ГДЗ</p>
                        </div>
                        <div class='v-sidebar-element-list'>
                                <div @click="changer('addGdz')">Новый тег</div>
                        </div>
                </div>
        </div>
</div>`,
methods:{
                changer(tab){
                        window.history.pushState("", "", '?p='+tab+'&pagination=1');
                        this.$emit('changer',tab);
                }
        }
});
Vue.component('v-content-question',{
        props:{
                questions: Object,
        },
        template: `
                <div>
                <div class='table-elem-wrapper' v-for='question in questions'>
                        <div class="table-block table-block-id">{{question.id}}</div>
                        <div class="table-block table-block-qt">{{question.title}}</div>
                        <a href='#' class="table-block">@{{question.user}}</a>                                        
                        <div class="table-block">{{question.date}} {{question.time}} </div>
                        <div class="table-block">
                                <a :href="'../index.php?page=question&question='+question.id" class="table-action table-action-view">
                                        <i class="fas fa-eye"></i>
                                </a>
                                <a :href="'../index.php?page=edit_question&question='+question.id" class="table-action table-action-edit">
                                        <i class="fas fa-pen"></i>
                                </a>
                                <a :href="'../index.php?page=remove_question&question='+question.id" class="table-action table-action-remove">
                                        <i class="fas fa-trash-alt"></i>
                                </a>
                        </div>
                </div>
                </div>
        `
});
Vue.component('v-content-questions',{
        data: function () {
                return{
                        pageNum: parseInt(paginationNumber),
                        questions: null,
                }
        },
        template: `
        <div id='v-content-questions' class='widget' >
                <div class='widget-header'>
                        <p><i class="fas fa-bars"></i></p>
                        <p>Вопросы</p>
                </div>
                <div class='widget-content'>
                        <div class='v-content-questions-table admin-table'>
                                <div class='admin-table-header'>
                                        <div class="table-block table-block-id">id</div>
                                        <div class="table-block table-block-qt">Question title</div>                                        
                                        <div class="table-block">Username</div>                                        
                                        <div class="table-block">Date</div>
                                        <div class="table-block">Actions</div>
                                </div>
                                <v-content-question :questions='questions'></v-content-question>
                        </div>
                        <v-pagination p='questions' :lastPage="${lastPage}" :pageNum='pageNum' ></v-pagination>
                </div>
        </div>
        `,
        created() {
                var questions;
                $.ajax({
                        type: "post",
                        url: "ajaxGetContent.php",
                        data: {table: 'questions',limit: 40,page: parseInt(paginationNumber),order: 'BY date DESC,time DESC'},
                        dataType: "json",
                        success: function (response) {
                                questions = response;
                        }
                });
                setTimeout(() => {
                        this.questions = questions;
                }, 100);
        },
});
Vue.component('v-content-blog',{
        props:{
                blogs: Object,
        },
        template: `
                <div>
                <div class='table-elem-wrapper' v-for='blog in blogs'>
                        <div class="table-block table-block-id">{{blog.id}}</div>
                        <div class="table-block table-block-qt">{{blog.title}}</div>
                        <div class="table-block">{{blog.date}} {{blog.time}} </div>
                        <div class="table-block table-block-id">{{blog.views}}</div>                                        
                        <div class="table-block table-block-id">{{blog.likes}}</div>                                        
                        <div class="table-block table-block-id">{{blog.comments}}</div>                                        
                        <div class="table-block">
                                <a :href="'../index.php?page=blog&blog='+blog.id" class="table-action table-action-view">
                                        <i class="fas fa-eye"></i>
                                </a>
                                <a :href="'?p=edit_blog&blog='+blog.id" class="table-action table-action-edit">
                                        <i class="fas fa-pen"></i>
                                </a>
                                <a :href="'?p=remove_blog&blog='+blog.id" class="table-action table-action-remove">
                                        <i class="fas fa-trash-alt"></i>
                                </a>
                        </div>
                </div>
                </div>
        `
});
Vue.component('v-pagination',{
        props:{
                p: String,
                pageNum: Number,
                lastPage: Number
        },
        data:function () {
                return {
                        nextPage: parseInt(this.pageNum) + 1,
                        previewPage: parseInt(this.pageNum) - 1,
                }
        },
        template: `
        <div class='pagination-wrapper'>
                <a v-if="previewPage > 0" :href="'?p='+p+'&pagination='+ previewPage" class='preview-page-button button'>
                        << предыдущий 
                </a>
                <a v-if="nextPage <= lastPage" :href="'?p='+p+'&pagination='+ nextPage" class='next-page-button button'>
                        следющий >>
                </a>
        </div>
        `
});
Vue.component('v-add-blog', {
        template: `
        <div>
        <div class='widget'>
        <div class='widget-header'>
                        <p><i class="fal fa-pencil"></i></p>
                        <p>Добавить Запись</p>
                </div>
                <div class='widget-content'>
                        <form method='post'  enctype='multipart/form-data'>
                        <label>
                                Заголовок: <br/>
                                <input required class='input article-title' type='text' name='article-title'>
                        </label>
                        <br/>
                        <label>
                                Изображение: <br/>
                                <input required class='input' type='file' name='article-img'>
                        </label>
                        <br/>
                        <label>
                                <input required class='input' type='radio' value='ru' name='article-lang'>
                                - Русский
                        </label>
                        <br/>
                        <label>
                                <input required class='input' type='radio' value='az' name='article-lang'>
                                - Азербайджанский
                        </label>
                        <hc-editor i='0' form_name='article-content'></hc-editor>
                        <input required type='submit' name='add-article-submit' class='button form-button' value='Отправить'>
                        </form>
                </div>
        </div>
        
        </div>
        `
});

Vue.component('v-blogs',{
        data: function () {
                return{
                        pageNum: parseInt(paginationNumber),
                        blogs: null,
                }
        },
        template: `
        <div id='v-content-blogs' class='widget' >
                <div class='widget-header'>
                        <p><i class="fas fa-bars"></i></p>
                        <p>Блог</p>
                </div>
                <div class='widget-content'>
                        <div class='v-content-questions-table admin-table'>
                                <div class='admin-table-header'>
                                        <div class="table-block table-block-id">id</div>
                                        <div class="table-block table-block-qt">Title</div>                                        
                                        <div class="table-block">Date</div>                                        
                                        <div class="table-block  table-block-id"><i class="fas fa-eye"></i></div>
                                        <div class="table-block table-block-id"><i class="fas fa-heart"></i></div>
                                        <div class="table-block table-block-id"><i class="fas fa-comment"></i></div>
                                        <div class="table-block">Actions</div>
                                </div>
                                <v-content-blog :blogs='blogs'></v-content-blog>
                        </div>
                        <v-pagination p='tags' :lastPage="${lastPage}" :pageNum='pageNum' ></v-pagination>
                </div>
        </div>
        `,
        created() {
                var blogs;
                $.ajax({
                        type: "post",
                        url: "ajaxGetContent.php",
                        data: {table: 'blog',limit: 40,page: parseInt(paginationNumber),order: "BY date DESC,time DESC"},
                        dataType: "json",
                        success: function (response) {
                                blogs = response;
                        }
                });
                setTimeout(() => {
                        this.blogs = blogs;
                }, 100);
        },
});

Vue.component('v-add-tag', {
        data: function(){
                return {
                        editTag: Object,
                }
        },
        template: `
        <div>
        <div class='widget'>
        <div class='widget-header'>
                        <p><i class="fas fa-plus"></i></p>
                        <p>Добавить Тег</p>
                </div>
                <div class='widget-content'>
                        <form method='post'  enctype='multipart/form-data'>
                        <label>
                                Назание тега Русский: <br/>
                                <input :value='editTag.name_ru' required class='input article-title' type='text' name='tag-name-ru'>
                        </label>
                        <br/>
                        <label>
                                Назание тега Азербайджанский: <br/>
                                <input :value='editTag.name_az' required class='input article-title' type='text' name='tag-name-az'>
                        </label>
                        <br/>
                        <label>
                                Изображение: <br/>
                                <input required class='input' type='file' name='article-img'>
                        </label>
                        <br/>
                        <input required type='submit' name='add-tag-submit' class='button form-button' value='Отправить'>
                        </form>
                </div>
        </div>
        
        </div>
        `,
        created() {
                var tag;
                $.ajax({
                        type: "post",
                        url: "ajaxLoad.php",
                        data: {table: 'tags',loadid: getUrlParameter('edit_tag')},
                        dataType: "json",
                        success: function (response) {
                                tag = response;
                        }
                });
                setTimeout(() => {
                        this.editTag = tag;
                }, 100);
        },
});

Vue.component('v-users',{
        template: `
        <div id='v-content-users' class='widget' >
                <div class='widget-header'>
                        <p><i class="fas fa-bars"></i></p>
                        <p>Пользователи</p>
                </div>
                <div class='widget-content'>
                        <p>Пользователи...</p>
                </div>
        </div>
        `
});

Vue.component('v-content-tag',{
        props:{
                tags: Object,
        },
        template: `
                <div>
                <div class='table-elem-wrapper' v-for='tag in tags'>
                        <div class="table-block table-block-id">{{tag.id}}</div>
                        <div class="table-block">{{tag.name_ru}}</div>
                        <div class="table-block">{{tag.name_az}}</div>                                        
                        <div class="table-block">{{tag.questions}}</div>
                        <div class="table-block">{{tag.subscribes}}</div>
                        <div class="table-block">
                                <img width='40px' :src="'../tagimages/'+tag.id+'.png'" />
                        </div>
                        <div class="table-block">
                                <a :href="'../index.php?page=tags&tag='+tag.id" class="table-action table-action-view">
                                        <i class="fas fa-eye"></i>
                                </a>
                                <a :href="'?p=addTag&pagination=1&edit_tag='+tag.id" class="table-action table-action-edit">
                                        <i class="fas fa-pen"></i>
                                </a>
                                <a style='cursor:pointer' @click="removeTag(tag.id)"  class="table-action table-action-remove">
                                        <i class="fas fa-trash-alt"></i>
                                </a>
                        </div>
                </div>
                </div>
        `,
        methods: {
                removeTag(tagId){
                        var isRemove = confirm('Remove tag?');
                        if(isRemove){
                                location = '?p=removeTag&removeTag='+tagId;
                        }
                }
        }
});

Vue.component('v-tags',{
        data: function () {
                return{
                        pageNum: parseInt(paginationNumber),
                        tags: null,
                }
        },
        template: `
        <div id='v-content-blogs' class='widget' >
                <div class='widget-header'>
                        <p><i class="fas fa-bars"></i></p>
                        <p>Теги</p>
                </div>
                <div class='widget-content'>
                        <div class='v-content-questions-table admin-table'>
                                <div class='admin-table-header'>
                                        <div class="table-block table-block-id">id</div>
                                        <div class="table-block">Tagname RU</div>                                        
                                        <div class="table-block">Tagname AZ</div>                                        
                                        <div class="table-block">Questions</div>
                                        <div class="table-block">Subscribes</div>
                                        <div class="table-block">Icon</div>
                                        <div class="table-block">Actions</div>
                                </div>
                                <v-content-tag :tags='tags'></v-content-tag>
                        </div>
                        <v-pagination p='tags' :lastPage="${lastPage}" :pageNum='pageNum' ></v-pagination>
                </div>
        </div>
        `,
        created() {
                var tags;
                $.ajax({
                        type: "post",
                        url: "ajaxGetContent.php",
                        data: {table: 'tags',limit: 40,page: parseInt(paginationNumber)},
                        dataType: "json",
                        success: function (response) {
                                tags = response;
                        }
                });
                setTimeout(() => {
                        this.tags = tags;
                }, 100);
        },
});

init_hceditor({
        id: '',
        load_img: true,
        load_to: '/'
});