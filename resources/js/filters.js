import Vue from 'vue';

Vue.filter('toReadableDate', (value) => {
    var date = new Date(value);

    return date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();
});

Vue.filter('removeSeconds', (value) => {
    var arrayStr = value.split(':');

    return arrayStr[0] + ':' + arrayStr[1]; 
})
