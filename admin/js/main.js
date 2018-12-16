function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
    
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
    
            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
};
var paginationNumber = getUrlParameter('pagination');
var p = getUrlParameter('p');
if(p == undefined || p == ''){
        p = 'questions';
}
if(p == 'questions'){
        if(paginationNumber == undefined || paginationNumber < 1){
                paginationNumber = 1;
                location = '?p=questions&pagination=1';
        }
}
new Vue({
        el:'#container',
        data:function () {
                return {
                        tab: p,
                }
        }
});
$('.v-sidebar-element-wrapper').mouseover(function () { 
        $('.v-sidebar-element-list-wrapper').hide();
        $(this).find('.v-sidebar-element-list-wrapper').show();
});
$('.v-sidebar-element-wrapper').mouseout(function () { 
        $('.v-sidebar-element-list-wrapper').hide();
});

// new Vue({
//         el:'#v-content-questions'
// });