

Vue.component('runners', {
    template: '#runners-template',

    props: ['runners'],

    data: function () {
        return {
            sortKey: '',
            reverse: '',
            filter: ''
        }
    },
    methods: {

        sortBy: function (sortKey) {

            this.reverse = (this.sortKey == sortKey) ? !this.reverse : '-1';

            this.sortKey = sortKey;

        }
    },

    created: function () {
        this.runners = JSON.parse(this.runners);
    }
});

new Vue({
    el: '#runners'
});
