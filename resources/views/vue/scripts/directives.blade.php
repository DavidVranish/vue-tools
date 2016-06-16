@section('vue_scripts')
<script>
Vue.directive('slot', {
    bind: function () {
        var vm = this.vm;

        var raw;
        
        if(this.expression == '') {
            raw = vm._slotContents.default;
        } else {
            raw = vm._slotContents.default.children[this.expression];
        }
        if(typeof(raw) != 'undefined') {
            for (var i = 0; i < raw.children.length; i++) {
                var node = raw.children[i].cloneNode(true);
                this.el.appendChild(node);
                vm.$root.$compile(node, vm, this._scope);
            }
        }
    }
});
</script>
@append