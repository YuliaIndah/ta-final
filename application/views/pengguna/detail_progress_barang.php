<?php
foreach ($detail_progress_barang as $key => $value) {
 ?> 
   <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="item">  

          <?php
          if($value->kode_nama_progress == 1){
            ?>

            <span class="glyphicon glyphicon-ok"></span>
            <div><?php echo $value->nama_progress; ?></div>
            <p>
             <?php echo $value->komentar; ?>
            </p>

        <?php
         }else{
          ?>

            <span class="glyphicon glyphicon-remove" style="background: #FAEBD7;" ></span>
            <div><?php echo $value->nama_progress; ?></div>
            <p>
             <?php echo $value->komentar; ?>
            </p>

          <?php
         }
         ?>

       </div>
     </div>
   </div>
 </div>

<?php
}
?>

<style type="text/css">

.item {
  position: relative;
  margin-left: 30px;
  border-left: 3px dashed #F0F8FF;
  padding: 10px 40px;
}

.item > span {
  position: absolute;
  width: 40px;
  height: 40px;
  font-size: 20px;
  text-align: center;
  line-height: 40px;
  border-radius: 50%;
  left: -20px;
  top: 0;
  background: #F0F8FF;
}

.item div {
  font-size: 18px;
  font-weight: bold;  
}

.item p {
  margin-top: 35px;
}

</style>