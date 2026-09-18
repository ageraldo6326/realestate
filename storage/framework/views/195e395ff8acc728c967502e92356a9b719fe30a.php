<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount($name, $params)->html();
} elseif ($_instance->childHasBeenRendered('he4rwCw')) {
    $componentId = $_instance->getRenderedChildComponentId('he4rwCw');
    $componentTag = $_instance->getRenderedChildComponentTagName('he4rwCw');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('he4rwCw');
} else {
    $response = \Livewire\Livewire::mount($name, $params);
    $html = $response->html();
    $_instance->logRenderedChild('he4rwCw', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\vendor\livewire\livewire\src\Testing/../views/mount-component.blade.php ENDPATH**/ ?>