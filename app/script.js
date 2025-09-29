let g_data = {
    name: "",
    school: ""
};

g_initialize();

function g_initialize() {
    g_loadData();

    document.body.onload = () => {
        for (const element of document.body.querySelectorAll("*")) {
            element.style.setProperty("--test", "test");
            element.style.removeProperty("--test");
        }
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

function g_renderNavigation(page) {
    return /*html*/`
        <div style="
            display: flex;
            border-top: 1px solid #aaa;">
            <a style="
                display: block;
                flex: 1;
                min-width: 0;"
                href="home.html">
                <div style="
                    display: flex;
                    justify-content: center;
                    padding: 0.7rem;">
                    <div style="
                        padding: 0.7rem;
                        border-radius: 1rem;
                        ${page == "home" ? "background-color: #332;" : ""}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffeeaa"><path d="M160-200v-360q0-19 8.5-36t23.5-28l240-180q21-16 48-16t48 16l240 180q15 11 23.5 28t8.5 36v360q0 33-23.5 56.5T720-120H600q-17 0-28.5-11.5T560-160v-200q0-17-11.5-28.5T520-400h-80q-17 0-28.5 11.5T400-360v200q0 17-11.5 28.5T360-120H240q-33 0-56.5-23.5T160-200Z"/></svg>
                    </div>
                </div>
                <div style="
                    padding: 0.7rem;
                    padding-top: 0rem;
                    color: #fea;
                    font-size: 0.7rem;
                    text-align: center;
                    ${page == "home" ? "font-weight: bold;" : ""}">
                    Home
                </div>
            </a>
            <a style="
                display: block;
                flex: 1;
                min-width: 0;"
                href="tribes.html">
                <div style="
                    display: flex;
                    justify-content: center;
                    padding: 0.7rem;">
                    <div style="
                        padding: 0.7rem;
                        border-radius: 1rem;
                        ${page == "tribes" ? "background-color: #332;" : ""}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffeeaa"><path d="M40-240q-17 0-28.5-11.5T0-280v-23q0-43 44-70t116-27q13 0 25 .5t23 2.5q-14 21-21 44t-7 48v65H40Zm240 0q-17 0-28.5-11.5T240-280v-25q0-32 17.5-58.5T307-410q32-20 76.5-30t96.5-10q53 0 97.5 10t76.5 30q32 20 49 46.5t17 58.5v25q0 17-11.5 28.5T680-240H280Zm500 0v-65q0-26-6.5-49T754-397q11-2 22.5-2.5t23.5-.5q72 0 116 26.5t44 70.5v23q0 17-11.5 28.5T920-240H780ZM160-440q-33 0-56.5-23.5T80-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T160-440Zm640 0q-33 0-56.5-23.5T720-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T800-440Zm-320-40q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T600-600q0 50-34.5 85T480-480Z"/></svg>
                    </div>
                </div>
                <div style="
                    padding: 0.7rem;
                    padding-top: 0rem;
                    color: #fea;
                    font-size: 0.7rem;
                    text-align: center;
                    ${page == "tribes" ? "font-weight: bold;" : ""}">
                    Tribes
                </div>
            </a>
            <a style="
                display: block;
                flex: 1;
                min-width: 0;"
                href="translate.html">
                <div style="
                    display: flex;
                    justify-content: center;
                    padding: 0.7rem;">
                    <div style="
                        padding: 0.7rem;
                        border-radius: 1rem;
                        ${page == "translate" ? "background-color: #332;" : ""}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffeeaa"><path d="m603-202-34 97q-4 11-14 18t-22 7q-20 0-32.5-16.5T496-133l152-402q5-11 15-18t22-7h30q12 0 22 7t15 18l152 403q8 19-4 35.5T868-80q-13 0-22.5-7T831-106l-34-96H603ZM362-401 188-228q-11 11-27.5 11.5T132-228q-11-11-11-28t11-28l174-174q-35-35-63.5-80T190-640h84q20 39 40 68t48 58q33-33 68.5-92.5T484-720H80q-17 0-28.5-11.5T40-760q0-17 11.5-28.5T80-800h240v-40q0-17 11.5-28.5T360-880q17 0 28.5 11.5T400-840v40h240q17 0 28.5 11.5T680-760q0 17-11.5 28.5T640-720h-76q-21 72-63 148t-83 116l96 98-30 82-122-125Zm266 129h144l-72-204-72 204Z"/></svg>
                    </div>
                </div>
                <div style="
                    padding: 0.7rem;
                    padding-top: 0rem;
                    color: #fea;
                    font-size: 0.7rem;
                    text-align: center;
                    ${page == "translate" ? "font-weight: bold;" : ""}">
                    Translate
                </div>
            </a>
        </div>
    `;
}

function g_elementFromHTML(html) {
    let template = document.createElement("template");
    template.innerHTML = html;
    return template.content.firstElementChild;
}

function g_escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}