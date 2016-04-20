window.onload = function() {
	dropdownInit();
    dropdownChange();
}

var dropdownChange = function() {
    document.getElementById('product').addEventListener('change', function() {
        changeDropdownColor(this);
    });
}
var dropdownInit = function() {
	changeDropdownColor(document.getElementById('product'));
}

var changeDropdownColor = function(element) {
	element.value.length > 0 ? element.style.color = 'black' : element.style.color = '';
}