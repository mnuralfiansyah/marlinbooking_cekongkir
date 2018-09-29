<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->

                    </ul>
                </div>
            </div>
        </nav>


        <div class="container">
          <div class="row">
              <div class="col-md-8 col-md-offset-2">
                  <div class="panel panel-default">
                      <div class="panel-heading">Cek Ongkos Kirim</div>

                      <div class="panel-body">
                          <form class="form-horizontal" method="get" action="/harga">
                              {{ csrf_field() }}

                              <div class="form-group">
                                  <label for="email" class="col-md-4 control-label">Dari </label>
                                  <div class="col-md-6">
                                      <input id="email" type="text" class="form-control" name="email" value="Yogyakarta" disabled>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label for="email" class="col-md-4 control-label">Berat (Gram)</label>
                                  <div class="col-md-6">
                                      <input name="total_berat" value="500" id="berat" class="form-control col-md-7 col-xs-12" placeholder="Dalam Satuan Gram" required="required" type="number" required>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label for="email" class="col-md-4 control-label">Tujuan Propinsi</label>
                                  <div class="col-md-6">
                                    <select class="form-control required" id="pilih_propinsi" name="propinsi">
                                      <option value="">---Pilih Propinsi---</option>
                                      @foreach ($propinsi as $k => $v)
                                        <option value="{{$v['id']}}">{{$v['name']}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                              </div>

                              <div class="form-group" id="formkab"></div>


                              <div class="item form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="name">Jasa Pengiriman<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select class="form-control" id="pilih_jasa_pengirim" name="kurir">
                                    <option value="">---Pilih Jasa Pengiriman---</option>
                                    <option value="jne">JNE</option>
                              			<option value="tiki">TIKI</option>
                              			<option value="pos">POS INDONESIA</option>
                                  </select>
                                </div>
                              </div>

                              <div class="item form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="name"></label>
                                <div class="col-md-6 col-sm-6 col-xs-12" id="ongkos">
                                </div>
                              </div>





                              <div class="form-group">
                                  <div class="col-md-8 col-md-offset-4">
                                      <button type="submit" class="btn btn-primary">
                                          Cek Ongkir
                                      </button>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
        </div>


    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script>

function Rupiah(bilangan) {
  var	number_string = bilangan.toString(),
  	sisa 	= number_string.length % 3,
  	rupiah 	= number_string.substr(0, sisa),
  	ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

  if (ribuan) {
  	separator = sisa ? '.' : '';
  	rupiah += separator + ribuan.join('.');
  }
  return rupiah;
}

$(document).ready(function() {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
});

$(document).on('click','button#send', function(e){


});


$(document).on('change','#pilih_propinsi', function(e){
  e.preventDefault();
  prop_id = $('#pilih_propinsi').val();

  $.ajax({
    type : "get",
    url : "/pilih_kab",
    data : {propinsi_id:prop_id},
    success : function(result) {
      $('#formkab').html(result);
    }
  });
});

$(document).on('change','#pilih_jasa_pengirim', function(e){
  e.preventDefault();
  // alert('masuk')

  kab_id = $('#pilih_kabupaten').val();
  berat = $('#berat').val();
  jumlah = 1;
  kurir = $('#pilih_jasa_pengirim').val()



  total_berat = berat * jumlah;
// alert(total_berat);

  $.ajax({
    type : "get",
    url : "/harga",
    data : {kabupaten_id:kab_id,total_berat:total_berat,kurir:kurir},
    success : function(result) {

      alert('Jika Ada Maka akan Tampil Dibawah');
          $('#ongkos').html(result);


    }
  });
});

$(document).on('change','#jumlah', function(e){
  e.preventDefault();

  kab_id = $('#pilih_kabupaten').val();
  berat = $('#berat').val();
  jumlah = 1;
  kurir = $('#pilih_jasa_pengirim').val()

  total_berat = berat * jumlah;

  $.ajax({
    type : "get",
    url : "/harga",
    data : {kabupaten_id:kab_id,total_berat:total_berat,kurir:kurir},
    success : function(result) {
      $('#ongkos').html(result);
    }
  });
});

$(document).on('change','.ongkir', function(e){
  e.preventDefault();

  var ongkos = parseInt($(this).attr('data-ongkos'));
  var harga = $('#harga').val();
  var jumlah = $('#jumlah').val();
  var total = (harga*jumlah+(harga*jumlah*0.1))+ongkos;
  var prop = $('#pilih_propinsi').find(":selected").text();
  var kab = $('#pilih_kabupaten').find(":selected").text();

  var html ='<input id="" name="total" class="form-control col-md-7 col-xs-12" required="required" type="text" value="Rp. '+Rupiah(total)+',00" disabled> <input type="hidden" name="kabupaten_name" value="'+kab+'"><input type="hidden" name="propinsi_name" value="'+prop+'"><input type="hidden" name="harga" value="'+harga+'"><input type="hidden" name="nama_produk" value="'+nama+'">';

  $('#totalsemua').html(html);

});









</script>
</body>
</html>
