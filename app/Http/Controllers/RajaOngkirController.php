<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RajaOngkirController extends Controller
{
    public function index($value='')
    {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "key: 88c860b0326366b5eeef2606cf92ce9f"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      $data = json_decode($response, true);
      for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
        $propinsi[$i] = ['id'=>$data['rajaongkir']['results'][$i]['province_id'],'name'=>$data['rajaongkir']['results'][$i]['province']];
      }


      return view('layouts.cekongkir',['propinsi'=>$propinsi]);
    }

    public function pilih_kab(Request $r) {
      $provinsi_id = $r->propinsi_id;

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=$provinsi_id",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "key: 88c860b0326366b5eeef2606cf92ce9f"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          //echo $response;
        }
        echo '<label class="control-label col-md-4 col-sm-3 col-xs-12" for="name">Kabupaten/Kota <span class="required">*</span></label>';
        echo '<div class="col-md-6 col-sm-6 col-xs-12">';
        echo '<select class="form-control required" id="pilih_kabupaten" name="kabupaten_id">';
        echo "<option value=''>---Pilih Kabupaten---</option>";
        $data = json_decode($response, true);
        for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
          // $kabupaten[$i] = ['id'=>$data['rajaongkir']['results'][$i]['city_id'],'name'=>$data['rajaongkir']['results'][$i]['city_name']];
            echo "<option value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>";
        }
        echo '</select>';
        echo "</div>";

    }

    public function Harga(Request $r)
    {
      $asal = '501'; //Yogyakarta
      $id_kabupaten = $r->kabupaten_id;
      $kurir = $r->kurir;
      $berat = $r->total_berat;

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=".$asal."&destination=".$id_kabupaten."&weight=".$berat."&courier=".$kurir."",
        CURLOPT_HTTPHEADER => array(
          "content-type: application/x-www-form-urlencoded",
          "key: 88c860b0326366b5eeef2606cf92ce9f"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {	  echo "cURL Error #:" . $err;
      } else {
        // echo $response;
      }

      $data = json_decode($response, true);
      for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
          foreach ($data['rajaongkir']['results'] as $k => $v) {
            foreach ($v['costs'] as $i => $u) {
              echo '<input class="ongkir" data-ongkos="'.$u["cost"][0]["value"].'" type="radio" value="'.$u["cost"][0]["value"].'" name="ongkir"> '.$u["service"].' Harga Rp. '.$u["cost"][0]["value"].' ('.$u["cost"][0]["value"].' Rupiah) Estimasi '.$u["cost"][0]["etd"].' Hari <br><br>';
            }

          }
      }


    }
}
