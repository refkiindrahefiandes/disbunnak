<div class="desc-container">
    <?php if (isset($result)) : ?>
    <div class="box-content-body">
        <?php if($result['dasar_hukum']) : ?>
        <div class="pelayanan-detail">
            <h3 style="border-top: none;">Dasar Hukum</h3>
            <div class="text-desc"><?php echo $result['dasar_hukum']; ?></div>
        </div>
        <?php endif; ?>

        <?php if($result['pemohon_baru']) : ?>
        <div class="pelayanan-detail">
            <h3>Permohonan Baru</h3>
            <div class="text-desc"><?php echo $result['pemohon_baru']; ?></div>
        </div>
        <?php endif; ?>

        <?php if($result['perpanjangan']) : ?>
        <div class="pelayanan-detail">
            <h3>Perpanjangan</h3>
            <div class="text-desc"><?php echo $result['perpanjangan']; ?></div>
        </div>
        <?php endif; ?>

        <?php if($result['mekanisme']) : ?>
        <div class="pelayanan-detail">
            <h3>Mekanisme</h3>
            <div class="text-desc"><?php echo $result['mekanisme']; ?></div>
        </div>
        <?php endif; ?>

        <?php if($result['lama_penyelesaian']) : ?>
        <div class="pelayanan-detail">
            <h3>Lama Penyelesaian</h3>
            <div class="text-desc"><?php echo $result['lama_penyelesaian']; ?></div>
        </div>
        <?php endif; ?>

        <?php if($result['biaya']) : ?>
        <div class="pelayanan-detail">
            <h3>Biaya</h3>
            <div class="text-desc"><?php echo $result['biaya']; ?></div>
        </div>
        <?php endif; ?>

        <?php if($result['hasil']) : ?>
        <div class="pelayanan-detail">
            <h3>Hasil Proses</h3>
            <div class="text-desc"><?php echo $result['hasil']; ?></div>
        </div>
        <?php endif; ?>

        <?php if($result['informasi_tambahan']) : ?>
        <div class="pelayanan-detail">
            <div class="text-desc"><?php echo $result['informasi_tambahan']; ?></div>
        </div>
        <?php endif; ?>

    </div>
    <?php endif; ?>
</div>
<script>
function goBack() {
    $('.desc-container').remove();
    $('#accordion').show();
}
</script>

<style>
    .box-content-body {
        padding: 20px;
    }

    .box-content-body h3 {
        margin-top: 0;
        margin-bottom: 23px;
        display: block;
        padding: 15px 0;
        border-top: 1px solid #f4f4f4;
        border-bottom: 1px solid #f4f4f4;
        font-size: 16px;
        font-weight: 600;
    }
</style>