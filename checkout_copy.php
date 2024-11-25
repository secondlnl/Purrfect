<!DOCTYPE html>
<html lang="en">

<head>
    <link href="style.css" rel="stylesheet" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        window.onload = function() {
            product("show");
        };

        async function product(opt, id = null) {
            const req = new XMLHttpRequest();
            req.open("POST", "productcess.php", true);
            req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            req.onreadystatechange = () => {
                // Call a function when the state changes.
                if (req.readyState === XMLHttpRequest.DONE && req.status === 200) {
                    // Request finished. Do processing here.
                    const resp = req.responseText.trim()
                    if (resp) {
                        prow = JSON.parse(req.responseText);
                        console.log(prow);
                        document.getElementById("me").innerHTML = "";
                        prow.forEach(e => {
                            document.getElementById("me").innerHTML += `
                    <tr id="products">
                    <td>${e.name}</td>
                    <td>${e.price}</td>
                    <td>${e.description}</td>
                    <td><button id="Del" class="cartremove" onclick="product('del',${e.id});">Delete ${e.id}</button></td> <td></td>`;
                        });
                    };
                };
            };
            if (opt.toLowerCase() === "del") { // opt del
                req.send(`opt=del&id=${id}`);
            } else if (opt.toLowerCase() === "add") { // opt add
                const name = document.getElementById("Name");
                const price = document.getElementById("Price");
                const description = document.getElementById("Description");
                name.oninput = function() {
                    document.getElementById("Error").innerHTML = "";
                }
                description.oninput = function() {
                    document.getElementById("Error").innerHTML = "";
                }
                price.oninput = function() {
                    document.getElementById("Error").innerHTML = "";
                }
                if (document.getElementById("Error").innerHTML.length <= 0 && description.value.trim() != "" && name.value.trim() != "" && price.value.trim() != "") {
                    req.send(`opt=add&name=${name.value}&price=${price.value}&description=${description.value}`);
                    name.value = "";
                    price.value = "";
                    description.value = "";
                } else {
                    console.log("error be error");
                    document.getElementById("Error").innerHTML = "Something wrong :C, fill in all the fields.";
                }
            } else if (opt.toLowerCase() === "show") {
                req.send("opt=show");
            };
        };
    </script>
</head>

<body>
    <table id="yp">
        <thead>
            <th>Name</th>
            <th>Price (kr)</th>
            <th>Description</th>
        </thead>
        <tbody id="me">

        </tbody>
        <tbody>
            <tr>
                <td><input type="text" id="Name" placeholder="Product name"></td>
                <td><input type="number" min="1" id="Price" placeholder="Desired price"></td>
                <td><textarea id="Description"></textarea></td>
                <td><button onclick="product('add');">add</button></td>
            </tr>
        </tbody>
    </table>
    <p id="Error"></p>
</body>