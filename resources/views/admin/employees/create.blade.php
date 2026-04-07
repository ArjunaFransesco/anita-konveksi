@section('dashboard-content')
<div class="card">
    <div class="card-header">
        <h4>Tambah Pegawai</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.employees.store') }}">
            @csrf
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Posisi</label>
                <input type="text" name="position" class="form-control">
            </div>
            <div class="form-group">
                <label>Tipe Pegawai</label>
                <select name="employee_type" class="form-control" required>
                    <option value="harian">Harian</option>
                    <option value="borongan">Borongan</option>
                    <option value="mingguan">Mingguan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Rate (Gaji)</label>
                <input type="number" name="salary_rate" step="0.01" class="form-control">
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="address" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Tanggal Bergabung</label>
                <input type="date" name="join_date" class="form-control">
            </div>
            <div class="form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" checked>
                <label class="form-check-label">Status Aktif</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
</div>
@endsection