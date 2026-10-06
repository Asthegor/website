<div>
    <br>
    <p><?= $returnprjlbl; ?>&nbsp;<a href="<?= ROOT_URL.'project/'.$viewModel['id_Project']; ?>"><?= urldecode($viewModel['Project']); ?></a></p>
    <h1><?= urldecode($viewModel['title']); ?></h1>
    <p><small><?= $datecreationlbl; ?>&nbsp;<?= $viewModel['date_creation']; ?></small></p>
    <p><?= urldecode($viewModel['description']); ?></p>
    <br>
    <p><?= $returnprjlbl; ?>&nbsp;<a href="<?= ROOT_URL.'project/'.$viewModel['id_Project']; ?>"><?= urldecode($viewModel['Project']); ?></a></p>
</div>
