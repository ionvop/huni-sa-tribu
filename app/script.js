let g_data = {
    name: "",
    school: ""
}

initialize();

function initialize() {
    g_loadData();

    for (const element of document.querySelectorAll("*")) {
        element.style.setProperty("--test", "test");
        element.style.removeProperty("--test");
    }
}

function g_saveData() {
    localStorage.setItem("20250927_data", JSON.stringify(g_data));
}

function g_loadData() {
    g_data = JSON.parse(localStorage.getItem("20250927_data"));
    if (g_data == null) g_data = {};
    if (g_data.name == null) g_data.name = "";
    if (g_data.school == null) g_data.school = "";
}