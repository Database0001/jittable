<?php
include("sys/db.php");
$users = $db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>

    <style>
        th,
        tr,
        td {
            padding: 5px;
            user-select: none;
        }

        td {
            cursor: pointer;
        }
    </style>

</head>

<body>

    <table id="example" border="1px" data-table="users">
        <thead>
            <th>#</th>
            <th>Kullanıcı adı</th>
            <th>E-mail</th>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr index="id" value="<?= $user['id'] ?>">
                    <td edit="false" data-key="id"><?= $user['id'] ?></td>
                    <td data-key="username"><?= $user['username'] ?></td>
                    <td data-key="email"><?= $user['email'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script src="assets/js/jquery.js"></script>

    <script>
        function jittable(id) {
            let table = document.querySelector(id);
            let th = document.querySelectorAll(id + ' thead th');
            let td = document.querySelectorAll(id + ' tbody td');

            td.forEach(function(item, index) {
                item.setAttribute("data-value", item.innerHTML);
                if (item.getAttribute('edit') != "false") {
                    item.addEventListener('click', function() {
                        let f = item.getAttribute("editing");
                        let t = item.getAttribute("data-value");
                        let hash = Math.random().toString(36);
                        let parent = item.parentElement;

                        if (f == null) {
                            item.innerHTML = `<input type="text" value="${t}" id="${hash}">`;
                            item.children[0].focus();
                            item.setAttribute("editing", "");
                        } else {
                            let _t = item.children[0].value;
                            item.setAttribute("data-value", _t);
                            item.innerHTML = _t;
                            item.removeAttribute("editing");
                            let request = {
                                table: table.getAttribute('data-table'),
                                key: {
                                    key: parent.getAttribute('index'),
                                    value: parent.getAttribute('value')
                                },
                                values: {
                                    set: item.getAttribute('data-key'),
                                    value: _t
                                }
                            };

                            $.post('ajax/update.php', request, function(e) {
                                console.log(e);
                            });
                        }
                    });
                }
            });
        }

        jittable('#example');
    </script>

</body>

</html>