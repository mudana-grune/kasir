import PaketForm from '../../../pages/admin/paket/PaketForm';
import PaketTable from '../../../pages/admin/paket/PaketTable';
import JenisPaketTable from '../../../pages/admin/paket/JenisPaketTable';

const paket = [
    {
        path: '/admin/paket',
        name: 'admin.paket',
        component: PaketTable,
    },
    {
        path: '/admin/paket/add',
        name: 'admin.paket.tambah',
        component: PaketForm
    },
    {
        path: '/admin/paket/edit/:id',
        name: 'admin.paket.edit',
        component: PaketForm,
        meta: {
            editPage: true,
        }
    },
    {
        path: '/admin/paket/jenis',
        name: 'admin.paket.jenis',
        component: JenisPaketTable,
    }
];

export default paket;
