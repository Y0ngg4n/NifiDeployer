const columnCount = 4


let timeout;

function getServer() {

    if (!timeout) {
        writeServerList(false);
        timeout = true;
    }

    setTimeout(function () {
        timeout = false;
    }, 1000);
}

function getAllServer() {
    writeServerList(true)
}

function writeServerList(all) {
    const searchWord = document.getElementById("searchWord").value;
    const serverListTable = document.getElementById("serverListTable");
    serverListTable.innerHTML = '';

    const webPath = dirname(window.location.pathname)[0];
    let url = webPath + "api/server/serverList.php";
    if (all) url = webPath + "api/server/allServerList.php";
    console.log(url);
    $.ajax({
        type: "GET",
        url: url,
        data: {searchWord: encodeURI(searchWord)},
        success: function (response) {
            const json = JSON.parse(response);
            for (let i = 0; i < json.length; i++) {
                const tr = document.createElement("tr");
                if (i % 2 == 0)
                    tr.classList.add("bg-secondary");
                else tr.classList.add("bg-dark");

                serverListTable.appendChild(tr);
                const rowId = document.createElement("td");
                tr.appendChild(rowId);
                for (let z = 0; z < columnCount; z++) {
                    rowId.innerText = i.toString();
                    const tableData = document.createElement("td");
                    tableData.innerText = json[i][z];
                    tr.appendChild(tableData)
                }
                tr.onclick = (event) => {
                    window.location = webPath + 'pages/server/manageServer.php?serverId=' + encodeURI(json[i][0]);
                };
            }
        }
    });
}

function dirname(path) {
    return path.match(/.*\//);
}