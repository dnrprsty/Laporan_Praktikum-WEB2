const Artikel = {
    template: `
        <div class="section-block">
            <div class="section-heading">
                <h2>Kelola Artikel</h2>
            </div>

            <div v-if="loading" class="empty-state">Memuat data...</div>

            <div v-else-if="error" class="alert alert-danger">{{ error }}</div>

            <div v-else-if="artikel.length === 0" class="empty-state">Tidak ada artikel.</div>

            <div v-else class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in artikel" :key="row.id">
                            <td>{{ row.id }}</td>
                            <td><strong>{{ row.judul }}</strong></td>
                            <td>{{ row.nama_kategori || 'Tanpa kategori' }}</td>
                            <td>
                                <span class="status-badge" :class="row.status == 1 ? 'published' : 'draft'">
                                    {{ row.status == 1 ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td>{{ formatDate(row.created_at) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    `,
    data() {
        return {
            artikel: [],
            loading: true,
            error: ''
        }
    },
    mounted() {
        this.fetchArtikel();
    },
    methods: {
        fetchArtikel() {
            axios.get(apiUrl + '/api/artikel')
                .then(response => {
                    this.artikel = response.data.data || [];
                })
                .catch(err => {
                    this.error = 'Gagal mengambil data artikel.';
                    console.error(err);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        formatDate(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
        }
    }
};