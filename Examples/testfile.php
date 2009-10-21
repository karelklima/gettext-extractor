<?php

echo $this->translate("I see %d little indians!", 10);

echo _("Escaping some \"fancy\" text");


// PHPFilter Nette Framework integration
$form = new Form();
$form->addText('name', 'Your name:');
$form->addSubmit('ok', 'Send')
        ->onClick[] = 'OkClicked'; // nebo 'OkClickHandler'
$form->addSubmit('cancel', 'Cancel');


?>