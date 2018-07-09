let Search;

$(function () {
    Search = new Vue({
        el: '#search',
        data: {
            keyword: '',
        },
        methods: {
            postQuery: function () {
                if (this.keyword === '') return;

                let search = this;

                axios.post('/search/', {
                    content: search.keyword,
                })
                    .then(res => {
                        Search_result.results = res.data;
                        Search_result.openSearchResult();
                    })
                    .catch(err => {

                    });
            },
            search: function (keyword) {
                if (keyword === '') return;

                axios.post('/search/', {
                    content: keyword,
                })
                    .then(res => {
                        Search_result.results = res.data;
                        Search_result.openSearchResult();
                    })
                    .catch(err => {

                    });
            },
        },
    });
});
