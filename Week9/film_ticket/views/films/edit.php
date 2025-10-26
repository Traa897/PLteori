<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Film</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
        }

        .form-container {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            border: 2px solid rgba(255,255,255,0.2);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: white;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 1.1em;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 10px;
            background: rgba(255,255,255,0.2);
            color: white;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        input::placeholder, textarea::placeholder {
            color: rgba(255,255,255,0.6);
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: rgba(255,255,255,0.6);
            background: rgba(255,255,255,0.25);
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        select option {
            background: #f5576c;
            color: white;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        button, .btn-back {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        button[type="submit"] {
            background: rgba(255, 152, 0, 0.3);
            color: white;
            border: 2px solid rgba(255, 152, 0, 0.6);
        }

        button[type="submit"]:hover {
            background: rgba(255, 152, 0, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }

        .btn-back {
            background: rgba(158, 158, 158, 0.3);
            color: white;
            border: 2px solid rgba(158, 158, 158, 0.6);
        }

        .btn-back:hover {
            background: rgba(158, 158, 158, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }
            h1 {
                font-size: 2em;
            }
            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✏️ Edit Film</h1>
            <p>Update informasi film</p>
        </div>

        <div class="form-container">
            <form action="update.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($film['id']); ?>">
                
                <div class="form-group">
                    <label for="title">Judul Film *</label>
                    <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($film['title']); ?>">
                </div>

                <div class="form-group">
                    <label for="genre">Genre *</label>
                    <input type="text" id="genre" name="genre" required value="<?php echo htmlspecialchars($film['genre']); ?>">
                </div>

                <div class="form-group">
                    <label for="duration">Durasi (menit) *</label>
                    <input type="number" id="duration" name="duration" required value="<?php echo htmlspecialchars($film['duration']); ?>">
                </div>

                <div class="form-group">
                    <label for="release_date">Tanggal Rilis *</label>
                    <input type="date" id="release_date" name="release_date" required value="<?php echo htmlspecialchars($film['release_date']); ?>">
                </div>

                <div class="form-group">
                    <label for="price">Harga Tiket (Rp) *</label>
                    <input type="number" id="price" name="price" required value="<?php echo htmlspecialchars($film['price']); ?>">
                </div>

                <div class="form-group">
                    <label for="director">Sutradara</label>
                    <input type="text" id="director" name="director" value="<?php echo htmlspecialchars($film['director']); ?>">
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($film['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="poster_url">URL Poster</label>
                    <input type="text" id="poster_url" name="poster_url" value="<?php echo htmlspecialchars($film['poster_url']); ?>">
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required>
                        <option value="coming_soon" <?php echo $film['status'] == 'coming_soon' ? 'selected' : ''; ?>>Segera Tayang</option>
                        <option value="now_showing" <?php echo $film['status'] == 'now_showing' ? 'selected' : ''; ?>>Sedang Tayang</option>
                        <option value="ended" <?php echo $film['status'] == 'ended' ? 'selected' : ''; ?>>Sudah Berakhir</option>
                    </select>
                </div>

                <div class="button-group">
                    <a href="index.php" class="btn-back">Kembali</a>
                    <button type="submit">Update Film</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>