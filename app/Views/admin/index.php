<?= $this->extend('template/layout') ?>

<?= $this->section('header'); ?>
<h4>Manajemen Admin User</h4>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Email</th>
                <th>Nama</th>
                <th>Groups</th>
                <th>Description</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($data as $row) : ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row->email; ?></td>
                    <td><?= $row->username; ?></td>
                    <td><?= $row->name; ?></td>
                    <td><?= $row->description; ?></td>
                    <td>
                        <a href="/admin/edit/<?= $row->id  ?>" class="btn btn-primary" id="btnEditAdmin"><i class="fa fa-edit"></i></a>
                        <a href="/admin/delete/<?= $row->id  ?>" class="btn btn-info" id="btnDeleteAdmin"><i class="fa fa-trash-alt"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



<script>


</script>


<?= $this->endSection(); ?>


<?= $this->section('footer'); ?>
<?= $this->endSection(); ?>