@section('vue_mixins')
<script>
    vueMixins.tablePaging = function(pageSize, page) {
        if(typeof(pageSize) == 'undefined') {
            pageSize = 10;
        }
        if(typeof(page) == 'undefined') {
            page = 0;
        }
        return {
            data: function() {
                var vm = this;
                return {
                    page: page,
                    pageSize: pageSize,
                    tableFilters: {
                        limitBy: function(keys, rows, args) {
                            return vm
                                .$options
                                .filters
                                .limitBy(keys, args.limitBy.pageSize, args.limitBy.offset);
                        }
                    },
                    filterArgs: {
                        limitBy: {
                            pageSize: pageSize,
                            offset: pageSize * page
                        }  
                    }
                }
            },
            computed: {
                offset: function() {
                    return this.pageSize * this.page;
                }
            },
            watch: {
                pageSize: function(val, oldVal) {
                    this.filterArgs.limitBy.pageSize = this.pageSize;
                },
                offset: function(val, oldVal) {
                    this.filterArgs.limitBy.offset = this.offset;
                }
            }
        };
    };
</script>
@append