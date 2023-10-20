<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container p-4 mx-auto">
        <div class="row d-flex justify-content-center">
            <div class="col-12 mx-auto">
                <div class="filter-area">
                    <form method="POST" action="<?= base_url('/'); ?>">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Select Area
                                    </button>
                                    <div class="dropdown-menu" id="areaDropdown">
                                        <?php foreach ($daftar_area as $area) : ?>
                                            <a class="dropdown-item">
                                                <input type="checkbox" name="selectedAreas[]" value="<?= $area->area_id; ?>">
                                                <?= $area->area_name; ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="date_start1">Select Date From</span>
                                    <input type="date" class="form-control" id="date_start" name="date_start" value=<?= $tgl_awal; ?> aria-describedby="date_start1">
                                </div>
                            </div>
                            <div class="">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="date_end1">Select Date To</span>
                                    <input type="date" class="form-control" id="date_end" name="date_end" value=<?= $tgl_akhir; ?> aria-describedby="date_end1">
                                </div>
                            </div>
                            <div class="">
                                <button class="btn btn-success" id="filterButton" type="submit">Lihat</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 mt-5">
                <div class="chart-area">
                    <canvas id="barChart" width="400" height="200"></canvas>
                </div>
            </div>
            <div class="col-12 mt-5">
                <div class="table-area">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Brand</th>
                                <?php foreach ($daftar_area as $area) : ?>
                                    <th><?= $area->area_name; ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($daftar_brand as $brand) : ?>
                                <tr>
                                    <th><?= $brand->brand_name; ?></th>
                                    <?php foreach ($hasil_perhitungan as $item) : ?>
                                        <?php if ($item['brand'] === $brand->brand_name) : ?>
                                            <td><?= number_format($item['nilai'], 0, '.', '') ?>%</td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</main>

<?= $this->endSection() ?>