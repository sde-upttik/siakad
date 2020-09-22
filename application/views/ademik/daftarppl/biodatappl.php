<div class="box">
  <div class="box-header">
    <h3 class="box-title">biodata mahasiswa</h3>
  </div>

  <div class="box-body">

        <form action="#" method=POST>
                <tr><th style='text-align:center' colspan=2 >FORMULIR PPL</th></tr>";
              
                <tr>
                    <td class=lst>NIM</td> <td class=lst>$nim</td> <input type='hidden' name='simnim' value='$nim'>
                   </tr>

                   <tr>
                    <td class=lst>Nama Lengkap</td> <td class=lst>$nama</td>
                   </tr>

                   <tr>
                    <td class=lst>Tanggal Lahir</td> <td class=lst>
                   
                   <table>
                     <tr>
                      <td> <input type='text' id='tanggal' name='tgllahir' value='$tgllahir' readOnly></td>
                      <td> <input type='checkbox' onClick='show(7)'/> <font size=1>tandai untuk mengaktifkan</font></td>
                     </tr>
                   </table>

                   </td>
                   </tr>
                  <tr>
                    <td class=lst>Program Studi</td><td class=lst>$kdjur - $nmj</td>
                  </tr>
                  <tr>
                    <td class=lst>Program</td><td class=lst>$kdprog</td>
                  </tr>
                  <tr>
                    <td class=lst>Jenis Kelamin</td><td class=lst>$sex</td>
                  </tr>
                  <tr>
                    <td class=lst>Agama</td><td class=lst>$agama</td>
                  </tr>
                  <tr>
                    <td class=lst>Alamat di Palu</td><td class=lst>
                      <table>
                        <tr>
                          <td><input type='text' value='$alamat' name='alamat' id='s1' readonly/></td>
                          <td><input type='checkbox' onClick='show(1)' id='cb2'/> <font size=1>tandai untuk mengaktifkan</font></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td class=lst>Nomor Telp / HP</td>
                      <td class=lst>
                        <table>
                          <tr>
                            <td><input type='text' value='$phone' name='phone' id='s2' readonly/></td>
                            <td><input type='checkbox' onClick='show(2)' id='cb2'/> <font size=1>tandai untuk mengaktifkan</font></td>
                          </tr>
                        </table>
                      </td>
                  </tr>
                  <tr>
                    <td class=lst>Daerah Asal</td> 
                    <td class=lst><input type='text' name='dasal' required></td>
                  </tr>
                  <tr>
                    <td class=lst>Jumlah SKS Lulus</td>
                    <td class=lst>$totsks SKS</td>
                  </tr>
                  <tr>
                    <td class=lst>Nilai PPL I<br>(Microteaching)/Latihan Mengajar</td>
                    <td class=lst> $nilai </td>
                  </tr>
                  <tr>
                    <td class=lst>Ke Kampus <br>dengan Kendaraan</td>
                    <td class=lst><input type='text' name='kendaraan' required></td>
                  </tr>
                  <tr>
                    <td class=lst>Nama Orang Tua/Wali<br>yang dapat di hubungi</td>
                    <td class=lst>
                      <table>
                      <tr>
                        <td><label>Nama Ayah</label></td>
                        <td><input type='text' name='ayah' value='$nmayah' id='s3' readonly /></td>
                        <td><input type='checkbox' onClick='show(3)'/> <font size=1>tandai untuk mengaktifkan</font></td>
                      </tr>
                      <tr>
                        <td>
                          <label>Nama Ibu</label></td>
                            <td><input type='text' value='$nmibu' name='ibu' id='s4' readonly /></td>
                      </table>
                  <tr>
                    <td class=lst>Alamat Orang Tua/Wali<br>yang dapat di hubungi</td>
                    <td class=lst>
                      <table>
                        <tr>
                          <td><input type='text' value='$alamatot1' name='alamatot' id='s5' readonly /></td>
                          <td><input type='checkbox' onClick='show(5)'/> <font size=1>tandai untuk mengaktifkan</font></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td class=lst>No.HP Orang Tua/Wali<br>yang dapat di hubungi</td>
                    <td class=lst>
                      <table>
                        <tr>
                          <td><input type='text' value='$phoneot' name='phoneot' id='s6' readonly /></td>
                          <td><input type='checkbox' onClick='show(6)'/> <font size=1>tandai untuk mengaktifkan</font></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  
                  <tr>
                    <td class=lst colspan=2><input type=submit value='Simpan'>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class=lst colspan=2>Catatan : Jika terdapat biodata yang belum lengkap, silahkan isi terlebih dahulu. (Menu : mahasiswa --> Biodata)</td>
                  </tr>
                </form></table>";
    
  </div>
</div>

