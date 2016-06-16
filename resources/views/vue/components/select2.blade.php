<template id="vue-select2">
	<select v-slot style="display: none;">
		
	</select>
</template>

@section('vue_components')
<script>
	vueComponents.select2 = Vue.extend({
		template: '#vue-select2',
		props: {
			value: null,
			disabled: String,
			options: {
				type: Object,
				default: function() {
		            return {
		            	width: '100%',
		            	minimumResultsForSearch: 6
		            };
		        }
			},
			list: {
				type: [Object, Array],
				default: function() {
					return new Array();
				}
			},
			valueField: {
				type: String
			},
			textField: {
				type: String
			}
		},
		computed: {
			selectData: function() {
				var list = this.list;
				var valueField = this.valueField;
				var textField = this.textField;

				return $.map(list, function (obj) {
				  	obj.id = obj[valueField];
				  	obj.text = obj[textField];

				  	return obj;
				});
			}
		},
        data: function() {
        	return {
	            '$select': {},
	            'select2': {}
	        }
        },
		ready: function() {
			var vm = this;
			vm.$select = $(vm.$el);

			vm.$nextTick(function() {
				var options = vm.options;
				if(!(Array.isArray(vm.list) && vm.list.length == 0)) {
					options.data = vm.selectData;
				}
				
				vm.select2 = vm.$select.select2(options);
				vm.$select.val(vm.value);
				vm.$select.trigger('change');
				
				vm.$select.on('select2:select', function() {
					vm.value = vm.$select.val();
				});

				vm.$select.on('select2:unselect', function() {
					vm.value = vm.$select.val();
				});

				vm.$select.show();
			});
		},
		watch: {
	    	value: function (val, oldVal) {
	    		var vm = this;

	    		vm.$select.val(this.value);
	    		vm.$select.trigger('change');
	      	}
	    }
	});

	Vue.component('select2', vueComponents.select2);

</script>
@append