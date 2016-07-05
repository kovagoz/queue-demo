// Convert log level to Bootstrap label suffix.
Vue.filter('label', function (value) {
    switch (value) {
        case 'error':
            return 'danger';

        case 'warning':
            return 'warning';

        case 'notice':
            return 'success';

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
        createJob: function (e) {
            var $button = $(e.target);
            $button.button('loading');

            $.ajax({
                url: '/message',
                method: 'POST',
                timeout: 2000,
                complete: function () {
                    $button.button('reset');
                },
                error: function () {
                    alert('Ooops. Something went wrong.');
                }
            });
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
                    this.log = data.concat(this.log);
                },
                error: function () {
                    console.log('Failed to refresh the log');
                },
                complete: function () {
                    var vue = this;

                    setTimeout(function () {
                        vue.fetchLog();
                    }, 1000);
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
