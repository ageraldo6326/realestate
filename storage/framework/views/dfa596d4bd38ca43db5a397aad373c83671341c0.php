<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Select</title>
    <?php echo \Livewire\Livewire::styles(); ?>

</head>
<body>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('select')->html();
} elseif ($_instance->childHasBeenRendered('8g1QwTO')) {
    $componentId = $_instance->getRenderedChildComponentId('8g1QwTO');
    $componentTag = $_instance->getRenderedChildComponentTagName('8g1QwTO');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('8g1QwTO');
} else {
    $response = \Livewire\Livewire::mount('select');
    $html = $response->html();
    $_instance->logRenderedChild('8g1QwTO', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

    <?php echo \Livewire\Livewire::scripts(); ?>

</body>
</html><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\select.blade.php ENDPATH**/ ?>