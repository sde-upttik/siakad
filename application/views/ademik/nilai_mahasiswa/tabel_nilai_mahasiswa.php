        <table id="tabel_nilai" class="table table-bordered table-striped table-responsive nowrap">
          <thead>
            <tr>
              <th class="fixed-column">NIM</th>
              <th class="fixed-column">Nama Mahasiswa</th>
              <th class="fixed-column">Hadir</th>
              <th class="fixed-column">Nilai Huruf</th>
              <th class="fixed-column">Bobot</th>
              <th class="fixed-column">User Edit</th>
              <th class="fixed-column">Tanggal Edit</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data_nilai_mahasiswa as $nilai) { ?>
              <tr>
                <td><?php echo $nilai['NIM']; ?></td>
                <td><?php echo $nilai['NamaMahasiswa']; ?></td>
                <td><?php echo $nilai['Hadir']; ?></td>
                <td><?php echo $nilai['GradeNilai']; ?></td>
                <td><?php echo $nilai['Bobot']; ?></td>
                <td><?php echo $nilai['useredt']; ?></td>
                <td><?php echo $nilai['tgledt']; ?></td>
              </tr>
            <?php } ?>
          </tbody>

        </table>

<script type="text/javascript">
  $("#tabel_nilai").DataTable();
</script>