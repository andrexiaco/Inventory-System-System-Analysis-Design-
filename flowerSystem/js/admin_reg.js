function toggleTheme() {
    const body = document.body;
    body.classList.toggle("dark-theme");
}

setTimeout(function() {
    document.getElementById('fname').style.display = 'none';
    document.getElementById('role').style.display = 'none';
    document.getElementById('uname').style.display = 'none';
    document.getElementById('pass').style.display = 'none';
}, 5000);