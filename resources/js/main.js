window.copy = function () {
    const el = document.getElementById('copy');
    el.select();
    el.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(el.value);
    alert('Copied!');
}
