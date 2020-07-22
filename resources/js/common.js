export default {
    methods: {
        axios(method, url, data) {
            try {
                return axios({
                    method: method,
                    url: url,
                    data: data
                });
            } catch (e) {
                return e.response;
            }
        },
        s(message) {
            this.$notify({
                title: 'Success!',
                message: message,
                type: 'success'
            });
        },
        e(message) {
            this.$notify({
                title: 'Oops!',
                message: message,
                type: 'error'
            });
        },
        swr() {
            this.$notify({
                title: 'Oops!',
                message: 'Something went wrong, please try again later.',
                type: 'error'
            });
        },
    },
}
