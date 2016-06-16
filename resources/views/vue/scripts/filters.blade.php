@section('vue_scripts')
<script>
	vueSorts.date = function(a, b) {
		if(typeof(a) == 'undefined'
			|| a == ''
			|| a == null) {
			a = moment('null');
		} else {
			a = moment(a);
		}

		if(typeof(b) == 'undefined'
			|| b == ''
			|| b == null) {
			b = moment('null');
		} else {
			b = moment(b);
		}

		if(!a.isValid() && !b.isValid()) {
			return 0;
		} else if(a.isValid() && !b.isValid()) {
			return 1;
		} else if(!a.isValid() && b.isValid()) {
			return -1;
		} else if(a.isBefore(b, 'day')) {
			return -1;
		} else if(b.isBefore(a, 'day')) {
			return 1;
		} else {
			return 0;		
		}
	}

	vueSorts.dateTime = function(a, b) {
		if(typeof(a) == 'undefined'
			|| a == ''
			|| a == null) {
			a = moment('null');
		} else {
			a = moment(a);
		}

		if(typeof(b) == 'undefined'
			|| b == ''
			|| b == null) {
			b = moment('null');
		} else {
			b = moment(b);
		}

		if(!a.isValid() && !b.isValid()) {
			return 0;
		} else if(a.isValid() && !b.isValid()) {
			return 1;
		} else if(!a.isValid() && b.isValid()) {
			return -1;
		} else if(a.isBefore(b, 'second')) {
			return -1;
		} else if(b.isBefore(a, 'second')) {
			return 1;
		} else {
			return 0;		
		}
	}

	vueSorts.number = function(a, b) {
		if((0 + a) > (0 + b)) {
			return 1;
		} else if((0 + a) < (0 + b)) {
			return -1;
		} else {
			return 0;
		}
	}

	vueSorts.alpha = function(a, b) {
		return ('' + a).localeCompare('' + b);
	}

	Vue.filter('date', function(date, format) {
		var filterDate
		if(date == '' || date == null) {
			filterDate = moment('null');
		} else {
			filterDate = moment(date);
		}
	    
	    if(filterDate.isValid()) {
	    	if(typeof(format) != 'undefined') {
	    		return filterDate.format(format);	
	    	} else {
	    		return filterDate.format("{{ config('vue.defaultDateFormat', 'MM/DD/YY') }}");
	    	}
	    } else {
	        return '';
	    }
	});

	Vue.filter('number', function(number, decimals, decimalPoint, thousandsSeperator) {
		if(typeof(number) == 'undefined' || isNaN(number)) {
			return '';
		} else {
			if(typeof(decimals) == 'undefined') {
				decimals = {{ config('vue.defaultDecimals', 2) }};
			}
			if(typeof(decimalPoint) == 'undefined') {
				decimalPoint = '{{ config('vue.defaultDecimalPoint', '.') }}';
			}
			if(typeof(thousandsSeperator) == 'undefined') {
				thousandsSeperator = '{{ config('vue.defaultThousandSeparator', ',') }}';
			}

			return number_format(number, decimals, decimalPoint, thousandsSeperator);
		}
	});

	Vue.filter('length', function(array) {
	    return array.length;
	});

	Vue.filter('notIn', function(array, compareArray, compareElement) {
		if(typeof(compareElement) == 'undefined') {
			return array.filter(function(elem) {
		    	var index = compareArray.indexOf(elem);
		    	return (index == -1);
		    });	
		} else {
			return array.filter(function(elem) {
		    	var index = compareArray.findIndex(function(compareElem) {
		    		return elem[compareElement] == compareElem[compareElement];
		    	});

		    	return (index == -1);
		    });	
		}
	    
	});

	function getObjectField(field, object) {
		var rtn = object;
		var keys = field.split('.');
		for(key in keys) {
			rtn = rtn[key];
		}
		return rtn;
	}

	Vue.filter('orderMulti', function(array, sortColumns) {

		var tmpArray = array.filter(function() {
			return true;
		});

	    tmpArray.sort(function(a, b) {
	    	if((typeof(a) == 'undefined' || a == null)
	    		&& (typeof(b) == 'undefined' || b == null)) {
	    		return 0;
			} else if((typeof(a) != 'undefined' && a != null)
	    		&& (typeof(b) == 'undefined' || b == null)) {
				return 1;
			} else if((typeof(a) == 'undefined' || a == null)
	    		&& (typeof(b) != 'undefined' && b != null)) {
				return -1;
			}

	        for(var i = 0; i < sortColumns.length; i++) {
	        	var aField = getObjectField(sortColumns[i][0], a);
	        	var bField = getObjectField(sortColumns[i][0], b);

	            var result = vueSorts[sortColumns[i][2]](aField, bField) * sortColumns[i][1];
	            if((result) != 0) {
	                return result;
	            }
	        }
	        return 0;
	    });
	    return tmpArray;
	});
</script>
@append
