<x-app-layouts title="Data Poli">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">Data Poli</h5>
            <a href="{{ route('admin.poli.create') }}" class="btn btn-primary">
                + Tambah Poli
            </a>
        </div>

        <div class="card-body table-responsive">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Nama Poli</th>
                        <th style="width: 120px;">Loket</th>
                        <th style="width: 180px;">Actions</th>
                    </tr>

                </thead>
                <tbody>
                    @forelse($polis as $index => $poli)
                        <tr>
                            <td>{{ $polis->firstItem() + $index }}</td>
                            <td>{{ $poli->nama_poli }}</td>
                            <td>{{ $poli->loket ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.poli.edit', $poli) }}" class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('admin.poli.destroy', $poli) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus poli ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                Belum ada data poli.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-2">
                {{ $polis->links() }}
            </div>
        </div>
    </div>
</x-app-layouts>
