<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <style>
        body { 
            font-family: sans-serif; 
            background-color: #e0f2fe; 
            margin: 0; 
            padding: 20px; 
        }

        .container { 
            max-width: 500px; 
            margin: 40px auto; 
            background: #ffffff; 
            padding: 25px; 
            border-radius: 8px; 
            border: 1px solid #cbd5e1;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .input-group { 
            margin-bottom: 12px; 
        }

        .input-group label {
            font-size: 14px;
            color: #333;
        }

        .input-group input, .input-group textarea { 
            width: 100%; 
            padding: 8px; 
            box-sizing: border-box; 
            margin-top: 4px; 
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button.btn-tambah { 
            padding: 8px 16px; 
            background: #0284c7; 
            color: white; 
            border: none; 
            cursor: pointer; 
            border-radius: 4px; 
            font-weight: bold;
        }

        button.btn-tambah:hover {
            background: #0369a1;
        }

        .todo-item { 
            border-bottom: 1px solid #e2e8f0; 
            padding: 10px 0; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; /* Menjaga teks di kiri & tombol hapus di kanan */
        }

        .todo-content {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .selesai { 
            text-decoration: line-through; 
            color: #94a3b8; 
        }

        .tanggal { 
            font-size: 11px; 
            color: #64748b; 
            display: block; 
            margin-top: 4px; 
        }

        /* Styling Tombol Bundar Merah */
        .btn-hapus {
            width: 26px;
            height: 26px;
            background-color: #ef4444;
            color: white;
            border: none;
            border-radius: 50%; /* Membuat lingkaran sempurna */
            cursor: pointer;
            font-size: 12px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            padding: 0;
            transition: background-color 0.2s;
        }

        .btn-hapus:hover {
            background-color: #dc2626;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 style="margin-top: 0; color: #1e293b;">To-Do List</h2>

        <!-- Form Tambah -->
        <form action="{{ route('todo.store') }}" method="POST">
            @csrf
            <div class="input-group">
                <label>Judul ToDo:</label>
                <input type="text" name="judul" required placeholder="Judul tugas...">
            </div>
            <div class="input-group">
                <label>Keterangan:</label>
                <textarea name="keterangan" rows="2" placeholder="Keterangan (opsional)..."></textarea>
            </div>
            <button type="submit" class="btn-tambah">Tambah ToDo</button>
        </form>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #e2e8f0;">

        <!-- Daftar ToDo -->
        <h3 style="color: #334155;">Daftar Tugas</h3>
        @forelse ($todos as $tugas)
            <div class="todo-item">
                <div class="todo-content">
                    <!-- Checkbox Selesai -->
                    <form action="{{ route('todo.update', $tugas->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="checkbox" onchange="this.form.submit()" {{ $tugas->is_selesai ? 'checked' : '' }}>
                    </form>

                    <div>
                        <!-- Judul & Keterangan -->
                        <strong class="{{ $tugas->is_selesai ? 'selesai' : '' }}">{{ $tugas->judul }}</strong>
                        @if ($tugas->keterangan)
                            <br><span class="{{ $tugas->is_selesai ? 'selesai' : '' }}" style="font-size: 13px;">{{ $tugas->keterangan }}</span>
                        @endif

                        <!-- Tanggal Penyelesaian -->
                        @if ($tugas->is_selesai && $tugas->selesai_pada)
                            <span class="tanggal">Selesai pada: {{ \Carbon\Carbon::parse($tugas->selesai_pada)->format('d-m-Y H:i') }}</span>
                        @endif
                    </div>
                </div>

                <!-- Tombol Hapus (Hanya muncul jika tugas sudah selesai) -->
                @if ($tugas->is_selesai)
                    <form action="{{ route('todo.destroy', $tugas->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-hapus" title="Hapus Tugas" onclick="return confirm('Yakin ingin menghapus tugas ini?')">✕</button>
                    </form>
                @endif
            </div>
        @empty
            <p style="color: #64748b; font-size: 14px;">Belum ada tugas.</p>
        @endforelse
    </div>

</body>
</html>