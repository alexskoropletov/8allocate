var App = {
    init: function () {
        if (authenticated) {
            // App.transaction.add(1);
            // App.transaction.add(2);
            // App.transaction.add(3);
            // App.transaction.delete(47);
            // App.transaction.update(50);
            // App.transaction.get(1, 50);
            App.transaction.list();
        }
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
        }
    },

    transaction: {
        path: '/api/transaction',
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
                this.path,
                'get',
                {
                    public: public,
                    token: token
                },
                App.success
            );
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