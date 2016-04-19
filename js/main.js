window.onload = function() {
    dropdownChange();
}

function dropdownChange() {
    document.getElementById('product').addEventListener('change', function() {
        this.value.length > 0 ? this.style.color = 'black' : this.style.color = '';
    });
}