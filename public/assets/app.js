new Vue({
    el: '#app',
    data: {
        log: [],
        lastId: 0
    },
    methods: {
        createJob: function () {
            $.ajax({
                url: '/hello',
                method: 'POST',
                timeout: 10000,
                dataType: 'json',
                context: this,
                success: function (data) {
                    this.log.unshift(data);
                },
                error: function () {
                    alert('AJAX failed.');
                }
            });
        },
        fetchLog: function () {
            this.log = [
                { message: 'Lorem ipsum dolor sit amet' },
                { message: 'Lorem ipsum dolor sit amet' },
                { message: 'Lorem ipsum dolor sit amet' },
                { message: 'Lorem ipsum dolor sit amet' },
                { message: 'Lorem ipsum dolor sit amet' },
                { message: 'Lorem ipsum dolor sit amet' },
            ];
        }
    },
    ready: function () {
        this.fetchLog();
    }
});
