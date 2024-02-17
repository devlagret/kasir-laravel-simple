<a type="button" href="{{route('customer.update',$model->id)}}" class="btn btn-sm mb-1 me-1 btn-warning btn-active-light-warning">
    Edit
 </a>
<a type="button" href="{{route('customer.delete',$model->id)}}" onclick="return check('Apakah Anda Yakin Ingin Menghapus Data Ini?')" class="btn mb-1 me-1 btn-sm btn-danger btn-active-light-danger">
    Hapus
 </a>