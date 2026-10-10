@extends('layouts.admin')

@section('title', 'Medical Inventory - Medika Admin')

@section('content')

    <header class="admin-header">
        <div>
            <h1 class="admin-title">Medical Inventory</h1>
            <p style="color: #64748b; font-size: 14px; margin-top: 4px;">Pantau stok obat-obatan, reagen lab, dan alat pelindung diri klinik.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.inventory.index', ['status' => 'low']) }}" class="btn btn-outline" style="font-size: 13px; padding: 6px 12px; border-color: #f59e0b; color: #f59e0b;">Stok Menipis</a>
            <a href="{{ route('admin.inventory.index', ['status' => 'critical']) }}" class="btn btn-outline" style="font-size: 13px; padding: 6px 12px; border-color: #b91c1c; color: #b91c1c;">Stok Kritis</a>
            <a href="{{ route('admin.inventory.index', ['status' => 'out_of_stock']) }}" class="btn btn-outline" style="font-size: 13px; padding: 6px 12px; border-color: #7f1d1d; color: #7f1d1d;">Habis</a>
        </div>
    </header>

    <div class="panel-card" x-data="{ itemModal: false, editMode: false, currentItem: { id: '', name: '', category: '', quantity: '', unit: '', critical_level: '', price: '' } }">
        <div class="panel-header">
            <h3 class="panel-title">Daftar Inventaris Medis</h3>
            <button @click="itemModal = true; editMode = false; currentItem = { id: '', name: '', category: '', quantity: '', unit: '', critical_level: '', price: '' }" class="btn btn-primary">+ Tambah Item Baru</button>
        </div>

        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama Item</th>
                        <th>Kategori</th>
                        <th>Stok Saat Ini</th>
                        <th>Batas Kritis</th>
                        <th>Harga per Unit</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td style="font-weight: 700; color: #1e293b;">{{ $item->name }}</td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->quantity }} {{ $item->unit }}</td>
                            <td>{{ $item->critical_level }} {{ $item->unit }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>
                                @if($item->status === 'available')
                                    <span class="status-badge active">Tersedia</span>
                                @elseif($item->status === 'low')
                                    <span class="status-badge" style="background-color: #fef3c7; color: #d97706;">Stok Menipis</span>
                                @elseif($item->status === 'critical')
                                    <span class="status-badge" style="background-color: #fee2e2; color: #b91c1c;">Stok Kritis</span>
                                @else
                                    <span class="status-badge" style="background-color: #f3f4f6; color: #1f2937;">Habis</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <button @click="itemModal = true; editMode = true; currentItem = { id: '{{ $item->id }}', name: '{{ $item->name }}', category: '{{ $item->category }}', quantity: '{{ $item->quantity }}', unit: '{{ $item->unit }}', critical_level: '{{ $item->critical_level }}', price: '{{ $item->price }}' }" style="color: var(--admin-primary); font-weight: bold; background: none; border: none; cursor: pointer;">Edit</button>
                                    <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini?');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color: var(--danger); font-weight: bold; background: none; border: none; cursor: pointer;">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top: 16px;">
                {{ $items->links() }}
            </div>
        </div>

        <!-- Add/Edit Item Modal (AlpineJS) -->
        <div class="modal-overlay" :class="{ 'open': itemModal }">
            <div class="modal-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-weight: 800; font-size: 20px; color: var(--dark);" x-text="editMode ? 'Edit Item Inventaris' : 'Tambah Item Baru'"></h3>
                    <button @click="itemModal = false" style="font-size: 24px; color: #64748b;">&times;</button>
                </div>

                <form :action="editMode ? '{{ url('admin/inventory') }}/' + currentItem.id : '{{ route('admin.inventory.store') }}'" method="POST">
                    @csrf
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="admin-form-group">
                        <label>Nama Item / Nama Obat</label>
                        <input type="text" name="name" class="admin-form-control" required x-model="currentItem.name">
                    </div>

                    <div class="admin-form-group">
                        <label>Kategori</label>
                        <input type="text" name="category" class="admin-form-control" required placeholder="Obat-obatan, Alkes, APD, dll." x-model="currentItem.category">
                    </div>

                    <div class="admin-form-group">
                        <label>Jumlah Stok</label>
                        <input type="number" name="quantity" class="admin-form-control" required min="0" x-model="currentItem.quantity">
                    </div>

                    <div class="admin-form-group">
                        <label>Satuan Unit</label>
                        <input type="text" name="unit" class="admin-form-control" required placeholder="box, tablet, pcs, tabung" x-model="currentItem.unit">
                    </div>

                    <div class="admin-form-group">
                        <label>Batas Stok Kritis (Critical Level)</label>
                        <input type="number" name="critical_level" class="admin-form-control" required min="1" x-model="currentItem.critical_level">
                    </div>

                    <div class="admin-form-group">
                        <label>Harga per Satuan ($)</label>
                        <input type="number" name="price" class="admin-form-control" min="0" step="0.01" x-model="currentItem.price">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 16px;" x-text="editMode ? 'Simpan Perubahan' : 'Tambahkan Item'"></button>
                </form>
            </div>
        </div>

    </div>

@endsection
