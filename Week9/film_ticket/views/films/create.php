<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Film Baru</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: #764ba2;
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
            background: rgba(76, 175, 80, 0.3);
            color: white;
            border: 2px solid rgba(76, 175, 80, 0.6);
        }

        button[type="submit"]:hover {
            background: rgba(76, 175, 80, 0.5);
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
            <h1>🎬 Tambah Film Baru</h1>
            <p>Isi form di bawah untuk menambahkan film</p>
        </div>

        <div class="form-container">
            <form action="store.php" method="POST">
                <div class="form-group">
                    <label for="title">Judul Film *</label>
                    <input type="text" id="title" name="title" required placeholder="Contoh: Avengers: Endgame">
                </div>

                <div class="form-group">
                    <label for="genre">Genre *</label>
                    <input type="text" id="genre" name="genre" required placeholder="Contoh: Action, Sci-Fi">
                </div>

                <div class="form-group">
                    <label for="duration">Durasi (menit) *</label>
                    <input type="number" id="duration" name="duration" required placeholder="Contoh: 120">
                </div>

                <div class="form-group">
                    <label for="release_date">Tanggal Rilis *</label>
                    <input type="date" id="release_date" name="release_date" required>
                </div>

                <div class="form-group">
                    <label for="price">Harga Tiket (Rp) *</label>
                    <input type="number" id="price" name="price" required placeholder="Contoh: 50000">
                </div>

                <div class="form-group">
                    <label for="director">Sutradara</label>
                    <input type="text" id="director" name="director" placeholder="Contoh: Christopher Nolan">
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" placeholder="Masukkan sinopsis film..."></textarea>
                </div>

                <div class="form-group">
                    <label for="poster_url">URL Poster</label>
                    <input type="text" id="poster_url" name="poster_url" placeholder="https://example.com/poster.jpg">
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required>
                        <option value="coming_soon">Segera Tayang</option>
                        <option value="now_showing">Sedang Tayang</option>
                        <option value="ended">Sudah Berakhir</option>
                    </select>
                </div>

                <div class="button-group">
                    <a href="index.php" class="btn-back">Kembali</a>
                    <button type="submit">Simpan Film</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>