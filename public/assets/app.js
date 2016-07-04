// Convert log level to Bootstrap label suffix.
Vue.filter('label', function (value) {
    switch (value) {
        case 'error':
            return 'danger';

        case 'warning':
            return 'warning';

        default:
            return 'default';
    }
});

var vm = new Vue({
    el: '#app',
    data: {
        log: [],
        lastId: 0
    },
    methods: {
        createJob: function () {
        },
        fetchLog: function () {
            $.ajax({
                url: '/log',
                method: 'GET',
                data: {
                    since: this.lastId
                },
                timeout: 2000,
                dataType: 'json',
                context: this,
                success: function (data) {
                    var vue = this;

                    vue.log = data.concat(this.log);

                    setTimeout(function () {
                        vue.fetchLog();
                    }, 1000);
                },
                error: function () {
                    alert('AJAX failed.');
                }
            });
        }
    },
    ready: function () {
        this.fetchLog();
    }
});

// Store the ID of the latest log entry.
vm.$watch('log', function (log) {
    if (log.length > 0) {
        this.lastId = log[0].id;
    }
});
