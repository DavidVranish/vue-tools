@section('vue_mixins')
<script>
    vueMixins.tableSorting = function(defaultField, defaultDir) {
        if(typeof(defaultDir) == 'undefined') {
            defaultDir = 1;
        }
        return {
            data: function() {
                return {
                    tableFilters: {
                        orderMulti: function(keys, rows, args) {
                            var tmpArray = keys.filter(function() {
                                return true;
                            });

                            var sortColumns = args.orderMulti;
                            tmpArray.sort(function(a, b) {
                                for(var key in sortColumns) {
                                    var aField = getObjectField(sortColumns[key]['field'], rows[a]);
                                    var bField = getObjectField(sortColumns[key]['field'], rows[b]);

                                    if((typeof(aField) == 'undefined' || aField == null)
                                        && (typeof(bField) == 'undefined' || bField == null)) {
                                        return 0;
                                    } else if((typeof(aField) != 'undefined' && aField != null)
                                        && (typeof(bField) == 'undefined' || bField == null)) {
                                        return 1 * sortColumns[key]['dir'];
                                    } else if((typeof(aField) == 'undefined' || aField == null)
                                        && (typeof(bField) != 'undefined' && bField != null)) {
                                        return -1 * sortColumns[key]['dir'];
                                    }

                                    var result = vueSorts[sortColumns[key]['type']](aField, bField) * sortColumns[key]['dir'];
                                    if((result) != 0) {
                                        return result;
                                    }
                                }

                                return 0;
                            });
                            return tmpArray;
                        }
                    },
                    filterArgs: {
                        orderMulti: {}
                    }
                }
            },
            methods: {
                sort: function(field, icon) {
                    var sortDir = this.filterArgs.orderMulti[field]['dir'];
                    for(var key in this.filterArgs.orderMulti) {
                        this.$set('filterArgs.orderMulti.' + key + '.dir', 0);
                    }

                    $(this.$el).find('th i')
                        .removeClass('fa-sort-amount-asc')
                        .removeClass('fa-sort-amount-desc')
                        .addClass('fa-sort');
                    if(sortDir == 0) {
                        icon
                            .removeClass('fa-sort')
                            .addClass('fa-sort-amount-asc');
                        this.$set('filterArgs.orderMulti.' + field.replace(/\./g, '') + '.dir', 1);
                    } else if(sortDir == 1) {
                        icon
                            .removeClass('fa-sort')
                            .addClass('fa-sort-amount-desc');
                        this.$set('filterArgs.orderMulti.' + field.replace(/\./g, '')  + '.dir', -1);
                    } else if(sortDir == -1) {
                        icon
                            .removeClass('fa-sort')
                            .addClass('fa-sort');
                        this.$set('filterArgs.orderMulti.' + field.replace(/\./g, '')  + '.dir', 0);
                    }
                }
            },
            directives: {
                sort: {
                    bind: function () {
                        $(this.el).append('<i class="pull-right fa fa-sort"></i>');
                        $(this.el).css('cursor', 'pointer');
                        var icon = $(this.el).find('i');

                        this.vm.$set('filterArgs.orderMulti.' + this.expression.replace(/\./g, ''), {
                            field: this.expression,
                            dir: 0,
                            type: this.arg
                        });

                        var directive = this;
                        this.el.addEventListener("click", function(event) {
                            directive.vm.sort(directive.expression.replace(/\./g, ''), icon);
                        });
                    },
                    unbind: function () {
                        this.el.removeEventListener("click", this.vm.sort);
                    }
                }
            }
        };
    };
</script>
@append