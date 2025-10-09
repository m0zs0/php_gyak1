<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Névjegykezelő</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            width: 100%;
            max-width: 900px;
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #1a4d2e;
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            color: #444;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 5px;
            margin-top: 30px;
        }
        form {
            display: grid;
            gap: 15px;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        form input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        form input[type="text"]:focus {
            border-color: #1a4d2e;
            outline: none;
        }
        form button {
            grid-column: 1 / -1;
            background-color: #1a4d2e;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.2s;
        }
        form button:hover {
            background-color: #143822;
            transform: translateY(-2px);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f8f8;
            font-weight: 600;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .delete-form, .edit-form {
            display: inline;
        }
        .edit-button, .delete-button {
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            margin-right: 5px;
        }
        .edit-button {
            background-color: #3498db;
            color: white;
        }
        .edit-button:hover {
            background-color: #2980b9;
            transform: translateY(-1px);
        }
        .delete-button {
            background-color: #e74c3c;
            color: white;
        }
        .delete-button:hover {
            background-color: #c0392b;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Névjegykezelő</h1>

        <h2>Új névjegy hozzáadása</h2>
        <form action="" method="post">
            <input type="hidden" name="action" value="add">
            <div>
                <label for="name">Név:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div>
                <label for="phone">Telefon:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div>
                <label for="company">Cég:</label>
                <input type="text" id="company" name="company" required>
            </div>
            <button type="submit">Hozzáadás</button>
        </form>

        <h2>Névjegyek listája</h2>
        <?php if (empty($cards)): ?>
            <p>Nincsenek névjegyek az adatbázisban.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Név</th>
                        <th>E-mail</th>
                        <th>Cég</th>
                        <th>Művelet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cards as $cardData): ?>
                        <tr>
                            <td><?= htmlspecialchars($cardData['id']) ?></td>
                            <td><?= htmlspecialchars($cardData['name']) ?></td>
                            <td><?= htmlspecialchars($cardData['email']) ?></td>
                            <td><?= htmlspecialchars($cardData['company']) ?></td>
                            <td>
                                <!-- Szerkesztés gomb -->
                                <button class="edit-button" onclick="showEditForm(<?= htmlspecialchars($cardData['id']) ?>)">Szerkesztés</button>
                                <!-- Törlés gomb -->
                                <form action="" method="post" class="delete-form">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($cardData['id']) ?>">
                                    <button type="submit" class="delete-button">Törlés</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Szerkesztő űrlap, ami alapból rejtett -->
                        <tr id="edit-form-<?= htmlspecialchars($cardData['id']) ?>" style="display:none;">
                            <td colspan="5">
                                <form action="" method="post">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($cardData['id']) ?>">
                                    <label>Név: <input type="text" name="name" value="<?= htmlspecialchars($cardData['name']) ?>"></label>
                                    <label>E-mail: <input type="text" name="email" value="<?= htmlspecialchars($cardData['email']) ?>"></label>
                                    <label>Telefon: <input type="text" name="phone" value="<?= htmlspecialchars($cardData['phone']) ?>"></label>
                                    <label>Cég: <input type="text" name="company" value="<?= htmlspecialchars($cardData['company']) ?>"></label>
                                    <button type="submit">Mentés</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <script>
        function showEditForm(id) {
            const form = document.getElementById('edit-form-' + id);
            form.style.display = form.style.display === 'none' ? 'table-row' : 'none';
        }
    </script>
</body>
</html>
