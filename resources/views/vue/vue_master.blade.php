@section('vue_scripts')
<script>
    var vueForms = {};
    var vueComponents = {};
    var vueMixins = {};
    var vueSorts = {};

    @if(config('app.debug', 'true') == 'true')
        Vue.config.debug = true;
    @else
        Vue.config.debug = false;
    @endif

    function clone(obj) {
        var rtn = new Object;
        var keys = Object.keys(obj);
        for(var i = 0; i < keys.length; i++) {
            rtn[keys[i]] = obj[keys[i]];
        }

        return rtn;
    }

    Vue.directive('validate', {
            bind: function() {
                    $(this.el).addClass('validate')
                            .css('width', '0px')
                            .css('border', 'none');
            },
            update: function(newValue, oldValue) {
                    if(typeof(newValue) == 'undefined' || newValue == null) {
                            newValue = '';
                    }
                    if(typeof(oldValue) == 'undefined' || oldValue == null) {
                            oldValue = '';
                    }
                    
                    if(newValue != oldValue) {
                            $(this.el).val(newValue);
                            if(typeof($root.formValidation) != 'undefined') {
                                $root.formValidation.validateField($(this.el));
                                $root.formValidation.revalidateField($(this.el));    
                            }
                            
                    }
            }
    });

    function number_format(number, decimals, dec_point, thousands_sep, show_zero) {
        number = (number + '')
            .replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
            .split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '')
            .length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1)
                .join('0');
        }
        
        if(s.join(dec) == 0 && show_zero === 'false' ) {
            return '';  
        } else  {
            return s.join(dec);
        }
    }
</script>
@append

@include('vue.scripts.ajax')
@include('vue.scripts.filters')
@include('vue.scripts.directives')

@include('vue.components.button_group')
@include('vue.components.datepicker')
@include('vue.components.delete')
@include('vue.components.edit_row')
@include('vue.components.icheck')
@include('vue.components.modal')
@include('vue.components.select2')
@include('vue.components.show_row')
@include('vue.components.standard_form')
@include('vue.components.table_all')
@include('vue.components.table_pager')
@include('vue.components.table_searcher')
@include('vue.components.table_pager')

@include('vue.mixins.table_paging')
@include('vue.mixins.table_searching')
@include('vue.mixins.table_sorting')
