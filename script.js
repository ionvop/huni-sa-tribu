const g_btnLogout = document.getElementById("g_btnLogout");

for (let element of document.querySelectorAll("*")) {
    element.style.setProperty("--test", "test");
    element.style.removeProperty("--test");
}

g_btnLogout.onclick = () => {
    if (confirm("Are you sure you want to logout?") == false) return;
    g_btnLogout.submit();
}