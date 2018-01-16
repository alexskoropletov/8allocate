var App = {
    init: function () {
        if (authenticated) {

            App.customer.list();

            $('#datetimepicker1').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss'
            });
            App.events();

            // App.transaction.add(1);
            // App.transaction.add(2);
            // App.transaction.add(3);
            // App.transaction.delete(47);
            // App.transaction.update(50);
            // App.transaction.get(1, 50);
            App.transaction.list();
        }
    },

    events: function() {
        $('#filter').on('submit', function(e) {
            e.preventDefault();
            $.each($(this).serializeArray(), function(_, field) {
                App.transaction.filter[field.name] = field.value ? field.value : false;
            });
            App.transaction.filter.offset = 0;
            App.transaction.list();
        });

        $('#per_page').on('change', function() {
            App.transaction.filter.offset = 0;
            App.transaction.filter.limit = $(this).val();
            App.transaction.list();
        });
    },

    customer: {
        path: '/api/customer',
        add: function (name) {
            App.sendAjax(
                this.path,
                'put',
                {
                    public: public,
                    token: token,
                    name: name,
                    cnp: 'some kind of "client not present" data'
                },
                App.success
            );
        },
        list: function () {
            App.sendAjax(
                this.path,
                'get',
                {
                    public: public,
                    token: token
                },
                function(data) {
                    var options = [
                        '<option value="">[*] All</option>'
                    ];
                    data.result.forEach(function (item) {
                        options.push(
                            '<option value="' + item.id + '">[' + item.id + '] ' + item.name + '</option>'
                        );
                    });
                    $('#customers').html(options.join(''));
                }
            );
        }
    },

    transaction: {
        path: '/api/transaction',
        filter: {
            customerId: false,
            amount: false,
            date: false,
            offset: 0,
            limit: 5
        },
        add: function (customerId) {
            App.sendAjax(
                this.path,
                'put',
                {
                    public: public,
                    token: token,
                    customerId: customerId,
                    amount: 100000 * Math.random() * Math.random()
                },
                App.success
            );
        },
        update: function (transactionId) {
            App.sendAjax(
                this.path,
                'post',
                {
                    public: public,
                    token: token,
                    transactionId: transactionId,
                    amount: 100000 * Math.random() * Math.random()
                },
                App.success
            );
        },
        get: function (customerId, transactionId) {
            App.sendAjax(
                this.path + '/' + customerId + '/' + transactionId,
                'get',
                {
                    public: public,
                    token: token
                },
                App.success
            );
        },
        list: function () {
            App.sendAjax(
                App.transaction.getUrl(),
                'get',
                {
                    public: public,
                    token: token
                },
                App.transaction.showList
            );
        },
        showList: function(data) {
            var list = [];
            if (data.result.length) {
                data.result.forEach(function(item) {
                    list.push(
                        '<tr>'
                            + '<th>' + item.id + '</th>'
                            + '<td>' + item.customerId + '</td>'
                            + '<td>' + item.amount + '</td>'
                            + '<td>' + item.date + '</td>'
                        + '</tr>'
                    );
                });
            }
            $('#list tbody').html(list.join(''));

            var pagination = [];
            if (data.last_page) {
                for(var index = 1; index <= data.last_page; index++) {
                    pagination.push(
                        '<li'
                        + (data.current_page == index ? ' class="active"' : '')
                        + '><a href="#" data-offset="'
                        + ((index - 1) * App.transaction.filter.limit)
                        + '">'
                        + index
                        + '</a></li>'
                    );
                }
            }
            $('#pagination ul').html(pagination.join(''));
            $('.pagination a').on('click', function() {
                App.transaction.filter.offset = $(this).data('offset');
                App.transaction.list();
            });
        },
        delete: function (transactionId) {
            App.sendAjax(
                this.path + '/' + transactionId,
                'delete',
                {
                    public: public,
                    token: token
                },
                App.success
            );
        },
        getUrl: function() {
            return this.path + '/' + Object.values(App.transaction.filter).join('/');
        }
    },

    success: function (response) {
        console.log(response);
    },

    sendAjax: function (url, method, data, success) {
        return $.ajax({
            url: url,
            type: method,
            data: data,
            dataType: 'json',
            error: function (status, error) {
                alert('Whoops! An error occurred. And we are fixing it! Please, try again later.');
            },
            success: success
        });
    }
};

$(function () {
    App.init();
});